<?php 

if($pos = $_GET['setinsertpos']) {
	$_SESSION['components'][$comp]['insertpos'] = $pos;
	$thiscomp = $_SESSION['components'][$comp];	
}

if(!$thiscomp['insertpos']) {
	$_SESSION['components'][$comp]['insertpos'] = "bottom";
	$thiscomp = $_SESSION['components'][$comp];
}

if($objecttype = $_GET['setobjecttype']) {
	$_SESSION['components'][$comp]['objecttype'] = $objecttype;
	$thiscomp = $_SESSION['components'][$comp];	
}

$nlobj = getdata($thiscomp['id']);
$insertpos = $thiscomp['insertpos'];


// feed smarty 
$smarty->assign("insertpos",$insertpos);
$smarty->assign("objects",listTools($thiscomp['objecttype']));
$smarty->assign("left_search_fnc","seach(this.value);return false");
$smarty->assign("paneContent",$paneContent);
$smarty->assign("rightpane",dirname(__FILE__)."/templates/rightpane.tpl");
$smarty->display($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/templates/".$cfg['env']['skin']."/rightpane.tpl");

?>