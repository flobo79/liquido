<?
$result = getObjectData($id);
$imagesize = GetImageSize("../../../../".$cfgcmslibdir.$id."/original.jpg");
?>
<script language="JavaScript">
<!--
	function selectImage() {
		parent.head.selectImage('<?php echo $id ?>',document.form1.lossless.value,document.form1.tnwidth.value);
	}
	

-->
</script>

 <form name="form1" method="post" action="selectImage.php" target="_top">
  <table width="493" border="0" cellpadding="1" cellspacing="2">
    <tr> 
      <td width="10" valign="top"></td>
      <td width="110" valign="top"><p><a href="#" onClick="MM_openBrWindow('pic_popup.php?pic=<?php echo $cfgcmspath."/".$cfgcmslibdir.$id."/original.jpg" ?>','picpopup','width=<?php echo $imagesize[0] ?>,height=<?php echo $imagesize[1] ?>')"><img src="../../../../<?php echo $cfgcmslibdir.$id?>/small.jpg" border="0"></a><br>
          <br>
          <br>
          <br>
      </td>
      <td width="174" valign="top"><p> <span class="headline"> <?php echo $result['name'] ?></span></p>
        <p> <?php echo $result['info'] ?> </p>
        <p>erstellt: <?php echo $result['date'] ?><br>
          ge&auml;ndert: <?php echo $result['changed'] ?> <br>
          <br>
        </p></td>
      <td width="181" valign="top"><p><span class="headline">Optionen</span> <br>
        <br>
          <input name="lossless" type="checkbox" id="lossless" value="1" <?php if($cfg['components']['medialib']['lossless']) echo "checked" ?>>
          verlustfrei          <br>
          (gr&ouml;ssere Datenmenge) </p>
        <p>Bildbreite: 
        <input name="tnwidth" type="text" id="tnwidth" value="<?php echo $cfg['components']['contents']['compose']['picwidth'];  ?>" size="4" maxlength="4">
       
		</p>
        <p> <a href="#" onClick="selectImage();">&raquo; Bild einf&uuml;gen </a> </p></td>
    </tr>
  </table>
</form>
