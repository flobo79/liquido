<?php

// trigger

if($type == "rec" and is_array($trash)) {
	recycle($trash);
	$update_leftpane = true;
}

if($type == "del" and is_array($trash)) {
	del($trash);
	$update_leftpane = true;
}


function del($obj) {
	if(is_array($obj)) {
		foreach($obj as $type => $objs) {
			switch ($type) {
				case "contents": case "area":
					foreach($objs as $id) {
						del_page($id);
					}
				break;
				case "contentobjects":
					foreach($objs as $id) {
						del_object($id);
					}
				break;
			}
		}
	}
}

// lösche gesamte newsletter ausgabe
function del_page($id) {
	global $cfg;
	global $db;
	
	// delete corresponding channels
	$areas = $db->getArray("select * from ".$cfg['tables']['contents']." where type = 'area' and parent = '$id'");
	if($areas) {
		foreach($areas as $area) {
			del_page($area['id']);
		}
	}
	
	// delete contentobjects
	$svSQL = "select id from ".$cfg['tables']['contentobjects']." where parent = '$id'";
	$objects = $db->getArray($svSQL);

	foreach($objects as $object) {
		del_object($object['id']);
	}
	
	// delete publishs and Statistics
	$sqlIssues = "select pb_id from  ".$cfg['tables']['nlpublishs']." where `pb_issue` = '$id'";
	$issues = $db->getArray($sqlIssues);

	foreach($issues as $issue) {
		$db->execute("delete from ".$cfg['tables']['nllinktracking']." where `pb_id` = '$issue[pb_id]'");
		$db->execute("delete from ".$cfg['tables']['nlpublishs']." where `pb_id` = '$issue[pb_id]'");
	}
	
	// delete issue
	$db->execute("delete from ".$cfg['tables']['contents']." where id = '$id'");
}


function del_object($id) {
	global $cfg;
	global $db;
	$objecttable = $cfg['tables']['contentobjects'];
	$thisobject = $db->con->getRow("select type,layout from `$objecttable` where `id` = '$id' LIMIT 1");
			
	if($thisobject['layout']) {
		$fncpart="delobject";
		include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."_objects/$thisobject[type]/$thisobject[layout]/functions.php");
	}
}

function getTrash() {
	global $cfg;
	global $user;
	global $db;
	
	// contents
	$trash['contents'] = $db-> getArray("select id,title,type from ".$cfg['tables']['contents']." where del = '$user[id]' order by type,rank,title");
	
	$fncpart = "listtrash";
	
	// objects
	$sql = "select	a.id, a.layout, b.title as parent, a.text, a.type as objecttype 
				from 	".$cfg['tables']['contentobjects']." as a,
						".$cfg['tables']['contents']." as b
				where 	a.del = '$user[id]' and a.parent = b.id";
			
	$trash['objects'] = $db->getArray($sql);
	
	foreach($trash['objects'] as $key => $result) {
		if(file_exists($_SERVER['DOCUMENT_ROOT'].LIQUIDO.'_objects/'.$result['objecttype'].'/'.$result['layout'].'/functions.php')) {
			include_once($_SERVER['DOCUMENT_ROOT'].LIQUIDO.'_objects/'.$result['objecttype'].'/'.$result['layout'].'/functions.php');
			
			$title = file(OBJECTSDIR."$result[objecttype]/$result[layout]/info.txt");
				
			$trash['objects'][$key]['title'] = $title[0];
			$trash['objects'][$key]['preview'] = $result['text'];
		} else {
			$db->execute("delete from `".$cfg['tables']['contentobjects']."` where del != '0' and `id` = '$result[id]' LIMIT 1");
			unset($trash['objects'][$key]);
		}
	}

	return $trash;
}




function recycle($obj) {
#############################################
	global $cfg;
	global $user;
	global $db;
	
	foreach($obj as $key => $val) {
		foreach ($val as $x => $id) {
			$db->execute("update `".$cfg['tables'][$key]."` set del='0' where `id` = '$id' LIMIT 1");
		}
	}
}



?>