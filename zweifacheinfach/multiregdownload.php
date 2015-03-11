<html>
<head>
<style>
body {
  color: #000;
  background-color: #fff;
  font-family: Arial;
  font-size: 11px;
}
</style>
</head>

<body>
<?php 

$link = mysql_connect('localhost', 'web7', 'v1ewr04d');
mysql_select_db('web7');

$code = mysql_real_escape_string(urldecode($_GET['ticket']));

$sql = "SELECT * FROM uploadmap WHERE secretcode='$code' LIMIT 1";

$result = mysql_query($sql);

if(mysql_affected_rows() == 0)
	die("<b>Das übergebene Ticket ist ungültig.</b><br /><br /> Sollten Sie auf den Link in der E-Mail geklickt haben, versuchen Sie bitte den vollständigen Link in die Adresszeile Ihres Browsers zu kopieren und die Adresse anschließend aufzurufen. Sollte das Problem weiterhin bestehen, wenden Sie sich bitte an den Systemadministrator.");

if($result) {

	$row = mysql_fetch_assoc($result);
	if ($row['times_downloaded'] < 2) {
	
		// update data entry	
		$sql = "UPDATE uploadmap SET `times_downloaded`=".($row['times_downloaded'] + 1)." WHERE `id`=".$row['id'];
		$upres = mysql_query($sql);
		if($upres) {
		
			ob_end_clean();
			
			header("Cache-Control: no-cache, must-revalidate");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
			header('Content-type: application/excel');
			header('Content-Disposition: attachment; filename="'.substr(strrchr($row['filename'], "/"), 1).'');
			header("Content-Transfer-Encoding: none");
			//header("Content-Length: ".filesize($row['filename']));
			readfile($row['filename']);
		}
	} else {
		echo "Die angeforderte Datei wurde bereits heruntergeladen und ist f&uuml;r weitere Downloads gesperrt.";
	}
}

?>
</body>
</html>