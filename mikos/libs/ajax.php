<?php




/* FIREPHP SETUP */
#require_once('../../liquido/lib/FirePHPCore/fb.php');



// JSON wrapper - if not supported natively, create functions
if(!function_exists('json_encode')) {
	require_once("../../liquido/lib/class_json.php");
	function json_encode($obj) {
		$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		return $json->encode($obj);
	}
	
	function json_decode($str) {
		$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		return $json->decode($str);
	}
}

function __autoload($name) {
	$inc = dirname(__FILE__);
	if(ereg("ADO",$name)) {
		include_once $inc.'/adodb/adodb.inc.php';
		include_once $inc.'/adodb/drivers/adodb-'.LOCALDBTYPE.'.inc.php';
	
	} elseif ($name == 'SMARTY') {
		require_once ($inc."/smarty/Smarty.class.php");
	}
}

require_once ('class.KIS.php');
require_once ('class.CPIS.php');


session_start();


global $_POST;
if(array_key_exists('class',$_POST)) {
	$class = $_POST['class'];
	switch($class) {
		case 'KIS':
			$_SESSION['kis']->KIS();
			if(array_key_exists('kis',$_SESSION)) {
				$method = $_POST['kis_action'];
				$_SESSION['kis']->$method($_POST);
			} else {
				echo "action '".$_POST['kis_action']."' not available in KIS";
			}
			break;
		case 'CPIS':
			$_SESSION['cpis']->CPIS();
			if(array_key_exists('cpis',$_SESSION)) {
				$method = $_POST['cpis_action'];
				$_SESSION['cpis']->$method($_POST);
			} else {
				echo "action '".$_POST['cpis_action']."' not available in CPIS";
			}
			break;
	}
} else {
	echo "parameter 'class' is missing";
}


?>