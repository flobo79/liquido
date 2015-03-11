<?php

// contents-template

$objecttitle = "Anker-Verknüpfung";

switch ($part) {
	case "compose":
		include("$cfgcmspath/components/contents/compose/templates/object_head.php");
?>
<table width="<?php echo $contentwidth ?>" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="19"><img src="../../components/contents/gfx/anchorlink.gif" width="17" height="21">
		<input name="objectdata[<? echo $result['id']; ?>][link]" type="text" class="text" value="<?php echo $result['text']; ?>" size="30">
      <input name="objectdata[<? echo $result['id']; ?>][type]" type="hidden" value="<?php echo $result['type']; ?>"> 
      <input name="objectdata[<? echo $result['id']; ?>][layout]" type="hidden" value="<?php echo $result['layout']; ?>"></td>
  </tr>
</table>

<a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','../../components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<div id="option<?php echo $objectid ?>"  style="display:none">
  <table width="<?php echo $contentwidth ?>" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="12" class="centerline">&nbsp;</td>
      <td width="70">Zielanker:</td>
      <td><input name="objectdata[<? echo $result['id']; ?>][link]" type="text" class="text" value="<?php echo $result['link']; ?>" size="30"></td>
    </tr>
  </table>
<a href="javascript:hide('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('less<?php echo $objectid ?>','','../../components/contents/gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../components/contents/gfx/less.gif" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>"></a>
</div>

<?php	break;
	case "public":
?>
<table width="<?php echo $contentwidth ?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
		<a href="#<?php echo $result['link']; ?>"><?php echo $result['text']; ?></a><br>
	</td>
  </tr>
</table>
<?php	break;
}
?>
