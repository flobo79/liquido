<?php

if($login = $_POST['login']) {}
if($login = $_GET['login']) {}

if($_SESSION['user']) {
	header("location:index.php");
} else {
	if($login) {
		include("cfg_mysql.inc.php");
		$setlogin = $login['user'];
		$setpass = $login['pass'];
	
		// deaktiviere alle abgelaufenen sessions
		$killtime = time() - $cfgSessionLifetime;
		mysql_query("update $cfgtablesessions set status = '1' where timestamp < 'killtime'");
	
		$sql = "SELECT 	a.id, a.status, a.name, a.mail, a.lang, a.memo, a.egroup, 
						b.name as groupname, b.status as groupstatus, b.id as groupid, b.leader as groupleader, b.leadermail as groupleadermail 
				FROM 	$cfgtableeditors as a,
						$cfgtableeditorgroups as b
				WHERE	a.login = '$setlogin' and a.pass = '$setpass' and a.egroup = b.id  
				LIMIT 	1";
	
		$user = mysql_fetch_array(mysql_query($sql),MYSQL_ASSOC);
							
		if($user['id']) {
			if($user['status'] and $user['groupstatus']) {
	
				$time = time();
				$browser = $HTTP_USER_AGENT;
				
				session_start();
				$_SESSION['user'] = $user;
				$sid = session_id();
				// schreibe session in db
				$sql = "insert into $cfgtablesessions (sessid, editor, browser, timestamp) values ('$sid', '$user[id]', '$browser', '$time')";
				mysql_query($sql);
				
				header("location:index.php");
			} else {
				header("location:http://www.vw-club.de/login/index.php?err=locked");
				//echo "Dieser Zugang ist gesperrt";
			}
		} else {
			header("location:http://www.vw-club.de/login/index.php?err=nouserfound");
			//echo "Dieser Zugang ist gesperrt";
		}
	}
}

?>