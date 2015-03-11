<?php switch($mailpart) {
	case "head":
// email header für nresletter-generation
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
Content-Type: text/plain; charset="iso-8859-1"<?php echo "\n" ?>
Content-Transfer-Encoding: 8bit<?php echo "\n" ?>

Lieber Newsletter-Abonnent

Sie verwenden vermutlich ein E-Mail-Programm, das die grafische (oder
HTML-) Version unserer E-Mail nicht darstellen kann. Da wir moechten,
dass Sie die E-Mail im korrekten Format lesen können, empfehlen
wir Ihnen, die folgende Web-Seite, auf der die E-Mail
hinterlegt wurde, zu besuchen: <?php echo $cfghost.$cfgroot."newsletter.php?a=abo_id&issue=".$letterid."&c=".$client['key'] ?>

<?php break;
	case "htmlpart":
?>
--==liquido==<?php echo "\n" ?>
Content-Type: text/html; charset="iso-8859-1"<?php echo "\n" ?>
Content-Transfer-Encoding: 8bit<?php echo "\n\n" ?>

<?php 
	break;
	case "end":
 ?>
<?php echo "\n" ?>--==liquido==--<?php echo "\n\n" ?> 
<?php break; } ?>
