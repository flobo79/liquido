<?php

error_reporting(E_ALL);

/*** 
 *  LIQUIDO INDEX FILE         
 */


$frontend = true;
$auth_noredirect = true;
require_once(dirname(__FILE__).'/liquido/lib/init.php');
require_once(dirname(__FILE__).'/liquido/lib/class_page.php');
require_once(dirname(__FILE__).'/liquido/lib/class_parser.php');
require_once(dirname(__FILE__)."/liquido/lib/fnc_public.php");

if(isset($_GET['stat'])) {
		$stat = new Statistic();
		$stat->setTable('content_stats')->writeStat(1);
}


$_SESSION['pages_nocache'] = array(946);


// Mikos Additions
$display = new Page();

require_once($docroot."/mikos/include.php");

// workaround


mysql_select_db($dbname);

$display->display();


?>