<?php 

include("../../lib/init.php");
include("lib/functions.php");

$id = $_GET['id'];
$result = getObjectData($id);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top"> <br> 
      <?php 
		include("list_edit_".$result['mime'].".php");
	?>
    </td>
  </tr>
</table>
</body>
</html>
