<?php
require_once($_SERVER['DOCUMENT_ROOT']."/liquido/lib/init.php");
require_once('libs/Statistics.php');

$page = array_key_exists('p', $_GET) ? $_GET['p'] : '';
switch($page)
{
	case 'monthdetails':
		$year = $_GET && is_array($_GET) && array_key_exists('y',$_GET) ? $_GET['y'] : date("Y");
		$month = $_GET && is_array($_GET) && array_key_exists('m',$_GET) ? $_GET['m'] : date("m");
		$smarty->assign('stats',Statistics::getMonthDetails($month,$year));
		$smarty->display('monthdetails.html');
		break;
	case '':
	default:
		$year = $_POST && is_array($_POST) && array_key_exists('year',$_POST) ? $_POST['year'] : date("Y");
		$yearrange = Statistics::getYears();
		
		$smarty->assign('year',$year);
		$smarty->assign('yearrange',$yearrange);
		$smarty->assign('chart',Statistics::getOverviewImg($year));
		$smarty->assign('stats',Statistics::getOverviewData($year));
		
		$smarty->display('gesamtstatistik.html');
		break;
}

$db->Close();

?>
