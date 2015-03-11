<table width="451" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="96" height="82" align="center"><img src="gfx/template.gif"></td>
    <td width="355" class="headline"><p><br>
        Strukturen </p></td>
  </tr>
  <tr> 
    <td height="195" align="center"></td>
    <td height="195">
      <?php if($data[info]) { ?>
      <table width="351" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="24" align="center" valign="top"><img src="../../gfx/info2.gif" width="15" height="15"></td>
          <td width="327"><?php echo nl2br($data[info]); ?></td>
        </tr>
      </table>
	<?php } ?>
	 <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('addpanel','')" onMouseOver="MM_swapImage('add','','../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/more.gif" alt="Optionen einblenden" border="0" name="add"></a></td>
          <td><a href="javascript:show('addpanel','')" onMouseOver="MM_swapImage('add','','../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"> 
            Struktur erstellen</a></td>
        </tr>
      </table>
      <div id="addpanel"  style="display:none"> 
        <table width="350" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td class="centerline">&nbsp;</td>
            <td colspan="2" align="center"> <form action="" method="post" enctype="multipart/form-data" name="properties">
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
              </form></td>
          </tr>
          <tr> 
            <td><a href="javascript:hide('addpanel')" onMouseOver="MM_swapImage('less_prop','','../../gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_prop"></a></td>
            <td height="16"><img src="../../gfx/line_hori_fade.gif" border="0"></td>
          </tr>
          <tr> 
            <td colspan="2" height="20"></td>
          </tr>
        </table>
      </div>
	
	</td>
  </tr>
</table>
