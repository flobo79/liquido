<?php
	require_once("../../lib/init.php");
	require_once("lib/functions.php");
	if(isset($_GET['id'])) $id = $_GET['id'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>liquido</title>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../../js/mootools.js"></script>
	<script type="text/javascript" src="../../js/liquido.js"></script>
</head>

<body>
	<br>
	<?php 

	if(isset($_GET['id']) || $result['mime']) {
		$result = getObjectData($_GET['id']);
		
		include(dirname(__FILE__)."/list_details_".$result['mime'].".php");
	} else {
		include(dirname(__FILE__)."/list_details_start.php");
	}
	?>
</body>
</html>