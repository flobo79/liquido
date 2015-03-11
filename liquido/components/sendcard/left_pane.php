<?php include("functions.php"); 
include("../../lib/fnc_frontend.inc.php");
?>
<html>
<head>
<title>cms-pro template left pane</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php if($cfg['visual']['pagefade']) { ?><meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)"><?php } ?>
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
<br>
<?php 
$content = "
<a href=\"body.php\" target=\"middle\">Sendcard verwalten</a><br>
<a href=\"statistik.php\" target=\"middle\">Statstiken</a><br>
<a href=\"settings.php\" target=\"middle\">Einstellungen</a><br>";

drawLeftPane ($content,"../../");
?>
</body>
</html>
