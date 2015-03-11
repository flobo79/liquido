<?php

switch ($fncpart) {
	case "delobject":
		

		mysql_query("delete from $objecttable where id = '$id'");

		break;
	case "update":
		$updatedata['smalltext2'] = $updatedata['smalltext2'];
		$updatedata['smalltext3'] = $updatedata['smalltext3'];
		break;
}


?>