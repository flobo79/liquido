<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	if(!$_SESSION['current']['comp']) $_SESSION['current']['comp'] = "start";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script language="JavaScript" type="text/JavaScript">
	var liquido = '<?php echo LIQUIDO ?>';
</script>
<script language="JavaScript" type="text/JavaScript" src="/liquido/js/mootools.js"></script>
<script language="JavaScript" type="text/JavaScript" src="/liquido/js/liquido.js"></script>
<link href="css/liquido.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#select {
		position:absolute;
		right:100px;
		width:200px;
		top:7px;
	} 
</style>
</head>

<body>
<table width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="684" height="29" background="gfx/head_bg.gif">
	<table border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="66"><a href="body.php?setmod=start" target="content"><img src="gfx/bu_start.gif" alt="zur Haupseite" name="Image1" width="66" height="27" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','gfx/bu_start_o.gif',1);" onmouseout="MM_swapImgRestore();"></a></td>
          <td> 
            <?php
			if(isset($_SESSION['current'])) include(file_exists($file = $_SERVER['DOCUMENT_ROOT']."/liquido/components/".$_SESSION['current']['comp']."/head.php") ? $file : $_SERVER['DOCUMENT_ROOT']."/liquido/components/".$_SESSION['current']['comp']."/head.html");
			?>
          </td>
          <td width="48"><a href="body.php?setmod=help&topic=<?php echo $_SESSION['current']['comp'] ?>" target="content"><img src="gfx/bu_help.gif" alt="Hilfeseite aufrufen" name="Image2" width="48" height="27" border="0" id="Image2" onMouseOver="MM_swapImage('Image2','','gfx/bu_help_o.gif',1);" onMouseOut="MM_swapImgRestore();"></a></td>
        </tr>
      </table>
    </td>
    <td align="right" valign="top" background="gfx/head_bg.gif">
		<?php if($user['egroup'] == 1) { ?><div id="select"><a href="http://www.vw-club.de/login/index.php" target="_top">Projektauswahl</a></div><?php } ?>
		<a href="http://www.missionmedia.de" target="_blank"><img src="gfx/logo-v3b.gif" width="124" height="29" border="0"></a> 
    </td>
  </tr>
</table>
</body>
</html>
