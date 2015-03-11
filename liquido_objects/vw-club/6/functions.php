<?php

switch ($fncpart) {
	case delobject:

		mysql_query("delete from $objecttable where id = '$id'");
		if($id)	exec("rm -r -f $cfgcmspath/".$cfgcmspicdir.$id);
		break;
}


?>