<?php 
	include("../../../lib/init.php");
	$temp = $_SESSION['components'][$comp]['temp'];
	
	// globals 
	foreach($_GET as $K => $V) { $$K = $V;}
	foreach($_POST as $K => $V) { $$K = $V; }
	unset($K,$V);
	
	include("functions.inc.php");
	
	if($_SESSION['components']['current'] != "classes") $_SESSION['components']['current'] = "classes";
	if($select['id']=="x") $_SESSION['components'][$comp]['temp'] = 9999;

	$classes = listClasses();
	
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
			
			$('saveas').addEvents({
				'keyup':function(ev) {
					if(ev.key == 'enter') {
						newClass();
					}},
					
				 'blur':function() {
					$('saveas').style.display='none';
					$('saveas').value="";
					$('save').style.display='block';
				 }
			});
		});
		
		function save(callback) {
			L.request('templates:classes:saveClass',{id:current.id,code:encodeURIComponent(escape(box1.getCode())),title:$('title').value},function(res){
				$('class'+current.id).innerHTML = '['+current.obj+'] '+$('title').value;
				if(typeof callback === 'function') {
					callback(res);
				} else {
					L.saved();
				}
			});
		}
		
		function preview() {
			save(function(res) {
				L.request('templates:classes:previewClass',{id:current.id},function(res) { $('preview').innerHTML = res;  })
			});
		}
		
		var current = false;
		function loadClass(id) {
			$('preview').innerHTML = '';
			L.request('templates:classes:loadClass',{id:id},function(res){
				var res = JSON.decode(res);
				current = res;
				box1.setCode(res.code);
				$('box_selectclass').style.display='none';
				$('codebox').style.visibility= 'visible';
				
				box1.edit(res.code ? res.code : "// enter your PHP code here ...\n",'php');
				$('title').value=res.title;
				$('box_middle_top').style.display = 'block';
				$('box_middle_bottom').style.display = 'block';
				$('box_selectclass').style.display = 'none';
				
			});
		}
		
		function resizeCodefield() {
			if($('codebox')) {
				var height = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
				var width = window.innerWidth ? window.innerWidth : document.body.offsetWidth;
				
				$('box_middle_top').style.height = ((height / 2))+'px';
				$('box_middle_bottom').style.height = ((height / 2))+'px';
				$('preview').style.height = ((height / 2) - 30)+'px';
				$('codebox').style.height = ((height / 2) - 30)+'px';
				$('codebox').style.width = (width - 360)+'px';
			}
		}
		
		function delClass () {
			if(confirm('Möchten Sie diese Klasse wirklich löschen?')) {
				L.request('templates:classes:delClass',{id:current.id},function () {
					$('box_middle_top').style.display = 'none';
					$('box_middle_bottom').style.display = 'none';
					$('box_selectclass').style.display = 'block';
					$('class'+current.id).dispose();
					box1.setCode('');
					current = false;
				});
			}
		}
		
		function newClass() {
			if($('saveas').value != '') {
				L.request('templates:classes:newClass',{title:$('saveas').value},function(res) {
					
					$('saveas').style.display='none';
					$('saveas').value='';
					$('save').show();
					
					var res = JSON.decode(res);
					
					
					new Element('a',{
						id:'class'+res.id,
						href:'javascript:loadClass('+res.id+')',
						html:'['+res.obj+'] '+res.title,
						styles:{
							clear:'both',
							display:'block',
							width:'100%'
						}
					}).inject($('class_list'));
					
				});
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
		#box_left {
			position:absolute;
			left:0;
			width:165px;
			overflow:auto;
			height:100%;
			z-index:100;
		}
		#box_middle {
			position:absolute;
			padding-left:170px;
			padding-right:170px;
			top:10px;
			left:0; right:0;
			z-index:90;
		}
		#box_middle_top {
			height:100px;
			display:none;
		}
		#box_middle_bottom {
			height:100px;
			display:none;
		}
		#box1 {
			display:none;
		}
		#codebox {
			margin-top:5px;
			display:none;
		}
		#preview {
			width:100%;
			height:100%;
			overflow:auto;
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


