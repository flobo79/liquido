<?php

switch ($fncpart) {
	case "delobject":
		mysql_query("delete from $objecttable where id = $id LIIMIT 1");
		break;
}


?>