<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/


//   Trigger   
//################################################################
// wenn zeitgesteuert, hole datum


$temp = $_SESSION['components'][$comp]['temp'];
$n_uploads = $_SESSION['components'][$comp]['n_uploads'];


########## load accesstable
$access = loadAccessTable($user,"contents");


if ($swap = $_POST['swap']) {
	swap_obj($swap);
	//$update_leftpane = 1;
}

if($delobj = $_GET['delobj']) {
	delobj($delobj,$temp);
}

if ($_GET['trash']) {
	trash($_GET['trash']);
	$select['id'] = "";
}


if(!$n_uploads) $_SESSION['components'][$comp]['n_uploads'] = 1;

if ($_GET['crease']) {
	$n_uploads = $n_uploads + $crease;
	$_SESSION['components'][$comp]['n_uploads'] = $n_uploads;
	header("Location:?showupload=1");
}

if ($upload = $_POST['upload']) upload($upload);

if($import) {
	importContainer($thiscomp['temp']);
	//header("Location:?");
}

/**************************************************
        Funktionen                       		*
**************************************************/

function swap_obj($swap) {
// vertauscht templates anhand der ids
	global $c_obj;
	$id = $c_obj;
	include("../../../lib/cfg.php");

	mysql_query("update $cfgtablecontainer set obj = '9999' where obj = '$id' LIMIT 1");
	mysql_query("update $cfgtablecontainer set obj = '$id' where obj = '$swap' LIMIT 1");
	mysql_query("update $cfgtablecontainer set obj = '$swap' where obj = '9999' LIMIT 1");
}

function trash($obj) {
#######################################
	include("../../lib/cfg.php");

	// verbleib der verwendungen
	if($trash[todo] == "setoffline") {
		$sql_todo = "update $cfgtablecontents set template = '', status='0' where template = '$obj[id]'";
	} else {
		$sql_todo = "update $cgftablecontents set template = '$obj[todo]' where template = '$obj[id]'";
	}
	mysql_query($sql_todo);
	
	// lösche template
	mysql_query("delete from $cfgtabletemplates where id = '$obj[id]'");
	
	// lösche changes
	mysql_query("delete from $cfgtabletemplateschanges where tpl = '$obj[id]'");
}



function delobj($id,$temp) {
#####################################
	include("../../../lib/cfg.php");

	if($temp and $id != "") {
		// hole noch schnell den dateinamen
		$file = mysql_fetch_array(mysql_query("select title from $cfgtablecontainer where id = '$id' LIMIT 1"));
		
		
		// löschen datenbankeintrag
		mysql_query("delete from $cfgtablecontainer where id = '$id' LIMIT 1");
		
		if($file['title']) {
			// lösche datei
			unlink($_SERVER['DOCUMENT_ROOT'].CONTAINERDIR.$temp."/".$file['title']);
		}
	}
}


#  upload  ##############
function upload($upload) {
	include("../../../lib/cfg.php");
	// registriere uploaded files
	global $HTTP_POST_FILES;
	global $user;
	$time = time();
	
	// make it easyier to handle
	$upl = $_FILES['upload'];
	$x=0;

	$lastid = mysql_fetch_row(mysql_query("select max(obj) from $cfgtablecontainer where tpl = '$upload[id]'")); //echo "select max(id) from $cfgtablecontainerobjects where tpl = '$upload[id]'";	
	$lastid = $lastid[0]+1;
	
	for($i=1;$upl['name']['file'.$i];$i++) {
			
		$filename = $upl['name']['file'.$i];
		$tmp_name = $upl['tmp_name']['file'.$i];
		
		$insert = "insert into $cfgtablecontainer (obj,title,tpl,date,author) values ('$lastid','$filename','$upload[id]','$time','$user[id]')";
		mysql_query($insert);
		$id = mysql_insert_id();		
					
		copy($tmp_name, $_SERVER['DOCUMENT_ROOT'].CONTAINERDIR."$upload[id]/$filename");
		
		$lastid++;
		$x++;
	}
}


function importContainer($id) {
##################################
	include("../../../lib/cfg.php");

	$time = time();
	global $user;
	
	$dir = CONTAINERDIR."$id/import";
	$d = dir($dir);
	while($entry=$d->read()) {
		if($entry != ".." and $entry != ".")  {
			// speicher in datenbank
			mysql_query("insert into $cfgtablecontainer (title,tpl,date,author) values ('$entry','$id','$time','$user[id]')");
			$entryid = mysql_insert_id();		
			
			// setze objectid
			mysql_query("update $cfgtablecontainer set obj = '$entryid' where id = '$entryid'");
			
			// bewege datei an den rechten fleck
			$move = "mv $dir/$entry ../../../container/$id/$entry";
			exec($move);
		}
	}
	
}


function getImportObjects($id) {
#####################################
	if(is_dir($dir = CONTAINERDIR."$id/import")) {
		$d = dir($dir);
		while($entry=$d->read()) {
			if($entry != "." and $entry != "..") $num++;
		}
		return $num;
	}
}


function getObject ($obj) {
###################################
	include("../../../lib/cfg.php");
	$sql = "select * from $cfgtablecontainer where id = '$obj' LIMIT 1"; //echo $sql;
	$obj = mysql_fetch_array(mysql_query($sql));
	$obj['mime'] = getMimeType ($obj['title']);	
	
	return $obj;
}


function getMimeType ($file) {
##################################
	$types = array(
		"image" => "jpg gif png",
		"pdf"	=> "pdf",
		"css"	=> "css",
		"file"	=> "exe zip" 
	);

	$file = explode(".",$file);

	while (list($key,$val) = each($types)) {
		if(eregi($file[1],$val)) {
			$file[0] = $key;
			$supported = 1;
			break;
		}
	}
	if(!$supported) $file[0] = "notsupported";
	return $file;
}



function getObjects ($id,$current=0) {
###################################
	include("../../../lib/cfg.php");

	$obj = array();

	if($current) $where = "and id != '$current[id]'";

	$sql = "select title,id,obj from $cfgtablecontainer where tpl = '$id' $where order by obj";
	$q = mysql_query($sql);
	while ($result = mysql_fetch_array($q)) {
		array_push($obj,$result);
	}
	
	return $obj;
}

?>