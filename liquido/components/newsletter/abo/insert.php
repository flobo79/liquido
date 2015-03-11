<?php
global $lng;
if($insert = $_POST['insert']) 		$insertresult 	= insertabo($insert);
if($insertresult['ok']) unset($insert);

$fields = array("form","firstname","name","email","company");

$groups = getgroups();
$areas = getAreas();
include(dirname(dirname(__FILE__))."/lang.inc.php");
$lng = $lng['de_DE'];
?>
<div class="content_centered">
	<h1>Abonnenten einpflegen</h1>
  <form name="form1" method="post" action="<?php echo $PHP_SELF ?>">
	<table border="0" cellspacing="0" cellpadding="0">
	<?php	foreach($fields as $name) { ?>
		<tr>
			<td height="25"><?php echo $lng[$name] ?>:</td>
			<td><input name="insert[<?php echo $name ?>]" type="text" value="<?php echo $insert[$name] ?>" size="25" /></td>
			<td><?php echo $insertresult[$name] ?></td> 
		</tr>
		<?php } ?>
	    <tr>
	      <td height="25" valign="top">&nbsp;</td>
	      <td valign="bottom">&nbsp;</td>
	      <td valign="bottom">&nbsp;</td>
      </tr>
      <tr> 
		<td height="25" valign="top">Bereiche:</td>
		<td valign="bottom"> 
		<?php 
		foreach($areas as $key => $value) {
			$entry = $value['area'];
			$checked = $insert['check'][$entry['id']] ? "checked" : "";
			echo "<input type=\"checkbox\" name=\"insert[check][$entry[id]]\" value=\"1\" $checked >".$entry['title']."<br>\n";
		}
		?>
		</td>
		<td valign="bottom">&nbsp;</td>
	  </tr>
	  <tr> 
		<td height="25">&nbsp;</td>
		<td valign="bottom">&nbsp;</td>
		<td valign="bottom">&nbsp;</td>
	  </tr>
	  <tr> 
		<td height="25" valign="top">in Gruppe</td>
		<td valign="bottom"> 
		<?php 
			foreach($groups as $key => $value) {
				$checked = $insert['group'][$value['id']] ? "checked" : "";
				echo "<input type=\"checkbox\" name=\"insert[group][".$value['id']."]\" value=\"1\" $checked >".$value['title']."<br>\n";
			}
		?>
		</td>
		<td valign="bottom">&nbsp;</td>
	  </tr>
	  <tr> 
		<td height="25">&nbsp;</td>
		<td valign="bottom">&nbsp;</td>
		<td valign="bottom">&nbsp;</td>
	  </tr>
	  <tr> 
		<td width="104" height="25">&nbsp;</td>
		<td width="188" valign="bottom">
			<input type="submit" value="speichern" /> 
		</td>
		<td width="224" valign="bottom"><?php if($insertresult['ok']) { ?>Abonnent gespeichert<?php } ?></td>
	  </tr>
	</table>
	<p> 
		<input name="page" type="hidden" id="file" value="insert.php">
	</p>
  </form>
</div>