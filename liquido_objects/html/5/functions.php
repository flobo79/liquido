<?php

switch ($fncpart) {
	case "delobject":
		mysql_query("delete from $objecttable where id = '$id'");
		break;
	case "load":
		if($part == "compose") {
			/*
			$thissearches  = array(
				0 => "<textarea ",
				1 => "</textarea>",
				2 => "<form ",
				3 => "</form>"
			);
			$thisreplaces = array(
				0 => "<textareax ",
				1 => "</textareax>",
				2 => "<formx ",
				3 => "</formx>"
			);
				*/
		}
		
		break;
	case "update":

		break;
}


?>