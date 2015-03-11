<?php

$objecttitle = "Fragebogen Autokauf";

global $ispublishing;
global $thiscomp;

if(!$object) {
if($part == "compose") {
	include("$cfgcmspath/components/contents/compose/templates/object_head.php");
	$disabled = "disabled";
}

if($ispublishing) echo "<form name=\"autokauf-form\" method=\"post\" action=\"#\">";

?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
			<h2 class="nl_grayhead">Wir m&ouml;chten Sie gerne besser kennenlernen!</h2>
			<p class="nl_p">Phasellus a odio eget nulla imperdiet ultrices. Curabitur tincidunt viverra malesuada. Nam malesuada, turpis a eleifend imperdiet, lacus erat bibendum enim, eget blandit nisl arcu dictum turpis.</p>
		</td>
	</tr>
</table>
<br />
<table border="0" cellpadding="8px" cellspacing="0" width="100%" style="background-color: #e1e1e1">
	<tr>
		<td valign="top" align="right">Ihr derzeitiges Fahrzeug:</td>
		<td valign="top"><input type="text" name="currentbrand" value="Eingabe hier"></td>
		<td valign="top" align="right">Modell:</td>
		<td valign="top"><input type="text" name="currentmodel" value="Eingabe hier"></td>
	</tr>
	<tr>
		<td valign="top" align="right">N&auml;chster geplanter Autokauf:</td>
		<td valign="top">
			<input type="radio" name="nextbuy"> In den n&auml;chsten 3 Monaten<br />
			<input type="radio" name="nextbuy"> In den n&auml;chsten 9 Monaten<br />
			<input type="radio" name="nextbuy"> Sp&auml;ter<br />
		</td>
		<td valign="top" align="right">&nbsp;</td>
		<td valign="top">
			<input type="radio" name="nextbuy"> In den n&auml;chsten 6 Monaten<br />
			<input type="radio" name="nextbuy"> In den n&auml;chsten 12 Monaten<br />
			<input type="radio" name="nextbuy"> Derzeit nicht geplant<br />
		</td>
	</tr>

</table>
<?php if($ispublishing) echo '<a class="submitlink" href="#" target="_blank">Absenden</a>';
} 
?>

