<?php

require_once ("../../lib/init.php");
include("functions.inc.php"); 

if(file_exists($file = dirname(__FILE__)."/".$_SESSION['components']['newsletter']['current']."/panel_right.php")) {
	include ($file);
}

// feed smarty
if($panel_right) {
	$smarty->assign("panel_right", $panel_right);
	$smarty->display($_SERVER['DOCUMENT_ROOT'].SKIN."/panel_right.tpl");
}


?>