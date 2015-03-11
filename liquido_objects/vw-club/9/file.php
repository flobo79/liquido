<?php


// contents-template

$pictures = $this->listpictures($result['id'], $part);
$size = $pictures[1];
$wimg = $pictures[1][0];
$himg = $pictures[1][1];

$objecttitle = "Gewinnspiel";
$thisobject['formrows'] = "5";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "text";
$thisobject['textwidth'] = $contentwidth - $size[0] - $result['text2'];

//shortcut
$id = $result['id'];

if ($part == "compose") include("$cfgcmspath/components/contents/compose/templates/object_head.php");

if($part != "compose") {
	global $mail;
	global $kis;

?>
<form name="gamble" method="post">
<?php } 

if($_POST['game'][$id]) {
	$values = $_POST['game'][$id];
	if(!$values['name']) $error['name'] = "< Bitte eingeben";
	if(!$values['email']) $error['email'] = "< Bitte eingeben";
	if(!$values['answer']) $error['answer'] = "Bitte geben Sie eine Lösung ein";
	
	if(!$error) {
		$mail = "Gewinnspielteilnahme
		
		Frage: $values[question]
		
		Antwort: ".urldecode($values['answer'])."
		
		Teilnehmer
		Name: $values[name]
		Email: $values[email]
		Mitteilung: $values[message]
		
		";
		if($result['text3']) $sent = mail($result['text3'],"Gewinnspielteilnahme auf VW-Club.de",$mail,"from: \"Volkswagen Club\" <vwclub@dialogservice.com>");
	}
}

?>
<table width="430" border="0" cellpadding="0" cellspacing="0" <?php if($result['smalltext2']) echo "bgcolor=\"$result[smalltext2]\"" ?>>
  <tr> 
    <td width="35" rowspan="2" valign="top"><?php $pictures[0]; ?></td>
    <td height="20" colspan="2" valign="top"><!-- <img src="/<xcontainer>div-head_01.gif" width="330" height="20" hspace="0" vspace="0" border="0"> --></td>
  </tr>
  <tr> 
    <td width="9" valign="top">&nbsp;</td>
    <td width="386" valign="top"> 
      <?php if(!$sent) {
	  $this->textobject($thisobject); ?>
      <p> 
        <?php 
		echo $error['answer']."<br>";
	  $num = substr_count ($result['text2'],"\n");
	  if($num != 0) {
	  	$auswahl = split("\n",$result['text2']);
		foreach($auswahl as $entry) {
			echo "<input type=\"radio\" name=\"game[$id][answer]\" value=\"".trim($entry)."\"> ".trim($entry)."<br/>\n";
		
		}		
	  } else {
	  echo $result['text2'];
	  ?>
        Ihre Antwort:<br>
        <textarea name="game[<?php echo $id ?>][answer]" cols="30" rows="4" style="width:<?php echo $thisobject['textwidth'] ?>px"></textarea>
        <?php
	  }

	  
	  ?>
        <input name="game[<?php echo $id ?>][question]" type="hidden" value="<?php echo $result['text'] ?>">
        <input name="game[<?php echo $id ?>][id]" type="hidden" value="<?php echo $result['id'] ?>">
      </p>
      <p><strong>Ihre Angaben:</strong><br>
        Name: <br>
        <input name="game[<?php echo $id ?>][name]" class="feld" type="text" value="<?php echo $values['name'] ?>"> <?php echo $error['name'] ?>
        <br>
        Emailadresse: <br>
        <input type="text" name="game[<?php echo $id ?>][email]" class="feld" value="<?php echo $values['email'] ?>"> <?php echo $error['email'] ?>
		<br>
      <br />
      Ihre Mitteilung:<br />
      <textarea name="game[<?php echo $id ?>][message]" class="mehrzeiler" cols="30" rows="4" style="width:<?php echo $thisobject['textwidth'] ?>px"></textarea>
      </p>
      <p> 
        <input type="Submit" class="button" name="game[submit]" value="absenden">
        <br>
      </p>
	  <?php } else { ?>
      <p>Vielen Dank f&uuml;r Ihre Teilnahme. </p>
      <p>Ihre Antwort: <?php echo urldecode($values['answer']) ?> 
        <?php } ?>
      </p></td>
  </tr>
</table>


<?php
if($part != "compose") {
	echo "</form>";
} else { ?>
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
                  <td colspan="2" valign="top" class="text"><!-- <font color="#000000"><a href="#" onClick="openLibrary(<?php echo $result[id] ?>,'type=picture'); return false">&raquo; 
                    Bild ausw&auml;hlen</a></font> --></td>
                </tr>
                <tr> 
                  <td width="95" valign="top" class="text">M&ouml;gliche Antworten:<br>
                    <div class="smalltext">Als Liste mit Zeilenumbruch eingeben. Als einzelne Antwortm&ouml;glichkeit, 
                    nur eine Antwortbeschreibung eingeben.</div></td>
                  <td width="253" valign="top" class="text"><font color="#000000"> 
                    <textarea name="objectdata[<? echo $result['id']; ?>][text2]" cols="30" rows="8"><?php echo $result['text2'] ?></textarea>
                    </font></td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top" class="text">&nbsp;</td>
                </tr>
                <tr> 
                  <td valign="top" class="text">Ziel-Email-Adresse:</td>
                  <td valign="top" class="text"><input name="objectdata[<? echo $result['id']; ?>][text3]" type="text" class="text" value="<?php echo $result['text3']; ?>" size="30"></td>
                </tr>
				<!-- 
                <tr> 
                  <td valign="top" class="text">Hintergrundfarbe:</td>
                  <td class="text"><p> 
                      <input name="objectdata[<? echo $result[id]; ?>][smalltext2]" type="text" class="text" value="<?php echo $result[smalltext2]; ?>" size="8" maxlength="7">
                      (zB #EFEFEF) 
                      <input name="objectdata[<? echo $result[id]; ?>][tnwidth]" type="hidden" id="objectdata[<? echo $result[id]; ?>][tnwidth]" value="100" size="3" maxlength="3">
                      <input name="imageupload" type="hidden" id="imageupload" value="<?php echo $result[id]; ?>">
                    </p></td>
                </tr>
				-->
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