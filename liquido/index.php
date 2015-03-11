<?php

error_reporting(E_ALL ^ E_NOTICE);

if(isset($_GET['reset'])) {
	session_start();
	session_destroy();
	unset($_SESSION);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<frameset rows="29,*" frameborder="NO" border="0" framespacing="0">
  <frame src="head.php" name="head" scrolling="NO" noresize >
  <frame src="body.php" name="content">
</frameset>
<noframes><body>

</body></noframes>
</html>
