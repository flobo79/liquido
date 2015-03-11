<?php
// lade zugriffstabelle
$access = $L->loadAccessTable($user,"medialibrary");
$n_uploads = $_SESSION['n_uploads'];
$id = $_GET['id'];

#  trigger #############
if (array_key_exists('createFolder',$_POST)) 		createFolder($_POST['createFolder']);
if (array_key_exists('editFolder',$_POST)) 			updateObject($_POST['editFolder']);
if (array_key_exists('editDocument',$_POST))		updateObject($_POST['editDocument']);



if (array_key_exists('upload', $_POST)) {
##############################
	upload($_POST['upload']);
	updateColumnChilds($_POST['id']);
}

function setIframeWidth($id,$width=0) {
// stetzt die breite des iFrames im Listenmodus

	$frame=getActiveFrame($id);
	$setwidth = $frame * 220 + $width;
	echo "<script language=\"JavaScript\" type=\"text/javascript\">
		top.content.mainFrame.setwidth($setwidth);
	</script>";
}


function updateColumn($id) {
//update list-frame
	
	$frame=getActiveFrame($id);
	$updateFrame = "top.content.mainFrame.iframe";
	for($i=1;$i<$frame;$i++) {
		$updateFrame .= ".frames[1]";
	}
	$updateFrame .= ".frames[0]";
	
	echo "<script language=\"JavaScript\" type=\"text/javascript\">
		$updateFrame.location.reload();
	</script>
	";
}

function updateColumnChilds($id) {
//update list-frame
	$frame=getActiveFrame($id);
	$updateFrame = "top.content.mainFrame.iframe";
	for($i=1;$i<$frame;$i++) {
		$updateFrame .= ".frames[1]";
	}
	$updateFrame .= ".frames[1].frames[0]";
	
	echo "<script language=\"JavaScript\" type=\"text/javascript\">
		$updateFrame.location.reload();
	</script>
	";
}

function updateTree($id) {
################################
	//update list-frame
	$frame=getActiveFrame($id);
	$updateFrame = "top.content.mainFrame.iframe";
	for($i=1;$i<$frame;$i++) {
		$updateFrame .= ".frames[1]";
	}
	
	echo "<script language=\"JavaScript\" type=\"text/javascript\">
		$updateFrame.location.reload();
	</script>
	";
}

function updateDetails($id=0) {
################################
	if($id) $linkadd = "?id=$id";
	echo "<script language=\"JavaScript\" type=\"text/javascript\">
		top.content.Details.location.href='list_details.php".$linkadd."';
	</script>";
}



function reprint($data) {
#  reprint #################
	global $cfg;
	global $L;
	include("lib/config.php");

	$insert['name'] 	= "Abzug";
	$insert['info'] 	= "Abzug von ".$data['name'];
	$insert['parent'] = $data['id'];
	$insert['mime'] 	= $data['mime'];
	$insert['copy']	= 1;

	// sqleintrag
	$id = writeObject($insert);
	
	// make a copy of the Object
	$shc = "cp -r ".$_SERVER['DOCUMENT_ROOT'].$cfgcmslibdir."/".$data['id']." ".$_SERVER['DOCUMENT_ROOT'].$cfgcmslibdir."/".$id;
	exec($shc);

	return $id;
}

function listFtpFolder($id) {
#############################
	global $cfg;
global $L;
	include("lib/config.php");
	
	$uploadFolder = $_SERVER['DOCUMENT_ROOT'].$cfguploadfolder;
	$folders = getFolderList($uploadFolder);
	
	if($folders) {
		while (list ($key, $val) = each ($folders)) {
			$location = urlencode($val);
			echo "<tr>
				<td width=\"25\"><a href=\"list_ftp_window.php?ftpfolder=$location&id=$id\"><img src=\"gfx/upload_folder_small.gif\"></a></td>
				<td> <a href=\"list_ftp_window.php?ftpfolder=$location&id=$id\"> $val </a></td>
			</tr>
			";
		}
	}
}



function importFolder($import) {
##############################
	global $cfg;
	global $L;
	include("lib/config.php");
	//include($_SERVER['DOCUMENT_ROOT'].$cfg['env']['cmspath']."/lib/cfg.php");
	
	//include($_SERVER['DOCUMENT_ROOT'].$cfg['env']['cmspath']."/lib/imagemagick.inc.php");

	$folder = $import['folder'];
	$parent = $import['id'];
	
	if(!$folder or !$parent) die("ftp-importfunktion \"importFolder\" konnte nicht gestartet werden da folder oder id nicht richtig waren");

	$folder = $_SERVER['DOCUMENT_ROOT'].$cfguploadfolder."/".$folder;
	$contents = getFolderList($folder);
	
	while (list ($key, $val) = each ($contents)) {
		if($val) {
		
			// maskiere nicht c-konforme zeichen
			$name = addcslashes($val," |&");

			// filename
			$file = $folder."/".$name;
			
			// Bildinfos referenzieren
			$fields['name'] = $name;
			$fields['info'] = "uploaded Image";
			$fields['parent'] = $parent;
			$fields['mime'] = 'picture';
			
			include("lib/upload_img.php");
			
			if($import['del']) unlink($file);
		}
	}
	
	if($import['del']) unlink($folder);
}



