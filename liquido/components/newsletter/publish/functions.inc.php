<?php

if(intval($publish['id'])) {
	updateLetter($publish['id']);
}

function updateLetter($id) {
	global $cfg;
	global $db;
	$db->execute("update `".$cfg['tables']['nlcontents']."` set `status` = '4' where `id` = '$id' LIMIT 1");
}

function getLetter($content) {
	global $path;	
	global $cfg;
	
	$areas = getAreas();
	$check = array();
	global $check;	
	foreach($areas as $value) $check[$value['area']['id']] = 1;
	reset($areas);
	
	$id = $content['id'];
	$contentwidth = $content['width'];
	
	$incms = 1;
	$useob = "1";
	
	$s = array(); // list of select field elements
	$mp = array(); // list of interest areas
	
	$node = new Node($id);
	$node->publishing = true;
	$node->compose = false;
	$node->s = array();
	$node->mp = array();
	$node->listobjects();
	
	// hole template
	if($content['template']) {
		$template = getTemplate($node->template);
	}
	
	$objects = array_merge(array(array('html' => $template[0])), $node->objects);
	$objects[] = array('html' => $template[1]);
	
	$parser = new Parser();
	foreach($objects as $k => $o) {
		$parser->html = $o['html'];
		$objects[$k]['html'] = $parser->parse();
	} 
	
	return $objects;
}



function getPagedata($content) {
################################
	global $path;
	global $cfg;
	//include($path."../../lib/cfg.php");

	// PageInformationen
	$sql = "select * from `".$cfg['tables']['nlcontents']."` where id='$content' limit 1";
	$content = mysql_fetch_array(mysql_query($sql));

	// Bereichinfos laden
	$nlobj['id'] = $content;
	$content['areasx'] = getAreas ($nlobj);
	
	// erstellungsdatum
	$content['createdate'] = strftime(getDay($content['date'])." %H:%M",$content['date']);
	
	// änderungsdatum
	if($changes['date']) { $content['changedate'] = strftime(getDay($changes['date'])." %H:%M",$changes['date']); } else { $content['changedate'] = "keine �nderungen"; }
	
	// parents
	$content['parents'] = getparents($content['parent']);

	return $content;
	print_r($content);
}


function listFields() {
########################
	global $path;
	global $cfg;
	global $dbname;
	
	$fields = mysql_list_fields($dbname, $cfg['tables']['nlabos']);
	$columns = mysql_num_fields($fields);
	
	for ($i = 0; $i < $columns; $i++) {
		echo mysql_field_name($fields, $i) . "\n";
	}
}

?>