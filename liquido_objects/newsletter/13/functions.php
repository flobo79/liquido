<?php

$result['showstyles'] = true;

switch ($fncpart) {
	case "delobject":
		mysql_query("delete from $objecttable where id = '$id'");
		mysql_query("delete from ".db_table('contentimgs')." where cid = $id");
		if(intval($id))	exec("rm -r -f ".$_SERVER['DOCUMENT_ROOT'].IMAGES."/".$id);
		break;
}

?>