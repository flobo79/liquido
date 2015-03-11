<?php 

include (dirname(dirname(dirname(__FILE__)))."/lib/init.php");
include (dirname(__FILE__)."/functions.inc.php");
include (dirname(__FILE__)."/".$mode."/functions.inc.php");



$data = getdata($thiscomp['id']);

?>
<html>
<head>
<title>LIQUIDO</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo LIQUIDO ?>/css/liquido.css" rel="stylesheet" type="text/css" />
<link href="/liquido/templates/blue/styles.css" rel="stylesheet" type="text/css">


<?php 
// cpmose-fallback
if ($cfg_composefallback) $add = "&setmode=detail";

?>
<script type="text/javascript">
<?php

	if($update_rightframe) {
		?>
		parent.middle.location.href='body.php';
		<?php
	}
	
?>
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF" class="blue_bg">
<div id="leftpane_content_box" style="top: 0px;">
	<div id="leftpane_content">

<br>
<!--<table width="165" border="0" cellspacing="0" cellpadding="0">-->
<table border="0" cellspacing="0" cellpadding="0">
<!--
  <tr>
    <td width="162"><img src="gfx/left_pane_top.gif" width="165" height="21"></td>
  </tr>
-->
  <tr>
<!--    <td valign="top" background="gfx/left_pane_content.gif"> <a href="body.php?setmode=detail&overview=1" target="middle"><img src="gfx/content_pane_title.gif" width="134" height="12" border="0"></a> -->
    <td valign="top"> <a href="body.php?setmode=detail&overview=1" target="middle"><img src="gfx/content_pane_title.gif" width="134" height="12" border="0"></a>
<!--      <table width="160" border="0" cellspacing="0" cellpadding="0">-->
      <table border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>&nbsp;</td>
          <td> 
            <?php contents_tree($thiscomp['id']);  ?>

            <br>
            <a href="?refreshall=true"><img src="gfx/zahnradsm.gif" border="0"> 
            alle Änderungen publizieren </a><br>
            <br>
            <br>
			<form name="form1" method="get" action="">
              Gehe zu ID: 
              <input name="select[id]" type="text" id="select[id]" size="5" maxlength="5">
            </form><br><br>
          </td>
        </tr>
        <tr> 
          <td colspan="2"><img src="gfx/content_pane_trash.gif" width="134" height="12" border="0"></td>
        </tr>
        <tr> 
          <td width="10"><img src="../../gfx/spacer.gif" width="10" height="8"></td>
<!--          <td width="149"> -->
		<td width="139">
<!--            <table width="150" border="0" cellspacing="0" cellpadding="0">-->
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
			  <?php $items = countTrashItems() ?>
                <td width="21" height="30"><a href="body.php?setmode=trash" target="middle"><img src="../../gfx/trashcan<?php echo $items > 0 ? "_full" : "" ?>.gif" border="0"></a></td>
                <td width="129"><a href="body.php?setmode=trash" target="middle"> 
                  <?php echo $items>0 ? $item = ($items == "1" ? "1 Objekt" : $items." Objekte") : "leer"; ?></a> 
                </td>
              </tr>
            </table></td>
        </tr>
      </table> 
     </td>
  </tr>
  <!--
  <tr>
    <td><img src="gfx/left_pane_bottom.gif" width="165" height="31"></td>
  </tr>
  -->
</table>


</div>
</div>

</body>
</html>