<div id="box_left">
	      <img src="../gfx/class.gif"><br>
	      <?php echo $data['title'] ?><br>
	      <strong>Klassen</strong> 
	      <div id="class_list">
	        <?php 
			if ($classes) { while(list($key,$val) = each($classes)) { ?>
	        <a style="width:100%; clear:both; display:block;" id="class<?php echo $val['id']; ?>" href="#" onclick="loadClass('<?php echo $val["id"] ?>');">[<?php echo $classes[$key]['obj'] ?>] <?php echo $classes[$key]['title'] ?></a>
	        <?php	}
			} ?>
	      </div>
	      <div id="save" onclick="this.style.display='none'; $('saveas').style.display='block';" style="cursor:pointer;"> + erstellen</div>
	      <input id="saveas" name="saveas" type="text" size="15" maxlength="20" id="input" style="display:none" class="text"><br><br>
</div>



<div id="box_middle">
	<div id="box_selectclass">Wählen Sie eine Class aus, oder erstellen Sie eine.</div>
	<div id="box_middle_top">
		Class Name: <input type="text" name="title" id="title" />
		<textarea class="codepress php" id="box1" style="width:100%" ><?php echo $data['code'] ?></textarea>
	</div>
	<div id="box_middle_bottom">
		
		<div class="button" onClick="preview();"><div class="inner">Vorschau:</div></div>
		<div id="preview"> </div>
	</div>
</div>



<div id="box_right">
	<table width="165" border="0" align="right" cellpadding="0" cellspacing="0">
	  <tr> 
	    <td height="21" background="../gfx/right_pane_top.gif">&nbsp;</td>
	  </tr>
	  <tr> 
	    <td align="right" background="../gfx/right_pane_content.gif"> <form name="form1" method="post" action="">
	        <table width="130" border="0" cellpadding="0" cellspacing="0">
	          <tr> 
	            <td valign="top"> <br> <table width="130" height="33" border="0" cellpadding="0" cellspacing="0">
	                <tr> 
	                  <td> 
	                    <?php if($data['undo']) { ?>
	                    <a href="?undo=<?php echo $tempid['id'] ?>" onMouseOver="MM_swapImage('Image11','','../../../gfx/savepane/z_over.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="../../../gfx/savepane/z_active.gif" name="Image11" border="0" id="Image1"></a></td>
	                  <?php } else { echo '<img src="../../../gfx/savepane/z_inactive.gif" name="Image1" width="63" height="14" border="0" alt="Änderung rückgängig machen"></td>'; } ?>
	                  <td> 
	                    <?php if($data['redo']) { ?>
	                    <a href="#" onMouseOver="MM_swapImage('Image21','','../../../gfx/savepane/y_over.gif',1);" onMouseOut="MM_swapImgRestore();"><img src="../../../gfx/savepane/y_active.gif" name="Image21" border="0" id="Image2"></a></td>
	                  <?php } else { echo '<img src="../../../gfx/savepane/y_inactive.gif" name="Image2" border="0" alt="Änderung wiederherstellen"></td>'; } ?>
	                </tr>
	                <tr> 
	                  <td colspan="2"><a href="#" onClick="save(); return false" onMouseOver="MM_swapImage('Image31','','../../../gfx/savepane/save_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/savepane/save_active.gif" alt="Änderungen speichern" name="Image31" width="130" height="19" border="0" id="Image3"></a></td>
	                </tr>
	              </table>
	              <br>
	            </td>
	          </tr>
	          <tr> 
	            <td valign="top">
	               <br>
	              Optionen: <br>
	              <select name="options" onChange="Action(this.value); this.value=''; return false" class="text" style="width:130px">
	                <option value="" selected>-- auswählen --</option>
					<option value="delClass">Klasse löschen</option>
	              </select> </td>
	          </tr>
	        </table>
	        <p>&nbsp;</p>
	      </form></td>
	  </tr>
	  <tr> 
	    <td align="right"><img src="../gfx/right_pane_bottom.gif" width="165" height="31"></td>
	  </tr>
	</table>
</div>
</body>
</html>
