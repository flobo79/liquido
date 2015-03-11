<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="{$LIQUIDO}/css/liquido.css" rel="stylesheet" type="text/css" />
	<link href="{$LIQUIDO}/css/objects.css" rel="stylesheet" type="text/css" />
	<?php foreach($cfg['components']['contents']['css'] as $lnk) { ?>
	<link href="<?php echo $lnk; ?>" rel="stylesheet" type="text/css" />
	<?php } ?>
	<script language="JavaScript" type="text/JavaScript" src="{$LIQUIDO}/js/mootools.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="{$LIQUIDO}/js/utils.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="{$LIQUIDO}/components/medialibrary/browser/mediabrowser.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="{$LIQUIDO}/js/liquido.js"></script>
	
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
<link href="{ $LIQUIDO }/templates/blue/styles.css" rel="stylesheet" type="text/css">
{if $searchbox }
	<div id="searchbox">
		<div id="searchbox_clear" onclick="delsearch();">&nbsp;</div>
		<div id="searchbox_inputbox"><input type="text" name="search" id="searchbox_input" value="{$search}" onkeyup="searchthis();" /></div>
	</div>
{/if}
<div id="leftpane_content_box">
	<div id="leftpane_content">
	{include file="$rightpane"}
	</div>
</div>

</body>
</html>