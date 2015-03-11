<?php 

ob_start();
include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/cfg.php");
include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/function_public.php");
include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/fnc_mysql.inc.php");
$questions = db_array("SELECT title FROM mc_game_questions ORDER BY id");
$customers = db_array("SELECT * FROM mc_game_answers GROUP BY kis_kunr");

echo "Name;Vorname;Straße;PLZ;Ort;VW-Partner;Mitgliedsnummer;MEV;";
foreach($questions as $q) { 
	echo $q['title'].";";
}
echo "\n";


foreach($customers as $c) {
	echo "$c[Name];$c[Vorname];$c[Street];$c[plz];$c[ort];$c[partner];$c[kis_kunr];$c[MEV];";
	$answers = db_array("select q_id, text from mc_game_answers where kis_kunr = '$c[kis_kunr]'");
	foreach($answers as $a) {
		echo trim(urldecode($a['text'])).";";
	}
	echo "\n";	
} 


$foo = ob_get_contents();
ob_end_clean();


header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header('Content-Length: ' .strlen($foo));
header('Content-Disposition: attachment; filename=liste.csv');


echo $foo;

?>

