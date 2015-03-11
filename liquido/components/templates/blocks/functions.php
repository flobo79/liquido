<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/


$access = loadAccessTable($user,"contents");
$temp = $_SESSION['components'][$comp]['temp'];



/**************************************************
        Funktionen                       		 *
**************************************************/

function delete($obj) {
#######################################
	include("../../lib/cfg.php");
}

function create($o) {
	
	
}

function update($o) {
	
}


function curl_string ($url){
#####################################
	$ch = curl_init(); 

	curl_setopt ($ch, CURLOPT_URL, $url); 
	curl_setopt ($ch, CURLOPT_HEADER, 1); 
	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
	
	$result = curl_exec ($ch);
	curl_close($ch);
	
	return $result;
}



?>