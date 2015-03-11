<?php
	// contor-default seite
	// kann für das tool manipuliert werden
	if(!$page) $page = "body.php";

?>

<div style="width:180px; text-align: left; margin: 0 auto;">
	<form method="post" action="">
    <p><strong>CSS-Set: </strong><br>
    	<select name="selectcssfile" onChange="submit()">
        <?php foreach($cssfiles as $id => $cssfile) {
				
				$selected = ($id == $plugindata['cssfile']) ? "selected" : "";
				echo "  <option value=\"$id\"$selected>$cssfile[1]</option>\n";			  
			} ?>
		<option value="editlist" style="background-color:#EFEFEF;" <?php if($editlist) echo "selected" ?>>Liste bearbeiten</option>
      </select>
      <br>
      Datei: <?php echo $cssfiles[$plugindata['cssfile']][0] ?> </p>
          
    <?php if(is_array($styles)) { ?>
	<p><strong>vorhande Stile:</strong><br />
      <?php 
		foreach ($styles as $key => $thisstyle) {
			echo "<a href=\"$page?selectstyle=".$key."\">".$thisstyle['title']."</a><br />\n";
		}
		?>
    </p>
	<?php } ?>
	</form>
    
  <p><a href="<?php echo $page ?>?makenewStyle=true">+ Stil erstellen</a></p>
  <p>Hilfe zu CSS unter:<br>
    <a href="#" onclick="window.open('http://www.css4you.de');">www.css4you.de</a> 
  </p>
</div>