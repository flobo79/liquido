<?php 
include("../../lib/init.php");
include("../../lib/fnc_frontend.inc.php");
include("functions.inc.php"); 

$info = getMessageInfo();

?><html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
<?php if($updateBody) echo "<script language=\"JavaScript\" type=\"text/javascript\">parent.middle.location.href='body.php';</script>"; ?>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
<br>
<?php

$count = $info['unread'] ? "(".$info['unread']." ungelesen)" : "";



$paneContent = "

        <a href=\"?setmode=box&type=in\">Eingang $count</a><br>
        <br>
        <br>
        <a href=\"?setmode=write&action=new\">Nachricht verfassen</a> <br>
        <br>";
		
drawLeftPane($paneContent,"../../");
		
?>
</body>
</html>
