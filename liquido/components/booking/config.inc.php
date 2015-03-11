<?

define(WEBPAGE_DIR,"/srv/web2/htdocs/liquido/");
define(COMPONENT_DIR,WEBPAGE_DIR."components/booking/");
define(SMARTY_DIR,WEBPAGE_DIR."lib/smarty/");
define(LIB_DIR,WEBPAGE_DIR."lib/");

require_once(SMARTY_DIR.'Smarty.class.php');
require_once(SMARTY_DIR.'SmartyValidate.class.php');
require_once(WEBPAGE_DIR."lib/adodb/adodb.inc.php");
//require_once(WEBPAGE_DIR."lib/adodb_lite/adodb.inc.php");
require_once("dbconn.inc.php");

?>
