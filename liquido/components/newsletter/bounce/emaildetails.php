<?
require_once("header.inc.php");
require_once("libs/EmailParser.php");

if($_GET['emailid'])
{
	$sql = sprintf("SELECT * FROM %semails WHERE id = %u",PREFIX,$_GET['emailid']);
	$dbemail = $db->con->getRow($sql);
	$emailparser=new EmailParser();
	$email = $emailparser->parseEmail($dbemail['source']);
	$email->setEmailID($dbemail['id']);
	$email->setFilterIDs(explode(',',$dbemail['filterIDs']),false);
	$dbemail['from']=$email->header['from'];
	$dbemail['to']=$email->header['to'];
	$dbemail['adressat']=$email->getToEmail();
	$grund=array();
	foreach($email->getFilterIDs() as $filterID)
	{
    $grund[]=$emailparser->getFilternameById($filterID);
	}
	$dbemail['grund']=implode(", ",$grund);
	$dbemail['datum']=$email->header['date'];
	$dbemail['betreff']=$email->header['subject'];

	$smarty->assign($dbemail);
	$smarty->assign('xajax_javascript', $xajax->getJavascript());
	$smarty->assign('body',implode("\n\n",$email->body));
}
output("emaildetails.tpl");
?>