<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by ultradigital.de 2009 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/


function newClass($obj) {
	global $thiscomp;
	global $user;
	global $db;
	$table = db_table('temp_structures');
	$lastid = $db->getRow("select max(id) from ".$table." where tpl = '".$thiscomp['temp']."'");	
	$lastid = $lastid[0];
	$lastid++;
	
	$write['title'] = $obj['title'];
	$write['date'] = time();
	$write['author'] = $user['id'];
	$write['tpl'] = $thiscomp['temp'];
	$write['obj'] = $lastid;
	
	$db->execute(GetWriteSQL ($table, $write));
	echo json_encode(array('id' => $db->insert_id(), 'obj' => $lastid));
}

function delClass($obj) {
	global $db;
	$db->execute("delete from ".db_table('temp_structures')." where id = '".intval($obj['id'])."' LIMIT 1");
}

function loadClass($obj) {
	global $db;
	global $cfgtableclasses;
	echo JSON_encode($db->getRow("select * from ".db_table('temp_structures')." where id = '".intval($obj['id'])."' LIMIT 1"));	
	
}

function saveClass($obj) {
	global $db;
	$obj['code'] = preg_replace("/\+/", "%2B", $obj['code']);
	$db->getRow("update ".db_table('temp_structures')." set 
		`code` = '".mysql_real_escape_string(utf8_encode(urldecode($obj['code'])))."', 
		`title` = '".mysql_real_escape_string($obj['title'])."', 
		`p1`= '".mysql_real_escape_string($obj['p1'])."', 
		`p2`= '".mysql_real_escape_string($obj['p2'])."', 
		`p3`= '".mysql_real_escape_string($obj['p3'])."',
		`info`= '".mysql_real_escape_string($obj['info'])."'  
		where `id` = '".intval($obj['id'])."' LIMIT 1");
	
	$parser = new Parser();
	$parser->setHtml(utf8_encode(urldecode($obj['code'])));
	
	echo $parser->parse();
	
}

function previewClass($obj) {
	global $db;
	$class = $db->getRow("select * from ".db_table('temp_structures')." where id = '".intval($obj['id'])."' LIMIT 1");
	echo $class['code'];
}


function listClasses () {
	global $db;
	$list = $db->getAssoc("select * from ".db_table('temp_structures')." where tpl = '".$_SESSION['thiscomp']['temp']."' order by title");
	return $list;
}



?>