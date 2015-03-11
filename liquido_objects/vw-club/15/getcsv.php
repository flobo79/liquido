<?php 

ob_start();
include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/init.php");
$questions = $db->getArray("select title from kis_game_questions order by id");
$customers = $db->getArray("select distinct kis_kunr from kis_game_answers order by q_id ");
	

echo "Ku-Nr;";
foreach($questions as $q) { 
	echo $q['title'].";";
}
echo "\n";


foreach($customers as $c) {
	echo "$c[kis_kunr];";
	$answers = db_array("select q_id, text from kis_game_answers where kis_kunr = '$c[kis_kunr]'");
	foreach($answers as $a) {
		echo $a['text'].";";
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

