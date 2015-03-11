<?php


function getList($select) {
	$from = mktime(0,0,1,$select['month'],1,$select['year']);
	$to = mktime(0,0,0,$select['month']+1,-1,$select['year']);
	$sql = "select * from `game_highscores` where `date` between $from and $to order by `score` DESC LIMIT 10";

	$list = db_array($sql);
	return $list;
}


// contents-template
$objecttitle = "Top 10";

if ($part == "compose") include($cfgcmspath."/components/contents/compose/templates/object_head.php");

if(isset($_POST['select']))  {
	$select = $_POST['select'];
} else {
	$select['month'] = date("m",time());
	$select['year'] = date("y",time());
}
$list = getList($select);

$rennenges = db_entry("select count(id) as number from `game_highscores` order by id");
$getdurchschnitt = db_entry("select SUM(score) as sum from `game_highscores` order by id");

$durchschnitt = ($getdurchschnitt['sum'] / $rennenges['number']);

?>


      
<table width="430" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form1" method="post" action="">
        <p>Anzahl der Rennen insgesamt: <?php echo $rennenges['number']  ?><br>
          Durchschnittliche Punktzahl: <?php echo round($durchschnitt,0);  ?></p>
        <p>Zeige Bestenliste f&uuml;r 
          <select name="select[month]">
            <option value="01" <?php if($_POST['select']['month'] == "01") echo "selected"; ?> >Januar</option>
            <option value="02" <?php if($_POST['select']['month'] == "02") echo "selected"; ?> >Februar</option>
            <option value="03" <?php if($_POST['select']['month'] == "03") echo "selected"; ?> >M&auml;rz</option>
            <option value="04" <?php if($_POST['select']['month'] == "04") echo "selected"; ?> >April</option>
            <option value="05" <?php if($_POST['select']['month'] == "05") echo "selected"; ?> >Mai</option>
            <option value="06" <?php if($_POST['select']['month'] == "06") echo "selected"; ?> >Juni</option>
            <option value="07" <?php if($_POST['select']['month'] == "07") echo "selected"; ?> >Juli</option>
            <option value="08" <?php if($_POST['select']['month'] == "08") echo "selected"; ?> >August</option>
            <option value="09" <?php if($_POST['select']['month'] == "09") echo "selected"; ?> >September</option>
            <option value="10" <?php if($_POST['select']['month'] == "10") echo "selected"; ?> >Oktober</option>
            <option value="11" <?php if($_POST['select']['month'] == "11") echo "selected"; ?> >November</option>
            <option value="12" <?php if($_POST['select']['month'] == "12") echo "selected"; ?> >Dezember</option>
          </select>
          <select name="select[year]">
            <option value="05" <?php if($_POST['select']['year'] == "05") echo "selected"; ?>  >2005</option>
			<option value="06" <?php if(($_POST['select']['year'] == "06") or (!$_POST['select']['year'])) echo "selected"; ?>  >2006</option>
			<option value="07" <?php if(($_POST['select']['year'] == "07") or (!$_POST['select']['year'])) echo "selected"; ?>  >2007</option>
			<option value="08" <?php if(($_POST['select']['year'] == "08") or (!$_POST['select']['year'])) echo "selected"; ?>  >2008</option>
          </select>
          <input type="submit" name="Submit" value="zeige">
        </p>
        </form>
      <table width="396" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="93"><strong>Punkte</strong></td>
          <td width="190"><strong>Name</strong></td>
          <td width="113"><strong>Datum:</strong></td>
        </tr>
		
		<?php
		
		if(is_array($list)) {
			foreach($list as $entry) {
		?>
        <tr> 
          <td><?php echo $entry['score'] ?></td>
          <td><?php echo $entry['name'] ? $entry['name'] : "Fahrer ".$entry['id']; ?></td>
          <td><?php echo date("H:i - d.m.Y",$entry['date']) ?></td>
        </tr>
		<?php }} ?>
      </table>
      </td>
  </tr>
</table>
<p>&nbsp;</p>
