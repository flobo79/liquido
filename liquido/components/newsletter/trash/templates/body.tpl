<div class="content_centered">
<form name="form1" method="post" action="trash.php">
  <table width="320" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="60"><img src="../../gfx/trashcan_big.gif" width="44" height="48"></td>
      <td width="260" class="headline"><br>
        Gel&ouml;schte Objekte</td>
    </tr>
  </table>
  <br>
  <table width="320" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="71" align="center" valign="middle"><img src="gfx/group.gif" width="32" height="34"></td>
      <td width="249"> Kampagnen</td>
    </tr>
    <tr> 
      <td width="71" align="center" valign="middle">&nbsp;</td>
      <td width="249">
	  	{foreach from=$trash.contents item=entry}
        <input type="checkbox" name="trash[contents][{$entry.id}]" value="{$entry.id}" />{$entry.title} <br/>
     	{/foreach}
	  </td>
    </tr>
  </table>
  <br/>
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="71" align="center" valign="middle"><img src="gfx/object.gif" width="32" height="20"></td>
      <td width=""> Objekte</td>
    </tr>
    <tr> 
      <td width="71" align="center" valign="middle">&nbsp;</td>
      <td width="">
       	{foreach from=$trash.objects item=entry}
		<input type="checkbox" name="trash[contentobjects][{$entry.id}]" value="{$entry.id}"> <span >{$entry.title} ({$entry.parent})</span><br/>
      	{/foreach}
	  </td>
    </tr>
  </table>
  <br>
  <table width="321" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="71" align="center" valign="middle">&nbsp;</td>
      <td width="250">
	  	<a href="#" onClick="javascript:recycle();">wiederherstellen</a>&nbsp;&nbsp;&nbsp; 
        <a href="#" onClick="javascript:del();">l&ouml;schen</a>
        <input name="type" type="hidden" id="type" value=""></td>
    </tr>
  </table>
  </form>
</div>