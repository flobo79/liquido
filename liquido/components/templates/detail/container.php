<table width="451" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="96" height="82" align="center"><img src="gfx/container.gif"></td>
    <td width="355" class="headline"><p><br>
        Vorlagen-Container</p>
      </td>
  </tr>
  <tr align="center"> 
    <td height="195" colspan="2"><form action="" method="post" name="newgroup">
      </form>
		<table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="32"><a href="javascript:show('addpanel','')" onMouseOver="MM_swapImage('add','','../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/more.gif" alt="Optionen einblenden" border="0" name="add"></a></td>
            
          <td><a href="javascript:show('addpanel','')" onMouseOver="MM_swapImage('add','','../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Objekt 
            hinzuf&uuml;gen</a></td>
          </tr>
        </table>
        <div id="addpanel"  style="display:none">
		
          <table width="350" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td class="centerline">&nbsp;</td>
              <td colspan="2" align="center">
			 
			  <form action="" method="post" enctype="multipart/form-data" name="properties">
				<table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="82" valign="top">Bezeichnung:</td>
                    <td width="218" valign="top"><input name="edit[title]" type="text" value="<?php echo $data[title]; ?>" size="25" maxlength="25" class="text" id=></td>
                  </tr>
                  <tr> 
                    <td valign="top">&nbsp;</td>
                    <td valign="top"><input name="file" type="file" size="15"></td>
                  </tr>
                  <tr> 
                    <td colspan="2" valign="top" class="smalltext">&nbsp;</td>
                  </tr>
                </table>
                <table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="340" height="30"> <a href="javascript:editors.submit()" onMouseOver="MM_swapImage('savegroupx','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">
                      <?php if ($access[c3]) { ?>
                      </a><a href="javascript:newgroup.submit()" onMouseOver="MM_swapImage('savenewx1','','../../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/save.gif" name="savenewx1" border="0" id="savenewx1"></a> 
                      <?php } ?>
                      <input name="insert[table]" type="hidden" value="templates"> 
                      <input name="insert[type]" type="hidden" value="template"> 
                      <input name="insert[rank]" type="hidden" value="x"> </td>
                  </tr>
                </table>
				 </form>
				</td>
            </tr>
            <tr> 
            <td><a href="javascript:hide('addpanel')" onMouseOver="MM_swapImage('less_prop','','../../gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_prop"></a></td>
              <td height="16"><img src="../../gfx/line_hori_fade.gif" border="0"></td>
            </tr>
			<tr>
				<td colspan="2" height="20"></td>
			</tr>
          </table>
        </div></td>
  </tr>
</table>
