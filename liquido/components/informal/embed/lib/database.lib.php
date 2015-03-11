<?php

//
// db_query() - runs a database query
//
// usage: db_query(<mysql_query_string>)
// expects $query to be a sigle line or an array with several queries like
// Array([0] => Array ([query] => "SELECT"))


function MY_dbQuery($query)
{
	global $cfg;
    $link = mysql_connect($cfg['mysql']['host'], $cfg['mysql']['user'], $cfg['mysql']['pass'])
		or die("Server Error: Could not access database (" . mysql_error() . ").");
    mysql_select_db($cfg['mysql']['database'], $link)
		or die("Server Error: Could not access database (" . mysql_error() . ").");
    if (gettype($query) == "array") {
		foreach ($query as $query_line) {
			mysql_query($query_line['query'], $link) or die("Server Error: Could not access database (" . mysql_error() . ").");
		}
	} else {
		$result = mysql_query($query, $link) or die("Server Error: Could not access database (" . mysql_error() . ").");
	}
	global $MYSQL_INSERT_ID;
	$MYSQL_INSERT_ID = mysql_insert_id($link);
	mysql_close($link);
    return $result;
}

//
// db_array() - runs a database query and returns an array with the result
//
// usage: db_array(<mysql_query_string>)
// note: uses db_query()
//
function MY_dbArray($query)
{
    $result = MY_dbQuery($query);
    $result_array = array();
    while ($row = mysql_fetch_assoc($result))
    {
        array_push($result_array, $row);
    }
    return $result_array;
}

//
// db_simple_array() - runs a database query and returns a simple array with the result
//
// usage: db_simple_array(<mysql_query_string>)
// note: uses db_query()
//
function MY_dbSimpleArray($query)
{
    $result = MY_dbQuery($query);
    $result_array = array();
    while ($row = mysql_fetch_row($result))
    {
        $result_array[$row[0]] = $row[1];
    }
    return $result_array;
}

?>
