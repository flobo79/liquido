<div class="content_centered">
  <table width="390" border="0" cellspacing="0" cellpadding="0">
	<tr class="smalltext">
	  <td height="24" width="263" valign="top">Ausgabe</td>
	  <td width="127" valign="top">Status</td>
	</tr>
	{foreach from=$redactions key=key item=tf}
	<tr class="{cycle values="row1,row2"}"> 
	  <td><a href="body.php?select[id]={$tf.id}"><b>{$tf.title}</b></a></td>
	  <td>{$stati[$tf.status]}</td>
	</tr>
	{/foreach}
    </table>
</div>