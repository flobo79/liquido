<?php

	//include ("../../lib/parser.php");
	include("preview/functions.inc.php");
	
	
	$panel_right = dirname(__FILE__)."/templates/panel_right.tpl";

	// feed smarty
	if($sendresult) $smarty->assign("sendresult",$sendresult);
	$smarty->assign("areas",getAreas());

?>