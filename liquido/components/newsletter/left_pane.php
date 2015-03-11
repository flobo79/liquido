<?php 

include ("../../lib/init.php");
include("functions.inc.php"); 

$left_pane =  dirname( __FILE__ )."/templates/left_pane.tpl";

if(file_exists($mode."/left_pane.php")) {
	include ($mode."/left_pane.php");
}
	
// feed smarty
$smarty->assign("leftpane",$left_pane);
$smarty->assign("issues",getIssues($thiscomp['id']));
$smarty->assign("trashitems",($items = countTrashItems()) ? $item = ($items == "1" ? "1 Objekt" : $items." Objekte") : "leer");
$smarty->display($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/templates/".$cfg['env']['skin']."/leftpane.tpl");

?>