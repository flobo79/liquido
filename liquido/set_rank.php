<?php

include("lib/init.php");

$maxrank = mysql_fetch_row(mysql_query("select MAX(rank) from $cfgtablecontents"));
$setrank = $maxrank[0] + 1;
$sql_objects = "select id from $cfgtablecontents where rank = '0'";
$q = mysql_query($sql_objects);
while($result = mysql_fetch_row($q)) {
	$check = mysql_query("update $cfgtablecontents set rank = '$setrank' where id = '$result[0]' LIMIT 1");
	echo "$result[0] set to rank $setrank\n";
	$setrank++;
}




?>