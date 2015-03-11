<?php

$objecttitle = "MC Gewinnspiel public";
$table_questions = "mc_game_questions";
$table_answers = "mc_game_answers";
global $user;

/***********************************
  compose Functions 
***********************************/

//>>>>   frage hinzufügen    <<<<<<<<<<<<
if($_POST['newquestion']['text'] && $_POST['newquestion']['title'] && $_POST['newquestion']['answers']) {
	$v = $_POST['newquestion'];
	$sql = "insert into $table_questions set `title` = '".mysql_real_escape_string($v['title'])."', 
		`text` = '".mysql_real_escape_string($v['text'])."',
		`answers` = '".mysql_real_escape_string($v['answers'])."'";
	db_query($sql);
}

//>>>>>  fragen aktualisieren   <<<<<<<<<<<
if(is_array($_POST['question'])) {
	foreach($_POST['question'] as $k => $v) {
		$sql = "update $table_questions set 
			`title` = '".mysql_real_escape_string($v['title'])."', 
			`text` = '".mysql_real_escape_string($v['text'])."',
			`answers` = '".mysql_real_escape_string($v['answers'])."' 
		 where id = '".intval($k)."'";
		
		db_query($sql);
	}
}

//>>>>>>  frage löschen <<<<<<<<<<<<<
if($delq = intval($_GET['delq'])) {
	// frage löschen
	db_query("delete from $table_questions where id = ".intval($delq));
	
	// alle antworten löschen
	db_query("delete from $table_answers where q_id = ".intval($delq));
	
	$question_deleted = true;
}


/***********************************
  public Functions 
***********************************/

