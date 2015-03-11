<?php include("functions.php"); 
include("../../lib/fnc_frontend.inc.php");
?>
<html>
<head>
<title>liquido template left pane</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php if($cfg['visual']['pagefade']) { ?><meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)"><?php } ?>
<link href="../../lib/css.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
<br/>
<?php 
$content = "
<a href=\"body.php\" target=\"middle\">Highscores</a><br>
<a href=\"logo.php\" target=\"middle\">Treuepunkte-Logos</a><br>
";

drawLeftPane ($content);
?>
</body>
</html>
