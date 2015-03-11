<?php 
	require_once("../../lib/init.php");
	require_once("lib/functions.php");
	
	$id = $_GET['id'];
	$result = getObjectData(intval($_GET['id'])); 
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
</head>

<body>
<br />

   <?php 

		include("list_delete_".$result['mime'].".php");
	?>
</body>
</html>
