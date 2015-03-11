<?
require_once("../header.inc.php");

$phpv=explode(".",phpversion());
$phpv=$phpv[0];

define("ANTIALIAS",false);

require_once(WEBPAGE_DIR."lib/jpgraph-php".$phpv."/jpgraph.php");
require_once(WEBPAGE_DIR."lib/jpgraph-php".$phpv."/jpgraph_bar.php");

$jahr = $_GET['jahr'] ? intval($_GET['jahr']) : intval(date("Y"));

$sql="CREATE TEMPORARY TABLE ".PREFIX."monthplaces SELECT DATE_FORMAT(d.dt_date,'%c') AS monat,SUM(d.dt_capacity_max) AS plaetze FROM ".PREFIX."dates d WHERE DATE_FORMAT(d.dt_date,'%Y')='".$jahr."' GROUP BY monat ORDER BY d.dt_date ASC";
$booking->sql->DB->Execute($sql);
$sql="SELECT p.monat, SUM(r.rs_places) AS genutzt, SUM(r.rs_coupon_nr) AS gutscheine, p.plaetze FROM ".PREFIX."dates d JOIN ".PREFIX."reserv r ON d.date_id = r.date_id JOIN ".PREFIX."monthplaces p ON DATE_FORMAT(d.dt_date,'%c')=p.monat WHERE DATE_FORMAT(d.dt_date,'%Y')='".$jahr."' GROUP BY monat ORDER BY d.dt_date ASC";
$stats=$booking->sql->DB->GetAssoc($sql);
$booking->sql->Disconnect();

$datay_genutzt=array();
$datay_gutscheine=array();
$datay_plaetze=array();

for($i=1;$i<=12;$i++) {
  $datay_genutzt[$i-1]=array_key_exists($i,$stats) ? intval($stats[$i]['genutzt']) : 0;
  $datay_gutscheine[$i-1]=array_key_exists($i,$stats) ? intval($stats[$i]['gutscheine']) : 0;
  $datay_plaetze[$i-1]=array_key_exists($i,$stats) ? intval($stats[$i]['plaetze']) : 0;
  //$datay_frei[$i-1]=array_key_exists($i,$stats) ? intval($stats[$i]['plaetze'])-intval($stats[$i]['genutzt']) : 0;
}

$graph = new Graph(900,400,'auto');	
$graph->img->SetMargin(40,20,40,70);
$graph->SetScale("textint");
$graph->SetFrame(true,'#AEC2C1',1); 
$graph->SetColor('#EAF2E5');
$graph->SetMarginColor('#EAF2E5');

$graph->legend->SetLayout(LEGEND_HOR);
$graph->legend->Pos(0.5,0.96,"center","bottom");

$graph->legend->SetShadow('#AEC2C1@0.5');
$graph->legend->SetFillColor('white@0.3');

$graph->yaxis->scale->SetGrace(10);

$gDateLocale->Set('german');
$a = $gDateLocale->GetShortMonth();
$graph->xaxis->SetTickLabels($a);
$graph->xaxis->SetFont(FF_FONT1);
$graph->xaxis->SetColor('black','black');

$graph->yaxis->SetColor('#EAF2E5','black');
$graph->ygrid->SetColor('#AEC2C1');

$graph->title->Set('Gesamtauswertung');
$graph->subtitle->Set('Jahr '.$jahr);

$bplot1 = new BarPlot($datay_plaetze);
$bplot2 = new BarPlot($datay_genutzt);
// $bplot3 = new BarPlot($datay_gutscheine);

$bplot1->SetFillColor('orange@0.4');
$bplot2->SetFillColor('brown@0.4');
// $bplot3->SetFillColor('darkgreen@0.4');

$bplot1->SetLegend('Angebotene Tickets');
$bplot2->SetLegend('Gebuchte Tickets');
// $bplot3->SetLegend('Verwendete Gutscheine2');

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
// $bplot3->value->Show();
// if(ANTIALIAS) {
//   $bplot3->value->SetFont(FF_ARIAL,FS_NORMAL,8);
// } else {
//   $bplot3->value->SetFont(FF_FONT0);
// }
// $bplot3->value->SetFormat('%d');
// $bplot3->value->SetColor("black","darkred");

//$ab2plot = new AccBarPlot(array($bplot2,$bplot3));

$gbarplot = new GroupBarPlot(array($bplot1,$bplot2));
//$gbarplot = new GroupBarPlot(array($bplot1,$bplot2,$bplot3));
$gbarplot->SetWidth(0.8);
$graph->Add($gbarplot);

$graph->Stroke();
?>
