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
      <td>Geben Sie die Daten des neuen Eventtermines an und best&auml;tigen Sie danach mit &quot;Speichern&quot;. Eine Ver&ouml;ffentlichung im Internet erfolgt erst, wenn der Termin freigegeben wurde. Die Freigabe kann hier direkt bei der Erfassung  oder erst sp&auml;ter &uuml;ber den Men&uuml;punkt &quot;Termindaten &auml;ndern&quot; erfolgen. </td>
    </tr>
    <tr class="row2">
      <td><p>W&auml;hlen Sie den zugeh&ouml;rigen Venue:
</p>
        <p>          
          <select name="place_id" class="formfeld" id="place_id">
            {html_options options=$places selected=$place_id}
          </select> 
        </p></td>
    </tr>
    <tr class="row3">
      <td><p>Geben Sie Eventdatum und -uhrzeit an:</p>
      <p> {html_select_date_german all_extra='class="formfeld"' selected_day="$Date_Day" selected_month="$Date_Month" selected_year="$Date_Year" field_order="DMY" start_year="-2" end_year="+3"} &nbsp;&nbsp;um&nbsp;&nbsp; {html_select_time_mod all_extra='class="formfeld"' selected_hour="$Time_Hour" selected_minute="$Time_Minute" minute_interval=5 display_seconds=false} Uhr </p></td>
    </tr>
    <tr class="row2">
      <td><p>W&auml;hlen Sie die gew&uuml;nschte Eventart: </p>
      <p>
        <select name="training_id" class="formfeld" id="training_id">
		  {html_options options=$trainings selected=$training_id}
        </select>
      </p></td>
    </tr>
    <tr class="row3">
      <td>Eventname: 
      <input name="eventname" type="text" class="formfeld" id="eventname" value="{$eventname}" />
	</td>
    </tr>
    <tr class="row3">
      <td><p>Details zum Event (optional - bitte ID der Webseite mit den Details angeben): </p>
  <input name="eventdetails" type="text" class="formfeld" id="eventdetails" value="{$eventdetails}" />
	</td>
    </tr>
    <tr class="row2">
      <td>Zahl der verf&uuml;gbaren Tickets: 
      <input name="dt_capacity_max" type="text" class="formfeld" id="dt_capacity_max" value="{$dt_capacity_max}" />
	  <span class="error">{validate id="dt_capacity_max" message="<br />
	  Bitte geben Sie eine Zahl ein"}</span></td>
    </tr>
    <tr class="row3">
      <td><p>Freigabe im Internet:</p>
        <p><input type="radio" name="dt_frei" value="j" {if $dt_frei=="j"}checked="checked" {/if}/>
          ja
          <input type="radio" name="dt_frei" value="b" {if $dt_frei=="b"}checked="checked" {/if}/>
          beschr&auml;nkt
          <input name="dt_frei" type="radio" value="n" {if $dt_frei=="n"}checked="checked" {/if}/>
      nein</p>
        <span class="error">{validate id="dt_frei" message="Bitte w&auml;hlen Sie eine Option "}</span></td>
    </tr>
    <tr class="row2">
      <td><input name="Submit" type="submit" class="formbutton" value="Speichern" />
      <input name="Delete" type="submit" class="formbutton" id="Delete" value="L&ouml;schen" onClick="return confirmSubmit('Wollen Sie den Termin wirklich l&ouml;schen?')"{if !$date_id} disabled="disabled"{/if}/>{if $date_id}
      <input name="date_id" type="hidden" id="date_id" value="{$date_id}" />
      {/if}</td>
    </tr>
  </table>
  <p><strong>Buchungen zu diesem Termin:</strong></p>
	<form action="" method="post" name="{$formname}-reserv" class="borderless" id="{$formname}-reserv">
	<table width="{$tablewidth}"  border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<th nowrap="nowrap" scope="col" {if $sort==0}class="highlight"{/if}><a href="?sort=0&type={if $sort==0}{$sorturladd}{else}0{/if}{$query}">&nbsp;{if $sort==0}{$typeimg}{/if}</a></th>
		<th nowrap="nowrap" scope="col" {if $sort==1}class="highlight"{/if}><a href="?sort=1&type={if $sort==1}{$sorturladd}{else}1{/if}{$query}">Datum{if $sort==1}{$typeimg}{/if}</a></th>
		<th nowrap="nowrap" scope="col" {if $sort==2}class="highlight"{/if}><a href="?sort=2&type={if $sort==2}{$sorturladd}{else}0{/if}{$query}">Ref.-Nr.{if $sort==2}{$typeimg}{/if}</a></th>
		<th nowrap="nowrap" scope="col" {if $sort==3}class="highlight"{/if}><a href="?sort=3&type={if $sort==3}{$sorturladd}{else}0{/if}{$query}">Kontakt{if $sort==3}{$typeimg}{/if}</a></th>
		<th nowrap="nowrap" scope="col">Sonstiges</a></th>
		<th nowrap="nowrap" scope="col" {if $sort==5}class="highlight"{/if}><a href="?sort=5&type={if $sort==5}{$sorturladd}{else}0{/if}{$query}">Tickets{if $sort==5}{$typeimg}{/if}</a></th>
		<th nowrap="nowrap" scope="col" {if $sort==6}class="highlight"{/if}><a href="?sort=6&type={if $sort==6}{$sorturladd}{else}0{/if}{$query}">R.v.{if $sort==6}{$typeimg}{/if}</a></th>
		<th nowrap="nowrap" scope="col" {if $sort==7}class="highlight"{/if}><a href="?sort=7&type={if $sort==7}{$sorturladd}{else}0{/if}{$query}">R.b.{if $sort==7}{$typeimg}{/if}</a></th>
		<th nowrap="NOWRAP" scope="col" {if $sort==8}class="highlight"{/if}><a href="?sort=8&type={if $sort==8}{$sorturladd}{else}0{/if}{$query}">T.v.{if $sort==8}{$typeimg}{/if}</a></th>
		<th nowrap="NOWRAP" scope="col" {if $sort==9}class="highlight"{/if}><a href="?sort=9&type={if $sort==9}{$sorturladd}{else}0{/if}{$query}">AB.v.{if $sort==9}{$typeimg}{/if}</a></th>
		<th nowrap="NOWRAP" scope="col" {if $sort==10}class="highlight"{/if}><a href="?sort=10&type={if $sort==10}{$sorturladd}{else}0{/if}{$query}">AB.e.{if $sort==10}{$typeimg}{/if}</a></th>
	  </tr>
	  {section name=res loop=$reservierungen}
	  <tr valign="top" class="{cycle values="row1,row2"}" ondblclick="javascript:location.href='list_bookings.php?action=edit&id={$reservierungen[res].rs_id}';">
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
		<td>{if $reservierungen[res].rs_coupon}<u><strong>Gutscheine:</strong></u><br />
		  {$reservierungen[res].rs_coupon|replace:",":", "}<br /><br />{/if}
  {if $reservierungen[res].rs_remark}<u><strong>Bemerkungen:</strong></u><br />
  {$reservierungen[res].rs_remark}<br /><br />{/if}
  {if $reservierungen[res].rs_names}<u><strong>Teilnehmernamen:</strong></u><br />
  {$reservierungen[res].rs_names}<br /><br />{/if}</td>
		<td {if $sort==5}class="over"{/if}>{$reservierungen[res].rs_places}<br />
		  ({if $reservierungen[res].rs_has_invalid_coupons=="1"}<img src="gfx/messagebox_warning.gif" alt="Fehlerhafte Coupons eingegeben!" title="Fehlerhafte Coupons eingegeben!" />&nbsp;{/if}{$reservierungen[res].rs_coupon_nr})</td>
		<td {if $sort==6}class="over"{/if}>{if $reservierungen[res].rs_calc_send=="1"}<img src="gfx/checked.gif" alt="Rechnung verschickt am {$reservierungen[res].rs_calc_senddate_format}" title="Rechnung verschickt am {$reservierungen[res].rs_calc_senddate_format}" /><br />{$reservierungen[res].rs_invoice_nbr}{else}&nbsp;{/if}</td>
		<td {if $sort==7}class="over"{/if}>{if $reservierungen[res].rs_calc_paid=="1"}<img src="gfx/checked.gif" alt="Rechnung bezahlt am {$reservierungen[res].rs_calc_date_format}" title="Rechnung bezahlt am {$reservierungen[res].rs_calc_date_format}" />{else}&nbsp;{/if}</td>
		<td {if $sort==8}class="over"{/if}>{if $reservierungen[res].rs_participantinfos_send=="1"}<img src="gfx/checked.gif" alt="Tickets verschickt am {$reservierungen[res].rs_participantinfos_date_format}" title="Tickets verschickt am {$reservierungen[res].rs_participantinfos_date_format}" />{else}&nbsp;{/if}</td>
		<td {if $sort==9}class="over"{/if}>{if $reservierungen[res].rs_announceconfirm_send=="1"}<img src="gfx/checked.gif" alt="Auftragsbest&auml;tigung verschickt am {$reservierungen[res].rs_announceconfirm_senddate_format}" title="Auftragsbest&auml;tigung verschickt am {$reservierungen[res].rs_announceconfirm_senddate_format}" />{else}&nbsp;{/if}</td>
		<td {if $sort==10}class="over"{/if}>{if $reservierungen[res].rs_announceconfirm_recv=="1"}<img src="gfx/checked.gif" alt="Auftragsbest&auml;tigung erhalten am {$reservierungen[res].rs_announceconfirm_recvdate_format}" title="Auftragsbest&auml;tigung erhalten am {$reservierungen[res].rs_announceconfirm_recvdate_format}" />{else}&nbsp;{/if}</td>
	  </tr>
	  {sectionelse}
	  <tr>
		<td colspan="10" class="error">Keine passenden Eintr&auml;ge gefunden.</td>
	  </tr>
	  {/section}
	</table>
	<input name="action" type="hidden" id="action" value="view" />
	</form>
  {elseif $editmode=="multi"}
  {section name=date loop=$dates}
  <table width="{$tablewidth}"  border="0" cellspacing="0" cellpadding="0">
    <tr class="row1">
      <td>Geben Sie die Daten des neuen Eventtermines an und best&auml;tigen Sie danach mit &quot;Speichern&quot;. Eine Ver&ouml;ffentlichung im Internet erfolgt erst, wenn der Termin freigegeben wurde. Die Freigabe kann hier direkt bei der Erfassung  oder erst sp&auml;ter &uuml;ber den Men&uuml;punkt &quot;Termindaten &auml;ndern&quot; erfolgen. </td>
    </tr>
    <tr class="row2">
      <td><p>W&auml;hlen Sie den zugeh&ouml;rigen Venue:
		</p>
        <p>          
          <select name="place_id[{$dates[date].date_id}]" class="formfeld" id="place_id[{$dates[date].date_id}]">
            {html_options options=$places selected=$dates[date].place_id}
          </select> 
        </p></td>
    </tr>
    <tr class="row3">
      <td><p>Geben Sie Eventdatum und -uhrzeit an:</p>
      <p> {html_select_date_german all_extra='class="formfeld"' suffix=$dates[date].Date_Suffix selected_day=$dates[date].Date_Day selected_month=$dates[date].Date_Month selected_year=$dates[date].Date_Year field_order="DMY" start_year="-2" end_year="+3"} &nbsp;&nbsp;um&nbsp;&nbsp; {html_select_time_mod all_extra='class="formfeld"' suffix=$dates[date].Date_Suffix selected_hour=$dates[date].Time_Hour selected_minute=$dates[date].Time_Minute minute_interval=5 display_seconds=false} Uhr </p></td>
    </tr>
    <tr class="row2">
      <td><p>W&auml;hlen Sie die gew&uuml;nschte Eventart: </p>
      <p>
        <select name="training_id[{$dates[date].date_id}]" class="formfeld" id="training_id[{$dates[date].date_id}]">
		  {html_options options=$trainings selected=$dates[date].training_id}
        </select>
      </p></td>
    </tr>
    <tr class="row3">
      <td>Eventname: 
      <input name="eventname" type="text" class="formfeld" id="eventname" value="{$eventname}" />
	</td>
    </tr>
    <tr class="row2">
      <td>Zahl der verf&uuml;gbaren Tickets: 
      <input name="dt_capacity_max[{$dates[date].date_id}]" type="text" class="formfeld" id="dt_capacity_max[{$dates[date].date_id}]" value="{$dates[date].dt_capacity_max}" />
	  <span class="error">{validate id=$dates[date].val_dt_capacity_max message="<br />
	  Bitte geben Sie eine Zahl ein" halt="yes"}</span></td>
    </tr>
    <tr class="row3">
      <td><p>Freigabe im Internet:</p>
        <p><input type="radio" name="dt_frei[{$dates[date].date_id}]" value="j" {if $dates[date].dt_frei=="j"}checked="checked" {/if}/>
          ja
          <input type="radio" name="dt_frei[{$dates[date].date_id}]" value="b" {if $dates[date].dt_frei=="b"}checked="checked" {/if}/>
          beschr&auml;nkt
          <input name="dt_frei[{$dates[date].date_id}]" type="radio" value="n" {if $dates[date].dt_frei=="n"}checked="checked" {/if}/>
      nein</p>
        <span class="error">{validate id=$dates[date].val_dt_frei message="Bitte w&auml;hlen Sie eine Option" halt="yes"}</span></td>
    </tr>
    <tr class="row2">
      <td><input name="Submit" type="submit" class="formbutton" value="Speichern" />
      {if $dates[date].date_id}
      <input name="dates[{$dates[date].date_id}]" type="hidden" id="dates[{$dates[date].date_id}]" value="{$dates[date].date_id}" />
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
