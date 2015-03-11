<?

// Liquido Config
require_once('../../../lib/init.php');

/*
// Konstanten
if($_SERVER["SERVER_ADDR"]=="127.0.0.1") {
	define(WEBPAGE_DIR,"S:/Webdesign/HtDocs/bounce_check/");
  define('SMARTY_DIR', 'Smarty/');
} else {
  ini_set("include_path", ".:/usr/lib/php");
	define(WEBPAGE_DIR,"/var/www/localhost/htdocs/bouncetest/");
  define('SMARTY_DIR', '/usr/lib/php/Smarty/');
}

// Template Engine
require_once(SMARTY_DIR.'Smarty.class.php');
$smarty=new Smarty;
$smarty->config_dir = WEBPAGE_DIR.'configs/';
$smarty->plugins_dir[0] = SMARTY_DIR.'plugins';
$smarty->cache = false;
$smarty->compile_check = true;
*/
define(WEBPAGE_DIR,dirname( __FILE__ ));
$smarty->template_dir = WEBPAGE_DIR.'/templates/';
$smarty->compile_dir = WEBPAGE_DIR.'/templates_c/';
$smarty->left_delimiter='[{';
$smarty->right_delimiter='}]';

// AJAX
require_once('bnc.xajax.common.php');

function output($template) {
  $GLOBALS['smarty']->display($template);
  $GLOBALS['db']->Close();
}

define("DBTYPE","mysql");
define("PREFIX","vwc_liquido_nl_bounce_");

//require_once("dbconn.inc.php");


?>
