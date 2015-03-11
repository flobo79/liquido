<?php

session_start();


if($_POST['updatescore']) {
	$file = getLogoList();
	foreach($_POST['updatescore'] as $i => $score) {
		$row = explode(":",$file[$i-1]);
		$file[$i-1] = $row[0].":".$score."\n";
	}
	$file = implode("",$file);
	writeFile($file);
}

if($_FILES['addlogo']['name'] && $_POST['addscore']) {
	if(ereg(".jpg$",$_FILES['addlogo']['name'])) {
		$filename = substr($_FILES['addlogo']['name'],0,-4);
		$filename=ereg_replace("[,;:äöüÄÖÜ&?]","",$filename).".jpg";
		if(!file_exists($target = $_SERVER['DOCUMENT_ROOT']."/vwgame/logos/".$filename)) copy($_FILES['addlogo']['tmp_name'],$target);
		
		$file = getLogoList();
		$file = implode("",$file);
		$file .= $filename.":".$_POST['addscore'];
		writeFile($file);
	}
}




if($_GET['dellogo']) {
	// lösche eintrag aus datei
	$file = getLogoList();
	unset($file[($_GET['dellogo']-1)]);
	$file = implode("",$file);
	writeFile($file);
	
	// bild wird nicht gelöscht da es eventuell noch verwendet wird
	
	header("Location:".$PHP_SELF."?part=logos");
}

function writeFile ($file) {
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."/vwgame/logos/list.txt","w");
		fwrite($fp,$file);
		fclose($fp);
}

function getList($select) {
	global $LQ;
	$from = mktime(0,0,0,$select['month'],0,$select['year']);
	$to = mktime(0,0,0,$select['month']+1,0,$select['year']);
	$sql = "select * from `game_highscores` where `date` between $from and $to order by `score` DESC LIMIT 10";
	$list = $LQ -> db_array($sql);
	return $list;
}


function getLogoList() {
	$list = file($_SERVER['DOCUMENT_ROOT']."/vwgame/logos/list.txt");
	
	return $list;
}

?>