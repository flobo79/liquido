<?
if(!defined('LIQUIDO'))
{
    require_once('header.inc.php');
}

$_SESSION['mikos']->requireLogin();

/*$cl = $_SESSION['mikos']->call('getCardsList');
$cardlist = parseObjectList($cl);

$smarty->assign('custInfo',$_SESSION['mikos']->custInfo);
$smarty->assign('cards',$cardlist);
*/
$smarty->display('partners.html');

?>
