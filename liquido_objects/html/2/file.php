<?php

// contents-template

$objecttitle = "Anker:";

switch ($part) {
	case "compose":
		include("$cfgcmspath/components/contents/compose/templates/object_head.php");
?>
<table width="<?php echo $contentwidth ?>" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr> 
    <td><img src="../../components/contents/gfx/anchor.gif"> 
      <input name="objectdata[<? echo $result[id]; ?>][text]" type="text" class="text" value="<?php echo $result[text]; ?>" size="30"> 
      <input name="objectdata[<? echo $result[id]; ?>][type]" type="hidden" value="<?php echo $result[type]; ?>"> 
      <input name="objectdata[<? echo $result[id]; ?>][layout]" type="hidden" value="<?php echo $result[layout]; ?>"></td>
  </tr>
</table>

<?php	break;
	case "public":
?>
	<a name="<?php echo $result['text']; ?>"></a>
<?php	break;
}
?>
