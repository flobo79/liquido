<?php

$root = dirname(dirname(dirname(__FILE__)));
$auth_noredirect = true;
require_once($root."/lib/init.php");
//if(!$auth) die("logout");

require_once(dirname(__FILE__)."/slideshow.php");
$obj = false;
if($_POST['obj']) $obj = db_entry("select * from ".db_table('contentobjects')." where id = '".intval($_POST['obj'])."' LIMIT 1");

$sl = new Slideshow($obj);


if(isset($_POST['setFolder'])) {
	$sql = "update ".$sl->table." set 
		`smalltext1` = '".intval($_POST['setFolder'])."'
		where id = ".intval($_POST['obj'])." limit 1";
	
	$sl->db->execute($sql);
	$sl->setFolder($_POST['setFolder']);
	$sl->thumbs = $_POST['number'];
	
	$return = array();
	$return['data'] = $sl->data;
	$return['html'] = $sl->display(true);
	
	echo json_encode($return);
}



if(isset($_POST['getItem'])) {
	$sl->setFolder($_POST['folder']);
	echo json_encode($sl->getItem($_POST['getItem']));
}


if(isset($_POST['loadGal'])) {
	$sl->setFolder($_POST['loadGal']);
	$sl->loadGal($_POST);
}

?>
