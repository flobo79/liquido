<?php

	$part = "places";
	$icons = array(
		"list" => array(
			"title" => "Liste",
			"link" => "sl('list_places.php');",
			"icon" => "places.gif"
			),
		"insert" => array(
			"title" => "erstellen",
			"link" => "sl('list_places.php?action=add');",
			"icon" => "places_new.gif"
			),
		"print" => array(
			"title" => "drucken",
			"link" => "printIframe(top.frames['content']['iframe']);",
			"icon" => "print.gif"
			)
	);
	
	$toolbar['height'] = 90;	
	
	
	include("tpl_header.php");
	include("tpl_toolbar.php");
	include("tpl_list.php");
	include("tpl_footer.php");

?>


