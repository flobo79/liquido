<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Übersicht</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
[{$xajax_javascript}]
<script type="text/javascript">
<!--

function deletemail()
{
	xajax_deletemail([{$id}]);
}

function deletesubscriber()
{
[{if $adressat}]
	xajax_deletesubscriber('[{$adressat}]');
[{/if}]
}

//-->
</script>
</head>

<body>
<h1>E-Mail Details</h1>
<p>Betreff: [{$betreff|escape:"htmlall"}] <br />
  Von: [{$from|escape:"htmlall"}]<br />
  Datum: [{$datum}]<br />
An: [{$to|escape:"htmlall"}]</p>
<p>Grund: [{if $grund}][{$grund}][{else}]unbekannt[{/if}]<br />
  Abonnent: [{if $adressat}][{$adressat}][{else}]kein Abonnent![{/if}]
</p>
<code>[{$body|escape:"htmlall"|nl2br}]</code>
<p>
  <input name="close" type="button" id="close" value="Schlie&szlig;en" onclick="javascript:window.close();" />
  <input name="deletemail" type="button" id="deletemail" value="Email l&ouml;schen" onclick="javascript:deletemail();" />
[{if $adressat}]
  <input name="deletesubscriber" type="button" id="deletesubscriber" value="Abonnent l&ouml;schen" onclick="javascript:deletesubscriber();" />
[{/if}]
</p>
</body>
</html>
