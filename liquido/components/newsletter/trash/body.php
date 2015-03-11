<?php

$smarty->assign("trash",getTrash());
include("tpl_head.php");
$smarty->display(dirname(__FILE__)."/templates/body.tpl");
include("tpl_footer.php");

?>