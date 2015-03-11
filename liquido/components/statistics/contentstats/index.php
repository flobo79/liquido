<?php include("../../../lib/init.php"); ?>
<html>
<head>
<title>Liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../lib/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="501" border="0" cellspacing="0" cellpadding="0">
  <tr class="headline"> 
    <td width="272">Seite</td>
    <td width="85">Typ</td>
    <td width="65">Status</td>
    <td width="79">Aufrufe</td>
  </tr>
  <?php 
$sql = "select title,type,status,views from $cfgtablecontents where del != '1'"; //echo $sql;
$q = mysql_query($sql);
while($result = mysql_fetch_row($q)) {
$status = $result[2] = "1" ? "online" : "offline";
echo "  <tr> 
    <td>$result[0]</td>
    <td>$result[1]</td>
    <td>$status</td>
	<td>$result[3]</td>
  </tr>
  ";
  
 }
 
 ?>
</table>
</body>
</html>
