<?php 
	$user = $_SESSION['user'];
	session_write_close();
	$parser = new Parser();
	
	$node= new Node($thiscomp['id']);
	$nlobj = getdata($thiscomp['id']);
	$content = $node->listobjects();
	
	$searches  = array(
		0 => "#anrede#",
		1 => "#titel#",
		2 => "#vorname#",
		3 => "#nachname#",
		4 => "#name#",
		5 => "#email#",
		6 => "#aboid#",
		7 => "#kampagne#"
	);

	$replaces = array(
		0 => "\"Anrede\"",
		1 => "\"Titel\"",
		2 => "\"Vorname\"",
		3 => "\"Nachname\"",
		4 => $user['name'],
		5 => $user['mail'],
		6 => "123",
		7 => $thiscomp['id']
	);
	
	$content = str_replace($searches,$replaces,$content);

// hole template
if($nlobj['template'] and $thiscomp['loadtemplate']) {
	$template = getTemplate($nlobj['template']);
	$parser->html = $template[0].$content.$template[1];
	echo $parser->parse();
	
} else {
	$parser->html = $content;
	echo $parser->parse();
} ?>