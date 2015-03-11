{if false}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Booking Reservierungen</title>
<link href="../booking.css" rel="stylesheet" type="text/css" />
</head>

<body>
{/if}
{include file="javascript.tpl"}
<script language="JavaScript" type="text/javascript">
	top.frames['content'].show('searchbox,booking_tools','block');
</script>
<script language="JavaScript" type="text/javascript">
	function multiSubmit(action){ldelim}
		var donot;
		foo = false;
		temp = document.{$formname}.elements.length ;
		for (i=0; i < temp; i++){ldelim}
			if(document.{$formname}.elements[i].checked == 1) foo = true;
		{rdelim}
		if(!foo) {ldelim}
			alert('Bitte wählen Sie zuerst ein oder mehrere Einträge aus der Liste aus');
		{rdelim} else {ldelim}
			// check ob es sich um löschaufruf handelt
			if(action == "multidel") {ldelim}
				if(!confirm("Möchten Sie die ausgewählten Einträge wirklich löschen?")) donot = true;
			}
			
			if(!donot) {ldelim}
				document.{$formname}.action.value = action ;
				document.{$formname}.submit();
			{rdelim}
		{rdelim}
	{rdelim}
</script>
<div id="tableheader">
<table width="{$tablewidth}"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th nowrap="nowrap" scope="col"><input name="checkallheader" type="checkbox" id="checkallheader" value="checkbox" onchange="Invers();" /></th>
    <th nowrap="nowrap" scope="col" {if $sort==0}class="highlight"{/if}><a href="?sort=0&type={if $sort==0}{$sorturladd}{else}0{/if}{$query}">&nbsp;{if $sort==0}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==1}class="highlight"{/if}><a href="?sort=1&type={if $sort==1}{$sorturladd}{else}1{/if}{$query}">Datum{if $sort==1}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==2}class="highlight"{/if}><a href="?sort=2&type={if $sort==2}{$sorturladd}{else}0{/if}{$query}">Ref.-Nr.{if $sort==2}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==3}class="highlight"{/if}><a href="?sort=3&type={if $sort==3}{$sorturladd}{else}0{/if}{$query}">Kontakt{if $sort==3}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==4}class="highlight"{/if}><a href="?sort=4&type={if $sort==4}{$sorturladd}{else}0{/if}{$query}">Event{if $sort==4}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==5}class="highlight"{/if}><a href="?sort=5&type={if $sort==5}{$sorturladd}{else}0{/if}{$query}">Tickets{if $sort==5}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==6}class="highlight"{/if}><a href="?sort=6&type={if $sort==6}{$sorturladd}{else}0{/if}{$query}">R.v.{if $sort==6}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==7}class="highlight"{/if}><a href="?sort=7&type={if $sort==7}{$sorturladd}{else}0{/if}{$query}">R.b.{if $sort==7}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==8}class="highlight"{/if}><a href="?sort=8&type={if $sort==8}{$sorturladd}{else}0{/if}{$query}">T.v.{if $sort==8}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==9}class="highlight"{/if}><a href="?sort=9&type={if $sort==9}{$sorturladd}{else}0{/if}{$query}">BB.v.{if $sort==9}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==10}class="highlight"{/if}><a href="?sort=10&type={if $sort==10}{$sorturladd}{else}0{/if}{$query}">BB.e.{if $sort==10}{$typeimg}{/if}</a></th>
  </tr>
  {section name=res loop=$reservierungen}
  <tr valign="top" class="{cycle values="row1,row2"}">
    <td><input name="reservheader[{$reservierungen[res].rs_id}]" type="checkbox" id="reservheader[{$reservierungen[res].rs_id}]" value="checkbox" /></td>
    <td {if $sort==0}class="over"{/if}>{if $reservierungen[res].rs_confirm_send=="0"}<img src="gfx/green_bubble.gif" />{else}&nbsp;{/if}</td>
    <td {if $sort==1}class="over"{/if}>{$reservierungen[res].rs_date_format}</td>
    <td {if $sort==2}class="over"{/if}>{$reservierungen[res].rs_book_nr}</td>
    <td {if $sort==3}class="over"{/if}><strong>{$reservierungen[res].rs_company}{if $reservierungen[res].rs_company}<br />{/if}
  {$reservierungen[res].rs_firstname}
      {$reservierungen[res].rs_lastname}</strong><br />        {$reservierungen[res].rs_street}<br />
{$reservierungen[res].rs_city}<br />
      {if $reservierungen[res].rs_email}<a href="mailto:{$reservierungen[res].rs_email}">{$reservierungen[res].rs_email}</a><br />{/if}
      {if $reservierungen[res].rs_phone}Tel.: {$reservierungen[res].rs_phone}{/if}
	  {if $reservierungen[res].rs_fax}<br />Fax: {$reservierungen[res].rs_fax}{/if}
	  </td>
    <td {if $sort==4}class="over"{/if}>{$reservierungen[res].t_datum} {$reservierungen[res].t_uhrzeit}<br /><strong>{$reservierungen[res].t_datum}</strong><br />
      ({$reservierungen[res].tr_designation})<br />      {$reservierungen[res].pl_name}<br />
{$reservierungen[res].pl_street}<br />
{$reservierungen[res].pl_zipcode} {$reservierungen[res].pl_city}</td>
    <td {if $sort==5}class="over"{/if}>{$reservierungen[res].rs_places}<br />
      ({if $reservierungen[res].rs_has_invalid_coupons=="1"}<img src="gfx/messagebox_warning.gif" alt="Fehlerhafte Gutscheine eingegeben!" title="Fehlerhafte Gutscheine eingegeben!" />&nbsp;{/if}{$reservierungen[res].rs_coupon_nr})
	  </td>
    <td {if $sort==6}class="over"{/if}>{if $reservierungen[res].rs_calc_send=="1"}<img src="gfx/checked.gif" alt="Rechnung verschickt am {$reservierungen[res].rs_calc_senddate_format}" title="Rechnung verschickt am {$reservierungen[res].rs_calc_senddate_format}" /><br />{$reservierungen[res].rs_invoice_nbr}{else}Rechnungs-Nr.:<br />
      <input name="invoicenbrheader[{$reservierungen[res].rs_id}]" type="text" class="formfeld" id="invoicenbrheader[{$reservierungen[res].rs_id}]" size="10" maxlength="255" />      
      &nbsp;{/if}</td>
    <td {if $sort==7}class="over"{/if}>{if $reservierungen[res].rs_calc_paid=="1"}<img src="gfx/checked.gif" alt="Rechnung bezahlt am {$reservierungen[res].rs_calc_date_format}" title="Rechnung bezahlt am {$reservierungen[res].rs_calc_date_format}" />{else}&nbsp;{/if}</td>
    <td {if $sort==8}class="over"{/if}>{if $reservierungen[res].rs_participantinfos_send=="1"}<img src="gfx/checked.gif" alt="Tickets verschickt am {$reservierungen[res].rs_participantinfos_date_format}" title="Teilnehmerunterlagen verschickt am {$reservierungen[res].rs_participantinfos_date_format}" />{else}&nbsp;{/if}</td>
    <td {if $sort==9}class="over"{/if}>{if $reservierungen[res].rs_announceconfirm_send=="1"}<img src="gfx/checked.gif" alt="Buchungsbestätigung verschickt am {$reservierungen[res].rs_announceconfirm_senddate_format}" title="Buchungsbestätigung verschickt am {$reservierungen[res].rs_announceconfirm_senddate_format}" />{else}&nbsp;{/if}</td>
    <td {if $sort==10}class="over"{/if}>{if $reservierungen[res].rs_announceconfirm_recv=="1"}<img src="gfx/checked.gif" alt="Buchungsbestätigung erhalten am {$reservierungen[res].rs_announceconfirm_recvdate_format}" title="Buchungsbestätigung erhalten am {$reservierungen[res].rs_announceconfirm_recvdate_format}" />{else}&nbsp;{/if}</td>
  </tr>
  {sectionelse}
  <tr>
    <td>&nbsp;</td>
    <td colspan="11" class="error">Keine passenden Eintr&auml;ge gefunden.</td>
    </tr>
  {/section}
