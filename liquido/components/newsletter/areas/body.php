<?php

	if($thisarea) {
		$data = getarea($thisarea);
		$include = "details.php";
	} else {
		$include = "list.php";
	}
	session_write_close();
	
	
	
		
	include ("tpl_head.php");
	include($include);
	include ("tpl_footer.php");
?>

