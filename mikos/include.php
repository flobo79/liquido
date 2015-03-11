<?php


// load Classes
$incpath = dirname(__FILE__);

require_once($incpath."/libs/class.KIS.php");
require_once($incpath."/libs/class.CPIS.php");

// if session is not started yet - start
if(!$_SESSION) { session_start(); }


require_once $incpath."/kis.php";
require_once $incpath."/cpis.php";



?>