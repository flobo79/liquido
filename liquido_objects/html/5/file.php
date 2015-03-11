<?php

// contents-template
$objecttitle = "Quellcode-Feld";
$thisobject['formrows'] = "30";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['textwidth'] = "100%";
$thisobject['wrap'] = "OFF";
$thisobject['nl2br'] = "no";

if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

echo $this->textobject($thisobject); 

?>
