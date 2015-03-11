<?php


function get_setting($type,$varname) {
	global $db;
	$foo =  $db -> getall("select varvalue from ".db_table('settings')." where vartype = '$type' and varname = '$varname' LIMIT 1");
	return $foo[0]['varvalue'];
}

function set_setting($type,$varname,$varvalue) {
	global $db;
	$db -> execute("update ".db_table('settings')." set varvalue = '$varvalue' where vartype = '$type' and varname = '$varname' LIMIT 1");
}
?>