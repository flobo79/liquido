<?php

// teile dem publish-script mit das es ein MP-object ist
$result['ismp'] = 1;

global $thiscomp;
global $publishing;
global $nlobj;
global $areas;

if(!$check) $check = $thiscomp['check'];

/***  FIND AREA ID AND MEASURE CONTENT WIDTH */
if($result['text']) {
	$tn = new Node($result['id'],true);
	$tn->contentwidth = $node->contentwidth;
	
	foreach($areas as $area) {
		if($area['id'] == $result['text']) {
			$thisarea = $area;
			break;
		}
	}
}

$check[$thisarea['id']];

if($thiscomp['current'] == 'compose') {
	$bordercolor = ($thiscomp['objtype'] == "area" && $thiscomp['area'] == $result['id']) ? 'green' : 'yellow';
	if($thiscomp['objtype'] == "area" and $thiscomp['area'] != $result['id']) $bordercolor = 'white';
?>
<div style="border: solid 2px <?php echo $bordercolor; ?>; float:left; width:100%;">
<?php 
	// ein bereich wurde festgelegt
	if($result['text']) {
		
		// wenn diese area im compose-modus ausgewaehlt is
		if($thiscomp['objtype'] == "area" and $thiscomp['area'] == $result['id']) {
			
			$check[$thisarea['id']] = 1;
			echo "<b>Bereich $thisarea[title] bearbeiten</b><br><a href=\"?select[id]=$thiscomp[id]\"><b>>> zurück zum newsletter</b></a><br><br>\n";
			$tn->compose = true;
		
		} else if($thiscomp['objtype'] != "area") {
			$objecttitle = "Bereich ".$thisarea['title']."<a href=\"?selectarea=".$result['id']."\"><b> >> bearbeiten</b></a>";
			include("$cfgcmspath/components/contents/compose/templates/object_head.php");
		}
		
		echo $tn->listobjects();
		
	} else {
		$objecttitle = "Bitte wählen Sie einen Bereich aus";
		include("$cfgcmspath/components/contents/compose/templates/object_head.php");
	}

	
// if area is currently selected for display - also important for sending newsletter
} else {
	if($check[$result['text']] or $this->publishing) {
		$result['mp'] = $result['text'];
		echo $tn->listobjects();
	}
}

if($part == "compose") { 
?>
<br />
<a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','/liquido/components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="/liquido/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<div id="option<?php echo $objectid ?>" style="display:none">
  Bereich ausw&auml;hlen: 
        <select name="objectdata[<?php echo $result['id'] ?>][text]">
			<option value="">(ausw&auml;hlen)</option>
        <?php
			foreach($areas as $key => $value) {
				$selected = $result['text'] == $value['id'] ? "selected" : "";
				echo "<option value=\"".$value['id']."\" $selected>".$value['title']."</option>\n";
			}
			reset($areas);
		?>
        </select><br />
		Bitte speichern Sie die Seite und, klicken Sie erneut auf "Compose" in der Haupmenuleiste um den Bereich zu laden.
	<a href="javascript:hide('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('less<?php echo $objectid ?>','','/liquido/components/contents/gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="/liquido/components/contents/gfx/less.gif" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>"></a>
</div>
</div>
<?php }  $thisarea = false; $objecttitle = ''; ?>
