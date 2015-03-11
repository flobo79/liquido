<?php 

$result = getObjectData($id);
$deleteFolder = $_POST['deleteFolder'];
$deleteresult = deleteFolder($deleteFolder);

// form-action bestimmen
$formaction = $deleteresult['formfile'] ? $deleteresult['formfile'] : "list_delete.php?id=$id";

?> 
<form name="form1" method="post" action="<?php echo $formaction ?>">
  <table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tr> 
      <td width="25" valign="top"><p>&nbsp; </p></td>
      <td width="65" valign="top"><img src="gfx/folder_big.gif" width="59" height="59"><br> 
        <br> <br>
        <br></td>
      <td width="275" valign="top"><p>
      	
<?php 	
if(!$deleteresult['part']) $deleteresult['part'] = "start";
switch ($deleteresult['part']) {
	case "start":
?>
          <br>
          Soll die Mappe <b><?php echo $result[name] ?></b> <br>
          wirklich gelöscht werden?<br>
          <br>
          Achtung! Das L&ouml;schen von Mappen kann nicht r&uuml;ckg&auml;ngig 
          gemacht werden</p>
        <p> 
          <input name="result" type="submit" id="result" value="  ja  ">  <input type="button" value="abbrechen" onclick="histpry.back();" />
          <input name="deleteFolder[fncpart]" type="hidden" value="contents">
          <input name="deleteFolder[id]" type="hidden" value="<?php echo $id ?>">
        </p>

<?php  
		break;
	case "contents":
?>
          <p><br>
          Diese Mappe enth&auml;lt:<br>
          <?php echo $result[folders] ?> Mappen<br>
          <?php echo $result[documents] ?> Dokumente</p>
        <p>Was soll mit diesen Inhalten geschehen?<br>
          <br>
          Inhalte verschieben nach:<br>
          <select name="deleteFolder[option]">
            <option value="">bitte ausw&auml;hlen</option>
            <option value="x">in den Hauptzweig</option>
            <?php 
					droplistFolder($id);
			?>
            <option value="">-------------------------</option>
            <option value="delete">alle Inhalte l&ouml;schen</option>
          </select>
        </p>
        <p> 
          <input type="submit" name="result2" value="  ok  ">
		  
          <input name="deleteFolder[fncpart]" type="hidden" value="end">
          <input name="deleteFolder[id]" type="hidden" value="<?php echo $id ?>">
        </p>
        <p> 
<?php  
		break;
	case "end":
?>
          <br>
          Mappe wurde gel&ouml;scht<span class="headline"> </span></p>
        <p> 
          
		  <input type="submit" name="submit" value="  ok  ">
          <input name="deleteFolder[fncpart]" type="hidden" value="end">
        </p>
<?php
		break;
}
?>
        </td>
		<td valign="top"><p><br>
          <?php echo $deleteresult['error'] ?>
		  </p>
		</td>
    </tr>
  </table>
</form>