<?php


$objecttitle = "Händler Angebot";
$thisobject['formrows'] = "5";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "text";
$thisobject['textwidth'] = $contentwidth - $size[0] - $result['text2'];

$mail['to'] = $result['smalltext3'];

if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

if(!part != "compose") {
global $mail;
global $kiss;

?>
<script type="text/javascript">
	function part(elementname,focusfield){
		if(self[elementname] == 'open') {
			document.getElementById(elementname).style.display='none';
			self[elementname] = 'close';
		} else {
			document.getElementById(elementname).style.display='block';
			self[elementname] = 'open';
			if(focusfield) {
				document.getElementById(focusfield).focus();
			}
		}
	}
</script>


<?php } ?>
<table width="440" border="0" cellpadding="0" cellspacing="0" <?php if($result['smalltext2']) echo "bgcolor=\"$result[smalltext2]\"" ?>>
  <tr> 
    <td width="110" rowspan="2" valign="top"><?php $pictures[0]; ?></td>
    <td height="20" colspan="2" valign="top"><img src="/<xcontainer>div-head_01.gif" width="330" height="20" hspace="0" vspace="0" border="0"></td>
  </tr>
  <tr> 
    <td width="5" valign="top">&nbsp;</td>
    <td width="325" valign="top">
	
      <?php $this->textobject($thisobject); ?>
      <br>
	  <?php if($result['smalltext1']) { 
	  	if(!$mail['result']) { ?>	
	  <a href="javascript:part('actionspanel<?php echo $result['id'] ?>','')" class="headline"> 
      weitere Informationen</a>
	  <?php } else { ?>
	  	<span class="headline">Mitteilung wurde verschickt</span>
	  <?php } }?>
	  </td>
  </tr>
</table>
<?php echo "<!-- $showupload -->";  ?>


<?php if($part != "compose") echo '<form name="offer" action="" method="post">'; ?>
<div id="actionspanel<?php echo $result['id'] ?>" <?php if(!$showupload) echo "style=\"display:none\""; ?>> 
	<?php 
		switch($result['smalltext1']) {
			case "2":
	?>
		
  <table width="440" border="0" cellpadding="0" cellspacing="0" <?php if($result['smalltext2']) echo "bgcolor=\"$result[smalltext2]\"" ?>>
    <tr> 
      <td width="20" valign="top" class="text"><p>&nbsp;</p>
        </td>
      <td width="410" valign="top" class="text"><p><br>
         <xclass:19><br>
		 Bestellen Sie unser Sonderangebot per E-Mail</p>
        <p>Meine e-Mail-Adresse:<br>
          <input name="<?php echo $part == "compose" ? "objectdata[$result[id]][text2]" : "mail[from]" ?>" type="text" class="feld" id="email" value="<xclass:39>" size="50">
          <br>
          <br>
          Meine Bestellung:<br>
          <textarea name="<?php echo $part == "compose" ? "objectdata[$result[id]][text3]" :"mail[message][2]" ?>" cols="45" rows="3" class="mehrzeiler"><?php echo $result['text3'] ?></textarea>
          <br>
          <br>
          <input name="mail[send]" type="submit" class="button" id="mail[send]" value="absenden">
          <input name="mail[message][1]" type="hidden" id="mail[message][1]" value="Ihr Kunde <xclass:38>, Ku-Nr <xclass:32> interessiert sich f�r das Sonderangebot und bittet um weitere Informationen ">
          <input name="mail[subject]" type="hidden" value="VW-Club.de Bestellung des Angebotes">
		  <input name="mail[to]" type="hidden" value="<?php echo $result['smalltext3'] ?>">
		  <input name="class" type="hidden" value="19">
          <br>
          <br>
        </p></td>
    </tr>
  </table>
		<?php 
					break;
				case "3":
		?>
		
  <table width="440" border="0" cellpadding="0" cellspacing="0" <?php if($result['smalltext2']) echo "bgcolor=\"$result[smalltext2]\"" ?>>
    <tr> 
      <td width="22" valign="top" class="text">&nbsp;</td>
      <td width="408" valign="top" class="text"><br>
        <xclass:19><br><br>
		Ich interessiere mich f&uuml;r das Sonderangebot.<br>
        <br>
        Bitte rufen Sie mich unter 
        <input name="<?php echo $part == "compose" ? "objectdata[$result[id]][text2]" : "mail[message][2]" ?>" type="text" class="feld" value="<xclass:40>" size="15">
        zur&uuml;ck.<br>
        Ich bin am besten erreichbar gegen 
        <input name="<?php echo $part == "compose" ? "objectdata[$result[id]][text3]" : "mail[message][3]" ?>" type="text" class="feld" value="" size="15">
        Uhr.<br> <br> <input name="mail[send]" type="submit" class="button" id="mail[send]" value="absenden">
        <input name="mail[message][1]" type="hidden" id="mail[message][1]" value="Ihr Kunde <xclass:38>, Ku-Nr <xclass:32> interessiert sich f�r das Sonderangebot und bittet um R�ckruf"> 
        <input name="mail[to]" type="hidden" value="<?php echo $mailto ?>"> 
        <br>
        <br>
      </td>
    </tr>
  </table>
<?php 
	
		break;
	}
	if($part != "compose") echo "</form>";
	?>       
