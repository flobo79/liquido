<?php

function wddx_read_file($path) {
	$wddx = file_get_contents($path);
	return wddx_unpack($wddx);
}

function wddx_pack($var) {
	return wddx_serialize_vars('var');
}

function wddx_unpack($wddx) {
	$var = wddx_deserialize($wddx);
	return $var['var'];
}

?>