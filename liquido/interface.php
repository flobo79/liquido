<?php


// liquido - startdatei
require_once("lib/cfg.php");
require_once("lib/fnc_mysql.inc.php");
require_once("lib/parser.php");
require_once("lib/class_css.php");
require_once("lib/class_settings.php");


$css = new CSS();

// listen for ajax calls

// if someone calls a xclass
if($xclass = $_GET['xclass'] or $xclass = $_POST['xclass']) {
	$xclass = db_entry("select * from `".db_table("temp_classes")."` where `id` = ".intval($xclass)." LIMIT 1");
	if($xclass['id']) {
		echo parseClass($xclass);
	}
}

if($_GET['xstructure']) {
	$obj = db_entry("select * from `".db_table("temp_structures")."` where `id` = ".intval($_GET['xstructure'])." LIMIT 1");
	if($obj['id']) {
		echo parseTag(array('','xstructure',$obj['id']));
	}
}


?>