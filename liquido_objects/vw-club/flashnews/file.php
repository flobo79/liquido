<?php

// contents-template
$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];


// contents-template
$objecttitle = "Flash-News";
$object_head_right = "<div class=\"bu_add\" onclick=\"mediabrowser.open();\"></div>";


// optionsmenue hinzuladen
if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

switch ($part) {
	case "compose":
?>
<div class="object" >
	<div style="width:200px; border:1px solid #CCC; ">
		Titel: 
		  <br />
		  <input name="objectdata[<?php echo $result['id'] ?>][text]" type="text" value="<?php echo $result['text'] ?>" size="30" />
		  <br />
		Bild:  <br />
			<div class="imgbox" id="imgbox<?php echo $result['id'] ?>" style="width:100%; float:none; clear:both;">
				<?php if($pictures[0]) {  echo $pictures[0]; } ?>
			</div>
		  <input name="imageupload" type="hidden" value="<?php echo $result['id']; ?>" />
		
		  <input name="objectdata[<?php echo $result['id']; ?>][tnwidth]" type="hidden" id="objectdata[<?php echo $result['id']; ?>][tnwidth]" value="181" size="4" maxlength="4" />
		 <br />
		 <br />
		Datum:<br />
		  <input name="objectdata[<?php echo $result['id'] ?>][text3]" type="text" value="<?php echo $result['text3'] ?>" size="30" />
		  <br />
		  <br />
		  Headline: <br />
		  <input name="objectdata[<?php echo $result['id'] ?>][smalltext2]" type="text" value="<?php echo $result['smalltext2'] ?>" size="30" />
		  <br />
		  <br />
		  Text: <br />
		  <textarea name="objectdata[<?php echo $result['id'] ?>][smalltext3]" cols="30"><?php echo $result['smalltext3'] ?></textarea>
		  <br />
		  <br />
		  Textlink:<br />
		  <input name="objectdata[<?php echo $result['id'] ?>][smalltext1]" type="text" value="<?php echo $result['smalltext1'] ?>" size="30" />
		  <br />
		  <br />
	  </div>
</div>

<?php 
	break;
	case "public":
?>
<div >
<?php echo $result['text']; ?><br />
<br />
<?php if($pictures[0]) { echo $pictures[0]; } ?><br />

<?php echo $result['text3']; ?><br />
<?php echo $result['smalltext2']; ?><br />
<a href="<?php echo $result['smalltext1']; ?>"><?php echo $result['smalltext3']; ?></a><br />


</div>
<?php	break;
	}
unset($marginxy,$side);
?>

