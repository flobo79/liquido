<?php
foreach($_GET as $k => $v) { $$k = $v; }
foreach($_POST as $k => $v) { $$k = $v; }

include ("../../lib/init.php");
include ("functions.inc.php");

$access = loadAccessTable($user,"templates");
$load = $_SESSION['components']['templates']['temp'] ? $_SESSION['components']['templates']['current'] : 'detail';
header("Location:".$load."/body.php?".$_SERVER['QUERY_STRING']);

?>