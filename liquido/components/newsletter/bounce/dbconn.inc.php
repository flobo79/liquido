<?
// DB Settings
define("DBTYPE","mysql");
define("PREFIX",DBPREFIX."_liquido_nl_bounce_");

// Bounce DB Object
$bouncedb =& $db;
/*
// Bounce DB Object
$bouncedb = NewADOConnection(DBTYPE,'pear');
$bouncedb->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (!$bouncedb) die("Systemfehler!");
$bouncedb->SetFetchMode(ADODB_FETCH_ASSOC);
//$bouncedb->debug = true;

// Liquido DB Object
$db = NewADOConnection(DBTYPE,'pear');
$db->Connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (!$db) die("Systemfehler!");
$db->SetFetchMode(ADODB_FETCH_ASSOC);
//$db->debug = true;
*/
?>
