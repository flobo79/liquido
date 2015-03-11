<?php
	// anzahl pro seite standard
	if(!$y) $y = 50;
	if(!$thispage) $thispage = 1;
	$start = ($thispage-1) * $y;
	
	if($_POST['action'] == "delete") {
		if(is_array($_POST['check'])) {
			foreach($_POST['check'] as $entry) { $where .= "or id='".intval($entry)."'"; }
			$db->execute("delete from".db_table('nl_abos')."where id = '0' $where");
		}
	}

	if(ereg("addgroup",$_POST['action'])) {
		$addgroup = substr($_POST['action'],-1);
		foreach($_POST['check'] as $id) {
		
			$row = $db-> getRow("select `group` from ".db_table('nl_abos')." where id = '$id' LIMIT 1"); echo mysql_error();
			if(!ereg(";$addgroup;",$row['group'])) {
				$db->execute("update  ".db_table('nl_abos')." set `group` = '".$row['group'].$addgroup.";' where `id` = '$id' LIMIT 1");
			}
		}
	}

	if(($search = $_REQUEST['search'])) {
		$search = utf8_encode($search);
		$i = 0;
		$result = $db->execute("SELECT * FROM ".db_table('nl_abos')." LIMIT 1");
		$fields = $result->fields;
		foreach($fields as $key => $value) {
			if(is_string($key)) {
				$searchfields .= "`$key` LIKE '%".mysql_real_escape_string($search)."%' or ";
			}
		}
		
		$sqladd = "and (".substr($searchfields,0,-4).")";
	}
	
	
	
	if($setgroup) $sql_group = "and `group` LIKE '%;$setgroup;%'";
	
	$sql = "select id,CONCAT(firstname,' ',name) AS Name,email from $cfgtablenlabos where status = '0' $sql_group $sqladd order by name limit $start,$y";
	$list = $db->getArray($sql);
	$groups = getGroups();
	
	$result = $db->execute("SELECT id FROM ".db_table('nl_abos')." where status = '0' $sql_group $sqladd order by id");
	$numrows = $result->RecordCount();	
	
	$baselink = "body.php?page=search.php&setgroup=$setgroup&search=$search&y=$y&thispage=$thispage";
	for($i=1;$i<=ceil($numrows/$y);$i++) $selectpage.= "<a href=\"$baselink&thispage=$i\">$i</a> ";

	$smarty->assign("pagesperview",array(25,50,100,250));
	$smarty->assign("selectpage", $selectpage);
	$smarty->assign("y", $y);
	$smarty->assign("thispage", $thispage);
	$smarty->assign("list", $list);
	$smarty->assign("groups", $groups);
	$smarty->assign('setgroup', $setgroup);
	$smarty->assign('baselink', $baselink);
	$smarty->display(dirname( __FILE__ )."/templates/search.tpl");
	
	?>