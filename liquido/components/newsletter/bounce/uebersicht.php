<?
require_once("header.inc.php");
require_once("libs/EmailParser.php");

$sql = sprintf("SELECT *,DATE_FORMAT(received,'%%d.%%m.%%Y um %%H:%%i:%%s Uhr') AS datum FROM %semails", PREFIX);
$emails = $db->GetAll($sql);
$emailparser=new EmailParser();
foreach($emails as $key=>$dbemail)
{
	$email = $emailparser->parseEmail($dbemail['source']);
	$email->setEmailID($dbemail['id']);
	if($dbemail['filterIDs']=='')
	{
	  $matches = $emailparser->getMatchingFilters($email);
	  if(array_key_exists('ids',$matches) && count($matches['ids']) > 0)
	  {
	    $email->setFilterIDs($matches['ids'],true);
	  }
	  else
	  {
 		  $email->saveToDB();
		}
	}
	else
	{
	  $matches = array('ids'=>array(),'namen'=>array());
		$matches['ids'] = explode(',',$dbemail['filterIDs']);
		$email->setFilterIDs($matches['ids'],false);
	}
	$emails[$key]['from']=$email->header['from'];
	$emails[$key]['adressat']=$email->getToEmail();
	$grund=array();
	foreach($email->getFilterIDs() as $filterID)
	{
    $grund[]=$emailparser->getFilternameById($filterID)."<br />\n";
	}
	$emails[$key]['grund']=implode("<br />\n",$grund);
	//$emails[$key]['datum']=$email->header['date'];
	$emails[$key]['datum']=$dbemail['datum'];
}
$smarty->assign('ruecklaeufer',$emails);

output("uebersicht.tpl");
?>