
	<form name="form1" method="post" action="list_details.php?id=<?php echo $id ?>">
		<table width="100%" border="0" cellpadding="1" cellspacing="0">
          <tr>
            <td width="25" valign="top">&nbsp;</td>
            <td width="65" valign="top"><p> <img src="gfx/folder_big.gif" width="59" height="59"><br>
                <br>
                <br>
                
                <br>
              </p></td>
            <td width="275" valign="top"><br> 
                <input name="editFolder[name]" type="text" id="editFolder[name]" value="<?php echo $result['name'] ?>" size="32" class="headline">
              <p> 
                <textarea name="editFolder[info]" cols="35" id="editFolder[info]" class="text"><?php echo $result['info'] ?></textarea>
                <input name="editFolder[id]" type="hidden" id="editFolder[id]" value="<?php echo $id ?>">
              </p>
              
        <p> Mappe befindet sich in:<br>
          <select name="editFolder[parent]">
            <option value="290779">im Hauptzweig</option>
            <?php 
				droplistFolder($result['id'],$result['parent']);
			?>
          </select>
          <br><br>
          <input type="submit" name="Submit" value="speichern"> <input type="button" name="cacnel" value="abbrechen" onclick='history.back();'>
          <span class="headline"> </span></p></td>
            <td valign="top"><p> <br>
          <span class="headline"> Inhalt</span> <br>
        </p>
        <p>enth&auml;lt:<br>
          <?php echo $result['folders'] ?> Mappen<br>
          <?php echo $result['documents'] ?> Dokumente </p>
      <p>&nbsp; </p>
              </td>
          </tr>
        </table>
	  </form>