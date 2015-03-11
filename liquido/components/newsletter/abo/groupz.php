<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="20" height="325"></td>
    <td><p class="headline"><br>
        Abonnenten-Gruppen</p>
      <p> 
        <table width="300" border="0" cellspacing="0" cellpadding="0">
		  
          <td width="27" height="19">id</td>
          <td width="157">Bezeichnung</td>
          <td width="116">&nbsp;</td>
		</tr>
  <?php $grouplist = getGroups();
  		if(is_array($grouplist)) {
		foreach($grouplist as $entry) { ?>
		<tr>
			<td width="27" height="19"><?php echo $entry['id'] ?></td>
          <td width="157"><?php echo $entry['title'] ?></td>
          <td width="116"><a href="?delgroup=<?php echo $entry[id] ?>&page=groupz.php">l&ouml;schen</a></td>
		</tr>
		<?php } }?>
		
</table>
      </p>
      <p>&nbsp;</p>
      <form name="form1" method="post" action="">
        <p class="headline"> Gruppe hinzuf&uuml;gen:</p>
          Bezeichnung: 
          <input name="insertgroup[title]" type="text" id="insertgroup[title]">
          <input name="imageField" type="image" src="gfx/save.gif" border="0">
          <input name="y" type="hidden" id="y" value="<?php echo $y ?>">
		  <input name="page" type="hidden" value="<?php echo $page ?>">
          <input name="thispage" type="hidden" id="thispage" value="<?php echo $thispage ?>">
          <input name="update[id]" type="hidden" id="thispage" value="<?php echo $data['id'] ?>">
      </form>
      <p>&nbsp;</p></td>
  </tr>
</table>
