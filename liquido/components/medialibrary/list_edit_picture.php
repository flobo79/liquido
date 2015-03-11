<form name="form1" method="post" action="list_details.php?id=<?php echo $id ?>">
  <div style="float:left; margin-left:20px;"> <img src="<?php echo MEDIALIB."/".$result['id']; ?>/small.jpg" alt="bild" /></div>
  <div style="float:left; margin-left:15px;">
  	<input name="editDocument[name]" type="text" id="editDocument[name]" value="<?php echo $result['name'] ?>" size="32" class="headline"> 
        <p> 
          <textarea name="editDocument[info]" cols="35" id="editDocument[info]" class="text"><?php echo $result['info'] ?></textarea>
          <input name="editDocument[id]" type="hidden" id="editDocument[id]" value="<?php echo intval($id); ?>">
        </p>
        <p> Bild befindet sich in:<br>
          <select name="editDocument[parent]">
            <option value=""></option>
            <option value="x">der Bibliothek</option>
            <?php 
				droplistFolder($result['id'],$result['parent']);
			?>
          </select>
          <br />
          <br /> 
          <input type="submit" name="Submit" value="speichern" />
          <input type="button" name="cancel" value="abbrechen" onclick="document.location.href='list_details.php?id=<?php echo $result['id'] ?>'" />
        </p>
	</div>
</form>