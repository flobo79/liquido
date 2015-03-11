<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$title}</title>
<link href="booking.css" rel="stylesheet" type="text/css" title="Normal" media="screen">
<link href="print.css" rel="stylesheet" type="text/css" media="print">
{if $redir}
<meta http-equiv="Refresh" content="{if $redirtime}{$redirtime}{else}0{/if};URL={$redir}" />
{/if}
<script language="JavaScript">
<!--
function confirmSubmit(question)
{ldelim}
var agree=confirm(question);
if (agree)
return true ;
else
return false ;
{rdelim}
// -->
</script>
{if $include=="booking_dates.tpl" || $include=="booking_reserv.tpl" || $include=="booking_places.tpl"}
<script language="javascript" src="stickylayer.js"></script>
{/if}
</head>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">
