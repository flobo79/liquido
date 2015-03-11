<?
if(!defined('LIQUIDO'))
{
    require_once('header.inc.php');
}

$_SESSION['mikos']->requireLogin();

$cl = $_SESSION['mikos']->call('getValidContractsMCListByMemberAndMandant',array('mandantId' => $_SESSION['mikos']->custInfo->mandantId));
$carlist = parseObjectList($cl);

/*
echo "<pre>";
print_r($carlist);
echo "</pre>";
*/

$smarty->assign('custInfo',$_SESSION['mikos']->custInfo);
$smarty->assign('cars',$carlist);
$smarty->display('cars.html');

?>
