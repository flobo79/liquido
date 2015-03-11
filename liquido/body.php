<?php

$basedir = dirname(__FILE__);
$auth_noredirect = true;
include($basedir."/lib/init.php");



if(!$auth) {
	session_destroy();
	include(dirname(__FILE__)."/login.php");
} else {
	$current = $_SESSION['current'];
	include($basedir."/components/".$current['comp']."/index.php");
}



?>