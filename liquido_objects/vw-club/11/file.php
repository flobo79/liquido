<?php

$objecttitle = "Katalogmodul";
$id = $result['id'];

if ($part == "compose") {
	include($cfgcmspath.'/components/contents/compose/templates/object_head.php');
	
} else {
	global $mail;
	global $kis;
	global $_POST;

	// add formtag
	echo "<form name=\"katalog_".$id."\" method=\"post\">\n";
	
	// wenn modul abgesendet wurde
	if($_POST['submitobject'] == $id) {

		$values = $_POST['katalog'][$id];
	
		if($result['smalltext2'] == "business") {
			if(!$values['betriebsnr']) 	$error['betriebsnr'] = "< Bitte eingeben";
			if(!$values['firma']) 		$error['firma'] = "< Bitte eingeben";
		}
		
		if(!$values['name']) 		$error['name'] = "< Bitte eingeben";
		if(!$values['street']) 		$error['street'] = "< Bitte eingeben";
		if(!$values['ort']) 		$error['ort'] = "< Bitte eingeben";
		if(!$values['email']) 		$error['email'] = "< Bitte eingeben";
		
		if(!$error) {

			$products = explode("##",$result['text']);
			for($i=0;$product = $products[$i];$i++) {
				if($values['menge'][$i]) {
					// splitte product in beschreibung und mengen
					$details = explode("#",$product);
					$mail_products .= $details[0]."\n".$values['menge'][$i]."\n\r";	
				}
			}
	
		if($result['smalltext2'] == "business") {
$mail_angaben = "
Firma: ".utf8_decode($values['firma'])."
Betriebsnummer: ".$values['betriebsnr']."\n";
			}
			
$mail_angaben .= "
			
Name: ".utf8_decode($values[name])."
Anschrift: ".utf8_decode($values[street])."
PLZ, Ort: ".utf8_decode($values[ort])."
E-Mail: $values[email]
Telefon: $values[phone]
Mitgliedsnummer: $values[clubnumber]

Sonstiges: ".utf8_decode($values[message])."

";
			
			// send to vw club
$mailbody = "Kunde:
			
".$mail_angaben."
			
hat folgende Unterlagen angefordert:
			
".utf8_decode($mail_products)."

";
			
			if($result['smalltext1']) $sent = mail($result['smalltext1'],$result['smalltext3'],$mailbody,"from: \"Volkswagen Club\" <vwclub@dialogservice.com>");
			
			
			// send to besteller
			$mailbody = utf8_decode($result['text2'])."
			
			".$mail_products."
			
			".$mail_angaben."
			
			".utf8_decode($result['text3']);
			if($values['email']) $sent = mail($values['email'],$result['smalltext3'],$mailbody,"from: \"Volkswagen Club\" <vwclub@dialogservice.com>");
			
			$sent = true;
		}
	}
}
?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top"> 
      
      <!-- <img src="/<xcontainer>div-head_01.gif" width="330" height="20" hspace="0" vspace="0" border="0"> -->
      <?php if(!$sent) { 
	  
			// splitte eingabe in einzelne produkte
			$products = explode("##",$result['text']);
			for($i=0;$product = $products[$i];$i++) {
				// splitte product in beschreibung und mengen
				$details = explode("#",$product);
				echo nl2br($details[0])."<br>\n";
				
				// stelle Mengen auswahl dar
				$mengen = explode(",",$details[1]);
				for($ii=0;$menge = $mengen[$ii];$ii++) {
					$checked = ($values['menge'][$i] == $menge) ? " checked" : "";
					echo "<input type=\"radio\" name=\"katalog[$id][menge][$i]\" value=\"$menge\" $checked> $menge ";
				}
				echo "<br><br>\n";
			}

	  ?>
      <p><strong>Ihre Angaben:</strong></p>
      <table width="360" border="0" cellspacing="0" cellpadding="0">
        <?php if($result['smalltext2'] == "business") { ?>
        <tr> 
          <td>Betriebsnummer:</td>
          <td><input name="katalog[<?php echo $id ?>][betriebsnr]" type="text" value="<?php echo $values['betriebsnr'] ? $values['betriebsnr'] : "<xclass:91>"; ?>" class="feld"> 
            <?php echo $error['betriebsnr'] ?></td>
        </tr>
        <tr> 
          <td>Firma:</td>
          <td><input name="katalog[<?php echo $id ?>][firma]" type="text" value="<?php echo $values['firma'] ? $values['firma'] : "<xclass:93>"; ?>" class="feld"> 
            <?php echo $error['firma'] ?></td>
        </tr>
        
        <?php } // end if business ?>
        <tr> 
          <td width="105">Ihr Name: </td>
          <td width="255"><input name="katalog[<?php echo $id ?>][name]" type="text" value="<?php echo $values['name'] ? $values['name'] : "<xclass:35>"; ?>" class="feld"> 
            <?php echo $error['name'] ?></td>
        </tr>
        <tr> 
          <td>Strasse, Nr:</td>
          <td><input name="katalog[<?php echo $id ?>][street]" type="text" value="<?php echo $values['street'] ? $values['street'] : "<xclass:47> <xclass:48> " ?>" class="feld"> 
            <?php echo $error['street'] ?></td>
        </tr>
        <tr> 
          <td>PLZ, Ort:</td>
          <td><input name="katalog[<?php echo $id ?>][ort]" type="text" value="<?php echo $values['ort'] ? $values['ort'] : "<xclass:49> <xclass:50>" ?>" class="feld"> 
            <?php echo $error['ort'] ?></td>
        </tr>
        <tr>
          <td>Telefonnummer:</td>
          <td><input name="katalog[<?php echo $id ?>][phone]" type="text" value="<?php echo $values['phone'] ? $values['phone'] : "<xclass:40>" ?>" class="feld">
            <?php echo $error['phone'] ?></td>
        </tr>
        <tr> 
          <td>E-Mail-Adresse: </td>
          <td><input type="text" name="katalog[<?php echo $id ?>][email]" value="<?php echo $values['email'] ? $values['email'] : "<xclass:39>" ?>" class="feld"> 
            <?php echo $error['email'] ?></td>
        </tr>
        <tr>
          <td>Mitgliedsnummer:</td>
          <td><input name="katalog[<?php echo $id ?>][clubnumber]" type="text" value="<?php echo $values['clubnumber'] ? $values['clubnumber'] : "<xclass:32>" ?>" class="feld">
            <?php echo $error['clubnumber'] ?></td>
        </tr>
        <tr>
          <td height="50" valign="top">Sonstiges:</td>
          <td><textarea name="katalog[<?php echo $id ?>][message]" cols="30" rows="5" class="feld" ><?php echo $values['message'] ?> </textarea></td>
        </tr>
        <tr> 
          <td height="50"><input type="Submit" name="submitbutton" value="absenden" class="button">          </td>
          <td><input name="submitobject" type="hidden" value="<?php echo $id ?>" /></td>
        </tr>
      </table>
      <p>&nbsp; </p>
      <?php } else { ?>
      <p>Vielen Dank f&uuml;r Ihre Angaben. </p>
      <p>&nbsp;</p>
      <?php } ?>
    </td>
  </tr>
