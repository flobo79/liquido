<?php 
include ("functions.inc.php");
include ($mode."/functions.inc.php");
?>
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)">
<link href="../../lib/css.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
	function save(){
		document.getElementById('save').style.display='none';
		document.getElementById('saveas').style.display='block';
		document.getElementById('input').focus();
	}
//-->
</script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="form1" method="post" action="?"><table width="182" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="gfx/compose_pane.gif"><table width="140" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> <br />
              <img src="gfx/compose_pane_title.gif"><br />
            <?php listTools($content);  ?>
            <br />
            <br />
            <img src="gfx/templates_title.gif"><br>
			<?php list_templates($content);  ?>
            <div id="save"><a href="javascript:save();">+ als Vorlage speichern</a></div>
			<div id="saveas" style="display:none"><input name="save_template" type="text" size="20" maxlength="20" id="input" class="text"></div>
			<br />
            <img src="gfx/library_title.gif"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><img src="gfx/compose_pane_bottom.gif" width="182" height="21"></td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
</body>
</html>
