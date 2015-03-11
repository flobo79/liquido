<?php 

	foreach($_GET as $K => $V) { $$K = $V;}
	foreach($_POST as $K => $V) { $$K = $V; }
	unset($K,$V);
	
	include("../../../lib/init.php");
	$temp = $_SESSION['components'][$comp]['temp'];
	
	include("../functions.inc.php");
	include("functions.inc.php");
	
	$data = getData($temp);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<title>Classes</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script language="JavaScript" type="text/JavaScript" src="../../../js/mootools.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../../../js/utils.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../../../js/liquido.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../functions.js"></script>
	<link href="<?php echo LIQUIDO ?>/css/liquido.css" rel="stylesheet" type="text/css">
	<script src="../codepress/codepress.js" type="text/javascript"></script>
	<script type="text/javascript">
		document.addEvent('domready', function () {
			CodePress.run();
			resizeCodefield();
			$('codebox').style.visibility= 'visible';
		});
		
		function save(callback){
			L.request('templates:compose:update', {
				code: escape(encodeURIComponent(codebox.getCode()))
			}, L.saved );
		}
		
		function preview() {
			save(function(res) {
				L.request('templates:classes:previewClass',{id:current.id},function(res) { $('preview').innerHTML = res;  })
			});
		}
		
		function resizeCodefield() {
			if($('codebox')) {
				var height = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
				var width = window.innerWidth ? window.innerWidth : document.body.offsetWidth;
				$('box_middle').style.height = ((height))+'px';
				$('preview').style.height = ((height / 2) - 30)+'px';
				$('codebox').style.height = ((height) - 50)+'px';
				$('codebox').style.width = (width - 200)+'px';
			}
		}
		
	</script>
	<style type="text/css">
		#box_right {
			position:absolute;
			right:0;
			top:10px;
			width:165px;
			z-index:95;
		}
		#box_middle {
			position:absolute;
			padding-right:170px;
			top:10px;
			left:0; right:0;
			z-index:90;
		}
		#box_middle_top {
			height:100px;
			
		}
		#box_middle_bottom {
			height:100px;
			
		}
		#box1 {
			
		}
		#codebox {
			margin-top:5px;
		}
		#preview {
			width:100%;
			height:100%;
			overflow:auto;
			display:none;
		}
		
		.button {
			border:1px solid #CCCCCC;
			padding:3px;
			text-align:center;
			width:100%;
			cursor:pointer;
		}
	</style>
</head>

<body onresize="resizeCodefield();">
	<div id="box_middle">
		
		<?php
			if($part == "preview") { 
			?>
		<p align="center">
		<?php 
		
			$obj['id'] = $temp['id'];
			$obj['code'] = $data['code'];
		
			$code = parseCode($obj,$obj['code']);
			echo $code;
		?>
		
		</p>
		<?php } else { ?>
		<br />
		
		  <input name="template" type="hidden" id="class" value="<?php echo $temp['id'] ?>">
		  <input name="part" type="hidden" id="class" value="<?php echo $part ?>">
		  <textarea name="code" rows="30" wrap="OFF" class="codepress html" id="codebox" style="width:100%" ><?php echo htmlentities(utf8_decode($data['code'])) ?></textarea>
		<?php } ?>
		
		<div id="preview"></div>
	</div>
	
	<div id="box_right">
		  <table border="0" cellpadding="0" cellspacing="0">
		    <tr> 
		      <td width="150" height="74" valign="top"> <br>
		        <table width="130" height="33" border="0" cellpadding="0" cellspacing="0">
		          <tr> 
		            <td> 
		              <?php if($data['undo']) { ?>
		              <a href="#" onMouseOver="MM_swapImage('Image11','','../../../gfx/savepane/z_over.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="../../../gfx/savepane/z_active.gif" name="Image11" border="0" id="Image1"></a></td>
		            <?php } else { echo '<img src="../../../gfx/savepane/z_inactive.gif" name="Image1" width="63" height="14" border="0" alt="Änderung rückgängig machen"></td>'; } ?>
		            <td> 
		              <?php if($data['redo']) { ?>
		              <a href="#" onMouseOver="MM_swapImage('Image21','','../../../gfx/savepane/y_over.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="../../../gfx/savepane/y_active.gif" name="Image21" border="0" id="Image2"></a></td>
		            <?php } else { echo '<img src="../../../gfx/savepane/y_inactive.gif" name="Image2" border="0" alt="Änderung wiederherstellen"></td>'; } ?>
		          </tr>
		          <tr> 
		            <td colspan="2"><a href="javascript:save();" onMouseOver="MM_swapImage('Image31','','../../../gfx/savepane/save_over.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="../../../gfx/savepane/save_active.gif" alt="Änderungen speichern" name="Image31" width="130" height="19" border="0" id="Image3"></a></td>
		          </tr>
		        </table>
		        <br>
		      </td>
		    </tr>
		    <tr>
		      <td height="74" valign="top">einfügen:<br>
				<select name="tags" onChange="insertTag(this.value,false); this.value=''; return false" class="text" style="width:150px">
		          <option value="">-- statische tags --</option>
		          <option value="content">Inhalte</option>
		          <option value="container">Containerpfad</option>
		          <option value="xcontainer">Hauptcontainerpfad</option>
		          <option value="createdate">Erstellungsdatum</option>
		          <option value="changedate">Änderungsdatum</option>
		          <option value="template">Vorlagenid</option>
		        </select> <br> <select name="tags" onChange="insertTag (this.value,false); this.value=''; return false" class="text" style="width:150px">
		          <option value="">-- Funktionen --</option>
		        </select>
		        <br>
		        <br>
		        Objekte:<br> <select name="foreign" onChange="insertTag (this.value,false); this.value=''; return false" class="text" style="width:150px">
		          <option value="">-- eigene --</option>
		          <?php 
				 //$tagobjects = listTempObjects($data['id']);
				$tagobjects = array();
				while(list($key,$val) = each($tagobjects)) {
					$thisobj = $tagobjects[$key];
					echo "<option value=\"\"></option>
					<option value=\"\">- $key ---- </option>\n";
					
					while(list($keyx,$valx) = each($thisobj)) {
						echo "<option value=\"$key:".$thisobj[$keyx]['id']."\">  ".$thisobj[$keyx]['title']."</option>\n";
					}
				}
				?>
		        </select>
		        <br>
		        <select name="home" onChange="insertTag (this.value,false); this.value=''; return false" class="text" style="width:150px">
		          <option value="">-- globale --</option>
		          <?php 
				// $tagobjects = listTempObjects (9999);
				$tagobjects = array();
				while(list($key,$val) = each($tagobjects)) {
					$thisobj = $tagobjects[$key];
					echo "<option value=\"\"></option>
					<option value=\"\">- $key ---- </option>\n";
					
					while(list($keyx,$valx) = each($thisobj)) {
						echo "<option value=\"x$key:".$thisobj[$keyx]['id']."\">  ".$thisobj[$keyx]['title']."</option>\n";
					}
				}
				?>
		        </select>
		        <br>
		        <br>
		        Optionen: <br> <select name="tags" onChange="swapWith (this.value,false); this.value=''; return false" class="text" style="width:150px">
		          <option value="">-- tauschen mit --</option>
		        </select>
		        <br>
		        <select name="tags" onChange="copyTo (this.value,false); this.value=''; return false" class="text" style="width:150px">
		          <option value="">-- kopieren nach --</option>
		        </select> </td>
		    </tr>
		  </table>
	</div>
</body>
</html>
