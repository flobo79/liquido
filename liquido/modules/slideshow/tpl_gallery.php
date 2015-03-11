<div id="ss_icons">
	<?php foreach($this->childs as $c) { 
		if($c['mime'] == 'picture') {
			echo '<div class="item"><img id="ii'.$c['id'].'" src="'.MEDIALIB.'/'. $c['id'].'/small.jpg" /></div>';
		}
	 } 
	?>
</div>

<div id="ss_show">
	<script type="text/javascript">
		var so = new SWFObject('/liquido/modules/slideshow/mediaplayer/player.swf','mpl','600','344','9');
		so.addParam('allowscriptaccess','always');
		so.addParam('allowfullscreen','true');
		so.addParam('flashvars','&file=/liquido/modules/slideshow/<?php echo $this->folder; ?>&playlist=right');
	</script>
</div>
