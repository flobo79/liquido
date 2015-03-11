<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);

$side = $result['smalltext3'] == "left" ? "right" : "left";
$marginxy = "margin-".$side.": ".$result['text2'] ."px;";

$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$objecttitle = "Textobjekt";
$thisobject['formrows'] = "5";
$thisobject['id'] = "text".$result['id'];
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = $result['contents_css'];
$thisobject['textwidth'] = $contentwidth - $size[0] - $result['text2']-5;
$thisobject['smalltext3']  = $result['smalltext3'] ? $result['smalltext3'] : "left";

$imgbox['margin-left'] = ($result['smalltext3'] == "right") ? $result['text2'] : "0";
$imgbox['margin-right'] = ($result['smalltext3'] == "left") ? $result['text2'] : "0";

$result['smalltext2'] = $result['smalltext2'] == 'ol' ? 'ol' : 'ul';
$result['smalltext3'] = $result['smalltext3'] == 'right' ? 'right' : 'left';

// optionsmenue hinzuladen
if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

switch ($part) {
	case "compose": 
?>
<div class="object" style="width:100%;" >
	<div class="imgbox" id="imgbox<?php echo $result['id'] ?>" style="<?php echo $marginxy ?> float:<?php echo $result['smalltext3'] ? $result['smalltext3'] : 'left'; ?>;">
	<?php if($pictures[0]) {  echo $pictures[0]; } ?>	
	</div>
	
	<?php
	echo $this->textobject($thisobject); ?>
	<br class="clear" />
	Listentyp: <select name="objectdata[<? echo $result['id']; ?>][text2]">
    		<option value="ul" <?php if ($result['text2'] == "ul" or !$result['text2']) echo " selected"; ?>>Punkte</option>
			<option value="ol" <?php if ($result['text2'] == "ol" or !$result['text2']) echo " selected"; ?>>Zahlen</option>
		</select>  <div class="button" onclick="mediabrowser.open();">Bild einfügen</div>
</div>
<?php	break;
	default:
?>
<div <?php if($result['contents_css']) echo "class=\"".$result['contents_css']."\""; ?> style="width:100%;">
	<?php if($size[0]) { ?>
	<div class="imgbox" style="float:<?php echo $result['smalltext3'] ?>; <?php echo $marginxy ?>">
		<?php echo $pictures[0];  ?>
	</div>
	<?php } 
	
	echo "<$result[text2] class=\"list\">";
	
	$text = ereg_replace("  ","&nbsp; ",$result[text]);
	$block = split("\n",$text);
	for($i=0;$block[$i];$i++) {
		echo "<li>$block[$i]</li>
		";
	}
	echo "</$result[text2]>";
	?>
</div>

<?php	break;
}

?>