</div>
<?php if($part == "compose") { ?>
<a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','../../components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a> 
<div id="option<?php echo $objectid ?>"  style="display:none">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="15" height="15" background="/liquido/gfx/x_box/coinsupg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td height="15" background="/liquido/gfx/x_box/sup.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td width="15" height="15" background="/liquido/gfx/x_box/coinsupd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
  <tr> 
    <td width="15" background="/liquido/gfx/x_box/g.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td background="/liquido/gfx/x_box/fond.gif" align="left" width="100%"> <table width="100%">
        <tr> 
          <td class="text"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td colspan="2" valign="top" class="text"><font color="#000000"><a href="#" onClick="openLibrary(<?php echo $result[id] ?>,'type=picture'); return false">&raquo; 
                    Bild ausw&auml;hlen</a></font></td>
                </tr>
                <tr> 
                  <td width="95" valign="top" class="text">Erweiterung:</td>
                  <td width="253" valign="top" class="text"><font color="#000000"> 
                    <input type="radio" name="objectdata[<? echo $result[id]; ?>][smalltext1]" value="1" <?php if($result[smalltext1] == "1") echo "checked"; ?>>
                    keine<br>
                    <input type="radio" name="objectdata[<? echo $result[id]; ?>][smalltext1]" value="2" <?php if($result[smalltext1] == "2") echo "checked"; ?>>
                    Email-Formular<br>
                    <input type="radio" name="objectdata[<? echo $result[id]; ?>][smalltext1]" value="3" <?php if($result[smalltext1] == "3") echo "checked"; ?>>
                    callback-Formular</font></td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top" class="text">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" class="text">H&auml;ndler-Email-Adresse:</td>
                  <td valign="top" class="text"><input name="objectdata[<? echo $result['id']; ?>][smalltext3]" type="text" class="text" value="<?php echo $result['smalltext3']; ?>" size="30"></td>
                </tr>
                <tr> 
                  <td valign="top" class="text">Link: <a href="javascript:page.submit()" onMouseOver="MM_swapImage('ok<?php echo $objectid ?>','','/components/contents/gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"> 
                    </a></td>
                  <td valign="top" class="text"><input name="objectdata[<? echo $result['id']; ?>][link]" type="text" class="text" value="<?php echo $result[link]; ?>" size="30"> 
                  </td>
                </tr>
                <tr> 
                  <td valign="top" class="text">Hintergrundfarbe:</td>
                  <td class="text"><p> 
                      <input name="objectdata[<? echo $result[id]; ?>][smalltext2]" type="text" class="text" value="<?php echo $result[smalltext2]; ?>" size="8" maxlength="7">
                      (zB #EFEFEF) 
                      <input name="objectdata[<? echo $result[id]; ?>][tnwidth]" type="hidden" id="objectdata[<? echo $result[id]; ?>][tnwidth]" value="110" size="3" maxlength="3">
                      <input name="imageupload" type="hidden" id="imageupload" value="<?php echo $result[id]; ?>">
                    </p></td>
                </tr>
              </table> </td>
        </tr>
      </table></td>
    <td width="15" background="/liquido/gfx/x_box/d.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
  <tr> 
    <td width="15" height="15" background="/liquido/gfx/x_box/coininfg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td height="15" background="/liquido/gfx/x_box/inf.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td width="15" height="15" background="/liquido/gfx/x_box/coininfd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>
</table>
<a href="javascript:hide('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('less<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/less.gif" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>"></a> 
</div>
<?php } ?>