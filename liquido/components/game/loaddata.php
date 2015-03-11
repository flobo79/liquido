<?php

include ("functions.php");

$images = listImages($imagepath);
$phrases = listPhrases();


print_r($images);

?>