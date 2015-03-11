<?php
global $user;

// contents-template
$objecttitle = "6 Monats Gewinnspiel";
if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

$table_questions = "kis_game_questions";
$table_answers = "kis_game_answers";

$kis = $_SESSION['kis'];
if(!$kis->custInfo) {
	$kis->custInfo = new emptyClass();
	$kis->custInfo->memberNumber = "243234234";
}

// frage hinzufügen
if($_POST['newquestion']['text'] and $_POST['newquestion']['title']) {
	$newq = $_POST['newquestion'];
	db_query("insert into $table_questions set `title` = '".mysql_real_escape_string($newq['title'])."', `text` = '".mysql_escape_string($newq['text'])."'");
}

// frage löschen
if($delq = intval($_GET['delq'])) {
	// frage löschen
	db_query("delete from $table_questions where id = $delq");
	
	// alle antworten löschen
	db_query("delete from $table_answers where q_id = $delq");
}

// fragen aktualisieren
if(is_array($_POST['question'])) {
	foreach($_POST['question'] as $k => $v) {
		//echo "update $table_questions set `title` = '".mysql_escape_string($v['title'])."', `text` = '".mysql_escape_string($v['text'])."' where id = '".mysql_escape_string($k)."'";
		db_query("update $table_questions set `title` = '".mysql_escape_string($v['title'])."', `text` = '".mysql_escape_string($v['text'])."' where id = '".mysql_escape_string($k)."'");
	}
}

	// first check if user has answered in the past
	//echo "select acceptedRulesOn from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and acceptedRulesOn != 0";
	if (db_entry("select acceptedRulesOn from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and acceptedRulesOn != 0")) {
		$acceptedAlready = true;
	} else {
		$acceptedAlready = false;
	}


// antworten speichern/aktualisieren
if(is_array($_POST['answer']) ) {
	//echo "hier!";
	// you know...
	if ( ( !$acceptedAlready && $_POST['disclaimer'] ) || ( $acceptedAlready ) ) {

		foreach($_POST['answer'] as $k => $v) {
		
			if(db_entry("select text from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$k'")) {
				db_query("update $table_answers set `text` = '$v[text]' where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$k'");
			} else {
				$time = time();
				db_query("insert into $table_answers set `text` = '$v[text]', kis_kunr = '".$kis->custInfo->memberNumber."', q_id = '$k', `acceptedRulesOn`='$time'");
			}
		}
		$answered = true;
	}
}

/*
// antworten speichern/aktualisieren
if(is_array($_POST['answer']) && isset($_POST['disclaimer']) ) {
	foreach($_POST['answer'] as $k => $v) {
		
		if(db_entry("select text from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$k'")) {
			db_query("update $table_answers set `text` = '$v[text]' where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$k'");
		} else {
			db_query("insert into $table_answers set `text` = '$v[text]', kis_kunr = '".$kis->custInfo->memberNumber."', q_id = '$k'");
		}
	}
	$answered = true;
}
*/

