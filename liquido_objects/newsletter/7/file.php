<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$side = $result['smalltext3'] == "left" ? "left" : "right";
$marginxy = "margin-".$side.": ".$result['text2'] ."px;";

$objecttitle = "Text mit Bild";
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
	
	<div class="imgbox" id="imgbox<?php echo $result['id'] ?>" style="<?php echo $marginxy ?> float:<?=$side ?>;">
		<?php if($pictures[0]) { echo $pictures[0]; } ?>
	</div>
	
	<div style="clear: both;">
		<label for="<? echo "headline".$result['id']; ?>">Überschrift:</label><br />
		<input name="objectdata[<? echo $result['id']; ?>][smalltext1]" id="<? echo "headline".$result['id']; ?>" type="text"  class="text" style="width: 95%; border:1px dotted #CCCCCC;" value="<?php echo htmlspecialchars($result['smalltext1']); ?>">

		<br />
		<label for="<? echo "text".$result['id']; ?>">Text:</label><br />
		<textarea name="objectdata[<? echo $result['id']; ?>][text]" rows="7" style="width: 100%"><?php echo $result['text']; ?></textarea>
	</div>
	
	<br class="clear" />
</div>


	<?php 
			break;
		default:	
	?>
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<?php if($side == "left" && $size[0]) { ?>	
				<td style="padding-right: 16px;" valign="top"><?php echo $pictures[0];  ?></td>
			<?php } ?>	
			<td valign="top">
				<h2 class="nl_grayhead"><?php echo $result['smalltext1']; ?></h2>
				<p class="nl_p" style="margin-top: 0;"><?php 
					echo nl2br(preg_replace("/  /","&nbsp; ",$result['text']));
				?></p>
			</td>
			<?php if($side != "left" && $size[0]) : ?>	
				<td style="padding-left: 16px;" valign="top"><?php echo $pictures[0];  ?></td>
			<?php endif; ?>	
		</tr>
	</table>

	<?php	
		break;
	}
	
	
	unset($marginxy,$side);
?>
