
<?php

require_once($_SERVER['DOCUMENT_ROOT']."/mikos/libs/class.KIS.php");

session_start();

// if kis is not initialised do that
if(array_key_exists('kis',$_SESSION) === false or isset($_GET['resetkis'])) {
	$_SESSION['kis'] = new KIS();
} else {
	$_SESSION['kis']->KIS();
}

$kis = $_SESSION['kis'];


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Volkswagen Club Mikos Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="/liquido/css/vwc.css" rel="stylesheet" type="text/css" />
	<link href="/liquido/css/objects.css" rel="stylesheet" type="text/css" />
	<link href="/mikos/files/mikos.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/JavaScript" src="/liquido/js/mootools.js"></script>
	
	<script language="JavaScript" type="text/JavaScript" src="/liquido/js/liquido.js"></script>
	
	<script language="JavaScript" type="text/JavaScript" src="/mikos/libs/ajax.js"></script>
	
</head>
<body  id="body">

<?php 
//***  check if connection to server exists ***
if($kis->connected) {
//*** if not logged in, show loginform ***
if (!$kis->loggedIn) {
?>
<noscript>
	Bitte aktivieren Sie JavaScript in Ihrem Browser um diesen Bereich zu betreten.
</noscript>

<form id="mikos_login" name="mikos_login" method="post" action="/mikos/libs/ajax.php" enctype="application/x-www-form-urlencoded" style="clear:both; display:block; width:100%; " >
<table border="0">
<tr>
  <td><b>Club Lounge Login</b></td>
</tr>

<tr>
  <td><label for="username">Benutzername:</label><br/>
  <input name="username" type="text" class="inputclass_p" id="username" value="" /></td>
</tr>
<tr>
  <td><label for="password">Passwort:</label><br/>
 <input name="password" class="inputclass_p" type="password" id="password" value="" />
  <input type="hidden" name="class" id="class" value="KIS" /></td>
</tr>
<tr>
  <td><input name="kis_action" id="kis_action" type="hidden" value="doLogin" />
  <input class="submit" type="button" value="Login" name="go"/></td>
</tr>
<tr>
  <td><input name="autologin" type="checkbox" value="true" /> angemeldet bleiben</td>
</tr>
</table>
<div id="output" class="response_error" style="clear:both; display:block; width:100%; "></div>
</form>



<?php 

 	}
 } else {
?>
	<div style="clear:both; margin:10px 0; font-family:Verdana;">Die Club Lounge ist vorrübergehend nicht verfügbar.</div>
<?php
 }
?>
</body></html>
