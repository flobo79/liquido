<?php

$noinit = 1;
$auth_noredirect = true;

error_reporting(E_PARSE);

global $ispublishing;
$ispublishing = true;
$path = "../";

ob_start();
if(!$_SERVER['argv'][1]) die("keine Parameter übergeben");
$issue = intval($_SERVER['argv'][1]);
chdir(dirname(__FILE__));
ini_set("include_path", ".:./:../");
$rootpath = dirname(dirname(dirname(__FILE__)));
require ("../../../lib/init.php");
require (dirname(__FILE__)."/functions.inc.php");
require (dirname(dirname(__FILE__))."/functions.inc.php");

$issue = $db->con->getRow("select * from `".$cfg['tables']['nlpublishs']."` where `pb_id` = '$issue' LIMIT 1");
if(!$issue['pb_id']) die("issue not found");

// define some shortcuts
$user['id'] = $issue['user_id'];
$groups = $issue['pb_groups'];
$thiscomp['id'] = $issue['pb_issue'];
$nlid = $issue['pb_issue'];
$pbid = $issue['pb_id'];
$publishing = true;
$abotable = $cfg['tables']['nlabos'];

if(!$_SERVER['DOCUMENT_ROOT']) $_SERVER['DOCUMENT_ROOT'] = $cfg['env']['document_root'];

$start = explode(' ', microtime());
$starttime = $start[1] + $start[0];

// get User
$user = $db->con->getRow('select * from '.db_table('editors').' where `id` = '.$user['id'].' LIMIT 1');

if(isset($nlid) and isset($user['id']) and isset($groups)) {
	// get and prepare letter content
	$nlobj = getdata($nlid);
	$letter = getLetter($nlobj);

	// gruppen ermitteln
	if($groups != "x") {
		$groups = explode("-",$groups);
		foreach ($groups as $group) {
			if($group) $condition .= '`group` LIKE \'%;'.$group.';%\' or ';
		}
		$condition = 'and ('.substr($condition,0,-4).')';
	}
	
	$subject = $nlobj['title'];
	$num=0; // count letters
	// erstelle mime-kompatible multipart mail
	ob_start();
	$mailpart = "head";
	include("mailbody.php");
	$mailhead = ob_get_contents();
	ob_clean();
	
	// text-bereich
	$mailpart = "htmlpart";
	include("mailbody.php");
	$htmlpart = ob_get_contents();
	ob_clean();

	$mailpart = "end";
	include("mailbody.php");
	$mailend = ob_get_contents();
	ob_clean();
	
	// ermittle startzeit der versendung
	$pt = explode(' ', microtime());
	$parsetime = $pt[0] + $pt[1];
	
	// für jeden abonennten
	// lese alle aktiven abos
	$sq_abos = "select * from `$abotable` where status = '0' $condition order by id";
	$q_abos = mysql_query($sq_abos);
	
	while($abo = mysql_fetch_row($q_abos)) {
		$db->execute("update `$abotable` set `issues_sent` = CONCAT(`issues_sent`, ';".$issue['pb_id']."') where `id` = '".$abo[0]."' LIMIT 1");		
		
		// lade bereichs-auswahl
		$mps = explode(";",$abo[8]);
		include (OBJECTSDIR."newsletter/2/file.php");
		$selectarea = ob_get_contents();
		ob_clean();
		
		// stelle individuelle mail zusammen
		foreach($letter as $part) {
			// select area
			if (isset($part['s'])) {
				$htmlcontent .= $selectarea;
			
			// interesst-bereich
			} elseif(isset($part['ismp'])) {
				if(in_array($part['mp'], $mps)) {
					$htmlcontent .= $part['html'];
				}
			} else {
				$htmlcontent .= $part['html'];
			}
		}
		
		// fuege bereiche zusammen
		$thisletter = $mailhead;
		// $thisletter .= $textcontent			// auskommentiert weil fehlerhaft
		$thisletter .= $htmlpart;
		$thisletter .= $htmlcontent;
		$thisletter .= $mailend;
		$htmlcontent = '';
		
		// parse mail-tags
		$searches  = array(
			0 => '/#anrede#/',
			1 => '/#titel#/',
			2 => '/#vorname#/',
			3 => '/#nachname#/',
			4 => '/#name#/',
			18 => '/#firma#/',
			5 => '/#email#/',
			6 => '/#aboid#/',
			7 => '/#---#/',
			8 => '/#nlid#/',
			9 => '/#publish#/',
			10 => '/<\/html>/',
			11 => '/a href="{0}[^#]/',
			12 => '/<link href="\//',
			13 => '/<aboid>/',
			14 => '/<email>/',
			15 => '/#HOST#/',
			16 => '/#urlemail#/',
			17 => '/#altlink#/',
		);
		
		$replaces = array(
			0 => $abo[1],
			1 => $abo[2],
			2 => $abo[4],
			3 => $abo[5],
			4 => $abo[1].' '.$abo[2].' '.$abo[4].' '.$abo[5],
			18 => $abo[7], 
			5 => $abo[6],
			6 => $abo[0],
			7 => '----------------',
			8 => $nlid,
			9 => $issue['pb_id'],
			10 => '<img src="'.HOST."/nl.php?nlid=".$issue['pb_id']."&ref=".($abo[0]*1234).'" /></html>',
			11 => 'a href="'.HOST."/nl.php?nlid=".$issue['pb_id']."&url=",
			12 => '<link href="'.HOST.'/',
			13 => $abo[0],
			14 => $abo[6],
			15 => HOST,
			16 => urlencode($abo[6]),
			17 => HOST.LIQUIDO."/components/newsletter/publish/display.php?pbid=".$issue['pb_id']."&aboid=".($abo[0]*1234),
		);
		
		$thisletter = preg_replace($searches,$replaces,$thisletter);		
		
		// versende das gute stueck
		mail($abo[6],$subject,'',$thisletter);

		$num++;
		ob_end_clean();
	}
	
	$st = explode(' ', microtime());
	$sendtime = $st[0] + $st[1];

	// schreibe Anzahl versendeter Newsletter ins publish
	$db->execute("update `".$cfg['tables']['nlpublishs']."` set `pb_sent_total` = '$num' where `pb_id` = '$issue[pb_id]' LIMIT 1");	
	$db->execute("update `".$cfg['tables']['contents']."`set `status`= '4' where id = '$nlid' LIMIT 1");
	
	$message = "
	Sendereport:
	
	Der Newsletter \"$subject\" wurde erfolgreich versendet.
	
	Anzahl versendete Newsletter: $num
	Dauer der Erstellung der Mail: ".number_format($parsetime-$starttime,2,",",".")." Sekunden
	Dauer des Versende-Vorgangs: ".number_format($sendtime-$parsetime,2,",",".")." Sekunden
	
	";
	
	mail($user['mail'].', bosselmann@gmail.com',"Liquido Sendereport", $message, "", "-f ".$cfg['components']['newsletter']['returnpath']);
}

ob_end_clean();

?>
