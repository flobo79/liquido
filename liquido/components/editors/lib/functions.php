<?php

// load accesstable
include("../../lib/init.php");

// globals 
foreach($_GET as $K => $V) { $$K = $V;}
foreach($_POST as $K => $V) { $$K = $V; }
unset($K,$V);	
	
$access = loadAccessTable($user,"editors");

if($new_group and $access['c1']) 		new_group($new_group);
if($deletegroup and $access['c3'])		deletegroup($group,$togroup);
if($new_user and $access['c4']) 		new_user($new_user,$group);
if($edituser and $access['c5']) 		edituser($edituser);
if($deleteuser and $access['c6'])		deleteuser($editor,$group);
if($changestatus and $access['c8'])		changestatus($changestatus);
if($sendaccess and $access['c11'])		$part = sendaccess($id,$group);
if($r) updateRights($r,$_POST['comp'],$group,$fields);

function dropbox_groups ($name,$current=0) {
############################################
	include("../../lib/cfg.php");	

	$sql = "select name,id from $cfgtableeditorgroups order by name";
	$q = mysql_query($sql);
	$current = unmask_id($current);
	
	echo "<select name=\"$name\" class=\"text\">
		<option value=\"\">alle Benutzer löschen</option>\n";
	
	while($result = mysql_fetch_array($q) and $result['id'] != $current) {
		$selected = ($result['id'] == $current) ? "selected" : "";
		$id = mask_id($result['id']);
		echo "<option value=\"$id\" $selected>".$result['name']."</option>\n";
	}
	echo "</select>";
}



function deleteuser($editor,$group) {
############################################
	include("../../lib/cfg.php");	
	
	$id = unmask_id($editor);
	
	$sql = "delete from $cfgtableeditors where id = '$id' LIMIT 1";
	mysql_query($sql);
	
	header("Location:detail_group.php?group=$group&updatebottom=1");
}



function deletegroup($group,$togroup=0) {
############################################
	include("../../lib/cfg.php");
	
	$group = unmask_id($group);
	if ($togroup) $togroup = unmask_id($togroup);
	
	
	$sql = $togroup ? "update $cfgtableeditors set egroup = '$togroup' where egroup = '$group'" : "delete from $cfgtableeditors where egroup = '$group' LIMIT 1";
	mysql_query($sql);
	
	$sql_r_tables = "SELECT * FROM $cfgtablecomponents";
	$r_q = mysql_query($sql_r_tables);
	while ($r_result = mysql_fetch_array($r_q)) {
		$r_tables .= $dbprefix."_liquido_r_".$r_result['dest'].", ";
	}
	$r_tables = substr($r_tables,0,strlen($r_tables)-2);

	$sql = "delete from $r_tables where egroup='$group'";
	mysql_query($sql);

	$sql = "delete from $cfgtableeditorgroups where id = '$group' LIMIT 1";
	mysql_query($sql);
	
	header("Location:top.php?updatebottom=1");
}


function changestatus ($data) {
################################
	include("../../lib/cfg.php");
	
	$id = $data['editor'] ? unmask_id($data['editor']) : unmask_id($data['group']);
	$table = $data['editor'] ? $cfgtableeditors : $cfgtableeditorgroups;
	$sql = "update $table set status = '$data[status]' where id = '$id' LIMIT 1";
 
	mysql_query($sql);
	
	header("Location:?group=$data[group]&id=$data[editor]");
}



function edituser($data) {
###############################
	include("../../lib/cfg.php");
	
	$id = unmask_id($data['id']);
	$group = unmask_id($data['egroup']);
	
	$sql = "update $cfgtableeditors set name='$data[name]', titel='$data[titel]', department='$data[department]', login = '$data[login]', pass='$data[pass]', egroup='$group', mail='$data[mail]', phone='$data[phone]', status='$data[status]', ldap='$data[ldpap]' where id = '$id' LIMIT 1";
	mysql_query($sql);
	
	header("Location:?id=$data[id]&updatebottom=1");
}



function list_groups($current) {
#################################
	include("../../lib/cfg.php");
	
	global $access;
	
	$sql = "select name,id from $cfgtableeditorgroups order by name";
	$q = mysql_query($sql);
	while($result = mysql_fetch_array($q)) {
		$id = mask_id($result['id']);
		include("list_group.php");
	}
}




function list_users($current,$group) {
####################################
	include("../../lib/cfg.php");
	
	$group = unmask_id($group);
	
	$sql = "select * from $cfgtableeditors where egroup = '$group' order by name"; //echo $sql;
	$q = mysql_query($sql);
	while($result = mysql_fetch_array($q)) {
		$id = mask_id($result['id']);
		
		$curr = $current == $id ? 1 : 0;
		include("list_user.php");	

	}
}



function userData($group,$user=0) {
###################################
	include("../../lib/cfg.php");	
	
	$group = unmask_id($group);
	
	if($user) {
		$user = unmask_id($user);
		$sql = "select 	a.name as username, a.login, a.pass, a.timestamp, a.status, a.mail, a.ldap, a.department, a.titel, a.phone, a.egroup, 
						b.name 
				from 	$cfgtableeditors as a, 
						$cfgtableeditorgroups as b 
				where 	a.id = '$user' and b.id = a.egroup LIMIT 1";
	} else {
		$sql = "select * from $cfgtableeditorgroups where id = '$group' LIMIT 1";
	}
	
	$q = mysql_fetch_array(mysql_query($sql));
	$q['egroup'] = mask_id($q['egroup']);
	return $q;
}


