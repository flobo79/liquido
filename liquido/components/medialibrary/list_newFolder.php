<?php 

require_once("../../lib/init.php");


$createFolder = $_POST['createFolder'];
$folderid = $_GET['folderid'];

require_once("lib/functions.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
<?php setIframeWidth($folderid,617); ?>
</head>

<body >
<form name="form1" method="post" action="" id="newfolderform"><br/>

  <table width="394" border="0" cellspacing="0" cellpadding="0">
    
    <tr>
      <td height="34">&nbsp;</td>
      <td colspan="2"><h2>Neue Medienmappe erstellen </h2></td>
    </tr>
    <tr>
      <td width="17">&nbsp;</td>
      <td width="87">Bezeichnung:</td>
      <td width="290"><input name="createFolder[name]" type="text" id="name" size="35" maxlength="255"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Info:</td>
      <td><textarea name="createFolder[info]" cols="30" id="info"></textarea>
          <input name="createFolder[parent]" type="hidden" value="<?php echo ($folderid == "0" ? "x" : $folderid) ?>">
        <a name="scroll"></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><br>
        <a href="#" onClick="document.getElementById('newfolderform').submit(); return false">anlegen</a></td>
    </tr>
  </table>
</form>
</body>
</html>
