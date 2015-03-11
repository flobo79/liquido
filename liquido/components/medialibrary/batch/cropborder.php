<?php
if($proceed) {
	include("../../../lib/init.php");
	include("../../../lib/imagemagick.inc.php");
	
	function cropPicture ($id,$pixel) {
	
			$docid = $id;
			// lösche small und thumbnail
			exec("cp ../../../medialib/$docid/original.jpg ../../../medialib/$docid/source.jpg");
			exec("rm ../../../medialib/$docid/original.jpg");
			exec("rm ../../../medialib/$docid/small.jpg");
			exec("rm ../../../medialib/$docid/thumbnail.jpg");

			// source-datei
			$upload['source'] = "../../../medialib/$docid/source.jpg";
			
			//berechne neue breite und höhe
			$size = GetImageSize($upload['source']);
			$width = $size[0] - ($pixel['left'] + $pixel['right']);
			$height = $size[1] - ($pixel['top'] + $pixel['bottom']);

			// schneide pixel ab
			$shc = "mogrify -crop '".$width."x".$height."+$pixel[left]+$pixel[top]' +profile '*' -quality '100' ".$upload['source']; //echo $shc;
			exec($shc);

			// Bildinfos referenzieren
			if(!$fields['name']) 	$fields['name'] = $upload["title".$i];
			if(!$fields['info'])	$fields['info'] = $upload["info".$i];
			if(!$fields['parent'])	$fields['parent'] = $upload[id];
			if(!$fields['mime'])	$fields['mime'] = 'picture';
			
			// optionen
			$upload['name'] = "thumbnail";			//name for the thumbnail  (optional)
			$upload['name2'] = "small";				//name for the converted image
			$upload['name3'] = "original";			//name for the original
			
			$upload['path'] = "../../../medialib/".$docid;  // targetpath für thumbnail  
		
			$upload['height'] = "80";				
			$upload['width'] = "100";
			
			$upload['watermark'] = $cfg['watermark1'];			// file to insert as watermark on thumbnail
			$upload['watermark2'] = $cfg['watermark2'];			// file to insert as watermark on image
			$upload['watermark3'] = $cfg['watermark3'];			// file to insert as watermark on original
			

			$upload['tnheight'] = "25";
			$upload['tnwidth'] = "25";
			
			$upload['original'] = 1;				// saves the originalfile

			// imagemagick-funktionsaufruf
			uploadandconvert($upload);
			
			exec("rm ".$upload['source']);
			
		}

	if($type == "folder") {
		$sql = "select id from $cfgtablemedialib where parent = '$id'"; //echo $sql;
		$q = mysql_query($sql);
		while ($result = mysql_fetch_row($q)) {
				 cropPicture ($result[0],$pixel);
		}
		header("Location:../list_details.php?id=$id");
	} elseif ($type == "picture") {
		cropPicture($id,$pixel);
		header("Location:../list_details.php?id=$id");
	}
	

}

if(!$part) $part = "panel";
switch($part) {
	case "info":
		
		$title = "crop border";
		break;
	case "panel":

	include("../../../lib/cfg_general.inc.php");
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../lib/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" border="0" cellpadding="1" cellspacing="0">
  <tr> 
    <td width="25" valign="top">&nbsp;</td>
    <td width="198" height="97" valign="top"><p><br>
        <br>
        <?php if($type == "folder") { ?>
        <img src="../gfx/folder_big.gif" width="59" height="59"><br>
        <?php } elseif ($type == "picture") { 
			$imagesize = GetImageSize("../../../".$cfgcmslibdir.$id."/original.jpg");
		?>
        <a href="#" onClick="window.open('../pic_popup_ruler.php?pic=<?php echo $cfgcmslibdir.$id ?>','bild','<?php echo "width=".($imagesize[0]+5).",height=".($imagesize[1]+5)."')" ?>; return false"><img src="../../../<?php echo $cfgcmslibdir.$id ?>/small.jpg" border="0"><br>
        <br>
        Bild mit Linial anzeigen </a>
        <?php } ?>
        <br>
      </p></td>
    <td width="273" valign="top"><p> <span class="headline"><br>
        </span>Schneidet Pixel vom Rand ab</p>
      <form name="form1" method="post" action="">
        <p>&nbsp;</p>
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr align="center"> 
            <td colspan="2">oben:
		<input name="pixel[top]" type="text" id="pixel" value="0" size="2" maxlength="2"></td>
          </tr>
          <tr align="center"> 
            <td>links: 
              <input name="pixel[left]" type="text" id="pixel" value="0" size="2" maxlength="2"></td>
            <td>rechts: 
              <input name="pixel[right]" type="text" id="pixel" value="0" size="2" maxlength="2"></td>
          </tr>
          <tr align="center"> 
            <td colspan="2">unten: 
              <input name="pixel[bottom]" type="text" id="pixel" value="0" size="2" maxlength="2"></td>
          </tr>
        </table>
        <p><a href="#" onClick="submit()">ausf&uuml;hren 
          </a> 
          <input name="id" type="hidden" id="id" value="<?php echo $id ?>">
		  <input name="type" type="hidden" id="id" value="<?php echo $type ?>">
          <input name="proceed" type="hidden" id="proceed" value="1">
        </p>
      </form>
      
    </td>
    <td width="552" valign="top"><br> <span class="headline"> </span> <p><br>
      </p></td>
  </tr>
</table>
</body>
</html>
<?php
		break;
	case "result":
	
		break;
}


?>