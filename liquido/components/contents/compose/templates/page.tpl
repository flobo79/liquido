<table width="433" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="80" height="250" align="center" valign="top" class="centerline"><a href="body.php?setmode=preview" target="middle"><img src="gfx/page_big.gif" border="0"></a></td>
    <td width="350" valign="top">
	<br/>
	<p><b>{$data.title}</b>
      <table width="191" border="0" cellspacing="0" cellpadding="0" class="smalltext">
        <tr> 
          <td>(ID: {$data.id}, Status: {$status})</td>
        </tr>
        <tr> 
          <td width="191">erstellt: {$data.date}</td>
        </tr>
        <tr> 
          <td>ge&auml;ndert: {$data.changedate}</td>
        </tr>
      </table>
      <p> 
      {if $data.cache.refresh == "6"}
      <table width="204" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="43"><a href="?refresh={$data.id}"><img src="gfx/zahnrad.gif" border="0"></a></td>
          <td width="161"><a href="?refresh={$data.id}">&Auml;nderungen 
            <br>
            ver&ouml;ffentlichen </a></td>
        </tr>
      </table>
      {/if}
      {if $data.info}
      <table width="317" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="24" align="center" valign="top"><img src="../../gfx/info2.gif" width="15" height="15"></td>
			  <td width="293">{$data.info|nl2br}<br></td>
			</tr>
	  </table>
	{/if}
	{if $access.c4}
      <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="32"><a href="javascript:show('eigenschaften','')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_prop"></a></td>
            <td><a href="javascript:show('eigenschaften','')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Eigenschaften</a></td>
          </tr>
      </table>
        <div id="eigenschaften"class="hidden">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coinsupg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/sup.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coinsupd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" background="../../gfx/x_box/g.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    		<td background="../../gfx/x_box/fond.gif" align="left" width="100%">
				
				<form action="" method="post" name="properties">
                <table width="300" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="56" valign="top">Titel:</td>
                    <td width="244" valign="top"><input name="edit[title]" type="text" value="<?php echo $data[title]; ?>" size="35" maxlength="50" class="text" id=></td>
                  </tr>
                  <tr> 
                    <td valign="top">Info: 
                      <input name="edit[id]" type="hidden"  value="<?php echo $data[id]; ?>"> 
                      <input name="edit[table]" type="hidden"  value="contents"> 
                    </td>
                    <td valign="top"><textarea name="edit[info]" cols="33" rows="5" class="text"><?php echo $data['info']; ?></textarea></td>
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
                    <td height="30">Seite nicht cachen: </td>
                    <td><a href="#">
                      <input type="checkbox" name="nocache" value="1" <?php if($data['cache']['refresh'] == "-1") echo "checked" ?>>
                      </a><a href="#"> <img src="../../gfx/info.gif" alt="Diese Seite nicht zwischenspeichern" border="0"></a></td>
                  </tr>
                  <tr> 
                    <td height="30">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td width="118" height="30">Unterseite von:</td>
                    <td width="182"> 
                      <?php //build_dropbox($data); // in detail/functions.php ?>
                    </td>
                  </tr>
                  <tr> 
                    <td height="30" colspan="2"> 
                      {if $access.c5}
                      <a href="javascript:properties.submit()" onMouseOver="MM_swapImage('save_prop','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="../../gfx/save.gif" name="savepropx2" border="0" id="save_prop"></a> 
                      {/if}
                    </td>
                  </tr>
                </table>
              </form>
			</td>
            <td width="15" background="../../gfx/x_box/d.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coininfg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/inf.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coininfd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table>
        <a href="javascript:hide('eigenschaften')" onMouseOver="MM_swapImage('less_prop','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_prop"></a><br>
        <br>
      </div>
		{/if}
		{if $access.c3}
        <table width="301" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_del"></a></td>
            <td width="269"><a href="javascript:show('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Seite l&ouml;schen</a></td>
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
                <p>Diese Seite wirklich l&ouml;schen? Es werden alle Unterseiten 
                  gel&ouml;scht.</p>
                <p><a href="javascript:delform.submit()" onMouseOver="MM_swapImage('ex_del','','../../components/contents/gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../components/contents/gfx/ok.gif" border="0" name="ex_del"></a> 
                  <input name="trash[id]" type="hidden"  value="<?php echo $data[id]; ?>">
                  <input name="trash[parent]" type="hidden"  value="<?php echo $data[parent]; ?>">
                  <input name="trash[type]" type="hidden"  value="contents">
                </p>
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
        <br>
      </div>
		{/if}
		{if $access.c4}
      <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="32"><a href="javascript:show('template')" onMouseOver="MM_swapImage('more_temp','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_temp"></a></td>
            
          <td width="265"><a href="javascript:show('template')" onMouseOver="MM_swapImage('more_temp','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Vorlage</a></td>
          </tr>
      </table>
        
      <div id="template" class="hidden"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coinsupg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/sup.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coinsupd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" background="../../gfx/x_box/g.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td background="../../gfx/x_box/fond.gif" align="left" width="100%"><form name="template" method="post" action="">
                Diese Gruppe verwendet die Vorlage:<br>
                <br>
                {$templatelist}
                <br>
                <br>
                {if $access.c5}
                <a href="#" onClick="javascript:template.submit();" onMouseOver="MM_swapImage('seltemp','','../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="../../gfx/save.gif" name="seltemp" border="0"></a> 
                {/if}
                <input name="edit[id]" type="hidden"  value="{$data.id}">
                <input name="edit[table]" type="hidden"  value="contents">
              </form></td>
            <td width="15" background="../../gfx/x_box/d.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coininfg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/inf.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coininfd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table>
        <a href="javascript:hide('template')" onMouseOver="MM_swapImage('less_temp','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" name="less_temp" width="19" border="0"></a><br>
      </div>
	{/if}
	{if $access.c7}
      <table width="301" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_pub" border="0"></a></td>
          <td width="269"><a href="javascript:show('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Seite ver&ouml;ffentlichen</a></td>
        </tr>
      </table>
      <div id="publishwindow"class="hidden">
	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coinsupg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/sup.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coinsupd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" background="../../gfx/x_box/g.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            
    <td background="../../gfx/x_box/fond.gif" align="left" width="100%">
	
				{if $access.c8}
				<form action="" method="post" name="publish">
                <br>
                {if $data.status == "0"}
                <table width="300" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td colspan="2">Diese Seite jetzt online schalten?</td>
					</tr>
					<tr> 
					  <td width="50" height="37"><a href="#" onClick="javascript:submit(); return false" onMouseOver="MM_swapImage('ok','','gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/ok.gif" alt="bestätigen" border="0" name="ok"></a></td>
					  <td width="239"><input name="publish[allsubpages]" type="checkbox" value="ok">
						alle Unterseiten online schalten 
						<input name="publish[set]" type="hidden" value="1"> <input name="publish[id]" type="hidden" value="{$data.id}"></td>
					</tr>
				  </table>
				{else}
				  <table width="300" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td colspan="2">Diese Seite jetzt offline schalten?</td>
					</tr>
					<tr> 
					  <td width="50" height="37"><a href="#" onClick="javascript:submit(); return false" onMouseOver="MM_swapImage('ok','','gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/ok.gif" alt="bestätigen" name="ok" border="0"></a></td>
					  <td width="246"><input name="publish[allsubpages]" type="checkbox" value="ok">
						alle Unterseiten offline schalten 
						<input name="publush[set]" type="hidden" value="0"> <input name="publish[id]" type="hidden" value="{$data.id}"></td>
					</tr>
				  </table>
				 {/if}
      </form>
	 {/if}
			</td>
            <td width="15" background="../../gfx/x_box/d.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coininfg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/inf.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coininfd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table> 
	    <a href="javascript:hide('publishwindow')" onMouseOver="MM_swapImage('less_pub','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_pub"></a><br>
        <br>
      </div>
      <table width="301" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('statswindow','')" onMouseOver="MM_swapImage('more_stats','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_stats" border="0"></a></td>
          <td width="269"><a href="javascript:show('statswindow','')" onMouseOver="MM_swapImage('more_stats','','gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Statstik</a></td>
        </tr>
      </table>
      <div id="statswindow" class="hidden">
	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coinsupg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/sup.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coinsupd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" background="../../gfx/x_box/g.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    		<td background="../../gfx/x_box/fond.gif" align="left" width="100%">
				<?php require($_SERVER['DOCUMENT_ROOT']."/liquido/modules/content_stats/single_page.php"); ?>
			</td>
            <td width="15" background="../../gfx/x_box/d.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
          <tr> 
            <td width="15" height="15" background="../../gfx/x_box/coininfg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td height="15" background="../../gfx/x_box/inf.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
            <td width="15" height="15" background="../../gfx/x_box/coininfd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          </tr>
        </table> 
	    <a href="javascript:hide('statswindow')" onMouseOver="MM_swapImage('less_stats','','gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_stats"></a><br>
        <br>
      </div>

	</td>
	</tr>
	<tr> 
		<td colspan="2"> 
		  <table width="400" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td width="40">&nbsp;</td>
			  <td>
				{$childlist}
			  </td>
			</tr>
		  </table>
		</td>
  </tr>
  <tr align="center"> 
    <td colspan="2">

	</td>
  </tr>
  {if $access.c1}
	  <tr align="center"> 
		<td colspan="2">
		<?php include("templates/newpage.php"); ?>	
		</td>
	  </tr>
  {/if}
</table>				  
