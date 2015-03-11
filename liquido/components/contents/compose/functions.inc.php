<?php
/* 
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      www.media5k.de     __/ _
_/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __
/ __/ __/   media5k 2003 | info@media5k.de    __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ 
*/


// set node into compose mode
$node->compose = true;

if(isset($_GET['overridelock']) and $access['c18']) {
	db_query("update $cfgtablecontents set `locked` = '' where id = '$thiscomp[id]' LIMIT 1");
	header('location:?');
}

if ($setobjecttype) { 
	$_SESSION['components'][$comp]['objecttype'] = $setobjecttype;
	$thiscomp = $_SESSION['components'][$comp];
}

if ($_GET['delpic'] and $access['c14']) del_pic($_GET['delpic']);

function imgDetails ($o) {
	global $db;
	$data = $db->getRow('select * from '.db_table('contentimgs')." where id = '".intval($o['id'])."' LIMIT 1");
	$object = $db->getRow('select * from '.db_table('contentobjects')." where id = '".($data['cid'])."' LIMIT 1");
	$size = getimagesize(DOCROOT.IMAGES."/".$data['cid']."/".$data['libid']."/thumbnail.jpg");
	
	include(dirname(__FILE__)."/imgDetails.php");
}

function updateImage($o) {
	global $db;
	require_once(DOCROOT.LIQUIDO."/lib/class_transform.php");
	
	$data = $db->getRow('select * from '.db_table('contentimgs')." where id = '".intval($o['id'])."' LIMIT 1");
	
	$sql = 'update '.db_table('contentimgs')." set `link` = '".mysql_real_escape_string($o['link'])."' where id =".($data['id'])." LIMIT 1";
	$db->execute($sql);
	
	$sql = 'update '.db_table('contentobjects')." set 
		`text2` = '".intval($o['margin'])."',
	  	`smalltext3` = '".($o['pos'] === 'left' ? 'left' : 'right')."'
		 where `id` = ".intval($data['cid'])." LIMIT 1";
	$db->execute($sql);
	
	$path = DOCROOT.IMAGES."/".$data['cid']."/".$data['libid'];
	$imageTransform = new imageTransform;
	$imageTransform->resize($path."/original.jpg", intval($o['width']), 1000, $path."/thumbnail.jpg");
	
	parkPage($o['id']);
}

function delObj($obj) {
	$trash['id'] = floor($obj['id']);
	$trash['type']="contentobjects";

	movetotrash($trash);
	parkPage($obj['id']);
}


function updateOrder($obj) {
	global $thiscomp;
	$objects = explode(',',$obj['order']);
	$page = $thiscomp['id'];
	
	$t = db_table("contentobjects");
	$rank = 1;
	
	foreach($objects as $id) {
		$sql = "update `$t` set `rank` = '".$rank++."' where `id` = ".floor($id)." LIMIT 1";
		db_query($sql);
	}
	
	parkPage($page);
}

function listcontents($title,$curr) {
	echo "<select name=\"$title\" class=\"text\">
		";
	echo "<option value=\"\" $selected></option>\n";

	mysql_query("SET NAMES 'utf8'");

	$sql = "select id,title,type,parent from $cfgtablecontents where del = '0' order by type,title";
	$query = mysql_query($sql);


	while ($result = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$add = $result['type'] == "group" ? "- " : "";
		$selected = $curr == $result['id'] ? "selected" : "";
		echo "<option value=\"$result[id]\" class=\"$class\" $selected>$add $result[title]</option>
		";
	}
	echo "</select>"; 
}


function lockObject($objid) {
	global $user;
	$lock = time().":".$user['id'];
	mysql_query("update ".db_table("contents")." set locked = '$lock' where id = '$objid'");
}


function listArticles($current) {
	global $cfgtablecontents;
	global $db;
	
	$sql = "select * from $cfgtablecontents where del != '1' and id != '$current' and type = 'page' order by title";
	$articles = $db->getArray($sql);

	return $articles;
}


function insertPicLink($id,$width,$height) {
	echo "<a href=\"#\" onClick=\"openLibrary($id,'selectimg[id]=$id&selectimg[tnwidth]=$width&selectimg[tnheight]=$height'); return false\">&raquo; Bild ausw&auml;hlen</a>
	";
}

