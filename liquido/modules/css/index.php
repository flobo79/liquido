<style>
	select { font-size:8pt; height: 18px; }
	#options_right {
		position: absolute;
		background: #E9E9E9 url(/<?php echo $settings['contorpath'] ?>images/infohigr2.gif);
		height: 100%; width:240px;
		text-align: center;
		right:0px; top:0px;
	}
</style>
<script language="JavaScript">
	function del(id) {
		ConfirmAction('CSS-Link l�schen?','document.location.href=\'body.php?delcss='+id+'\'');
	}
</script>
<div style="text-align:left; margin-right:100px;">
  <?php if ($editlist) { ?>
  <form name="form1" method="post" action="">
    <table width="488" border="0" cellspacing="0" cellpadding="0" summary="Liste der vorhandenen CSS-Links">
      <caption style="text-align:left; font-weight:bold;">
			CSS-Links bearbeiten<br />
		</caption>
      <tr>
        <td width="130">Beschreibung</td>
        <td width="358">CSS-Dateipfad</td>
      </tr>
      <?php for($i=1;$entry = $dbcssfiles[$i];$i++) {    ?>
	  <tr>
        <td>
          <input name="<?php echo "edit[".$entry['css_id']."][css_desc]"; ?>" type="text" size="15" maxlength="30" value="<?php echo $entry['css_desc'] ?>" />
      </td>
        <td>
          <input name="<?php echo "edit[".$entry['css_id']."][css_file]"; ?>" type="text" size="50" maxlength="50" value="<?php echo $entry['css_file'] ?>" />
          <?php if($entry['css_id'] != '2') { ?><input type="button" name="button" value="x" onclick="del('<?php echo $entry['css_id'] ?>');" /><?php } ?>
          <input name="edit[<?php echo $entry['css_id']?>][css_id]" type="hidden" value="<?php echo $entry['css_id'] ?>" />
        </td>
      </tr>
	  <?php } ?>
      <tr>
        <td>
          <input type="submit" name="Submit" value="speichern" />
        </td>
        <td>
          <input type="hidden" name="hiddenField" />
        </td>
      </tr>
      
    </table>
    <br>
    <table width="488" border="0" cellspacing="0" cellpadding="0" summary="Liste der vorhandenen CSS-Links">
      <caption style="text-align:left; font-weight:bold;">
    CSS-Link einf&uuml;gen<br />
</caption>
      <tr>
        <td width="130">
        
          <input name="add[css_desc]" type="text" size="20" maxlength="20" value="" />
        
      </td>
        <td width="358">
          <input name="add[css_file]" type="text" size="50" maxlength="50" value="" />
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" name="Submit" value="speichern" />
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </form>

  <?php } elseif(!$iswriteable) { ?>
	<img src="../../images/warning.gif" /> Achtung! <br>
	Die Datei <?php echo $cssfile ?> ist nicht beschreibbar. Bitte �ndern Sie die 
	Zugriffsrechte. 
<?php } else { 
	if ($_GET['makenewStyle']) {  ?>
<form method="post" action="?">
  <p class="CONTOR_headline">Neuen Stil erstellen:</p>
    <p>Name: 
      <input name="addstyle" type="text" id="addstyle" size="15" maxlength="30" />
      Typ: 
      <select name="addstyle_type">
        <?php foreach($css -> $types as $type) echo "<option value=\"$type[1]\">$type[0]</option>\n"; ?>
      </select>
      <br>
      <br>
      <input type="submit" name="Submit" value="erstellen" />
      <input type="button" name="Button" value="abbrechen" onclick="document.location.href='<?php echo $page ?>?selectstyle=<?php echo $plugindata['currstyleid'] ?>'" />
    </p>
</form>
  <p>
  <div onclick="changenode('hint');" class="link"><img src="/<?php echo $settings['contorpath'] ?>images/n_close.gif" alt="open" title="[lng 1_move_up]" name="hint_node" /> Hinweis</div><br />

  <div id="hint" class="hidden"> 
    <p>Bei der Erstellung von CSS-Stilen beachten Sie bitte folgende Typen:<br />
      .meinStil - symbolisiert einen eigenen Stil<br>
      <br>
      #meinStil - ist ein Objekt-Stil und wird �ber die Objekt-id zugewiesen. 
      Dieser Stil kann nur einmal&nbsp;pro Seite vergeben werden.<br>
      <br />
      meinStil - ein html-Tag-Stil (Bsp: form) zum editeren von html-Elementen
    </p>
  </div>
  
<?php } elseif ($_GET['delstyle']) { ?>
<form method="post" action="?">
  <p class="CONTOR_headline">Stil <?php echo $currstyle['title'] ?> l&ouml;schen?</p>
  <p> 
    <?php 
	// lade verwendungen
	$uses = checkUses($currstyle);

  	if($uses[0]) {
		?>Achtung, dieser Stil wird auf <?php echo count($uses[0]) ?> Seiten verwendet!<br />
		<a href="#" onclick="part('pages'); return false">&raquo; zeige Seiten</a><br />
		<div id="pages" style="display:none;">
		<?php 
		foreach($uses as $use) {
			echo "&nbsp;- ".$use['title']."<br />\n";
		} 
		?>
  		</div>	
		<br />
		Möchten Sie den betroffen Objekten einen anderen Stil zuweisen?<br />
		Alternativ-Stil: 
		<select name="delstyle[replace]">
			<option value=""></option>
			<?php foreach($styles as $id => $style) {
				if($id != $plugindata['currstyleid']) echo "  <option value=\"".$style['title']."\"$selected>$style[title]</option>\n";			  
			} ?>
		</select>
	<?php } ?>
  	
  <p> 
    <input name="delstyle[submit]" type="submit" id="delstyle[submit]" value=" l&ouml;schen " />
    <input type="button" name="Button" value="abbrechen" onclick="document.location.href='<?php echo $page ?>?selectstyle=<?php echo $plugindata['currstyleid'] ?>'" />
    <input name="delstyle[id]" type="hidden" id="delstyle[id]" value="<?php echo $plugindata['currstyleid'] ?>" />
  </p>
</form>




<?php } elseif ($currstyle) { ?>
<br />
<form method="post" action="">
    Bezeichnung: 
    <input name="set[title]" type="text" id="set[title]" value="<?php echo $currstyle['title'] ?>" maxlength="50" /> 
	<?php
	$type = ereg("^\.",$currstyle['title']) ? "class" :
			(ereg("^#",$currstyle['title']) ? "div" : "html");
		
	$types = array(
		"html" => "html-Elemtent",
		"div" => "Objekt-Stil",
		"class" => "eigener Stil"
	);
	
	echo $types[$type];
	?>
	<hr size="1">
	<textarea name="set[source]" cols="50" rows="12" wrap="OFF" class="CONTOR_formtext"><?php
		$foo = explode(";",$currstyle['source']);
		$trash = array_pop($foo);
		foreach($foo as $fooo) {
			$bar .= trim($fooo).";\n";
		}
		echo $bar;
	?></textarea>
        
		<br>
	<input type="submit" name="savecss" value="speichern" />
  	<input type="button" name="Button" value="Stil l&ouml;schen" onclick="document.location.href='<?php echo $PHP_SELF ?>?delstyle=true';"/>
</form><br />
	<br />
	<style type="text/css">
		#preview {
		<?php echo $currstyle['source'] ?>
			position:relative;
			top:10px;
		}
	</style>
	<strong>Vorschau: </strong>
	<div id="preview"><?php echo $currstyle['title'] ?></div>

	<?php } else { ?>
	<div> 
		<p>Bitte w&auml;hlen Sie einen CSS-Stil aus, um diesen zu bearbeiten.</p>
		<p>Weitere Informationen zur Verwendung von CSS unter <a href="#" onclick="window.open('http://www.css4you.de');">www.css4you.de</a></p>
	</div>
	<?php } ?>
	
<?php } ?>
</div>
