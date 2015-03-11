<?php




    include(dirname(__FILE__)."/init.php");
	$param = json_decode(preg_replace('/[\n\r]+/', '\n',stripslashes ($_POST['json'])), true) 
		or die("error: DATA could not be parsed from json string");
	
	$query = explode(':', $param['query']);
	if(count($query) != 3) die("error: query incorrect");
	
	if($query[0] == 'module') {
		// requires the module to be a class with the same name as the module
		require(dirname(dirname(__FILE__))."/modules/".$query[1]."/module.inc.php");
		$module = new $query[1]();
		
		// if not logged in, and param auth_noredirect defined - ie by ajax connectors
		if(!$auth && !$module->noAuth) header("Location:/liquido/login.php?l=$location");
		
		$module->$query[2]($param['parameter']);
		
	} else {
		// if not logged in, and param auth_noredirect defined
		if(!$auth && !$auth_noredirect) header("Location:/liquido/login.php?l=$location");
		
		$access = loadAccessTable($_SESSION['user'], $query[0]);
		if(!$access['access']) die("error: no access to this component");
		
		require(dirname(dirname(__FILE__))."/components/".$query[0]."/functions.inc.php");
		require(dirname(dirname(__FILE__))."/components/".$query[0]."/".$query[1]."/functions.inc.php");
		
		if(!function_exists($query[2])) die("error: method ".$query[2]." does not exist in class ".$query[0]);

		$query[2]($param['parameter']);
	}
?>
