<?php /* Smarty version 2.6.9, created on 2010-09-28 09:14:59
         compiled from /Webserver/vwclub.local/htdocs/liquido/components/contents/detail/templates/page.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/Webserver/vwclub.local/htdocs/liquido/components/contents/detail/templates/page.html', 16, false),array('modifier', 'nl2br', '/Webserver/vwclub.local/htdocs/liquido/components/contents/detail/templates/page.html', 36, false),)), $this); ?>
<link type="text/css" href="../styles.css" rel="stylesheet"  />
<div id="img_saved"></div>

<table id="parents">
	<?php echo $this->_tpl_vars['parents']; ?>


<div id="icon">
	<img src="gfx/page_big.gif" alt="page" />
</div>

<div id="iconcolon">
	
	<div id="details">
		<b id="page_title"><?php echo $this->_tpl_vars['data']['title']; ?>
</b><br />
		(ID: <?php echo $this->_tpl_vars['data']['id']; ?>
, Status: <?php echo $this->_tpl_vars['status']; ?>
)<br />
		erstellt: <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
<br />
		<?php if ($this->_tpl_vars['data']['changedate']): ?>geändert: <?php echo $this->_tpl_vars['data']['changedate'];  endif; ?><br />
		<br />

		<?php if ($this->_tpl_vars['data']['cache']['refresh'] == '6'): ?>
		  <table width="204" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td width="43"><a href="?refresh=<?php echo $this->_tpl_vars['data']['id']; ?>
"><img src="gfx/zahnrad.gif" border="0"></a></td>
			  <td width="161"><a href="?refresh=<?php echo $this->_tpl_vars['data']['id']; ?>
">&Auml;nderungen 
				<br/>
				ver&ouml;ffentlichen </a></td>
			</tr>
		  </table>
		  <br />
		  <?php endif; ?>
		  
		  <?php if ($this->_tpl_vars['data']['info']): ?>
		  <table width="317" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="24" align="center" valign="top"><img src="../../gfx/info2.gif" width="15" height="15"></td>
			  <td width="293"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['info'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
<br /><br /></td>
			</tr>
		  </table>
		  <br />
		<?php endif; ?>
	
		<?php if ($this->_tpl_vars['access']['c4']): ?>
		  <table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="32"><a href="javascript:part('eigenschaften','')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_prop"></a></td>
				<td><a href="javascript:part('eigenschaften','')" onMouseOver="MM_swapImage('more_prop','','gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore();">Eigenschaften</a></td>
			  </tr>
		  </table>
	
		<div id="eigenschaften" class="hidden">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr> 
				<td width="15" height="15" background="../../gfx/x_box/coinsupg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
				<td height="15" background="../../gfx/x_box/sup.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
				<td width="15" height="15" background="../../gfx/x_box/coinsupd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
			  </tr>
			  <tr> 
				<td width="15" background="../../gfx/x_box/g.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
				<td background="../../gfx/x_box/fond.gif" align="left" width="100%">
					
					<form action="" method="post" name="properties" accept-charset="utf-8">
					<table width="300" border="0" cellpadding="0" cellspacing="0">
					  <tr> 
						<td width="56" valign="top">Titel:</td>
						<td width="244" valign="top"><input name="title" type="text" value="<?php echo $this->_tpl_vars['data']['title']; ?>
" size="35" maxlength="50" class="text" onkeyup="$('link').value=L.clean_url(this.value);"></td>
					  </tr>
					  <tr> 
						<td valign="top">Info: 
						  
						</td>
						<td valign="top"><textarea name="info" cols="33" rows="5" class="text"><?php echo $this->_tpl_vars['data']['info']; ?>
</textarea></td>
					  </tr>
					  <tr> 
						<td colspan="2" valign="top" class="smalltext">&nbsp;</td>
					  </tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0">
					  <tr> 
						<td>Von Suche ausschliessen:</td>
						<td >
						  <input type="checkbox" name="public" value="1" <?php if ($this->_tpl_vars['data']['public']): ?>checked<?php endif; ?>>
						  <a href="#"> <img src="../../gfx/info.gif" alt="?" title="Ist dieser Bereich für alle zugänglich?" /></a></td>
					  </tr>
					  <tr>
                        <td height="30">Startseite: </td>
					    <td><a href="#">
                          <input type="checkbox" name="setstartpage" value="1" <?php if ($this->_tpl_vars['data']['id'] == $this->_tpl_vars['startpage']): ?>checked<?php endif; ?> />
                        </a><a href="#"> <img src="../../gfx/info.gif" alt="?" title="Diese Seite als Startseite festlegen" /></a></td>
				      </tr>
					  <tr style="display:none;"> 
						<td width="161" height="30">Seite als RSS veröffentlichen</td>
						<td width="165"><input type="checkbox" name="promoteAsRSS" value="1" <?php if ($this->_tpl_vars['data']['promoteAsRSS']): ?>checked<?php endif; ?> />
						<a href="#"> <img src="../../gfx/info.gif" alt="" title="Diese Seite als RSS ver&ouml;ffentlichen" /></a>
						</td>
					  
					  </tr>
					  <tr style="display:none">
					    <td height="30">Breite des Inhalts: </td>
					    <td><input name="width" type="text" value="<?php echo $this->_tpl_vars['data']['width']; ?>
" size="4" maxlength="5" class="text" id="edit[title]" />
					      px</td>
				      </tr>
					  <tr> 
						<td height="30">Vorlage verwenden: </td>
						<td><?php echo $this->_tpl_vars['templatelist']; ?>
</td>
					  </tr>
					  <tr> 
						<td width="161" height="30">Unterseite von:</td>
						<td width="165"><?php echo $this->_tpl_vars['pageslist']; ?>
</td>
					  </tr>
					  <tr> 
						<td width="161" height="30">Seiten URL</td>
						<td width="165"><input name="cleanURL" type="text" value="<?php echo $this->_tpl_vars['data']['cleanURL']; ?>
" size="35" maxlength="50" class="text" id="link"><br />
						<?php if (! $this->_tpl_vars['data']['cleanURL']): ?><span style="color:#666">System-URL: <?php echo $this->_tpl_vars['data']['cleanURLSystem']; ?>
</span><?php endif; ?>
						</td>
					  </tr>
					  
					  <tr> 
						<td height="30" colspan="2"> 
						  <?php if ($this->_tpl_vars['access']['c5']): ?>
							<a href="javascript:checkSyslinkAndSave();" onMouseOver="MM_swapImage('save_prop','','../../gfx/save_o.gif',1);" onMouseOut="MM_swapImgRestore()">&nbsp;<img src="../../gfx/save.gif" name="savepropx2" id="save_prop" ></a> 
						  <?php endif; ?>
						  </td>
					  </tr>
					</table>
				  </form>			</td>
				<td width="15" background="../../gfx/x_box/d.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
			  </tr>
			  <tr> 
				<td width="15" height="15" background="../../gfx/x_box/coininfg.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
				<td height="15" background="../../gfx/x_box/inf.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
				<td width="15" height="15" background="../../gfx/x_box/coininfd.gif"><img src="../../gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
			  </tr>
			</table>
			<a href="javascript:part('eigenschaften')" onMouseOver="MM_swapImage('less_prop','','gfx/less_o.gif',1);" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" name="less_prop"></a>
			<br/>
		  </div>
		<?php endif; ?>
	
		<?php if ($this->_tpl_vars['access']['c3']): ?>
		<table width="301" border="0" cellspacing="0" cellpadding="0">
		  <tr> 
			<td width="32"><a href="javascript:part('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore()"><img src="gfx/more.gif" alt="Optionen einblenden" border="0" name="more_del"></a></td>
			<td width="269"><a href="javascript:part('delete','')" onMouseOver="MM_swapImage('more_del','','gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore()">Seite l&ouml;schen</a></td>
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
				
				<td background="../../gfx/x_box/fond.gif" align="left" width="100%"><form action="" method="post" name="delform" id="delform">
					<p>Diese Seite wirklich l&ouml;schen? Es werden alle Unterseiten 
					  gel&ouml;scht.</p>
					<p><a href="javascript:document.getElementById('delform').submit()" onMouseOver="MM_swapImage('ex_del','','../../components/contents/gfx/ok_o.gif',1);" onMouseOut="MM_swapImgRestore()"><img src="../../components/contents/gfx/ok.gif" border="0" name="ex_del"></a> 
					  <input name="trash[id]" type="hidden"  value="<?php echo $this->_tpl_vars['data']['id']; ?>
">
					  <input name="trash[parent]" type="hidden"  value="<?php echo $this->_tpl_vars['data']['parent']; ?>
">
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
			  
			<a href="javascript:part('delete')" onMouseOver="MM_swapImage('less_del','','gfx/less_o.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_del"></a><br />
			<br />
		 </div>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['access']['c8']): ?>
		 <table width="301" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td width="32"><a href="javascript:part('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_pub" border="0"></a></td>
			  <td width="269"><a href="javascript:part('publishwindow','')" onMouseOver="MM_swapImage('more_pub','','gfx/more_o.gif',1);" onMouseOut="MM_swapImgRestore();">Seite ver&ouml;ffentlichen</a></td>
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
		
				
					<form action="" method="post" name="publish" id="publish">
				  <?php if ($this->_tpl_vars['data']['status'] == '0'): ?>
					<table width="300" border="0" cellspacing="0" cellpadding="0">
						<tr> 
						  <td colspan="2">Diese Seite jetzt online schalten?</td>
						</tr>
						<tr> 
						  <td width="50" height="37">
							<a href="#" onClick="javascript:document.getElementById('publish').submit(); return false" onMouseOver="MM_swapImage('ok','','gfx/ok_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/ok.gif" alt="bestätigen" border="0" name="ok"></a>					  </td>
						  <td width="239"><input name="publish[allsubpages]" type="checkbox" value="ok">
							alle Unterseiten online schalten 
							<input name="publish[set]" type="hidden" value="1"> <input name="publish[id]" type="hidden" value="<?php echo $this->_tpl_vars['data']['id']; ?>
">					  </td>
						</tr>
					  </table>
					<?php else: ?>
					  <table width="300" border="0" cellspacing="0" cellpadding="0">
						<tr> 
						  <td colspan="2">Diese Seite jetzt offline schalten?</td>
						</tr>
						<tr> 
						  <td width="50" height="37"><a href="#" onclick="$('publish').submit(); return false" onMouseOver="MM_swapImage('ok','','gfx/ok_o.gif',1);" onMouseOut="MM_swapImgRestore()"><img src="gfx/ok.gif" alt="bestätigen" name="ok" border="0"></a></td>
						  <td width="246"><input name="publish[allsubpages]" type="checkbox" value="ok">
							alle Unterseiten offline schalten 
							<input name="publush[set]" type="hidden" value="0"> <input name="publish[id]" type="hidden" value="<?php echo $this->_tpl_vars['data']['id']; ?>
"></td>
						</tr>
					  </table>
					<?php endif; ?>
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
			<a href="javascript:part('publishwindow')" onMouseOver="MM_swapImage('less_pub','','gfx/less_o.gif',1);" onMouseOut="MM_swapImgRestore()"><img src="gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_pub"></a><br />
			<br />
		  </div>
			<?php endif; ?>
		 
		 
		  <table width="301" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td width="32"><a href="javascript:part('statswindow','');"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_stats" border="0"></a></td>
			  <td width="269"><a href="javascript:part('statswindow','');" >Seitenstatstik</a></td>
			</tr>
		  </table>
		  
		<div id="statswindow" class="box <?php if (! $this->_tpl_vars['showstat']): ?>hidden<?php endif; ?>" style="width:500px">
		 	<div class="top"><div class="inner"></div></div>
		 	<div class="body"><div class="inner">
			 	
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['docroot']).($this->_tpl_vars['LIQUIDO'])."/modules/content_stats/templates/statistik.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				
			 </div></div>
			<div class="bottom"><div class="inner"></div></div>
		</div>
		
	
		<table width="301" border="0" cellspacing="0" cellpadding="0" onclick="$('box_blocks').style.display == 'block' ? $('box_blocks').style.display = 'none' : $('box_blocks').style.display = 'block'">
			<tr> 
			  <td width="32"><a href="#"><img src="gfx/more.gif" alt="Optionen einblenden" name="more_stats" border="0"></a></td>
			  <td width="269"><a href="#">Block Zuweisung</a></td>
			</tr>
		</table>
		  
		  
	  <div id="box_blocks" class="box hidden" style="width:100%">
		 <div class="top"><div class="inner"></div></div>
		 <div class="body"><div class="inner" style="padding:10px;">
		 	Weisen Sie diese Seite einem Block zu und setzen Sie die Postition innerhalb des Blockes, indem Sie die Seite per Drag-&-Drop verschieben.
			Wenn Sie noch keinen Block erstellt haben, können Sie dies im Vorlagen-Modul tun.<br><br>
			<br>
			<table>
				<tr>
					<td valign="top">			
					<b>Vorhandene Blöcke:</b>		
						<ul id="box_blocks_list">
						<?php $_from = $this->_tpl_vars['blocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
							<li id="block<?php echo $this->_tpl_vars['e']['id']; ?>
"><?php echo $this->_tpl_vars['e']['title']; ?>
</li>
						<?php endforeach; endif; unset($_from); ?>
						</ul>
					</td>
					
					<td valign="top">
						<b>Seiten im Block:</b>
						<div id="box_blocks_nodes"></div>
					</td>
				
					<td valign="top" id="box_blocks_settings">
						<div id="settings_not_contained" style="display:none">
							<input type="button" onclick="blockAddNode()" value="Seite hinzufügen" />
							
						</div>
						<div id="settings_contained" style="display:none">
							<input type="button" onclick="blockRemoveNode()" value="Seite entfernen" />
							
						</div>
					</td>
				</tr>
			</table>
			
		 </div></div>
		 
		 <div class="bottom"><div class="inner"></div></div>
	  </div>
	</div>
</div> 

<div id="childlist">
	<?php echo $this->_tpl_vars['childlist']; ?>

</div>




<form action="" method="post" name="form_newpage">
    <div id="box_newPage" class="hidden">
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
          <td colspan="2" rowspan="3" align="center">
		  <table width="300" border="0" cellspacing="2" cellpadding="2">
              <tr> 
                <td colspan="2"><strong>Neue Seite  
                erstellen</strong></td>
                <td align="right" valign="top"><a href="javascript:hide('box_newPage')" onMouseOver="MM_swapImage('hide_new','','gfx/less_o.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="gfx/less.gif" alt="Optionen ausblenden" name="newx1" border="0" id="hide_new"></a></td>
              </tr>
              <tr> 
                <td width="50">Titel:</td>
                <td width="172">
					<input name="insert[title]" type="text" id="title" size="25">
                  <input name="insert[parent]" type="hidden" value="<?php echo $this->_tpl_vars['data']['id']; ?>
">
                  <input name="insert[table]" type="hidden" value="contents" />
                  <input name="insert[type]" type="hidden" value="page"></td>
                <td width="78" align="center">
					<input type="image" src="../../gfx/save.gif" name="savenewx1" border="0" id="savenew">
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

  