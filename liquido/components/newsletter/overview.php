<?php

	$smarty->assign("stati",array("in Bearbeitung","Redaktionsschluss","Redaktion freigegeben", "Versand freigegeben","versendet"));
	$smarty->assign("status",	array("unveröffentlicht","aktuell","versendet"));
	$smarty->assign("redactions",getIssues($thiscomp['id']));
	$smarty->assign("access",$access);
	
	$smarty->display(dirname(__FILE__)."/templates/overview.tpl");
	
?>