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
    <th scope="col"><input name="checkallheader" type="checkbox" id="checkallheader" value="checkbox" onchange="Invers();" /></th>
    <th scope="col" {if $sort==0}class="highlight"{/if}><a href="?sort=0&type={if $sort==0}{$sorturladd}{else}1{/if}{$query}">Datum, Uhrzeit{if $sort==0}{$typeimg}{/if}</a></th>
    <th scope="col" {if $sort==1}class="highlight"{/if}><a href="?sort=1&type={if $sort==1}{$sorturladd}{else}0{/if}{$query}">Eventart{if $sort==1}{$typeimg}{/if}</a></th>
    <th scope="col" {if $sort==2}class="highlight"{/if}><a href="?sort=2&type={if $sort==2}{$sorturladd}{else}0{/if}{$query}">Venue{if $sort==2}{$typeimg}{/if}</a></th>
    <th align="center" scope="col">PDF</th>
    <th scope="col" {if $sort==3}class="highlight"{/if}><a href="?sort=3&type={if $sort==3}{$sorturladd}{else}0{/if}{$query}">Gebucht{if $sort==3}{$typeimg}{/if}</a></th>
  </tr>
  {section name=termin loop=$termine}
  <tr class="{cycle values="row1,row2"}">
    <td valign="top"><input name="datesheader[{$termine[termin].date_id}]" type="checkbox" id="datesheader[{$termine[termin].date_id}]" value="" /></td>
    <td valign="top" {if $sort==0}class="over"{/if}>{if $termine[termin].dt_frei == 0}<img src="gfx/dates_stat_red.gif" alt="nicht freigegeben" title="nicht freigegeben" />{elseif $termine[termin].dt_frei == 2}<img src="gfx/dates_stat_yellow.gif" alt="beschr&auml;nkt freigegeben" title="beschr&auml;nkt freigegeben" />{elseif $termine[termin].dt_frei == 1}<img src="gfx/dates_stat_green.gif" alt="freigegeben" title="freigegeben" />{/if} {$termine[termin].datum} {$termine[termin].uhrzeit}</td>
    <td valign="top" {if $sort==1}class="over"{/if}>{$termine[termin].tr_designation}
      {if $termine[termin].dt_fullreservation == 1}<br /><span class="error">ausgebucht</span>{/if}</td>
    <td valign="top" {if $sort==2}class="over"{/if}><strong>{$termine[termin].pl_name}</strong><br />
      {$termine[termin].pl_street}<br />
      {$termine[termin].pl_zipcode} {$termine[termin].pl_city}</td>
    <td align="center" valign="top"><a href="list_dates.php?action=export&type=pdf&id={$termine[termin].date_id}"><img src="gfx/pdf.gif" alt="Details als PDF exportieren" width="16" height="16" border="0" /></a></td>
    <td valign="top" {if $sort==3}class="over"{/if}>{if $termine[termin].bookedpercent <= 51}<img src="gfx/dates_stat_red.gif" />{elseif $termine[termin].bookedpercent < 90}<img src="gfx/dates_stat_yellow.gif" />{elseif $termine[termin].bookedpercent >= 90}<img src="gfx/dates_stat_green.gif" />{/if} {$termine[termin].bookedplaces} / {$termine[termin].dt_capacity_max}</td>
  </tr>
  {sectionelse}
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="error">Keine passenden Eintr&auml;ge gefunden.</td>
    </tr>
  {/section}
</table>
</div>
<form action="" method="post" name="{$formname}" class="borderless" id="{$formname}">
<table width="{$tablewidth}"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col"><input name="checkall" type="checkbox" id="checkall" value="checkbox" onchange="Invers();" /></th>
    <th scope="col" {if $sort==0}class="highlight"{/if}><a href="?sort=0&type={if $sort==0}{$sorturladd}{else}1{/if}{$query}">Datum, Uhrzeit{if $sort==0}{$typeimg}{/if}</a></th>
    <th scope="col" {if $sort==1}class="highlight"{/if}><a href="?sort=1&type={if $sort==1}{$sorturladd}{else}0{/if}{$query}">Eventart{if $sort==1}{$typeimg}{/if}</a></th>
    <th scope="col" {if $sort==2}class="highlight"{/if}><a href="?sort=2&type={if $sort==2}{$sorturladd}{else}0{/if}{$query}">Venue{if $sort==2}{$typeimg}{/if}</a></th>
    <th align="center" scope="col">PDF</th>
    <th scope="col" {if $sort==3}class="highlight"{/if}><a href="?sort=3&type={if $sort==3}{$sorturladd}{else}0{/if}{$query}">Gebucht{if $sort==3}{$typeimg}{/if}</a></th>
  </tr>
  {section name=termin loop=$termine}
  <tr class="{cycle values="row1,row2"}" ondblclick="javascript:location.href='list_dates.php?action=edit&id={$termine[termin].date_id}';">
    <td valign="top"><input name="dates[{$termine[termin].date_id}]" type="checkbox" id="dates[{$termine[termin].date_id}]" value="checkbox" /></td>
    <td valign="top" {if $sort==0}class="over"{/if}>{if $termine[termin].dt_frei == 0}<img src="gfx/dates_stat_red.gif" alt="nicht freigegeben" title="nicht freigegeben" />{elseif $termine[termin].dt_frei == 2}<img src="gfx/dates_stat_yellow.gif" alt="beschr&auml;nkt freigegeben" title="beschr&auml;nkt freigegeben" />{elseif $termine[termin].dt_frei == 1}<img src="gfx/dates_stat_green.gif" alt="freigegeben" title="freigegeben" />{/if} {$termine[termin].datum} {$termine[termin].uhrzeit}</td>
    <td valign="top" {if $sort==1}class="over"{/if}><strong>{$termine[termin].eventname} {if $termine[termin].eventdetails!=""}[<a target="newwindow" href="http://checkyou.de/index.php?page={$termine[termin].eventdetails}">?</a>]{/if}</strong><br />({$termine[termin].tr_designation})

      {if $termine[termin].dt_fullreservation == 1}<br /><span class="error">ausgebucht</span>{/if}</td>
    <td valign="top" {if $sort==2}class="over"{/if}><strong>{$termine[termin].pl_name}</strong><br />
      {$termine[termin].pl_street}<br />
      {$termine[termin].pl_zipcode} {$termine[termin].pl_city}</td>
    <td align="center" valign="top"><a href="list_dates.php?action=export&type=pdf&id={$termine[termin].date_id}"><img src="gfx/pdf.gif" alt="Details als PDF exportieren" width="16" height="16" border="0" /></a></td>
    <td valign="top" {if $sort==3}class="over"{/if}>{if $termine[termin].bookedpercent <= 51}<img src="gfx/dates_stat_red.gif" />{elseif $termine[termin].bookedpercent < 90}<img src="gfx/dates_stat_yellow.gif" />{elseif $termine[termin].bookedpercent >= 90}<img src="gfx/dates_stat_green.gif" />{/if} {$termine[termin].bookedplaces} / {$termine[termin].dt_capacity_max}</td>
  </tr>
  {sectionelse}
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="error">Keine passenden Eintr&auml;ge gefunden.</td>
    </tr>
  {/section}
</table>
<input name="action" type="hidden" id="action" value="view" />
</form>
{if false}
</body>
</html>
{/if}
