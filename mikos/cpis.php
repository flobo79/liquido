<?php

header("Content-type: text/html; charset=UTF-8");

// load Classes
$incpath = dirname(__FILE__);
require_once ($incpath.'/libs/class.KIS.php');
require_once ($incpath.'/libs/class.CPIS.php');


// if cpis is not initialised do that
if(array_key_exists('cpis',$_SESSION) === false or isset($_GET['resetcpis'])) {
	$_SESSION['cpis'] = new CPIS();
} else {
	$_SESSION['cpis']->CPIS();
}

/**
* page wrapper
*
* Set pages set automaticly load CPIS methods
*/
$pageident = 'page';
$pages = array(
	1001 => 'showLoginForm',
	634  => 'showMyEmployees',
	1009 => 'showMyData',
	631 => 'showMyData',
	1007 => 'showMyDataEdit',
	1499 => 'showMyMember',
	632 => 'showMyProoflists',
	1011 => 'showMyEmployeeDetails',
	1013 => 'showForgotPasswordForm',
	1029 => 'showVerifyEmailForm',
	1410 => 'showMemberList',
	1029 => 'showVerifyEmailForm',
	1423 => 'showMemberList'
);

/**
* page wrapper loader
*
* if the $pageident variable matches an entry in the page wrapper
* array, load that function
*/
$page = $display->id;
if(isset($page) && array_key_exists($page, $pages)) {
	$_SESSION['cpis']->$pages[$page]();
}

?>