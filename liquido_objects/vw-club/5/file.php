<?php

$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$objecttitle = "koop-bild";
$thisobject['formrows'] = "3";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "smalltext";
$thisobject['textwidth'] = 130;
$thisobject['text'] = $result['text'];
$object_head_right = "<div class=\"bu_add\" onclick=\"mediabrowser.open();\"></div>";

// optionsmenue hinzuladen
if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

?>

<div class="imgbox" id="imgbox<?php echo $result['id'] ?>" style="<?php echo $marginxy ?> float:<?php echo $result['smalltext3'] ? $result['smalltext3'] : 'left'; ?>;">


<?php 
	// HACK: do not use thumbnails for koop pictures. Instead use the original image
	$pictures[0] = str_replace("thumbnail.jpg", "original.jpg", $pictures[0]);
?>


<a href="<?php echo $result['link'] ?>"><?php if($pictures[0]) {  echo $pictures[0]; } ?>	</a>

</div>


<?php if ($part == "compose") { ?>
<a href="javascript:show('option<?php echo $objectid ?>');" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<div id="option<?php echo $objectid ?>"  style="display:none"> 

 Bildlink: 
	<input name="objectdata[<? echo $result['id']; ?>][link]" type="text" class="text" value="<?php echo $result['link']; ?>" size="30">
                    Ziel: 
                    <input name="objectdata[<? echo $result['id']; ?>][smalltext1]" type="text" value="<?php echo $result['smalltext1'] ?>" size="10"> 
                    <input name="imageupload" type="hidden" value="<?php echo $result[id]; ?>"> 
                    <input name="objectdata[<? echo $result['id']; ?>][tnwidth]" id="objectdata[<? echo $result['id']; ?>][tnwidth]" type="hidden" value="180">
     <br />          
  <a href="javascript:hide('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('less<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/less.gif" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>"></a>
</div>
<?php } ?>