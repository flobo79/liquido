<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="bottom" class="smalltext">
		<?php echo $objecttitle ?>
		<input name="objectdata[id]" type="hidden" value="<?php echo $objectid; ?>"> 
      	<input name="updateobject" type="hidden" value="ok">
	</td>
	
    <td align="right" class="smalltext">
		<?php foreach($buttons as $button) { echo $button; } ?>
		<?php if ($access['c11']) { ?><a href="?trash[id]=<?php echo $objectid; ?>" onMouseOver="MM_swapImage('del<?php echo $objectid ?>','','<?php echo LIQUIDO ?>components/contents/gfx/delobject_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>components/contents/gfx/delobject.gif" title="Objekt l&ouml;schen" name="del<?php echo $objectid ?>" /></a><?php } ?>
		<?php if ($access['c12']) { ?><a href="<?php echo "?rank[dir]=up&amp;rank[rank]=$result[rank]&amp;rank[id]=$objectid"; ?>" onMouseOver="MM_swapImage('up<?php echo $objectid ?>','','<?php echo LIQUIDO ?>components/contents/gfx/move_up_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;&nbsp;<img src="<?php echo LIQUIDO ?>components/contents/gfx/move_up.gif" title="aufw&auml;rts verschieben" name="up<?php echo $objectid ?>" /></a><a href="<?php echo "?rank[dir]=down&amp;rank[rank]=$result[rank]&amp;rank[id]=$objectid"; ?>" onMouseOver="MM_swapImage('down<?php echo $objectid ?>','','<?php echo LIQUIDO ?>components/contents/gfx/move_down_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo LIQUIDO ?>components/contents/gfx/move_down.gif" title="abw&auml;rts verschieben"  name="down<?php echo $objectid ?>"></a><?php } ?>
	</td>
  </tr>
</table>