Return-Path: <?php echo "<".$user['mail'].">"; ?> 
From: <?php echo "\"".$user['name']."\" <".$user['mail'].">"; ?> 
MIME-Version: 1.0
Content-Type: multipart/alternative; boundary="==liquido=="



--==liquido==
Content-Type: text/plain; charset=iso-8859-1
Content-Transfer-Encoding: 8bit


Hallo <?php echo $details['username']; ?>

Ihre Zugangsdaten f&uuml;r <?php echo $cfg['env']['projecttitle'] ?>

Link: <?php echo $cfg['env']['host'].$cfg['env']['cmspath'] ?>

Benutzername: <?php echo $details['login'] ?>
Passwort: <?php echo $details['pass'] ?>


Info: Ein Schl&uuml;ssel sch&uuml;tzt nur dann, wenn ihn nicht jeder nutzen kann.


--==liquido==
Content-Transfer-Encoding: 8bit
Content-Type: text/html; charset=iso-8859-1

<html>
<link href="<?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?>lib/css.css" rel="stylesheet" type="text/css">

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="29" background="<?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?>gfx/head_bg.gif"><a href="<?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?>"><img src="<?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?>gfx/bu_start.gif" width="66" height="27" border="0"></a></td>
    <td height="29" align="right" background="<?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?>gfx/head_bg.gif"><img src="<?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?>gfx/liquido_head.gif" width="92" height="29"></td>
  </tr>
  <tr valign="top"> 
    <td width="98" align="center"><p><img src="<?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?>components/editors/gfx/logo.gif" width="77" height="74"></p></td>
    <td><p>&nbsp;</p>
      <p class="bigheadline">Hallo <?php echo $details['username']; ?>
      </p>
      <p>Ihre Zugangsdaten f&uuml;r <?php echo $cfg['env']['projecttitle'] ?><br>
        <br>
        Link:  <a href="<?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?>"><?php echo $cfg['env']['host']."/".$cfg['env']['cmspath'] ?></a><br>
        <br>
        Benutzername: <?php echo $details['login'] ?><br>
        Passwort: <?php echo $details['pass'] ?></p>
      <p>Info: Ein Schl&uuml;ssel sch&uuml;tzt nur dann, wenn ihn nicht jeder 
        nutzen kann. Bitte verwahren Sie Ihre Zugangsdaten sorgf&auml;ltig.</p></td>
  </tr>
</table>
</body>
</html>

--==liquido==--
