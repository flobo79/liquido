<? 
$result = getObjectData($id); 
?>
	<form name="form1" method="post" action="list_details.php?id=<?php echo $id ?>">
		
  <table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td width="25" valign="top">&nbsp;</td>
      <td width="110" valign="top"><p> <img src="gfx/file_big.gif"><br>
          <br>
          <br>
          [<a href="list_details.php?id=<?php echo $id ?>" onClick="submit(); return false">zur&uuml;ck</a>] 
          <br>
        </p></td>
      <td width="275" valign="top"> <input name="editDocument[name]" type="text" id="editDocument[name]" value="<?php echo $result[name] ?>" size="32" class="headline"> 
        <p> 
          <textarea name="editDocument[info]" cols="35" id="editDocument[info]" class="text"><?php echo $result[info] ?></textarea>
          <input name="editDocument[id]" type="hidden" id="editDocument[id]" value="<?php echo $id ?>">
          <input name="editDocument[parent]" type="hidden" id="editDocument[id]" value="<?php echo $result[parent] ?>">
        </p>
        <p> Datei befindet sich in:<br>
          <select name="editDocument[newparent]">
            <option value=""></option>
            <option value="x">der Bibliothek</option>
            <?php 
				droplistFolder($id);
			?>
          </select>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="Submit" value="speichern">
          <span class="headline"> </span></p></td>
      <td valign="top"><p> <br>
          <span class="headline"> </span></p>
        <p>&nbsp; </p></td>
    </tr>
  </table>
	  </form>