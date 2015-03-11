<?php 

if($_POST['editgroups']) {
	$result = editGroups($_POST['editgroups']);
}

$grouplist = getGroups();

?>
<div class="content_centered" style="width:600px; padding-left:30px;">
	<h3>Abonnenten-Gruppen</h3>
	Abos können in Abonnenten-Gruppen verwaltet werden. Zum Beispiel kann bei einem Anmeldeformular auf der Webseite eine Gruppe angegeben werden in diese Abos gespeichert werden, und eine weitere Abonnentengruppe
	kann manuell hinzugefügte Abonnenten enthalten.<br><br>
	<form action="<?php echo $PHP_SELF ?>" method="post" name="edit" enctype="application/x-www-form-urlencoded">
		<table width="300">
			<tr>
			  <th width="151" height="19">Bezeichnung</th>
			  <th width="137">&nbsp;</th>
			</tr>
		<?php 
			if(is_array($grouplist)) {
			foreach($grouplist as $entry) { ?>
			<tr>
				<td width="151" height="19"><input type="text" style="width:190px;" name="editgroups[<?php echo $entry['id'] ?>][title]" value="<?php echo $entry['title'] ?>" /></td>
				<td width="137"><img src="/liquido/gfx/trashcan.gif" onclick="if(confirm('Gruppe <?php echo $entry['title'] ?> wirklich löschen?')) { document.location.href='?delgroup=<?php echo $entry['id'] ?>&page=abogroups.php'; }" class="hand" /></td>
			</tr>
			<?php } }?>
		</table>
		<input type="hidden" name="page" value="<?php echo $page ?>" />
		<input type="hidden" name="thispage" id="thispage" value="<?php echo $thispage ?>" />
	    <input type="submit" value="speichern" />
	</form>
      <p style="margin-top:30px;">
      <form name="form1" method="post" action="<?php echo $PHP_SELF ?>" enctype="application/x-www-form-urlencoded">
		<h3> Gruppe hinzuf&uuml;gen:</h3>
		Bezeichnung: 
		<input type="text" name="insertgroup[title]" id="insertgroup[title]" />
		<br/>
		<input type="submit" value="speichern" />
		<input type="hidden" name="y" id="y" value="<?php echo $y ?>" />
		<input type="hidden" name="page" value="<?php echo $page ?>" />
		<input type="hidden" name="thispage" id="thispage" value="<?php echo $thispage ?>" />
		<input type="hidden" name="update[id]" id="thispage" value="<?php echo $data['id'] ?>" />
      </form>
	  </p>
</div>