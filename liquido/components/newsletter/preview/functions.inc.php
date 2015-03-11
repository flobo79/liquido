<?php

if($setcheck) {
	$thiscomp['check'][$setcheck] = $thiscomp['check'][$setcheck] == "1" ? "0" : "1";
}

$_SESSION['components'][$comp] = $thiscomp;

// testmail versenden
if($_POST['previewto']) {
	if(checkEmailSyntax($_POST['previewto'])) {
		$sendresult = sendTest($_POST['previewto']) ? "versendet" : "nicht versandt";
	} else {
		$sendresult = "Email-Syntax prüfen";
	}
}


function sendTest ($to) {
######################################
	include("../../lib/cfg.php");
	global $thiscomp;
	global $user;
	global $ispublishing;
	global $thiscomp;
	global $area;
	
	$ispublishing = true;
	
	$node = new Node($thiscomp['id']);
	$parser = new Parser();
	
	$nlobj = getdata($thiscomp['id']);
	$contents = $node->listobjects();
	$template = getTemplate($nlobj['template']);
	
	$replaces = array(
		0 => "\"Anrede\"",
		1 => "\"Titel\"",
		2 => "\"Vorname\"",
		3 => "\"Nachname\"",
		4 => $user['name'],
		5 => $user['mail'],
		6 => "123",
		7 => $thiscomp['id'],
		8 => '',
		9 => ''
	);
	
	$searches  = array(
		0 => "#anrede#",
		1 => "#titel#",
		2 => "#vorname#",
		3 => "#nachname#",
		4 => "#name#",
		5 => "#email#",
		6 => "#aboid#",
		7 => "#kampagne#",
		8 => "#webbug#",
		9 => '#nlid#'
	);
	
	$letter = $template[0].$contents.$template[1];
	// erstelle mime-kompatible multipart mail
	
	ob_start();
		$mailpart = "head";
		include("preview/mailbody.php");
		
		echo str_replace("	","",(strip_tags($letter)));
		
		$mailpart = "htmlpart";
		include("preview/mailbody.php");

		echo $letter;
		
		$mailpart = "end";
		include("preview/mailbody.php");
		
		$thisletter = ob_get_contents();
	ob_end_clean();
	
	// versende das gute stueck
	$parser->html = str_replace($searches,$replaces,$thisletter);
	$thisletter = $parser->parse();
	
	mail($to, $nlobj['title'],'',$thisletter);

	return "ok";
}


function getPagedata($content) {
################################
	include("../../lib/cfg.php");

	// PageInformationen
	$sql = "select * from $cfgtablecontents where id='$content' limit 1"; //echo $sql;
	$content = mysql_fetch_array(mysql_query($sql));

	// setze pageview-zähler
	$sql_update = "update $cfgtablecontents set views = views+1 where id='$content[0]' limit 1"; //echo $sql_update;
	mysql_query($sql_update);
	
	// erstellungsdatum
	$content['createdate'] = strftime(getDay($content['date'])." %H:%M",$content['date']);
	
	// änderungsdatum
	$sql = "select * from $cfgtablecontentschanges where obj = '$content[0]' LIMIT 1";
	$changes = mysql_fetch_array(mysql_query($sql));
	if($changes['date']) { $content['changedate'] = strftime(getDay($changes['date'])." %H:%M",$changes['date']); } else { $content['changedate'] = "keine �nderungen"; }
	
	// parents
	$content['parents'] = getparents($content['parent']);
	
	return $content;
}



function showlink($title,$theme,$article,$addon,$class=0) {
##############################################
# 
	include("../../lib/cfg_general.inc.php");
	echo "<a href=\"?$addon\">$title</a>";
}

?>