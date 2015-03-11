<?php 
include ("../../../lib/init.php");
include("functions.inc.php"); 
include("../../../lib/fnc_frontend.inc.php");

	
// listeneinstellungen 
if($_GET['list']) $list = $_GET['list'];
if($_POST['search']) $list['search'] = urldecode($_POST['search']);

if(!$list['order']) $list['order'] = "id";
$list['coltitles'] = "art_nr,image,art_title,art_price,art_descr";
$list['searchcols'] = "*";
//$list['viewcols'] = "art_nr,#image,art_title,art_price,#short";
$list['float'] = "left,left,left,left,left";
$list['colwidths'] ="50,35,130,80,";
$list['table'] = "fs_liquido_nl_abos";
$list['rowlink'] = "onclick=\"details('art_id')\"";
$list['tablewidth'] = "700px";

// listencallbackfunktionen
function image($row) {
	global $class_shop;
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$class_shop->settings['picdir']."/".$row['art_id']."s.jpg")) {
		return "<img src=\"".$class_shop->settings['picdir']."/".$row['art_id']."s.jpg\" alt=\"$row[art_nr]\" width=\"30\" />";
	}
}

function short($row) {
	return trimfilename($row['art_descr'],60);
}

$mylist = $TEMPLATE->drawlist($list);
//$labels =  $class_shop->getLabels();


session_write_close();
?>
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php if($cfg['visual']['pagefade'] == 1) { ?><meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)"><?php } ?>
<link href="../../lib/css.css" rel="stylesheet" type="text/css">

</head>



<body>

</body>
</html>
