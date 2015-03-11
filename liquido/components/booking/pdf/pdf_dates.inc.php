<?
//define("LIB_DIR","S:/Webdesign/HtDocs/vw-fahrsicherheitstraing.de/site/libs/");
require_once(LIB_DIR."pdf/pdf_extensions.php");

$pdf = &new Cezpdf('a4','portrait');

$mainFont = COMPONENT_DIR.'pdf/fonts/Helvetica.afm';
//$mainFont = './fonts/Times-Roman.afm';
//$codeFont = LIB_DIR.'pdf/fonts/Courier.afm';
$pdf->selectFont($mainFont);

//$sql="";
//$booking->sql->DB->Close();

$pdf->ezSetCmMargins(4,2,2,2);

$size=10;

// put a line top and bottom on all the pages
$all = $pdf->openObject();
$pdf->saveState();
$pdf->ezSetY(fromTop("2cm"));
$pdf->ezText("<b>Trainingsinformationen</b>",$size+8,array('justification'=>'left'));
$pdf->ezText("\n".$date['tr_designation']." - ".$date['datum']." ".$date['uhrzeit']." - <b>".$date['pl_name']."</b>",$size,array('justification'=>'left'));
//$pdf->line(fromLeftMargin("0cm"),fromTop("0cm"),fromRightMargin("0cm"),fromTop("0cm"));
$pdf->ezSetDy(-(measure2Pt("2mm")));
$pdf->line(fromLeftMargin("0cm"),$pdf->y,fromRightMargin("0cm"),$pdf->y);
//$pdf->line(fromLeftMargin("0cm"),fromBottomMargin("25mm"),fromRightMargin("0cm"),fromBottomMargin("25mm"));
$pdf->restoreState();
$pdf->closeObject();
$pdf->addObject($all,'all');

$pdf->ezStartPageNumbers(500,28,10,'right','Seite {PAGENUM} von {TOTALPAGENUM}',1);

//$pdf->ezSetDy(-100);

$pdf->ezText("\n\nStand: ".date("d.m.Y - H:i:s")." Uhr\n\n",$size,array('justification'=>'left'));

$pdf->ezText("<u><b>Standortdetails</b></u>",$size+4,array('justification'=>'left'));
$pdf->ezText("\n<b>".$date['pl_name']."</b>
".$date['pl_street']."
".$date['pl_zipcode']." ".$date['pl_city']."\n\n",$size,array('justification'=>'left'));

$pdf->ezText("<u><b>Freigabe im Internet</b></u>",$size+4,array('justification'=>'left'));
switch($date['dt_frei']) {
	case '0':
		$date['dt_frei']="nein";
		break;
	case '1':
		$date['dt_frei']="ja";
		break;
	case '2':
		$date['dt_frei']="beschränkt";
		break;
}
$pdf->ezText("\n".$date['dt_frei']."\n\n",$size,array('justification'=>'left'));

$pdf->ezText("<u><b>Buchungsstatus</b></u>",$size+4,array('justification'=>'left'));
$pdf->ezText("\n".$date['bookedplaces']." von ".$date['dt_capacity_max']." Plätzen gebucht\n\n",$size,array('justification'=>'left'));

$pdf->ezText("<u><b>Reservierungsdetails</b></u>",$size+4,array('justification'=>'left'));

unset($data);
$pos=0;
/*
$reservierungen=array();
$reservierungen[]=array(
  'datum'=>'1.1.2000',
  'refnr'=>'05-002459',
  'kontakt'=>'Stefan Strehle
Wittener Str. 45
44789 Bochum
janette.bartscherer@de.bp.com
<u><b>Tel.:</b></u> 0234/315-3849
<u><b>Fax:</b></u> 0234/315-643849

<u><b>Firma:</b></u> Deutsche BP AG; Retail GLS',
  'places'=>'2',
  'coupons'=>'STI0042, STI0041',
  'notes'=>'...',
  'teilnehmer'=>'Stefan Strehle',
  'rv'=>'x',
  'rb'=>'x',
  'tuv'=>'x',
  'abv'=>'x',
  'abe'=>'x',
);
*/
foreach ($reservierungen as $res) {
  ++$pos;
  $kontakt=array();
  if($res['rs_company']) $kontakt[]=$res['rs_company'];
  if($res['rs_firstname'] || $res['rs_lastname']) $kontakt[]=trim($res['rs_firstname']." ".$res['rs_lastname']);
  if($res['rs_street']) $kontakt[]=$res['rs_street'];
  if($res['rs_city']) $kontakt[]=$res['rs_city'];
  if($res['rs_email']) $kontakt[]="Mail: ".$res['rs_email'];
  if($res['rs_phone']) $kontakt[]="Tel.: ".$res['rs_phone'];
  if($res['rs_fax']) $kontakt[]="Fax: ".$res['rs_fax'];
  $kontakt=implode("\n",$kontakt);
  $misc=array();
  if($res['rs_coupon']) $misc[]="<u><b>Gutscheine:</b></u>\n".$res['rs_coupon'];
  if($res['rs_remark']) $misc[]="<u><b>Bemerkungen:</b></u>\n".$res['rs_remark'];
  if($res['rs_names']) $misc[]="<u><b>Teilnehmernamen:</b></u>\n".$res['rs_names'];
  $misc=implode("\n\n",$misc);
  $data[]=array(
    'pos'=>$pos,
    'datum'=>$res['rs_date_format'],
    'refnr'=>$res['rs_book_nr'],
    'kontakt'=>$kontakt,
    'places'=>$res['rs_places'],
    'misc'=>$misc,
    'rv'=>$res['rs_calc_send'] == 1 ? 'x' : '',
    'rb'=>$res['rs_calc_paid'] == 1 ? 'x' : '',
    'tuv'=>$res['rs_participantinfos_send'] == 1 ? 'x' : '',
    'abv'=>$res['rs_announceconfirm_send'] == 1 ? 'x' : '',
    'abe'=>$res['rs_announceconfirm_recv'] == 1 ? 'x' : '',
  );
}
/*$pdf->setStrokeColor(0,0,0,1);
$pdf->setLineStyle(1);*/
$pdf->ezTable($data,array('pos'=>'Pos','datum'=>'Datum','refnr'=>'Ref.-Nr.','kontakt'=>"Kontakt",'places'=>"Plätze",'misc'=>"Sonstiges",'rv'=>"R.v.",'rb'=>"R.b.",'tuv'=>"TU v.",'abv'=>"AB v.",'abe'=>"AB e."),' ',
  array('fontSize'=>8,'xPos'=>getInnerWidth()+$pdf->ez['leftMargin']+6,'xOrientation'=>'left','width'=>getInnerWidth(),'shadeCol'=>array('0.9','0.9','0.9'),
	'cols'=>array(
		'pos'=>array('justification'=>'center'),
		'places'=>array('justification'=>'center'),
		'rv'=>array('justification'=>'center'),
		'rb'=>array('justification'=>'center'),
		'tuv'=>array('justification'=>'center'),
		'abv'=>array('justification'=>'center'),
		'abe'=>array('justification'=>'center'),
		'misc'=>array('width'=>measure2Pt("3cm")),
	)));

$pdf->ezStream();
?>
