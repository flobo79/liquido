<?
define('SMARTY_DIR',$_SERVER['DOCUMENT_ROOT']."/liquido/lib/smarty/");
define('WEBPAGE_DIR',$_SERVER['DOCUMENT_ROOT']."/liquido/modules/content_stats/");
require_once(SMARTY_DIR.'Smarty.class.php');
$smarty=new Smarty;
$smarty->template_dir = WEBPAGE_DIR.'templates/';
$smarty->compile_dir = WEBPAGE_DIR.'templates_c/';
$smarty->config_dir = WEBPAGE_DIR.'configs/';
//$smarty->plugins_dir[0] = SMARTY_DIR.'plugins';
$smarty->compile_check = true;
//$smarty->debugging = true;
?>