function getFolderList($uploadFolder) {
#############################
	$folders = array();
	global $cfg;
	global $L;
	
	$d = dir($uploadFolder);

	while($entry=$d->read()) {
		if(!ereg("^\.", $entry)) array_push($folders,$entry);
	}
	sort ($folders);
	reset ($folders);
	
	return $folders;
}


function getFtpFolderDetails($folder) {
############################
	include("lib/config.php");
	global $cfg;
	global $L;
	$folder = $_SERVER['DOCUMENT_ROOT'].$cfguploadfolder."/".$folder;
	
	$contents = getFolderList($folder);
	$contents['number'] = count($contents); 
	
	return $contents;
}

function listBatches() {
##########################
	global $cfg;
	global $L;
	$batches = array();
	$d = dir(realpath("batch"));
	$part = "info";
	
	while($entry=$d->read()) {
		if(substr($entry,-4) == ".php")  {

			include("batch/$entry");
			$batches[] = array(
				"file" => $entry,
				"title" => $title
			);
		}
	}
		
	sort ($batches);
	reset ($batches);
	return $batches;
}


function upload($upload) {
	global $cfg;
	global $L;
	include("lib/config.php");
	include("lib/mimetypes.php");
	global $_FILES;
	
	$x=0;
	
	
	
	for($i = 1; $i <= $_SESSION['n_uploads']; $i++) {
		if($file = $_FILES['upload']['tmp_name']["file".$i]) {
			// try to get filetype
			$realname = $_FILES['upload']['name']["file".$i];
			$fields['name'] = $upload["title".$i] ? $upload["title".$i] : $realname;
			
			$endung = strtolower(pathinfo($realname, PATHINFO_EXTENSION));
			$gettype = $mimetypes[$endung];
			$type = $gettype ? $gettype : "file";
			
			include("lib/upload_".$type.".php");
			$x++;
		}
	}
	return $report;
}


