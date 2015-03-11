<?php

// boot informal
require_once('bootstrap.php');

if ($_GET['a']) {
	$page = new admin_page;
} else if ($_GET['f']) {
	$page = new form_page;
} else {
	$page = new admin_page_list;
}

$page->display();
exit();

?>
