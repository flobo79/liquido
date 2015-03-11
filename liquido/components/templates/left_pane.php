<?php 
include ("../../lib/init.php");
include("functions.inc.php");

?>
<html>
<head>
<title>liquio template left pane</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">

<?php 
	if ($cfg_templatefallback) $add = "&setmode=detail";
?>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
<br>
<table width="165" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="162"><img src="gfx/left_pane_top.gif" width="165" height="21"></td>
  </tr>
  <tr>
    <td valign="top" background="gfx/left_pane_content.gif"> <img src="gfx/content_pane_title.gif" width="134" height="12"> 
      <table width="160" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10"><img src="../../gfx/spacer.gif" width="10" height="1"></td>
          <td width="149"> 
            <?php contents_tree($temp[id]);  ?>
            <p><a href="body.php?file=new_template&setmode=detail" target="middle">+ 
              Vorlage erstellen</a><br>
              <br>
              <br>
              <img src="gfx/content_pane_globals.gif" width="119" height="12" border="0"><br>
              <a href="body.php?setmode=container&select[id]=9999" target="middle"><img src="gfx/container_tn.gif" border="0"> 
              Container</a><br>
              <a href="body.php?setmode=classes&select[id]=9999" target="middle"><img src="gfx/class_tn.gif" border="0"> 
              Klassen</a><br>
              <a href="body.php?setmode=snippets&select[id]=9999" target="middle"><img src="gfx/template_tn.gif" width="14" height="15" border="0"> 
              Snippets</a><br>
              <br>
            </p></td>
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
