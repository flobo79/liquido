<?php

switch ($fncpart) {
	case update:
		$check1 = strchr($updatedata[link],"@");
		$check2 = strchr($updatedata[link],"mailto:");
		if($check1 and !$check2) {
			$newlink = "mailto:".$updatedata[link];
			$updatedata[link] = $newlink;
		}
		break;
	case delobject:
		mysql_query("delete from $objecttable where id = '$id'");
		break;
}

?>