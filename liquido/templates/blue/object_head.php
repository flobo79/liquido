<div class="objecthead" id="head<?php echo $objectid ?>">
	<div style="float:left">
		<?php echo $objecttitle ?>
		<input name="objectdata[id]" type="hidden" value="<?php echo $objectid; ?>">
	</div>
	<div style="float:right">
		<?php if(is_array($buttons)) { foreach($buttons as $button) { echo $button; } } ?>
		<?php if ($access['c11']) { ?><a href="?trash[id]=<?php echo $objectid; ?>" ><img src="<?php echo LIQUIDO ?>/components/contents/gfx/delobject.gif" title="Objekt l&ouml;schen" name="del<?php echo $objectid ?>"></a><?php } ?>
		<?php if ($access['c12']) { ?><a href="<?php echo "?rank[dir]=up&rank[rank]=$result[rank]&rank[id]=$objectid"; ?>" >&nbsp;&nbsp;<img src="<?php echo LIQUIDO ?>/components/contents/gfx/move_up.gif" title="aufw&auml;rts verschieben" name="up<?php echo $objectid ?>"></a><a href="<?php echo "?rank[dir]=down&amp;rank[rank]=$result[rank]&amp;rank[id]=$objectid"; ?>"><img src="<?php echo LIQUIDO ?>/components/contents/gfx/move_down.gif" title="abw&auml;rts verschieben" name="down<?php echo $objectid ?>"></a><?php } ?>
	</div>
</div>