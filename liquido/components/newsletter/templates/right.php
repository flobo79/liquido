 <?php 
include ("functions.inc.php");
include ($nlmode."/functions.inc.php");

if($setinsertpos) {
	$insertpos = $setinsertpos;
	session_register("insertpos");
}
if(!$insertpos)  {
	$insertpos = "bottom";
	session_register("insertpos");
}

?>
<html>
<head>
<title>CMS-Pro compose-toolpane</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php if($cfg[visual][pagefade] == 1) { ?><meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)"><?php } ?>
<link href="../../lib/css.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function save(){
		document.getElementById('save').style.display='none';
		document.getElementById('saveas').style.display='block';
		document.getElementById('input').focus();
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
//-->
</script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('gfx/compose_save_o.gif')">
<form name="form1" method="post" action="?">
  <br>
  <table width="165" border="0" align="right" cellpadding="0" cellspacing="0">
    <tr>
      <td height="21" background="gfx/right_pane_top.gif">&nbsp;</td>
    </tr>
    <tr> 
      <td align="right" background="gfx/right_pane_content.gif"><table width="139" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="139"><img src="gfx/compose_pane_title.gif"><br> <a href="?setinsertpos=bottom"><img src="gfx/<?php echo $insertpos == "bottom" ? "ins_b_d.gif" : "ins_b_u.gif"; ?>" border="0"></a><a href="?setinsertpos=middle"><img src="gfx/<?php echo $insertpos == "middle" ? "ins_m_d.gif" : "ins_m_u.gif"; ?>" border="0"></a><a href="?setinsertpos=top"><img src="gfx/<?php echo $insertpos == "top" ? "ins_t_d.gif" : "ins_t_u.gif"; ?>" border="0"></a><br> 
              <br> 
              <?php listTools($content,$insertpos);  ?>
              <br> <br> <img src="gfx/templates_title.gif"><br> 
              <?php list_templates($content);  ?>
              <?php if($access['c15']) { ?>
              <div id="save"><a href="javascript:save();">+ als Vorlage speichern</a></div>
              <div id="saveas" style="display:none"> 
                <input name="save_template" type="text" size="20" maxlength="20" class="text" style="width:130">
              </div>
              <?php } ?>
              <p align="center"><a href="#" onClick="parent.middle.page.submit(); return false" onMouseOver="MM_swapImage('save','','gfx/compose_save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/compose_save.gif" name="save" border="0"></a><br>
                <a href="body.php#composebottom" target="middle"><img src="gfx/tobottom.gif" width="43" height="8" border="0"></a> 
                <br>
              </p>
              </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td><img src="gfx/right_pane_bottom.gif" width="165" height="31"></td>
    </tr>
  </table>
</form>
</body>
</html>