#  list_variantions  ###############
function listVariations($id) {
	global $cfg;
global $L;
	include($_SERVER['DOCUMENT_ROOT'].$cfg['env']['cmspath']."/lib/cfg.php");
	include("lib/config.php");
	
	$sql = "select * from ".$L->table_medialib." where parent = '$id' and copy = '1'";
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


# 02  getObjectType
function getObjectType($id) {
	global $cfg;
global $L;
	//include($_SERVER['DOCUMENT_ROOT'].$cfg['env']['cmspath']."/lib/init.php");
	include("lib/config.php");
	$sql = "select mime from ".$L->table_medialib." where id = '$id' LIMIT 1"; //echo $sql;
	$mime = mysql_fetch_row(mysql_query($sql));
	return $mime[0];
}


# 03  writeObject
function writeObject($fields) {
	global $L;
	//include($_SERVER['DOCUMENT_ROOT'].$cfg['env']['cmspath']."/lib/init.php");
	include("lib/config.php");
	while(list($name,$val) = each($fields)) {
		$str1 .= "$name, ";
		$str2 .= "'$val', ";
	}
	$str1 .= "date";
	$str2 .= "'".time()."'";

	$sql = "insert into ".$L->table_medialib." ($str1) values ($str2)";	
	mysql_query($sql);
	
	$insertid = mysql_insert_id();
	
	return $insertid;
}



function ListFolder($parent,$order=0,$current=0,$search=0,$width=0) {
###################################################
	global $L;
	$order = $order ? "order by '$order'" : "order by name,type";
	$where = $search ? "where name like '%$search%' or id like '%$search%' or info like '%$search%'" : "where parent = '$parent'";
	
	include("lib/config.php");
	$sql = "select * from ".$L->table_medialib." $where $order"; //echo $sql;
	$q = mysql_query($sql);
	while ($result = mysql_fetch_array($q)) {
		if($width) $result['name'] = $L->trimfilename($result['name'],$width);
		include("list_entry.php");
	}	
}


	
function createFolder($data) {
#####################################
	global $cfg;
	global $L;
	//include($_SERVER['DOCUMENT_ROOT'].$cfg['env']['cmspath']."/lib/init.php");
	include("lib/config.php");
	if($data[parent]) {
		$sqladd1 = ",parent";
		$sqladd2 = ",'$data[parent]'";
	}
	$timestamp = time();	
	$sql = "insert into ".$L->table_medialib." (name,info,date,mime$sqladd1) values ('$data[name]','$data[info]','$timestamp','folder'$sqladd2)";
	$result = mysql_query($sql);
	if($result) {
		$id = mysql_insert_id();
		header("Location:list.php?folderid=$id&refreshParent=$data[parent]");
	}
}



function getActiveFrame($id) {
####################################
	global $L;
	if($id) {
	//	include($_SERVER['DOCUMENT_ROOT'].$cfg['env']['cmspath']."/lib/init.php");
		include("lib/config.php");
		
		$i=0;
		$current = mysql_fetch_array(mysql_query("select parent from ".$L->table_medialib." where id = '$id' LIMIT 1"));
		if($parent = $current[parent]) {
			while($parent) {
				$previous = mysql_fetch_array(mysql_query("select parent from ".$L->table_medialib." where id = '$parent' LIMIT 1"));
				$parent = $previous[parent];
				$i++;
			}
		}
		return $i;
	}
}


function getObjectData($folderid) {
#################################
	global $cfg;
	global $L;
	
	$sql = "select * from ".$L->table_medialib." where id = '$folderid' limit 1";
	$data = mysql_fetch_array(mysql_query($sql));
	$result = $data;
	
	// anzahl der beinhalteten Ordner
	$sql_folder = "select COUNT(id) from ".$L->table_medialib." where parent = '$folderid' and mime = 'folder'";
	$count_folders = mysql_fetch_row(mysql_query($sql_folder));
	$result['folders'] = $count_folders[0];
	
	// anzahl der beinhalteten Dokumente
	$sql_documents = "select COUNT(id) from ".$L->table_medialib." where parent = '$folderid' and mime != 'folder'";
	$count_documents = mysql_fetch_row(mysql_query($sql_documents));
	$result['documents'] = $count_documents[0];
	
	//erstellungsdatum
	$result['date'] = strftime(getDay($result['date'])." %H:%M",$result['date']);

	// Änderungsdatum
	if($result['changed']) { $result['changed'] = strftime(getDay($result['changed'])." %H:%M",$result['changed']); } else { $result['changed'] = "keine Änderungen"; }
		
	return $result;
}


function updateObject($editFolder) {

	global $L;
	include("lib/config.php");
	$timestamp = time();
		
	// aktualisiere medialib
	$sql = "update ".$L->table_medialib." set 
		`name`='".mysql_real_escape_string($editFolder['name'])."', 
		`info`='".mysql_real_escape_string($editFolder['info'])."', 
		`parent` = '".mysql_real_escape_string($editFolder['parent'])."', 
		`changed`='".time()."', `editorgroup`='$editFolder[group]' $add where `id` = '$editFolder[id]' LIMIT 1";
	mysql_query($sql);

	// speichere Änderung im changes-table
	$sql = addslashes($sql);
	$sql2 = "insert into ".$L->table_medialibchanges." (object,user,sql) values ('$editFolder[id]','$userid','$sql')"; 
	mysql_query($sql2);
	
	
	if($editFolder['newparent']) {
		updateColumnChilds($editFolder['newparent']);
		updateTree($editFolder[parent]);
	} else {
		updateColumn($editFolder['id']);
	}
}



function droplistFolder($current,$selectthis=0) {
	global $cfg;
	global $L;

	$sql 	= "select * from ".$L->table_medialib." where mime = 'folder' order by name";
	$q 		= db_array($sql);
	
	foreach($q as $result) {
		$select = $result['id'] == $selectthis ? "selected" : "";
		if($result['id'] != $current) echo "<option value=\"$result[id]\" $select>$result[name]</option>";
	}
}



function deleteFolder($delete) {
	//global $cfg;
	global $L;
	
	include("lib/config.php");
	
	switch ($delete['fncpart']) {
		case "start":
			// nothing
			break;
			
		case "contents":
			// get folder-contents
			$contents = getObjectData($delete['id']);
			
			// wenn sich weitere mappen im folder befinden
			if($contents['folders'] or $contents['documents']) {
				$result['part'] = "contents";

			// andernfalls
			} else {
				updateTree($delete['id']);
				removeFolderContent($delete['id']);
				$result['formfile'] = "list_details.php";
				$result['part'] = "end";
			}
			break;

		case "end":
			if($delete['option']) {
				updateTree($delete['id']);

				// alle Inhalte sollen gelöscht werden
				if($delete[option] == "delete") {
					deleteChilds($delete['id']);
					removeFolderContent($delete['id']);

				// verschiebe inhalte durch ändern der parent-id
				} else {
					$sql = "update ".$L->table_medialib." set parent='$delete[option]' where parent = '$delete[id]'";
					db_query($sql);
					
					removeFolderContent($delete['id']);
				}
				$result['formfile'] = "list_details.php";
				$result['part'] = "end";

			} else {
				$result['error'] = "bitte wählen Sie einen Verbleib für die Inhalte dieser Mappe aus";
				$result['part'] = "contents";
			}
			break;
	}
	return $result;
}



function deleteChilds($parent) {
	global $cfg;
	global $L;
	$sql = "select * from ".$L->table_medialib." where parent = '$parent'";
	$q = mysql_query($sql);
	while($result = mysql_fetch_array($q)) {
		deleteChilds($result[id]);
		removeFolderContent($result['id']);
	}
}


function removeFolderContent($id) {
//	include("../../lib/init.php");
	global $db;
	global $L;
	$sql = "delete from ".$L->table_medialib." where id = '$id' LIMIT 1";

	$db->execute($sql);
	
	// lösche dateien
	exec("rm -r -f ".$_SERVER['DOCUMENT_ROOT'].IMAGES."/".$id);
}



?>