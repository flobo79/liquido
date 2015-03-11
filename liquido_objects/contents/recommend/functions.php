<?php

$result['showstyles'] = true;

switch ($fncpart) {
	case "delobject":
		mysql_query("delete from $objecttable where id = '$id'");
		break;
}

?>