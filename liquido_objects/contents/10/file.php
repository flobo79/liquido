<?php

// contents-template
$objecttitle = "Iframe-Objekt";
$thisobject['formrows'] = "2";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "smalltext";
$thisobject['textwidth'] = $contentwidth;

// optionsmenue hinzuladen
if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

$bgcolor = $result[text2] ? $result[text2] : "#FFFFFF";
$name = $result[text3] ? $result[text3] : "iframe";

if($result[link]) echo "<iframe bgcolor=$bgcolor src=\"$result[link]\" width=\"$contentwidth\" height=\"$result[text]\" id=\"$name\" border=\"0\" frameborder=\"0\" framespacing=\"0\" name=\"$name\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" leftmargin=\"0\" topmargin=\"0\"></iframe><br>";

if ($part == "compose") { ?>
<a href="javascript:part('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<div id="option<?php echo $objectid ?>"  style="display:none">
  <table width="<?php echo $contentwidth ?>" border="0">
    <tr> 
      <td width="12" rowspan="4" class="centerline"></td>
      <td colspan="2" class="text">Link: 
        <input name="objectdata[<? echo $result[id]; ?>][link]" type="text" class="text" value="<?php echo $result[link]; ?>" size="55"></td>
    </tr>
    <tr>
      <td class="text">Bezeichnung:</td>
      <td class="text"><font color="#000000">
        <input name="objectdata[<? echo $result[id]; ?>][text3]" type="text" class="text" id="objectdata[<? echo $result[id]; ?>][text3]" value="<?php echo $result[text3] ?>">
        </font>
		</td>
    </tr>
    <tr> 
      <td width="110" class="text"><font color="#000000">H&ouml;he des Iframes: 
        <br>
        </font></td>
      <td width="186" class="text"><font color="#000000"> 
        <input name="objectdata[<? echo $result[id]; ?>][text]" type="text" class="text" id="objectdata[<? echo $result[id]; ?>][text]" value="<?php if($result[text]) { echo $result[text]; } else { echo "250"; } ?>">
        </font></td>
    </tr>
    <tr> 
      <td width="110" class="text"><font color="#000000">Hintergundfarbe: </font></td>
      <td class="text"><font color="#000000"> 
        <input name="objectdata[<? echo $result[id]; ?>][text2]" type="text" class="text" id="objectdata[<? echo $result[id]; ?>][text2]" value="<?php echo $result[text2] ?>" size="8" maxlength="7">
        (zb #EFEFEF)</font></td>
    </tr>
  </table>
</div>
<?php } ?>