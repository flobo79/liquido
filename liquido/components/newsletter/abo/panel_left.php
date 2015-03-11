<?php

$panel_left =  dirname( __FILE__ )."/templates/panel_left.tpl";
$smarty->assign("left_search_fnc","seach(this.value);return false");
$smarty->assign("searchbox",true);
$smarty->assign("groups",getGroups());

?>