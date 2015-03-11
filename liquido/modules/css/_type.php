<?php

function draw_droplist ($object) {
	$current = $object['current'];
	if(is_array($object['options'])) {
		echo "<select name=\"$object[name]\">
			<option value=\"xx\"></option>\r";
		foreach($object['options'] as $value => $title) {
			$selected = $current == $value ? " selected" : "";
			echo "<option value=\"$value\"$selected>$title</option>\n";
		}
		echo "</select>\n";	
	}
}

function draw_checklist ($object) {



}

$font_family = array(
	"name" => "set[font-family]",
	"options" => array(
		"Arial, Helvetica, sans-serif" => "Arial, Helvetica, sans-serif",
		"Times New Roman, Times, serif" => "Times New Roman, Times, serif",
		"Courir New, Courir, mono" => "Courir New, Courir, mono",
		"Georgia, Times New Roman, Times, serif" => "Georgia, Times New Roman, Times, serif",
		"Verdana, Arial, Helvetica, sans-serif" => "Verdana, Arial, Helvetica, sans-serif",
		"Geneva, Arial, Helvetica, serif" => "Geneva, Arial, Helvetica, serif"
		),
	"current" => $currstyle["font-family"],
	);

$font_weight = array(
	"name" => "set[font-weight]",
	"options" => array("normal" => "normal",
		"bold" => "fett",
		"bolder" => "fetter",
		"lighter" => "schmaler"),
	"current" => $currstyle['font-weight']
	);

$font_style = array(
	"name" => "set[font-style]",
	"options" => array(
		"normal" => "normal",
		"italic" => "kursiv",
		"oblique" => "zurückgestellt"),
	"current" => $currstyle['font-style']
);

$font_variant = array(
	"name" => "set[font-variant]",
	"options" => array(
		"normal" => "normal",
		"small-caps" => "small-caps"),
	"current" => $currstyle['font-variant']
);

$text_transform = array(
	"name" => "set[text-transform]",
	"options" => array(
		"normal" => "normal",
		"capitalize" => "Kapitälchen"),
	"current" => $currstyle['text-transform']
);

?>
<table width="395" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="79">Schrift: </td>
    <td colspan="3"><?php draw_droplist ($font_family) ?></td>
  </tr>
  <tr> 
    <td>H&ouml;he</td>
    <td width="118"><input name="set[font-size]" type="text" size="6" maxlength="3" value="<?php echo $currstyle['font-size']; ?>"> </td>
    <td width="57" align="right">Art:</td>
    <td width="141"><?php draw_droplist ($font_weight) ?></td>
  </tr>
  <tr> 
    <td>Stil</td>
    <td>
      <?php draw_droplist ($font_style) ?>
    </td>
    <td align="right">Variante:</td>
    <td>
      <?php draw_droplist ($font_variant) ?>
    </td>
  </tr>
  <tr> 
    <td>Zeilen-H&ouml;he</td>
    <td><input name="set[line-height]" value="<?php echo $currstyle['line-height']; ?>" type="text" size="6" maxlength="3"></td>
    <td align="right">Format:</td>
    <td>
      <?php draw_droplist ($text_transform) ?>
    </td>
  </tr>
  <tr> 
    <td valign="top">Verzierung:</td>
    <td><input type="checkbox" name="checkbox" value="checkbox">
      unterstrichen<br> <input type="checkbox" name="checkbox2" value="checkbox">
      &uuml;berstrichen<br> <input type="checkbox" name="checkbox3" value="checkbox">
      durchgestrichen<br> <input type="checkbox" name="checkbox4" value="checkbox">
      blinken<br> <input type="checkbox" name="checkbox5" value="checkbox">
      keine </td>
    <td align="right" valign="top">Farbe:</td>
    <td valign="top"> 

<script type="text/javascript" language="JavaScript">
	function show(color) {  
		document.getElementById("cb").style.backgroundColor = '#' + color;
		document.getElementById("cc").value = '#' + color;
	}
	
	function set(color) {             
		show(color);
		document.getElementById('colorfield').style.display='none';    
		document.getElementById('cb').value = '#'+color;
	}
</script>

<table border="0px" width="100%">
 <tr>
  <td valign=center><input type="text" name="cc" id="cc" value="" size="10"></td>
  <td width="100%"><div id="cb" style="cursor:pointer; height: 100%; width: 30px; background-color:<?php echo $currstyle['color'] ? $currstyle['color'] : "#000000" ?>;" onclick="document.getElementById('colorfield').style.display='block'"></div></td>
 </tr>
