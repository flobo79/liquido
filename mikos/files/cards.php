<?
if(!defined('LIQUIDO'))
{
    require_once('header.inc.php');
}

$_SESSION['mikos']->requireLogin();

$cl = $_SESSION['mikos']->call('getCardsList');
$cardlist = parseObjectList($cl);

/*
echo "<pre>";
print_r($cardlist);
echo "</pre>";
*/

$smarty->assign('custInfo',$_SESSION['mikos']->custInfo);
$smarty->assign('cards',$cardlist);
$smarty->display('cards.html');

?>
