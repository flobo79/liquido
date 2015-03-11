<?php

	require_once("../../lib/init.php");
	require_once("lib/functions.php");
	
	$id = $_GET['id'];
	$result = getObjectData($id); 
	$import = $_POST['import'];
	$ftpfolder = $_GET['ftpfolder'];
	
	if ($import) {
		importFolder($import);
		updateColumnChilds($id);
	}

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
      <td width="22" rowspan="3" valign="top"> <p> 
          <input name="id" type="hidden" id="id" value="<?php echo $id ?>">
          <input name="import[id]" type="hidden" id="id" value="<?php echo $id ?>">
          <input name="import[folder]" type="hidden" value="<?php echo $ftpfolder ?>">
          <img src="../../gfx/spacer.gif" width="22" height="1"> </p></td>
      <td width="74" height="97" rowspan="3" align="center" valign="top"><p><img src="gfx/upload_folder_big.gif"><br>
          <br>
          [<a href="list_details.php?id=<?php echo $id ?>">abbrechen</a>] 
        </p>
        <p><img src="../../gfx/spacer.gif" width="74" height="1"></p></td>
      <td width="239" rowspan="3" valign="top"> <p><br>
          <span class="headline"><?php echo $result[name] ?></span> </p>
        <p><?php echo $result[info] ?></p>
        <p><img src="../../gfx/spacer.gif" width="239" height="1"></p></td>
      <td height="24" colspan="2" valign="top">Ftp-UploadVerzeichnis</td>
    </tr>
    <tr> 
      <td width="182" height="66" valign="top"> 
			<table width="150" border="0" cellspacing="0" cellpadding="0">
			  <?php listFtpFolder($id); ?>
			</table>
		</td>
      <td width="213" valign="top"> 
        <?php 
		if($ftpfolder) { 
		$folderdetails = getFtpFolderDetails($ftpfolder);
		?>
        <p>Ordnerdetails<br>
          <br>
          <?php echo $folderdetails['number'] ?> Dokumente</p>
        <p>
          
          <!-- 
          <input name="import[del]" type="checkbox" value="1">
          nach dem Importiern l&ouml;schen</p> 
           -->
        <div align="right"><a href="#" onClick="uploadform.submit(); return false">&raquo; 
          importieren</a> 
          <?php } ?>
          </div>
        <p>&nbsp;</p></td>
    </tr>
    <tr> 
      <td colspan="2" align="right" valign="top">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
