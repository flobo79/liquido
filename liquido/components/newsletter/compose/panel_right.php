<?php 

include(dirname(__FILE__)."/functions.inc.php");

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
$panel_right = dirname(__FILE__)."/templates/panel_right.tpl";

$smarty->assign("nlobj",$nlobj);
$smarty->assign("insertpos",$insertpos);
$smarty->assign("objects",listTools($thiscomp['objecttype']));

?>