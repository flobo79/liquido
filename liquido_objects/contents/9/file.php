<?php

$objecttitle = "Objekt einbinden";
$thisobject['formrows'] = "1";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "text";
$thisobject['textwidth'] = $contentwidth;

if($part == "compose") include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");

if($result['link'] and file_exists(realpath($_SERVER['DOCUMENT_ROOT'].$result['link']))) {  include($_SERVER['DOCUMENT_ROOT'].$result['link']); } ?>

<?php if($part == "compose") { ?>
<a href="javascript:part('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo LIQUIDO ?>/components/contents/gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore()"><img src="<?php echo LIQUIDO ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<div id="option<?php echo $objectid ?>" style="display:none"> 
	Dateiname: 
	<input name="objectdata[<? echo $result['id']; ?>][link]" type="text" class="text" id="objectdata[text]" value="<?php echo $result['link']; ?>" size="30">
  <br>
  Info: Dateiname ausgehend der root-ebene und http-links mit http:// </div>

<?php } ?>
