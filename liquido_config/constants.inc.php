<?php

define('DOCROOT', $docroot);
define("LIQUIDO","/liquido");
define("MEDIALIB",$cfg['env']['cmslibdir']);
define("IMAGES",$cfg['env']['cmspicdir']);
if(!defined('HOST')) define("HOST",'http://www.vw-club.de');
define("SKIN",LIQUIDO."/skins/".$cfg['env']['skin']);
define("DOCUMENTS",$cfg['env']['cmsdocdir']);
define("CONFIGDIR",DOCUMENT_ROOT."/liquido_config/");
define("OBJECTSDIR",DOCUMENT_ROOT."/liquido_objects/");
define("IMAGESDIR",DOCUMENT_ROOT."/liquido_images/");
define("CONTAINERDIR","/liquido_container/");
define("DOWNLOADSDIR","/liquido_downloads/");
define("DBPREFIX", $dbprefix);
define('PHP_BIN', '/usr/bin/php5');
define('PAGE_404', 1315);

?>
