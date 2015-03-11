<?php

//include("header.inc.php");


function sendMessage() {
	global $booking;
	global $_GET;
	global $user;

	$reciepgroup = 2;		// gruppe an die eine Nachricht versendet wird
	$permail = true;
	$betreff = "Rechnung bezahlt";		
	
	/* alle empfänger */
	$reciever = $booking->sql->DB->GetAssoc("select id,mail from fs_liquido_editors where egroup = '$reciepgroup'");

	foreach($_GET['reserv'] as $f => $v) {
		$sql="SELECT * from `fs_b_reserv` where rs_id = '$v' LIMIT 1";
		//die($sql);
		$reservs[] = $booking->sql->DB->GetRow($sql);
	}
	
	// Nachrichttext erstellen
	$message = "Folgende Reservierungen haben den Rechnungsbetrag bezahlt:\n\n\n";
	
	foreach($reservs as $entry) {
		$message .= "Nr: ".$entry['rs_book_nr'].", Plätze: ".$entry['rs_places']." Name: ".$entry['rs_firstname']." ".$entry['rs_lastname']."\n"."Bemerkung: ".$entry['rs_remark']."\n\n";
	}
	
	$message .= "
	
	mit freundlichen Grüssen,
	
	$user[name]";
	
	$time = time();
	
	// versende nachrichten
	foreach($reciever as $id => $email) {
		
		if($permail && $email != "") {
			$message = "Automatische Benachrichtigung:\n\n\n$user[name] schrieb:\n\n$message\n\n";
			mail($email,$betreff,$message,"from: Liquido (www.vw-fahrsicherheitstraining.de) <$user[email]>");
		}	
		
		$sql = "insert into fs_liquido_messageboard (`message`,`subject`,`reciepient`,`from`,`date`) values ('$message','$betreff','$id','$user[id]','$date')";
		$result = $booking->sql->DB->execute($sql);
	}
}

if($booking) sendMessage();


?>