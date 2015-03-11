<script type="text/javascript">
function popup (url,w,h) {
 fenster = window.open(url, "MEV", "width="+w+",height="+h+",toolbar=0,resizable=yes,scrollbars=yes");
 fenster.focus();
 return false;
}
</script>

<?php


$objecttitle = "Multiple Choice Gewinnspiel";
$table_questions = "kis_mc_game_questions";
$table_answers = "kis_mc_game_answers";
global $user;




/***********************************
  load mikos datensatz
***********************************/

$kis = $_SESSION['kis'];
if(!$kis->custInfo) {
	$kis->custInfo = new emptyClass();
	$kis->custInfo->memberNumber = "243234234";
}

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



//>>>>>  check if user has already accepted the disclaimer
$acceptedAlready = true; //db_entry("select acceptedRulesOn from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and acceptedRulesOn != 0") ? true : false;


if($_POST['set_mev']) {
	// save mev to mikos
	$kis->custInfo->is_maa = $_POST['set_mev'] == '2' ? 1 : 0;
	
	$sendobj = clone $kis->custInfo;
	unset($sendobj->localID, $sendobj->webStatus);
	
	if(!$kis->call('CMUpdateCustomerDetails',array('customer' => $sendobj))) { }
	db_query("update $table_answers set MEV = ".$kis->custInfo->is_maa." where kis_kunr = '".$kis->custInfo->memberNumber."'");
	$part = 'answered';
}

//>>>>   antworten speichern/aktualisieren
if(is_array($_POST['answer']) ) {
	if ((!$acceptedAlready && $_POST['disclaimer']) || ($acceptedAlready)) {
		
		
		
		// try to find BNR
		if(is_array($kis->custInfo->myCars)) {
			foreach($kis->custInfo->myCars as $contract) {
				if($contract->partnerBNR) {
					$BNR = $contract->partnerBNR;
				}
			}
		}
		
		$MEV = $_POST['is_maa'] ? '2' : '1';
		
		foreach($_POST['answer'] as $k => $v) {
			if(db_entry("select text from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$k'")) {
				$sql = "update $table_answers set 
					`text` = '".mysql_real_escape_string(trim($v['text']))."',
					`Name` = '".mysql_real_escape_string($kis->custInfo->name)."',
					`Vorname` = '".mysql_real_escape_string($kis->custInfo->firstName)."',
					`Adresse` = '".mysql_real_escape_string($kis->custInfo->street." ".$kis->custInfo->houseNumber." ".$kis->custInfo->houseNumberAdd.", ".$kis->custInfo->zip." ".$kis->custInfo->city)."',
					`Mitgliedsnummer` = '".mysql_real_escape_string($kis->custInfo->memberNumber)."',
					`BNR` = '".mysql_real_escape_string($BNR)."',
					`MEV` = '".mysql_real_escape_string($MEV)."'
				 where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$k'";
			} else {
				$time = time();
				$sql = "insert into $table_answers set 
					`text` = '".mysql_real_escape_string(trim($v['text']))."',
					`Name` = '".mysql_real_escape_string($kis->custInfo->name)."',
					`Vorname` = '".mysql_real_escape_string($kis->custInfo->firstName)."',
					`Adresse` = '".mysql_real_escape_string($kis->custInfo->street." ".$kis->custInfo->houseNumber." ".$kis->custInfo->houseNumberAdd.", ".$kis->custInfo->zip." ".$kis->custInfo->city)."',
					`Mitgliedsnummer` = '".mysql_real_escape_string($kis->custInfo->memberNumber)."',
					`BNR` = '".mysql_real_escape_string($kis->custInfo->BNR)."',
					`kis_kunr` = '".$kis->custInfo->memberNumber."',
					`MEV` = '".mysql_real_escape_string($MEV)."',
					`q_id` = '$k', `acceptedRulesOn`='$time'";
			}
			db_query($sql);
		}
		
		$part = 'answered';
	}
	
	// if user hasn't accepted the marketing agreement, send him
	// to the question page
	
	
	if(!$kis->custInfo->is_maa) {
		$is_maa = '0';
	} else {
		$is_maa = '1';
	}
}


