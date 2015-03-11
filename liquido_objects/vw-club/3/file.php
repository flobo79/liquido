<?php

$objecttitle = "Händler Extension";
$thisobject['formrows'] = "5";
$thisobject['result'] = $result;
$thisobject['part'] = $part;
$thisobject['css_class'] = "text";
$thisobject['textwidth'] = $contentwidth - $size[0] - $result['text2'];


$_kisx = (array)$_SESSION['kis']->myDealer;
$partner = (array)$_kisx[0];



if($fmode) $part = "public";
if ($part == "compose") include($_SERVER['DOCUMENT_ROOT']."/liquido/components/contents/compose/templates/object_head.php");
?>

<!-- 

<?php // print_r($partner); ?>
 -->
 
 
<?php if($partner) {  ?>
<table width="<?php echo $contentwidth ?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
   <td>
	<?php echo $partner['name']." <br>
	".$partner['zusatzx']."<br>
	".$partner['street']." ".$partner['houseNumber']."<br>
	".$partner['zip']." ".$partner['city'];
	 ?>
	 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
</tr>
</table>
<?php


	global $cfgtablecontents;	
	$thissql = "select * from $cfgtablecontents where title = '$partner[id]' LIMIT 1"; //echo $thissql;
	$thisresult = mysql_fetch_array(mysql_query($thissql));
	
	if($thisresult['id']) {
		$load['id'] = $thisresult['id'];
		$load['parents']['group']['width'] = $contentwidth;
		
		$mynode = new Node($thisresult['id']);
		
		echo $mynode->listobjects();
	}
}


	if($part == "compose") { 

?><a href="javascript:show('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('more<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/more.gif" alt="Optionen einblenden" border="0" name="more<?php echo $objectid ?>"></a>
<div id="option<?php echo $objectid ?>" style="display:none"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="15" height="15" background="/liquido/gfx/x_box/coinsupg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td height="15" background="/liquido/gfx/x_box/sup.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td width="15" height="15" background="/liquido/gfx/x_box/coinsupd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
    <tr> 
      <td width="15" background="/liquido/gfx/x_box/g.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td background="/liquido/gfx/x_box/fond.gif" align="left" width="100%"> 
        <table width="100%">
          <tr> 
            <td class="text">Info: Dieses Modul l&auml;d die H&auml;ndleinformationensseite 
              automatisch anhand der H&auml;ndlernummer des betreuenden H&auml;ndlers. 
              Es wird die Seite geladen dessen Titel der H&auml;ndlernummer entspricht.</td>
          </tr>
        </table></td>
      <td width="15" background="/liquido/gfx/x_box/d.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
    <tr> 
      <td width="15" height="15" background="/liquido/gfx/x_box/coininfg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td height="15" background="/liquido/gfx/x_box/inf.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
      <td width="15" height="15" background="/liquido/gfx/x_box/coininfd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
    </tr>
  </table>
  <a href="javascript:hide('option<?php echo $objectid ?>')" onMouseOver="MM_swapImage('less<?php echo $objectid ?>','','<?php echo $cfgcmspath ?>/components/contents/gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?php echo $cfgcmspath ?>/components/contents/gfx/less.gif" alt="Optionen ausblenden" border="0" name="less<?php echo $objectid ?>"></a>
</div>
<?php } ?>