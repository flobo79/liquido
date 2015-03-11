<?php

// read the config
require_once('config.inc.php');

// get the common functions library (MY_ functions)
require_once('lib/common.lib.php');

// get the informal functions libraries (MY_ functions)
require_once('lib/ifl_actions.lib.php');
require_once('lib/ifl_misc.lib.php');

// get database function library
require_once('lib/database.lib.php');

// get authentification function library (AUTH_ functions)
require_once('lib/auth.lib.php');

// get additional wddx functions
require_once('lib/wddx.lib.php');

//include element classes
require_once('lib/element.class.php');
$element = new element;
foreach($element->all as $name) {
	require_once('lib/element_' . $name . '.class.php');
}

// FIXME: get the paths right
$current_include_path = ini_get("include_path");
ini_set('include_path', $current_include_path . INFORMAL_FILEROOT
    . 'lib/pear');

// get PEAR quickform classes
require_once('lib/pear/HTML/QuickForm.php');
require_once('lib/pear/HTML/QuickForm/Renderer/ArraySmarty.php');

// get form class (quickform wrapper)
require_once('lib/form.class.php');

// get form registry class
require_once('lib/all_forms.class.php');

// get informal functions
require_once('lib/informal.lib.php');

// get string_test classes
require_once('lib/string_test.class.php');

// get informal class
require_once('lib/informal.class.php');

// get database classes
if (!function_exists('adonewconnection')) {
    require_once('lib/adodb_lite/adodb.inc.php');
}
require_once('lib/database.class.php');

// include smarty
if (!class_exists('smarty')) {
    require_once('lib/smarty/Smarty.class.php');
}

// start session management if sessions are used
if ($cfg['sessions']['used']) {
	session_start();
}

// get page class
require_once('lib/page.class.php');

// get form_page class
require_once('lib/form_page.class.php');

// get admin page classes
require_once('lib/admin_page.class.php');
$admin_page = new admin_page;
foreach($admin_page->all as $name) {
	require_once('lib/admin_page_' . $name . '.class.php');
}

// get form_element class
require_once('lib/form_element.class.php');

// define global constants and variables
if ($_GET['f']) $GLOBALS['informal_form_id'] = intval($_GET['f']);
define('INFORMAL_ELEMENT_CLASS_PREFIX', 'element_');
define('INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX', 'collector_');
define('INFORMAL_ELEMENT_MULTIPLE_PREFIX', 'option_');

?>