// fetch all questions from database database
$questions = db_array("select * from $table_questions order by id");

//check if user session exists
if($kis->custInfo->memberNumber or $user) {  ?>

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
			<input type="button" name="getcsv" value="Ergebnisse als CSV" onclick="window.open('/liquido_objects/vw-club/16/getcsv.php')" />
		</div>


<?php break;  case "public":  //------------------------    ?>

		<table width="100%">
			<tr><td colspan="2" style="background-color: #cccccc"><h3>Ihre Daten</h3></td></tr>
			<tr><td>Name:</td><td><b><?php echo $kis->custInfo->firstName." ".$kis->custInfo->surname; ?></b></td></tr>
			<tr><td>E-Mail:</td><td><b><?php echo $kis->custInfo->email; ?></b></td></tr>
		</table>

		<form action="" method="post" >
	<?php if(is_array($questions)) {
		$answeridx = 0;
		foreach($questions as $question) {
			$answer = db_entry("select * from $table_answers where kis_kunr = '".$kis->custInfo->memberNumber."' and q_id = '$question[id]' LIMIT 1"); ?>
		<div style="font-weight:bold; margin-bottom:15px; margin-top:30px;">
			<?php echo nl2br($question['title']); ?>
		</div>
		<div style="margin-bottom:20px; display:block; clear:both;" >
			
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
		
		<?php if (!$is_maa && $answer['MEV'] != '2') { ?>
		<table border="0">
			<tr>
			<td valign="top"><input type="checkbox" name="is_maa" id="is_maa" value="1" /></td>
			<td valign="top">Ja, ich bin damit einverstanden, dass meine vorstehenden personenbezogenen Daten (einschließlich meiner Telefonnummer und E-Mail-Adresse) zum Zwecke der <a class="copy" style="font-size: 9px;" href="http://www.volkswagen.de/vwcms_publish/vwcms/master_public/virtualmaster/de3/login/login/rechtliches/datenschutz0/datenschutz.html" target="_blank" onclick="return popup(this.href,800,600);">persönlich auf mich zugeschnittenen Werbung und Marktforschung</a> von der Volkswagen AG, den <a class="copy" style="font-size: 9px;" href="http://www.volkswagenag.com/vwag/vwcorp/content/de/homepage.html" target="_blank" onclick="return popup(this.href,1024,768);">Volkswagen Konzerngesellschaften</a> sowie den von mir ausgewählten Volkswagen Partnern (Händlern) verarbeitet und genutzt werden.</td>

			</tr>
		</table>
		<?php } ?>
		<div id="savethis" style="margin-top:15px; display:block; clear:both;">
			<input type="submit" name="submitme" value="Antwort(en) speichern" <?php if ($acceptedAlreadyxxx  ) { ?>onclick="if(document.getElementById('disclaimer').checked==false) { alert('Sie müssen die Nutzungsbedingungen anerkennen um teilnehmen zu können.'); return false; }" <?php } ?> />
		</div>	
		</form>
		
		
		
<?php break;  case "MEV":  //------------------------    ?>

	Stimmen Sie zu?
	<form name="form_mev" action="" method="post" >
		<input type="button" name="mev" value=" ja " onclick="document.getElementById('set_mev').value='2'; submit();" />&nbsp;&nbsp;
		<input type="button" name="mev" value=" nein "  onclick="document.getElementById('set_mev').value='1'; submit();"  />
		<input type="hidden" name="set_mev" value="" id="set_mev" />
	</form>




<?php break;  case "answered":  //------------------------    ?>

	<span style="font-weight:bold; color:#006600;">Ihre Antwort(en) wurden gespeichert. Vielen Dank und viel Glück.</span><br />

<?php break; }
} // if kis[mitgliedsnr] ?>

</div>