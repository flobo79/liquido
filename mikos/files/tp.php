<?
if(!defined('LIQUIDO'))
{
    require_once('header.inc.php');
}
$_SESSION['mikos']->requireLogin();

$pl = $_SESSION['mikos']->call('getMvBBookingsList');
$plist = parseObjectList($pl);

/*
echo "<pre>";
print_r($plist);
echo "</pre>";
*/

// round values for points and euroAmount
for ($i=0; $i<sizeof($plist); $i++)
{
	$plist[$i]->euroAmount = round($plist[$i]->euroAmount,2);
	$plist[$i]->points = round($plist[$i]->points,2);
}

// reverse array
krsort($plist);

// call smarty
$smarty->assign('custInfo',$_SESSION['mikos']->custInfo);
$smarty->assign('tp',$plist);
$smarty->display('treuepunkte.html');

?>
