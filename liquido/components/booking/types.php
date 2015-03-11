<?php

	$part = "types";
	
	/*
	$icons = array(
		"list" => array(
			"title" => "Arten",
			"link" => "sl('list_types.php'); show('searchbox,booking_tools','block');",
			"icon" => "bookings.gif"
			)
	);
	*/
	$toolbar['height'] = 20;
	$toolbar['nosearch'] = true;
	
	include("tpl_header.php");
	include("tpl_toolbar.php");
	include("tpl_list.php");
	include("tpl_footer.php");

?>


