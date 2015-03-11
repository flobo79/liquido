<div class="content_centered">
<table>
	<tr> 
    <td width="98" height="250" align="center" valign="top"><p><img src="gfx/group_big.gif"></p></td>
    <td width="379" valign="top">
		<b><br>
		<?php echo $data['title'] ?></b> 
		<div class="smalltext">
		ID: <?php echo $data['id'] ?>,             erstellt: <?php echo $data['date'] ?> Uhr<br>
		<br/>
		<?php if($data['info']) { ?>
      </div>
      <table width="351" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="24" align="center" valign="top"><img src="../../gfx/info2.gif" width="15" height="15"></td>
          <td width="327"><?php echo nl2br($data['info']); ?></td>
        </tr>
      </table></p>
      <?php } ?>
      <?php if($access['c4']) { ?>
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('windowproperties')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_prop"></a></td>
          <td width="265"><a href="javascript:show('windowproperties')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Eigenschaften</a></td>
        </tr>
      </table>
      <div id="windowproperties" class="hidden">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="15" height="15" background="../../gfx/x_box/coinsupg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td height="15" background="../../gfx/x_box/sup.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td width="15" height="15" background="../../gfx/x_box/coinsupd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
    <tr> 
      <td width="15" background="../../gfx/x_box/g.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td background="../../gfx/x_box/fond.gif" align="left" width="100%"><form name="properties" method="post" action="">
              <table width="300" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td valign="top">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                  <tr> 
                    <td width="90" valign="top">Betreff:</td>
                  <td width="210" valign="top"><input name="edit[title]" type="text" value="<?php echo $data['title']; ?>" size="35" maxlength="100" class="text"></td>
                </tr>
                <tr> 
                  <td valign="top"> Bemerkung: </td>
                  <td valign="top"><textarea name="edit[info]" cols="33" rows="5" class="text"><?php echo $data['info']; ?></textarea></td>
                </tr>
                <tr> 
                  <td valign="top">
					 </td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr valign="bottom">
                  <td>Vorlage:</td>
                  <td>  
                      <?php if($access['c4']) { listTemplates($thistemplate=$data['template']); } else { echo $data['template']; } ?>
                  </td>
                </tr>
                <tr valign="bottom"> 
                  <td>Inhaltsbreite:</td>
                  <td><input name="edit[width]" type="text" value="<?php echo $data['width']; ?>" size="4" maxlength="3" class="text" />
                    Pixel <a href="#"><img src="../../gfx/info.gif" alt="?" title="Alle Inhaltsobjekte dieser Gruppe beziehen sich auf diese Breite" name="savepropx" /></a></td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top" class="smalltext"> <br> 
                    <?php if ($access['c5']) { ?>
                    <a href="#" onClick="javascript:document.forms['properties'].submit();" onMouseOver="MM_swapImage('saveprop','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="../../gfx/save.gif" name="savepropx1" border="0" id="saveprop"></a> 
                    <?php } ?>
                  </td>
                </tr>
              </table>
            </form> </td>
      <td width="15" background="../../gfx/x_box/d.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
    <tr> 
      <td width="15" height="15" background="../../gfx/x_box/coininfg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td height="15" background="../../gfx/x_box/inf.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td width="15" height="15" background="../../gfx/x_box/coininfd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
  </table>
  <a href="javascript:hide('windowproperties')" onMouseOver="MM_swapImage('less_prop','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" name="less_prop" width="19" border="0"></a></div>
      <?php } ?>
	  <?php if($access['c7']) { ?>
      <table width="332" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_pub" border="0"></a></td>
          <td width="300"><a href="javascript:show('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Kampagne versenden</a></td>
        </tr>
      </table>
      <div id="publishwindow" class="hidden"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coinsupg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/sup.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coinsupd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" background="../../gfx/x_box/g.gif"> <img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td background="../../gfx/x_box/fond.gif" align="left" width="100%"> 
              <?php if ($data['status'] >= "3") { ?>
              <form action="" method="get" name="publish">
                <?php if ($data['status'] > "3") { ?><br>
                <strong>Achtung! Diese Ausgabe wurde bereits veröffentlicht.</strong><br>
                <br>
                <?php } ?>
                <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td colspan="2"> W&auml;hlen Sie eine oder mehrere Empf&auml;ngergruppen 
                      aus:<br> <br> 
					<?php 
						$groups = getgroups();
						if(is_array($groups)) {
							$data['group'] = explode(";",$data['group']); 
							foreach($data['group'] as $value) $setgroups[$value] = "1";
							
							foreach($groups as $key => $value) {
								$checked = $setgroups[$value['id']] ? "checked" : "";
								echo "<input type=\"checkbox\" name=\"publish[group][".$value['id']."]\" value=\"1\" $checked >".$value['title']."<br>\n";
							}
						}
					?>
                      <br> <br>
                      Wenn keine Gruppe ausgew&auml;hlt ist, wird der Newsletter 
                      an alle Abonnenten verschickt.<br> </td>
                  </tr>
                  <tr> 
                    <td width="50" height="37"><input type="image" src="gfx/ok.gif" alt="bestätigen" name="" border="0" id="ok1" class="hand"></td>
                    <td width="239"> Versendung jetzt starten
						<input type="hidden" name="publish[id]" value="<?php echo $data['id'] ?>"> 
						<input type="hidden" name="setmode" value="publish"> <input name="loc" type="hidden" value="publish">
						<input type="hidden" name="publish[send]" value="publish">
						<input type="hidden" name="loc" value="publish_forked"></td>
                  </tr>
                </table>
             
              </form>
              <?php } else { // keine Versandfreigabe ?>
			  	Der Versand dieser Kampagne ist noch nicht freigegeben.
			  <?php } ?>
            </td>
            <td width="15" background="../../gfx/x_box/d.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coininfg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/inf.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coininfd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table>
        <a href="javascript:hide('publishwindow')" onMouseOver="MM_swapImage('less_pub','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_pub"><br>
        </a><br>
      </div>
      <?php } ?>
	  <?php if ($access['c3']) { ?>
      <table width="333" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="32"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_del"></a></td>
          <td width="301"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Kampagne l&ouml;schen</a></td>
        </tr>
      </table>
      <div id="delete" class="hidden">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="15" height="15" background="../../gfx/x_box/coinsupg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/sup.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coinsupd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr>
            <td width="15" background="../../gfx/x_box/g.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td background="../../gfx/x_box/fond.gif" align="left" width="100%"><form action="" method="post" name="delform">
                <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="346" colspan="2"><p><br>
                  Diese Ausgabe in den Papierkorb bewegen? </p>
                        <p> <a href="#" onClick="javascript:delform.submit();" onMouseOver="MM_swapImage('ex_temp1','','../../components/contents/gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"> <img src="../../components/contents/gfx/ok.gif" name="ex_temp1" border="0" id="ex_temp1"></a>
                            <input name="trash[type]" type="hidden"  value="nlcontents">
                            <input name="trash[id]" type="hidden"  value="<?php echo $data['id']; ?>">
                      </p></td>
                  </tr>
                </table>
            </form></td>
            <td width="15" background="../../gfx/x_box/d.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr>
            <td width="15" height="15" background="../../gfx/x_box/coininfg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/inf.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coininfd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table>
        <a href="javascript:hide('delete')" onMouseOver="MM_swapImage('less_del','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_del"></a><br>
      </div>
      <?php } ?>	  <p class="headline"><strong>Freigabestatus:</strong></p>
	<input type="checkbox" name="setstatus" value="1" <?php if(!$access['c6']) echo "disabled";  if($data['status'] >= 1) echo "checked"; ?> onclick="document.location.href='?setstatus=1&amp;status='+this.checked" />
	Redaktionsschluss<br>
	<input type="checkbox" name="setstatus" value="2" <?php if(!$access['c7']) echo "disabled";  if($data['status'] >= 2) echo "checked"; ?> onclick="document.location.href='?setstatus=2&amp;status='+this.checked" />
	Redaktion freigegeben<br>
	<input type="checkbox" name="setstatus" value="3" <?php if(!$access['c8']) echo "disabled";  if($data['status'] >= 3) echo "checked"; ?> onclick="document.location.href='?setstatus=3&amp;status='+this.checked" />
	Versand freigegeben
<p>&nbsp;</p>
    </tr>
</table>
</div>