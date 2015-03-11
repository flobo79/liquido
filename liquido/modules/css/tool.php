<?php
session_start();
if(!$_SESSION['contor']) { ?>
<script language="JavaScript"> window.close()</script>
<?php 
	exit();
}

$settings = $_SESSION['contor']['settings'];
$path = $_SERVER['DOCUMENT_ROOT']."/".$settings['contorpath'];
$page = "tool.php";

include($path."lib/fnc_mysql.inc.php");
include($path."lib/class_auth.php");
include("functions.inc.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Contor-CSS-editor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../lib/contor.js"></script>
<link href="../../css/contor.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#left {
		float:left;
		width: 100px;
	}
	#body {
		margin-left:15px;
		float:left;
		width:370px;
	}
</style>

</head>

<body onload="focus();">
<div id="options_right">
	<?php include("rightside.php"); ?>
</div>

<div id="body">
	<?php include("index.php"); ?>
</div>


</body>
</html>
