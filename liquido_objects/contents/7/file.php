<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$objecttitle = "Bild-Objekt";
$object_head_right = "<div class=\"bu_add\" onclick=\"mediabrowser.open();\"></div>";

// optionsmenue hinzuladen
if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");


// nasty quick hack
if($result['contents_css'] == 'kv') $result['smalltext3'] = 'none';

?>


<div class="object <?php echo $result['contents_css']; ?>" style="width:100%;" >
	<div class="imgbox" id="imgbox<?php echo $result['id'] ?>" style="<?php echo $marginxy ?> float:<?php echo $result['smalltext3'] ?>;">
		<?php if($pictures[0]) {  echo $pictures[0]; } ?>
	</div>
</div>
<?php if ($part == "compose") { ?>
Stil: <?php echo $mystyles; ?>
<?php } ?>