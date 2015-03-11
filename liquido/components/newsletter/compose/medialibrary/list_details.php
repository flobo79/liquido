<?php
	
	include("../../../../lib/init.php");
	include("lib/functions.php");
	
	if($_GET['id']) $id = intval($_GET['id']);
	if($_GET['searchid']) $id = intval($_GET['searchid']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>details_folder</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../lib/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="ru">
  <tr>
    <td valign="top">
    <?php 

		if($id) {
			$mime = getObjectType($id);
			$template = $mime ? $mime : "notfound";
			include("list_details_".$template.".php");
		} else {
			include("list_details_start.php");
		}
	?>
    </td>
  </tr>
</table>
</body>
</html>