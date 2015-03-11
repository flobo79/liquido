<?php

	include("lib/functions.php");
	$data = userData($id);


?>
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../lib/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF">
<table width="404" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="headline">Rechte festlegen f&uuml;r Gruppe <?php echo $data['name'] ?></td>
  </tr>
</table>
<form name="form1" method="post" action="">
  <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php listRights($id,$component); ?></td>
  </tr>
</table>

  <input name="comp" type="hidden" id="comp" value="<?php echo $component ?>">
  <input name="group" type="hidden" value="<?php echo $id ?>">
  <input name="r[x]" type="hidden" id="r[x]" value="foo">
</form>
<p>&nbsp;</p>
</body>
</html>
