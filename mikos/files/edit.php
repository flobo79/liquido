<?

require_once("../kis.php");

$kis->requireLogin();

/**
 * Verarbeiten von POST-Daten
 */
if($_POST && array_key_exists('action',$_POST) && $_POST['action'] == 'edit')
{
	if(array_key_exists('custInfo',$_POST))
	{
		foreach($_POST['custInfo'] as $key => $value)
		{
			$_SESSION['kis']->custInfo->$key = $value;
		}
		$res = $_SESSION['kis']->call('CMUpdateCustomerDetails',array('customer' => $_SESSION['kis']->custInfo));
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

/*
echo "<pre>";
print_r($_SESSION['mikos']);
//print_r($_SESSION['mikos']->custInfo);
echo "</pre>";
*/

$kis->smarty->compile_dir = dirname(dirname(__FILE__)).'/templates_c';
$kis->smarty->display(dirname(dirname(__FILE__)).'/templates/myData.html');

?>
