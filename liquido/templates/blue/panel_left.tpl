<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="{$LIQUIDO}/lib/css.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="{$LIQUIDO}/lib/liquido.js"></script>
<link href="{$LIQUIDO}/templates/blue/styles.css" rel="stylesheet" type="text/css">
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
	{include file=$panel_left}
	</div>
</div>