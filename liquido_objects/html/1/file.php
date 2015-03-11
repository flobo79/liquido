<?php

// contents-template

$objecttitle = "HTTP-Verkn&uuml;pfung";

switch ($part) {
	case compose:
		include("$cfgcmspath/components/contents/compose/templates/object_head.php");
		
?>
<table width="<?php echo $contentwidth ?>" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr> 
    <td height="19" colspan="2"><input name="objectdata[<? echo $result[id]; ?>][text]" type="text" class="text" value="<?php echo $result['text']; ?>" size="30"> 
      <input name="objectdata[<? echo $result['id']; ?>][updatefunction]" type="hidden" value="ok"> 
      <input name="objectdata[<? echo $result['id']; ?>][type]" type="hidden" value="<?php echo $result['type']; ?>"> 
      <input name="objectdata[<? echo $result['id']; ?>][layout]" type="hidden" value="<?php echo $result['layout']; ?>"></td>
  </tr>
</table>

<a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<div id="option<?php echo $objectid ?>"  style="display:none">
<table width="<?php echo $contentwidth ?>" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr> 
    <td height="19">Link:</td>
    <td><input name="objectdata[<? echo $result['id']; ?>][link]" type="text" class="text" value="<?php echo $result['link']; ?>" size="25"></td>
  </tr>
  <tr> 
    <td width="80" height="19">Link &ouml;ffnen </td>
    <td><input name="objectdata[<? echo $result['id']; ?>][text2]" type="text" class="text" value="<?php echo $result['text2']; ?>" size="25"></td>
  </tr>
</table>
<a href="javascript:hide('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('less<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/less.gif" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>"></a>
</div>

<?php	break;
/*	case public:
?>
<table width="<?php echo $contentwidth ?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
		<a href="<?php echo $result['link']; ?>" <?php if($result['text2']) echo "target=\"$result['text2']\""; ?>><?php echo $result['text']; ?></a><br>
	</td>
  </tr>
</table>

<?php	break; */
}
?>
