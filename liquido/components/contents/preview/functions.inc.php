<?php


function getPagedata($content) {
################################
	include("../../lib/cfg.php");

	// PageInformationen
	$sql = "select * from $cfgtablecontents where id='$content' limit 1"; //echo $sql;
	$content = db_entry($sql);

	// setze pageview-zähler
	$sql_update = "update $cfgtablecontents set views = views+1 where id='$content[0]' limit 1"; //echo $sql_update;
	db_query($sql_update);
	
	// erstellungsdatum
	$content['createdate'] = strftime(getDay($content['date'])." %H:%M",$content['date']);
	
	// änderungsdatum
	$sql = "select * from $cfgtablecontentschanges where obj = '$content[0]' LIMIT 1";
	$changes = db_entry($sql);
	if($changes['date']) { $content['changedate'] = strftime(getDay($changes['date'])." %H:%M",$changes['date']); } else { $content['changedate'] = "keine �nderungen"; }
	
	// parents
	$content['parents'] = getparents($content['parent']);
	if(!$content['width']) $content['width'] = $content['parents']['width'];
	// Template laden
	//if($templateid = $content['parents']['group']['template']) $content['template'] = getTemplate($templateid);

	return $content;
}



function showlink($title,$theme,$article,$addon,$class=0) {
	include("../../lib/cfg_general.inc.php");
	echo "<a href=\"?$addon\">$title</a>";
}

?>