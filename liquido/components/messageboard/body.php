<?php
session_start();

include("../../lib/init.php");
include ("functions.inc.php");

if(!$mode) {
	$mode = "box";
	$_SESSION['components'][$comp]['current'] = $mode;
}

if($_GET['setmode']) $_SESSION['components'][$comp]['action'] = "";

if($delete) {
	delMessage($delete);
}

if($_GET['answer']) {
	$_SESSION['components'][$comp]['action'] = "answer";
	$_SESSION['components'][$comp]['current'] = "write";
	$mode = "write";
}

if($_GET['forward']) {
	$_SESSION['components'][$comp]['action'] = "forward";
	$_SESSION['components'][$comp]['current'] = "write";
	$mode = "write";
}


include ($mode."/body.php");
session_write_close();

?>