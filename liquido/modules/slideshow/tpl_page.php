
	<span style="display:none !important;" class="data">
	<?php 

	$data = array();
	foreach($this->childs as $c) {
		if($c['mime'] == 'picture' or $c['mime'] == 'mp3' or $c['mime'] == 'flv') $data[] = $c;
	}
	echo json_encode($data);
	
	?>
	</span>
	<?php 
	$i = 0;
	
	foreach($this->childs as $node) { 
		if($node['mime'] == 'picture' or $node['mime'] == 'flv' or $node['mime'] == 'mp3') { 
				$ico = $node['mime'] == 'flv' ? LIQUIDO.'/components/medialibrary/gfx/movie.png' : $node['mime'] == 'mp3' ? LIQUIDO.'/modules/slideshow/mp3.png' : MEDIALIB."/".$node['id']."/small.jpg";
				?>
				<div id="i<?php echo $node['id'] ?>">
					<img width="80" src="<?php echo $ico; ?>" /> </div>
	<?php
		 $i++;
		 if($this->thumbs && $this->thumbs == $i) break; 
		 }	 
	} ?>
