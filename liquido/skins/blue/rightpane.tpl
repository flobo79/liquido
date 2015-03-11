<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
{if $cfg.visual.pagefade}<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)">{/if}

<link href="{$LIQUIDO}/lib/css.css" rel="stylesheet" type="text/css">
<link href="{$LIQUIDO}/templates/blue/styles.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript" src="{$LIQUIDO}/lib/liquido.js"></script>
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
<link href="{ $CMSPATH }/templates/blue/styles.css" rel="stylesheet" type="text/css">
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