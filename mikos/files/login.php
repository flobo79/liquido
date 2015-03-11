<?

// header for demo - needs to be removed in liquido
define('WEBPAGE_DIR',str_replace('\\','/',dirname(__FILE__)).'/');
define('LOGIN_URL','login.php');

require_once ("../libs/adodb/adodb.inc.php");
require_once ("../libs/smarty/Smarty.class.php");
require_once ('../libs/class.KIS.php');

session_start();
header('Content-Type: text/html; charset=UTF-8');

// if kis is not initialised do that
if(array_key_exists('kis',$_SESSION) === false or $_GET['kis'] == 'reload')
{
	$_SESSION['kis'] = new Kis();
}

/**
 * Verarbeiten von POST-Daten
 */
if($_POST && array_key_exists('action',$_POST) && $_POST['action'] == 'login')
{
	$_SESSION['kis']->mikos_login($_POST['username'],$_POST['password']);
}


if($_SESSION['kis']->loggedIn)
{
	header('Location: edit.php');
}
else
{
	
	$kis->smarty->compile_dir = dirname(dirname(__FILE__)).'/templates_c';
	$kis->smarty->display(dirname(dirname(__FILE__)).'/templates/login.html');
}

?>
