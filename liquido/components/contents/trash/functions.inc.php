<?php

if(isset($_POST['trash'])) {
	$type = $_POST['type'];
	$trash = $_POST['trash'];
	
	if($type == "rec" and is_array($trash)) {
		recycle($trash);
		header("Location:body.php?update_leftframe=1");
	}
	
	if($type == "del" and is_array($trash)) {
		del($trash);
		header("Location:body.php?update_leftframe=1");
	}
}


function del($obj) {
################################

	while(list($key,$val) = each($obj)) {
		switch ($key) {
			case "contents":
				while(list($x,$id) = each ($val)) {
					del_page($id);
				}
			break;
			case "contentobjects":
				while(list($x,$id) = each ($val)) {
					del_object($id);
				}
			break;
		}
	}
}


function del_page($id) 
################################
{
	// lösche Inhaltsobjekte;
	del_objects($id);
	
	// lösche Childs
	$svSQL = "select id from ".db_table("contents")." where parent = '$id'";
	$childs = db_array($svSQL);

	if(is_array($childs)) {
		foreach($childs as $child) {
			del_objects($child['id']);
			del_page($child['id']);
		}
	}	
	db_query("delete from ".db_table("contents")." where id = '$id'");
	db_query("delete from ".db_table("contents_cache")." where page = $id LIMIT 1");
}




function del_objects($data) 
##############################
{
	//include("../../lib/cfg_mysql.inc.php");
	
	$svSQL = "select id from ".db_table("contentobjects")." where parent = '$data'";
	$query = mysql_query($svSQL);

	while($result = mysql_fetch_row($query)) {
		del_object($result[0]);
	}
}




function del_object($id) {
###############################
	$objecttable = db_table("contentobjects");
	$thisobject = db_entry("select id, type,layout from $objecttable where id = '$id'");

	if(is_array($thisobject)) {	
		$fncpart="delobject";
		if(file_exists(OBJECTSDIR."$thisobject[type]/$thisobject[layout]/functions.php")) {
			include(OBJECTSDIR."$thisobject[type]/$thisobject[layout]/functions.php");
		} else {
			db_query("delete from $objecttable where id = '$thisobject[id]' LIMIT 1");
		}
	}
}



function list_trash($content,$type)
##################################
{
	
	global $user;
	
	switch ($type) {
		case "contents":
			$sql = "select id,title,type from ".db_table("contents")." where del = '$user[id]' order by type,rank,title";
			$query = mysql_query($sql);
			echo "<table>
			";
					
			while ($result = mysql_fetch_array($query)) {
				echo "<tr>
					<td><input type=\"checkbox\" name=\"trash[contents][$result[id]]\" value=\"$result[id]\"></td>
					<td><img src=\"gfx/".$result[type]."_tn.gif\"></td>
					<td>$result[title]</td>
				</tr>
				";
			}
			
		echo "</table>
		";
				
			break;
		case "objects":
			$sql = "select	a.id, a.layout, b.title as parent, a.type as objecttype 
					from 	".db_table("contentobjects")." as a left join 
							".db_table("contents")." as b
							on b.id = a.parent
					where 	a.del = '$user[id]' and b.type = 'page'";
			
			$query = mysql_query($sql);
			while ($result = mysql_fetch_array($query)) {
				
				$title = file(OBJECTSDIR."$result[objecttype]/$result[layout]/info.txt");
				
				echo "<input type=\"checkbox\" name=\"trash[contentobjects][$result[id]]\" value=\"$result[id]\"> $title[0] ($result[parent])<br>
				";
			}
			
			break;
		case "templates":
		
			break;
		case "master":
		
			break;
	}
}



function recycle($obj) {
	//include("../../lib/cfg_mysql.inc.php");
	
	while(list($key,$val) = each($obj)) {

		$table = db_table($key);
		while(list($x,$id) = each ($val)) {
			mysql_query("update $table set del='' where id = '$id'");
		}
	}
}


function preview($preview) {
	//include("../../lib/cfg_mysql.inc.php");
	
	$type = key($preview);
	$id = $preview[objects];

	switch ($type) {
		case "group":
			
			break;
		case "contents":
			
			break;
		case "objects":
			$part = "public";
			$sql = "select * from ".db_table("contentobjects")." where id = '$id'";
			$result = db_entry($sql);
			include(OBJECTSDIR."$result[type]/$result[layout]/file.php");			
			break;
		case "template":
		
			break;
	}
}


?>