<?php

// contents-template
$objecttitle = "KOOP-Übersicht";



if ($part == "compose") {
	include("$cfgcmspath/components/contents/compose/templates/object_head.php");

	$composex = 1;
	$part = "public";
}
//if($incms) $cfgcmspath = "../../";

echo "<div class=\"koop_list\">\n";
if($result['text']) {
	$node = new Node($result['text']);
	echo $node->listobjects();
}
echo "</div>\n";

if($composex) $part = "compose";
if($part == "compose") { $mode = "compose"; ?>
<a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<div id="option<?php echo $objectid ?>" style="display:none">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="15" height="15" background="/liquido/gfx/x_box/coinsupg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td height="15" background="/liquido/gfx/x_box/sup.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    <td width="15" height="15" background="/liquido/gfx/x_box/coinsupd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
  </tr>

  <tr>
   <td width="15" background="/liquido/gfx/x_box/g.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td background="/liquido/gfx/x_box/fond.gif" align="left" width="100%">
	<table width="100%">
          <tr> 
            <td class="text">Objekte-Seite ausw&auml;hlen: 
              <select name="objectdata[<?php echo $result['id'] ?>][text]">
                <?php 
				$articles = listArticles($result['id'],$result['text']);
				if($articles) {
					foreach ($articles as $key => $value) {
						$setselected = $value['id'] == $result['text'] ? " selected" : "";
						echo "<option value=\"$value[id]\" $setselected>$value[title]</option>\n";
					}
				}
			?>
              </select>
			  </td>
          </tr>
        </table>
  </td>
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
