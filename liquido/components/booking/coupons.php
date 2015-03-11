<?php

	$part = "coupons";
	$icons = array(
		"list" => array(
			"title" => "Liste",
			"link" => "sl('list_coupons.php'); show('searchbox,booking_tools','block');",
			"icon" => "coupons.gif"
			),
		"insert" => array(
			"title" => "einpflegen",
			"link" => "sl('list_coupons.php?action=add'); show('searchbox,booking_tools','none');",
			"icon" => "coupons_new.gif"
			),
		"print" => array(
			"title" => "drucken",
			"link" => "printIframe(top.frames['content']['iframe']);",
			"icon" => "print.gif"
			)
	);
	
	$toolbar['height'] = 90;
	$nosearch = true;
	
	include("tpl_header.php");
	include("tpl_toolbar.php");
	include("tpl_list.php");
	include("tpl_footer.php");

?>


