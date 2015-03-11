<?php

// trigger

if($inserttemplatex) {
	if ($insertobject) {
		$data['type'] = $content['objecttype'];
		$data['parent'] = $content['id'];
		$data['layout'] = $insertobject['id'];
		$data['table'] = "contentobjects";
		
		insert($data);
	}
}


// funktionen      ###########################################
function listTools ($content)     #######################
{	
	include("../../lib/cfg_mysql.inc.php");
	OpenDatabase ();
	
	$d = dir("../../objects");
	while($entry=$d->read()) {
		if($entry !="." and $entry != "..") {
			$title = file("../../objects/".$entry."/info.txt");
			echo "<a href=\"?setobjecttype=$entry\"><b>$title[0]</b></a><br>
			";
			if($content['objecttype'] == $entry) {
				$xd = dir("../../objects/$entry");
				while($xentry=$xd->read()) {
					if(is_dir("../../objects/$entry/".$xentry) and $xentry !="." and $xentry != "..") {
						$title = file("../../objects/$entry/".$xentry."/info.txt");
	echo "&nbsp;<a href=\"body.php?insertobject[id]=$xentry\" target=\"middle\">$title[0]</a></br>
		";
					}
				}
			}
		}
	}
}


function list_templates($content) {      #########################

	include("../../lib/cfg_mysql.inc.php");
	OpenDatabase ();
	
	$sql = mysql_query("select id,title from $cfgtablecontents where status = '99'");
	while($result = mysql_fetch_row($sql)) {
		echo "<b><a href=\"body.php?inserttemplate=$result[0]\" target=\"middle\">$result[1]</a></b></br>";
	}

}


	
function get_tempname ($id) {     ##########################

	include("../../lib/cfg_general.inc.php");
	include("../../lib/cfg_mysql.inc.php");
	OpenDatabase ();
	
	$result = mysql_fetch_array(mysql_query("select title from $cfgtablecontents where id = '$id' and status = '99'"));
	
	return $result;
}


function showtemplate ($content,$template) {  ####################

	include("../../lib/cfg_general.inc.php");
	include("../../lib/cfg_mysql.inc.php");
	OpenDatabase ();
	
	$contentwidth = $content['groupwidth'];
	$cfgcmspath = "../../";
	$part = "compose";
	
	$ConID = OpenDatabase ();
	$svSQL = "select * 
				from $cfgtablenlcontentobjects
				where parent = $template and del != '1' 
				order by rank";

	$testquery = mysql_query($svSQL,$ConID);
	$query = mysql_query($svSQL,$ConID);
	if (mysql_fetch_array($testquery)) {

		while ($result = mysql_fetch_array($query)) 
		{	
			$objectid = $result[id];
			include ("../../objects/$result[type]/$result[layout]/file.php");
			$update .= "$result[id],";
		}
	}
	
	//schneidet das letzte komma hinten ab
	$update = substr($update,0,(strlen($update)-1));	

	return $update;
}


?>