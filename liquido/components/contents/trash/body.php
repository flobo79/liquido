<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
	<!--
	 function recycle() {
		document.form1.type.value = 'rec';
		document.form1.submit();
	 }
	 
	 function del() {
		document.form1.type.value = 'del';
		document.form1.submit();
	 }
	 
	 <?php  
		if($_GET['update_rightframe'] and $access['c10']) echo "parent.right.location.href = 'right.php?mode=$mode'";
		if($_GET['update_leftframe']) echo "parent.left.location.href = 'left_pane.php?noupdate=1'";
	?>	
	//-->
</script>

</head>
<body>
<form name="form1" method="post" action="body.php"><br />

  <table width="320" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="60"><img src="../../gfx/trashcan_big.gif" width="44" height="48"></td>
      <td width="260" class="headline"><br>
        Gel&ouml;schte Objekte</td>
    </tr>
  </table>
  <br>
  <table width="320" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="71" align="center" valign="middle"><img src="gfx/group.gif" width="32" height="34"></td>
      <td width="249"> Seiten </td>
    </tr>
    <tr> 
      <td width="71" align="center" valign="middle">&nbsp;</td>
      <td width="249">
        <?php list_trash($content, "contents"); ?>
      </td>
    </tr>
  </table>
  
  <!--
  <br>
  <table width="321" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="71" align="center" valign="middle"><img src="gfx/template.gif" width="32" height="34"></td>
      <td width="250"> Vorlagen</td>
    </tr>
    <tr> 
      <td width="71" align="center" valign="middle">&nbsp;</td>
      <td width="250">
        <?php list_trash($content,"templates"); ?>
      </td>
    </tr>
  </table>
  -->
  <br>
  <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="71" align="center" valign="middle"><img src="gfx/object.gif" width="32" height="20"></td>
      <td width="250"> Objekte</td>
    </tr>
    <tr> 
      <td width="71" align="center" valign="middle">&nbsp;</td>
      <td width="450">
        <?php list_trash($content, "objects"); ?>
      </td>
    </tr>
  </table>
  <br>
  <table width="321" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="71" align="center" valign="middle">&nbsp;</td>
      <td width="250">&nbsp; </td>
    </tr>
    <tr> 
      <td width="71" align="center" valign="middle">&nbsp;</td>
      <td width="250"> <a href="javascript:recycle();">wiederherstellen</a>&nbsp;&nbsp;&nbsp; 
        <a href="#" onClick="javascript:del();">l&ouml;schen</a>
        <input name="type" type="hidden" id="type"></td>
    </tr>
  </table>
  </form>
</body>
</html>
