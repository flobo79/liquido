<?php 

include ("../../lib/init.php");
include("functions.inc.php"); 

$panel_left =  dirname( __FILE__ )."/templates/panel_left.tpl";

// feed smarty
$smarty->assign("left_search_fnc","seach(this.value);return false");
$smarty->assign("searchbox",true);
$smarty->assign("groups",getGroups());
$smarty->assign("panel_left",$panel_left);
$smarty->assign("issues",getIssues($thiscomp['id']));
$smarty->assign("trashitems",($items = countTrashItems()) ? $item = ($items == "1" ? "1 Objekt" : $items." Objekte") : "leer");
$smarty->display($_SERVER['DOCUMENT_ROOT'].SKIN."/panel_left.tpl");

?>