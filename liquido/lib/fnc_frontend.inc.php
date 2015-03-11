<?php

//print_r($_SERVER);

function drawLeftPane ($content,$toroot="") {
	$part = "top";
	include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/tpl/leftpane.php");
		
	echo $content;
	
	$part = "bottom";
	include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/tpl/leftpane.php");

}





?>