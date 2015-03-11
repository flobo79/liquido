<?php
include("../../../lib/init.php");
include("../functions.inc.php");
include("functions.inc.php");


// erstelle neue ausgabe
if($insert) {
	$insert['table'] ="contents";
	$insert['type'] ="nl_issue";
	$thiscomp['id'] = insert($insert);
	$update_leftpane = 1;
}


// lade ausgaben
$issues = getIssues();

// auferbeiten der Kurzstatistik
$statbarlength = 100;	// die gesamtlänge der anzeigebar
foreach($issues as $key => $issue) {
	
	if($issue['publishs']) {
		$laststat=array_pop($issue['publishs']);		
		$rel = $laststat['pb_sent_total'] ? $statbarlength / $laststat['pb_sent_total'] : 0; 
		$laststat['length_bounce'] = round($laststat['bounces']['number'] * $rel);
		$laststat['length_reads'] = round($laststat['pb_reads'] * $rel);
		$laststat['length_rest'] = $statbarlength - $laststat['length_bounce'] - $laststat['length_reads'];
		$issues[$key]['laststat'] = $laststat;
	}

}

$smarty->assign("stati",array("in Bearbeitung","Redaktionsschluss","Redaktion freigegeben", "Versand freigegeben","versendet"));
$smarty->assign("access",$access);
$smarty->assign("statbarlength",$statbarlength);
$smarty->assign("issues",$issues);

$smarty->display(dirname(__FILE__)."/templates/list.tpl");

?>