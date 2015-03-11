<?php

	include("../../../lib/init.php");
	
	
	// globals 
	foreach($_GET as $K => $V) { $$K = $V;}
	foreach($_POST as $K => $V) { $$K = $V; }
	unset($K,$V);
	
	include("../functions.inc.php");
	include_once("functions.php");
	
	$temp = $_SESSION['components'][$comp]['temp'];
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>templates</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script language="JavaScript" type="text/JavaScript" src="../../../js/mootools.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../../../js/utils.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../functions.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="<?php echo LIQUIDO ?>/js/liquido.js"></script>
	<link href="../../../css/liquido.css" rel="stylesheet" type="text/css">



</head>
<body bgcolor="#FFFFFF">
<?php
	if($_GET['file']) {
		include($file.".php");
	} else {
		if($temp) {
			$data = getData($temp);
			
			include("template.php");
		} else {
			include("overview.php");
		}
	}
	
?>

</body>
</html>