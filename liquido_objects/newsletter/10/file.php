<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];


$side = $result['smalltext3'] == "left" ? "right" : "left";
$marginxy = "margin-".$side.": ".$result['text2'] ."px;";

$objecttitle = "Text mit Bild ( 2 Spalten)";
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
	
	<div class="imgbox" id="imgbox<?php echo $result['id'] ?>" style="float:<?php echo $result['smalltext3'] ? $result['smalltext3'] : 'left'; ?>;">
		<?php if($pictures[0]) { echo $pictures[0]; } ?>
	</div>
	
	
	
	<div style="clear: both;">
		<br /><label for="<? echo "text1".$result['id']; ?>">Text f&uuml;r linke Spalte:</label><br />
		<textarea name="objectdata[<? echo $result['id']; ?>][text4]" rows="7" style="width: 100%"><?php echo $result['text4']; ?></textarea>

		<br /><label for="<? echo "text2".$result['id']; ?>">Text f&uuml;r rechte Spalte:</label><br />
		<textarea name="objectdata[<? echo $result['id']; ?>][text5]" rows="7" style="width: 100%"><?php echo $result['text5']; ?></textarea>
	</div>
	
	<br class="clear" />
</div>









<?php 
	break;
	default:
?>
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<?php
				$images = $pictures[0];
				$pattern = "/<.*?>/msi"; 
				preg_match_all($pattern, $images, $matches);
			?>
			<td width="290px" valign="top" align="left" style="padding-bottom: 4px;"><?php if($matches[0][0]) { echo $matches[0][0]; } ?></td>
			<td width="16px" valign="top" style="padding-bottom: 4px;">&nbsp;</td>
			<td width="290px" valign="top" align="left" style="padding-bottom: 4px;"><?php if($matches[0][1]) { echo $matches[0][1]; } ?></td>
		</tr>
		<tr>
			<td width="290px" valign="top" style="line-height: 12px">
					<p class="nl_p" style="margin-top: 0;"><?php 
						$text4 = ereg_replace("  ","&nbsp; ",$result['text4']);
						echo nl2br($text4);
					?></p>
			</td>
			<td width="16px" valign="top">&nbsp;</td>
			<td width="290px" valign="top" style="line-height: 12px">
					<p class="nl_p" style="margin-top: 0;"><?php 
						$text5 = ereg_replace("  ","&nbsp; ",$result['text5']);
						echo nl2br($text5);
					?></p>
			</td>
		</tr>
	</table>
	
	

<?php	break;
	}
	unset($marginxy,$side);
?>
