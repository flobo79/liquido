<?php

// contents-template
$objecttitle = "Slideshow";

require_once($_SERVER['DOCUMENT_ROOT'].LIQUIDO.'/modules/slideshow/slideshow.php');
$ss = new Slideshow($result);
$folder = $ss->getData ();
if(!$result['text2']) $result['text2'] = 5;
if($part == "compose") include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");


if($part == "compose") { ?>
<div style="padding: 5px; height: 100px; line-height: 20px; background-color:#EFEFEF;">
	<div id="<?php echo $result['id'] ?>_settings" <?php if(!isset($folder)) echo 'style="display:none;"'; ?>>
		<input type="hidden" name="objectdata[<?php echo $result[id]; ?>][text]" value="slideshow" />
		Ausgewählter Galerie Ordner: <span class="gal_name"><?php if(isset($folder)) echo $folder['name']; ?></span>&nbsp; <input type="button" onclick="slideshow<?php echo $result['id'] ?>.openGallerybrowser()" value="Galerie Ordner auswählen" /><br />
		Galery-Link: <b>javascript:slideshow<?php echo $result['id'] ?>.openGallery();</b><br />
		Interval für Bilderwechsel: <input maxlength="3" style="width:40px;" type="text" name="objectdata[<?php echo $result[id]; ?>][text2]" value="<?php echo $result[text2]; ?>" /> Sekunden<br>
		Zeige <input type="text" onchange="slideshow<?php echo $result['id'] ?>.updateThumblist(this.value);" name="objectdata[<?php echo $result[id]; ?>][text3]" value="<?php echo $result[text3]; ?>" maxlength="3" style="width:40px;" /> Thumbnails auf der Webseite (leeres Feld - alle Thumbnails)<br>
		<input type="hidden" name="objectdata[<?php echo $result[id]; ?>][smalltext3]" value="2" />
		<input type="checkbox" name="objectdata[<?php echo $result[id]; ?>][smalltext3]" value="1" <?php if($result['smalltext3'] == "1") echo "checked"; ?> /> Autostart
	</div>
</div>
<?php } ?>

<div id="ss_list_<?php echo $result['id'] ?>" class="page_list" style="display:none;">
	<?php $ss->display(); ?>
	<div style="clear:both;"></div>
</div>

<script type="text/javascript">
	var slideshow<?php echo $result['id'] ?> = false;
	
	document.addEvent('domready', function() {
		if (typeof Slideshow == 'undefined') {
			
			Asset.css('/liquido/modules/slideshow/slideshow.css', { id: 'ss_css' });
			Asset.javascript('/liquido/modules/slideshow/slideshow.js?v=6', { id: 'ss_js', onload:function() {
				slideshow<?php echo $result['id'] ?> = new Slideshow({
					id:<?php echo $result['id']; ?>,
					gallery:'<?php echo $result['smalltext1']; ?>',
					delay:'<?php echo $result['text2']*1000; ?>',
					autostart:<?php echo $result['smalltext3'] == "1" ? "true" : "false"; ?>
				});
			}});
		} else {
			slideshow<?php echo $result['id'] ?> = new Slideshow({
				id:<?php echo $result['id']; ?>,
				gallery:'<?php echo $result['smalltext1']; ?>',
				delay:'<?php echo $result['text2']*1000; ?>',
				autostart:<?php echo $result['smalltext3'] == "1" ? "true" : "false"; ?>
			});
		}
	});
</script>