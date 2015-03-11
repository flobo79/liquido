<?php

$objecttitle = "Bereichs-Auswahl";
// markiere object als selectarea
global $areas;
global $ispublishing;
global $thiscomp;

$s = 1;
if(isset($publishing)) {
	$result['s'] = $true;
}

if(!$mps) { 
	if(is_array($check)) {
		foreach($check as $k => $v) if($v) $mps[] = $k;
	}
}

if(!$object) {
if($part == "compose") {
	include("$cfgcmspath/components/contents/compose/templates/object_head.php");
	$disabled = "disabled";
}
?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
			<h2 class="nl_grayhead">Wir m&ouml;chten Sie in Zukunft besser informieren!</h2>
			<p class="nl_p" style="margin-top: 0;">Bitte klicken Sie auf den nachfolgenden Link und w&auml;hlen Sie im Anschluss die Rubriken aus, f&uuml;r die Sie sich interessieren. In Zukunft erhalten Sie dann einen eigens auf Ihre Bed&uuml;rfnisse zugeschnittenen Newsletter.
			
			<?php if($ispublishing) { ?>
				<br /><br /><xstructure:269><a class="n" href="http://www.vw-club.de/newsletterrubrik?email=#urlemail#&aboid=#aboid#" target="_blank">Bereiche ausw&auml;hlen</a>
			</form>
			<?php } ?>
			</p>
		</td>
	</tr>
</table>

<?php
}
?>

