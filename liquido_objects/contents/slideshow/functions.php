<?php
/**
 * This object is supposed to be a connector between a ajax-picture browser and the media library
 * 
 */


switch ($fncpart) {
	case "insert":
		
		break;
	case "compose":
		
		
		break;
	case "load": 

		
		break;
	
	case "delobject":
		mysql_query("delete from $objecttable where id = '$id'");
		break;
}

?>