<?php
include("lib/functions.php");


$closewindow = select($selectimg);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>select image</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
<!-- 
	function closeWindow() {
		opener.document.forms['page'].submit();
		window.close();
	}
-->
</script>

</head>
<body <?php if ($closewindow) echo 'onload="closeWindow();"'; ?>>
<p>es ist ein Fehler aufgetreten</p>
</body>
</html>
