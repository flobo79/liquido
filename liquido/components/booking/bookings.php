<?php

	$part = "bookings";
	$icons = array(
		"list" => array(
			"title" => "Liste",
			"link" => "sl('list_bookings.php'); show('searchbox,booking_tools','block');",
			"icon" => "bookings.gif"
			),
		"insert" => array(
			"title" => "aufnehmen",
			"link" => "sl('list_bookings.php?action=add'); show('searchbox,booking_tools','none');",
			"icon" => "bookings_new.gif"
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


