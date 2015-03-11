<?php

include ("functions.php");

if($_POST['set']) {
	foreach($_POST['set'] as $field => $value) {
		$svFields .= "`$field` = '$value', "; 
	}
	if(!$_POST['set']['confirm_cards']) $svFields .= "`confirm_cards` = '0', "; 
	
	// sql-statement ohne komma am ende ** get string without last comma
	$svFields = substr($svFields,0,-2);
	
	$sql = "update sendcard_settings set $svFields where id = '1' LIMIT 1";
//	echo $sql;
	mysql_query($sql);
}

$set = mysql_fetch_array(mysql_query("select * from sendcard_settings"),MYSQL_ASSOC);

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>sendcard</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" enctype="multipart/form-data" method="post" action="">
  <table width="487" border="0" cellspacing="1" cellpadding="0">
    <tr> 
      <td width="485" height="36" class="headline">E-Card Einstellungen</td>
    </tr>
    <tr>
      <td height="36"><p>Folgende Platzhalter k&ouml;nnen in die Texte eingef&uuml;gt 
          werden:<br>
          <br>
          Versender = Name des Versenders<br>
          Versendermail = Email des Versender<br>
          Emfaenger = Name des Emf&auml;ngers<br>
          Emfaengermail = Email des Emf&auml;ngers</p>
        <p>E-Cards verfallen nach 
          <input name="set[expire]" type="text" value="<?php echo $set['expire'] ?>" size="2" maxlength="2">
          Monaten</p>
        <p>&nbsp;</p></td>
    </tr>
    <tr> 
      <td height="36"> <fieldset>
        <legend>E-Card-Tool</legend>
        <p> Nachricht nach Absenden der E-Card:<br>
          <br>
          <textarea name="set[returntext]" cols="60" rows="10" id="set[returntext]"><?php echo $set['returntext'] ?></textarea>
        </p>
        </fieldset>
        <br> <fieldset>
        <legend>Bestätigung der E-Card</legend>
        <p><strong>Zus&auml;tzliche Platzhalter:</strong><br>
          bestaetigen = Link zum best&auml;tigen der E-Card<br>
          ablehnen = Link zum ablehnen der E-Card </p>
        <p>
          <input name="set[confirm_cards]" type="checkbox" id="set[confirm_cards]" value="1" <?php if ($set['confirm_cards']) echo "checked"; ?>>
          E-Cards m&uuml;ssen per Email best&auml;tigt werden<br>
        </p>
        <p> Email an E-Card versender zum best&auml;tigen der E-Card:<br>
          <br>
          <textarea name="set[confirm_mailtext]" cols="60" rows="15" id="set[confirm_mailtext]"><?php echo $set['confirm_mailtext'] ?></textarea>
          <br>
          <br>
          Betreff der Email:<br>
          <input name="set[confirm_mailsubject]" type="text" id="set[confirm_mailsubject]" value="<?php echo $set['confirm_mailsubject'] ?>" size="50">
        </p>
        <p>Zielseite nach best&auml;tigen der E-Card:<br>
          <input name="set[recieve_link]" type="text" id="set[recieve_link]" value="<?php echo $set[recieve_link] ?>" size="50" maxlength="100">
        </p>
        <p>Zielseite nach ablehnen der E-Card:<br>
          <input name="set[refuse_link]2" type="text" id="set[refuse_link]2" value="<?php echo $set[refuse_link] ?>" size="50" maxlength="100">
          <br>
        </p>
        </fieldset><br>
	<fieldset>
	    <legend>E-Mail an Emf&auml;nger</legend>
        <p><strong>Zus&auml;tzlicher Platzhalter:</strong><br>
          link = Link zum &Ouml;ffnen der Ecard</p>
        <p> 
          <textarea name="set[recieve_mailtext]" cols="60" rows="10" id="set[returntext]"><?php echo $set['recieve_mailtext'] ?></textarea>
          <br>
          <br>
          Betreff der Email:<br>
          <br>
          <input name="set[recieve_subject]" type="text" id="set[recieve_subject]" value="<?php echo $set['recieve_subject'] ?>" size="50" maxlength="100">
          <br>
        </p>
        </fieldset>
        <br>
			<fieldset>
	<legend>Lesebestätigung</legend>
        <p> 
          <textarea name="set[confirmation_mail]" cols="60" rows="10"><?php echo $set['confirmation_mail'] ?></textarea>
          <br>
          <br>
          Betreff der Email:<br>
          <input name="set[confirmation_subject]" type="text" value="<?php echo $set['confirmation_subject'] ?>" size="50" maxlength="100">
          <br>
        </p>
        </fieldset></td>
    </tr>
    <tr> 
      <td height="36" class="headline"><input name="save" type="submit" id="save" value="Einstellungen speichern"></td>
    </tr>
    <tr> 
      <td height="36" class="headline">&nbsp;</td>
    </tr>
  </table>
</form>

</body>
</html>