class InsertWrap extends Node {
	var $data = '';
	var $result = '';

	function InsertWrap () {
		$this->Node();	
	}
	
	function insert() {
		global $access;
		$css = new CSS();
		$incms = 1;
		
		$contentwidth = $this->width;
		$cfgcmspath = "../../";
		
		// lade css-stile
		$styles = $css->readCss(DOCROOT.LIQUIDO."/css/objects.css");
		
		if($styles) {
			reset($styles);
			$css_styles = "<select name=\"objectdata[objid][contents_css]\" class=\"css_box\">\n";
			$css_styles .= "	<option value=\"\"></option>\n";
			foreach($styles as $key => $style) {
				// ohne id-styles
				if(preg_match("/^\./",$style['title'])) {
					$title = substr($style['title'],1);
					$css_styles .= "	<option value=\"".$style['title']."\">".$title."</option>\n";
				}					
			}
			$css_styles .= "</select>";
			$mystyles = $css_styles;
			
		} else {
			echo "Stile nicht geladen";
		}
		
		ob_start();
			// NOTE: SORRY ABOUT THE MESS, BUT BACKWARDS COMPAT!!
			$data = $this->data;
			$part = "compose";
			$insert = true;
			$cfgcmspath = $_SERVER['DOCUMENT_ROOT'].LIQUIDO;
			$contentwidth = '100%';
			$objectid = $this->result['id'];
			$result = $this->result;

			if(file_exists(OBJECTSDIR.$data['type']."/".$data['obj']."/functions.php")) include(OBJECTSDIR.$data['type']."/".$data['obj']."/functions.php");
			include(OBJECTSDIR.$data['type']."/".$data['obj']."/file.php");
			$html = ob_get_contents();
			unset($part,$objectid);
		ob_end_clean();
		
		return $html;
	}
}


function insertObject($data) {
	$user = $_SESSION['user'];
	global $db;
	global $access;
	global $cfg;
	global $node;
	global $contentwidth;
	
	$css = new CSS;	
	$table = db_table('contentobjects');
	
	$styles = $css->readCss(DOCROOT.LIQUIDO."/css/objects.css");
	
	if($styles) {
		reset($styles);
		$css_styles = "<select name=\"objectdata[objid][contents_css]\" class=\"css_box\">\n";
		$css_styles .= "	<option value=\"\"></option>\n";
		foreach($styles as $key => $style) {
			// ohne id-styles
			if(preg_match("/^\./",$style['title'])) {
				$title = substr($style['title'],1);
				$css_styles .= "	<option value=\"".$style['title']."\">".$title."</option>\n";
			}					
		}
		$css_styles .= "</select>";
		
	} else {
		echo "Stile nicht geladen";
	}
	// load details from parent node
	
	$data['date'] = time();
	$data['author'] = $user['id'];
	$data['layout'] = $data['obj'];
	$data['parent'] = $node->id;
	
	$db->execute(GetWriteSQL ($table, $data));
	$newid = $db->insert_id();
	$result = $db->getRow("select * from $table where id = ".$newid." LIMIT 1");

	// put loading of content object into the wrapper to give
	// $this context to object functions
	$insert = new InsertWrap();
	$insert->data = $data;
	$insert->result = $result;
	$insert->contentwidth = $node->width;
	
	$return = array();
	$return['html'] = $insert->insert();
	$return['id'] = $newid;
	
	echo json_encode($return);
}

