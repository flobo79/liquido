<?php 
require(dirname(dirname(__FILE__))."/lang.inc.php");
$lng = $lng['de_DE'];


if($update = $_POST['update']) 	$updateresult = updateabo($update);




$update = $db->con->getRow("select * from ".$cfg['tables']['nlabos']." where id ='$abo' LIMIT 1");
$fields = array("form","firstname","name","email","company");
$areas = getAreas();


?>
<div class="content_centered">
	<h1>Abonnenten bearbeiten</h1>
	<form name="form1" method="post" action="<?php echo $PHP_SELF ?>">
		<table width="516" border="0" cellspacing="0" cellpadding="0">
		  <?php
			
			
			foreach($fields as $name) {
			?>
			<tr>
				<td height="25"><?php echo $lng[$name] ?>:</td>
				<td><input name="update[<?php echo $name ?>]" type="text" value="<?php echo $update[$name] ?>" size="25" /></td>
				<td><?php echo $updateresult[$name] ?></td> 
			</tr>
			<?php 
			}
			$i++;
		
			// schneide komma bei den fields ab
			$insert['fields'] = substr($insert['fields'],0,-1);
			
			?>
		  <tr>
			<td height="25" valign="top">&nbsp;</td>
			<td width="287" valign="bottom">&nbsp;</td>
			<td width="108" valign="bottom">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="25" valign="top">Bereiche:</td>
			<td valign="bottom"> 
			  <?php 
			
				$update['check'] = explode(";",$update['mp']); 
				foreach($update['check'] as $value) $setareas[$value] = "1";
				
				foreach($areas as $key => $value) {
					$entry = $value['area'];
					$checked = $setareas[$entry['id']] ? "checked" : "";
					echo "<input type=\"checkbox\" name=\"update[check][$entry[id]]\" value=\"1\" $checked >".$entry['title']."<br>\n";
				}
			?>
			</td>
			<td valign="bottom">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="25" valign="top">&nbsp;</td>
			<td valign="bottom">&nbsp;</td>
			<td valign="bottom">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="25" valign="top">Gruppen:</td>
			<td valign="bottom"> 
			  <?php 
			$groups = getgroups();
			if(is_array($groups)) {
				$update['group'] = explode(";",$update['group']); 
				foreach($update['group'] as $value) $setgroups[$value] = "1";
				
				foreach($groups as $key => $value) {
					$checked = $setgroups[$value['id']] ? "checked" : "";
					echo "<input type=\"checkbox\" name=\"update[group][".$value['id']."]\" value=\"1\" $checked >".$value['title']."<br>\n";
				}
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
			<td width="121" height="25">&nbsp;</td>
			<td valign="bottom" colspan="2"><input name="imageField" type="image" src="gfx/save.gif" border="0" class="hand"> <br>
			<br><?php if($updateresult['ok']) { ?>Änderungen gespeichert<?php } ?></td>
		  </tr>
		</table>
		<p> 
		  <input name="page" type="hidden" value="edit.php">
		  <input name="abo" type="hidden" value="<?php echo $update['id'] ?>">
		  <input name="y" type="hidden" value="<?php echo $y ?>">
		  <input name="thispage" type="hidden" value="<?php echo $thispage ?>">
		  <input name="update[id]" type="hidden" value="<?php echo $update['id'] ?>">
		</p>
	  </form>
</div>