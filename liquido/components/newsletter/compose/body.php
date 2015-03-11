<?php

	if($access['c9']) {
		if ($thiscomp['id']) {
			$nlobj = getdata($thiscomp['id']);
			if($nlobj['status'] >= "1") {
				$include = "redaktionsschluss.php";
			} else {
				$css = new CSS;
				$styles = $css->readCss($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/css/objects.css");

				if($styles) {
					reset($styles);
					
					$css_styles = "<select name=\"objectdata[objid][contents_css]\" class=\"css_box\" id=\"set_css\">\n";
					$css_styles .= "	<option>auswählen...</option>\n";
					foreach($styles as $key => $style) {
						// ohne id-styles
						if(preg_match("/^\./",$style['title'])) {
							$title = substr($style['title'],1);
							$css_styles .= "	<option value=\"".$style['title']."\">".$title."</option>\n";
						}					
					}
					$css_styles .= "</select>";
				} else {
					echo "Stile nicht geladen";
				}
			
				$include = "redaction.php";
			}
		} else {
			$include = "overview.php";
		}
	} else { 
		$include = "noaccess.php";
	}
		
	include ("tpl_head.php");
	include($include);
	include ("tpl_footer.php");
	
?>