</table>

<div id="colorfield" style="display:none">
<table border="0" cellspacing="0px" cellpadding="0px" width="100%" height="80" style="cursor: pointer;">
	<tr height="10">
	<td bgcolor="#000000"  onclick="set('000000')"></td>
	<td bgcolor="#000000"  onclick="set('000000')"></td>
	<td bgcolor="#003300"  onclick="set('003300')"></td>
	<td bgcolor="#006600"  onclick="set('006600')"></td>
	<td bgcolor="#009900"  onclick="set('009900')"></td>
	<td bgcolor="#00CC00"  onclick="set('00CC00')"></td>
	<td bgcolor="#00FF00"  onclick="set('00FF00')"></td>
	<td bgcolor="#330000"  onclick="set('330000')"></td>
	<td bgcolor="#333300"  onclick="set('333300')"></td>
	<td bgcolor="#336600"  onclick="set('336600')"></td>
	<td bgcolor="#339900"  onclick="set('339900')"></td>
	<td bgcolor="#33CC00"  onclick="set('33CC00')"></td>
	<td bgcolor="#33FF00"  onclick="set('33FF00')"></td>
	<td bgcolor="#660000"  onclick="set('660000')"></td>
	<td bgcolor="#663300"  onclick="set('663300')"></td>
	<td bgcolor="#666600"  onclick="set('666600')"></td>
	<td bgcolor="#669900"  onclick="set('669900')"></td>
	<td bgcolor="#66CC00"  onclick="set('66CC00')"></td>
	<td bgcolor="#66FF00"  onclick="set('66FF00')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#333333"  onclick="set('333333')"></td>
	<td bgcolor="#000033"  onclick="set('000033')"></td>
	<td bgcolor="#003333"  onclick="set('003333')"></td>
	<td bgcolor="#006633"  onclick="set('006633')"></td>
	<td bgcolor="#009933"  onclick="set('009933')"></td>
	<td bgcolor="#00CC33"  onclick="set('00CC33')"></td>
	<td bgcolor="#00FF33"  onclick="set('00FF33')"></td>
	<td bgcolor="#330033"  onclick="set('330033')"></td>
	<td bgcolor="#333333"  onclick="set('333333')"></td>
	<td bgcolor="#336633"  onclick="set('336633')"></td>
	<td bgcolor="#339933"  onclick="set('339933')"></td>
	<td bgcolor="#33CC33"  onclick="set('33CC33')"></td>
	<td bgcolor="#33FF33"  onclick="set('33FF33')"></td>
	<td bgcolor="#660033"  onclick="set('660033')"></td>
	<td bgcolor="#663333"  onclick="set('663333')"></td>
	<td bgcolor="#666633"  onclick="set('666633')"></td>
	<td bgcolor="#669933"  onclick="set('669933')"></td>
	<td bgcolor="#66CC33"  onclick="set('66CC33')"></td>
	<td bgcolor="#66FF33"  onclick="set('66FF33')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#666666"  onclick="set('666666')"></td>
	<td bgcolor="#000066"  onclick="set('000066')"></td>
	<td bgcolor="#003366"  onclick="set('003366')"></td>
	<td bgcolor="#006666"  onclick="set('006666')"></td>
	<td bgcolor="#009966"  onclick="set('009966')"></td>
	<td bgcolor="#00CC66"  onclick="set('00CC66')"></td>
	<td bgcolor="#00FF66"  onclick="set('00FF66')"></td>
	<td bgcolor="#330066"  onclick="set('330066')"></td>
	<td bgcolor="#333366"  onclick="set('333366')"></td>
	<td bgcolor="#336666"  onclick="set('336666')"></td>
	<td bgcolor="#339966"  onclick="set('339966')"></td>
	<td bgcolor="#33CC66"  onclick="set('33CC66')"></td>
	<td bgcolor="#33FF66"  onclick="set('33FF66')"></td>
	<td bgcolor="#660066"  onclick="set('660066')"></td>
	<td bgcolor="#663366"  onclick="set('663366')"></td>
	<td bgcolor="#666666"  onclick="set('666666')"></td>
	<td bgcolor="#669966"  onclick="set('669966')"></td>
	<td bgcolor="#66CC66"  onclick="set('66CC66')"></td>
	<td bgcolor="#66FF66"  onclick="set('66FF66')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#999999"  onclick="set('999999')"></td>
	<td bgcolor="#000099"  onclick="set('000099')"></td>
	<td bgcolor="#003399"  onclick="set('003399')"></td>
	<td bgcolor="#006699"  onclick="set('006699')"></td>
	<td bgcolor="#009999"  onclick="set('009999')"></td>
	<td bgcolor="#00CC99"  onclick="set('00CC99')"></td>
	<td bgcolor="#00FF99"  onclick="set('00FF99')"></td>
	<td bgcolor="#330099"  onclick="set('330099')"></td>
	<td bgcolor="#333399"  onclick="set('333399')"></td>
	<td bgcolor="#336699"  onclick="set('336699')"></td>
	<td bgcolor="#339999"  onclick="set('339999')"></td>
	<td bgcolor="#33CC99"  onclick="set('33CC99')"></td>
	<td bgcolor="#33FF99"  onclick="set('33FF99')"></td>
	<td bgcolor="#660099"  onclick="set('660099')"></td>
	<td bgcolor="#663399"  onclick="set('663399')"></td>
	<td bgcolor="#666699"  onclick="set('666699')"></td>
	<td bgcolor="#669999"  onclick="set('669999')"></td>
	<td bgcolor="#66CC99"  onclick="set('66CC99')"></td>
	<td bgcolor="#66FF99"  onclick="set('66FF99')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#CCCCCC"  onclick="set('CCCCCC')"></td>
	<td bgcolor="#0000CC"  onclick="set('0000CC')"></td>
	<td bgcolor="#0033CC"  onclick="set('0033CC')"></td>
	<td bgcolor="#0066CC"  onclick="set('0066CC')"></td>
	<td bgcolor="#0099CC"  onclick="set('0099CC')"></td>
	<td bgcolor="#00CCCC"  onclick="set('00CCCC')"></td>
	<td bgcolor="#00FFCC"  onclick="set('00FFCC')"></td>
	<td bgcolor="#3300CC"  onclick="set('3300CC')"></td>
	<td bgcolor="#3333CC"  onclick="set('3333CC')"></td>
	<td bgcolor="#3366CC"  onclick="set('3366CC')"></td>
	<td bgcolor="#3399CC"  onclick="set('3399CC')"></td>
	<td bgcolor="#33CCCC"  onclick="set('33CCCC')"></td>
	<td bgcolor="#33FFCC"  onclick="set('33FFCC')"></td>
	<td bgcolor="#6600CC"  onclick="set('6600CC')"></td>
	<td bgcolor="#6633CC"  onclick="set('6633CC')"></td>
	<td bgcolor="#6666CC"  onclick="set('6666CC')"></td>
	<td bgcolor="#6699CC"  onclick="set('6699CC')"></td>
	<td bgcolor="#66CCCC"  onclick="set('66CCCC')"></td>
	<td bgcolor="#66FFCC"  onclick="set('66FFCC')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#FFFFFF"  onclick="set('FFFFFF')"></td>
	<td bgcolor="#0000FF"  onclick="set('0000FF')"></td>
	<td bgcolor="#0033FF"  onclick="set('0033FF')"></td>
	<td bgcolor="#0066FF"  onclick="set('0066FF')"></td>
	<td bgcolor="#0099FF"  onclick="set('0099FF')"></td>
	<td bgcolor="#00CCFF"  onclick="set('00CCFF')"></td>
	<td bgcolor="#00FFFF"  onclick="set('00FFFF')"></td>
	<td bgcolor="#3300FF"  onclick="set('3300FF')"></td>
	<td bgcolor="#3333FF"  onclick="set('3333FF')"></td>
	<td bgcolor="#3366FF"  onclick="set('3366FF')"></td>
	<td bgcolor="#3399FF"  onclick="set('3399FF')"></td>
	<td bgcolor="#33CCFF"  onclick="set('33CCFF')"></td>
	<td bgcolor="#33FFFF"  onclick="set('33FFFF')"></td>
	<td bgcolor="#6600FF"  onclick="set('6600FF')"></td>
	<td bgcolor="#6633FF"  onclick="set('6633FF')"></td>
	<td bgcolor="#6666FF"  onclick="set('6666FF')"></td>
	<td bgcolor="#6699FF"  onclick="set('6699FF')"></td>
	<td bgcolor="#66CCFF"  onclick="set('66CCFF')"></td>
	<td bgcolor="#66FFFF"  onclick="set('66FFFF')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#FF0000"  onclick="set('FF0000')"></td>
	<td bgcolor="#990000"  onclick="set('990000')"></td>
	<td bgcolor="#993300"  onclick="set('993300')"></td>
	<td bgcolor="#996600"  onclick="set('996600')"></td>
	<td bgcolor="#999900"  onclick="set('999900')"></td>
	<td bgcolor="#99CC00"  onclick="set('99CC00')"></td>
	<td bgcolor="#99FF00"  onclick="set('99FF00')"></td>
	<td bgcolor="#CC0000"  onclick="set('CC0000')"></td>
	<td bgcolor="#CC3300"  onclick="set('CC3300')"></td>
	<td bgcolor="#CC6600"  onclick="set('CC6600')"></td>
	<td bgcolor="#CC9900"  onclick="set('CC9900')"></td>
	<td bgcolor="#CCCC00"  onclick="set('CCCC00')"></td>
	<td bgcolor="#CCFF00"  onclick="set('CCFF00')"></td>
	<td bgcolor="#FF0000"  onclick="set('FF0000')"></td>
	<td bgcolor="#FF3300"  onclick="set('FF3300')"></td>
	<td bgcolor="#FF6600"  onclick="set('FF6600')"></td>
	<td bgcolor="#FF9900"  onclick="set('FF9900')"></td>
	<td bgcolor="#FFCC00"  onclick="set('FFCC00')"></td>
	<td bgcolor="#FFFF00"  onclick="set('FFFF00')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#00FF00"  onclick="set('00FF00')"></td>
	<td bgcolor="#990033"  onclick="set('990033')"></td>
	<td bgcolor="#993333"  onclick="set('993333')"></td>
	<td bgcolor="#996633"  onclick="set('996633')"></td>
	<td bgcolor="#999933"  onclick="set('999933')"></td>
	<td bgcolor="#99CC33"  onclick="set('99CC33')"></td>
	<td bgcolor="#99FF33"  onclick="set('99FF33')"></td>
	<td bgcolor="#CC0033"  onclick="set('CC0033')"></td>
	<td bgcolor="#CC3333"  onclick="set('CC3333')"></td>
	<td bgcolor="#CC6633"  onclick="set('CC6633')"></td>
	<td bgcolor="#CC9933"  onclick="set('CC9933')"></td>
	<td bgcolor="#CCCC33"  onclick="set('CCCC33')"></td>
	<td bgcolor="#CCFF33"  onclick="set('CCFF33')"></td>
	<td bgcolor="#FF0033"  onclick="set('FF0033')"></td>
	<td bgcolor="#FF3333"  onclick="set('FF3333')"></td>
	<td bgcolor="#FF6633"  onclick="set('FF6633')"></td>
	<td bgcolor="#FF9933"  onclick="set('FF9933')"></td>
	<td bgcolor="#FFCC33"  onclick="set('FFCC33')"></td>
	<td bgcolor="#FFFF33"  onclick="set('FFFF33')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#0000FF"  onclick="set('0000FF')"></td>
	<td bgcolor="#990066"  onclick="set('990066')"></td>
	<td bgcolor="#993366"  onclick="set('993366')"></td>
	<td bgcolor="#996666"  onclick="set('996666')"></td>
	<td bgcolor="#999966"  onclick="set('999966')"></td>
	<td bgcolor="#99CC66"  onclick="set('99CC66')"></td>
	<td bgcolor="#99FF66"  onclick="set('99FF66')"></td>
	<td bgcolor="#CC0066"  onclick="set('CC0066')"></td>
	<td bgcolor="#CC3366"  onclick="set('CC3366')"></td>
	<td bgcolor="#CC6666"  onclick="set('CC6666')"></td>
	<td bgcolor="#CC9966"  onclick="set('CC9966')"></td>
	<td bgcolor="#CCCC66"  onclick="set('CCCC66')"></td>
	<td bgcolor="#CCFF66"  onclick="set('CCFF66')"></td>
	<td bgcolor="#FF0066"  onclick="set('FF0066')"></td>
	<td bgcolor="#FF3366"  onclick="set('FF3366')"></td>
	<td bgcolor="#FF6666"  onclick="set('FF6666')"></td>
	<td bgcolor="#FF9966"  onclick="set('FF9966')"></td>
	<td bgcolor="#FFCC66"  onclick="set('FFCC66')"></td>
	<td bgcolor="#FFFF66"  onclick="set('FFFF66')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#FFFF00"  onclick="set('FFFF00')"></td>
	<td bgcolor="#990099"  onclick="set('990099')"></td>
	<td bgcolor="#993399"  onclick="set('993399')"></td>
	<td bgcolor="#996699"  onclick="set('996699')"></td>
	<td bgcolor="#999999"  onclick="set('999999')"></td>
	<td bgcolor="#99CC99"  onclick="set('99CC99')"></td>
	<td bgcolor="#99FF99"  onclick="set('99FF99')"></td>
	<td bgcolor="#CC0099"  onclick="set('CC0099')"></td>
	<td bgcolor="#CC3399"  onclick="set('CC3399')"></td>
	<td bgcolor="#CC6699"  onclick="set('CC6699')"></td>
	<td bgcolor="#CC9999"  onclick="set('CC9999')"></td>
	<td bgcolor="#CCCC99"  onclick="set('CCCC99')"></td>
	<td bgcolor="#CCFF99"  onclick="set('CCFF99')"></td>
	<td bgcolor="#FF0099"  onclick="set('FF0099')"></td>
	<td bgcolor="#FF3399"  onclick="set('FF3399')"></td>
	<td bgcolor="#FF6699"  onclick="set('FF6699')"></td>
	<td bgcolor="#FF9999"  onclick="set('FF9999')"></td>
	<td bgcolor="#FFCC99"  onclick="set('FFCC99')"></td>
	<td bgcolor="#FFFF99"  onclick="set('FFFF99')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#00FFFF"  onclick="set('00FFFF')"></td>
	<td bgcolor="#9900CC"  onclick="set('9900CC')"></td>
	<td bgcolor="#9933CC"  onclick="set('9933CC')"></td>
	<td bgcolor="#9966CC"  onclick="set('9966CC')"></td>
	<td bgcolor="#9999CC"  onclick="set('9999CC')"></td>
	<td bgcolor="#99CCCC"  onclick="set('99CCCC')"></td>
	<td bgcolor="#99FFCC"  onclick="set('99FFCC')"></td>
	<td bgcolor="#CC00CC"  onclick="set('CC00CC')"></td>
	<td bgcolor="#CC33CC"  onclick="set('CC33CC')"></td>
	<td bgcolor="#CC66CC"  onclick="set('CC66CC')"></td>
	<td bgcolor="#CC99CC"  onclick="set('CC99CC')"></td>
	<td bgcolor="#CCCCCC"  onclick="set('CCCCCC')"></td>
	<td bgcolor="#CCFFCC"  onclick="set('CCFFCC')"></td>
	<td bgcolor="#FF00CC"  onclick="set('FF00CC')"></td>
	<td bgcolor="#FF33CC"  onclick="set('FF33CC')"></td>
	<td bgcolor="#FF66CC"  onclick="set('FF66CC')"></td>
	<td bgcolor="#FF99CC"  onclick="set('FF99CC')"></td>
	<td bgcolor="#FFCCCC"  onclick="set('FFCCCC')"></td>
	<td bgcolor="#FFFFCC"  onclick="set('FFFFCC')"></td>
	</tr>
	<tr height="10px">
	<td bgcolor="#FF00FF"  onclick="set('FF00FF')"></td>
	<td bgcolor="#9900FF"  onclick="set('9900FF')"></td>
	<td bgcolor="#9933FF"  onclick="set('9933FF')"></td>
	<td bgcolor="#9966FF"  onclick="set('9966FF')"></td>
	<td bgcolor="#9999FF"  onclick="set('9999FF')"></td>
	<td bgcolor="#99CCFF"  onclick="set('99CCFF')"></td>
	<td bgcolor="#99FFFF"  onclick="set('99FFFF')"></td>
	<td bgcolor="#CC00FF"  onclick="set('CC00FF')"></td>
	<td bgcolor="#CC33FF"  onclick="set('CC33FF')"></td>
	<td bgcolor="#CC66FF"  onclick="set('CC66FF')"></td>
	<td bgcolor="#CC99FF"  onclick="set('CC99FF')"></td>
	<td bgcolor="#CCCCFF"  onclick="set('CCCCFF')"></td>
	<td bgcolor="#CCFFFF"  onclick="set('CCFFFF')"></td>
	<td bgcolor="#FF00FF"  onclick="set('FF00FF')"></td>
	<td bgcolor="#FF33FF"  onclick="set('FF33FF')"></td>
	<td bgcolor="#FF66FF"  onclick="set('FF66FF')"></td>
	<td bgcolor="#FF99FF"  onclick="set('FF99FF')"></td>
	<td bgcolor="#FFCCFF"  onclick="set('FFCCFF')"></td>
	<td bgcolor="#FFFFFF"  onclick="set('FFFFFF')"></td>
	</tr>
</table>
</div>
 </td>
  </tr>
</table>
