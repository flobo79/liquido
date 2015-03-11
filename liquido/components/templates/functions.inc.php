<?php

foreach($_GET as $k => $v) { $$k = $v; }
foreach($_POST as $k => $v) { $$k = $v; }

if(isset($setmode)) {
	$_SESSION['components'][$comp]['current'] = $setmode;
}
if(isset($select)) {
	$_SESSION['thiscomp']['temp'] = $select['id'];
}

if($setmode) {
	$mode = $setmode;
	$_SESSION['components']['templates']['current'] = $setmode;
}

if(!$_SESSION['components']['templates']['current']) {
	$_SESSION['components']['templates']['current'] = "detail";
	$thiscomp = $_SESSION['components'][$comp];
}

if($_GET['select']) {
	$_SESSION['components'][$comp]['class'] = "";
	$_SESSION['components'][$comp]['struct'] = "";
	$_SESSION['components'][$comp]['obj'] = "";
	$_SESSION['components'][$comp]['temp'] = $_GET['select']['id'];
	$thiscomp = $components[$comp];
}

$temp = $_SESSION['components'][$comp]['temp'];
$access = loadAccessTable($user,"contents");



function gettemplates($current=0,$onlypublic=0) {	
	global $db;
	global $cfgtabletemplates;
	
	if($current) $where = "and id != '$current'";
	if($onlypublic) $status = "and status = '1' ";
	$sql = "select id,title from $cfgtabletemplates where id != '0' $status $where order by title";
	$templates = $db->getArray($sql);

	return $templates;
}


function getData($id,$do=0) {
	global $db;
	global $cfgtabletemplates;
	global $cfgtablecontents;
	global $cfgtabletemplateschanges;
	
	$sql = "select * from $cfgtabletemplates where id = '$id' limit 1";
	$content = $db->getRow($sql);
	
	// erstellungsdatum
	$content['date'] = strftime(getDay($content['date'])." %H:%M",$content['date']);

	// anzahl der verwendungen
	$sql_uses = "select count(id) as nr from $cfgtablecontents where `template` = '$id'";
	$content['uses'] = $db->getArray($sql_uses);

	//get letzte Änderung und Editor
	$sql_changes = "select max(timestamp) as timestamp, max(id) as id, max(user) as user from $cfgtabletemplateschanges where tpl = '$id' group by tpl"; //echo $sql_changes;
	$content['changes'] = $db->getRow($sql_changes);
	
	// wenn es Änderungen gab
	if($content['changes']) {
		
		// gegenwärtige zeit
		$timestamp = $content['changes']['timestamp'];
		
		// formatiere Änderungszeit
		$content['changes']['date'] = strftime(getDay($timestamp)." %H:%M",$timestamp); 
				
		// get undo (grösste id der entries mit timestamp < $timestamp)
		$sql_undo = "select MAX(id) as id from $cfgtabletemplateschanges where tpl = '$content[id]' and timestamp < '$timestamp'";
		$content['undo'] = $db->getArray($sql_undo);
		
		// get redo (kleinste id der entries mit timestamp > $timestamp)
		$sql_redo = "select id from $cfgtabletemplateschanges where tpl = '$id' and timestamp > '$timestamp' LIMIT 1"; //echo $sql_redo;
		$content['redo'] =$db->getArray($sql_redo);	
	
	} else { 
		$content['changes']['date'] = "keine Änderungen"; 
	}

	return $content;
}



function showchildsx($content,$new) {
	global $db;
	global $cfgtabletemplates;
	global $access;

	$sql = "select * from $cfgtabletemplates where parent = '$content[id]' order by type desc";

	// wenn neuanlegen von Seiten erlaubt ist
	if($new == "1" and $access[c1]) { $insert_new = "
		<tr>
			<td width=\"5\">
				<img src=\"/cms_pro/gfx/tree_end.gif\">
			</td>		
			<td valign=\"top\" width=\"25\">
				<a href=\"javascript:show('newObject','in_newpage')\"><img src=\"../gfx/page_new_tn.gif\" border=\"0\"></a>
			</td>
			<td colspan=\"2\">
				<a href=\"javascript:show('newObject','in_newpage')\">neues Vorlagenobjekt</a>
			</td>
		"; 
		$endtree = "1";
	}

	
	// finde Unterobjekte
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query)) {
	
		if(!$endtree) { $grf = "../gfx/tree_end.gif"; } else { $grf = "../gfx/tree_body.gif"; }

		if($access[c6]) $rankbuttons = "<a href=\"body.php?rank[id]=$result[id]&rank[dir]=up&rank[type]=contents\" onMouseOver=\"MM_swapImage('up$result[id]','','../../components/contents/gfx/move_up_o.gif',1)\" onMouseOut=\"MM_swapImgRestore()\"><img src=\"../../components/contents/gfx/move_up.gif\" alt=\"Objekt 1 nach oben verschieben\" border=\"0\" name=\"up$result[id]\"></a><a href=\"body.php?rank[id]=$result[id]&rank[type]=contents&rank[dir]=down\" onMouseOver=\"MM_swapImage('down$result[id]','','../../components/contents/gfx/move_down_o.gif',1)\" onMouseOut=\"MM_swapImgRestore()\"><img src=\"../../components/contents/gfx/move_down.gif\" alt=\"Seite mit darunterliegender tauschen\" border=\"0\"  name=\"down$result[id]\"></a>"; 
		$status = $result[status] ? "online" : "offline";
		
	
		$cell .= "
		<tr>
			<td width=\"5\">
				<img src=\"$grf\"></br>
			</td>
			<td width=\"25\">
				<a href=\"body.php?&select[id]=$result[id]\"><img src=\"../gfx/".$result[type]."_tn.gif\" border=\"0\"></a>
			</td>
			<td width=\"250\">
				<a href=\"body.php?&select[id]=$result[id]\">$result[title]</a>
			</td>
			<td width=\"150\">
				<a href=\"body.php?&select[id]=$result[id]\">$status</a>
			</td>
			<td width=\"50\">
				$rankbuttons
			</td>
		</tr>
		";
				
		$endtree = "1";
	}
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			$cell
			$insert_new
	</table>";
}



function listTempObjects ($id,$type=0) {

	$objects = array();
	
	if($type) { $types = array($type); } else { $types = array("container","structures","classes"); }
	while(list($key,$val) = each($types)) {	
		$type = $types[$key];
		$table = "cfgtable".$type;
		
		$sql = "select id,title from ".$$table." where tpl = '$id' order by title"; echo "<!-- $sql -->";

		$results = array();
		
		$q = mysql_query($sql);
		while($result = mysql_fetch_array($q)) {
			array_push($results,$result);
		}
		$objects[$type] = $results;
	}
	
	return $objects;
	
}

function contents_tree ($obj=0,$current=0,$inst=-1) {
	global $cfgtabletemplates;
	$inst++;

	// listet alle contents auf, beim ersten aufruf die hauptthemen
	$sql = "select id,title,status from $cfgtabletemplates order by title"; //echo $sql;
	$query = mysql_query($sql);

	while ($result = mysql_fetch_array($query)) {

		$titel = ($x = strlen($result[1])) > (18-$inst) ? substr($result[1],0,(17-$inst))."..." : $result[1];
		if($result[status]) {
			$bold1 = "<b>";
			$bold2 = "</b>";
		} else {
			$bold1 = "";
			$bold2 = "";
		}
		
		echo $bold1."<a href=\"body.php?select[id]=$result[0]\" target=\"middle\">$titel</a>$bold2<br>
		";
	}
}


?>