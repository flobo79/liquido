<?php

//if(file_exists($_SERVER['DOCUMENT_ROOT'].MEDIALIB."/".$result['id']."/original.jpg")) {
	//$imagesize = @getimagesize($_SERVER['DOCUMENT_ROOT'].MEDIALIB."/".$result['id']."/original.jpg");
//}


$id = $_GET['id'];

if($_GET['reprint']) {
	reprint($result);
	updateColumnChilds($id);
}


?>

<div style="float:left; margin-left:20px;">
	<img src="<?php echo MEDIALIB."/".$result['id']; ?>/small.jpg" alt="bild" /><br />
	<?php if($access['c8x']) { ?>
	<a href="list_functions_picture.php?id=<?php echo $id ?>">Bild bearbeiten</a> 
	<?php } ?>
</div>

<div style="float:left; width:275px; margin-left:15px;">
  <span class="headline"><?php echo $result['name'] ?></span><br />
	Bildnummer: <?php echo $result['id'] ?><br />
  	<?php echo $result['info'] ?> <br /> <br />
  	erstellt: <?php echo $result['date'] ?><br />
	<br />
	<br />
	<?php if($access['c5']) { ?>
	<input type="button" onclick="location.href='list_delete.php?id=<?php echo $id ?>'" value="löschen" />
	
	<?php } ?>
	<?php if($access['c6']) { ?>
	<input type="button" onclick="location.href='list_edit.php?id=<?php echo $id ?>'" value="bearbeiten" />
	
	<?php } ?>
	<?php if($access['c7']) { ?>
	<input type="button" onclick="location.href='list_details.php?id=<?php echo $id ?>&amp;reprint=1'" value="Abzug erstellen" />
	
	<?php } ?>
</div>

<div style="float:left;">
	<span class="headline">Variationen:</span>
	<?php listVariations($result['id']); ?>
</div>
