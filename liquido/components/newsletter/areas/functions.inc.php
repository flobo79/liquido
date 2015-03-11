<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/

/************* TO DO ************************


********************************************/


//   Trigger   
//################################################################

if ($area = $_POST['delarea']) {
	del_area($area);
	$thisarea = "";
	//$update_leftpane = true;
}

if ($edit) {
	if(!$edit['status']) $edit['status'] = "0";
	$edit['table'] = "nl_areas";
	$edit['id'] = $thisarea;
	edit($edit);
	
	$update_leftpane = 1;
}

if($rank) {
	$rank['parent'] = $obj['id'];
	$rank['type'] = "contents";
	rank($rank);
	//header("Location:body.php");
}

if($insert) {
	$insert['table'] = "nl_areas";
	$area['id'] = insert($insert);
	$nlobj['areas'] = getAreas ();
	//session_register(nlobj);
	$update_leftpane = true;
}




/**************************************************
       area - Funktionen                       *
**************************************************/

function getarea($area) {
################################
	include("../../lib/cfg.php");

	// PageInformationen

	$sql = "select * from $cfgtablenlareas where id = '$area' limit 1";
	$content = mysql_fetch_array(mysql_query($sql));

	// erstellungsdatum
	$content['date'] = strftime(getDay($content['date'])." %H:%M",$content['date']);
	
	return $content;
}


function del_area($area){
	
	$sql = "delete from ".db_table("nl_areas")." where id = '$area' limit 1";
	mysql_query($sql);
}


function listTemplates($current=0) {
##################################
	include("../../lib/cfg.php");
	
	echo "<select name=\"edit[template]\" class=\"text\">\n
		<option value=\"0\">kein Template ausgewählt</option>\n";
			
	$sql = "select * from ".db_table("templates")."  where status != '0' order by title";
	$q = mysql_query($sql);
	while ($result = mysql_fetch_array($q)) {
		$selected = $current == $result['id'] ? " selected" : "";
		echo "<option value=\"$result[id]\" $selected>$result[title]</option>";
	}
	echo "</select>\n";
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
			
			if($newdata[id] != $data[currentid]) {
				$selected = $newdata[id] == $data[pageparent] ? " selected" : "";
				$id = ($newdata[id] == $data[currentid] ? $data[pageparent] : $newdata[id]);
				
				echo "<option value=\"$id\" $selected>$space$newdata[title]</option>\n";
	
				$newdata['parent'] = $newdata[id];
				$newdata['currentid'] = $data[currentid];
				$newdata['pageparent'] = $data[pageparent];
				
				 get_dropbox($newdata,$nr);
				
				if($nr == "1") echo "<option> </option>\n";
			}
		}
	}
}



function build_dropbox($data) {
#############################
	include("../../lib/cfg.php");
	
	echo "<select name=\"edit[parent]\" class=\"text\" lang=\"de\">
		";

		$selected = !$data[parent] ? "selected" : "";
		echo "<option value=\"\" $selected></option>\n";
		
		$sql = "select id,title,type,parent from ".db_table("nl_contents")."  where del != '1' order by type, title";
		$query = mysql_query($sql);
		
		while ($result = mysql_fetch_array($query)) {
			$add = $result[type] == "group" ? "- " : "";
			$selected = $data[parent] == $result[id] ? "selected" : "";
			echo "<option value=\"$result[id]\" class=\"$class\" $selected>$add $result[title]</option>
			";
		}
		
		
		echo "</select>"; 
}


?>