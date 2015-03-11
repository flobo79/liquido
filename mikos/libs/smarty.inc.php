<?
define('SMARTY_DIR',str_replace('\\','/',dirname(__FILE__)).'/smarty/');
define('WEBPAGE_DIR',str_replace('\\','/',dirname(dirname(__FILE__))).'/');
require_once(SMARTY_DIR.'Smarty.class.php');
$this->smarty=new Smarty;
$this->smarty->left_delimiter='[{';
$this->smarty->right_delimiter='}]';
$this->smarty->config_dir = WEBPAGE_DIR.'configs/';
$this->smarty->plugins_dir[0] = SMARTY_DIR.'plugins';
$this->smarty->template_dir = WEBPAGE_DIR.'templates/';
$this->smarty->compile_dir = WEBPAGE_DIR.'templates_c/';
$this->smarty->cache = false;
$this->smarty->compile_check = true;

?>
