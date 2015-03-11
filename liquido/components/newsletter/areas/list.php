<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
//-->
</script>
<div class="content_centered" style="width:500px;padding-left:30px;">
<h3>Inhaltsbereiche</h3>
Newsletter können in Bereiche unterteilt werden, die von den Abonnenten einzeln ausgewählt werden können, um so individuelle und speziell
auf die Interessen zugeschnittenen Newsletter versenden zu erhalten. Erstellen Sie hier die Bereiche die Sie zur Auswahl anbieten möchten.
<br>
<br>
<p><strong>Vorhandene Bereiche </strong>
    <table width="500" border="0" cellspacing="0" cellpadding="0">
    	<tr>
          <th width="196">Bezeichnung</th>
          <th width="108">Status</th>
          <th width="150">Info</th>
        </tr>
<?php 
	$areas = getareas();
	if(is_array($areas)) {
		foreach($areas as $key => $value) {
			$entry = $value['area'];
		?>
      </p>
        <tr>
          <td width="196"><a href="?setmode=areas&thisarea=<?php echo $entry['id'] ?>"><?php echo $entry['title'] ?></a></td>
          <td width="108"><?php echo $entry['status'] ? 'aktiv' : 'inaktiv'; ?></td>
          <td width="150"><?php echo $entry['info'] ?></td>
        </tr>
      <p>
        <?php } } ?>
	  </table>
      <br>
	  </p>
    <a href="#" onclick="part('new');">+ Bereich erstellen</a>
      <?php if ($access['c1']) { ?>
    <div id="new" class="optionbox" style="width:300px; display:none;">
	<br>
      <form action="body.php" method="post" name="form_newpage" id="new_form">
        <fieldset>
        	<legend>Neuen Bereich erstellen</legend> 
          Bezeichnung:
          <input name="insert[title]" type="text" size="25" /><br /> <br /> 
		  <p>Info:<br/>  
			<textarea name="insert[info]" cols="40" rows="5" class="text"></textarea>
		</p>
		Aktiv:
			<input type="checkbox" name="insert[status]" value="1" /><br><br>
          <input type="submit" value="speichern" /> <input type="button" onclick="part('new');" value="abbrechen" />
		  </fieldset>
      </form>
    </div>
    <?php } ?>
</div>