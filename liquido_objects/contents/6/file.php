<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$side = $result['smalltext3'] == "left" ? "right" : "left";
$marginxy = "margin-".$side.": ".$result['text2'] ."px;";

$objecttitle = "Textblock";
$thisobject['formrows'] = "5";
$thisobject['id'] = "text".$result['id'];
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = $result['contents_css'];
$thisobject['textwidth'] = $insert ? '100%' : $contentwidth - $size[0] - $result['text2']-5;
$thisobject['smalltext3']  = $thisobject['smalltext3'] ? $thisobject['smalltext3'] : "left";
$thisobject['style'] = '';

$imgbox['margin-left'] = ($result['smalltext3'] == "right") ? $result['text2'] : "0";
$imgbox['margin-right'] = ($result['smalltext3'] == "left") ? $result['text2'] : "0";

$object_head_right = "<div class=\"bu_add\" onclick=\"mediabrowser.open();\"></div>";

switch ($part) {
	case "compose":
	
	include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");
?>
<div class="object" style="width:100%;" >
	<div class="imgbox" id="imgbox<?php echo $result['id'] ?>" style="<?php echo $marginxy ?> float:<?php echo $result['smalltext3'] ? $result['smalltext3'] : 'left'; ?>;">
	<?php if($pictures[0]) {  echo $pictures[0]; } ?>	
	</div>

	<?php echo $this->textobject($thisobject); ?>
	<br class="clear" />
</div>
Stil: <?php echo $mystyles; ?>








<?php 
	break;
	default:
?>
<div <?php if($result['contents_css']) echo "class=\"".$result['contents_css']."\""; ?> style="width:100%;">
	<?php if($size[0]) { ?>
	
	<div class="imgbox" style="float:<?php echo $result['smalltext3'] ?>; <?php echo $marginxy ?>">
		<?php echo $pictures[0];  ?>
	</div>
	
	<?php } ?>
	
	<?php if($result['smalltext1']) echo "<div style=\"padding-".$result['smalltext3'].":".($size[0]+$result['text2'])."px;\">\n";	
	$text = ereg_replace("  ","&nbsp; ",$result['text']);
	echo nl2br($text);
	if($result['smalltext1']) echo "</div>\n";
	?>
<div style="clear:left;"></div>
</div>
<?php	break;
	}
	unset($marginxy,$side);
?>
