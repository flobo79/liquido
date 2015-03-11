<?php

include ("lib/init.php");
include ("lib/fnc_frontend.inc.php");
include ("functions.php");

if($select = $_POST['select']) {
	$list = getList($select);
}

$rennenges = db_entry("select count(id) as number from `game_highscores` order by id");
$getdurchschnitt = db_entry("select SUM(score) as sum from `game_highscores` order by id");
$durchschnitt = ($getdurchschnitt['sum'] / $rennenges['number']);

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Game</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
	<!--
	 top.head.location.href = 'head.php?location=settings'
	//-->
</script>

<link href="lib/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td width="239" height="157" rowspan="2" valign="top"> 
      <?php 
$content = "
	<a href=\"".$PHP_SELF."\">Übersicht</a><br>
	<a href=\"".$PHP_SELF."?page=logos\">Punkte und Logos</a><br>
";


drawLeftPane ($content);
?>
    </td>
    <td width="554" valign="top"><img src="components/<?php echo $current['comp'] ?>/gfx/logo.gif" width="77" height="74"> <br>
      <strong>VW Club Game<br>
      </strong></td>
  </tr>
  <tr>
    <td height="106" valign="top">
      <form name="form1" method="post" action="">
        <p>Anzahl der Rennen insgesamt: <?php echo $rennenges['number']  ?><br>
          Durchschnittliche Punktzahl: <?php echo round($durchschnitt,0);  ?></p>
        <p>Zeige Bestenliste f&uuml;r 
          <select name="select[month]">
            <option value="01" <?php if($select['month'] == "01") echo "selected" ?>>Januar</option>
            <option value="02" <?php if($select['month'] == "02") echo "selected" ?>>Februar</option>
            <option value="03" <?php if($select['month'] == "03") echo "selected" ?>>M&auml;rz</option>
            <option value="04" <?php if($select['month'] == "04") echo "selected" ?>>April</option>
            <option value="05" <?php if($select['month'] == "05") echo "selected" ?>>Mai</option>
            <option value="06" <?php if($select['month'] == "06") echo "selected" ?>>Juni</option>
            <option value="07" <?php if($select['month'] == "07") echo "selected" ?>>Juli</option>
            <option value="08" <?php if($select['month'] == "08") echo "selected" ?>>August</option>
            <option value="09" <?php if($select['month'] == "09") echo "selected" ?>>September</option>
            <option value="10" <?php if($select['month'] == "10") echo "selected" ?>>Oktober</option>
            <option value="11" <?php if($select['month'] == "11") echo "selected" ?>>November</option>
            <option value="12" <?php if($select['month'] == "12") echo "selected" ?>>Dezember</option>
          </select>
          <select name="select[year]">
            <option value="04" <?php if($select['year'] == "04") echo "selected" ?>>2004</option>
            <option value="05" <?php if($select['year'] == "05") echo "selected" ?>>2005</option>
          </select>
          <input type="submit" name="Submit" value="zeige">
        </p>
      </form>
      <table width="486" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="74"><strong>Punkte</strong></td>
          <td width="129"><strong>Name</strong></td>
          <td width="173"><strong>Email </strong></td>
          <td width="110"><strong>Datum:</strong></td>
        </tr>
		
		<?php
		
		if(is_array($list)) {
			foreach($list as $entry) {
		?>
        <tr> 
          <td><?php echo $entry['score'] ?></td>
          <td><?php echo $entry['name'] ?></td>
          <td><?php echo $entry['email'] ?></td>
          <td><?php echo date("d.m.y",$entry['date']) ?></td>
        </tr>
		<?php }} ?>
      </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      </td>
  </tr>
</table>
</body>
</html>
