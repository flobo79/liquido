<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$objecttitle = "Titelelement";
$thisobject['formrows'] = "5";
$thisobject['id'] = "text".$result['id'];
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = $result['contents_css'];
$thisobject['textwidth'] = $insert ? '100%' : $contentwidth - $size[0] - $result['text2']-5;
$thisobject['style'] = '';

$object_head_right = "<div class=\"bu_add\" onclick=\"mediabrowser.open();\"></div>";

switch ($part) {
	case "compose":
	
	include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");
?>
<div class="object" style="width:100%;" >
	
	<div class="imgbox" id="imgbox<?php echo $result['id'] ?>">
		<?php if($pictures[0]) { echo $pictures[0]; } ?>
	</div>
	
	<div style="clear: both;">
		<label for="<? echo "headline".$result['id']; ?>">&Uuml;berschrift:</label><br />
		<input name="objectdata[<? echo $result['id']; ?>][smalltext1]" id="<? echo "headline".$result['id']; ?>" type="text"  class="text" style="width: 95%; border:1px dotted #CCCCCC;" value="<?php echo $result['smalltext1']; ?>">

		<br /><label for="<? echo "text".$result['id']; ?>">Text:</label><br />
		<textarea name="objectdata[<? echo $result['id']; ?>][text]" rows="7" style="width: 100%"><?php echo $result['text']; ?></textarea>

		<br /><label for="<? echo "title".$result['id']; ?>">Titeltext:</label><br />
		<input name="objectdata[<? echo $result['id']; ?>][smalltext3]" id="<? echo "headline".$result['id']; ?>" type="text"  class="text" style="width: 95%; border:1px dotted #CCCCCC;" value="<?php echo $result['smalltext3']; ?>">

	</div>
	
	<br class="clear" />
</div>









<?php 
	break;
	default:
?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 15px; border-bottom: 2px solid #eb690b">
		<tr>
			<?php if($size[0]) : ?>	
				<td style="padding-right: 16px;" valign="top" width="290px"><?php echo $pictures[0];  ?></td>
			<?php endif; ?>	
			<td valign="top">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td valign="top">
							<h2 class="nl_grayhead"><?php echo $result['smalltext1']; ?></h2>
							<p class="nl_p"><?php 
									$text = ereg_replace("  ","&nbsp; ",$result['text']);
									echo nl2br($text);
								?></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	

<?php	break;
	}
	unset($marginxy,$side);
?>
