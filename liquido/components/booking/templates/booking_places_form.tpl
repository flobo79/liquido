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
    <tr class="row1">
      <td>Geben Sie die Daten des neuen Venues an und best&auml;tigen Sie danach mit &quot;Speichern&quot;. Eine Ver&ouml;ffentlichung im Internet erfolgt erst, wenn dem Venue Termine zugeordnet werden. </td>
    </tr>
    <tr class="row2">
      <td>Name des Venues: 
        <input name="pl_name" type="text" class="formfeld" id="pl_name" value="{$pl_name}" />
      <span class="error">{validate id="pl_name" message="<br />
	  Bitte geben Sie einen Namen ein"}</span></td>
    </tr>
    <tr class="row3">
      <td>Stra&szlig;e:
        <input name="pl_street" type="text" class="formfeld" id="pl_street" value="{$pl_street}" />
      <span class="error">{validate id="pl_street" message="<br />
	  Bitte geben Sie eine Stra&szlig;e ein"}</span></td>
    </tr>
    <tr class="row2">
      <td>PLZ / Ort: 
        <input name="pl_zipcode" type="text" class="formfeld" id="pl_zipcode" value="{$pl_zipcode}" size="6" maxlength="5" />
/ 
<input name="pl_city" type="text" class="formfeld" id="pl_city" value="{$pl_city}" />
<span class="error">{validate id="pl_zipcode" message="<br />
	  Bitte geben Sie eine Postleitzahl ein"}</span><span class="error">{validate id="pl_city" message="<br />
	  Bitte geben Sie einen Ort ein"}</span></td>
    </tr>
    <tr class="row3">
      <td>Bundesland: 
          <select name="country_id" class="formfeld" id="country_id">
            {html_options options=$countries selected=$country_id}
        </select></tr>
    <tr class="row2">
      <td><input name="Submit" type="submit" class="formbutton" value="Speichern" />
      <input name="Delete" type="submit" class="formbutton" id="Delete" value="L&ouml;schen" onClick="return confirmSubmit('Wollen Sie den Venue wirklich l&ouml;schen?')"{if !$place_id} disabled="disabled"{/if}/>{if $place_id}
      <input name="place_id" type="hidden" id="place_id" value="{$place_id}" />
      {/if}</td>
    </tr>
  </table>
{elseif $editmode=="multi"}
  {section name=place loop=$places}
  <table width="{$tablewidth}"  border="0" cellspacing="0" cellpadding="0">
    <tr class="row1">
      <td>Geben Sie die Daten des neuen Venues an und best&auml;tigen Sie danach mit &quot;Speichern&quot;. Eine Ver&ouml;ffentlichung im Internet erfolgt erst, wenn dem Venue Termine zugeordnet werden. </td>
    </tr>
    <tr class="row2">
      <td>Name des Venues: 
        <input name="pl_name[{$places[place].place_id}]" type="text" class="formfeld" id="pl_name[{$places[place].place_id}]" value="{$places[place].pl_name}" />
      <span class="error">{validate id=$places[place].val_pl_name message="<br />
	  Bitte geben Sie einen Namen ein" halt=&quot;yes&quot;}</span></td>
    </tr>
    <tr class="row3">
      <td>Stra&szlig;e:
        <input name="pl_street[{$places[place].place_id}]" type="text" class="formfeld" id="pl_street[{$places[place].place_id}]" value="{$places[place].pl_street}" />
      <span class="error">{validate id=$places[place].val_pl_street message="<br />
	  Bitte geben Sie eine Stra&szlig;e ein" halt=&quot;yes&quot;}</span></td>
    </tr>
    <tr class="row2">
      <td>PLZ / Ort: 
        <input name="pl_zipcode[{$places[place].place_id}]" type="text" class="formfeld" id="pl_zipcode[{$places[place].place_id}]" value="{$places[place].pl_zipcode}" size="6" maxlength="5" />
/ 
<input name="pl_city[{$places[place].place_id}]" type="text" class="formfeld" id="pl_city[{$places[place].place_id}]" value="{$places[place].pl_city}" />
<span class="error">{validate id=$places[place].val_pl_zipcode message="<br />
	  Bitte geben Sie eine Postleitzahl ein" halt=&quot;yes&quot;}</span><span class="error">{validate id=$places[place].val_pl_city message="<br />
	  Bitte geben Sie einen Ort ein" halt=&quot;yes&quot;}</span></td>
    </tr>
    <tr class="row3">
      <td>Bundesland: 
          <select name="country_id[{$places[place].place_id}]" class="formfeld" id="country_id[{$places[place].place_id}]">
            {html_options options=$countries selected=$places[place].country_id}
        </select></tr>
    <tr class="row2">
      <td><input name="Submit" type="submit" class="formbutton" value="Speichern" />
	  {if $places[place].place_id}
      <input name="places[{$places[place].place_id}]" type="hidden" id="places[{$places[place].place_id}]" value="{$places[place].place_id}" />
      {/if}</td>
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
