<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);
$side = $result['smalltext3'] == "left" ? "right" : "left";
$marginxy = "margin-".$side.": ".$result['text2'] ."px;";

$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$objecttitle = "cpis start-objekt";
$thisobject['formrows'] = "3";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "ticker";
$thisobject['textwidth'] = 130;

// optionsmenue hinzuladen
if ($part == "compose") {
	$includehtml = parseCode($result, $result['smalltext2']);
	include("$cfgcmspath/components/contents/compose/templates/object_head.php");
}
?>
<table width="215" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="2" height="8"></td>
  </tr>
  <tr>
    <td colspan="2" background="/<xcontainer>5x5rose.gif"><img src="<?php echo $result['smalltext2'] ?>" border="0" /></td>
  </tr>
  <tr> 
    <td width="<?php echo $size[0]+5; ?>" height="80" valign="top" background="/<xcontainer>5x5rose.gif"> 
    	<?php echo $pictures[0];  ?>
    </td>
    <td width=" <?php echo (215 - $size[0]) ?>" valign="top" background="/<xcontainer>5x5rose.gif" class="ticker"> 
      <?php $this->textobject($thisobject); ?>
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
        <table width="100%">
          <tr> 
            <td class="text"><table width="100%" border="0">
                <tr> 
                  <td class="text">Kopfbild: 
                    <input name="objectdata[<? echo $result['id']; ?>][smalltext2]" type="text" class="text" value="<?php echo ($result['smalltext2']); ?>" size="20"> 
                    <br>
                    Bildlink: 
                    <input name="objectdata[<? echo $result['id']; ?>][link]" type="text" class="text" value="<?php echo $result['link']; ?>" size="30">
                    Ziel: 
                    <input name="objectdata[<? echo $result['id']; ?>][smalltext1]" type="text" value="<?php echo $result['smalltext1'] ?>" size="10"></td>
                </tr>
                <tr> 
                  <td class="text"><font color="#000000"> <a href="#" onClick="openLibrary(<?php echo $result['id'] ?>,'type=picture'); return false">&raquo; 
                    Bild ausw&auml;hlen</a> 
                    <input name="imageupload" type="hidden" value="<?php echo $result['id']; ?>">
                    <input name="objectdata[<? echo $result['id']; ?>][tnwidth]" type="hidden" value="80">
                    </font> </td>
                </tr>
              </table> </td>
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