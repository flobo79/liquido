<table width="451" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="96" height="82"><img src="../gfx/logo.gif" width="77" height="74"></td>
    <td width="355" class="headline"><p><br>
        Neue Vorlage erstellen</p>
      </td>
  </tr>
  <tr align="center"> 
    <td height="195" colspan="2"><form action="" method="post" name="newgroup">
        <table width="300" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="104">Bezeichnung:</td>
            <td><input name="insert[title]" type="text" id="input" value="<?php echo $insert[title]; ?>" size="25"></td>
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
            <td height="41" colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2" valign="top">
				<?php if ($access['c3']) { ?>
              	<a href="#" onClick="javascript:document.newgroup.submit()" onMouseOver="MM_swapImage('savenewx','','../../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/save.gif" border="0" name="savenewx"></a> 
              <?php } ?>
              <input name="insert[table]" type="hidden" value="templates">
              <input name="insert[rank]" type="hidden" value="x"> </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
