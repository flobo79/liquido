<?php


include (dirname(dirname(dirname(__FILE__)))."/lib/init.php");
include (dirname(__FILE__)."/functions.inc.php");
include (dirname(__FILE__)."/".$mode."/functions.inc.php");

if(!$auth) { header('location:?logout=1'); }
include ($mode."/body.php");


?>