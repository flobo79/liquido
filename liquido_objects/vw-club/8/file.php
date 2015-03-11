<?php


$pictures = $this->listpictures($result['id'], $part);
$side = $result['smalltext3'] == "left" ? "right" : "left";
$marginxy = "margin-".$side.": ".$result['text2'] ."px;";

$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$objecttitle = "Händlerinfo mit Logo";
$thisobject['formrows'] = "5";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "text";
$thisobject['textwidth'] = $contentwidth - $size[0] - $result['text2'];

$kis = $_SESSION['kis'];
$myPartner = $kis->myDealer[0];

if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

?><table width="<?php echo $contentwidth ?>" border="0" cellpadding="0" cellspacing="0">
	<tr> 
	  <td valign="top" class="text"> 
		<table width="<?php echo ( - $result['text2']) ?>" border="0" cellspacing="0" cellpadding="0" align="left">
		  <tr> 
			<td width="<?php echo $size[0] ?>"> 
				<?php echo $pictures[0];  ?>
		
			 </td>
			<td width="<?php echo $result['text2'] ?>"></td>
		  </tr>
		</table>
	<br/><?php echo $myPartner->name."<br />
				".$myPartner->street." ".$myPartner->houseNumber."<br />
				".$myPartner->zip." ".$myPartner->city."<br />
				<a href=\"mailto:".$myPartner->email."\">".$myPartner->email."</a><br />
				<a href=\"".$myPartner->webSite."\" target=\"_blank\">".$myPartner->webSite."</a>";

 		?>
	  </td>
	</tr>
  </table>
<?php if($part == "compose") { ?>
<a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
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
                  <td align="right" class="text"> <font color="#000000"><a href="#" onClick="openLibrary(<?php echo $result['id'] ?>,'type=picture'); return false">&raquo; 
                    Bild auswählen</a> (Änderungen vorher speichern)</font> 
                    <br>
                    Bildlink: 
                    <input name="objectdata[<?php echo $result['id']; ?>][link]" type="text" class="text" value="<?php echo $result['link']; ?>" size="30"> 
                    <br>
                    Ziel: 
                    <input name="objectdata[<?php echo $result['id']; ?>][smalltext1]" type="text" value="<?php echo $result['smalltext1'] ?>" size="10">
                    Bildbreite: 
                    <input name="objectdata[<?php echo $result['id']; ?>][tnwidth]" type="text" id="objectdata[<?php echo $result['id']; ?>][tnwidth]" value="<?php if(!$size[0]) { echo $cfg_def_picwidth; } else { echo $size[0]; }  ?>" size="3" maxlength="3">
                    Textabstand: 
                    <input name="objectdata[<?php echo $result['id']; ?>][text2]" type="text" id="objectdata[<?php echo $result['id']; ?>][text2]" value="<?php if(!$result['text2']) { echo "5"; } else { echo $result['text2']; } ?>" size="3" maxlength="3"> 
                    <input name="imageupload" type="hidden" id="imageupload" value="<?php echo $result['id']; ?>"> 
                  </td>
                </tr>
        	</table>
		</td>
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