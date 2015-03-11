<?php
	// feed smarty 
	if($sendresult) $smarty->assign("sendresult",$sendresult);
	$smarty->assign("areas",getAreas()); 
	$smarty->assign("left_search_fnc","seach(this.value);return false");
	$smarty->assign("paneContent",$paneContent);
	$smarty->display($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/templates/".$cfg['env']['skin']."/rightpane.tpl");


?>