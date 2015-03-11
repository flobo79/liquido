<?php 

include("lib/functions.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>list_left</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../lib/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../js/markRows.js"></script>
<script language="JavaScript">
	selectFolder = function(id) {
		parent.col2.location.href='list.php?folderid='+id;
		top.Details.location.href='list_details.php?id='+id;
	}
</script>
<?php
	setIframeWidth($folderid,217); 
	if ($selectFolder) updateDetails($selectFolder); 
?>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" <?php echo $body ?> bgcolor="#FFFFFF">
<table width="200" height="100%" border="0" cellpadding="0" cellspacing="0" class="rl">
  <tr> 
    <td valign="top" width="199"> 
      <?php ListFolder($folderid,"name",$current); ?>
    </td>
  </tr>
</table>
</body>
</html>
