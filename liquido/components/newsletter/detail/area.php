<?php  showParents($data); ?>
<table width="460" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="80" height="250" align="center" valign="top" class="centerline"><a href="body.php?setmode=preview" target="middle"><img src="gfx/page_big.gif" border="0"></a></td>
    <td valign="top"></br> <p><b><?php echo $data['title'] ?></b>
		<table width="373" border="0" cellspacing="0" cellpadding="0" class="smalltext">
			<tr>
			  
          <td>(ID: <?php echo $data['id'] ?>, Status: <?php showstatus($data['status']) ?>)</td>
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
		  </table><p>
      <?php if($data['info']) { ?>
		  
		  <table width="351" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="24" align="center" valign="top"><img src="../../gfx/info2.gif" width="15" height="15"></td>
			  <td width="327"><?php echo nl2br($data['info']); ?></td>
			</tr>
		  </table>
	<?php } ?></p>
	<?php if($access['c4']) { ?>
      <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="32"><a href="javascript:show('eigenschaften','')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_prop"></a></td>
            <td><a href="javascript:show('eigenschaften','')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Eigenschaften</a></td>
          </tr>
        </table>
        <div id="eigenschaften"  style="display:none">
		
          <table width="350" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td class="centerline">&nbsp;</td>
              <td colspan="2" align="center">
			  <form action="" method="post" name="properties">
				<table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="56" valign="top">Titel:</td>
                    <td width="244" valign="top"><input name="edit[title]" type="text" value="<?php echo $data[title]; ?>" size="25" maxlength="25" class="text" id=></td>
                  </tr>
                  <tr> 
                    <td valign="top">Info: 
                      <input name="edit[id]" type="hidden"  value="<?php echo $data[id]; ?>"> 
					  <input name="edit[table]" type="hidden"  value="contents">
				    </td>
                    <td valign="top"><textarea name="edit[info]" cols="25" rows="5" class="text"><?php echo $data['info']; ?></textarea></td>
                  </tr>
                  <tr> 
                    <td colspan="2" valign="top" class="smalltext">&nbsp;</td>
                  </tr>
                </table>
                <table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td valign="bottom">eingeschr&auml;nkt:</td>
                    <td valign="top"><a href="#">
                      <input type="checkbox" name="edit[public]" value="1" <?php if($data['public']) echo "checked" ?>>
                      <img src="../../gfx/info.gif" alt="Ist dieser Bereich für alle zugänglich?" border="0"></a></td>
                  </tr>
                  <tr> 
                    <td width="112" height="30">Unterseite von:</td>
                    <td width="228"> 
                      <?php build_dropbox($data); // in detail/functions.php ?>
                    </td>
                  </tr>
                  <tr> 
                    <td height="30" colspan="2"><?php if ($access['c5']) { ?><a href="javascript:properties.submit()" onMouseOver="MM_swapImage('save_prop','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="../../gfx/save.gif" name="savepropx2" border="0" id="save_prop"></a><?php } ?></td>
                  </tr>
                </table>
			    </form>
				</td>
            </tr>
            <tr> 
            <td><a href="javascript:hide('eigenschaften')" onMouseOver="MM_swapImage('less_prop','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_prop"></a></td>
              <td height="16"><img src="../../gfx/line_hori_fade.gif" border="0"></td>
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
            <td width="269"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Seite l&ouml;schen</a></td>
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
                        Diese Seite wirklich l&ouml;schen? Es werden alle Unterseiten 
                        gel&ouml;scht.</p>
					<p><a href="javascript:delform.submit()" onMouseOver="MM_swapImage('ex_del','','../../components/contents/gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../components/contents/gfx/ok.gif" border="0" name="ex_del"></a> 
					  <input name="trash[id]" type="hidden"  value="<?php echo $data[id]; ?>">
					  <input name="trash[parent]" type="hidden"  value="<?php echo $data[parent]; ?>">
					  <input name="trash[type]" type="hidden"  value="contents">
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
		 
		 if($access[c7]) {
		 ?>
      <table width="301" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_pub" border="0"></a></td>
          <td width="269"><a href="javascript:show('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Seite ver&ouml;ffentlichen</a></td>
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
                <?php if ($data[status] == "0") { ?>
                <table width="300" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td colspan="2">Diese Seite jetzt online schalten?</td>
					</tr>
					<tr> 
					  <td width="50" height="37"><a href="#" onClick="javascript:submit(); return false" onMouseOver="MM_swapImage('ok','','gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/ok.gif" alt="bestätigen" border="0" name="ok"></a></td>
					  <td width="239"><input name="publish[allsubpages]" type="checkbox" value="ok">
						alle Unterseiten online schalten 
						<input name="publish[set]" type="hidden" value="1"> <input name="publish[id]" type="hidden" value="<?php echo $data['id'] ?>"></td>
					</tr>
				  </table>
				<?php } else { ?>
				  <table width="300" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td colspan="2">Diese Seite jetzt offline schalten?</td>
					</tr>
					<tr> 
					  <td width="50" height="37"><a href="#" onClick="javascript:submit(); return false" onMouseOver="MM_swapImage('ok','','gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/ok.gif" alt="bestätigen" name="ok" border="0"></a></td>
					  <td width="246"><input name="publish[allsubpages]" type="checkbox" value="ok">
						alle Unterseiten offline schalten 
						<input name="publush[set]" type="hidden" value="0"> <input name="publish[id]" type="hidden" value="<?php echo $data['id'] ?>"></td>
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
              <td colspan="2"><?php if($access[c8]) { ?>
			  	<a href="#" onClick="javascript:scedule.submit(); return false" onMouseOver="MM_swapImage('save','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/save.gif" name="save" border="0"></a> <?php } ?>
                <input name="scedule[id]" type="hidden" value="<?php echo $result[id]; ?>"> </p> 
                <p>* Datum im Format tt.mm.jj</td>
            </tr>
            <tr> 
              <td width="116"> 
              <td colspan="2"> <p></p></td>
            </tr>
          </table>
		</form>
	  	</td>
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
<?php } ?>
</td></tr>
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
</td>
  </tr>
  <tr align="center"> 
    <td colspan="2"> <form action="" method="post" name="form_newpage">
        <div id="newPage" style="display:none"><br>
          <br>
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
                    <td colspan="2">Neue Seite in <b><?php echo $data['title'] ?></b> 
                      erstellen</td>
                    <td align="right" valign="top"><a href="javascript:hide('newPage')" onMouseOver="MM_swapImage('hide_new','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" name="newx1" border="0" id="hide_new"></a></td>
                  </tr>
                  <tr> 
                    <td width="46">
                      	<input name="insert[parent]" type="hidden" value="<?php echo $data['id']; ?>">
						<input name="insert[table]" type="hidden" value="contents">
                      	<input name="insert[type]" type="hidden" value="page"> 
                    </td>
                    <td width="50">Titel:</td>
                    <td width="186"><input name="insert[title]" type="text" size="25"></td>
                    <td width="64" align="center"><a href="#" onClick="submit(); return false" onMouseOver="MM_swapImage('savenew','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/save.gif" name="savenewx1" border="0" id="savenew"></a> 
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
	<?php } ?></td>
  </tr>
</table>				  