function insertImage($obj) {
	if(isset($obj['image']) && isset($obj['obj'])) {
		require_once(DOCROOT.LIQUIDO."/lib/class_transform.php");
		
		$obj_id = substr($obj['obj'], 3);
		if(!intval($obj_id)) return;
		
		$table = db_table("contentimgs");
		$pic = db_query("insert into ".$table." set
			`libid` = '".intval($obj['image'])."', 
			`cid` = '".($obj_id)."', 
			`info` = ''");
		$id = db_insert_id();
		
		db_query('update '.db_table('contentobjects')." set `text2`='5', `smalltext3` = 'left' where `id` = '".($obj_id)."' LIMIT 1");
		
		if(!file_exists(IMAGESDIR.$obj_id)) mkdir(IMAGESDIR.$obj_id,0777);
		if(!file_exists(IMAGESDIR.$obj_id."/".$obj['image'])) mkdir(IMAGESDIR.$obj_id."/".$obj['image'],0777);
		$folder = IMAGESDIR.$obj_id."/".$obj['image'];
		$source = $folder."/original.jpg";
		
		// copy original to new folder
		if(file_exists(DOCROOT.MEDIALIB."/".$obj['image']."/original.jpg")) {
			copy(DOCROOT.MEDIALIB."/".$obj['image']."/original.jpg", $source);
		} else {
			copy(DOCROOT.MEDIALIB."/".$obj['image']."/small.jpg", $source);
		}
		
		copy(DOCROOT.MEDIALIB."/".$obj['image']."/small.jpg", $folder.'/small.jpg');
		
		$img['path'] = IMAGESDIR.$obj_id."/".$obj['image'];
		$img['tnwidth'] = $obj['objectdata['.$obj_id.'][tnwidth]'];
		$img['source'] = $image_src;
		
		$imageTransform = new imageTransform;
		$imageTransform->resize($source, 200, 500, $folder.'/thumbnail.jpg');

		$return = array();
		$return['id'] = $id;
		$return['link'] = IMAGES."/".$obj_id."/".$obj['image']."/thumbnail.jpg";
		
		echo json_encode($return);
	}
}


/** this method is used to draw **/
function loadContentobject($obj) {
	$node = new Node($obj['id']);
	$node->compose = $obj['mode'] == 'compose' ? true : false;
	$node->request = $obj;
	
	echo $node->listobjects($obj['obj']);
}

function listTools ($content) {	
	$dir = OBJECTSDIR;
	$d = dir($dir);
	echo "<ul>";
	while($entry=$d->read()) {
		if(!ereg("^\.",$entry)) {
			$title = file($dir.$entry."/info.txt");
			echo "<li class=\"acc_toggle\"><b>$title[0]</b>
			<ul class=\"acc_content\">
			";
				$xd = dir($dir.$entry);
				while($xentry=$xd->read()) {
					if(is_dir($dir.$entry."/".$xentry) and !ereg("^\.",$xentry)) {
						$objcfg = file($dir.$entry."/".$xentry."/info.txt");
						if($objcfg[0]) {
							echo "<li onclick=\"top.content.middle.insert('$entry','$xentry');\">&nbsp;".(trim($objcfg[0]))."</li>";
						}
					}
				}
			echo "</ul></li>";
		}
	}
	echo "</ul>";
}


function update ($upload) {
	global $db;
	
	// set page to edited
	parkPage($upload['parent']);
	$parent = getdata($upload['parent']);
	$table_objects = db_table("contentobjects");
	
	
	
	// Änderungsdatum schreiben
	db_query("update ".db_table("contents")." set `changed` = '".time()."' where `id` = '$parent[id]' LIMIT 1"); 
	
	//objektestring in IDs zerlegen
	$object = explode(",",$upload['objects']);
	
	foreach($upload['data'] as $name => $object) {
		$updatedata = array();
		$id = substr($name,3);
		$entry = $upload['data']['obj'.$id];
		$object = db_entry("select * from ".$table_objects." where id = '".$id."' LIMIT 1");
		
		if(is_array($entry)) {
			foreach($entry as $fieldname => $value) {
				if(array_key_exists($fieldname, $object)) {
					 $updatedata[$fieldname] = urldecode($entry[$fieldname]);
				}
			}
			
			$fncpart = "update";
			if(file_exists(realpath($thisfile = OBJECTSDIR."$object[type]/$object[layout]/functions.php"))) include($thisfile);
			
			$updatedata['id'] = $id;
			
			$svSQL = GetUpdateSQL ($table_objects, $updatedata);
			db_query($svSQL);
		}
	}
	
}

function del_pic($delpic) {
	if(!intval($delpic['picid'])) die('wrong id');
	$table = db_table("contentimgs");
	$pic = db_entry("select * from ".$table." where id = '$delpic[picid]'");
	if($pic['libid'] != "") {
		$picdir = $_SERVER['DOCUMENT_ROOT'].IMAGESDIR.$pic['cid']."/".$pic['libid'];
		$shc = "rm -r $picdir";
		
		exec($shc);
		
		//datensatz löschen
		db_query("delete from $table where id = '$delpic[picid]'");
	}
}


?>