</table>
<?php
if($part != "compose") {
	echo "</form>";
} else {  ?>
<a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','../../components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a> 
<div id="option<?php echo $objectid ?>" style="display:none">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="15" height="15" background="/liquido/gfx/x_box/coinsupg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td height="15" background="/liquido/gfx/x_box/sup.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td width="15" height="15" background="/liquido/gfx/x_box/coinsupd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
  <tr> 
    <td width="15" background="/liquido/gfx/x_box/g.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td background="/liquido/gfx/x_box/fond.gif" align="left" width="100%"> <table width="100%">
        <tr> 
          <td class="text"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td colspan="2" valign="top" class="text"> 
                    <!-- <font color="#000000"><a href="#" onClick="openLibrary(<?php echo $result[id] ?>,'type=picture'); return false">&raquo; 
                    Bild ausw&auml;hlen</a></font> -->
                  </td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top" class="text">Produkte:<br> <div class="smalltext">Einzelne 
                      Produkte mit folgender Syntax eintragen: <br>
                      Beschreibung # menge1, menge2, ... , mengeN ##</div>
                    <p> 
                      <textarea name="objectdata[<?php echo $result['id']; ?>][text]" cols="50" rows="8"><?php echo $result['text'] ?></textarea>
                    </p>
                    <p>Einleitungs-Text in E-Mail:<br>
                      <textarea name="objectdata[<?php echo $result['id']; ?>][text2]" cols="50" rows="4"><?php echo $result['text2'] ?></textarea>
                    </p>
                    <p>Abspann-Text in E-Mail:<br>
                      <textarea name="objectdata[<?php echo $result['id']; ?>][text3]" cols="50" rows="4"><?php echo $result['text3'] ?></textarea>
                    </p></td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top" class="text">&nbsp;</td>
                </tr>
                <tr> 
                  <td width="167" valign="top" class="text">Ziel-E-Mail-Adresse:</td>
                  <td width="852" valign="top" class="text"><input name="objectdata[<?php echo $result['id']; ?>][smalltext1]" type="text" class="text" value="<?php echo $result['smalltext1']; ?>" size="30"></td>
                </tr>
                <tr>
                  <td valign="top" class="text">E-Mail-Betreff:</td>
                  <td valign="top" class="text"><input name="objectdata[<?php echo $result['id']; ?>][smalltext3]" type="text" class="text" value="<?php echo $result['smalltext3']; ?>" size="30"></td>
                </tr>
                <tr> 
                  <td valign="top" class="text">Angaben f&uuml;r: </td>
                  <td valign="top" class="text"> <input type="radio" name="objectdata[<?php echo $result['id']; ?>][smalltext2]" value="private" <?php if($result['smalltext2'] == "private") echo "checked"; ?>>
                    privat 
                    <input type="radio" name="objectdata[<?php echo $result['id']; ?>][smalltext2]" value="business" <?php if($result['smalltext2'] == "business") echo "checked"; ?>>
                    gesch&auml;ftlich </td>
                </tr>
              </table> </td>
        </tr>
      </table></td>
    <td width="15" background="/liquido/gfx/x_box/d.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
  <tr> 
    <td width="15" height="15" background="/liquido/gfx/x_box/coininfg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td height="15" background="/liquido/gfx/x_box/inf.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td width="15" height="15" background="/liquido/gfx/x_box/coininfd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
</table>
<a href="javascript:hide('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('less<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/less.gif" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>"></a> 
</div>
<?php } ?>