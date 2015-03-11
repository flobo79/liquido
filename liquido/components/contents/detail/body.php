<?php 




//if($_GET['overview']) $thiscomp['id'] = '';
$obj = $thiscomp['id'] ;
$node = new Node($thiscomp['id']);
$data = $node->data();
$parents = '';
$templatelist = '';
$childlist = '';




ob_start();
	showParents($data); 
	$smarty -> assign("parents", ob_get_contents());
	ob_clean();

	listTemplates ($thistemplate=$data['template']);
	$smarty -> assign("templatelist", ob_get_contents());
	ob_clean();
	
	showchilds($data,"1");
	$smarty -> assign("childlist", ob_get_contents());

ob_end_clean();

$smarty -> assign("update_rightframe",$update_rightframe);
$smarty -> assign("update_leftframe",$update_leftframe);
$smarty -> assign("startpage", get_setting("content","startpage"));
$smarty -> assign("mode",$mode);
$smarty -> assign("current", dirname(__FILE__));
$smarty -> assign("access",$access);
$smarty -> assign("data", $data);
$smarty -> assign("status",getstatus($data['status']));
$smarty -> assign("pageslist", build_dropbox($data));
$smarty -> assign('blocks', $db->getArray("select * from ".db_table('blocks')." order by title"));

if(isset($_POST['range'])) 
	$smarty -> assign("showstat", true);

// load header incl. javascript
$smarty -> display(dirname(__FILE__)."/templates/head.tpl");

if(!isset($obj) or isset($_GET['overview'])) {
	$smarty -> display(dirname(__FILE__)."/templates/overview.tpl");
	
} else {
	//$data = getdata($obj);
	//require($_SERVER['DOCUMENT_ROOT']."/liquido/modules/content_stats/single_page.php");
	$smarty -> display(dirname(__FILE__)."/templates/page.html");
	
}


$smarty -> display(dirname(__FILE__)."/templates/foot.tpl");
?>