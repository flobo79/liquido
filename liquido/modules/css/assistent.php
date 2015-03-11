<?php 
	  // lese alle parameter als variablen ein
	  $currstyle['values'] = sourcetovalues ($currstyle['source']);
	  
	  if($mode == "advanced") {
	  ?>
	<div style="float:left; width=150px;"> <a href="<?php echo $PHP_SELF ?>?show=type">Schrift</a><br>
   
		Hintergrund<br>
		Umrandung<br>
		Box<br>
		Block<br>
		Liste<br>
		Positionierung<br>
		Erweiterungen
	</div>
	<div style="float:left; margin-left:20px;"> 
		<?php
			if(!$show) $show = "type";
			include("_".$show.".php");	  
		?>
	</div>
<?php } else {  ?>
	<textarea name="set[source]" cols="50" rows="12" class="CONTOR_formtext"><?php
	 	$foo = explode(";",$currstyle['source']);
		$trash = array_pop($foo);
		foreach($foo as $fooo) {
			$bar .= trim($fooo).";\n";
		}
		echo $bar;
}
?></textarea>
