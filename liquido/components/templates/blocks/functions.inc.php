<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/


$access = loadAccessTable($user,"contents");
$temp = $_SESSION['components'][$comp]['temp'];

/**************************************************
        Funktionen                       		 *
**************************************************/


function saveBlock($o) {
	if($o['id']) {
		$block = new Block($o['id']);
		unset($o['id']);
		
		foreach($o as $k => $v) {
			$block->$k = $v;
		}
		$block->update();
		
	} else {
		$block = new Block();
		echo $block->create($o);
	}
}

function loadBlock($o) {
	$block = new Block($o['id']);
	echo json_encode($block->data());
}


function delBlock($o) {
	$block = new Block($o['id']);
	$block->delete();
}

function updateOrder($obj) {
	if(intval($obj['id'])) {
		$block = new Block($obj['id']);
		$block->updateNodeOrder($obj['order']);
	}
}

?>