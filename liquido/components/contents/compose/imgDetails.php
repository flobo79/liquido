<img style="float:left; margin-right:15px;" src="<?php echo IMAGES."/".$data['cid']."/".$data['libid']."/thumbnail.jpg" ?>" width="200" />

<div id="imgdetails" style="float:left; width:270px; padding:10px;">
	<strong>Bildeigenschaften</strong><br>
	<form id="form_imgdetails">
		<table>
			<tr>
				<td>Beite: </td>
				<td><input type="text" value="<?php echo $size[0]; ?>" style="width:100px;" maxchars="3" name="width" /> Pixel</td>
			</tr>
			<tr>
				<td>Link: </td>
				<td><input type="text" id="link" value="<?php echo $data['link'] ?>" name="link"/><select onchange="$('link').value=this.value; this.selectedIndex=0;">
					<option value="">Link-Optionen</option>
					<option value="-">kein Link</option>
					<option value="popup">Bild als Popup</option>
				</select></td>
			</tr><tr>
				<td>Position: </td>
				<td><input type="radio" value="left" name="pos" <?php if($object['smalltext3'] == 'left' or !$object['smalltext3']) echo "checked"; ?> /> links  
				 <input type="radio" value="right" name="pos" <?php if($object['smalltext3'] == 'right') echo "checked"; ?>  /> rechts </td>
			</tr><tr>
				<td>Textabstand: </td>
				<td> <input type="text" value="<?php echo $object['text2']; ?>" style="width:100px;" maxchars="3" name="margin" /> Pixel</td>
				<input type="hidden" name="id" value="<?php echo $data['id']; ?>" id="imgid" />
				<input type="hidden" name="cid" value="<?php echo $data['cid']; ?>" id="cid" />
			</tr>
		</table>
	</form>
	<div class="button" onclick="updateImage();" style="display:inline; padding:3px; background-color:#FFF; border:1px solid #CCC; cursor:pointer; float:left; margin-right:5px;">Speichern</div>
	<div class="button" onclick="imgDetails.close();" style="display:inline; padding:3px; background-color:#FFF; border:1px solid #CCC; cursor:pointer; float:left; margin-right:5px;">Schliessen</div>
</div>
