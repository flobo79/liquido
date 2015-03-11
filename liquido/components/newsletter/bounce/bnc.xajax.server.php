<?
require_once('header.inc.php');

function deletemail($id)
{
	$objResponse = new xajaxResponse();
	$db =& $GLOBALS['db'];
	$sql=sprintf("DELETE FROM %semails WHERE id = %u",PREFIX,$id);
	$ok = $db->Execute($sql);
	if($ok)
	{
		$objResponse->addScript("alert('E-Mail wurde geloescht.');");
		$objResponse->addScript("window.setTimeout('opener.location.reload()',1000);");
		$objResponse->addScript("window.setTimeout('window.close()',1000);");
	}
	else
	{
		$objResponse->addScript("alert('Fehler beim Loeschen der E-Mail!');");
	}
	return $objResponse->getXML();
}

function deletesubscriber($email)
{
	$objResponse = new xajaxResponse();
	$db =& $GLOBALS['db'];
	$sql=sprintf("DELETE FROM fs_liquido_nl_abos WHERE email = '%s'",PREFIX,mysql_escape_string($email));
	$ok = $db->Execute($sql);
	if($ok)
	{
		$objResponse->addScript("alert('Abonnent wurde geloescht.');");
		//$objResponse->addScript("window.setTimeout('opener.location.reload()',1000);");
		//$objResponse->addScript("window.setTimeout('window.close()',1000);");
	}
	else
	{
		$objResponse->addScript("alert('Fehler beim Loeschen des Abonnents!');");
	}
	return $objResponse->getXML();
}

require_once("bnc.xajax.common.php");
$xajax->processRequests();
?>
