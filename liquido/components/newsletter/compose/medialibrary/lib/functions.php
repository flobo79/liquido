<?php

/*   Funktionen für die MediaLibrary

 02 getObjectType		funktion zum ermitteln des Mime-Types eines objects
 						** get the mimetype of an object
 04 ListFolder			listet die Mappen einer parent-mappe auf
 						** list all folders in a parentfolder
 getActiveFrame			ermittelt die aktuelle Spalte
 						** get current column
 getObjectData			liest alle Informationen eines Objektes
 
 droplistFolder

 */

include_once("../../../../lib/init.php");
session_start();

// functions
function select($image) {
	global $cfg;
	global $db;
	global $user;
	
	include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/lib/imagemagick.inc.php");
	$time = time();

	// bild ind die datenbank aufnemen
	$sql = "INSERT INTO ".$cfg['tables']['nlcontentimgs']." (`libid`,`cid`,`user`,`date`) VALUES ('".mysql_escape_string($image['img'])."', '".intval($image['id'])."', '".intval($user['id'])."', '$time')"; //echo $sql;
	$db->execute($sql);
	$picid = $db->insert_id();
	
	// bildordner aktualisieren
	$picdir = $_SERVER['DOCUMENT_ROOT'].LIQUIDO."/nlbilder/".intval($picid);
	if(!file_exists(realpath($picdir))) mkdir($picdir);
	

	$upload['source'] = $_SERVER['DOCUMENT_ROOT'].MEDIALIB"/".$image['img']."/original.jpg";

	// optionen
	$upload['name'] = "thumbnail";			//name for the thumbnail  (optional)
	$upload['name2'] = "small";				//name for the converted image
	$upload['name3'] = "original";			//name for the original
	
	$upload['path'] = $picdir;		// targetpath für thumbnail  

	$upload['height'] = $pictures['maxsize_y'];				
	$upload['width'] = $image['width'];
	$upload['crop'] = $content['crop'];
	$upload['lossless'] = $image['lossless'];
	
	$upload['watermark'] = $cfg['components']['medialib']['watermark1'];				// file to insert as watermark on thumbnail
	$upload['watermark2'] =  $cfg['components']['medialib']['watermark2'];			// file to insert as watermark on image
	$upload['watermark3'] =  $cfg['components']['medialib']['watermark3'];			// file to insert as watermark on original

	$upload['tnheight'] = 1000;
	$upload['tnwidth'] = $image['tnwidth'];
	$upload['tncrop'] = $content['thumbcrop'];
	
	$upload['original'] = 1;							// saves the originalfile

	// funktionsaufruf
	$file = uploadandconvert($upload);

	return "ok";
}


# 02  getObjectType
function getObjectType($id) {
	global $db;
	global $cfg;
	$sql = "select mime from ".$cfg['tables']['medialib']." where `id` = '".intval($id)."' LIMIT 1"; 
	$mime = $db->con->getRow($sql);
	return $mime['mime'];
}

# 03  writeObject
function writeObject($fields) {
	include("../../../../lib/init.php");
	//include("lib/config.php");
	
	foreach($fields as $name => $val) {
		$str1 .= mysql_escape_string($name).", ";
		$str2 .= "'".mysql_escape_string($val)."', ";
	}
	$str1 .= "date";
	$str2 .= "'".time()."'";
	$sql = "insert into ".$cfg['tables']['medialib']." ($str1) values ($str2)";
	
	mysql_query($sql);
	
	$insertid = mysql_insert_id();
	
	return $insertid;
}



function ListFolder($parent,$order=0,$current=0) {
	$order = $order ? "order by '$order'" : "order by name";
	$parent = $parent ? $parent : "0";
	global $cfg;
	global $db;
	include("lib/config.php");
	$sql = "select * from ".$cfg['tables']['medialib']." where parent = '$parent' $order"; //echo $sql;
	$q = mysql_query($sql);
	while ($result = mysql_fetch_array($q)) {
		include("list_".$result['mime'].".php");
	}	
}




function getActiveFrame($id) {
	if(intval($id)) {
		global $cfg;
		global $db;

		include("lib/config.php");
		
		$i=0;
		$current = mysql_fetch_array(mysql_query("select parent from ".$cfg['tables']['medialib']." where id = '$id' LIMIT 1"));
		if($parent = $current['parent']) {
			while($parent) {
				$previous = mysql_fetch_array(mysql_query("select parent from ".$cfg['tables']['medialib']." where id = '$parent' LIMIT 1"));
				$parent = $previous['parent'];
				$i++;
			}
		}
		return $i;
	}
}


// stetzt die breite des iFrames im Listenmodus
function setIframeWidth($id,$width=0) {
	$frame=getActiveFrame($id);
	$setwidth = $frame * 220 + $width;
	echo "<script language=\"JavaScript\">
			top.mainFrame.setwidth($setwidth);
		</script>";
}



function updateColumn($id) {
	//update list-frame
	$frame=getActiveFrame($id);
	$updateFrame = "top.body.mainFrame.iframe";
	for($i=1;$i<$frame;$i++) {
		$updateFrame .= ".frames[1]";
	}
	$updateFrame .= ".frames[0]";
	
	echo "<script language=\"JavaScript\">
		$updateFrame.location.reload();
	</script>
	";
}

function updateColumnChilds($id) {
	//update list-frame
	$frame=getActiveFrame($id);
	$updateFrame = "top.body.mainFrame.iframe";
	for($i=1;$i<$frame;$i++) {
		$updateFrame .= ".frames[1]";
	}
	$updateFrame .= ".frames[1].frames[0]";
	
	echo "<script language=\"JavaScript\">
		$updateFrame.location.reload();
	</script>
	";
}

function updateTree($id) {
	//update list-frame
	$frame=getActiveFrame($id);
	$updateFrame = "top.body.mainFrame.iframe";
	for($i=1;$i<$frame;$i++) {
		$updateFrame .= ".frames[1]";
	}
	
	echo "<script language=\"JavaScript\">
		$updateFrame.location.reload();
	</script>
	";
}


function getObjectData($folderid) {
	global $db;
	global $cfg;
	include("lib/config.php");
	
	//$sql = "select * from ".$cfg['tables']['medialib']." where id = '$folderid' limit 1";
	//$result = $db->con->getRow($sql));
	
	// anzahl der beinhalteten Ordner
	$sql_folder = "select COUNT(id) from ".$cfg['tables']['medialib']." where parent = '$folderid' and mime = 'folder'";
	$count_folders = $db->con->getRow($sql_folder);
	$result['folders'] = $count_folders[0];
	
	// anzahl der beinhalteten Dokumente
	$sql_documents = "select COUNT(id) from $cfgTableMediaLib where parent = '$folderid' and mime != 'folder'";
	$count_documents = $db->con->getRow($sql_documents);
	$result['documents'] = $count_documents[0];
	
	//erstellungsdatum
	$result['date'] = strftime(getDay($result['date'])." %H:%M",$result['date']);
	// änderungsdatum
	if($result['changed']) { $result['changed'] = strftime(getDay($result['changed'])." %H:%M",$result['changed']); } else { $result['changed'] = "keine Änderungen"; }

	return $result;
}



function droplistFolder($current) {
	global $cfg;
	global $db;
	include("lib/config.php");
	$sql 	= "select * from ".$cfg['tables']['medialib']; //echo $sql;
	$q 		= mysql_query($sql);
	while($result = mysql_fetch_array($q)) {
		if($result['id'] != $current) echo "<option value=\"$result[id]\">$result[name]</option>";
	}
}


?>