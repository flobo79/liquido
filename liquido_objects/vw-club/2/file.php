<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$objecttitle = "key-visual";
$thisobject[result] = $result;
$thisobject[part] = $part;

$object_head_right = "<div class=\"bu_add\" onclick=\"mediabrowser.open();\"></div>";

// optionsmenue hinzuladen
if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

?>
<table width="<?php echo $contentwidth ?>" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td>
		<?php $pictures[0]; ?>
	  </td>
	</tr>
</table>
<?php if ($part == "compose") { ?>
<a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a> 
<div id="option<?php echo $objectid ?>"  style="display:none"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="15" height="15" background="/liquido/gfx/x_box/coinsupg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td height="15" background="/liquido/gfx/x_box/sup.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td width="15" height="15" background="/liquido/gfx/x_box/coinsupd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
  <tr> 
    <td width="15" background="/liquido/gfx/x_box/g.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td background="/liquido/gfx/x_box/fond.gif" align="left" width="100%">
		<table width="100%" border="0">
        <tr> 
          <td class="text">Bildlink: 
            <input name="objectdata[<? echo $result[id]; ?>][link]" type="text" class="text" value="<?php echo $result[link]; ?>" size="55"></td>
        </tr>
        <tr> 
          <td class="text"><font color="#000000"> <a href="#" onClick="openLibrary(<?php echo $result[id] ?>,'type=picture'); return false">&raquo; 
            Bild ausw&auml;hlen</a> 
            <input name="imageupload" type="hidden" value="<?php echo $result[id]; ?>">
            <input name="objectdata[<? echo $result[id]; ?>][tnheight]" type="hidden" value="500">
            <input name="objectdata[<? echo $result[id]; ?>][tnwidth]" type="hidden" value="440">
            </font> </td>
        </tr>
      </table></td>
    <td width="15" background="/liquido/gfx/x_box/d.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
  <tr> 
    <td width="15" height="15" background="/liquido/gfx/x_box/coininfg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td height="15" background="/liquido/gfx/x_box/inf.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td width="15" height="15" background="/liquido/gfx/x_box/coininfd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
</table>
<a href="javascript:hide('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('less<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/less.gif" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>"></a> 
</div>
<?php } ?>