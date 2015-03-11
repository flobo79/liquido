<?php

include_once ("../../lib/init.php");
include_once ("functions.inc.php");


if (!$_SESSION['components'][$comp]['current']) {
	$mode = "detail";
	$_SESSION['components'][$comp]['current'] = $mode;
	$thiscomp = $_SESSION['components'][$comp];
}

$mode = $thiscomp['current'];

include ($mode."/functions.inc.php");
include ($mode."/body.php");


?>