//check if user session exists
if($kis->custInfo->memberNumber or $user) {

	// fetch database
	$questions = db_array("select * from $table_questions order by id");

?>

<div style="text-align:left; width:430px;">	

<?php 	if($part != "compose") { ?>
	<br /><br />
	<table width="100%">
		<tr><td colspan="2" style="background-color: #cccccc"><h3>Ihre Daten</h3></td></tr>
		<tr><td>Name:</td><td><b><?php echo $kis->custInfo->firstName." ".$kis->custInfo->surname; ?></b></td></tr>
		<tr><td>E-Mail:</td><td><b><?php echo $kis->custInfo->email; ?></b></td></tr>
	</table>

	<form action="" method="post" > <?php } ?>
	
	<?php
	// draw question for each month exists
	if(is_array($questions)) {
		$answeridx = 0;
		foreach($questions as $question) {
			$answer = db_entry("select * from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$question[id]' LIMIT 1");
	?>
	
	<div style="font-weight:bold; margin-bottom:15px; margin-top:30px;">
	<?php if($part == "compose") { ?>
		<input type="text" style="width:400px" name="question[<?php echo $question['id'] ?>][title]" value="<?php echo $question['title'] ?>" />
		<a href="#" title="Frage l&ouml;schen?" onclick="if(confirm('Frage und alle Antworten löschen?')) { document.location.href='?delq=<?php echo $question['id'] ?>'; }"> [x]</a>
	<?php } else { ?>
		<?php echo nl2br($question['title']); ?>
	<?php } ?>
	</div>
	
	<div style="margin-bottom:10px;" >
		<?php if($part == "compose") { ?>
			<textarea style="width:430px;height:50px;" name="question[<?php echo $question['id'] ?>][text]" ><?php echo $question['text']; ?></textarea>
		<?php } else { ?>
			<?php echo nl2br($question['text']); ?>
		<?php } ?>
	<div>
	<?php if($part != "compose") { ?>
	<div style="margin-top:10px;">
		Ihre Antwort:<br />
		<?php if( is_array( $_POST['answer'] ) ) { $q_id = $question['id']; ?>
			<textarea name="answer[<?php echo $question['id'] ?>][text]" style="width:430px; height:50px;"><?php echo $_POST['answer'][$q_id]['text']; ?></textarea>
		<?php } else { ?>
			<textarea name="answer[<?php echo $question['id'] ?>][text]" style="width:430px; height:50px;"><?php echo nl2br($answer['text']); ?></textarea>
		<?php } ?>
	</div>
	
	<?php } ?>
	

<?php }} // foreach question ?>

<div id="disclaimer" style="margin-top:15px">
<?php if (!$acceptedAlready) { ?>

	<table border="0">
	<tr>
		<td valign="top"><input type="checkbox" name="disclaimer" id="disclaimer" /></td>
		<td valign="top">Ich bin damit einverstanden, dass meine vorstehend angegebenen personenbezogenen Daten (auch meine E-Mail-Adresse und Telefonnummer) zu Zwecken der Kundenbetreuung, -befragung und pers&ouml;nlich auf mich zugeschnittenen Kundeninformation von der Volkswagen AG und den von mir beauftragten Volkswagen Partnern (H&auml;ndlern und Werkst&auml;tten) erhoben, verarbeitet, &uuml;bermittelt und genutzt werden d&uuml;rfen.</td>

	</tr>
	</table>
<?php } ?>
</div>
	
<div id="savethis" style="margin-top:15px;">
	<input type="submit" name="submitme" value="<?php if($part != "compose") { ?>Antwort(en) speichern<?php } else { ?> Fragen aktualisieren<?php } ?>" />
  <br />
  
  <?php if($answered) { ?><span style="font-weight:bold; color:#006600;">Ihre Antwort(en) wurden gespeichert. Vielen Dank und viel Gl&uuml;ck.</span><br /><?php } 
	elseif (!$answered && isset($_POST['submit']) ) { ?><span style="font-weight:bold; color:#990000;">Sie m&uuml;ssen die Vereinbarung akzeptieren!</span><br /><?php } ?>
</div>
<?php if($part == "compose") { ?>
	<div style="margin-top:35px;">
		<strong>Weitere Frage hinzuf&uuml;gen</strong><br />
		<br />
		Titel:<br />
		<span style="font-weight:bold; margin-bottom:15px;">
		<input type="text" style="width:430px" name="newquestion[title]" />
		</span><br />
		Beschreibung:<br />
		<textarea style="width:430px;height:50px;" name="newquestion[text]" ></textarea>
		<br />
		<br />
		<input type="submit" name="savenewquestion" value="Frage hinzuf&uuml;gen" />
	</div>
	
	<div style="margin-top:25px;">
		<input type="button" name="getcsv" value="Ergebnisse als CSV" onclick="window.open('/liquido_objects/vw-club/15/getcsv.php')" />
	</div>
</div>
<?php } ?>
<?php if($part != "compose") { ?></form> <?php } ?>
<?php } // if kis[mitgliedsnr] ?>