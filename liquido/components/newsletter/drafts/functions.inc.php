<?php
/* __/ __/ __/ __/ __/ __/ __/ __/ __/
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      www.media5k.de     __/ _
_/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/		
 c by media5k 2003 | info@media5k.de             __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/

//   todo
/***********************************************************************************/



//   defaults
/***********************************************************************************/



//   Trigger
/*/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/*/


if ($setobjecttype) { 
	session_start();
	$content['objecttype'] = $setobjecttype;
	session_register(content);
}


if ($save_template) save_template($content,$save_template);
if ($showtemplate) show_template($content,$inserttemplate);

if ($insertobject) {
	$data['type'] = $content['objecttype'];		// art des objektes
	$data['parent'] = $template['id'];			// seite				
	$data['layout'] = $insertobject['id'];		// typ des objects
	$data['table'] = "nlcontentobjects";		// tabellenbezeichnung
	$data['position'] = $insertpos;			// position
	$data['rank'] = GetObjectRank($data);	// ermittle rankid und verschiebe ggf die objecte

	insert($data);
}

if($rank) {
	$rank['parent'] = $obj['id'];
	$rank['type'] = "nlcontentobjects";
	rank($rank);
	header("Location:body.php");
}

if ($update) update($objectdata);

if ($trash) {
	$trash['type'] = "nlcontentobjects";
	movetotrash($trash);
	header("Location:body.php?update_leftframe=1");
}

if ($delpic and $access['c14']) del_pic($delpic);


function GetObjectRank($get)
########################################
// erweiterte getRank-Funktion die nicht die letzte rank-id des tables
// sondern der inhalte eines objectes ermittelt
{
	include("../../lib/cfg.php");

	// füge objekt am Ende der Seite ein
	switch ($get['position'])  {
		case "bottom":
		$svSQL = "select MAX(rank) from $cfgtablenlcontentobjects where parent='$get[parent]'";
		$result = mysql_fetch_row(mysql_query($svSQL));
		$rank = $result[0];
		$rank++;
		return $rank;
		break;
		
	
	
		case "middle":
		// ermittle die anzahl der nicht gelöschten objekte einer seite
		$sql = "select COUNT(*) from $cfgtablenlcontentobjects where parent='$get[parent]'";
		$count = mysql_fetch_row(mysql_query($sql));
		$middle = ceil($count[0]/2);
		$rowsleft = $count[0] - $middle;
		
		// hole id des middleren datensatze
		$middlerank = mysql_fetch_row(mysql_query("select rank from $cfgtablenlcontentobjects where parent='$get[parent]' limit $middle,1"));
		
		// aktualisiere alle objects die einen gleichen/höheren rank haben als middle
		$sql = "select id,rank from $cfgtablenlcontentobjects where parent='$get[parent]' and rank >= '$middlerank[0]'"; //echo $sql;
		$q = mysql_query($sql);
		while($result = mysql_fetch_row($q)) {
			// merke rank des mittleren datensatzes
			$rank = $result[1];
			$rank++;
			mysql_query("update $cfgtablenlcontentobjects set rank = '$rank' where id = '$result[0]'");
		}
		
		return $middlerank[0];
		break;
		
		
		
		case "top":
		// prüfe ob das erste object der Seite rank 1 ist
		$sql = "select MIN(rank) from $cfgtablenlcontentobjects where parent='$get[parent]'"; //echo $sql;
		$toprank = mysql_fetch_row(mysql_query($sql));
		
		// wenn rank 1 ist
		if($toprank[0] == "1") {
			// verschiebe alle ranks um 1 nach hinten
			$sql = "select id,rank from $cfgtablenlcontentobjects where parent='$get[parent]'"; //echo $sql;
			$q = mysql_query($sql);
			while($result = mysql_fetch_row($q)) {
				$rank = $result[1];
				$rank++;
				mysql_query("update $cfgtablenlcontentobjects set rank = '$rank' where id = '$result[0]'");
			}
		}
		// andernfalls gib 1 zurück
		return "1";
		break;
	}
}


