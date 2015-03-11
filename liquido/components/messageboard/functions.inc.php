<?php

if(isset($_GET['type'])) {
	$_SESSION['components'][$comp]['type'] = $type;
	$updateBody = true;
}

if($setmode = isset($_GET['setmode'])) {
	if($_GET['action'] == "new") unset($_SESSION['components'][$comp]['action']);
	$updateBody = true;
}

if(isset($_POST['send']['submit']) and isset($_POST['send']['reciepient'])) {
	if($sendresult = sendMessage($send)) {
		unset($send);
		unset($_SESSION['components'][$comp]['message'],$_SESSION['components'][$comp]['current']);
	}
}

function getMessageInfo() {
	//include("../../lib/cfg.php");
	global $user;
	global $dbprefix;
	
	$table = $dbprefix."_liquido_messageboard";

	//$return['inbox'] 	= mysql_num_rows(mysql_query("select id from $table where reciepient = '$user[id]'"));
	$return['unread'] 	= mysql_num_rows(mysql_query("select id from $table where reciepient = '$user[id]' and `read` = '0'"));
	//$return['outbox'] 	= mysql_num_rows(mysql_query("select id from $table where `from` = '$user[id]'"));
	return $return;
}

function listMessages($type) {
	global $user;
	global $dbprefix;

	//OpenDatabase();

	$table = $dbprefix."_liquido_messageboard";
		
	$where = $type == "in" ? "`reciepient` = '$user[id]'" : "`from` = '$user[id]'";
	$sql = "select id,subject,`read` from ".$table." where $where order by date desc";

	
	$q = mysql_query($sql);
	while ($entry = mysql_fetch_row($q)) {
		$title = ($type == "in" and !$entry[2]) ? "<b>".$entry[1]."</b>" : $entry[1];
		if ($type == "in" and !$entry[2]) $linkadd = "&read=1"; 
		echo "<a href=\"list.php?selMessage=$entry[0]$linkadd\">$title</a><br>\n";
	}
	if(!$title) echo "keine Nachrichten vorhanden";
}


function getMessage($id) {
##
	global $user;
	global $dbprefix;
	
	$table = $dbprefix."_liquido_messageboard";
	$usertable = $dbprefix."_liquido_editors";

	$message = mysql_fetch_array(mysql_query("select * from $table where id = '$id' LIMIT 1"));
	$getFromName = mysql_fetch_array(mysql_query("select name as fromname from $usertable where id = '$message[from]' LIMIT 1"));
	$getToNamee = mysql_fetch_array(mysql_query("select name as toname from $usertable where id = '$message[reciepient]' LIMIT 1"));
	$message['fromname'] = $getFromName[0];
	$message['toname'] = $getToName[0];
	
	return $message;
}

function readMessage ($id) {
##
	global $user;
	global $dbprefix;
	
	$table = $dbprefix."_liquido_messageboard";
	$time = time();
	
	mysql_query("update $table set `read`=$time where id = '$id' LIMIT 1");
	
}



function listUser ($current=0) {
##
	include("../../lib/cfg.php");
	
	global $user;
	
	$sql = "select id,name from $cfgtableeditors order by name";
	$q = mysql_query($sql);
	while ($entry = mysql_fetch_row($q)) {
		$add = $entry[0] == $current ? " selected" : "";
		echo "<option value=\"$entry[0]\"$add>$entry[1]</option>\n";
	}
}


function sendMessage($data) {

	global $user;
	global $dbprefix;
	
	$time = time();
	
	$table = $dbprefix."_liquido_messageboard";
	
	if($data['permail']) {
		
		$toUser = mysql_fetch_row(mysql_query("select mail from ".$dbprefix."_liquido_editors where id = '$data[reciepient]' LIMIT 1"));
		
		$message = "Ihnen wurde eine Mitteilung über das Liquido Messaging-System zustestellt:\n\n\n$user[name] schrieb:\n\n$data[message]\n\n";
			
		mail($toUser[0],$data['subject'],$message,"from: www.vw-club.de liquido <>");
	}	
	
	$sql = "insert into $table (`message`,`subject`,`reciepient`,`from`,`date`) values ('$data[message]','$data[subject]','$data[reciepient]','$user[id]','$date')";
	$result = mysql_query($sql);
	
	return $result;
	
}


function delMessage ($id) {
	if($id) {
		global $user;
		global $dbprefix;
		$table = $dbprefix."_liquido_messageboard";
		
		mysql_query("delete from $table where id = '$id' LIMIT 1");
	}
}


?>