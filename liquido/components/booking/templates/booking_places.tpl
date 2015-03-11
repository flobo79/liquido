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
    <th scope="col"><input name="checkallplacesheader" type="checkbox" id="checkallplacesheader" value="checkbox" onchange="Invers();" /></th>
    <th scope="col" {if $sort==0}class="highlight"{/if}><a href="?sort=0&type={if $sort==0}{$sorturladd}{else}0{/if}{$query}">Bundesland{if $sort==0}{$typeimg}{/if}</a></th>
    <th scope="col" {if $sort==1}class="highlight"{/if}><a href="?sort=1&type={if $sort==1}{$sorturladd}{else}0{/if}{$query}">Venue{if $sort==1}{$typeimg}{/if}</a></th>
    <th scope="col" {if $sort==2}class="highlight"{/if}><a href="?sort=2&type={if $sort==2}{$sorturladd}{else}0{/if}{$query}">Adresse{if $sort==2}{$typeimg}{/if}</a></th>
    <th scope="col">&nbsp;</th>
  </tr>
  {section name=place loop=$places}
  <tr class="{cycle values="row1,row2"}" ondblclick="javascript:location.href='list_places.php?action=edit&id={$places[place].place_id}';">
    <td valign="top"><input name="placesheader[{$places[place].place_id}]" type="checkbox" id="placesplacesheader[{$places[place].place_id}]" value="checkbox" /></td>
    <td valign="top" {if $sort==0}class="over"{/if}>{$places[place].co_name}</td>
    <td valign="top" {if $sort==1}class="over"{/if}>{$places[place].pl_name}</td>
    <td valign="top" {if $sort==2}class="over"{/if}>{$places[place].pl_street}<br />
      {$places[place].pl_zipcode} {$places[place].pl_city}</td>
    <td>&nbsp;</td>
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
    <th scope="col" {if $sort==0}class="highlight"{/if}><a href="?sort=0&type={if $sort==0}{$sorturladd}{else}0{/if}{$query}">Bundesland{if $sort==0}{$typeimg}{/if}</a></th>
    <th scope="col" {if $sort==1}class="highlight"{/if}><a href="?sort=1&type={if $sort==1}{$sorturladd}{else}0{/if}{$query}">Venue{if $sort==1}{$typeimg}{/if}</a></th>
    <th scope="col" {if $sort==2}class="highlight"{/if}><a href="?sort=2&type={if $sort==2}{$sorturladd}{else}0{/if}{$query}">Adresse{if $sort==2}{$typeimg}{/if}</a></th>
    <th scope="col">&nbsp;</th>
  </tr>
  {section name=place loop=$places}
  <tr class="{cycle values="row1,row2"}" ondblclick="javascript:location.href='list_places.php?action=edit&id={$places[place].place_id}';">
    <td valign="top"><input name="places[{$places[place].place_id}]" type="checkbox" id="places[{$places[place].place_id}]" value="checkbox" /></td>
    <td valign="top" {if $sort==0}class="over"{/if}>{$places[place].co_name}</td>
    <td valign="top" {if $sort==1}class="over"{/if}>{$places[place].pl_name}</td>
    <td valign="top" {if $sort==2}class="over"{/if}>{$places[place].pl_street}<br />
      {$places[place].pl_zipcode} {$places[place].pl_city}</td>
    <td>&nbsp;</td>
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