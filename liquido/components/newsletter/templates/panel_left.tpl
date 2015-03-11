<script language="javascript" type="text/javascript" src="abo/scripts.js"></script>
<p>
	<a href="#" style="font-size:13px;" onClick="parent.middle.location.href='body.php?setmode=detail&amp;file=overview'"><strong> Alle Kampagnen</strong></a><br>
</p>
<p>  <strong>Abonnenten</strong><br>
  <a href="#" onclick="selectgroup('');">Alle Gruppen</a><br/>
{foreach from=$groups item=group}
<a href="#" onclick="selectgroup({$group.id})">{$group.title}</a><br/>
{/foreach}
<br/>
<a href="#" onclick="parent.middle.document.location.href='body.php?setmode=abo&amp;page=insert.php'">einf&uuml;gen</a><br/>
<a href="#" onclick="parent.middle.document.location.href='body.php?setmode=abo&amp;page=remove.php'">l&ouml;schen</a><br/>
<a href="#" onclick="parent.middle.document.location.href='body.php?setmode=abo&amp;page=import.php'">importieren</a><br/>
<br/>
<a href="#" onclick="parent.middle.document.location.href='body.php?setmode=abo&amp;page=abogroups.php'">Gruppen
bearbeiten</a><br/>
<a href="#" onClick="parent.middle.document.location.href='bounce/uebersicht.php'">R&uuml;ckl&auml;ufer
bearbeiten</a></p>
<p>
	<a href="body.php?setmode=trash" target="middle" onclick="parent.right.location.href='panel_right.php?setmode=trash'"><img src="{$LIQUIDO}/gfx/trashcan.gif" name="trashcan" alt="(U)" /> Papierkorb ({$trashitems})</a> 
</p>
<br/>
