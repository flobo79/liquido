<?php 

function parseTemplate($template) {
	global $replaces;
	return  parseCode($obj, $template['code'], $replaces);
}

function parsePage($obj,$content) {
	global $fmode;

	if ($fmode == "compose") {
		// simply do nothing
		//$code = listobjects($obj,"compose");
	} else {
		$replaces = get_replaces($obj);
		$content = parseCode($obj,$content,$replaces);
	}

	return $content;
}

function mergeCode($template,$content) {
	return str_replace("<content>",$content,$template);
}


function get_replaces($obj) {
// funktion ausgelagert um mehrfaches laden zu vermeiden
	$replaces = array(
		0 => CONTAINERDIR.$obj['template']['id']."/",
		1 => CONTAINERDIR."9999/",
		2 => $obj['createdate'],
		3 => $obj['changedate'],
		4 => $obj['template']['id'],
		5 => "", //traceLocation($obj),
		6 => $obj['id'],
		7 => $frame,
		8 => $cfg['env']['host']
	);
	return $replaces;
}


function parseCode($obj,$code,$replaces=0) {
	//global $cfg;
	if(!$replaces) $replaces = get_replaces($obj);
	
	// classes und tags
	$code = filterObj($code);

	$searches = array(
		0 => "<container>",
		1 => "<xcontainer>",
		2 => "<createdate>",
		3 => "<changedate>",
		4 => "<template>",
		5 => "<location>",
		6 => "<page>",
		7 => "<frame>",
		8 => "<host>"
	);
	
	// Ersetzen
	$code = str_replace($searches,$replaces,$code);
	return $code;
}


function filterObj($code) {
#############################
	// suche nach klassen
	$pattern = array("/<(xstructure|structure|xclass|class|xcontainer|container|page):(\d+)>/","/#(xstructure|structure|xclass|class|xcontainer|container|page):(\d+)#/");
	$replacement = "parseTag";
	$code = preg_replace_callback($pattern,$replacement,$code);

	return $code;
}

function parseTag ($match) {
	include("cfg.php");
	global $frame;
	global $temp;
	global $fe;
	if(!$frame) $frame = $temp['id'];
	
	$id = $match[2];
	$type = $match[1];

	switch($type) {
		case "page":
			
			break;
		case "structure":
			$sql = "select code from $cfgtablestructures where tpl = '$frame' and obj = '$id' LIMIT 1";
			break;
		case "xstructure":
			$sql = "select code from $cfgtablestructures where tpl = '9999' and obj = '$id' LIMIT 1";
			break;
		case "container":
			$sql = "select title from $cfgtablecontainer where tpl = '$frame' and obj = '$id' LIMIT 1";
			break;
		case "xcontainer":
			$sql = "select title from $cfgtablecontainer where tpl = '9999' and obj = '$id' LIMIT 1";
			break;
		case "class":
			$sql = "select code from $cfgtableclasses where tpl = '$frame' and obj = '$id' LIMIT 1";
			break;
		case "xclass":
			$sql = "select * from $cfgtableclasses where tpl = '9999' and obj = '$id' LIMIT 1";
			break;
	}
	
	if($sql) {
		$obj = mysql_fetch_array(mysql_query($sql));
		if($obj) {
			$code = ($type == "class" or $type == "xclass") ? parseClass($obj) : $obj[0];
			$code = ($type == "container") ? "<container>".$code : $code;
			$code = ($type == "xcontainer") ? "<xcontainer>".$code : $code;
			if($code) $code = filterObj($code);
		} else {
			$code = "<!-- $type $id nicht vorhanden -->";
		}
	}
	return $code;
}


function parseClass($obj) {
#############################
	include("cfg.php");
	$id = $obj['id'];
	//$obj['code'];
	ob_start();
		try {
			eval($obj['code']);
		}
		catch(Exception $e) {  }
		
		$code = ob_get_contents();
	ob_end_clean ();
	
	if($code) $code = parseCode($obj, $code);
	return $code;
}

?>