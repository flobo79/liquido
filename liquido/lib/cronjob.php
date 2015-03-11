<?php

## stelle datum fest....

include("cfg_mysql.inc.php");
include("fnc_mysql.inc.php");

$date = time();
setlocale ("LC_TIME", "de_DE");
$date = strftime ("%d.%m.%y", $date);

$conID = OpenDatabase();
$svSQL = "select * from $cfgtablesceduler where date = '$date'";
$query = mysql_query($svSQL,$conID);
while ($result = mysql_fetch_array($query)) {

	$table = "cfgtable$result[table]";
	$settable = $$table;
	echo "update $settable set status = '$result[type]' where id = '$result[child_id]'";
	$updateresult = mysql_query("update $settable set status = '$result[type]' where id = '$result[child_id]'");
	if ($updateresult) mysql_query("delete from $cfgtablesceduler where id = '$result[id]'"); 

}

?>