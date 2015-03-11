<?php

include ("functions.php");

if($_FILES['addimage']['size'] != 0) {
	$filename = $_FILES['addimage']['name'];
	$source = $_FILES['addimage']['tmp_name'];
	
	if(file_exists($imagepath.$filename)) {
		for($i=1;file_exists($imagepath.$i.$filename);$i++) { }
		$filename = $i.$filename; 
	}
	copy($source,$imagepath.$filename);
}

if($_POST['addphrase']) {
	addPhrase($_POST['addphrase']);
}
if($delphrase = $_GET['delphrase']) {
	mysql_query("delete from sendcard_phrases where id = '$delphrase' LIMIT 1");
}

$images = listImages($imagepath);
$phrases = listPhrases();

session_write_close();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>sendcard</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../lib/css.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" enctype="multipart/form-data" method="post" action="">
  <table width="250" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="headline">Sendcard verwalten</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><strong>Angebotene Motive:</strong><br>
		<table width="450" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			
<?php 
	$max = 6;
	$i=0;
	foreach($images as $file) {
		echo "<td align=\"center\" width=\"55\" height=\"50\">
			<a href=\"#\" onClick=\"window.open('popup.php?file=$file','details','height=400,width=450');\"><img src=\"$imagepath$file\" border=\"0\" width=\"50\"></a><br>\n
		</td>";
		$i++;
		if($i == $max) {
			echo "</tr><tr>\n";
			$i=0;
		}
	}
	if($i > 0) echo "<td colspan=\"".($max-$i)."\">&nbsp;</td>\n";
	 ?>
	 
		  </tr>
		</table>
      </p>
      Motiv hinzuf&uuml;gen:<br>
        <input name="addimage" type="file" id="addimage">
        <input type="submit" name="Submit" value="hinzuf&uuml;gen"> 
        <p><br>
      </p></td>
  </tr>
  <tr>
    <td><p><strong>Angebotene Textzeilen:</strong><br>
          <br>
          <?php
		  foreach($phrases as $id => $entry) {
		  	echo "<a href=\"?delphrase=$id\">l&ouml;schen</a> | $entry<br>\n";		  
		  }
		  
		  
		  ?><br>
      </p>
        <p> 
          <input name="addphrase" type="text" id="addphrase" maxlength="50">
          <input type="submit" name="Submit2" value="speichern">
        </p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

</body>
</html>