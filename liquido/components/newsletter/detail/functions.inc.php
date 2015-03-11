<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/

/**************************************************
       Detail - Funktionen          
**************************************************/

function setstatus($status) {
	global $thiscomp;
	global $db;
	global $cfg;
	
	$db->execute("update ".$cfg['tables']['contents']." set status = '$status' where id = '$thiscomp[id]' LIMIT 1");
}

function get_dropbox ($data,$nr) {
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
	include("../../lib/cfg.php");
	
	echo "<select name=\"edit[parent]\" class=\"text\" lang=\"de\">
		";

		$selected = !$data[parent] ? "selected" : "";
		echo "<option value=\"\" $selected></option>\n";
		
		$sql = "select id,title,type,parent from $cfgtablecontents where del != '1' order by type, title";
		$query = mysql_query($sql);
		
		while ($result = mysql_fetch_array($query)) {
			$add = $result[type] == "group" ? "- " : "";
			$selected = $data[parent] == $result[id] ? "selected" : "";
			echo "<option value=\"$result[id]\" class=\"$class\" $selected>$add $result[title]</option>
			";
		}
		
		
		echo "</select>"; 
}


function scedule($data) {
	include("../../lib/cfg_mysql.inc.php");
	$ConID = OpenDatabase ();

	if ($data['publish']) {
		$svSQLpub = "insert into $cfgtablesceduler (page, type, date) values ('$data[id]','1','$data[publish]')";
		$svdel = "delete from $cfgtablesceduler where page = '$data[id]' and type = '1'";
		$delete = mysql_query($svSQLdel);
		$insert = mysql_query($svSQLpub);
	} else {
		$svdel = "delete from $cfgtablesceduler where page = '$data[id]' and type = '1'";
		$delete = mysql_query($svSQLdel);
	}

	if ($data['unpublish']) {
		$svSQLunpub = "insert into $cfgtablesceduler (page, type, date) values ('$data[id]','0','$data[unpublish]')";
		$svdel = "delete from $cfgtablesceduler where child_id = '$data[page]' and type = '0'";
		$delete = mysql_query($svSQLdel);
		$insert = mysql_query($svSQLunpub);
	} else {
		$svdelx = "delete from $cfgtablesceduler where page = '$data[id]' and type = '0'";
		$delete = mysql_query($svSQLdelx);
	}

	if(!$data['publish'] and !$data['unpublish']) {
		$svSQLupd = "update $cfgtablecontents set status='0' where id = '$data[id]'";
	} else {
		$svSQLupd = "update $cfgtablecontents set status='2' where id = '$data[id]'";
	}
	$update = mysql_query($svSQLupd);
}

?>