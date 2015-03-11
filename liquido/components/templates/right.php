<?php
	include("../../lib/init.php");
	include("functions.php");
	session_start();
	$templates = gettemplates($temp);
?>
<html>
<head>
<title>liquido option-menue</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--

	function markSelection (txtObj) {
	 if (txtObj.createTextRange ) {
			txtObj.caretPos = document.selection.createRange().duplicate();
			txtField = txtObj;
			isSelected = true;
		}
	}
	

	function insertTag ( tag, enclose ) { 
		if(tag != "0") {
		 var closeTag = tag;
		 if ( enclose ) {
		   var attribSplit = tag.indexOf ( ' ' );
		   if ( tag.indexOf ( ' ' ) > -1 )
			 closeTag = tag.substring ( 0, attribSplit );
		 }
		 if ( isSelected && tag) {
		   var Field = txtField.name;
		   var txtObj = eval ( "document.forms[0]." + Field );
		   if (txtObj.createTextRange && txtObj.caretPos) {
			 var caretPos = txtObj.caretPos;
			 caretPos.text = ( ( enclose ) ? "<"+tag+">"+caretPos.text+"</"+closeTag+">" : "<"+tag+">"+caretPos.text );
			 markSelection ( txtObj );
			 if ( txtObj.caretPos.text=='' ) {
			   isSelected=false;
			txtObj.focus();
			 }
		   }
		   
		 } else {
		   // placeholder for loss of focus handler
		 }
		}
	}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

save = function() {
	parent.middle_c.document.forms[0].submit();
}

//-->
</script>
<link href="../../lib/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../gfx/savepane/z_over.gif','../../gfx/savepane/y_over.gif','../../gfx/savepane/save_over.gif','gfx/preview_o.gif')" >
<br>

<table width="165" border="0" align="right" cellpadding="0" cellspacing="0">
    <tr> 
      <td height="21" background="gfx/right_pane_top.gif">&nbsp;</td>
    </tr>
    <tr> 
      <td align="right" background="gfx/right_pane_content.gif">
		<form name="form1" method="post" action="">
        <table width="138" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="74" align="center" valign="top"> <div align="center"></div>
              <table width="130" height="33" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td> 
                    <?php if($data['undo']) { ?>
                    <a href="?undo=<?php echo $tempid['id'] ?>" onMouseOver="MM_swapImage('Image11','','../../gfx/savepane/z_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/savepane/z_active.gif" name="Image11" border="0" id="Image1"></a></td>
                  <?php } else { echo '<img src="../../gfx/savepane/z_inactive.gif" name="Image1" width="63" height="14" border="0" alt="Änderung räckgängig machen"></td>'; } ?>
                  <td> 
                    <?php if($data['redo']) { ?>
                    <a href="#" onMouseOver="MM_swapImage('Image21','','../../gfx/savepane/y_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../gfx/savepane/y_active.gif" name="Image21" border="0" id="Image2"></a></td>
                  <?php } else { echo '<img src="../../gfx/savepane/y_inactive.gif" name="Image2" border="0" alt="Änderung wiederherstellen"></td>'; } ?>
                </tr>
                <tr> 
                  <td colspan="2"><a href="#" onClick="save(); return false"><img src="../../gfx/savepane/save_active.gif" alt="Änderungen speichern" name="Image31" width="130" height="19" border="0" id="Image3" onMouseOver="MM_swapImage('Image31','','../../gfx/savepane/save_over.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
                </tr>
              </table>
              <br><a href="#" onClick="parent.middle_c.document.forms[0].part.value='preview'; parent.middle_c.document.forms[0].submit(); return false " onMouseOver="MM_swapImage('Image4','','gfx/preview_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/preview.gif" name="Image4" width="134" height="24" border="0" id="Image4"></a> 
            </td>
          </tr>
          <tr> 
            <td height="74" align="center" valign="top" class="smalltext">einf&uuml;gen:<br> <select name="tags" onChange="parent.middle_c.insertTag (this.value,false); this.value=''; return false" class="text" style="width:120px">
                <option value="">-- statische tags --</option>
                <option value="content">Inhalte</option>
                <option value="container">Containerpfad</option>
                <option value="xcontainer">Hauptcontainerpfad</option>
                <option value="createdate">Erstellungsdatum</option>
                <option value="changedate">Änderungsdatum</option>
                <option value="template">Vorlagenid</option>
              </select> <select name="tags" onChange="parent.middle_c.insertTag (this.value,false); this.value=''; return false" class="text" style="width:120px">
                <option value="">-- Funktionen --</option>
              </select>
              Objekte<br> <select name="foreign" onChange="parent.middle_c.insertTag (this.value,false); this.value=''; return false" class="text" style="width:120px">
                <option value="">-- eigene --</option>
                <?php 
		 $tagobjects = listTempObjects($temp['id']);

		while(list($key,$val) = each($tagobjects)) {
			$thisobj = $tagobjects[$key];
			echo "<option value=\"\"></option>
			<option value=\"\">- $key ---- </option>\n";
			
			while(list($keyx,$valx) = each($thisobj)) {
				echo "<option value=\"$key:".$thisobj[$keyx]['id']."\">  ".$thisobj[$keyx]['title']."</option>\n";
			}
		}
		?>
              </select> <select name="home" onChange="parent.middle_c.insertTag (this.value,false); this.value=''; return false" class="text" style="width:120px">
                <option value="">-- globale --</option>
                <?php 
		 $tagobjects = listTempObjects (9999);

		while(list($key,$val) = each($tagobjects)) {
			$thisobj = $tagobjects[$key];
			echo "<option value=\"\"></option>
			<option value=\"\">- $key ---- </option>\n";
			
			while(list($keyx,$valx) = each($thisobj)) {
				echo "<option value=\"x$key:".$thisobj[$keyx]['id']."\">  ".$thisobj[$keyx]['title']."</option>\n";
			}
		}
		?>
              </select> <br>
              <br>
              <br>
            </td>
          </tr>
        </table>
	<p>&nbsp;</p></form>
   </td>
    </tr>
    <tr> 
      <td align="right"><img src="gfx/right_pane_bottom.gif" width="165" height="31"></td>
    </tr>
  </table>
   
</body>
</html>
