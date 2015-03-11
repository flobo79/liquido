<?php

//require_once("include.php");


header('content-type: text/html; charset=utf-8');
require_once ((dirname(__FILE__))."/config.inc.php");	
require_once (dirname(__FILE__).'/libs/class.Mikos.dev.php');


//session_start();

// get myDealer
//$kis = $_SESSION['kis'];
//$cpis = $_SESSION['cpis'];

//$myDealer = $kis->parseObjectList($kis->call('getPartnerListByMemberId',array('memberId' => $kis->custInfo->id, 'mandantId' => $kis->custInfo->mandantId, 'contractMCisValid' => true)));


$Mikos = new Mikos();

//echo $cpis->mikos->loggedIn;

?>