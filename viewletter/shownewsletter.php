<?php 

if(!$_GET['letter_id']) header("location:../");

$letter_id = $_GET['letter_id'];

require_once("../liquido/lib/init.php");

$letter = new Node($letter_id);
$html = $letter->listobjects();


$template =  db_entry("select * from ".db_table("templates")." where id = ".$letter->template." LIMIT 1");
$template = explode("<content>", $template['html']);

// key holen vom abonnenten
if($aboid = $_GET['abo_id']) {
	$abo = mysql_fetch_array(mysql_query("select * from $cfgtablenlabos where id = '$aboid' LIMIT 1"),MYSQL_ASSOC);
	$check = explode(";",$abo['mp']);
}

// keys generieren
if(!$check) $check = array();
while(list($field,$val) = each($check)) {
	if($val) $key[] = $field;
}

$nlobj['keys'] = $key;
//$thisletter =  listobjects($nlobj); 
 
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
);


$letter = $template[0].$html.$template[1];	
$letter = str_replace($searches,$replaces,$letter);
$letter = parseCode($thiscomp['id'],$letter);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Newsletter</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>	
<body>
		<?php echo $letter ?>

</body>
</html>
