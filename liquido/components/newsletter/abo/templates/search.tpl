{literal}
<script language="javascript" type="text/javascript" src="scripts.js"></script>
<script language="javascript" type="text/javascript">

	function delAbo (id) {
		if(confirm('Dieses Abonnement wirklich löschen?')) {
			{/literal}document.location.href='body.php?page=search.php&del='+id+'&thispage={$thispage}&y={$y}&setgroup={$setgroup}';{literal}
		};
	} 
</script>
{/literal}
<div class="content_centered">
  <h1>Abonnentenliste </h1>
  <form name="form1" id="aboform" method="post" action="body.php">
  
  <input type="hidden" name="setgroup" value="{$setgroup}" />
  <input type="hidden" name="thispage" value="{$thispage}" />
  <input type="hidden" name="y" value="{$y}" />
  <input type="hidden" name="search" value="{$search}" />
  
  <table width="98%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="25"><input name="checkbox" type="checkbox" value="checkbox" onclick="selectall();"></td>
      <td width="163" height="31"><strong>E-Mail</strong></td>
      <td width="206"><strong>Name</strong></td>
      <td width="299"><strong>Firma</strong></td>
      <td width="65">&nbsp;</td>
    </tr>
    {foreach from=$list item=entry}
    <tr bgcolor="{cycle values="#EFEFEF,#FFFFFF"}">
      <td><input type="checkbox" name="check[{$entry.id}]" id="c{$entry.id}" value="{$entry.id}"></td>
      <td>{$entry.email|truncate:20:"..":true}</td>
      <td>{$entry.Name|truncate:20:"..":true}</td>
      <td>{$entry.Firma|truncate:20:"..":true}</td>
      <td><a href="#" onclick="delAbo('{$entry.id}')" ><img src="gfx/rm_sm.gif"/></a><a href="body.php?page=edit.php&amp;abo={$entry.id}&thispage={$thispage}&y={$y}&setgroup={$setgroup}"><img src="gfx/edit_small.gif"/></a></td>
    </tr>
   {/foreach}
  </table>
  <p>
    <select style="display:none" name="action" onchange="comboaction(this[selectedIndex].value); this.selectedIndex=0">
      <option>markierte ...</option>
      <option value="delete"> l&ouml;schen</option>
      <option> &nbsp;Gruppe hinzuf&uuml;gen:</option>
      {foreach from=$groups item=group}
      <option value="addgroup_{$group.id}"> &nbsp;- {$group.title}</option>
      {/foreach}
    </select>
    <br/>
    <br/>
    Seite: {$thispage} | gehe zu Seite:
    {$selectpage}| Ergebnisse pro Seite: 
    {foreach from=$pagesperview item=entry}
	{if $y == $entry} <b>{$entry}</b>
	{else}
	<a href="body.php?page=search.php{if $search}&search={$search}{/if}&y={$entry}&setgroup={$setgroup}">{$entry}</a>
	{/if}
    {/foreach}
  </p>
</form>
</div>