<?php 
// verfügbare templates ermitteln
$templates = getTemplates($temp);


?>
<table width="460" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="90" height="250" align="center" valign="top" class="centerline"><p><img src="../gfx/logo.gif"></p></td>
    <td valign="top"></br> <p><b><?php echo $data['title'] ?></b> 
      <p class="smalltext">erstellt: <?php echo $data['date'] ?> <br>
        ge&auml;ndert: <?php echo $data['changes']['date'] ?> <br>
        ID:<?php echo $data['id'] ?>
      </p> 
      <?php if($data['info']) { ?>
      
      <p>
      <table width="351" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="24" align="center" valign="top"><img src="../../../gfx/info2.gif" width="15" height="15"></td>
          <td width="327"><?php echo nl2br($data['info']); ?></td>
        </tr>
      </table>
	</p>
	<?php } if($access['c4']) { ?>
		<table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('windowproperties')" onMouseOver="MM_swapImage('more_prop','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/more.gif" alt="Optionen einblenden" border="0" name="more_prop"></a></td>
            <td width="265"><a href="javascript:show('windowproperties')" onMouseOver="MM_swapImage('more_prop','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Eigenschaften</a></td>
          </tr>
        </table>
        <div id="windowproperties" style="display:none">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="../../../gfx/x_box/coinsupg.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../../gfx/x_box/sup.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../../gfx/x_box/coinsupd.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" background="../../../gfx/x_box/g.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td background="../../../gfx/x_box/fond.gif" align="left" width="100%"><form name="properties" method="post" action="">
                <table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td valign="top">&nbsp;</td>
                    <td valign="top">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td width="78" valign="top">Bezeichnung:</td>
                    <td width="222" valign="top"><input name="edit[title]" type="text" value="<?php echo $data['title']; ?>" size="40" maxlength="25" class="text"></td>
                  </tr>
                  <tr> 
                    <td valign="top">Info: 
                      <input name="edit[id]" type="hidden"  value="<?php echo $data['id']; ?>"> 
                      <input name="edit[table]" type="hidden"  value="templates"></td>
                    <td valign="top"><textarea name="edit[info]" cols="38" rows="5" class="text"><?php echo $data['info']; ?></textarea></td>
                  </tr>
                  <tr>
                    <td height="31" colspan="2" class="smalltext">Vorlage tauschen mit: 
                      <select name="swap" class="text">
                <option value="">-- tauschen mit --</option>
				<?php foreach($templates as $entry) {
				 	echo "<option value=\"$entry[id]\">$entry[title]</option>\n";
				
				}
				?>
              </select></td>
                  </tr>
                  <tr> 
                    <td colspan="2" valign="top" class="smalltext"> 
                      <?php if ($access['c5']) { ?>
                      <a href="javascript:document.properties.submit()" onMouseOver="MM_swapImage('savepropx1','','../../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="../../../gfx/save.gif" name="savepropx1" border="0" id="savepropx1"></a> 
                      <?php } ?>
                    </td>
                  </tr>
                </table>
              </form></td>
            <td width="15" background="../../../gfx/x_box/d.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="../../../gfx/x_box/coininfg.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../../gfx/x_box/inf.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../../gfx/x_box/coininfd.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table> 
          
        <a href="javascript:hide('windowproperties')" onMouseOver="MM_swapImage('less_prop','','../../../gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/less.gif" alt="Optionen ausblenden" name="less_prop" width="19" border="0"></a><br><br>
      </div>
		<?php } if ($access['c3']) { ?>
        <table width="301" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/more.gif" alt="Optionen einblenden" border="0" name="more_del"></a></td>
            
          <td width="269"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Vorlage 
            l&ouml;schen</a></td>
          </tr>
        </table>
		<div id="delete"  style="display:none">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="../../../gfx/x_box/coinsupg.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../../gfx/x_box/sup.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../../gfx/x_box/coinsupd.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" background="../../../gfx/x_box/g.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td background="../../../gfx/x_box/fond.gif" align="left" width="100%"><form action="" method="post" name="delform">
                <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="346" colspan="2"><p>Diese Vorlage wirklich löschen? 
                        Es werden alle Inhalte gelöscht! </p>
                      <p> 
                        <?php if($data['uses']['nr']) { ?>
                        Wie möchten Sie mit den Verwendungen verfahren?</p>
                      <p> 
                        <select name="trash[todo]" id="trash[todo]">
                          <option value="setoffline">alle Inhalte auf offline setzen</option>
                          <?php
							$thisarray = $templates;
							while(list($key,$val) = each($thisarray)) {
								echo "<option value=\"$val[id]\">mit $val[title] ersetzen</option>\n";
							}
						?>
                        </select>
                      </p>
                      <?php } ?>
                      <p><a href="#" onclick="javascript:document.delform.submit()" onMouseOver="MM_swapImage('ex_del','','../../../gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/ok.gif" border="0" name="ex_del"></a> 
                        <input name="trash[id]" type="hidden"  value="<?php echo $data['id']; ?>">
                      </p></td>
                  </tr>
                </table>
              </form></td>
            <td width="15" background="../../../gfx/x_box/d.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="../../../gfx/x_box/coininfg.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../../gfx/x_box/inf.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../../gfx/x_box/coininfd.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table>
          
        <a href="javascript:hide('delete')" onMouseOver="MM_swapImage('less_del','','../../../gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_del"></a><br><br>
      </div>
	  <?php } if ($access['c5']) { ?>
        <table width="301" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('publish','')" onMouseOver="MM_swapImage('more_pub','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/more.gif" alt="Optionen einblenden" border="0" name="more_pub"></a></td>
            
          <td width="269"><a href="javascript:show('publish','')" onMouseOver="MM_swapImage('more_pub','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><?php echo ($data['status'] == "1") ? "Freigabe zurückziehen" : "Vorlage freigeben"; ?></a></td>
          </tr>
        </table>
		<div id="publish"  style="display:none"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="../../../gfx/x_box/coinsupg.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../../gfx/x_box/sup.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../../gfx/x_box/coinsupd.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" background="../../../gfx/x_box/g.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td background="../../../gfx/x_box/fond.gif" align="left" width="100%"><form action="" method="post" name="publishform">
                <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="346" colspan="2"><p>
                        <?php if($data['status'] == "0") { ?>
                      </p>
                      <p>Diese Vorlage jetzt freigeben? 
                        <input name="publish[id]" type="hidden"  value="<?php echo $data['id']; ?>">
                      </p>
                     
                     
                      <?php if ($data['uses']['nr']) { ?>
                      <p> 
                        <input type="checkbox" name="publish[todo]" value="setonline">
                        alle Verwendungen online setzen</p>
                      
                        <?php } 
                         } else { ?>
                        <p> 

                        Freigabe der Vorlage zurückziehen? 
                        <input name="offtake[id]" type="hidden"  value="<?php echo $data['id']; ?>">
                      </p>
                        <?php if($data['uses']['nr']) { ?>
                        
                        <p> 
                        Wie möchten Sie mit den Verwendungen dieser Vorlage 
                        verfahren?</p>
                      <p> 
                        <select name="offtake[todo]">
                          <option value="setoffline">alle Inhalte auf offline setzen</option>
                          <?php 
							while(list($key,$val) = each($templates)) {
								echo "<option value=\"$val[id]\">mit $val[title] ersetzen</option>\n";
							}
						?>
                        </select>
                      </p>
                      <?php }} ?>
                      <p>
                      	
                       <a href="#" onclick="javascript:publishform.submit()" onMouseOver="MM_swapImage('ex_pub','','../../../gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/ok.gif" border="0" name="ex_pub"></a> 
                      </p>
                      </td>
                  </tr>
                </table>
              </form></td>
            <td width="15" background="../../../gfx/x_box/d.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="../../../gfx/x_box/coininfg.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../../gfx/x_box/inf.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../../gfx/x_box/coininfd.gif"><img src="../../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table>
	    <a href="javascript:hide('publish')" onMouseOver="MM_swapImage('less_pub','','../../../gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_pub"></a> 
        <br>
        <br>      
      </div>
 <?php } ?>
    </td>
  </tr>
  <tr> 
    <td colspan="2"> 
      <table width="281" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="45" rowspan="4"> </td>
          <td><img src="../../../gfx/tree_body.gif" border="0"> <a href="?setmode=container"><img src="../gfx/container_tn.gif" width="15" height="15" border="0"> Container</a></td>
        </tr>
        <tr> 
          <td><img src="../../../gfx/tree_body.gif" border="0"> <a href="?setmode=classes"><img src="../gfx/class_tn.gif" width="15" height="15" border="0"> 
            Klassen</a></td>
        </tr>
        <tr> 
          <td><img src="../../../gfx/tree_end.gif" border="0"> <a href="?setmode=structures"><img src="../gfx/template_tn.gif" width="14" height="15" border="0"> 
            Strukturen</a> </td>
        </tr>
        <tr> 
          <td height="50" valign="top"> 
           
          </td>
        </tr>
      </table> </td>
  </tr>
</table>
