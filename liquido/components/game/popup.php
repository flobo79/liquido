<?php 

include ("functions.php");

if($_POST['delconfirm']) {
	$deleted = delImage($_POST['file']);
	$reloadparent=true;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Ansicht</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
	<?php if($reloadparent) echo "opener.window.reload();"; ?>

</script>

</head>

<body bgcolor="#F8F8F8">
<form name="form" action="" method="post">
<?php if ($_POST['deletethis']) { ?>
Möchten Sie das Motiv wirklich löschen? Alle versendeten Karten mit diesem Motiv werden ebenfalls gelöscht.<br><br>
<input type="submit" name="delconfirm" value="ja, l&ouml;schen">
  <input type="button" name="cancel" value="nein, abbrechen" onClick="history.back()">
<?php } elseif($deleted==true) { ?>
Motiv wurde gelöscht<br><br><input type="button" name="Fenster schliessen" value="ok" onClick="window.close();">
<?php } else { ?> 
<img src="<?php echo $imagepath.$file ?>" width="430">
<br>
<br><input type="submit" name="deletethis" value="Motiv l&ouml;schen">
<?php } ?>
<input type="hidden" name="file" value="<?php echo $file ?>">
</form>
</body>
</html>
