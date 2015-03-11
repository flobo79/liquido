<script language="javascript" type="text/javascript" src="abo/scripts.js"></script>
<a href="#" onclick="reloadlist();">Alle Gruppen</a><br/>
{foreach from=$groups item=group}
<a href="#" onclick="selectgroup({$group.id})">{$group.title}</a><br/>
{/foreach}
<br/>
<br/>
<a href="#" onclick="parent.middle.document.location.href='body.php?page=groupz.php'">Gruppen bearbeiten</a><br><br/>
Abonnenten:<br>
<a href="#" onclick="parent.middle.document.location.href='body.php?page=insert.php'">Hinzuf&uuml;gen</a><br/>
<a href="#" onclick="parent.middle.document.location.href='body.php?page=remove.php'">L&ouml;schen</a><br/>
<a href="#" onclick="parent.middle.document.location.href='body.php?page=import.php'">Importieren</a><br/>
<a href="#" onclick="parent.middle.document.location.href='body.php?page=export.php'">Exportieren</a><br/>
  