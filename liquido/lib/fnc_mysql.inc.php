<?php

require(dirname(dirname(dirname(__FILE__)))."/liquido_config/cfg_mysql.inc.php");
require(dirname(__FILE__)."/adodb/adodb.inc.php");

global $db;
$db = ADONewConnection('mysql');
$db->Connect($dbhost, $dbuser, $dbpass, $dbname);

$db->query('SET character_set_database=UTF8');
$db->query('SET character_set_client=UTF8');
$db->query('SET character_set_connection=UTF8');
$db->query('SET character_set_results=UTF8');
$db->query('SET character_set_server=UTF8');
$db->query('SET names UTF8');



function GetWriteSQL ($svTable, $saRecord,$nofieldindex=0){
	include(CONFIGDIR."cfg_mysql.inc.php");

	$svFields = '';
	$svValues = '';
	
	$replace = $dbprefix."_liquido_";
	$table = ereg_replace($replace,"","$svTable");
	$dbfields = $cfgfields[$table];

	while (list($field, $value) = each($saRecord)) 	{
		if (!get_magic_quotes_gpc())      // Wenn nicht eingeschaltet
		$value = addslashes($value);
	
		// prüfe ob das feld valide ist (in cfg_mysql.inc.php)
		if($nofieldindex) {
			$svFields .= mysql_escape_string($field).", "; 
			$svValues .= "'".mysql_escape_string($value)."', ";
			
		} else {
			if(ereg($field,$dbfields)) {
				$svFields .= "$field, "; 
				$svValues .= "'$value', ";
			}
		}
	}
	
	// sql-statement ohne komma am ende ** get string without last comma
	$svFields = substr($svFields,0,strlen($svFields)-2);
	$svValues = substr($svValues,0,strlen($svValues)-2);
	
	$svSQL  = "insert into $svTable ($svFields) values ($svValues)";
	
	return $svSQL;

}

function GetUpdateSQL ($svTable, $saRecord) {
	include(CONFIGDIR."cfg_mysql.inc.php");
	
	$replace = $dbprefix."_liquido_";
	$table = ereg_replace($replace,"","$svTable");
	$dbfields = $cfgfields[$table];
    
	$svString = '';
	  foreach($saRecord as $field => $value) {
			
			//if (!get_magic_quotes_gpc()) $value = addslashes($value);    // Wenn nicht eingeschaltet
			
			// prüfe ob das feld valide ist (in cfg_mysql.inc.php)
			if(ereg($field,$dbfields)) {
				$svString .= "`$field`='".mysql_real_escape_string($value)."', ";
			}
	   }
   
   // sql-statement ohne komma am ende ** get string without trailing comma
   //$svString = substr($svString,0,strlen($svString)-2);
   
   $svSQL  = "update `$svTable` set $svString id='$saRecord[id]' where `id`='$saRecord[id]'";

   return $svSQL;
}

function OpenDatabase ()
{
	global $dbconnected;

   if (!$dbconnected)
   {  
   	  include (CONFIGDIR."cfg_mysql.inc.php");
   	

	  $ConID = @mysql_connect($dbhost, $dbuser, $dbpass);
	  $bCheck = @mysql_select_db($dbname, $ConID);
	  //mysql_set_charset('utf8',$ConID); 
	  // Überprüfe, ob Connection stattgefunden hat ** if connection failed
	  
	  if($ConID) {
	  	$dbconnected = "yes";
		global $dbconnected;
	  } else {
		 echo "Connection to SQL-Server $dbhost failed";
		 exit;
	  }

	  if(!$bCheck)
	  {
		echo "Etwas ist beim Verbinden zur Datenbank $dbname fehlgeschlagen";
		exit;
	  }
   
   }
   return $ConID;
}

//OpenDatabase();


function db_table($table) {
	include (CONFIGDIR."cfg_mysql.inc.php");

	$table = $dbprefix."_liquido_".$table;
	if(table_exists($table)) return $table;
	echo "table $table doesnt exists";
}

function table_exists($table) {
	include (CONFIGDIR."cfg_mysql.inc.php");
	global $tables;
	if(!$tables) {
		$gettables = mysql_list_tables($dbname);
		while (list($temp) = mysql_fetch_array($gettables)) {
			$tables[] = $temp;
		}
	}
	if(in_array($table,$tables)) return true;
	return FALSE;
}

function db_query ($q,$db=0) {
	global $num_queries;
	global $db;
	
	$num_queries++;
	//mysql_query("SET NAMES 'utf8'");
	if($r = $db->execute($q)) {
		return $r;
	} else {
		die(mysql_error());
	}
}

function db_entry($sql,$type=0,$db=0) {
	global $db;
	return $db->GetRow($sql);
}


function db_array($query,$type=0,$db=0) {
	if($db) db_use($db);
	global $db;
	return $db->GetAll($query);
	
	
	$result = db_query($query);
	$result_array = array();
	
	if(!$type) $type = MYSQL_BOTH;
	while ($row = mysql_fetch_array($result,$type)) {
		array_push($result_array, $row);
	}
	return $result_array;
}

function db_insert_id() {
	return mysql_insert_id();
}


/*
Escapet einen Array wie $_POST und $_GET für SQL Abfragen
*/
function castUserData($data) {
	$result = array();
	foreach ($data as $key => $value) {
	  $arr = explode("_",$key,1);
	  if(count($arr) == 2 && strlen($arr[0]) == 1) {
		  // $arr[0] enthällt dann s / i / f / ... und $arr[1] den varnamen
		  if($arr[0]=="i") {
			$result[$key] = intval($value);
		  } else if($arr[0]=="f") {
			$result[$key] = floatval(str_replace(",",".",$value));
		  } else {
			$result[$key] = $this->SqlEscapeArg($value);
		  }
	  } else {
		$result[$key] = $this->SqlEscapeArg($value);
	  }
	}
}

function prepareData(&$PD,&$GD) {
	if($_POST) {
		$PD=$this->castUserData($_POST);
	}
	if($_GET) {
		$GD=$this->castUserData($_GET);
	}
}

?>