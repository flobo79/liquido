<?php

	if(!$access['c16']) header("Location:templates/noaccess.php");
	
	if($selecttemplate) {
		
		unset($temp);
		$temp['id'] = $selecttemplate;
		session_register(temp);
	}

	if($temp) $data = getdata($temp);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>templates</title>
<?php if($cfg['visual']['pagefade'] == 1) { ?><meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)"><?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../lib/css.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--

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
<?php if ($data) { ?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="40"><img src="gfx/template.gif" width="32" height="34" border="0"></td>
    <td> <?php echo $data['title']; ?><br>
    </td>
    <td width="162" align="right">
      <?php if($update) echo "<img src=\"gfx/fade.gif\" border=\"0\">" ?>
    </td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form action="body.php" method="post" enctype="multipart/form-data" name="page" target="middle">
<table width="<?php echo $data['groupwidth'] ?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td> 
        <?php $objects = listobjects($data,"compose"); ?>
              <p align="center"> 
                <input name="objectdata[objects]" type="hidden" value="<? echo $objects; ?>">
          <input name="update" type="hidden" value="true">
        </p>
  </td>
  </tr>
</table>

  

</form></td>
  </tr>
</table>

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