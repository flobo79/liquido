<?php if($feem == "start") {
	session_start();
	$part = "compose";
	session_register("start");
	$closewindow=1;
}
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="lib/css.css" rel="stylesheet" type="text/css">
<?php if($closewindow) { ?>
<script language="JavaScript">
<!--
	function selectMode() {
		opener.window.reload();
		window.close();
	}
-->
</script>
<?php } ?>
</head>

<body <?php if ($closewindow) echo "onLoad='selectMod();'"; ?>>
<table width="180" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center"><p>In den FrontEnd-Editier-Modus wechseln?</p>
      <p><a href="#" onClick="self.location.href='?feem=start'"><img src="gfx/ok.gif" width="35" height="16" border="0"></a></p>
      </td>
  </tr>
</table>
</body>
</html>
