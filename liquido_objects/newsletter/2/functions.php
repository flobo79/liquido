<?php

switch ($fncpart) {
	case "delobject":
		

		mysql_query("delete from $objecttable where id = '$id' LIMIT 1");

		break;
}


?>