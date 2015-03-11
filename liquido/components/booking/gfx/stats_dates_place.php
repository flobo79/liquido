<?
require_once("../header.inc.php");

$phpv=explode(".",phpversion());
$phpv=$phpv[0];

// Trainingsplatz Hoehe
define("TPLATZH",45);
define("CHARW",6);
define("ANTIALIAS",false);

require_once(WEBPAGE_DIR."lib/jpgraph-php".$phpv."/jpgraph.php");
require_once(WEBPAGE_DIR."lib/jpgraph-php".$phpv."/jpgraph_bar.php");

$jahr = $_GET['jahr'] ? intval($_GET['jahr']) : intval(date("Y"));
$monat = $_GET['monat'] ? intval($_GET['monat']) : intval(date("m"));

$sql="CREATE TEMPORARY TABLE ".PREFIX."monthplacedetails SELECT place_id,SUM(d.dt_capacity_max) AS plaetze FROM ".PREFIX."dates d WHERE DATE_FORMAT(d.dt_date,'%Y')='".$jahr."' AND DATE_FORMAT(d.dt_date,'%c')='".$monat."' GROUP BY place_id ORDER BY d.dt_date ASC";
$booking->sql->DB->Execute($sql);
$sql="SELECT d.place_id,CONCAT(p.pl_name,'\n',c.co_name) AS tplatz,LENGTH(p.pl_name) AS xlabellen, SUM(r.rs_places) AS genutzt, SUM(r.rs_coupon_nr) AS gutscheine, mpd.plaetze FROM ".PREFIX."monthplacedetails mpd JOIN ".PREFIX."dates d ON d.place_id=mpd.place_id LEFT JOIN ".PREFIX."reserv r ON d.date_id = r.date_id JOIN ".PREFIX."places p ON d.place_id=p.place_id JOIN ".PREFIX."countries c ON p.country_id=c.country_id WHERE DATE_FORMAT(d.dt_date,'%Y')='".$jahr."' AND DATE_FORMAT(d.dt_date,'%c')='".$monat."' GROUP BY place_id ORDER BY p.pl_name ASC";
$stats=$booking->sql->DB->GetAssoc($sql);
$booking->sql->Disconnect();

$datax_label=array();
$datay_genutzt=array();
$datay_gutscheine=array();
$datay_plaetze=array();
$xlabellen=0;

foreach($stats as $tplatzdata) {
  $datax_label[]=$tplatzdata['tplatz'];
  $datay_genutzt[]=intval($tplatzdata['genutzt']);
  $datay_gutscheine[]=intval($tplatzdata['gutscheine']);
  $datay_plaetze[]=intval($tplatzdata['plaetze']);
  $xlabellen=max($xlabellen,intval($tplatzdata['xlabellen']));
}

$graph = new Graph(900,130+count($stats)*TPLATZH,'auto');	
$graph->SetScale("textint");
$graph->Set90AndMargin(20+$xlabellen*CHARW,20,70,60);
$graph->SetFrame(true,'#AEC2C1',1); 
$graph->SetColor('#EAF2E5');
$graph->SetMarginColor('#EAF2E5');

$graph->legend->SetLayout(LEGEND_HOR);
$graph->legend->Pos(0.5,0.96,"center","bottom");

$graph->legend->SetShadow('#AEC2C1@0.5');
$graph->legend->SetFillColor('white@0.3');

$graph->yaxis->scale->SetGrace(10);

$graph->xaxis->SetTickLabels($datax_label);
$graph->xaxis->SetLabelAlign('right','center','right');
$graph->xaxis->SetFont(FF_FONT1);
$graph->xaxis->SetColor('black','black');

$graph->yaxis->SetColor('#EAF2E5','black');
$graph->ygrid->SetColor('#AEC2C1');

$gDateLocale->Set('german');
$monate = $gDateLocale->GetMonth();
$graph->title->Set('Monatsauswertung der Trainingsplätze');
$graph->subtitle->Set($monate[$monat-1].' '.$jahr);

$bplot1 = new BarPlot($datay_plaetze);
$bplot2 = new BarPlot($datay_genutzt);
$bplot3 = new BarPlot($datay_gutscheine);

$bplot1->SetFillColor('orange@0.4');
$bplot2->SetFillColor('brown@0.4');
$bplot3->SetFillColor('darkgreen@0.4');

$bplot1->SetLegend('Angebotene Tickets');
$bplot2->SetLegend('Gebuchte Tickets');
$bplot3->SetLegend('Verwendete Gutscheine');

// Zahlen ueber Balken

$bplot1->value->Show();
if(ANTIALIAS) {
  $bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,8);
} else {
  $bplot1->value->SetFont(FF_FONT0);
}
$bplot1->value->SetFormat('%d');
$bplot1->value->SetColor("black","darkred");
$bplot2->value->Show();
if(ANTIALIAS) {
  $bplot2->value->SetFont(FF_ARIAL,FS_NORMAL,8);
} else {
  $bplot2->value->SetFont(FF_FONT0);
}
$bplot2->value->SetFormat('%d');
$bplot2->value->SetColor("black","darkred");
$bplot3->value->Show();
if(ANTIALIAS) {
  $bplot3->value->SetFont(FF_ARIAL,FS_NORMAL,8);
} else {
  $bplot3->value->SetFont(FF_FONT0);
}
$bplot3->value->SetFormat('%d');
$bplot3->value->SetColor("black","darkred");


$gbarplot = new GroupBarPlot(array($bplot1,$bplot2));
$gbarplot->SetWidth(0.8);
$graph->Add($gbarplot);

$graph->Stroke();
?>
