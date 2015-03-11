<?php
	include("lib/functions.php");
	include("../../lib/init.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../lib/css.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF">
<table width="100%" height="205" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">
	<br>
	<?php 

	if($id) {
		$mime = getObjectType($id);
		include("list_details_".$mime.".php");
	} else {
		include("list_details_start.php");
	}
	?>
	</td>
  </tr>
</table>
</body>
</html>