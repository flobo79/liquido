<?php

header("Content-type: text/html; charset=UTF-8");


// load Classes
$incpath = dirname(__FILE__);
require_once ($incpath.'/libs/class.KIS.php');
require_once ($incpath.'/libs/class.CPIS.php');

// if session is not started yet - start
if(!$_SESSION) {
	session_start();
}

// if kis is not initialised do that
if(array_key_exists('kis',$_SESSION) === false or isset($_GET['resetkis'])) {
	$_SESSION['kis'] = new KIS();
} else {
	$_SESSION['kis']->KIS();
}



/**
* page wrapper
*
* Set pages set automaticly load KIS methods
*/
$pageident = 'page';
$pages = array(
	195 => 'showMyData',
	627 => 'showMyData',  				
	763 => 'showMyDataEdit',
	699 => 'showMyPoints',
	700 => 'showMyCars',
	770 => 'showMyCarsEdit',
	701 => 'showMyDealer',
	702 => 'showMyCards',
	985 => 'showRegisterForm',
	993 => 'showForgotPasswordForm',
	995 => 'showVerifyEmailForm',
	997 => 'doConfirmation',
	999 => 'showMyDealerDetails',
	766 => 'showLoginForm'
);

$kis = $_SESSION['kis'];


/**
* page wrapper loader
*
* if the $pageident variable matches an entry in the page wrapper
* array, load that function
*/
$page = $display->id;
if(isset($page) && array_key_exists($page, $pages)) {
	$_SESSION['kis']->$pages[$page]();
}


?>
