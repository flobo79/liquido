<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/

if ($edit) {
	edit($edit);
	$update_leftpane = 1;
}

if($swap) {
	swapTemp($swap,$temp['id']);
}

if ($trash) {
	trash($trash);
	$select['id'] = "";
	header("Location:?file=overview&update_leftpane=1");
};

if($insert) {
	header("Location:?update_leftpane=1&select[id]=".newTemplate($insert));
}

if($publish) {
	publish($publish);
	$update_leftpane = true;
}

if($offtake) {
	unpublish($offtake);
	$update_leftpane = true;
}


$temp = $thiscomp['temp'];


/**************************************************
       Detail - Funktionen                       *
**************************************************/

function swapTemp($swap,$curr) {
// vertauscht templates anhand der ids

	include("../../lib/cfg.php");
	mysql_query("update $cfgtabletemplates set id = '9999' where id = '$curr' LIMIT 1");
	mysql_query("update $cfgtabletemplates set id = '$curr' where id = '$swap' LIMIT 1");
	mysql_query("update $cfgtabletemplates set id = '$swap' where id = '9999' LIMIT 1");
}

function trash($obj) {
#######################################
	global $db;
	
	// verbleib der verwendungen
	$cfgtablecontents = db_table("contents");
	$cfgtabletemplates = db_table("templates");
	$cfgtabletemplateschanges = db_table("templates_changes");
	$cfgtablecontainerobjects = db_table("temp_container");
	
	if($trash['todo'] == "setoffline") {
		$sql_todo = "update $cfgtablecontents set template = '', status='0' where template = '$obj[id]'";
	} else {
		$sql_todo = "update $cgftablecontents set template = '$obj[todo]' where template = '$obj[id]'";
	}
	$db->execute($sql_todo);
	
	// lösche template and related
	$db->execute("delete from $cfgtabletemplates where id = '$obj[id]'");
	$db->execute("delete from $cfgtabletemplateschanges where tpl = '$obj[id]'");
	$db->execute("delete from $cfgtablecontainerobjects where tpl = '$obj[id]'");

	if($obj['id']) exec("rm -r -f ".DOCROOT.CONTAINERDIR."/$obj[id]");
}



function unpublish ($obj) {
	$cfgtablecontents = db_table("contents");
	$cfgtabletemplates = db_table("templates");
	
	if(isset($obj['todo'])) {
		if($obj['todo'] == "setoffline") {
			$sql_todo = "update $cfgtablecontents set template = '', status='2' where template = '$obj[id]'";
		} else {
			$sql_todo = "update $cgftablecontents set template = '$obj[todo]' where template = '$obj[id]'";
		}
		
		mysql_query($sql_todo);
	}

	// aktualiesiere tabelle
	mysql_query("update $cfgtabletemplates set status = '0' where id = '$obj[id]' LIMIT 1");
}


function publish ($obj) {
#######################################
	global $db;
	// verbleib der verwendungen
	$cfgtablecontents = db_table("contents");
	$cfgtabletemplates = db_table("templates");
	
	if(intval($obj['id'])) {
		$id = $obj['id'];
		// aktualiesiere tabelle
		$db->execute("update $cfgtabletemplates set status = '1' where id = $id");
	}
}


function newTemplate($insert) {
#######################################
	$id = insert($insert);	
	mkdir($_SERVER['DOCUMENT_ROOT'].CONTAINERDIR.$id, 0777);
	mkdir($_SERVER['DOCUMENT_ROOT'].CONTAINERDIR.$id."/import", 0777);
	return $id;
}



function get_dropbox ($data,$nr) {
##################################
	$nr++;
	
	$marker = ".";
	for($i=2; $i <= $nr;$i++) {
		$space = $space.$marker;
	}
	
	$result = list_child($data);

	if(is_array($result)) { 
		while(list($field,$newdata) = each($result)) {
			
			if($newdata['id'] != $data['currentid']) {
				$selected = $newdata['id'] == $data['pageparent'] ? " selected" : "";
				$id = ($newdata['id'] == $data['currentid'] ? $data['pageparent'] : $newdata['id']);
				
				echo "<option value=\"$id\" $selected>$space$newdata[title]</option>\n";
	
				$newdata['parent'] = $newdata['id'];
				$newdata['currentid'] = $data['currentid'];
				$newdata['pageparent'] = $data['pageparent'];
				
				 get_dropbox($newdata,$nr);
				
				if($nr == "1") echo "<option> </option>\n";
			}
		}
	}
}



function build_dropbox($data) {
#############################
	$cfgtablecontents = db_table("contents");
	echo "<select name=\"edit[parent]\" class=\"text\" lang=\"de\">
		";

		$selected = !$data['parent'] ? "selected" : "";
		echo "<option value=\"\" $selected></option>\n";
		
		$sql = "select id,title,type,parent from $cfgtablecontents where del != '1' order by type, title";
		$query = mysql_query($sql);
		
		while ($result = mysql_fetch_array($query)) {
			$add = $result['type'] == "group" ? "- " : "";
			$selected = $data['parent'] == $result['id'] ? "selected" : "";
			echo "<option value=\"$result[id]\" class=\"$class\" $selected>$add $result[title]</option>
			";
		}
		
		
		echo "</select>"; 
}



?>