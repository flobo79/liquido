<?
if(!defined('LIQUIDO'))
{
    require_once('header.inc.php');
}

$_SESSION['mikos']->requireLogin();

/**
 * Verarbeiten von POST-Daten
 */
if($_POST && array_key_exists('action',$_POST) && $_POST['action'] == 'edit')
{
	if(array_key_exists('custInfo',$_POST))
	{
		foreach($_POST['custInfo'] as $key => $value)
		{
			$_SESSION['mikos']->custInfo->$key = $value;
		}
		$res = $_SESSION['mikos']->call('CMUpdateCustomerDetails',array('customer' => $_SESSION['mikos']->custInfo));
		if($res)
		{
			$smarty->assign('notice','Ihre Kundendaten wurden aktualisiert.');
		}
		else
		{
			$smarty->assign('notice','Fehler beim Aktualisieren Ihrer Kundendaten.');
		}
	}
}

$smarty->assign('custInfo',$_SESSION['mikos']->custInfo);
$smarty->display('editdaten.html');

?>
