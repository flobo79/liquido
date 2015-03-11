<?php

define('INFORMAL_EMBEDDED', false);
define('INFORMAL_DATABASE_DSN', 'mysql://fckgw:rhqq2@localhost/web2');
define('INFORMAL_DATABASE_TABLE_PREFIX', 'informal_');
define('INFORMAL_VERSION', '0.7.0.1');
define('INFORMAL_PAGE_TITLE_SEPARATOR', ' | ');
define('INFORMAL_FORM_ELEMENT_NAME_PREFIX', 'e');

define('INFORMAL_PAGE_TITLE_SUFFIX', INFORMAL_PAGE_TITLE_SEPARATOR
    . 'informal ' . INFORMAL_VERSION);

//FIXME: any nicer way to do this?
define('INFORMAL_WEBROOT', str_replace(strrchr($_SERVER["SCRIPT_NAME"],"/"),
    '',$_SERVER["SCRIPT_NAME"]) . '/');

// detect the informal file root
//FIXME: any nicer way to do this?
$informal_fileroot = str_replace(strrchr($_SERVER["SCRIPT_FILENAME"],"/")
    ,'',$_SERVER["SCRIPT_FILENAME"]) . '/';

// if embedded add path to informal from embedder
if (INFORMAL_EMBEDDED && INFORMAL_SUBDIR != 'INFORMAL_SUBDIR') {
    $informal_fileroot .= INFORMAL_SUBDIR; //defined in embed.php
}
define('INFORMAL_FILEROOT', $informal_fileroot);
define('INFORMAL_URLBASE',$PHP_SELF);

// smarty settings
define('INFORMAL_SMARTY_COMPILE', 'smarty/templates_c');
define('INFORMAL_SMARTY_CACHE', 'smarty/cache');

//
// general configuration 
// FIXME: $cfg is still in use!
//
$cfg['software']['name'] = 'informal';
$cfg['lists']['max_chars'] = 50;

//
// themes
//
$cfg['themes']['default'] = 'default';

//
// some internal settings and automatic self configuration (don't change anything here)
//
$cfg['page']['title_suffix'] = ' | ' . $cfg['software']['name'] . ' ' . $cfg['software']['version'];
$cfg['path']['webroot'] = str_replace(strrchr($_SERVER["SCRIPT_NAME"],"/"),'',$_SERVER["SCRIPT_NAME"]) . '/';
$cfg['path']['fileroot'] = str_replace(strrchr($_SERVER["SCRIPT_FILENAME"],"/"),'',$_SERVER["SCRIPT_FILENAME"]) . '/';
$cfg['url']['informal'] = 'http://' . $_SERVER["HTTP_HOST"] . $cfg['path']['webroot'];
$cfg['auth']['usertable'] = 'auth_users';
$cfg['auth']['grouptable'] = 'auth_groups';
$cfg['sessions']['used'] = 'true';

?>
