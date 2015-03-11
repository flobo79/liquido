<?php
session_start();
if($setmode) {
	//session_unregister(components);
	//unset($components);
	$components[$mod]['mode'] = $setmode;
	$components[$mod]['type'] = $type;
	
	session_register(components);
	$updateBody = true;
}

//include ("/right.php");


?>