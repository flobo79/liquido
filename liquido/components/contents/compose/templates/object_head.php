<div class="objecthead" style="width:100%; height:14px;">
	<div style="float:right; height:14px; clear:none; width:40%;" >
		<?php if ($access['c11']) { ?>
		<div class="delbutton" onclick="del('<?php echo $objectid; ?>');" title="dieses Objekt löschen" ></div>
		<div class="sort"></div>
		<?php if(isset($object_head_right)) echo $object_head_right; ?>
		<?php } ?>
	</div>
	
	<?php echo $objecttitle; ?>
</div>

<?php unset($object_head_right); ?>
