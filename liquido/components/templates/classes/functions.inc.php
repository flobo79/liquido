<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/



function newClass($obj) {
	global $thiscomp;
	global $user;
	global $db;
	$table = db_table('temp_classes');
	$lastid = $db->getRow("select max(id) from ".$table." where tpl = '".$thiscomp['temp']."'");	
	$lastid = $lastid[0];
	$lastid++;
	
	$write['title'] = $obj['title'];
	$write['date'] = time();
	$write['author'] = $user['id'];
	$write['tpl'] = $thiscomp['temp'];
	$write['obj'] = $lastid;
	
	$sql = GetWriteSQL ($table, $write);
	$db->execute($sql);
	$newclassid = $db->insert_id();
	
	echo json_encode(array('id' => $newclassid, 'obj' => $lastid, 'title' => $obj['title']));
}

function delClass($obj) {
	global $db;
	$db->execute("delete from ".db_table('temp_classes')." where id = '".intval($obj['id'])."' LIMIT 1");
}

function loadClass($obj) {
	global $db;
	global $cfgtableclasses;
	
	$db->SetFetchMode(ADODB_FETCH_ASSOC);
	$data = $db->getRow("select * from ".db_table('temp_classes')." where id = '".intval($obj['id'])."' LIMIT 1");
	//$data['code'] = str_replace(array('}','{'), array('\}','\{'), $data['code']);
	echo JSON_encode($data);	
	
}

function saveClass($obj) {
	global $db;
	
	$obj['code'] = preg_replace("/\+/", "%2B", $obj['code']);

	$db->getRow("update ".db_table('temp_classes')." set 
		`code` = '".mysql_real_escape_string(urldecode($obj['code']))."', 
		`title` = '".mysql_real_escape_string($obj['title'])."'
		where `id` = '".intval($obj['id'])."' LIMIT 1");	
}

function previewClass($obj) {
	global $db;
	$class = $db->getRow("select * from ".db_table('temp_classes')." where id = '".intval($obj['id'])."' LIMIT 1");
	
	echo eval($class['code']);
}


function listClasses () {
	global $db;
	$list = $db->getAssoc("select * from ".db_table('temp_classes')." where tpl = '".$_SESSION['thiscomp']['temp']."' order by obj");
	return $list;
}



?>