function insertPicLink($id,$width,$height) {
###########################################
	echo "<a href=\"#\" onClick=\"openLibrary($id,'selectimg[id]=$id&selectimg[tnwidth]=$width&selectimg[tnheight]=$height'); return false\">&raquo; Bild ausw&auml;hlen</a>
	";
}



function list_templates($content) {
###########################################
	include("../../lib/cfg_mysql.inc.php");
	OpenDatabase ();
	
	$sql = mysql_query("select id,title from $cfgtablenlcontents where type = 'template'");
	while($result = mysql_fetch_row($sql)) {
		echo "<b><a href=\"body.php?selecttemplate=$result[0]\" target=\"middle\">$result[1]</a></b></br>";
	}

}


function listTools ($content) 
###########################################
{	
	include("../../lib/cfg_mysql.inc.php");
	OpenDatabase ();
	
	$d = dir("../../objects");
	while($entry=$d->read()) {
		if($entry !="." and $entry != "..") {
			$title = file("../../objects/".$entry."/info.txt");
			echo "<a href=\"?setobjecttype=$entry\"><b>$title[0]</b></a><br>
			";
			if($content[objecttype] == $entry) {
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



function listobjects ($content,$part) {
###################################################
	include("../../lib/cfg.php");
	
	global $access;

	$contentwidth = "400";
	$cfgcmspath = "../../";
	
	$svSQL = "select * 
				from $cfgtablenlcontentobjects
				where parent = '$content[id]' and del = '0' 
				order by rank";
	

	$testquery = mysql_query($svSQL);
	$query = mysql_query($svSQL);
	if (mysql_fetch_array($testquery)) {

		while ($result = mysql_fetch_array($query)) 
		{	
			$objectid = $result[id];
			include ("../../objects/$result[type]/$result[layout]/file.php");
			
			// objekteigenschaften löschen
			unset($thisobject);
			
			$update .= "$result[id],";
		}
	} else {
		echo "<span class=\"headline\">Es gibt noch keine Objekte</span>";
	}
	
	//schneidet das letzte komma hinten ab
	$update = substr($update,0,(strlen($update)-1));	

	return $update;
}






function update ($upload) {
###################################################
	
	include("../../lib/cfg.php");
	
	//objektestring in IDs zerlegen
	$object = explode(",","$upload[objects]");
	
	//für jede vorkommene ID ausführen
	for($i = 0;$object[$i];$i++) {
		
	   $updatedata = '';
	   
	   while (list($field, $value) = each($upload[$object[$i]]))
	   {	
			$updatedata[$field] = $value;
			//echo "updatedata[$field] = $value";
	   }

		include("../../lib/cfg_mysql.inc.php");
		
		if($upload[$object[$i]]['updatefunction']) {
			$part = update;
			$type = $upload[$object[$i]]['type'];
			$layout = $upload[$object[$i]]['layout'];
			include("../../objects/$type/$layout/functions.php");
		}
		
		$updatedata[id] = $object[$i];

		$svSQL = GetUpdateSQL ($cfgtablecontentobjects, $updatedata);
		$query = mysql_query($svSQL);
		
	}
}



function del_pic($delpic) {
#####################################################
	include("../../lib/cfg.php");
	
	$pic = mysql_fetch_array(mysql_query("select * from $cfgtablenlcontentimgs where id = '$delpic[picid]'"));
	
	if($pic[libid] != "") {
		$picdir = $cfgcmspath.$cfgcmspicdir.$pic[cid]."/".$pic[libid];
		$shc = "rm -r $picdir";
		
		exec($shc);
		
		//datensatz löschen
		mysql_query("delete from $cfgtablenlcontentimgs where id = '$delpic[picid]'");
	}
}


?>