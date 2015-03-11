<?php
if($content[formsend]) {
	$content = "Mail von talk2-webseite
	
	von:
	$content[formcontact]
	
	$content[formtext]
	";
	$sendok = mail("fb@media5k.de","Mail von talk2-webseite",$content,"from: www.talk2.de <>");
}

if(!$sendok) {

if($part != "layout") echo '<form name="form1" method="post" action="">';
?>
  <table width="315" border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td width="87"><p>Ihre Kontakt-daten:</p></td>
      <td width="228"><textarea name="vars[formcontact]" cols="30" rows="5" class="text"><?php echo $content[formcontact]; ?></textarea></td>
    </tr>
    <tr> 
      <td colspan="2"><br>
        Text:</td>
    </tr>
    
<tr> <td colspan="2"><textarea name="vars[formtext]" cols="45" rows="10" class="text"><?php echo $content[formtext]; ?></textarea></td></tr> <tr align="center"><td colspan="2">
    <input type="reset" name="Reset" value="l&ouml;schen">
    &nbsp; 
    <input name="vars[formsend]" type="submit" id="vars[formsend]" value="absenden"></td></tr>
  </table>

<?php if($part != "layout") echo '</form>';
} else { ?>
<table width="315" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p>Email wurde versandt. In K&uuml;rze wird sich ein Mitarbeiter mit Ihnen 
        in Verbindung setzen.</p>
      <p>Vielen Dank.</p></td>
  </tr>
</table>
<? } ?>