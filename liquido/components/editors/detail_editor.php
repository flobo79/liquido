<?php


include("lib/functions.php");
$details = userData($group,$id); 

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>liquido</title>
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
<?php if ($updatebottom) { ?>
<script language="JavaScript">
	<!-- 
		parent.bottom.location.href='bottom.php?group=<?php echo $details['egroup'] ?>&id=<?php echo $id ?>';
	-->
</script>
<?php } ?>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="730" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="27" height="70"><img src="../../gfx/spacer.gif" width="25" height="8"></td>
    <td width="53" valign="top"><br> <img src="gfx/keybound.gif" width="50" height="53"> 
    </td>
    <td width="650" valign="top"><p>&nbsp;</p>
      <p class="headline">Benutzer <span class="text"><?php echo $details['username'] ?></span><br>
      id: <?php echo unmask_id($id) ?></p></td>
  </tr>
  <tr> 
    <td height="70">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">
		<form name="detailsform" method="post" action="">
	<?php if(!$part) { ?>
      <table width="505" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="254"><?php echo $details['titel']; ?><br>
            <?php echo $details['department'] ?><br>
            <br>
            email: <?php echo $details['mail'] ?><br>
            Telefon: <?php echo $details['phone'] ?><br> <br>
            Benutzername: <?php echo $details['login'] ?><br>
            Passwort: 
            <?php 
			for($i=1;$i<=strlen($details['pass']);$i++) $mask .= "*";
			echo $pass = ($viewpassword and $access['c9']) ? $details['pass'] : $mask; 
		?>
            <br> </td>
          <td width="251" valign="top"><p> erstellt <?php echo strftime(getDay($details['timestamp'])." %H:%M",$details['timestamp']); ?><br>
              Freigabe : 
              <?php if($access['c8']) { ?>
              <input id="status" name="changestatus[status]" type="checkbox" onClick="detailsform.submit()" value="1" <?php if ($details['status']) echo "checked" ?> <?php if(!$access['c8']) echo "disabled"; ?>>
              <input name="changestatus[group]" type="hidden" id="changestatus[group]" value="<?php echo $details['egroup'] ?>">
              <input name="changestatus[editor]" type="hidden" id="changestatus[editor]" value="<?php echo $id ?>">
              <?php } else { echo ($details[status] ? "aktiv" : "gesperrt"); } ?>
            </p>
              <p> 
                <?php if($access['c11'] and $details['mail']) { ?>
                [<a href="?id=<?php echo $id ?>&group=<?php echo $details['egroup'] ?>&part=send">Zugangsdaten 
                zusenden</a>] 
                <?php } ?>
                <br>
                <?php if($access['c9']) { ?>
                [<a href="?id=<?php echo $id ?>&viewpassword=1">Passwort 
                anzeigen</a>] 
                <?php } ?>
                <br>
                <?php if($access['c5']) { ?>
                [<a href="?id=<?php echo $id ?>&part=edit">bearbeiten</a>] 
                <?php } ?>
                <br>
                <?php if($access['c6']) { ?>
                [<a href="?id=<?php echo $id ?>&group=<?php echo $details['egroup'] ?>&part=delete">l&ouml;schen</a>] 
                <?php } ?>
              </p></td>
        </tr>
      </table>
      <?php } elseif ($part == "edit") { ?>
      
        <table width="635" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="83">Benutzer <span class="headline"> </span></td>
            <td width="151"><span class="headline"> 
              <input name="edituser[name]" type="text" class="text" value="<?php echo $details['username'] ?>">
              </span></td>
            <td width="96">Freigabe: </td>
            <td colspan="2"><span class="headline"> 
              <?php if($access['c8']) { ?>
              <input type="checkbox" name="edituser[status]" value="1" <?php if ($details['status']) echo "checked" ?>>
              <?php } ?>
              </span></td>
          </tr>
          <tr> 
            <td>Titel:</td>
            <td valign="top"><span class="headline"> 
              <input name="edituser[titel]" type="text" class="text" value="<?php echo $details['titel'] ?>">
              </span></td>
            <td valign="top">Gruppe:</td>
            <td colspan="2" valign="top"><span class="headline"> 
              <?php if($access['c7']) { listGroups("edituser[egroup]","order by name",$details['egroup']); } else { echo $details['name']; } ?>
              </span></td>
          </tr>
          <tr> 
            <td>Abteilung:</td>
            <td valign="top"><span class="headline"> 
              <input name="edituser[department]" type="text" value="<?php echo $details['department'] ?>">
              </span></td>
            <td colspan="3" valign="top"><span class="headline"> </span></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">Benutzername: </td>
            <td colspan="2" valign="top"><input name="edituser[login]" type="text" value="<?php echo $details['login'] ?>" class="text"></td>
          </tr>
          <tr> 
            <td>email: </td>
            <td valign="top"><input name="edituser[mail]" type="text" value="<?php echo $details['mail'] ?>" class="text"> 
            </td>
            <td valign="top">Passwort: </td>
            <td colspan="2" valign="top"><input name="edituser[pass]" type="password" value="<?php echo $details['pass'] ?>" class="text"></td>
          </tr>
          <tr> 
            <td>Telefon:</td>
            <td valign="top"><input name="edituser[phone]" type="text" value="<?php echo $details['phone'] ?>" class="text"></td>
            <td valign="top">LDAP-Schl&uuml;ssel: </td>
            <td width="158" valign="top"><input name="edituser[ldap]" type="text" value="<?php echo $details['ldap'] ?>" class="text"></td>
            <td width="147" valign="top"><input type="submit" name="Submit" value="speichern" class="text"> 
              <input name="edituser[id]" type="hidden" value="<?php echo $id ?>"></td>
          </tr>
        </table>
      
      <?php } elseif($part == "delete") {?>
      <table width="349" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="349"><p>Soll der Benutzer <span class="headline"><?php echo $details['username'] ?></span> 
              wirklich gel&ouml;scht werden?</p>
            <p><a href="?editor=<?php echo $id ?>&group=<?php echo $group ?>&deleteuser=1">ja</a> 
              &nbsp;&nbsp;<a href="javascript:history.back()">nein</a></p></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
        <? } elseif($part == "send") {?>
        <table width="349" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="349"><p>M&ouml;chten Sie dem Benutzer <span class="headline"><?php echo $details['username'] ?></span> 
                seine Zugangsdaten an seine Email-Adresse schicken?</p>
              <p><a href="?id=<?php echo $id ?>&group=<?php echo $group ?>&sendaccess=1">ja</a> 
                &nbsp;&nbsp;<a href="javascript:history.back()">nein</a></p></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
       <? } elseif($part == "sendok") {?>
        <table width="349" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="349"><p>Zugangsdaten wurden verschickt.</p>
              <p><a href="?id=<?php echo $id ?>&group=<?php echo $group ?>">ok</a></p></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
        <?php } ?>
      </form>
	</td>
  </tr>
</table>
