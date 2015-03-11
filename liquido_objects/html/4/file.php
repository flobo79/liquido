<?php

// contents-template

$objecttitle = "Zeilenumbruch";

switch ($part) {
	case "compose":
		include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");
?>
      <input name="objectdata[<? echo $result['id']; ?>][type]" type="hidden" value="<?php echo $result['type']; ?>"> 
      <input name="objectdata[<? echo $result['id']; ?>][layout]" type="hidden" value="<?php echo $result['layout']; ?>">
<?php
		break;
	case "public":
?>
	<br>
<?php	break;
}
?>
