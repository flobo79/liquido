<?php


include (dirname(dirname(dirname(__FILE__)))."/lib/init.php");
include (dirname(__FILE__)."/functions.inc.php");
include (dirname(__FILE__)."/".$mode."/functions.inc.php");

$data = getdata($thiscomp['id']);

include ($mode."/right.php");


?>