<?php

//   Trigger
//################################################################
if($remove) 	$removeresult 	= removeabo($remove);
if(isset($_GET['del'])) delabo($del);
if($insertgroup) $result		= insertgroup($insertgroup);
if($delgroup) $result			= delgroup($delgroup);

// funktionen
//########################################################################

function importfile($file) {
	$SID = session_id();
	$target = $_SERVER['DOCUMENT_ROOT'].LIQUIDO."/templates_c/".$SID.".csv";
	if(file_exists($target)) unlink($target);
	copy($file['tmp_name'],$target);
	
	return $target;
}

function import($data) { 
	global $cfg;
	global $db;
	/* Importfunktion importiert jeden Datensatz einzeln um funktionen auf dem Datensatz auszuführen */
	$SID = session_id();
	$file = file($_SERVER['DOCUMENT_ROOT']."/liquido/templates_c/".$SID.".csv");
	
	if($data['skipfirstline']) $firstline = array_shift($file);
	
	// get fields
	foreach($data['field'] as $name => $value) {
		$fields .= "`".$name."`,";
	}
	
	// groups
	$fields .= "`group`";
	$fields = mysql_escape_string($fields);
	$count = 0;
	
	foreach($file as $entry) {
		// option stip hyphens from entry
		if($data['striphyphens']) $entry = str_replace('"','',$entry);
		
		// catch values in array
		$entry = explode($data['separator'],$entry);
		
		// make string from groups-array
		$groups = is_array($data['groups']) ? ";".implode(";",$data['groups']).";" : ";";
		
		foreach($data['field'] as $key => $index) {
			// skip if mandatory but empty
			if($data['manda'][$index] and !$entry[$index]) {
				$skip = true;
				//echo "skipping entry ".implode(",",$entry)."\n";
			} else {
				$insertvalues .= '\''.mysql_escape_string($entry[$index]).'\',';
				$skipcheckvalues .= " and $key = '$entry[$index]'";
			}
		}
		
		if(!$skip) {
			// adding groups
			$insertvalues .= '\''.$groups.'\'';
			
			// if overwrite - delete existing entries
			if($data['overwrite']) {
				$db->execute("delete from ".$cfg['tables']['nlabos']." where id != '' $skipcheckvalues");
			}
			
			//echo 'insert into '.$cfg['tables']['nlabos'].' ('.$fields.') values ('.$insertvalues.')'; echo "\n";
			$db->execute('insert into '.$cfg['tables']['nlabos'].' ('.$fields.') values ('.$insertvalues.')');
		
			$count++;
		}
		
		$insertvalues = "";
		$skipcheckvalues = "";
		
		
	}
	
	return $count;
}

function insertgroup($data) {
		global $cfg;
		global $db;
		
		return $db->execute("insert into ".$cfg['tables']['nlabogroups']." (title) values ('".mysql_escape_string($data['title'])."')");
}

function delgroup($id) {
	global $cfg;
	global $db;
	if(!intval($id)) return;
	return $db->execute("delete from ".$cfg['tables']['nlabogroups']." where id = '$id' LIMIT 1");
}

function countabos () {
	global $cfg;
	global $db;
	
	return $db->con->getRow("select COUNT(id) as num from `'".$cfg['tables']['nlabos']."'` where status = '0'");
}

function delabo ($id) {
	global $cfg;
	global $db;
	if(!intval($id)) return;
	return $db->execute("delete from ".$cfg['tables']['nlabos']." where `id` = '$id'");
}

function insertabo($data) {
	global $cfg;
	global $db;
	
	if(!$data['name']) $error['name'] = "<- Sie müssen einen Namen eingeben";
	if(!$data['email']) $error['email'] = "<- Es wurde keine Email-Adresse angegeben";
	if(!checkEmailSyntax($data['email'])) $error['email'] = "<- Die Email-Adresse kann nicht verwendet werden";
	if($result = $db->con->getRow("select id from ".$cfg['tables']['nlabos']." where `email` = '".$data['email']."' and status = '0' limit 1")) $error['email'] = "<- Die Email-Adresse ist bereits angemeldet";

	if(!$error) {
		// gruppen
		if($data['group'] and is_array($data['group'])) {
			$groups = ";";
			foreach($data['group'] as $key => $value) {
				$groups .= intval($key).";";
			}
			$data['group'] = $groups;
		}

		// bereiche
		if($data['check']) {
			foreach($data['check'] as $key => $value) {
				$mp .= "$key;";
			}
			if($mp) $mp = substr($mp,0,-1);
			$data['mp'] = $mp;
			unset($data['check']);
		}

		// lösche evt. vorhandene status-1 eintröge (ohne bestätigung)
		$db->execute("delete from `".$cfg['tables']['nlabos']."` where `email` = '".mysql_real_escape_string($data['email'])."' and `status` = '1' LIMIT 1");		

		// felder
		foreach($data as $field => $value) {
			$setfields .= "`".mysql_escape_string($field)."`,";
			$setvalues .= "'".mysql_escape_string($value)."',";
		}
		
		$setfields = substr($setfields,0,-1);
		$setvalues = substr($setvalues,0,-1);

		$insert_sq = "insert into `".$cfg['tables']['nlabos']."` ($setfields) values ($setvalues)";
		$result = mysql_query($insert_sq);
		

		$error['ok'] = true;
	}

	return $error;
}
	
function updateabo($data) {
	global $cfg;
	global $db;	
	
	if(!$data['name']) $error['name'] = "<- Sie müssen einen Namen eingeben";
	if(!$data['email']) $error['email'] = "<- Es wurde keine Email-Adresse angegeben";
	if(!checkEmailSyntax($data['email'])) $error['email'] = "<- Die Email-Adresse kann nicht verwendet werden";
		
	if($db->con->getRow("select distinct id from $cfgtablenlabos where email = '$data[email]' limit 1")) $error['email'] = "<- Die Email-Adresse ist bereits angemeldet";
	
	if(!$error) {
		// bereiche
		if(is_array($data['check'])) {
			foreach($data['check'] as $key => $value) {
				$mp .= "$key;";
			}
			if($mp) $mp = substr($mp,0,-1);
			$data['mp'] = $mp;
			unset($data['check']);
		}

		// gruppen
		if(is_array($data['group'])) {
			foreach($data['group'] as $key => $value) {
				$grp .= ";$key;";
			}
			$data['group'] = $grp;
		}
	
		foreach($data as $field => $value)
			$setfields .= "`".mysql_escape_string($field)."` = '".mysql_escape_string($value)."',";
		
		$setfields = substr($setfields,0,-1);
		
		$update_sq = "update `".$cfg['tables']['nlabos']."` set $setfields where id='$data[id]' LIMIT 1";
		$result = $db->execute($update_sq);
		$error['ok'] = true;
	}
	return $error;
}

function removeabo($data) {
	global $db;
	if(!$result = $db->execute("delete from `".$cfg['tables']['nlabos']."` where email = '$data[mail]'")) {
		$return['ok'] = "Abo wurde gelöscht";
	} else {
		$return['mail'] = "Abo mit dieser Email-Adresse wurde nicht gefunden";
	}
	return $return;
}


?>