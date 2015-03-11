<div id="option<?php echo $objectid ?>">
	<input type="hidden" name="objectdata[<?php echo $objectid; ?>][contents_css]" id="css_<?php echo $objectid ?>" value=".<?php echo $result['contents_css'] ?>" />
	<input type="hidden" name="objectdata[<?php echo $objectid; ?>][text2]" id="ta_<?php echo $objectid ?>" value="<?php echo $result['text2'] ? $result['text2'] : $cfg['components']['contents']['compose']['textmargin']; ?>" />
	<input type="hidden" name="objectdata[<?php echo $objectid; ?>][smalltext3]" id="pos_<?php echo $objectid ?>" value="<?php echo $float ?>" />
</div>