<?php 
include("../../lib/init.php"); 
include("functions.php"); 
?>
<html>
<head>
<title>cms-pro template left pane</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">

<?php 

// cpmose-fallback
if ($cfg_templatefallback) $add = "&setmode=detail";

if($select[id]) {
echo "<script type=\"text/javascript\">
		<!--
		 parent.middle.location.href = 'body.php?select[id]=".$select[id].$add."';
		//-->
</script>";
}
?>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
<br>
<table width="165" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="162"><img src="gfx/left_pane_top.gif" width="165" height="21"></td>
  </tr>
  <tr>
    <td valign="top" background="gfx/left_pane_content.gif"> 
      <table width="160" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10"><img src="../../gfx/spacer.gif" width="10" height="1"></td>
          <td width="149">eigene Einstellungen<br>
            <br>
            Administration <br>
          </td>
        </tr>
      </table> 
     </td>
  </tr>
  <tr>
    <td><img src="gfx/left_pane_bottom.gif" width="165" height="31"></td>
  </tr>
</table>
</body>
</html>
