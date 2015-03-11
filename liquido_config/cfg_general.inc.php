<?php 
	
/*
			
	LIQUIDO 
	c by media5k 2003 | florian bosselmann | info@media5k.de

*/

$cfg = array();

## modrewrite-einstellungen
$cfg['mr'] = array(
	"enabled" 	=> "1",
	"prefix" 	=> "vwclub"
);
	

// umgebungseinstellungen
$cfg['env'] = array(
	"projecttitle" 	=> "Volkswagen Club",		
	"host" 			=> "http://www.vw-club.de",
	"defaultmail" 	=> "kontakt@volkswagen-club.de",
	"cmspath" 		=> "/liquido",
	"cmspicdir" 	=> "/liquido_images",
	"cmslibdir" 	=> "/liquido_medialib",
	"cmsdocdir"		=> "/liquido_documents",
	"defaultlang" 	=> "de_DE",
	"skin"			=> "blue",
	"document_root" => $_SERVER['DOCUMENT_ROOT']
);
	
$cfg['auth']['SessionLifetime'] = 7200;			// zeit in sek für automatischen logout bei inaktivität

#### visuals
$cfg['visual']['pagefade'] 	= 0;		// fade effect ie only


#### components
$cfg['components'] = array(
	### medienbibliothek
	"medialib" => array(
		"maxsize_x" 		=> 800,		// maxmalwert für bilder
		"maxsize_y" 		=> 800,		// maxmalwert für bilder
		
		// wasserzeichen
		"watermark1" 		=> "",		// für das thumbnail
		"watermark2" 		=> "",		// für kleindarstellung
		"watermark3" 		=> "",		// für die originaldarstellung
		
		"saveoriginal" 		=> 0,		// soll das original vor bearbeitung geschützt werden?
		"lossless"			=> 0		// bilder standardmässig komprimieren
	),
	
	### contents
	"contents" => array(
		// compose
		"compose" => array (
			"lock" 			=> 1,		// gleichzeitiges bearbeiten von contents verhindern?
			"fallback" 		=> 0,		
			"enable_groups" => 1,		// können gruppen inhalte besitzen
			"picwidth" 		=> 180,		// standardbildbreite beim einfügen von objekten
			"textmargin"	=> 20
		),
		"css" => array(
			'/liquido/css/vwc.css'
		)
	),
	
	### newsletter
	"newsletter" => array(
		"returnpath" 		=> "kontakt@volkswagen-club.de",
		"from_name" 		=> "Volkswagen Club",
		"from_mail" 		=> "kontakt@volkswagen-club.de",
		"organisation" 		=> "Volkswagen Club",
		"tools"				=> "/newsletter",
		"sendreportto"		=> "r.schindler@missionmedia.de,m.reisch@missionmedia.de"
	)
);


if(!defined("DOCUMENT_ROOT")) 	define('DOCUMENT_ROOT',dirname(dirname(__FILE__)));

// define some constants
require_once(dirname(__FILE__).'/constants.inc.php');
?>