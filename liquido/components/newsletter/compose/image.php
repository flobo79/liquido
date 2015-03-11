<?php

include ("../../../lib/init.php");
include ("../functions.inc.php");

if(($imgid = intval($_GET['id'])) or ($imgid = intval($_POST['id']))) {
//	$size = getimagesize($_SERVER['DOCUMENT_ROOT'].IMAGES."/".intval($_GET['id'])."/thumbnail.jpg");

	if($_POST['save'] and $imgid) {
		$link = mysql_escape_string($_POST['link']);
		$linktarget = mysql_escape_string($_POST['linktarget']);
		$info = mysql_escape_string($_POST['info']);
		
		$update_sql = "update ".$cfg['tables']['contentimgs']." set `info` = '$info', `link` = '$link', `linktarget` = '$linktarget' where id = '$imgid' LIMIT 1";
		$db->execute($update_sql); //echo mysql_error();
		
		// bildgröße verändern
		if(intval($_POST['width'])) {
			include ($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/lib/imagemagick.inc.php");
			$upload['source'] = $_SERVER['DOCUMENT_ROOT'].IMAGES."/".intval($imgid)."/original.jpg";
			$upload['name'] = "thumbnail";				//name for the thumbnail  (optional)
			$upload['name2'] = "small";					//name for the converted image
			//$upload['name3'] = "original";			//name for the original
			
			$upload['path'] = $_SERVER['DOCUMENT_ROOT'].IMAGES."/".$imgid;		// targetpath für thumbnail  
		
			$upload['height'] = "80";				
			$upload['width'] = intval($_POST['width']);
			
			//$upload['lossless'] = $image['lossless'];
			
			/*
			$upload[watermark] = $watermark1;			// file to insert as watermark on thumbnail
			$upload[watermark2] = $watermark2;			// file to insert as watermark on image
			$upload[watermark3] = $watermark3;			// file to insert as watermark on original
			*/
		
			$upload['tnheight'] = 500;
			$upload['tnwidth'] = intval($_POST['width']);
			//$upload['tncrop'] = $thumbcrop;			// set true to crop the image to the size-values
			//$upload['original'] = 1;				// saves the originalfile
	
			// funktionsaufruf
			$file = uploadandconvert($upload);
		}
	}
	
	$size = getimagesize($_SERVER['DOCUMENT_ROOT'].IMAGES."/".$imgid."/thumbnail.jpg");
	$sql = "select * from ".$cfg['tables']['contentimgs']." where `id` = '".$imgid."' LIMIT 1";
	$image = $db->con->getRow($sql);

	// feed smarty
	$smarty->assign("size",$size);
	$smarty->assign("image",$image);
	$smarty->assign("img",IMAGES."/".$imgid."/thumbnail.jpg");

	$smarty->display(dirname(__FILE__)."/templates/edit_image.tpl");
	
} else { ?>
<script language="javascript" type="text/javascript">
	alert("Keine Bildnummer übergeben, Fenster wird geschlossen");
	window.close();
</script>
<?php } ?>