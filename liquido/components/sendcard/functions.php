<?php

session_start();

include("../../lib/init.php");
global $_FILES;

$imagepath = "/sendcard/images/";

function listImages($pfad) {
	if($pfad) {
		$images = array();
		if(file_exists($pfad)) {
			$d = dir($pfad);
			while($entry=$d->read()) {
				if($entry != "." and $entry != "..") {
					$images[] = $entry;
				}
			}
			return $images;
		}
	}
}

function delImage($file) {
	global $imagepath;
	// lösche alle sendcards mit diesem Bild
	
	// lösche bild
	unlink($_SERVER['DOCUMENT_ROOT']."/sendcard/images/".$file);
	return true;

}


function listPhrases() {
	global $path;
	include($path."../../lib/cfg.php");
	$cfgcmspath = "../../";
	OpenDatabase();
	
	$entry = array();
	$q = mysql_query("select * from `sendcard_phrases` order by phrase");
	while ($list = mysql_fetch_array($q,MYSQL_ASSOC)) {
		$entry[$list['id']] = $list['phrase'];
	}
	return $entry;
}


function addPhrase($phrase) {
	global $path;
	include($path."../../lib/cfg.php");
	$cfgcmspath = "../../";
	
	
	$svSQL = "insert into `sendcard_phrases` (`phrase`) values ('$phrase')";
	
	mysql_query($svSQL);
	
	return true;
}


?>