<?php 

include("../../../lib/init.php");
include("../functions.inc.php");
include("functions.inc.php");


if($publish) publish($publish);
//if($scedule) scedule($scedule);

if ($trash and $trash['id']) {
	movetotrash($trash);
	$thiscomp['id'] = $trash['parent'];
	$_SESSION['components']['newsletter']['id'] = 0;
	$updateleft = true;
	$updatelist = true;
}

if ($edit) {
	$edit['table'] = "contents";
	$edit['id'] = $thiscomp['id'];
	edit($edit);
	
	$updatelist = true;
}

if($rank) {
	$rank['parent'] = $nlobj['id'];
	$rank['type'] = "contents";
	rank($rank);
}

if($thiscomp['id']) {
	$data = getdata($thiscomp['id']);
	
	if($setstatus = $_GET['setstatus']) {
		if($access['c'.$setstatus+4]) setstatus($data['status'] = ($setstatus == $data['status'] ? $setstatus-1 : $setstatus));
		$updatelist = true;
	}
	
	if($data['status'] >= 3) {
		$statbarlength = 320;//320;
		$linkbarlength = 2;//100;
		
		if(is_array($data['publishs'])) {
			foreach($data['publishs'] as $key => $publish) {
				$rel = $publish['pb_sent_total'] ? ceil($statbarlength / $publish['pb_sent_total']) : 1;
				
				$data['publishs'][$key]['bounces']['barlength_bounce'] = round($publish['bounces']['number'] * $rel);
				$data['publishs'][$key]['bounces']['barlength_reads'] = round($publish['pb_reads']*0.3);// * $rel);
				$data['publishs'][$key]['bounces']['barlength_rest'] = $statbarlength - $data['publishs'][$key]['bounces']['barlength_bounce'] - $data['publishs'][$key]['bounces']['barlength_reads'];
				
				if($publish['clickedlinks'][0]['lt_clicks'] != 0) {
					$relclicks = $linkbarlength / $publish['clickedlinks'][0]['lt_clicks'];
					foreach($publish['clickedlinks'] as $keylink => $link) {
						$data['publishs'][$key]['clickedlinks'][$keylink]['barlength'] = $relclicks * $link['lt_clicks'];
					}
				}
			}
		}
		
		$smarty->assign("statbarlength",$statbarlength);
		$smarty->assign("linkbarlength",$linkbarlength);
		$smarty->assign("status_disabled",true);
	}
	
	
	$smarty->assign("templates", $L->getTemplates($data['template'],1));
	$smarty->assign("groups",getgroups());
	$smarty->assign("data", $data);
	$smarty->assign("access",$access);
}

$smarty->assign("updateleft",$updateleft);
$smarty->assign("updatelist",$updatelist);
$smarty->display(dirname(__FILE__)."/templates/details.tpl");

?>