//>>>>   antworten speichern/aktualisieren
if(is_array($_POST['answer']) ) {
	if ((!$acceptedAlready && $_POST['disclaimer']) || ($acceptedAlready)) {
		
		foreach($_POST['answer'] as $k => $v) {
			if(db_entry("select text from $table_answers where kis_kunr = '".mysql_real_escape_string($_POST['my_accountnumber'])."' and q_id = '$k'")) {
				db_query("update $table_answers set 
					`text` = '".mysql_real_escape_string(trim($v['text']))."',
					`Name` = '".mysql_real_escape_string($_POST['my_surname'])."',
					`Vorname` = '".mysql_real_escape_string($_POST['my_firstname'])."',
					`Adresse` = '".mysql_real_escape_string($_POST['my_address'])."',
					`MEV` = '".mysql_real_escape_string($_POST['mev'])."'
				 where kis_kunr = '".mysql_real_escape_string($_POST['my_accountnumber'])."' and q_id = '$k'");
			} else {
				$time = time();
				
				
				db_query("insert into $table_answers set 
					`text` = '".mysql_real_escape_string(trim($v['text']))."',
					`Name` = '".mysql_real_escape_string($_POST['my_surname'])."',
					`Vorname` = '".mysql_real_escape_string($_POST['my_firstname'])."',
					`Adresse` = '".mysql_real_escape_string($_POST['my_address'])."',
					`kis_kunr` = '".mysql_real_escape_string($_POST['my_accountnumber'])."',
					`MEV` = '".mysql_real_escape_string($_POST['mev'])."',
					`q_id` = '$k', `acceptedRulesOn`='$time'");
			}
		}
	
	}
	
	$part = "answered";
}

// fetch all questions from database database
$questions = db_array("select * from $table_questions order by id");
?>


<div style="text-align:left; width:430px;">	

<?php 	
	switch($part) { case "compose": //>>>>>>>>>>>>>>>>>>>>>>>>>
		include("$cfgcmspath/components/contents/compose/templates/object_head.php");
		
		global $mod16;
		if($mod16) die("dieses Modul kann nur einmal pro Seite verwendet werden.");
		$mod16 = true;
		
		
		if(is_array($questions)) {
			$answeridx = 0;
			foreach($questions as $question) {
				$answer = db_entry("select * from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$question[id]' LIMIT 1"); ?>
		<div style="font-weight:bold; margin-bottom:15px; margin-top:30px;">
			<span >Titel:</span><br/>
			<input type="text" style="width:400px" name="question[<?php echo $question['id'] ?>][title]" value="<?php echo $question['title'] ?>" />
			<a href="#" title="Frage löschen?" onclick="if(confirm('Frage und alle Antworten löschen?')) { document.location.href='?delq=<?php echo $question['id'] ?>'; }"> [x]</a>
		</div>
		
		<div style="margin-bottom:20px; display:block; clear:both;" >
			<span >Frage:</span><br/>
			<textarea style="width:430px;height:50px;" name="question[<?php echo $question['id'] ?>][text]" ><?php echo $question['text']; ?></textarea>
		<div>
		
		<div style="margin-bottom:10px; display:block; clear:both;" >
			<span >Antworten (je Antwort eine Zeile):</span><br />
			<textarea style="width:430px;height:50px;" name="question[<?php echo $question['id'] ?>][answers]" ><?php echo $question['answers']; ?></textarea>
		</div>
		<?php }} ?>
		
		<div style="margin-top:35px; display:block; clear:both;">
			<strong>Weitere Frage hinzufügen</strong><br />
			<br />
			Titel:<br />
			<span style="font-weight:bold; margin-bottom:15px;">
			<input type="text" style="width:430px" name="newquestion[title]" />
			</span><br />
			Frage:<br />
			<textarea style="width:430px;height:50px;" name="newquestion[text]" ></textarea>
			<br />
			Antworten (je Antwort eine Zeile):<br />
			<textarea style="width:430px;height:60px;" name="newquestion[answers]" ></textarea>
			<br />
			<input type="submit" name="savenewquestion" value="Frage hinzufügen" />
		</div>

		<div style="margin-top:25px;">
			<input type="button" name="getcsv" value="Ergebnisse als CSV" onclick="window.open('/liquido_objects/vw-club/17/getcsv.php')" />
		</div>


<?php break;  case "public":  //------------------------    ?>

		<form action="" method="post" >
	<?php if(is_array($questions)) {
		$answeridx = 0;
		foreach($questions as $question) {
			$answer = db_entry("select * from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$question[id]' LIMIT 1"); ?>
		<div style="font-weight:bold; margin-bottom:15px; margin-top:30px;">
			<?php echo nl2br($question['title']); ?>
		</div>
		<div style="margin-bottom:20px; display:block; clear:both;" >
			<span >Frage:</span><br />
			<?php echo nl2br($question['text']); ?>
		<div>
		<br />
		<div style="margin-bottom:10px; display:block; clear:both;" >
			<b>Ihre Antwort:</b> <br />
			<?php
				$thisanswers = split("\n",$question['answers']);
				foreach($thisanswers as $option) {
					$checked = $answer['text'] == urlencode(trim($option)) ? 'checked="true"' : '';
					echo "<input type=\"radio\" name=\"answer[".$question['id']."][text]\" value=\"".urlencode(trim($option))."\" $checked /> $option<br/> ";
				}
			?>
		</div>
		<br />
		<?php }} ?>
	
		<table border="0">
			<tr>
			<td valign="top">Vorname:</td>
			<td valign="top">
				<input type="text" id="my_firstname"  name="my_firstname" value="" style="width:200px;"/>*
			
			</td>
			</tr>
			
			<tr>
			<td valign="top">Nachname:</td>
			<td valign="top">
				<input type="text" id="my_surname" name="my_surname" value="" style="width:200px;"/>*
				
			</td>
			</tr>
			
			<tr>
			<td valign="top">Anschrift:</td>
			<td valign="top">
				<textarea name="my_address" id="my_address" style="width:200px; height:50px;"></textarea>*
			</td>
			</tr>
			<tr>
			<td valign="top">Mitgliedsnummer:</td>
			<td valign="top">
				<input type="text" id="my_accountnumber" name="my_accountnumber" value="" style="width:200px;"/>*
				
			</td>
			</tr>
			<tr>
			<td valign="top"><input type="checkbox" name="mev" id="mev" value="1" /></td>
			<td valign="top">
				MEV ABFRAGE TEXT HIER ERGÄNZEN!!
				
			</td>
			</tr>
		</table>
		
		<div id="savethis" style="margin-top:15px; display:block; clear:both;">
			<input type="submit" name="submitme" value="Antwort(en) speichern" <?php if (!$acceptedAlready) { ?>onclick="if (document.getElementById('my_firstname').value=='' || document.getElementById('my_surname').value=='' || document.getElementById('my_address').value=='' || document.getElementById('my_accountnumber').value=='') { alert('Bitte f&uuml;llen Sie alle ben&ouml;tigten Felder aus.'); return false; }" <?php } ?> />
		</div>	
	</form>
<?php break;  case "answered":  //------------------------    ?>

	<span style="font-weight:bold; color:#006600;">Ihre Antwort(en) wurden gespeichert. Vielen Dank und viel Gl&uuml;ck.</span><br />
<?php break; } ?>
</div>