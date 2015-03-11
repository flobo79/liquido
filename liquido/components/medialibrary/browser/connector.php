<?php

$root = dirname(dirname(dirname(dirname((__FILE__)))));
$auth_noredirect = true;
require_once($root."/lib/init.php");
if(!$auth) die("logout");

require_once("mediabrowser.php");

$mb = new Mediabrowser();

if(isset($_POST['getList'])) {
	echo JSON_encode($mb->getChilds($_POST['getList']));
}

if(isset($_POST['getDetails'])) {
	$data = $mb->getDetails($_POST['getDetails']);
	if(isset($_POST['template'])) {
		echo $mb->loadTemplate($data, $_POST['template']);
	} else {
		echo JSON_encode($data);
	}
}
	
?>
