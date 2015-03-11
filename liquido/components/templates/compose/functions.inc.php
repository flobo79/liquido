<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/


//   Trigger   
//################################################################

if ($edit) {
	edit($edit);
	$update_leftpane = 1;
}

if ($trash) {
	trash($trash);
	$select['id'] = "";
	$update_leftpane = true;
}

if($delobj) {
	delobj($delobj,$temp[id]);
	header("Location?");
}


if ($update) {
	$update['code'] = $code;
	$update['id'] = $update['id'];
	update($update);
}


/**************************************************
        Funktionen                       		*
**************************************************/


function update($obj) {
	global $db;
	global $cfgtabletemplates;
	global $cfgtabletemplateschanges;
	global $user;
	global $thiscomp;
	
	$id = intval($thiscomp['temp']);
	$sql = "update $cfgtabletemplates set code = '".mysql_real_escape_string(urldecode($obj['code']))."' where id = $id LIMIT 1";
	$db->execute($sql);
	$db->execute("insert into $cfgtabletemplateschanges (tpl,timestamp,user,sql) values ($id , ".time().", '".$user->id."','$sql')");
	$db->execute("update ".db_table("contents_cache")." set refresh = '0' where page = '$id' LIMIT 1");
}


function refreshPages($id) {
	db_query("update ".db_table("contents_cache")." set refresh = '0' where page = '$id' LIMIT 1");
}


function getDatax($id,$do=0) {
################################
	include("../../../lib/cfg.php");


	$sql = "select * from $cfgtabletemplates where id = '$id' limit 1";
	$content = mysql_fetch_array(mysql_query($sql));
	
	// erstellungsdatum
	$content['date'] = strftime(getDay($content['date'])." %H:%M",$content['date']);

	// anzahl der verwendungen
	$sql_uses = "select count(id) as nr from $cfgtablecontents where template = '$id'";
	$content['uses'] = mysql_fetch_array(mysql_query($sql_uses));

	//get letzte Änderung und Editor
	$sql_changes = "select max(timestamp) as timestamp, max(id) as id, max(user) as user from $cfgtabletemplateschanges where tpl = '$id' group by tpl"; //echo $sql_changes;
	$content['changes'] = mysql_fetch_array(mysql_query($sql_changes));
	
	// wenn es Änderungen gab
	if($content['changes']) {
		
		// gegenwärtige zeit
		$timestamp = $content['changes']['timestamp'];
		
		// formatiere Änderungszeit
		$content['changes']['date'] = strftime(getDay($timestamp)." %H:%M",$timestamp); 
	
	} else { 
		$content['changes']['date'] = "keine Änderungen"; 
	}

	return $content;
}



function listStructs ($id, $where=0) {
	global $cfgtablestructures;
	global $db;

	if($isset($current['id'])) $where = "and id != '$where[id]'";

	$sql = "select * from $cfgtablestructures where tpl = '".intval($id)."' $where order by obj";
	$obj = $db->getArray($sql);

	return $obj;
}



?>