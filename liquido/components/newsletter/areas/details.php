<div class="content_centered">
<form action="<?php echo $PHP_SELF ?>" method="post" name="properties">
	<p>
		<strong>Bereich bearbeiten </strong>
	</p>
	<p>Titel:<br/>
		<input name="edit[title]" type="text" value="<?php echo $data['title']; ?>" size="30" maxlength="25" class="text" /> 
	</p>          
	<p>Info:<br/>  
		<textarea name="edit[info]" cols="40" rows="5" class="text"><?php echo $data['info']; ?></textarea>
	</p>
	Aktiv:
	<input type="checkbox" name="edit[status]" value="1" <?php if($data['status']) echo "checked" ?> />
	<input name="thisarea" type="hidden" id="thisarea" value="<?php echo $thisarea ?>" /><br/>
	<br/> 
	<?php if ($access['c5']) { ?>
		<input type="submit" value="Speichern" /> 
	<?php } ?>
	<?php if ($access['c3']) { ?>
		<input type="button" onclick="part('delete','');" value="Bereich löschen" />
	<?php } ?>
	<input type="button" onclick="document.location.href='body.php?setmode=areas'" value="Zurück" />
</form>

<?php if ($access['c3']) { ?>
	<div id="delete" class="hidden"> 
		<form action="<?php echo $PHP_SELF ?>" method="post" name="delform">
		  <p><strong>Diesen Bereich wirklich l&ouml;schen? </strong></p>
		  <p>Vorsicht, das L&ouml;schen kann nicht r&uuml;ckg&auml;ngig gemacht werden.
	        <input name="delarea" type="hidden" value="<?php echo $data['id']; ?>" />
		    <br>
		    <br>
		    <input name="submit" type="button" value=" ja löschen " />
	            </p>
		</form>
	</div>
<?php } ?>
</div>