</table>
</div>
<form action="" method="post" name="{$formname}" class="borderless" id="{$formname}">
<table width="{$tablewidth}"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th nowrap="nowrap" scope="col"><input name="checkall" type="checkbox" id="checkall" value="checkbox" onchange="Invers();" /></th>
    <th nowrap="nowrap" scope="col" {if $sort==0}class="highlight"{/if}><a href="?sort=0&type={if $sort==0}{$sorturladd}{else}0{/if}{$query}">&nbsp;{if $sort==0}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==1}class="highlight"{/if}><a href="?sort=1&type={if $sort==1}{$sorturladd}{else}1{/if}{$query}">Datum{if $sort==1}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==2}class="highlight"{/if}><a href="?sort=2&type={if $sort==2}{$sorturladd}{else}0{/if}{$query}">Ref.-Nr.{if $sort==2}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==3}class="highlight"{/if}><a href="?sort=3&type={if $sort==3}{$sorturladd}{else}0{/if}{$query}">Kontakt{if $sort==3}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==4}class="highlight"{/if}><a href="?sort=4&type={if $sort==4}{$sorturladd}{else}0{/if}{$query}">Training{if $sort==4}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==5}class="highlight"{/if}><a href="?sort=5&type={if $sort==5}{$sorturladd}{else}0{/if}{$query}">Tickets{if $sort==5}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==6}class="highlight"{/if}><a href="?sort=6&type={if $sort==6}{$sorturladd}{else}0{/if}{$query}">R.v.{if $sort==6}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==7}class="highlight"{/if}><a href="?sort=7&type={if $sort==7}{$sorturladd}{else}0{/if}{$query}">R.b.{if $sort==7}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==8}class="highlight"{/if}><a href="?sort=8&type={if $sort==8}{$sorturladd}{else}0{/if}{$query}">T.v.{if $sort==8}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==9}class="highlight"{/if}><a href="?sort=9&type={if $sort==9}{$sorturladd}{else}0{/if}{$query}">BB.v.{if $sort==9}{$typeimg}{/if}</a></th>
    <th nowrap="nowrap" scope="col" {if $sort==10}class="highlight"{/if}><a href="?sort=10&type={if $sort==10}{$sorturladd}{else}0{/if}{$query}">BB.e.{if $sort==10}{$typeimg}{/if}</a></th>
  </tr>
  {section name=res loop=$reservierungen}
  <tr valign="top" class="{cycle values="row1,row2"}" ondblclick="javascript:location.href='list_bookings.php?action=edit&id={$reservierungen[res].rs_id}';">
    <td><input name="reserv[{$reservierungen[res].rs_id}]" type="checkbox" id="reserv[{$reservierungen[res].rs_id}]" value="checkbox" /></td>
    <td {if $sort==0}class="over"{/if}>{if $reservierungen[res].rs_confirm_send=="0"}<img src="gfx/green_bubble.gif" />{else}&nbsp;{/if}</td>
    <td {if $sort==1}class="over"{/if}>{$reservierungen[res].rs_date_format}</td>
    <td {if $sort==2}class="over"{/if}>{$reservierungen[res].rs_book_nr}</td>
    <td {if $sort==3}class="over"{/if}><strong>{$reservierungen[res].rs_company}{if $reservierungen[res].rs_company}<br />{/if}
  {$reservierungen[res].rs_firstname}
      {$reservierungen[res].rs_lastname}</strong><br />        {$reservierungen[res].rs_street}<br />
{$reservierungen[res].rs_city}<br />
      {if $reservierungen[res].rs_email}<a href="mailto:{$reservierungen[res].rs_email}">{$reservierungen[res].rs_email}</a><br />{/if}
      {if $reservierungen[res].rs_phone}Tel.: {$reservierungen[res].rs_phone}{/if}
	  {if $reservierungen[res].rs_fax}<br />Fax: {$reservierungen[res].rs_fax}{/if}
	  </td>
    <td {if $sort==4}class="over"{/if}>{$reservierungen[res].t_datum} {$reservierungen[res].t_uhrzeit}<br /><strong>{$reservierungen[res].eventname}</strong><br />

      ({$reservierungen[res].tr_designation})<br />      {$reservierungen[res].pl_name}<br />
{$reservierungen[res].pl_street}<br />
{$reservierungen[res].pl_zipcode} {$reservierungen[res].pl_city}</td>
    <td {if $sort==5}class="over"{/if}>{$reservierungen[res].rs_places}<br />
      ({if $reservierungen[res].rs_has_invalid_coupons=="1"}<img src="gfx/messagebox_warning.gif" alt="Fehlerhafte Coupons eingegeben!" title="Fehlerhafte Coupons eingegeben!" />&nbsp;{/if}{$reservierungen[res].rs_coupon_nr})
	  </td>
    <td {if $sort==6}class="over"{/if}>{if $reservierungen[res].rs_calc_send=="1"}<img src="gfx/checked.gif" alt="Rechnung verschickt am {$reservierungen[res].rs_calc_senddate_format}" title="Rechnung verschickt am {$reservierungen[res].rs_calc_senddate_format}" /><br />{$reservierungen[res].rs_invoice_nbr}{else}Rechnungs-Nr.:<br />
      <input name="invoicenbr[{$reservierungen[res].rs_id}]" type="text" class="formfeld" id="invoicenbr[{$reservierungen[res].rs_id}]" size="10" maxlength="255" />      
      &nbsp;{/if}</td>
    <td {if $sort==7}class="over"{/if}>{if $reservierungen[res].rs_calc_paid=="1"}<img src="gfx/checked.gif" alt="Rechnung bezahlt am {$reservierungen[res].rs_calc_date_format}" title="Rechnung bezahlt am {$reservierungen[res].rs_calc_date_format}" />{else}&nbsp;{/if}</td>
    <td {if $sort==8}class="over"{/if}>{if $reservierungen[res].rs_participantinfos_send=="1"}<img src="gfx/checked.gif" alt="Teilnehmerunterlagen verschickt am {$reservierungen[res].rs_participantinfos_date_format}" title="Tickets verschickt am {$reservierungen[res].rs_participantinfos_date_format}" />{else}&nbsp;{/if}</td>
    <td {if $sort==9}class="over"{/if}>{if $reservierungen[res].rs_announceconfirm_send=="1"}<img src="gfx/checked.gif" alt="Anmeldebestätigung verschickt am {$reservierungen[res].rs_announceconfirm_senddate_format}" title="Buchungsbestätigung verschickt am {$reservierungen[res].rs_announceconfirm_senddate_format}" />{else}&nbsp;{/if}</td>
    <td {if $sort==10}class="over"{/if}>{if $reservierungen[res].rs_announceconfirm_recv=="1"}<img src="gfx/checked.gif" alt="Anmeldebestätigung erhalten am {$reservierungen[res].rs_announceconfirm_recvdate_format}" title="Buchungsbestätigung erhalten am {$reservierungen[res].rs_announceconfirm_recvdate_format}" />{else}&nbsp;{/if}</td>
  </tr>
  {sectionelse}
  <tr>
    <td>&nbsp;</td>
    <td colspan="11" class="error">Keine passenden Eintr&auml;ge gefunden.</td>
    </tr>
  {/section}
</table>
<input name="action" type="hidden" id="action" value="view" />
</form>
{if false}
</body>
</html>
{/if}