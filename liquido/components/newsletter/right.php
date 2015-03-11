<?php

	include ("../../lib/init.php");
	//include ("../../lib/parser.php");
	//include ("functions.inc.php");
	if (!$mode) {
		$mode = "detail";
		$_SESSION['components'][$comp]['current'] = $mode;
	}
	
	//include ($mode."/functions.inc.php");
	include ($mode."/right.php");
	session_write_close();

?>