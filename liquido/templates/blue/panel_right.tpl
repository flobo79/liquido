<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="<?php echo LIQUIDO ?>/css/liquido.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo LIQUIDO ?>/css/objects.css" rel="stylesheet" type="text/css" />
	<?php foreach($cfg['components']['contents']['css'] as $lnk) { ?>
	<link href="<?php echo $lnk; ?>" rel="stylesheet" type="text/css" />
	<?php } ?>
	<script language="JavaScript" type="text/JavaScript" src="/liquido/js/mootools.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="/liquido/js/utils.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="/liquido/components/medialibrary/browser/mediabrowser.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="/liquido/js/liquido.js"></script>
	
<script language="JavaScript" type="text/JavaScript">
<!--
{php} 

	if($update_rightframe) echo "parent.right.location.href='right.php?nlmode=$nlmode';";
	if($update_leftpane) echo "parent.left.location.href='left_pane.php?select[id]=$obj[id]&noupdate=1';";
	if($update_leftframe) echo "parent.left.location.href='left_pane.php?noupdate=1';";

{/php}
 //-->
</script>

</head>

<body class="blue_bg">
{if $searchbox }
	<div id="searchbox">
		<div id="searchbox_clear" onclick="delsearch();">&nbsp;</div>
		<div id="searchbox_inputbox"><input type="text" name="search" id="searchbox_input" value="{$search}" onkeyup="searchthis();" /></div>
	</div>
{/if}
<div id="leftpane_content_box">
	<div id="leftpane_content">
	{include file="$panel_right"}
	</div>
</div>

</body>
</html>