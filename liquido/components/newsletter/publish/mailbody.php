<?php

switch($mailpart) {
	case "head":

/*
echo "From: \"".$cfg['components']['newsletter']['from_name']."\" <".$cfg['components']['newsletter']['from_mail'].">\n";
//echo "Reply-To: \"".$cfg['components']['newsletter']['from_name']."\" <".$cfg['components']['newsletter']['from_mail'].">\n";
echo "MIME-Version: 1.0\n";
echo "Content-Type: multipart/alternative;\n\tboundary=\"==liquido==\"\n";
echo "Liquido-Newsletter-ID: $nlid\n";
echo "Subscriber-ID: #aboid#\n";
//echo "X-Sender: <".$cfg['components']['newsletter']['returnpath'].">\n"; 
echo "X-Mailer: PHP5\n";
echo "X-Priority: 3\n"; 
echo "Return-Path: ".$cfg['components']['newsletter']['returnpath']."\n";
//echo "Return-Receipt-To: ".$cfg['components']['newsletter']['returnpath']."\n";
*/

echo "From: \"".$cfg['components']['newsletter']['from_name']."\" <".$cfg['components']['newsletter']['from_mail'].">\n";
//echo "Reply-To: \"".$user['name']." <".$user['mail'].">\n";
echo "Reply-To: kontakt@volkswagen-club.de\n";
echo "MIME-Version: 1.0\n";
echo "Content-Type: multipart/alternative;\n\tboundary=\"==liquido==\"\n";

echo "X-Sender: ".$cfg['newsletter']['returnpath'].">\n"; 
echo "X-Priority: 3\n"; 
echo "Return-Path: <".$cfg['newsletter']['returnpath'].">\n";

?>

Diese Nachricht wurde im Mime-Format versendet. Wenn Ihr
E-Mail-Programm dieses Format nicht lesen kann, sind
moeglicherweise einige oder alle Teile dieser Nachricht unlesbar.

<?php echo "\n" ?>
--==liquido==<?php echo "\n" ?>
Content-Type: text/plain; charset="utf-8"<?php echo "\n" ?>
Content-Transfer-Encoding: 8bit<?php echo "\n" ?>

Lieber Newsletter-Abonnent

Sie verwenden vermutlich ein E-Mail-Programm, das die grafische (oder
HTML-) Version dieser E-Mail nicht darstellen kann. Da wir moechten,
dass Sie die E-Mail im korrekten Format lesen können, empfehlen
wir Ihnen, die folgende Web-Seite, auf der die E-Mail
hinterlegt wurde, zu besuchen: #altlink#

<?php break;
	case "htmlpart":
?>
--==liquido==<?php echo "\n" ?>
Content-Type: text/html; charset="utf-8"<?php echo "\n" ?>
Content-Transfer-Encoding: 8bit<?php echo "\n\n" ?>

<?php 
	break;
	case "end":
 ?>
<?php echo "\n" ?>--==liquido==--<?php echo "\n\n" ?> 
<?php break; } ?>