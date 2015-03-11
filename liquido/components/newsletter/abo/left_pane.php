<?php

$left_pane =  dirname( __FILE__ )."/templates/left_pane.tpl";
$smarty->assign("left_search_fnc","seach(this.value);return false");
$smarty->assign("searchbox",true);
$smarty->assign("groups",getGroups());

?>