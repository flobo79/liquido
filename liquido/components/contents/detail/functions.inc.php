<?php

 /*__/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/      c by media5k 2003 | info@media5k.de
/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/
 __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __/ __*/


// 
function loadBlock ($o) {
	global $db;
	$block = new Block($o['id']);
	echo json_encode($block->data());
}

if(intval($_POST['publish']['id'])) publish($_POST['publish']);

if (array_key_exists('trash',$_POST)) {
	$trash = $_POST['trash'];
	movetotrash($trash);
	$select['id'] = intval($trash['parent']);
	$obj['id'] = intval($trash['parent']);
	
	$_SESSION['components'][$comp]['id'] = $trash['parent'];
	$thiscomp['id'] = $trash['parent'];
	
	$update_leftframe = true;
}

if(isset($_POST['insert'])) $insert = $_POST['insert'];
if($insert) {
	$lastid =  insert($insert);
	$obj['id'] = $lastid;

	db_query("insert into `".db_table("contents_cache")."` (`page`) values ('$lastid')");
	
	session_register(obj);
	$update_leftframe = true;
}

// checkt ob eine clean URL existiert
function checkSyslink($obj) {
	$sql = "select id, title from ".db_table('contents')." where 
		(`cleanURL` = '".mysql_real_escape_string($obj['syslink'])."')
		and id != ".intval($obj['id'])."  
		order by id
		";
	
	$list = db_array($sql);
	
	if(count($list)) {
		echo json_encode($list);
	}
}


function blockNodesUpdateOrder($obj) {
	if(intval($obj['id'])) {
		$block = new Block($obj['id']);
		$block->updateNodeOrder($obj['order']);
	}
}

function blockAddNode($obj) {
	if(intval($obj['id'])) {
		$block = new Block($obj['id']);
		$block->addNode($obj['node']);
	}
}

function blockRemoveNode($obj) {
	if(intval($obj['id'])) {
		$block = new Block($obj['id']);
		$block->removeNode($obj['node']);
	}
}


function listTemplates($current=0) {
	echo "<select name=\"template\" class=\"text\">\n
		<option value=\"0\">keine Vorlage ausgewählt</option>\n";
	$cfgtabletemplates = db_table('templates');
	
	foreach (db_array("select * from $cfgtabletemplates where status != '0' order by title") as $result) {
		$selected = $current == $result['id'] ? " selected" : "";
		echo "<option value=\"$result[id]\" $selected>$result[title]</option>";
	}
	echo "</select>\n";
}


function get_dropbox ($data,$nr) {
##################################
	$nr++;
	
	$marker = ".";
	for($i=2; $i <= $nr;$i++) {
		$space = $space.$marker;
	}
	
	$result = list_child($data);
	
	if(is_array($result)) { 
		foreach($result as $field => $newdata) {
			
			if($newdata['id'] != $data['currentid']) {
				$selected = $newdata[id] == $data[pageparent] ? " selected" : "";
				$id = ($newdata['id'] == $data[currentid] ? $data[pageparent] : $newdata[id]);
				
				echo "<option value=\"$id\" $selected>$space$newdata[title]</option>\n";
	
				$newdata['parent'] = $newdata[id];
				$newdata['currentid'] = $data[currentid];
				$newdata['pageparent'] = $data[pageparent];
				
				 get_dropbox($newdata,$nr);
				
				if($nr == "1") echo "<option> </option>\n";
			}
		}
	}
}


function build_dropbox($data, $show=0) {
#############################
	include("../../lib/cfg.php");
	
	$list = "<select name=\"parent\" class=\"text\" lang=\"de\">\n";

		$selected = !$data['parent'] ? "selected" : "";
		$list .= "<option value=\"\" $selected></option>\n";
		
		$parents = db_array($sql = "select id,title,type,parent from $cfgtablecontents where del != '1' and type = 'page' order by type, title");
		
		foreach($parents as $result) {
			$add = $result['type'] == "group" ? "- " : "";
			$title = $result['title'];
			$title .= ' - (id: '.$result['id'].") ";
			
			$selected = $data['parent'] == $result['id'] ? "selected" : "";
			$list .= "<option value=\"$result[id]\" class=\"$class\" $selected>$add $title</option>\n";
		}

		$list .= "</select>\n\n"; 
		
		if($show) echo $list;
		return $list;
}

function scedule($data)
###############################################
{
	include("../../lib/cfg_mysql.inc.php");
	$ConID = OpenDatabase ();

	if ($data['publish']) {
		$svSQLpub = "insert into $cfgtablesceduler (page, type, date) values ('$data[id]','1','$data[publish]')";
		$svdel = "delete from $cfgtablesceduler where page = '$data[id]' and type = '1'";
		$delete = db_query($svSQLdel);
		$insert = db_query($svSQLpub);
	} else {
		$svdel = "delete from $cfgtablesceduler where page = '$data[id]' and type = '1'";
		$delete = db_query($svSQLdel);
	}

	if ($data['unpublish']) {
		$svSQLunpub = "insert into $cfgtablesceduler (page, type, date) values ('$data[id]','0','$data[unpublish]')";
		$svdel = "delete from $cfgtablesceduler where child_id = '$data[page]' and type = '0'";
		$delete = db_query($svSQLdel);
		$insert = db_query($svSQLunpub);
	} else {
		$svdelx = "delete from $cfgtablesceduler where page = '$data[id]' and type = '0'";
		$delete = db_query($svSQLdelx);
	}

	if(!$data['publish'] and !$data['unpublish']) {
		$svSQLupd = "update $cfgtablecontents set status='0' where id = '$data[id]'";
	} else {
		$svSQLupd = "update $cfgtablecontents set status='2' where id = '$data[id]'";
	}
	$update = db_query($svSQLupd);
}

function update($obj) {
	global $thiscomp;
	global $fe;
	global $data;
	
	$obj['table'] = 'contents';
	$obj['id'] = $thiscomp['id'];
	if(!$obj['cleanURL']) $obj['cleanURL'] = "";
	$obj['promoteAsRSS'] = $obj['promoteAsRSS'] ? time() : 0;
	
	edit($obj);
	
	if(isset($obj['setstartpage']) &&  $obj['setstartpage']) set_setting("content","startpage", $obj['id']);
	db_query("update ".db_table("contents_cache")." set refresh = '".($_POST['nocache'] == "1" ? "-1" : "6")."' where page ='$thiscomp[id]' LIMIT 1");

	if($obj['parent'] != $data['parent']) echo "reload";
}

function updateOrder($obj) {
	global $thiscomp;
	$objects = explode(',',$obj['order']);
	$page = $thiscomp['id'];
	
	$t = db_table("contents");
	$rank = 1;
	
	foreach($objects as $id) {
		$sql = "update `$t` set `rank` = '".$rank++."' where `id` = ".floor($id)." LIMIT 1";
		db_query($sql);
	}
}


function publish($data)
#########################################
{

	//include("../../lib/init.php");

	$svSQLupd = "update ".db_table("contents")." set status='$data[set]' where id = '$data[id]'"; //echo $svSQLupd;
	$update = db_query($svSQLupd);

	//$svSQLdel = "delete from ".db_table("sceduler")." where page = '$data[id]'";
	//$delete = db_query($svSQLdel);

	if($data['allsubpages'] == "ok") publish_subpages($data);
}



function publish_subpages($data) 
#########################################
{
	$q = "select * from ".db_table("contents")." where parent = '$data[id]'";
	$childs = db_array($q);
	$data['allsubpages'] == "ok";
	
	foreach($childs as $result) {
		$data['id'] = $result['id'];
		publish($data);
	}
}


?>