function sendaccess($editor,$group) {
###############################################
	include("../../lib/cfg.php");
	$details = userData($group,$editor);
	
	global $user;
	
	ob_start();
		include("lib/sendaccess.php");
		$mail = ob_get_contents();
	ob_end_clean();
	
	mail($details['mail'],"Zugangsdaten ".$cfg['env']['projecttitle']."-Liquido","",$mail);
	return "sendok";
}


function listGroups($name,$clause=0,$current) {
###################################################
	include("../../lib/cfg.php");
	
	echo "<select name=\"$name\" class=\"text\">
	 	";			
    $current = unmask_id($current);
		
	$sql = "select * from $cfgtableeditorgroups $clause"; //echo $sql;
	$q = mysql_query($sql);
	while($result = mysql_fetch_array($q)) {
		$id = mask_id($result['id']);
		$add = $current == $result['id'] ? "selected" : "";
		echo "<option value=\"$id\" $add>$result[name]</option>
		";
	}
	echo " </select>";

}


function new_user($newuser,$group) {
#####################################################
	include("../../lib/cfg.php");
	
	$groupx = unmask_id($group);
	$time = time();
	
	$sql = "INSERT INTO $cfgtableeditors (name,egroup,timestamp,lang) VALUES ('$newuser','$groupx','$time','de_DE')";
	mysql_query($sql);
	$mysqlid = mysql_insert_id();
	$id = mask_id($mysqlid);
	header("Location:?group=$group&id=$id&updatetop=2");
}



function new_group($newgroup) {
#####################################################
	include("../../lib/cfg.php");
	
	$sql = "INSERT INTO $cfgtableeditorgroups (name) VALUES ('$newgroup')";
	mysql_query($sql);
	
	$id = mysql_insert_id();
	
	$sql_r_tables = "SELECT * FROM $cfgtablecomponents";
	$r_q = mysql_query($sql_r_tables);
	
	while ($r_result = mysql_fetch_array($r_q)) {
		mysql_query("insert into ".$dbprefix."_liquido_r_".$r_result['dest']." (egroup) values ('$id')");
	}
	
	$id = mask_id($id);
	header("Location:?group=$id&updatetop=1");
}




function listAreas($id) {
###################################################
	include("../../lib/cfg.php");
	global $L;
	global $user;
	
	$idx = unmask_id($id);
	
	$sql = "select * from ".$L->table_components." order by dest";
	$list = $L->db_array($sql);

	foreach ($list as $result) {
		$table = $dbprefix."_liquido_r_".$result['dest'];
		$sql_keys = "select * from $table where egroup = '$idx'";
		//echo $sql_keys;
		/*
		$q_keys = mysql_query($sql_keys);
		$result_keys = mysql_fetch_array($q_keys);
		*/
		include("../../components/".$result['dest']."/lang.inc.php");
		echo "<a href=\"#\" onClick=\"window.open('edit_rights.php?id=$id&component=".$result['dest']."','rights','width=300,height=500'); return false\"  onMouseUp=\"document.window('rights').focus(); return false\">".$lng[$user['lang']]['titel']."</a><br>";
	}
}




function listRights($id,$comp) {
###################################################
	include("../../lib/cfg.php");
	
	global $user;
	
	$id = unmask_id($id);
	
	$table = $dbprefix."_liquido_r_".$comp;
	$sql_keys = "select * from $table where egroup = '$id'";
	$q_keys = mysql_query($sql_keys);
	$result_keys = mysql_fetch_array($q_keys);
	$fields = mysql_num_fields($q_keys);
	
	include("../../components/$comp/lang.inc.php");
		
	$checked = $result_keys['access'] ? "checked" : "";
	echo "<br><input name=\"r[access]\" type=\"checkbox\" onClick=\"form1.submit()\" value=\"1\" $checked><span class=\"headline\"> ".$lng[$user['lang']]['titel']."</span><br>
	";
	

	for($i=1;$i<=($fields-3);$i++) {
		$checked = $result_keys["c".$i] ? "checked" : "";
		echo "&nbsp;<input name=\"r[".$i."]\" type=\"checkbox\" onClick=\"form1.submit()\" value=\"1\" $checked> ".$lng[$user['lang']]["c".($i)]."<br>
		";
	}

	echo "<input name=\"fields\" type=\"hidden\" value=\"".($fields-3)."\">";
}



function updateRights($r,$comp,$group,$fields) {
############################################

	include("../../lib/cfg.php");

	$table = $dbprefix."_liquido_r_".$comp;
	$sql = "update $table set access = '$r[access]', ";

	for($i=1;$i <= $fields;$i++) {
		$sql .= "c$i = '".$r[$i]."', ";
	}
	
	$sql = substr($sql,0,strlen($sql)-2);
	$sql .= " where egroup = '".unmask_id($group)."' LIMIT 1";
	mysql_query($sql);
}


?>