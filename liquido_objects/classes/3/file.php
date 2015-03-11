<?php


// contents-template
$objecttitle = "Inhaltseite laden";
$thisobject['formrows'] = "5";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "text";
$thisobject['textwidth'] = $contentwidth - $result['text2'];


if($fmode) $part = "public";

if ($part == "compose" && $this->request['display'] != 'inline') include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/components/contents/compose/templates/object_head.php");

$cols = trim($result['text']);
$cols = explode(";", $cols);
if(count($cols) > 1) $usetable = true;

foreach($cols as $col) {
	$col = explode(",",$col);
}

?>

<div class="objectcontent">
<?php

if($result['text']) {
	if($usetable) { echo "	<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
		<tr>\n";
		if($result['smalltext2']) echo "<td width=\"$result[smalltext1]\"></td>\n";
	}
	
	foreach($cols as $i => $col) {
		$col = explode(",",$col);
		
		if(intval($col[0])) {
			$load['id'] = $col[0];
			$load['contentwidth'] = $col[1];
			
			$parser = new Parser();
			$node = new Node($load['id']);
			$node->width = $col[1] ? $col[1] : $contentwidth;
			$code = $node->listobjects();
			$hover = '';
			
			if($part == "compose") {
				$code = "<span class=\"compose_edit_include\" onclick=\"parent.left.location.href='left_pane.php?select[id]=$col[0]';\">editieren</span><br/>\n".$code;
				$hover = 'hoverborder';
			}
			
			// add parent box
			$code = "<div class=\"classes_1_inner $hover\" >$code</div>";
			
			// if multi column - add table markup
			if($usetable) $code = "<td width=\"$col[1]\" valign=\"top\">".$code."\n</td>\n";
			
			
			$parser->html = $code;
			echo $parser->parse();
			
			if($result['smalltext1']) echo "<td width=\"$result[smalltext1]\"></td>\n";
		}
	}
	
	if($usetable) { 
		if($result['smalltext3']) echo "<td width=\"$result[smalltext1]\"></td>\n";
		echo "</tr></table>\n"; 
	}
}
?>
</div>

<?php 

if($part == "compose" && $this->request['display'] != 'inline') { ?>
<a href="javascript:part('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<script type="text/javascript">
	var text<?php echo $result['id'] ?> = '<?php echo $result['text'] ?>';
	contentobjects.push({
		save:function() {
			if($('text<?php echo $objectid ?>').value != text<?php echo $objectid ?>) {
				text<?php echo $objectid ?> = $('text<?php echo $objectid ?>').value;
				L.request('contents:compose:loadContentobject', {obj:<?php echo $result['id']; ?>, mode:'compose', display:'inline'}, function(response) {
					$('obj<?php echo $objectid ?>').getElement('.objectcontent').innerHTML = response;
				});
			}
		}
	});
</script>

<div id="option<?php echo $objectid ?>" style="display:none" class="compose_textoptions"> 
  <div class="compose_textoptions_inner"> 
    <br />
    Seite(n): 
    <input type="text" id="text<?php echo $result['id']; ?>" name="objectdata[<?php echo $result['id'] ?>][text]" value="<?php echo $result['text'] ?>">
    <br>
    <strong>Beschreibung:</strong> Geben Sie hier die zu ladene Seitenzahl an. 
    Sie k&ouml;nnen auch eine Breitenangabe durch Komm angeben, Bsp: Seitezahl,Breite<br>
    Wenn Sie mehrere Spalten darstellen m&ouml;chten, geben Sie einfach mit Semikolon 
    getrennt die Seitennummern und optional die Breiten an, Bsp: Spalte1,breite;Spalte2,breite 
    (1,150;2,200) <br>
    <br>
    <strong>Optional</strong><br>
    Spalten-Abstand: 
    <input name="objectdata[<?php echo $result['id'] ?>][smalltext1]" id="smalltext1<?php echo $result['id']; ?>" type="text" size="3" maxlength="3" value="<?php echo $result['smalltext1'] ?>" />
    <br>
    <input type="checkbox" name="objectdata[<?php echo $result['id'] ?>][smalltext2]" id="smalltext2<?php echo $result['id']; ?>"  value="1" <?php if($result['smalltext2']) echo "checked" ?> />
    Spaltenabstand links anf&uuml;gen<br>
    <input type="checkbox" name="objectdata[<?php echo $result['id'] ?>][smalltext3]" id="smalltext3<?php echo $result['id']; ?>"  value="1" <?php if($result['smalltext3']) echo "checked" ?> />
    Spaltenabstand rechts anf&uuml;gen<br>
  </div>
</div>
<?php } ?>