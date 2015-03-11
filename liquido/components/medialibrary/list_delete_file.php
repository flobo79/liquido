<?php 

$id = $_GET['id'];
$result = getObjectData($id);
$deleteresult = deleteFolder($_POST['deleteFolder']);

// form-action bestimmen
$formaction = $deleteresult['formfile'] ? $deleteresult['formfile'] : "list_delete.php?id=$id";

?> 
<form name="form1" method="post" action="<?php echo $formaction ?>">
  <table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tr> 
      <td width="25" valign="top"><p>&nbsp; </p></td>
      <td width="110" valign="top"><img src="gfx/file_big.gif" border="0"><br> 
        <br> <br>
       </td>
      <td width="257" valign="top"><p> 
<?php 
if(!$deleteresult['part']) $deleteresult['part'] = "start";
switch ($deleteresult['part']) {
	case "start":
?>
          <br>
          Soll die Datei<b> <?php echo $result['name'] ?></b> <br>
          wirklich gelöscht werden?<br>
          <br>
          Achtung! Das L&ouml;schen kann nicht r&uuml;ckg&auml;ngig gemacht werden</p>
        <p> 
          <input name="result" type="submit" id="result" value="  ja  ">
          <input name="deleteFolder[fncpart]" type="hidden" value="contents">
          <input name="deleteFolder[id]" type="hidden" value="<?php echo $id ?>">
        </p>

<?php  
		break;
	case "contents":
?>
          
        <p><br>
          Diese Datei hat folgende Verwendungen:<br>
        </p>
        <p>Ersatz ausw&auml;hlen</p>
        <p> 
          <input type="submit" name="result2" value="  ok  "> <input type="button" onclick="location.href='list_details.php?id=<?php echo $id ?>'" value="abbrechen" />
          <input name="deleteFolder[fncpart]" type="hidden" value="end">
          <input name="deleteFolder[id]" type="hidden" value="<?php echo $id ?>">
        </p>
        <p> 
<?php  
		break;
	case "end":
?>
          <br>
          Datei wurde gel&ouml;scht<span class="headline"> </span></p>
        <p> 
          <input type="submit" name="Submit" value="  ok  ">
          <input name="deleteFolder[fncpart]" type="hidden" value="end">
        </p>
<?php
		break;
}
?>
        </td>
		<td width="639" valign="top"><p><br>
          <?php echo $deleteresult['error'] ?>
		  </p>
		</td>
    </tr>
  </table>
</form>