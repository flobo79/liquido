<?php 

ob_start();
include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/cfg.php");
include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/function_public.php");
include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/fnc_mysql.inc.php");
$questions = db_array("select title from kis_mc_game_questions order by id");
$customers = db_array("SELECT * FROM kis_mc_game_answers GROUP BY kis_kunr");

echo "Ku-Nr;Name;Vorname;Adresse;Mitgliedsnummer;BNR;MEV;";
foreach($questions as $q) { 
	echo $q['title'].";";
}
echo "\n";


foreach($customers as $c) {
	echo "$c[kis_kunr];$c[Name];$c[Vorname];$c[Adresse];$c[Mitgliedsnummer];$c[BNR];$c[MEV];";
	$answers = db_array("select q_id, text from kis_mc_game_answers where kis_kunr = '$c[kis_kunr]'");
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

