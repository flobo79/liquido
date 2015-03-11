<?php

// shortcut for old functions
$user = $_SESSION['user'];

setlocale (LC_TIME, $user['lang']);

// navigation-trigger
if (isset($_GET['setmod'])) { $_SESSION['current']['comp'] = $_GET['setmod'];  }
if (!isset($_SESSION['current']['comp'])) $_SESSION['current']['comp']  = "start";
if (!$_SESSION['components'][$_SESSION['current']['comp']]) $_SESSION['components'][$_SESSION['current']['comp']] = array();
if (isset($_GET['setmode'])) { $_SESSION['components'][$_SESSION['current']['comp']]['current'] = $_GET['setmode']; }

$comp = $_SESSION['current']['comp'];
$thiscomp = $_SESSION['components'][$comp];
$mode = $_SESSION['components'][$comp]['current'];

// dummy-mailversand zukünftig über klasse zu regeln
if(isset($mail['send'])) {
	$to = $mail['to'];
	$subject = $mail['subject'];
	$from = $mail['from'];
	
	
	for($i=1;$mail['message'][$i];$i++) {
		$message .= $mail['message'][$i];
	}
	if($from and $to and $message) {
		mail($to,$subject,$message,"from: vw-club<$from>");
		$mail['result'] = true;
	}
}


// functions zum maskieren/demaskieren von ids
function mask_id($id) {
	$id = $id * 29779;
	return $id;
}

function unmask_id($id) {
	$id = $id / 29779;
	return $id;
}


## setzt die letzte Änderung 
function touchEntry($data) {
	mysql_query("update $data[table] set date = '".time()."' where id = '$data[id]' LIMIT 1");
}

function unicode_to_entities_preserving_ascii( $unicode ) {

    $entities = '';
    foreach( $unicode as $value ) {
    
        $entities .= ( $value > 127 ) ? '&#' . $value . ';' : chr( $value );
        
    } //foreach
    return $entities;
    
} // unicode_to_entities_preserving_ascii


function trace($obj=0) {
	$pagedata['id'] = $obj;
	$pagedata['code'] = listobjects($pagedata,"public");

	// render html-code
	$html = parseCode($pagedata,$mode);
	echo $html;
}

