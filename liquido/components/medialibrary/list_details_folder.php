

<div style="float:left; width:100px; margin-left:20px;"><img src="gfx/folder_big.gif" alt="folder" /></div>
  <div style="float:left; width:275px;">
  	<span class="headline"><?php echo $result['name'] ?></span>
      <p> <?php echo $result['info'] ?> </p>
      <p>&nbsp;</p>
      <p>erstellt: <?php echo $result['date'] ?><br>
      <p>
      	<?php if($access['c2']) { ?><input type="button" name="cancel" value="bearbeiten" onclick="document.location.href='list_edit.php?id=<?php echo $id ?>'" />
       <?php } ?>
        <?php if($access['c3']) { ?><input type="button" name="cancel" value="löschen" onclick="document.location.href='list_delete.php?id=<?php echo $id ?>'" /><?php } ?><br>
      </p>
</div>
<div style="float:left; width:200px;">
      <span class="headline"> Inhalt</span> <br> <p>enth&auml;lt:<br>
        <?php echo $result['folders'] ?> Mappen<br>
        <?php echo $result['documents'] ?> Dokumente </p>
      <?php if($access['c4']) { ?>
      <table width="199" border="0" cellspacing="0" cellpadding="0" class="hand">
        <tr onclick="location.href='list_uploadwindow.php?id=<?php echo $id ?>'"> 
          <td width="35" height="25" align="center" valign="top"><img src="gfx/upload_small.gif"></td>
          <td width="164">Datei-upload</td>
        </tr>
      </table>

      <br>
      <table width="199" border="0" cellspacing="0" cellpadding="0" class="hand">
        <tr onclick="location.href='list_ftp_window.php?id=<?php echo $id ?>'"> 
          <td width="36" height="25" align="center" valign="top"><img src="gfx/upload_folder.gif" width="28" height="27"></td>
          <td width="163">Verzeichnis importieren</td>
        </tr>
      </table>
      <?php } ?>
</div>
<div style="float:left;">
	<span class="headline">Automatisieren</span>
      <p>
	  	<?php 
	  	$batches = listBatches();
		if ($batches) {
			foreach($batches as $key => $val) {
				echo "<a href=\"batch/".$val['file']."?id=$id&type=folder\">".$val['title']."</a><br>\n";
			}
		}		
		?>	
	  </p>
</div>