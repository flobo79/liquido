<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Übersicht</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function openmail(id)
{
	MM_openBrWindow('emaildetails.php?emailid='+id,'emaildetails','scrollbars=yes,resizable=yes,width=400,height=500');
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<h1>&Uuml;bersicht der nicht zustellbaren Mails</h1>
<p>
  <table width="100%">
    <tr>
      <th>&nbsp;</th>
      <!--<th>Von</th>-->
      <th>Adressat</th>
      <th>Grund</th>
      <th>Datum</th>
    </tr>
    [{section name=r loop=$ruecklaeufer}]
    <tr class="[{cycle values="row1,row2"}]" onclick="javascript:openmail([{$ruecklaeufer[r].id}]);">
      <td><input name="cb[[{$ruecklaeufer[r].id}]]" type="checkbox" id="cb[[{$ruecklaeufer[r].id}]]" value="1" /></td>
      <!--<td>[{$ruecklaeufer[r].from|escape:"htmlall"}]</td>-->
      <td>[{$ruecklaeufer[r].adressat|escape:"htmlall"|default:"unbekannt"}]</td>
      <td>[{$ruecklaeufer[r].grund}]</td>
      <td>[{$ruecklaeufer[r].datum}]</td>
    </tr>
    [{sectionelse}]
    <tr>
      <td colspan="4">Keine R&uuml;ckl&auml;ufer vorhanden.</td>
    </tr>
    [{/section}]
  </table>
</p>
</body>
</html>
