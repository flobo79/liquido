<?php 


error_reporting(E_ALL ^ E_NOTICE);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>liquido login</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/liquido.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
<!--
if(this == top) top.location.href='/liquido/index.php';
if(this.name != 'content') { top.location.href='/liquido/index.php'; }
 init = function() {
 	parent.head.location.href='head.php?location=start';
 }
-->
</script>
</head>
<body onload="init();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center">
<p>&nbsp;</p><table width="282" height="262" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" background="gfx/loginscreen-v3.gif">
          		<div style="margin-left:40px; margin-top:75px; text-align:left;">
                  <p class="headline">Anmeldung</p>
                  <form action="body.php" method="post" name="login">
                    <p> Benutzername:<br />
                      <input name="login[user]" type="text" value="<?php echo $login['user']; ?>" id="login" />
                   </p>
                   <p>Passwort:<br />
                      <input name="login[pass]" type="password" id="logn[pass]" />
                      <br />
                      <?php if($loginerror) echo $loginerror."<br>"; ?>
                      <input name="imageField" type="image" src="gfx/login.gif" />
                    </p>
                  </form>
                </div>
				<div class="smalltext" align="right" style="margin-left:205px; margin-top:13px; position:absolute;">Version 3.0.7</div>
				
			</td>
        </tr>
      </table>
<br/>
<a href="http://www.mozilla-europe.org/de/firefox/" target="_blank"><img src="gfx/loginscreen_ff.gif" border="0" /></a>



</td>
  </tr>
</table>
</body>
</html>
