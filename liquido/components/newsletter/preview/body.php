<?php
	if($thiscomp['id']) {
		$include = "redaction.php";
	} else {
		$include = "overview.php";
	}
		
	include ("tpl_head.php");
	include($include);
	include ("tpl_footer.php");
	
?>