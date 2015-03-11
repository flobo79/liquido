<?php

#  reprint #############



#  upload  ##############
function select($upload) {
	include("../../lib/init.php");
	include("lib/config.php");
	include("../../lib/imagemagick.inc.php");

	$x=0;
	for($i = 1; $i <= $upload['n_uploads']; $i++) {
	
		$imagefile = $upload["imagefile".$i];
		if($imagefile and $imagefile != "none") {

			// Bildinfos referenzieren
			$fields['name'] = $upload["title".$i];
			$fields['info'] = $upload["info".$i];
			$fields['parent'] = $upload['id'];
			$fields['mime'] = 'picture';
			
			// Object in die Datenbank aufnehmen
			$docid = writeObject($fields);
			
			$upload['source'] = $imagefile;
		
			// optionen
			$upload['name'] = "thumbnail";			//name for the thumbnail  (optional)
			$upload['name2'] = "small";			//name for the converted image
			$upload['name3'] = "original";			//name for the original
			
			$upload['path'] = "../../".$cfgcmslibdir.$docid;		// targetpath für thumbnail  
		
			$upload['height'] = "80";				
			$upload['width'] = "100";
			
			$upload['lossless'] = $image['lossless'];
			
			/*
			$upload[watermark] = $watermark1;			// file to insert as watermark on thumbnail
			$upload[watermark2] = $watermark2;			// file to insert as watermark on image
			$upload[watermark3] = $watermark3;			// file to insert as watermark on original
			*/

			$upload['tnheight'] = "25";
			$upload['tnwidth'] = "25";
			$upload['tncrop'] = $thumbcrop;			// set true to crop the image to the size-values
			
			$upload['original'] = 1;				// saves the originalfile

			// funktionsaufruf
			$file = uploadandconvert($upload);


			$x++;
		}
	}
	return $report;
}


#  list_variantions  ###############
function listVariations($id) {
	include("../../lib/init.php");
	include("lib/config.php");
	
	$sql = "select * from $cfgTableMediaLib where parent = '$id' and copy = '1'";
	$q = mysql_query($sql);
	while($variation = mysql_fetch_array($q)) {
		if(!$started) {
			$part = "start";
			include("list_variations.php");
			$started = 1;
		}
		$part = "box";
		include("list_variations.php");
			
	}
	if($started) {
		$part = "end";
		include("list_variations.php");
	}
}

?>