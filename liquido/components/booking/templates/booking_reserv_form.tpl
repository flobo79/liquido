{if false}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Booking Termine</title>
<link href="../booking.css" rel="stylesheet" type="text/css" />
</head>

<body>
{/if}
<form action="" method="post" name="{$formname}" class="borderless" id="{$formname}">
{if $editmode=="single"}
  <table width="{$tablewidth}"  border="0" cellspacing="0" cellpadding="0">
    <tr valign="top" class="row1">
      <td colspan="2">Geben Sie die gew&uuml;nschten Daten ein und best&auml;tigen Sie danach mit &quot;Speichern&quot;.<br />
        <strong>ACHTUNG!!!</strong> Eine Sicherheits&uuml;berpr&uuml;fung in Bezug auf &Uuml;berbuchung findet nur bei Terminen statt, die in der Zukunft liegen. Bei vergangenen Terminen wird eine &Uuml;berbuchung zugelassen.</td>
    </tr>
    <tr valign="top" class="row2">
      <td>Event:      </td>
      <td><select name="date_id" class="formfeld" id="date_id">
            {html_options options=$dates selected=$date_id}      
      </select></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Nachname:</td>
      <td><input name="rs_lastname" type="text" class="formfeld" id="rs_lastname" value="{$rs_lastname}" />
        <span class="error">{validate id="rs_lastname" message="<br />
Bitte geben Sie den Nachnamen ein"}</span></td>
    </tr>
    <tr valign="top" class="row2">
      <td>Vorname:</td>
      <td><input name="rs_firstname" type="text" class="formfeld" id="rs_firstname" value="{$rs_firstname}" /><span class="error">{validate id="rs_firstname" message="<br />
Bitte geben Sie den Vornamen ein"}</span></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Firma: </td>
      <td><input name="rs_company" type="text" class="formfeld" id="rs_company" value="{$rs_company}" /></td>
    </tr>
    <tr valign="top" class="row2">
      <td>Anzahl gew&uuml;nschte Tickets: </td>
      <td><input name="rs_places" type="text" class="formfeld" id="rs_places" value="{$rs_places}" />
        <span class="error">{validate id="rs_places" message="<br />
F&uuml;r diesen Eventtermin sind nicht gen&uuml;gend Tickets vorhanden"}</span></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Gutschein-Nummern (durch Komma getrennt): </td>
      <td><textarea name="rs_coupon" wrap="VIRTUAL" class="formfeld" id="rs_coupon">{$rs_coupon}</textarea>
        </td>
    </tr>
    <tr valign="top" class="row2">
      <td>Stra&szlig;e:</td>
      <td><input name="rs_street" type="text" class="formfeld" id="rs_street" value="{$rs_street}" />
        <span class="error">{validate id="rs_street" message="<br />
Bitte geben Sie eine Stra&szlig;e ein"}</span></td>
    </tr>
    <tr valign="top" class="row3">
      <td>PLZ, Ort: </td>
      <td><input name="rs_city" type="text" class="formfeld" id="rs_city" value="{$rs_city}" />
        <span class="error">{validate id="rs_city" message="<br />
Bitte geben Sie die PLZ und den Ort ein"}</span></td>
    </tr>
    <tr valign="top" class="row2">
      <td>E-Mail:</td>
      <td><input name="rs_email" type="text" class="formfeld" id="rs_email" value="{$rs_email}" />
        <span class="error">{validate id="rs_email" message="<br />
Bitte geben Sie eine E-Mail-Adresse ein"}</span></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Telefon:</td>
      <td><input name="rs_phone" type="text" class="formfeld" id="rs_phone" value="{$rs_phone}" /></td>
    </tr>
    <tr valign="top" class="row2">
      <td>Fax:</td>
      <td><input name="rs_fax" type="text" class="formfeld" id="rs_fax" value="{$rs_fax}" /></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Bemerkungen:</td>
      <td><textarea name="rs_remark" rows="5" class="formfeld" id="rs_remark">{$rs_remark}</textarea></td>
    </tr>
    <tr valign="top" class="row3">
      <td colspan="2"><input name="Submit" type="submit" class="formbutton" value="Speichern" />
      <input name="Delete" type="submit" class="formbutton" id="Delete" value="L&ouml;schen" onClick="return confirmSubmit('Wollen Sie die Buchung wirklich l&ouml;schen?')"{if !$rs_id} disabled="disabled"{/if}/>{if $rs_id}
      <input name="rs_id" type="hidden" id="rs_id" value="{$rs_id}" />
      {/if}</td>
    </tr>
  </table>
{elseif $editmode=="multi"}
  {section name=reserv loop=$reservierungen}
  <table width="{$tablewidth}"  border="0" cellspacing="0" cellpadding="0">
    <tr valign="top" class="row1">
      <td colspan="2">Geben Sie die gew&uuml;nschten Daten ein und best&auml;tigen Sie danach mit &quot;Speichern&quot;.<br />
        <strong>ACHTUNG!!!</strong> Eine Sicherheits&uuml;berpr&uuml;fung in Bezug auf &Uuml;berbuchung findet nur bei Terminen statt, die in der Zukunft liegen. Bei vergangenen Terminen wird eine &Uuml;berbuchung zugelassen.</td>
    </tr>
    <tr valign="top" class="row2">
      <td>Event:      </td>
      <td><select name="date_id[{$reservierungen[reserv].rs_id}]" class="formfeld" id="date_id[{$reservierungen[reserv].rs_id}]">
            {html_options options=$dates selected=$reservierungen[reserv].date_id}      
      </select></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Nachname:</td>
      <td><input name="rs_lastname[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_lastname[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_lastname}" />
        <span class="error">{validate id=$reservierungen[reserv].val_rs_lastname message="<br />
Bitte geben Sie den Nachnamen ein" halt="yes"}</span></td>
    </tr>
    <tr valign="top" class="row2">
      <td>Vorname:</td>
      <td><input name="rs_firstname[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_firstname[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_firstname}" />
      <span class="error">{validate id=$reservierungen[reserv].val_rs_firstname message="<br />
Bitte geben Sie den Vornamen ein" halt="yes"}</span></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Firma: </td>
      <td><input name="rs_company[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_company[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_company}" /></td>
    </tr>
    <tr valign="top" class="row2">
      <td>Anzahl gew&uuml;nschte Tickets: </td>
      <td><input name="rs_places[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_places[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_places}" />
        <span class="error">{validate id=$reservierungen[reserv].val_rs_places message="<br />
Bitte geben Sie eine Zahl ein" halt="yes"}</span></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Gutschein-Nummern (durch Komma getrennt):</td>
      <td><textarea name="rs_coupon[{$reservierungen[reserv].rs_id}]" wrap="VIRTUAL" class="formfeld" id="rs_coupon[{$reservierungen[reserv].rs_id}]">{$reservierungen[reserv].rs_coupon}</textarea>
      </td>
    </tr>
    <tr valign="top" class="row2">
      <td>Stra&szlig;e:</td>
      <td><input name="rs_street[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_street[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_street}" />
        <span class="error">{validate id=$reservierungen[reserv].val_rs_street message="<br />
Bitte geben Sie eine Stra&szlig;e ein" halt="yes"}</span></td>
    </tr>
    <tr valign="top" class="row3">
      <td>PLZ, Ort: </td>
      <td><input name="rs_city[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_city[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_city}" />
        <span class="error">{validate id=$reservierungen[reserv].val_rs_city message="<br />
Bitte geben Sie die PLZ und den Ort ein" halt="yes"}</span></td>
    </tr>
    <tr valign="top" class="row2">
      <td>E-Mail:</td>
      <td><input name="rs_email[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_email[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_email}" />
        <span class="error">{validate id=$reservierungen[reserv].val_rs_email message="<br />
Bitte geben Sie eine E-Mail-Adresse ein" halt="yes"}</span></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Telefon:</td>
      <td><input name="rs_phone[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_phone[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_phone}" /></td>
    </tr>
    <tr valign="top" class="row2">
      <td>Fax:</td>
      <td><input name="rs_fax[{$reservierungen[reserv].rs_id}]" type="text" class="formfeld" id="rs_fax[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_fax}" /></td>
    </tr>
    <tr valign="top" class="row3">
      <td>Bemerkungen:</td>
      <td><textarea name="rs_remark[{$reservierungen[reserv].rs_id}]" rows="5" class="formfeld" id="rs_remark[{$reservierungen[reserv].rs_id}]">{$reservierungen[reserv].rs_remark}</textarea></td>
    </tr>
    <tr valign="top" class="row3">
      <td colspan="2"><input name="Submit" type="submit" class="formbutton" value="Speichern" />
	  {if $reservierungen[reserv].rs_id}
      <input name="reserv[{$reservierungen[reserv].rs_id}]" type="hidden" id="reserv[{$reservierungen[reserv].rs_id}]" value="{$reservierungen[reserv].rs_id}" />
      {/if}
	  </td>
    </tr>
  </table>
  {/section}
  <input name="action" type="hidden" id="action" value="multiupdate" />
{/if}
</form>
{if false}
</body>
</html>
{/if}
