<?php  showParents($data); ?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<body onLoad="MM_preloadImages('gfx/more_o.gif','gfx/ok_o.gif','../../gfx/save_o.gif','gfx/less_o.gif')">
<table width="460" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="80" height="250" align="center" valign="top" class="centerline"><p><img src="gfx/group_big.gif"></p></td>
    <td valign="top"></br>
      <p><b><?php echo $data['title'] ?></b>
      <table width="341" border="0" cellspacing="0" cellpadding="0" class="smalltext">
        <tr> 
          <td>(ID: <?php echo $data['id'] ?>, Status: <?php showstatus($data[status]) ?>)</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td width="191">erstellt: <?php echo $data['date'] ?></td>
          <td width="182">&nbsp;</td>
        </tr>
        <tr> 
          <td>ge&auml;ndert: <?php echo $data['changedate'] ?></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      </p>

      <?php if($data['info']) { ?>
      <table width="351" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="24" align="center" valign="top"><img src="../../gfx/info2.gif" width="15" height="15"></td>
          <td width="327"><?php echo nl2br($data['info']); ?></td>
        </tr>
      </table>
	</p><?php } ?>

	  <?php if($access['c4']) { ?>
	  <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('windowproperties')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_prop"></a></td>
            <td width="265"><a href="javascript:show('windowproperties')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Eigenschaften</a></td>
          </tr>
        </table>
        <div id="windowproperties"  style="display:none"> 
          <table width="350" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="32" class="centerline">&nbsp;</td>
              <td colspan="2" align="center" valign="top">
			  <form name="properties" method="post" action="">
			    <table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td valign="top">&nbsp;</td>
                    <td valign="top">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td width="90" valign="top">Bezeichnung:</td>
                    <td width="210" valign="top"><input name="edit[title]" type="text" value="<?php echo $data['title']; ?>" size="25" maxlength="25" class="text"></td>
                  </tr>
                  <tr> 
                    <td valign="top"> Bemerkung: </td>
                    <td valign="top"><textarea name="edit[info]" cols="25" rows="5" class="text"><?php echo $data['info']; ?></textarea></td>
                  </tr>
                  <tr> 
                    <td valign="top"><input name="edit[id]" type="hidden"  value="<?php echo $data['id']; ?>"> 
                      <input name="edit[table]" type="hidden"  value="contents"></td>
                    <td valign="top">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td height="30">Untergruppe von:</td>
                    <td> 
                      <?php build_dropbox($data); // in detail/functions.php ?>
                    </td>
                  </tr>
                  <tr> 
                    <td valign="bottom">eingeschr&auml;nkt:</td>
                    <td valign="top"><a href="#"> 
                      <input type="checkbox" name="edit[public]" value="1" <?php if($data['public']) echo "checked" ?>>
                      <img src="../../gfx/info.gif" alt="Ist dieser Bereich für alle zugänglich?" border="0"></a></td>
                  </tr>
                  <tr valign="bottom"> 
                    <td>Inhaltsbreite:</td>
                    <td><input name="edit[width]" type="text" value="<?php echo $data['width']; ?>" size="4" maxlength="3" class="text">
                      Pixel <a href="#"><img src="../../gfx/info.gif" alt="Alle Inhaltsobjekte dieser Gruppe beziehen sich auf diese Breite" name="savepropx" border="0"></a></td>
                  </tr>
                  <tr> 
                    <td colspan="2" valign="top" class="smalltext"> <br> 
                      <?php if ($access['c5']) { ?>
                      <a href="#" onClick="javascript:properties.submit();" onMouseOver="MM_swapImage('saveprop','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="../../gfx/save.gif" name="savepropx1" border="0" id="saveprop"></a> 
                      <?php } ?>
                    </td>
                  </tr>
                </table>
				</form>
				</td>
            </tr>
            <tr> 
              <td valign="top"><a href="javascript:hide('windowproperties')" onMouseOver="MM_swapImage('less_prop','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" name="less_prop" width="19" border="0"></a><br> 
              </td>
              <td colspan="2"><img src="../../gfx/line_hori_fade.gif" width="326" height="2" border="0"></td>
            </tr>
			<tr>
				<td colspan="2" height="20"></td>
			</tr>
          </table>
        </div>
        
      <?php } 
		 
		 if($access['c7']) {
		 ?>
      <table width="301" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_pub" border="0"></a></td>
          <td width="269"><a href="javascript:show('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">ver&ouml;ffentlichen</a></td>
        </tr>
      </table>
      <div id="publishwindow"  style="display:none"> 
        <table width="350" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="19" class="centerline">&nbsp;</td>
            <td align="center"> 
              <?php if ($access[c8]) { ?>
              <form action="" method="post" name="publish">
                <br>
                <?php if ($data['status'] == "0") { ?>
                <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td colspan="2">Diese Gruppe jetzt online schalten?</td>
                  </tr>
                  <tr> 
                    <td width="50" height="37"><a href="#" onClick="javascript:submit(); return false" onMouseOver="MM_swapImage('ok1','','gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/ok.gif" alt="bestätigen" name="ok1" border="0" id="ok1"></a></td>
                    <td width="239"><input name="publish[allsubpages]" type="checkbox" value="ok">
                      alle Unterseiten online schalten 
                      <input name="publish[set]" type="hidden" value="1">
					  <input name="publish[id]" type="hidden" value="<?php echo $data['id'] ?>"></td>
                  </tr>
                </table>
                <?php } else { ?>
                <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td colspan="2">Diese Gruppe jetzt offline schalten?</td>
                  </tr>
                  <tr> 
                    <td width="50" height="37"><a href="#" onClick="javascript:submit(); return false" onMouseOver="MM_swapImage('ok','','gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/ok.gif" alt="bestätigen" name="ok" border="0"></a></td>
                    <td width="246"><input name="publish[allsubpages]" type="checkbox" value="ok">
                      alle Unterseiten offline schalten 
                      <input name="publush[set]" type="hidden" value="0">
					  <input name="publish[id]" type="hidden" value="<?php echo $data['id'] ?>"></td>
                  </tr>
                </table>
                <?php } ?>
              </form>
              <?php } ?>
              <form action="" method="post" name="scedule">
                <table width="300" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="41"><img src="gfx/clock_big.gif" border="0"></td>
                    <td width="259"> Zeitgesteuerte Ver&ouml;ffentlichung*</td>
                  </tr>
                </table>
                <table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="116"><br>
                      online stellen am:</td>
                    <td width="184"><br>
                      offline stellen am:</td>
                  </tr>
                  <tr> 
                    <td height="37"><input name="scedule[publish]" type="text" value="<?php echo $publishdata[0]; ?>" size="8" maxlength="8"></td>
                    <td><input name="scedule[unpublish]" type="text" value="<?php echo $unpublishdata[0]; ?>" size="8" maxlength="8"></td>
                  </tr>
                  <tr> 
                    <td colspan="2">
                      <?php if($access['c8']) { ?>
                      <a href="#" onClick="javascript:scedule.submit(); return false" onMouseOver="MM_swapImage('save','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/save.gif" name="save" border="0"></a> 
                      <?php } ?>
                      <input name="scedule[id]" type="hidden" value="<?php echo $result['id']; ?>"> 
                      <p></p>
                      <p>* Datum im Format tt.mm.jj</td>
                  </tr>
                  <tr> 
                    <td width="116"> 
                    <td colspan="2"> <p></p></td>
                  </tr>
                </table>
              </form></td>
          </tr>
          <tr> 
            <td width="19"><a href="javascript:hide('publishwindow')" onMouseOver="MM_swapImage('less_pub','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_pub"></a></td>
            <td height="16" colspan="2"><img src="../../gfx/line_hori_fade.gif" border="0"></td>
          </tr>
          <tr> 
            <td colspan="2" height="20"></td>
          </tr>
        </table>
      </div>
      <?php } if($access['c4']) { ?>
      <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('template')" onMouseOver="MM_swapImage('more_temp','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_temp"></a></td>
            
          <td width="265"><a href="javascript:show('template')" onMouseOver="MM_swapImage('more_temp','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Vorlage</a></td>
          </tr>
        </table>
        <div id="template"  style="display:none"> 
          <table width="350" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="32" class="centerline">&nbsp;</td>
              <td colspan="2" align="center" valign="top">
			  <form name="template" method="post" action="">
			    <table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="100" valign="top">
						<input name="edit[id]" type="hidden"  value="<?php echo $data['id']; ?>"> 
                    	<input name="edit[table]" type="hidden"  value="contents">
					</td>
                    <td width="200" valign="top">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td colspan="2" valign="top"> Diese Gruppe 
                      verwendet die Vorlage:<br><br>
                      <?php listTemplates($current=$data['template']); ?>
                      <br>
                      <br>
                      <br> 
                      <?php if ($access['c5']) { ?>
                      <a href="#" onClick="javascript:template.submit();" onMouseOver="MM_swapImage('seltemp','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="../../gfx/save.gif" name="seltemp" border="0"></a> 
                      <?php } ?>
                    </td>
                  </tr>
                </table>
				</form>
				</td>
            </tr>
            <tr> 
              <td valign="top"><a href="javascript:hide('template')" onMouseOver="MM_swapImage('less_temp','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" name="less_temp" width="19" border="0"></a><br> 
              </td>
              <td colspan="2"><img src="../../gfx/line_hori_fade.gif" width="326" height="2" border="0"></td>
            </tr>
			<tr>
				<td colspan="2" height="20"></td>
			</tr>
          </table>
        </div>
		<?php } if ($access['c3']) { ?>
		<table width="301" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_del"></a></td>
            
          <td width="269"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Papierkorb</a></td>
          </tr>
        </table>
		<div id="delete"  style="display:none">
          <table width="350" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="19" class="centerline">&nbsp;</td>
			  <td align="center">
			  <form action="" method="post" name="delform">
				<table width="300" border="0" cellspacing="0" cellpadding="0">
				 <tr>
					<td width="346" colspan="2"><p><br>
                        Diese Gruppe in den Papierkorb legen? </p>
                      <p> <a href="#" onClick="javascript:delform.submit();" onMouseOver="MM_swapImage('ex_temp','','../../components/contents/gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"> 
                        <img src="../../components/contents/gfx/ok.gif" border="0" name="ex_temp"></a> 
                        <input name="trash[parent]" type="hidden"  value="<?php echo $data['parent']; ?>">
                        <input name="trash[type]" type="hidden"  value="contents">
                        <input name="trash[id]" type="hidden"  value="<?php echo $data['id']; ?>">
                      </p></td>
					</tr>
				</table>
				</form>
		  		</td>
            </tr>
            <tr> 
              <td width="19"><a href="javascript:hide('delete')" onMouseOver="MM_swapImage('less_del','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_del"></a></td>
              <td height="16"><img src="../../gfx/line_hori_fade.gif" border="0"></td>
            </tr>
			<tr>
				<td colspan="2" height="20"></td>
			</tr>
          </table>
		 </div>
	  <?php } 
	  if($access['c2']) { ?>
      <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('new','new_group_input')"><img src="gfx/group_new.gif" border="0"></a></td>
            
          <td width="229"><a href="javascript:show('new','new_group_input')">Gruppe 
            erstellen</a></td>
          </tr>
        </table>
        <div id="new"  style="display:none"> 
          <table width="350" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="38" class="centerline">&nbsp;</td>
              <td colspan="2">
			  <form action="" method="post" name="newgroup">
			    <table width="324" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td>&nbsp;</td>
                    <td width="220">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td width="104">Bezeichnung:</td>
                    <td><input name="insert[title]" type="text" id="new_group_input" value="Inhaltsgruppe" size="25"></td>
                  </tr>
                  <tr> 
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td valign="top">Bemerkung:</td>
                    <td><textarea name="insert[info]" cols="25" class="text"></textarea></td>
                  </tr>
                  <tr> 
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td>Inhaltsbreite</td>
                    <td><input name="insert[width]" type="text" value="250" size="4" maxlength="3">
                      Pixel</td>
                  </tr>
                  <tr> 
                    <td height="41" colspan="2"><input name="insert[parent]" type="checkbox" id="insert[parent]" value="<?php echo $data['id'] ?>">
                      als Untergruppe von <b><?php echo $data['title'] ?></b> anlegen <a href="#"> <img src="../../gfx/info.gif" alt="Alle Inhalte dieser Gruppe beziehen sich auf diese Breite" name="savepropx" border="0"></a></td>
                  </tr>
                  <tr> 
                    <td colspan="2" valign="top"><a href="javascript:editors.submit()" onMouseOver="MM_swapImage('savegroupx','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"> 
                      <br>
                      <?php if ($access['c3']) { ?>
                      </a><a href="#" onClick="javascript:newgroup.submit();" onMouseOver="MM_swapImage('savenew','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/save.gif" border="0" name="savenew"></a> 
                      <?php } ?>
                      <input name="insert[table]" type="hidden" value="contents"> 
                      <input name="insert[type]" type="hidden" value="group"> 
                    </td>
                  </tr>
                </table>
				</form>
				</td>
            </tr>
            <tr> 
              <td align="center" valign="top"><a href="javascript:hide('new')" onMouseOver="MM_swapImage('newx','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="newx"><br> 
              </td>
              <td colspan="2"><img src="../../gfx/line_hori_fade.gif" width="326" height="2" border="0"></td>
            </tr>
			<tr>
				<td colspan="2" height="20"><p>&nbsp;</p>
              </td>
			</tr>
          </table>
        </div>
		
      <?php } ?>
      <br>
    </td>
  </tr>
  <tr> 
    <td colspan="2"> 
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="40">&nbsp;</td>
          <td> 
            <?php showchilds($data,"1"); ?>
          </td>
        </tr>
      </table> </td>
  </tr>
  <tr align="center"> 
    <td colspan="2">
	<?php if ($access['c1']) { ?>
		<form action="" method="post" name="newpagex" id="new">
        <div id="newPage"  style="display:none"><br>
          <table border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="17" height="1"></td>
              <td width="11"></td>
              <td></td>
              <td width="17"></td>
              <td width="1"></td>
            </tr>
            <tr> 
              <td rowspan="2"><img src="../../gfx/dropshadow/03.gif" width=17 height=24 ></td>
              <td background="../../gfx/dropshadow/05.gif"><img src="../../gfx/dropshadow/04.gif" width=11 height=11 ></td>
              <td align="right" background="../../gfx/dropshadow/05.gif"><img src="../../gfx/dropshadow/07.gif" width=12 height=11 ></td>
              <td rowspan="2"><img src="../../gfx/dropshadow/08.gif" width=17 height=24 ></td>
              <td height="1"></td>
            </tr>
            <tr> 
              <td colspan="2" rowspan="3" align="center"><table width="372" border="0" cellspacing="2" cellpadding="2">
                  <tr> 
                    <td width="46"><img src="../../components/contents/gfx/page_new.gif" border="0" id="savenewx1"></td>
                    <td colspan="2">Neue Seite in <b><?php echo $data['grouptitle'] ?></b> 
                      erstellen</td>
                    <td align="right" valign="top"><a href="javascript:hide('newPage')" onMouseOver="MM_swapImage('newx1','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" name="newx1" border="0" id="newx1"></a></td>
                  </tr>
                  <tr> 
                    <td width="46">
						<input name="insert[parent]" type="hidden" value="<?php echo $obj['id']; ?>">
						<input name="insert[table]" type="hidden" value="contents">
						<input name="insert[type]" type="hidden" value="page">
                    </td>
                    <td width="50">Titel</td>
                    <td width="186"><input name="insert[title]" type="text" size="25" id="in_newpage"></td>
                    <td width="64" align="center"><a href="javascript:newpagex.submit()" onMouseOver="MM_swapImage('savenewy','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/save.gif" name="savenewy" border="0"></a> 
                    </td>
                  </tr>
                </table></td>
              <td height="13"></td>
            </tr>
            <tr> 
              <td background="../../gfx/dropshadow/12.gif">&nbsp;</td>
              <td background="../../gfx/dropshadow/13.gif">&nbsp;</td>
              <td height="70"></td>
            </tr>
            <tr> 
              <td height="32" rowspan="2"><img src="../../gfx/dropshadow/16.gif" width=17 height=32 ></td>
              <td height="32" rowspan="2"><img src="../../gfx/dropshadow/17.gif" width=17 height=32 ></td>
              <td height="6"></td>
            </tr>
            <tr> 
              <td background="../../gfx/dropshadow/19.gif"><img src="../../gfx/dropshadow/18.gif" width=11 height=26 ></td>
              <td align="right" background="../../gfx/dropshadow/19.gif"><img src="../../gfx/dropshadow/20.gif" width=12 height=26 ></td>
              <td height="26"></td>
            </tr>
          </table>
        </div>
      </form>
	  <?php } ?>
	  </td>
  </tr>
</table>
