<?php

if(isset($_POST['logout'])) {
	session_start();
	$sid = session_id();
	mysql_query("update $cfgtablesessions set status = '1' where sessid = '$sid' LIMIT 1");
	if($memo = addslashes($_GET['memo'])) mysql_query("update $cfgtableeditors set memo = '".$memo."' where id = '$user[id]'");
	unset($_SESSION);
	$_SESSION = "";
	session_destroy();
	
	$location = $REQUEST_URI;
	header("Location:/liquido/login.php?l=$location");
}

if(isset($_POST['login'])) {
	$login = $_POST['login'];
	$setlogin = mysql_escape_string($login['user']);
	$setpass = mysql_escape_string($login['pass']);

	// deaktiviere alle abgelaufenen sessions
	//$killtime = time() - $cfg['auth']['SessionLifetime'];
	//mysql_query("update $cfgtablesessions set status = '1' where timestamp < '$killtime'");

	$sql = "SELECT 	a.id, a.status, a.name, a.mail, a.lang, a.memo, a.egroup, 
					b.name as groupname, b.status as groupstatus, b.id as groupid, b.leader as groupleader, b.leadermail as groupleadermail 
			FROM 	$cfgtableeditors as a,
					$cfgtableeditorgroups as b
			WHERE	a.login = '$setlogin' and a.pass = '$setpass' and a.egroup = b.id  
			LIMIT 	1";
			
	$user = db_entry($sql);

	if($user['id']) {
		if($user['status'] and $user['groupstatus']) {

			$time = time();
			$browser = $_SERVER['HTTP_USER_AGENT'];
			
			$_SESSION['user'] = $user;
			//$_SESSION['cfg'](cfg);
			$sid = session_id();
			
			// schreibe session in db
			//$sql = "insert into $cfgtablesessions (sessid, editor, browser, timestamp) values ('$sid', '$user[id]', '$browser', '$time')";
			//db_query($sql);
		} else {
			$loginerror = "Dieser Zugang ist gesperrt";
		} 
	} else {  
		$loginerror = "Benutzerkonto nicht gefunden"; 
	}
}

function auth($location=0) {
	include("cfg.php");
	
	$sid = session_id();
	
	global $db;
	
	//$sql = "select editor,timestamp from $cfgtablesessions where sessid = '$sid' and status != '1' limit 1";
	//echo $sql;
	//$check = db_entry($sql);

	// wenn keine gültige session besteht
	//if($check_session and $check_session['editor'] == $user['id']) {
	if(isset($_SESSION['user'])) {
		//$currenttime = time();
		
		/*
		// wenn max lifetime abgelaufen ist (cfg_general.php);
		if($cfgSessionLifetime and ($currenttime - $check_session['timestamp']) > $cfgSessionLifetime) {
			$location = $REQUEST_URI;
			$db->execute("update $cfgtablesessions set status = '1' where sessid = '$sid'");
			
			session_destroy();
			unset($_SESSION);
			//echo "<!-- session abgelaufen -->";
			$location = $REQUEST_URI;
			header("Location:/liquido/login.php?l=$location");
			return false;
			
		} else {
			
			// aktualisiere Zeitstempel
			$db->execute("update $cfgtablesessions set timestamp = '$currenttime' where sessid = '$sid'");
			return true;
		}
		*/
		return true;
	} else {
		//echo "<!-- keine session -->";
		$location = $_SERVER['REQUEST_URI'];
		
		return false;
	}
}

?>