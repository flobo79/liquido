<?php

// contents-template
$objecttitle = "Startseiten-Objekte";

if ($part == "compose") {
	include("$cfgcmspath/components/contents/compose/templates/object_head.php");
	$composex = 1;
}

if($result['text']) {
	
	$mynode = new Node($result['text']);
	echo $mynode->listobjects();
}
if($composex) { $part = "compose";  unset($composex); }

if($part == "compose") { 
?>
<a href="javascript:show('option<?php echo $objectid ?>');" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>">[+]</a>
<div id="option<?php echo $objectid ?>" style="display:none"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="15" height="15" background="/liquido/gfx/x_box/coinsupg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td height="15" background="/liquido/gfx/x_box/sup.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td width="15" height="15" background="/liquido/gfx/x_box/coinsupd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
    <tr> 
      <td width="15" background="/liquido/gfx/x_box/g.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td background="/liquido/gfx/x_box/fond.gif" align="left" width="100%">Artikel 
        ausw&auml;hlen: 
        <select name="objectdata[<?php echo $result['id'] ?>][text]">
          <?php 
				$articles = listArticles($result['id'],$result['text']);
				if(is_array($articles)) {
					foreach ($articles as $key => $value) {
						$setselected = $value['id'] == $result['text'] ? " selected" : "";
						echo "<option value=\"$value[id]\" $setselected>$value[title] $value[id]</option>\n";
					}
				}
			?>
        </select> </td>
      <td width="15" background="/liquido/gfx/x_box/d.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
    <tr> 
      <td width="15" height="15" background="/liquido/gfx/x_box/coininfg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td height="15" background="/liquido/gfx/x_box/inf.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td width="15" height="15" background="/liquido/gfx/x_box/coininfd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
  </table>
  <a href="javascript:hide('option<?php echo $objectid ?>');" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>">[-]</a>
</div>
<?php } ?>