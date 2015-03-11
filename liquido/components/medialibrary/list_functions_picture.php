<?

include("../../lib/init.php");
include("lib/functions.php");

$result = getObjectData($id);
$imagesize = GetImageSize($_SERVER['DOCUMENT_ROOT'].MEDIALIB."/".$result['id']."/original.jpg");
if($reprint) {
	reprint($result);
	updateColumnChilds($id);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>LIQUIDO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../lib/css.css" rel="stylesheet" type="text/css">
</head>

<body >
<br />
<table width="100%" border="0" cellpadding="1" cellspacing="0">
  
  <tr> 
    <td width="25" valign="top">&nbsp;</td>
    <td width="110" valign="top"><p><a href="#" onClick="window.open('pic_popup.php?pic=<?php echo MEDIALIB."/".$result['id'] ?>','bild','<?php echo "width=$imagesize[0],height=$imagesize[1]" ?>'); return false "><img src="<?php echo MEDIALIB."/".$result['id']?>/small.jpg" border="0"></a><br>
        <br>
        <a href="list_details.php?id=<?php echo $id ?>">zur&uuml;ck </a></p></td>
    <td width="215" valign="top"><p> <span class="headline"> <?php echo $result['name'] ?></span><br>
        Bildnummer: <?php echo $result['id'] ?></p>
      <p> <?php echo $result['info'] ?> </p>
      <p>&nbsp;</p>
      <p>erstellt: <?php echo $result['date'] ?><br>
        ge&auml;ndert: <?php echo $result['changed'] ?> </p>
      <p> <br>
      </p></td>
    <td style="display:none" width="497" colspan="2" valign="top">
		<span class="headline">Funktionen</span> 
      <p> 
        <?php 
	  	$batches = array(); //listBatches(); 
	  	
		if ($batches) {
			while(list($key,$val) = each($batches)) {
				echo "<a href=\"batch/".$val['file']."?id=$id&type=picture\">$key</a><br>\n";
			}
		}		
		?>
      </td>
  </tr>
</table>
</body>
</html>