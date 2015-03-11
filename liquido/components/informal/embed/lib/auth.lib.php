<?php

function AUTH_fetchUserData($username) {
	// get user information from database
	// use the allow values from the group permissions
	global $cfg;
	$query = "
		SELECT
			a.*,
			b.`allow` as `allow`
		FROM
			`" . $cfg['auth']['usertable'] . "` as a,
			`" . $cfg['auth']['grouptable'] . "` as b
		WHERE
			`username` = '" . $username . "'
			AND
			a.`group` = b.`id`
		LIMIT 1
		";
	$user = MY_dbArray($query);
	return $user[0];
}

function AUTH_logIn($user) {
	$_SESSION['logged_in'] = true;
	$_SESSION['databases'] = $user['databases'];
	$_SESSION['group'] = $user['group'];
	$_SESSION['allow'] = $user['allow'];
	$_SESSION['username'] = $user['username'];
}

function AUTH_logOut($user) {
	$_SESSION = array();
}

function AUTH_isLoggedIn() {
	if ($_SESSION['logged_in']) return true;
}

?>
