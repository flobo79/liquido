<?
require_once('header.inc.php');

$_SESSION['mikos']->logout();

session_destroy();
header('Location: http://web2.baggerware.com/index.php?page=627');
?>
