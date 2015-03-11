<?php
	// file einlesen	
	if($_FILES['importfile']['tmp_name']) importfile($_FILES['importfile']);
	
	$SID = session_id();
	
	if(file_exists($getimportfile = $_SERVER['DOCUMENT_ROOT']."/liquido/templates_c/".$SID.".csv")) $importfile = $getimportfile;

	if($_GET['delcsv'] && $importfile) {
		unlink($importfile);
		unset($importfile);
	}
		
	if($importfile) {
		$showfields = array("form","firstname","name","email","company");
		
		// read in file
		$thefile=file($importfile);
		$lines = count($thefile);
		
		// detect separator
		$counts = 0;
		$sep = '';
		$separators = array(";",",","\t","-","x");
		foreach($separators as $key => $separator) {
			$count = substr_count($thefile[0], $separator);
			
			if($count > $counts) {
				$sep = $separator;
				$counts = $count;
			}
		} 

		if($sep == "x") $sep = ",";
		$separator = $sep;
		
		$csv_fields = explode($separator,$thefile[0]);
		$list_db_fields = "<option value=\"\"></option>\n";
		
		foreach($csv_fields as $key => $field) {
			$list_db_fields .= "<option value=\"$key\">".htmlspecialchars($field)."</option>\n";
		}

		// load Groups
		$groups = getgroups();
	}
	
	include(dirname(dirname(__FILE__))."/lang.inc.php");
	if($_POST['import']) 	$importresult 	= import($_POST['import']);
?>


<div class="content_centered">
	<h1>Abonnenten importieren</h1>
	<form action="<?php echo $PHP_SELF ?>" method="post" enctype="multipart/form-data">
     
	 <?php if(!$importfile) { ?>
		Unterst&uuml;tzt wird der  Import von Kontakten im Dateiformat CSV (Comma Separated Values, durch Komma getrennte Werte).<br>
		<br>
		CSV-Datei
            <input type="file" name="importfile" /> <p>
              <input type="submit" name="btnLDI" value="Datei einlesen" />
            </p><br>
			
<?php } elseif ($importfile) { ?>
        <table width="579" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2"><p>Die vorhandene CSV-Datei enth&auml;lt <?php echo $lines ?> Eintr&auml;ge.<br>
              automatisch erkanntes Trennzeichen: &quot;<?php echo $separator ?>&quot;</p>
              <p><strong>Bitte ordnen Sie die Felder Ihrer Adress-Datei den Zielfeldern zu:</strong></p></td>
          </tr>
          <tr> 
            <td height="39">Abonnentengruppenfeld</td>
            <td width="392">Feld in CSV-Datei</td>
          </tr>
          <?php 
		  
		  foreach ($showfields as $key => $field) { 
		  	if($lng['de_DE'][$field]) {
		  ?>
          <tr> 
            <td><?php echo $lng['de_DE'][$field]; ?> </td>
            <td>
				<select name="import[field][<?php echo $field ?>]" />
                	<?php echo $list_db_fields ?>
				</select>
			</td>
          </tr>
          <?php }} ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">Import in Gruppe: </td>
            <td>
			<?php
			foreach($groups as $key => $value) {
				$checked = $insert['group'][$value['id']] ? "checked" : "";
				echo "<input type=\"checkbox\" name=\"import[groups][]\" value=\"".$value['id']."\" $checked >".$value['title']."<br>\n";
			}
			?>
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Anf&uuml;hrungszeichen entfernen : </td>
            <td><input name="import[striphyphens]" type="checkbox" value="1" checked />
            </td>
          </tr>
          <tr>
            <td>Erste Zeile &uuml;berspringen:</td>
            <td><input name="import[skipfirstline]" type="checkbox" value="1" checked /></td>
          </tr>
          <tr> 
            <td width="187">vorhandene &uuml;berscheiben:</td>
            <td><input type="checkbox" name="import[overwrite]" value="1" /></td>
          </tr>
          <tr> 
            <td colspan="2">
				<input name="import[file]" type="hidden" value="<?php echo $importfile ?>" /> 
				<input name="import[separator]" type="hidden" value="<?php echo $separator ?>" />
				<input name="import[fields]" type="hidden" value="<?php echo implode(",",$showfields); ?>" />
				<input name="page" value="import.php" type="hidden" />
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="importieren" /></td>
          </tr>
          <tr> 
            <td><?php if($importresult) { echo $importresult." Abos importiert."; } ?></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        vorhandene CSV-Datei: <input type="button" name="delete" value="l&ouml;schen" onclick="document.location.href='?delcsv=true&page=import.php'" />
        <?php } elseif ($importresult) { ?>
			<?php echo $importresult ?>
        <?php } ?>
		<p>
		  <input name="page" value="import.php" type="hidden" />
      </p>
	</form>
</div>