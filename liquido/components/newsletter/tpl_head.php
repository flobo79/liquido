<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo LIQUIDO; ?>/css/liquido.css" rel="stylesheet" type="text/css">
<link href="<?php echo LIQUIDO; ?>/css/objects.css" rel="stylesheet" type="text/css">
<link href="<?php echo LIQUIDO; ?>/css/objects.css" rel="stylesheet" type="text/css">
<link href="<?php echo LIQUIDO; ?>/components/contents/styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="/liquido/js/mootools.js"></script>
<script language="JavaScript" type="text/javascript" src="/liquido/js/utils.js"></script>
<link href="<?php echo LIQUIDO."/components/".$comp ?>/styles.css" rel="stylesheet" type="text/css">
<link href="<?php echo SKIN ?>/styles.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript" src="<?php echo LIQUIDO; ?>/js/liquido.js"></script>
<?php  if(file_exists($thiscomp['current']."/scripts.js")) { ?><script language="JavaScript" type="text/javascript" src="<?php echo $thiscomp['current'] ?>/scripts.js"></script><?php } ?>
<script language="JavaScript" type="text/JavaScript">
<!--
<?php 

	if($update_rightpane) echo "parent.right.location.href='panel_right.php";
	if($update_leftpane) echo "parent.left.location.href='panel_left.php?select[id]=$obj[id]&amp;noupdate=1';";
	if($update_leftframe) echo "parent.left.location.href='panel_left.php?noupdate=1';";
?>
 //-->
</script>

</head>

<body>
