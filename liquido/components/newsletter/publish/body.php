<?php 

if($loc) { 
	$include = "publish/".$loc.".php";
} else {
	$include = "publish/start.php";
}

		
	include ("tpl_head.php");
	include($include);
	include ("tpl_footer.php");

?>