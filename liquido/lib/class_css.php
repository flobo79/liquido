<?php

class CSS {
	function CSS() {
		$this->types = array(array("html-Stil",""),array("Objekt-Stil","#"),array("eigener Stil","."));
	}
	
	function readCss ($file) {
		if(file_exists($file)) {
			$css = explode("}",implode("\n",file ($file)));
			$i=1;
			foreach($css as $entry) {
				$style = ereg("(.*)\{(.*)",$entry,$reg);
				$styles[$i]['title'] = trim($reg[1]);
				$styles[$i]['source'] = $reg[2];
				
				$i++;
			}
			
			$trash = array_pop($styles);		
			asort($styles);
			return $styles;
		
		} else {
			echo "CSS: Datei $file existiert nicht";
		}
	}

	function valuestosource ($values) {
		foreach($values as $name => $value) {
			// sonderfälle
			if($name == "background-image:" and !ereg("url(",$value)) $value = "url($value)";

			$source .= "	$name: $value;\n";
		}
			
		return $source;
	}
	
	function sourcetovalues ($source) {
		// get parameter
		$values = array();
		$valuesraw = explode(";",$source);
		$trash = array_pop($valuesraw);		// lösche leeres feld am ende			
		
		foreach($valuesraw as $thisvalue) {
			$thisvalue = explode(":",$thisvalue);
			// prüfe sonderfälle
			
			$values[trim($thisvalue[0])] = $thisvalue[1];
		}
		
		return $values;
	}
	
	function addStyle ($style,$file) {
		$newstyle = $style." { \n}";
				
		$fp = fopen($file,"a");
		fwrite ($fp, $newstyle);
		fclose($fp);
	}
	
	function removeStyle ($styles,$id,$file,$replace=0) {
		$title = $styles[$id]['title'];
		unset($styles[$id]);
		$this->saveCss($styles,$file);
		
		if($replace) $this->updateContents($title,$replace);
		return $styles;
	}
	
	function updateContents ($style,$replace) {
		db_query("update ".db_table("contents")." set contents_css = '$replace' where content_css = '$style' ");
	}
	
	function updateCSS ($save,$id,$styles,$file) {
		$oldtitle = $styles[$id]['title'];
		$styles[$id] = $save;
		$this->saveCss ($styles,$file);
	}
	
	function saveCss ($styles,$file) {
		foreach($styles as $style) {
			$newfile .= trim($style['title'])." {\n";
			$sourcelines = explode(";",$style['source']);
			array_pop($sourcelines); //trash
			
			foreach($sourcelines as $sourceline) {
				$sourcevalues = explode(":",$sourceline);
				$newfile .= "	".trim($sourcevalues[0]).": ".trim($sourcevalues[1]).";\n";
			}
			unset($sourcevalues,$sourcelines,$sourceline);

			$newfile .= "}\n";		
		}
		
		$fp = @fopen($file,"w");
		if($fp) {
			fwrite ($fp, $newfile);
			fclose ($fp);
		} else {
			echo "CSS: Fehler: keine Schreibrechte auf $file";
		}
	}
}


?>