<?php


// contents-template
$objecttitle = "E-Card lesen";

if ($part == "compose") {
	include($cfgcmspath."/components/contents/compose/templates/object_head.php");
	echo "<input name=\"objectdata[".$result['id']."][smalltext]\" type=\"hidden\" value=\"dummy\">";
}
?><a href="#" onClick="window.open('/sendcard/index.php','sendcard','width=620,height=510')">E-Card erstellen</a>