function listobjects ($content,$part,$settable = 0) {
	include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/cfg.php");
	
	global $access;
	$css = new CSS();
	$incms = 1;
	
	$contentwidth = $content['width'];
	$cfgcmspath = "../../";
	
	$table = $settable ? $settable : $cfgtablecontentobjects;
	
	$svSQL = "select * 
				from $table
				where parent = '$content[id]' and del = '0' 
				order by rank";

	$fncpart = "load";
	
	// lade css-stile
	$styles = $css->readCss($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/css/objects.css");
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
	
	
	ob_start();
	
	echo "<div id=\"block$content[id]\">";
	
	if($part == "compose") {
		// formtag replace
		$searches  = array(
			2 => "<form ",
			3 => "</form>",
			4 => "<textarea"
		);
		$replaces = array(
			2 => "<!form! ",
			3 => "</!form!>",
			4 => "<textbereich"
		);
	}
	
	mysql_query("SET NAMES 'utf8'");

	$query = mysql_query($svSQL);	
	while ($result = mysql_fetch_array($query)) {
		$objpath = OBJECTSDIR.$result['type'].'/'.$result['layout'].'/';
		$objectid = $result['id'];
		include ($objpath.'functions.php');
		
		if($part == "compose") {
			//$result['text'] = str_replace($searches,$replaces,$result['text']);
			//$result['text2'] = str_replace($searches,$replaces,$result['text2']);
			//$result['text3'] = str_replace($searches,$replaces,$result['text3']);
			//$result['smalltext1'] = str_replace($searches,$replaces,$result['smalltext1']);
			//$result['smalltext2'] = str_replace($searches,$replaces,$result['smalltext2']);
			//$result['smalltext3'] = str_replace($searches,$replaces,$result['smalltext3']);
		}
		
		// setze ausgewählten style auf aktiv
		if($result['showstyles']) {
			$mystyles = $css_styles;
			$mystyles = ereg_replace('"'.$result['contents_css'].'">','"'.$result['contents_css'].'" selected>',$mystyles);
			$mystyles = ereg_replace("objid",$objectid,$mystyles);
		}
		
		// schneide punkt von css-class ab
		$result['contents_css'] = substr($result['contents_css'],1);
		
		echo "<div id=\"obj$objectid\" class=\"objbox\">";
		include ($objpath.'file.php');
		echo "</div>";
		
		
		// objekteigenschaften löschen
		$thisobject = "";
		
		//$update .= $result['id'].",";
		unset($result);
	}
	
	echo "</div>";
	
	$content = ob_get_contents();
	ob_end_clean();
	
	
	
	if($content) {
		echo $content;
	} else {
		echo "<span class=\"headline\">Es gibt noch keine Objekte</span>";
	}
}


function curl_string ($url){
#####################################
	$ch = curl_init(); 

	curl_setopt ($ch, CURLOPT_URL, $url); 
	curl_setopt ($ch, CURLOPT_HEADER, 1); 
	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
	
	$result = curl_exec ($ch);
	curl_close($ch);
	
	return $result;
}


function listthisobjects ($result) {
	global $cfg;
	global $cfgtablecontentobjects;
	
	ob_start();
		$i=0;
		
		mysql_query("SET NAMES 'utf8'");
		
		$contentwidth = "140";
		$svSQL = "	select 	* 
					from 	$cfgtablecontentobjects 
					where 	parent = '$result[text]' and del = '0' 
					order 	by rank";
		
		$fncpart = "build";	
		$query = mysql_query($svSQL);
		while ($result = mysql_fetch_array($query))
		{
			echo "<td>\n";
			$objectid = $result['id'];
			include (OBJECTSDIR."$result[type]/$result[layout]/file.php");
			echo "</td>\n";
			
			$i++;
			if($i == 3) {
				echo "</tr><tr>\n";
				$i=0;
			}
			$thisobject = "";
		}

		$code = ob_get_contents();
	
	ob_end_clean();
	
	return $code;
}



function loadAccessTable($user=false, $location) {
## lade Rechtetabelle #####################
	include(CONFIGDIR."cfg_mysql.inc.php");
	
	$user = $_SESSION['user'];
	
	if($user['id'] and $location) {
		$table = $dbprefix."_liquido_r_".$location;
		$sql = "select * from $table where egroup = '$user[groupid]'";
		$access = db_array($sql);

		return $access[0];
	} else {
		echo "<-- loadaccesstable: fehlerhafte parameter -->";
	}
}


function getDay($date) {
######  ermitteln des Tages eines Timestamps

	if(strftime("%D",$date) == strftime("%D",time())) {
		$day = "heute";
	} elseif (strftime("%D",$date) == strftime("%D",(time() - 86400))){
		$day = "gestern";
	} else {
		$day = strftime("am %d.%m.%y",$date);
	}
	return $day;
}



function rank ($rank) {
###########  rankingfunktion  
# input $rank[type][parent][rank][dir]

	$curr_rank = $rank['rank'];
	//$settable = db_table($rank['type']);
	$table = db_table($rank['type']);

	//richtung bestimmen
	switch ($rank['dir']) {
		case "up":
			$dir = "<";
			$ordertype = "desc";
			break;
		case "down":
			$dir = ">";
			break;
	}

	// bei rankings von seiten und gruppen
	if($rank['type'] == "contents" or $rank['type'] == "contentobjects") {
		$addon = " and `parent` = '$rank[parent]' ";
	}
	
	$addon = "and `parent` = '$rank[parent]' ";
	
	# frage ob es einen höheren oder niedrigeren datensatz gibt
	$svSQL = "select `id`,`rank` from $table where `rank` $dir '$curr_rank' $addon and del != '1' order by rank $ordertype";  
	//echo "<!-- $svSQL -->\n";
	$result = db_entry($svSQL);
	
	# wenn ja
	if($result[0]) {
		# setze die jetzige rankid in den anderen datensatz
		db_query("update $table set rank='$curr_rank' where id='$result[0]'");
		//echo "<!-- \"update $table set rank='$curr_rank' where id='$result[0]'\" -->\n";
		# und setze die rankid des anderen datensatzes in diesen datensatz
		//echo "<!-- \"update $table set rank='$result[1]' where id='$rank[id]'\" -->\n";
		db_query("update $table set rank='$result[1]' where id='$rank[id]'");
	}
}



function insert($data) {
	global $user;
	
	//rank-id ermitteln
	if(!$data['rank']) $data['rank'] = GetRank($data);	

	// soll gelogt werden?
	if($data['logtable']) {
		$logtable = $data['logtable'];
		$loginfo = $data['loginfo'];
		unset($data['logtable']);
		unset($data['loginfo']);	
	}	

	$table = db_table($data['table']);
	unset($data['table']);

	$data['date'] = time();
	$data['author'] = $user['id'];
	
	$svSQL = GetWriteSQL ($table, $data);
	
	if($logtable) logEntry($svSQL,$logtable,$loginfo);
	
	$result = mysql_query($svSQL);
	return  mysql_insert_id();
}


function edit($data) {
	$table = db_table($data['table']);
	$svSQL = GetUpdateSQL ($table, $data);
	$query = db_query($svSQL);

	// save changes
	logEntry($data['id'],$data['table'],$svSQL);
	return $svSQL;
}


function logEntry($obj,$table,$sql) {
##
	/*//include("cfg.php");
	if(in_array($table,$cfgtables['changetables'])) {

		global $user;
		$time = time();
		$table = "cfgtable".$table."changes";
		
		$sql= urlencode($sql);
		$sql = "insert into ".$$table." (obj,sql,user,date) values ('$obj','$sql','$user[id]','$time')";
		
		mysql_query($sql);
	}
	*/
}


function GetRank($get) {
	//include("cfg.php");

	$table = db_table($get['table']);
	
	$svSQL = "select MAX(rank) from $table";
	$result = db_entry($svSQL);
	$rankid = $result[0];
	
	$rankid++;

	return $rankid;
}


function formattime($timestamp) {
########################################
	setlocale(LC_TIME, "de_DE");
	$time = strftime("%d.%m.%y",$timestamp);
	return $time;
}

function list_child($data) {
########################################
	//include("cfg_mysql.inc.php");
	//openDatabase();
	$sql = "select * from ".db_table("contents")." where parent = '$data[parent]' and cgroup = '$data[cgroup]' and del != '1' order by rank";
	$query = mysql_query($sql);
	while($get = mysql_fetch_array($query)) {
		while(list($key,$val) = each($get)) {	
			$result[$get['id']]['$key'] = $val;
		}
	}
	mysql_free_result($query);
	return $result;
	
}

function getErrorHandler($errno, $errmsg, $filename, $linenum) {
##############################################
	$error = "Zeit: " .date("Y-m-d H:i:s"). "\n";
	$error .= "Meldung: " .$errmsg. "\n";
	$error .= "Datei: " .$filename. "\n";
	$error .= "Zeile: " .$linenum;
	//mail("bosselmann@gmail.com", "Error @ vwc.de", $error, "From: Liquido VWC<fb@media5k.de>");
}


function out($value,$output=0) {
	if(!$output) echo "<!-- ";
	if(is_array($value)) {
		if($output) echo "<pre>";
		print_r($value);
		if($output) echo "</pre>";
	} else {
		echo $value;	
	}
	if(!$output) echo "-->";
}


class Liquido {
	function Liquido() {
		global $cfg;
		$this -> db_register_tables();
		$this -> CONF = $cfg;
	}
	
	function getTemplates($current=0, $asArray = 0) {
		global $db;
		$return = '';
		$return .=  "<select name=\"template\" class=\"text\">\n
			<option value=\"0\">keine Vorlage ausgewählt</option>\n";
		$cfgtabletemplates = db_table('templates');
		
		$sql = "select * from $cfgtabletemplates where status != '0' order by title";
		$list = $db->getArray($sql);
		
		
		foreach($list as $entry) {
			$selected = $current == $result[id] ? " selected" : "";
			$return .= "<option value=\"$result[id]\" $selected>$result[title]</option>";
		}
		$return .= "</select>\n";

		return $asArray ? $list : $return;
}

	
	function getSystemURL($str, $reverse=0) {
		$search = array(" ","ä","ö","ü",'Ä','Ö','Ü',"ß",'é', '&');
		$replace = array("-","ae","oe","ue",'Ae','Oe','Ue',"ss",'e','und');
		
		if($reverse) {
			$searchx = $search;
			$search = $replace;
			$replace = $searchx;
		}
		
		return str_replace($search,$replace,$str);
	}
	
	
	function getTree($pageid) {
		global $db;
		$sql = "select id, title, parent from ".$this->table_contents." where parent = '$pageid' and del = 0 and type = 'page' order by rank";

		$result = $this -> db_array($sql);

		foreach($result as $key => $entry) {
			$result[$key]['childs'] = $this->getTree($entry['id']);
		}
		
		return $result;
	}
	
	function loadAccessTable($user,$location) {
	## lade Rechtetabelle #####################
		include(CONFIGDIR."cfg_mysql.inc.php");
		
		if($user['id'] and $location) {
			$table = $dbprefix."_liquido_r_".$location;
			$sql = "select * from $table where egroup = '$user[groupid]'";
			$access = db_array($sql);

			return $access[0];
		} else {
			echo "<-- loadaccesstable: fehlerhafte parameter -->";
		}
	}
	
	
	
	function db_register_tables() {
		include(CONFIGDIR."cfg_mysql.inc.php");
		
		foreach($cfgtable as $key => $table) {
			$tablename = "table_".$key;
			$this->$tablename = $table;	
		}
		
	}

	function db_table($table) {
		include (CONFIGDIR."cfg_mysql.inc.php");

		if(array_key_exists($table,$cfgtable)) return $cfgtable[$table];

		return $dbprefix."_liquido_".$table;
		//if(table_exists($table)) return $table;
		//die("table $table doesnt exists");
	}
	
	function table_exists($table) {
		include (CONFIGDIR."cfg_mysql.inc.php");
		
		if(!$this->knowntables) {
			$gettables = mysql_list_tables($dbname);
			while (list($temp) = mysql_fetch_array($gettables)) {
				$this->knowntables[] = $temp;
			}
		}
		
		if(in_array($table,$this->knowntables)) return true;
		return FALSE;
	}
	
	function db_query ($q,$db=0) {
		global $db;
		$this -> num_queries++;
		return $db -> execute(mysql_escape_string($q));
	}
	
	function db_entry($sql,$type=0,$db=0) {
		global $db;
		$settype = $type ? $type : MYSQL_ASSOC;
		$entry = $db -> getall($sql);
		return $entry[0];
	}
	
	function db_array($query,$type=0,$usedb=0) {
		global $db;
		if($usedb) $this->db_use($usedb);

		return $db -> getassoc($query);
	}
	
	function db_insert_id() {
		global $db;
		return $db -> insert_id();
	}
	
	function trimfilename($title,$length) {
		return (strlen($title) < $length) ? $title : substr($title,0,($bar = floor(($length-3) / 2)))."...".substr($title,-$bar);
	}
	function getDay($timestamp) {
		setlocale(LC_TIME, "de_DE");
		$time = strftime("%d.%m.%y",$timestamp);
		return $time;
	}
}

/* ERSTATZ FUNKTION FÜR RÜCKWÄRTS KOMPATIBILITÄT */

function textobject($obj) {
	$node = new Node($obj['result']['parent']);
	$node->textobject($obj);
}

function get_parents($obj) {
	$node = new Node();
	$node->parent = $obj['parent'];
	return $node->get_parents();
}

function parsePage($obj) {
	$parser = new Parser('<node:'.$obj['id'].'>', $obj['id']);
	return $parser->parse();
}

function parseCode($obj) {
	$parser = new Parser('<node:'.$obj['id'].'>', $obj['id']);
	return $parser->parse();
}

?>