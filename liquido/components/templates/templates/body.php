<?php 

if(!$access['c16']) header("Location:templates/noaccess.php");
$temp = get_tempname($inserttemplate);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<?php if($cfg[visual][pagefade] == 1) { ?><meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)"><?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../lib/css.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--

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
function show(elementname){
	document.getElementById(elementname).style.display='block';
}

function hide(elementname){
	document.getElementById(elementname).style.display='none';
}
//-->
</script>

<?php if($update_rightframe) { ?>
<script type="text/javascript">
		<!--
		 parent.right.location.href = 'right.php?mode=$mode';
		//-->
</script>
<?php } ?>
</head>

<body bgcolor="#FFFFFF">
<table width="411" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="60" align="center"><img src="gfx/template.gif" width="32" height="34"></td>
    <td width="351"> Vorlagen</td>
  </tr>
</table>
<?php if ($inserttemplate) { ?>
<form action="body.php" method="post" enctype="multipart/form-data" name="page" target="middle">
  <table width="411" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="60" align="center">&nbsp;</td>
      <td width="351"> Bezeichnung: 
        <input name="temp_title" type="text" class="text" id="temp_title" value="<?php echo $temp['title']; ?> " size="20" maxlength="15"></td>
    </tr>
  </table>
  <br>
  <table width="<?php echo $data['groupwidth'] ?>" border="0" align="center" cellpadding="0" cellspacing="0"> 
    <tr> 
      <td> 
        <?php $objects = showtemplate($data,$inserttemplate); ?>
        <p align="center"> <a href="#" onClick="document.page.submit()" onMouseOver="MM_swapImage('save','','gfx/compose_save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="gfx/compose_save.gif" name="save" border="0"></a> 
          <input name="objectdata[objects]" type="hidden" value="<? echo $objects; ?>">
          <input name="update" type="hidden" value="true">
        </p></td>
    </tr>
  </table>

</form>
<?php } else { ?>
<table width="411" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="60" align="center">&nbsp;</td>
    <td width="351"> W&auml;hlen Sie eine Vorlage aus um sie zu bearbeiten</td>
  </tr>
</table>
<?php } ?>
</body>
</html>