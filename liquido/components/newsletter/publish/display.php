<?php

$noinit = 1;
global $ispublishing;
$ispublishing = true;
$path = "../";

//ob_start();

$issue = intval($_GET['pbid']);
$aboid = intval($_GET['aboid']);

chdir(dirname(__FILE__));
ini_set("include_path", ".:./:../");

require ($_SERVER['DOCUMENT_ROOT']."/liquido/lib/init.php");
require (dirname(__FILE__)."/functions.inc.php");
require (dirname(dirname(__FILE__))."/functions.inc.php");

$issue = $db->getRow("select * from `".db_table('nl_publishs')."` where `pb_id` = '$issue' LIMIT 1");
if(!$issue['pb_id']) die("issue not found");

// define some shortcuts
$user['id'] = $issue['user_id'];
$groups = $issue['pb_groups'];
$thiscomp['id'] = $issue['pb_issue'];
$nlid = $issue['pb_issue'];
$pbid = $issue['pb_id'];
$publishing = true;
$abotable = $cfg['tables']['nlabos'];

$start = explode(' ', microtime());
$starttime = $start[1] + $start[0];

// get User
$aboid /= 1234;
$user = $db->con->getRow('select * from '.db_table('editors').' where `id` = '.$user['id'].' LIMIT 1');
$sq_abo = "select * from `$abotable` where id=$aboid LIMIT 1";
$abo = $db->getRow($sq_abo);
if(!$abo['id']) die("wrong parameter aboid");

$nl = $db->getRow("select * from ".db_table("nl_publishs")." where pb_id = ".intval($pbid)." LIMIT 1");
if(!$nl['pb_id']) die("wrong parameter");



// zerlege mp-komibantion in array
global $mps;
$mps = explode(";",$abo[7]);

$parser = new Parser();
$node= new Node($nl['pb_issue']);
$node->publishing = true;
$node->compose = false;
$node->s = array();
$node->mp = array();
$node->mps = $mps;
$node->listobjects();
	
$nlobj = getdata($nl['pb_issue']);


// hole template
if($node->template) {
	$template = getTemplate($node->template);
}

$objects = array_merge(array(array('html' => $template[0])), $node->objects);
$objects[] = array('html' => $template[1]);

$parser = new Parser();
foreach($objects as $k => $o) {
	$parser->html = $o['html'];
	$objects[$k]['html'] = $parser->parse();
} 


ob_start();
// lade bereichs-auswahl
include (OBJECTSDIR."newsletter/2/file.php");
$selectarea = ob_get_contents();
ob_end_clean();

$htmlcontent = "";
// stelle individuelle mail zusammen
foreach($objects as $part) {
	// select area
	if (isset($part['s'])) {
		$htmlcontent .= $selectarea;
		
	// interesst-bereich
	} elseif(isset($part['mp']) && in_array($part['mp'], $mps)) {
		$htmlcontent .= $part['html'];
		
	} else {
		$htmlcontent .= $part['html'];
	}
}

// parse mail-tags
$searches  = array(
	0 => '#anrede#',
	1 => '#titel#',
	2 => '#vorname#',
	3 => '#nachname#',
	4 => '#name#',
	5 => '#email#',
	6 => '#aboid#',
	7 => '#---#',
	8 => '#nlid#',
	9 => '#publish#',
	10 => '</html>',
	11 => 'a href="',
	12 => '<link href="/',
	13 => '<aboid>',
	14 => '<email>',
	15 => '#HOST#',
	16 => '#urlemail#'
);

$replaces = array(
	0 => $abo[1],
	1 => $abo[2],
	2 => $abo[4],
	3 => $abo[5],
	4 => $abo[1].' '.$abo[2].' '.$abo[4].' '.$abo[5],
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
	16 => urlencode($abo[6])
);
		

$letter = str_replace($searches, $replaces, $htmlcontent);
	
echo $letter;

 ?>
