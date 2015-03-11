<?php


if (isset($_GET['crease'])) {
	session_start();
	$_SESSION['n_uploads'] +=  $_GET['crease'];
	header("Location:list_uploadwindow.php?id=$id");
	
}



include("../../lib/init.php");
include("lib/functions.php");

// wenn n_uploads 0 ist;
if(!isset($n_uploads)) {
	$_SESSION["n_uploads"] = 1;
}

$n_uploads = $_SESSION['n_uploads'];

// Objektinfos laden
$id = $_GET['id'];
$result = getObjectData($id); 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function closePleaseWait() {
	upload.close();
}
//-->
</script>
</head>

<body>
<form action="" enctype="multipart/form-data" method="post" name="uploadform">
  <table border="0" cellpadding="1" cellspacing="0">
    <tr> 
      <td width="22" rowspan="7" valign="top"> <p> 
          <input name="id" type="hidden" id="id" value="<?php echo $id ?>">
          <input name="upload[id]" type="hidden" id="id" value="<?php echo $id ?>">
          <input name="upload[n_uploads]" type="hidden" value="<?php echo $n_uploads ?>">
          <img src="../../gfx/spacer.gif" width="22" height="1"> </p></td>
      <td width="74" height="97" rowspan="7" valign="top"><p><img src="gfx/upload.gif" width="59" height="77"><br>
          <br>
          [<a href="list_details.php?id=<?php echo $id ?>">abbrechen</a>] 
        </p>
        <p><img src="../../gfx/spacer.gif" width="74" height="1"></p></td>
      <td width="239" rowspan="7" valign="top"> <p><br>
          <span class="headline"><?php echo $result['name'] ?></span> </p>
        <p><?php echo $result['info'] ?></p>
        <p><img src="../../gfx/spacer.gif" width="239" height="1"></p></td>
      <td width="11" rowspan="7" valign="top"><img src="../../gfx/spacer.gif" width="11" height="1"></td>
      <td colspan="2" valign="top">Dateien hinzuf&uuml;gen:</td>
    </tr>
    <tr> 
      <td width="103" valign="top"><a href="?id=<?php echo $id ?>&crease=-1">- 
        weniger</a></td>
      <td align="right" valign="top"><a href="?id=<?php echo $id ?>&crease=1"> 
        mehr +</a></td>
    </tr>
    <tr> 
      <td height="33" valign="top"><img src="../../gfx/spacer.gif" width="103" height="12"><br>
        Datei:<br> </td>
      <td height="90" rowspan="4" valign="top">
	  	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <?php
				for($i = 1; $i <= $n_uploads; $i++) {
					echo "<td width=\"250\">
						<img src=\"../../gfx/spacer.gif\" width=\"250\" height=\"1\">";
					include("list_upload_file.php");
					echo "</td>";
				}
				?>
          </tr>
        </table>
	  </td>
    </tr>
    <tr>
      <td height="20" valign="top">Bezeichnung:</td>
    </tr>
    <tr>
      <td height="30" valign="top">Kommentar:</td>
    </tr>
    <tr>
      <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2" align="right" valign="top"><a href="#" onClick="uploadform.submit(); return false"><strong>&raquo; 
        speichern</strong></a></td>
    </tr>
  </table>
</form>
</body>
</html>
