<?
$result = getObjectData($id);
if($reprint) {
	reprint($result);
	updateColumnChilds($id);
}
?> 
<form name="form1" method="post" action="">
  <table width="100%" height="100%">
    <tr> 
      <td width="25" valign="top">&nbsp; </td>
      <td valign="top"><p><br>
          <br>
          Das Bild mit der gesuchten Bildnummer wurde nicht gefunden.</p>
        <p>Bildernummer: 
          <input name="id" type="text" size="4" maxlength="4">
          <a href="#" onClick="form1.submit(); return false">ok</a> </p></td>
    </tr>
  </table>
</form>
