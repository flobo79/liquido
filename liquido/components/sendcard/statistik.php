<?php

include ("functions.php");

$stat = mysql_fetch_array(mysql_query("select * from sendcard_stats"),MYSQL_ASSOC);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>sendcard</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" enctype="multipart/form-data" method="post" action="">
  <table width="394" border="0" cellspacing="1" cellpadding="0">
    <tr> 
      <td height="36" colspan="2" class="headline">E-Card Statistik</td>
    </tr>
    <tr> 
      <td align="center"><strong><?php echo $stat['cards_number'] ?></strong></td>
      <td>E-Cards wurden erstellt</td>
    </tr>
    <tr> 
      <td align="center"><strong><?php echo $stat['cards_confirmed'] ?></strong></td>
      <td>E-Cards wurden best&auml;tigt</td>
    </tr>
    <tr> 
      <td width="40" align="center"> <p> <strong><?php echo $stat['cards_read'] ?></strong></p></td>
      <td width="351">E-Cards wurden gelesen:</td>
    </tr>
    <tr> 
      <td align="center"><strong><?php echo $stat['cards_read'] ?></strong></td>
      <td>Besucher kamen von einer E-Card auf die Webseite</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"><strong><?php echo round(((100 / $stat['cards_number']) * $stat['cards_confirmed']),1) ?>% </strong>
      aller erstellten E-Cards wurden best&auml;tigt</td>
    </tr>
    <tr> 
      <td colspan="2">1 versendete E-Card wird durchschnittlich<strong> <?php echo round(((1 / $stat['cards_confirmed']) * $stat['cards_read']),1) ?> 
        x</strong> gelesen</td>
    </tr>
    <tr> 
      <td colspan="2">1 gelesene E-Card wird durchschnittlich<strong> <?php echo round((1 / $stat['cards_read']) * $stat['cards_answered']) ?> 
        x </strong>beantwortet</td>
    </tr>
    <tr> 
      <td colspan="2"> <strong><?php echo round((1 / $stat['cards_read']) * $stat['cards_returned']) ?> 
        x</strong> wechselt ein Besucher von 1 E-Card zur Webseite</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

</body>
</html>