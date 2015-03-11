 <p>
 	<a href="#" onClick="parent.middle.location.href='body.php?setmode=detail&amp;file=overview'">Kampagnen</a><br>
	{foreach from=$issues item=issue}
	<a href="left_pane.php?select[id]={$issue.id}" onclick="parent.middle.location.href='body.php?&amp;select[id]={$issue.id}'"><b>{$issue.title}</b></a><br>
	{/foreach}
  </p>
<a href="body.php?setmode=trash" target="middle"><img src="{$LIQUIDO}/gfx/trashcan.gif" /> Papierkorb ({$trashitems})</a> 
