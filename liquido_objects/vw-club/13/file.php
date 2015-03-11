<?php

$kis = $_SESSION['kis'];
$objecttitle = "tradedoubler";
$partner = explode("\n",$result['text']);

foreach($partner as $entry) { 
	$entry = explode(":",$entry);
	$partnerlist[$entry[0]] = $entry[1];
}

if(intval($_GET['p'])) {
	$partnerid = $_GET['p'];
	$partnername = $partnerlist[$partnerid] ? $partnerlist[$partnerid] : "<b>unbekannter Shopbetreiber</b>";
	$result['smalltext1'] = $_GET['p'];
}

if(intval($_GET['a'])) $result['smalltext2'] = $_GET['a'];
if(intval($_GET['g'])) $result['smalltext3'] = $_GET['g'];

$linkmit = "http://clkde.tradedoubler.com/click?p=".$result['smalltext1']."&a=".$result['smalltext2']."&g=".$result['smalltext3']."&epi=".$kis->custInfo->memberNumber;
$linkohne = "http://clkde.tradedoubler.com/click?p=".$result['smalltext1']."&a=".$result['smalltext2']."&g=".$result['smalltext3'];

// optionsmenue hinzuladen
if ($part == "compose") {
	include("$cfgcmspath/components/contents/compose/templates/object_head.php");
?>
  <br>
  a:
  <input name="objectdata[<?php echo $result['id'] ?>][smalltext2]" type="text" size="15" maxlength="50" value="<?php echo $result['smalltext2'] ?>" />
  <br>
  g:
  <input name="objectdata[<?php echo $result['id'] ?>][smalltext3]" type="text" size="15" maxlength="50" value="<?php echo $result['smalltext3'] ?>" />
  <br>
  <br>
bekannte Partner:<br>
<textarea name="objectdata[<?php echo $result['id'] ?>][text]" cols="70" rows="10"><?php echo $result['text'] ?></textarea>
<br>
Partner zeilenweise im Format Partnernummer:Partnername eintragen<br>
<br>
<?php
}
?>
<table width="<?php echo $contentwidth ?>" border="0">
  <tr>
    <td width="486">
	
<?php 
if($partnerid) {	// wenn eine partnerid ermittelt werden konnte
	if($kis->custInfo->memberNumber) { ?>
<strong>&Uuml;bergabe Ihrer Volkswagen Club Mitgliedsnummer an <?php echo $partnername; ?> </strong><br>
<br>
Auch
beim Online-Shopping bei <?php echo $partnername; ?> k&ouml;nnen
Sie wertvolle Treuepunkte sammeln. Dazu muss Ihre Volkswagen Club Mitgliedsnummer an <?php echo $partnername; ?> &uuml;bermittelt
werden:<br>
<br>
Ihre Volkswagen Club Mitgliedsnummer lautet: <b><i><?php echo $kis->custInfo->memberNumber ?></i></b>
<p>Wenn Sie mit der Weitergabe Ihrer Volkswagen Club Mitgliedsnummer einverstanden sind,
  klicken Sie auf <img src="<xcontainer:706>"> <a href="<?php echo $linkmit ?>" target="_blank">weiter</a>,
  um zu <?php echo $partnername; ?> zu gelangen.<br>
  <br>
  Wenn Sie mit der Weitergabe Ihrer Volkswagen Club Mitgliedsnummer nicht einverstanden
  sind, klicken Sie <img src="<xcontainer:706>"> <a href="<?php echo $linkohne ?>" target="_blank">hier</a>,
  um ohne &Uuml;bermittlung Ihrer Daten weitergeleitet zu werden.<br>
</p>
<?php } else { ?>
<strong>&Uuml;bergabe der Volkswagen Club Mitgliedsnummer an <?php echo $partnername; ?> zum Sammeln
von Treuepunkten </strong><br>
<br>
Auch beim Online-Shopping bei <?php echo $partnername; ?> k&ouml;nnen Sie
wertvolle Treuepunkte sammeln. Dazu muss Ihre Volkswagen Club Mitgliedsnummer an <?php echo $partnername; ?> &uuml;bermittelt
werden. <br>
<br>
<b>Ich bin bereits Mitglied im Volkswagen Club</b><br>
Meine Volkswagen Club Mitgliedsnummer lautet:<br>
<br>
<input name="mitgliedsnummer" type="text" class="feld" id="mitgliedsnummer" value="<?php echo $kis->custInfo->memberNumber ?>" size="20" maxlength="200" />
<input type="submit" name="Submit" value="weiter" class="button" style="position:relative; float:none; display:block; clear:both; " onClick="window.open('<?php echo $linkohne ?>&epi='+document.getElementById('mitgliedsnummer').value)" />
<br>
<br>
Wenn Sie Ihre Volkswagen Club Mitgliedsnummer nicht weitergeben möchten, klicken
Sie <img src="<xcontainer:706>"> <a href="<?php echo $linkohne ?>" target="_blank">hier</a>,
um ohne &Uuml;bermittlung Ihrer Daten zu <?php echo $partnername; ?> zu gelangen. Sie
bekommen dann keine Treuepunkte gutgeschrieben.<br>
        <br>
        <b>Ich bin noch kein Mitglied im Volkswagen Club</b><br>
Sollten Sie noch kein Mitglied sein, klicken Sie <img src="<xcontainer:706>"> <a href="http://www.vw-club.de/?page=1052">hier</a>,
um Informationen &uuml;ber die Mitgliedschaft im Vokswagen Club zu erhalten.<br>
        <br>
    <?php } 
	
		} else {  //  es konnte keine partnerid ermittelt werden?>
	Die Partnerid ist nicht korrekt übergeben worden, bitte überprüfen. Wenn Sie ein Besucher sind, melden Sie dies bitte dem Webmaster unter vwclub@dialogservice.com. Vielen Dank.
	<?php } ?></td>
  </tr>
</table>
