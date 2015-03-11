<?php 

include("../../../lib/init.php");
foreach($_GET as $K => $V) { $$K = $V;}
foreach($_POST as $K => $V) { $$K = $V; }
unset($K,$V);
$temp = $thiscomp['temp'];
include("functions.php");

// hole alle containerobjects dieses templates
if($temp=="x" or $temp == "9999") {
	$_SESSION['components'][$comp]['temp'] = 9999;
	$temp = 9999;
	$x=1;
	$thiscomp = $_SESSION['components'][$comp];
}

$c_objs = getObjects($temp);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>templates</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script language="JavaScript" type="text/JavaScript" src="../../../js/mootools.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../../../js/utils.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="../functions.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="<?php echo LIQUIDO ?>/js/liquido.js"></script>
	<link href="<?php echo LIQUIDO ?>/css/liquido.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="553" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"><p><img src="../gfx/container.gif" width="25"> <br>
        <strong><?php if($x) { ?>
         Hauptcontainer 
        <?php } else { ?>
        Container <?php } ?></strong><br>
        <br>
      </p>
      </td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="11" height="21">&nbsp;</td>
    <td height="21" colspan="2" class="ru">Container-Objekte </td>
  </tr>
  <tr> 
    <td height="225">&nbsp;</td>
    <td width="180" valign="top"> 
       <p>
	   <?php foreach($c_objs as $key => $val) { ?>
     		[<?php echo $c_objs[$key]['obj'] ?>] <a href="?c_obj=<?php echo $c_objs[$key]['id'] ?>"><?php echo $c_objs[$key]['title'] ?></a><br>
        <?php } ?>
      </p>
      <p>&nbsp; </p></td>
    <td width="353" valign="top"> <br>

      <?php 
	  	if($c_obj) {
	  		$containerobj = getObject($c_obj);	
			include("mimetypes/".$containerobj[mime][0].".php");
	  ?>
      <table width="275" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('actionspanel','')" onMouseOver="MM_swapImage('showactionsx','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/more.gif" alt="Optionen einblenden" name="showactionsx" border="0" id="add1"></a></td>
          <td width="243"><a href="javascript:show('actionspanel','')" onMouseOver="MM_swapImage('showactionsx','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()" class="headline"> 
            Aktionen</a></td>
        </tr>
      </table>
	  <div id="actionspanel" class="hidden"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="15" height="15" background="/liquido/gfx/x_box/coinsupg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td height="15" background="/liquido/gfx/x_box/sup.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td width="15" height="15" background="/liquido/gfx/x_box/coinsupd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
        </tr>
        <tr> 
          <td width="15" background="/liquido/gfx/x_box/g.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td background="/liquido/gfx/x_box/fond.gif" align="left" width="100%">
		  <form method="post">
              <select name="swap" class="text">
                <option value="" selected>tauschen mit</option>
                <?php
			
					if ($c_obj) {
						$list = $c_objs;
						while(list($key,$val) = each($list)) {
							if($list[$key]['id'] != $c_obj['id']) echo "<option value=\"".$list[$key]['obj']."\">".$list[$key]['title']."</option>\n";
						}
					}		
					?>
              </select>
                <input type="submit" name="Submit" value="ok">
                <br>
              </form>
		  <a href="?delobj=<?php echo $containerobj[id]; ?>">Objekt l&ouml;schen 
              </a></td>
          <td width="15" background="/liquido/gfx/x_box/d.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
        </tr>
        <tr> 
          <td width="15" height="15" background="/liquido/gfx/x_box/coininfg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td height="15" background="/liquido/gfx/x_box/inf.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td width="15" height="15" background="/liquido/gfx/x_box/coininfd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
        </tr>
      </table>
        <a href="javascript:hide('actionspanel')" onMouseOver="MM_swapImage('hideactionsx','','../../../gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/less.gif" alt="Optionen ausblenden" name="hideactionsx" border="0" id="less_prop1"><br>
        <br>
        </a></div>
        <?php } ?>
        <?php if ($access['c3']) { ?>
      <table width="275" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32"><a href="javascript:show('addpanel','')" onMouseOver="MM_swapImage('add','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/more.gif" alt="Optionen einblenden" border="0" name="add"></a></td>
          <td width="243"><a href="javascript:show('addpanel','')" onMouseOver="MM_swapImage('add','','../../../gfx/more_o.gif',1)" onMouseOut="MM_swapImgRestore()">Objekte 
            hinzuf&uuml;gen</a></td>
        </tr>
      
	  </table>
	  <div id="addpanel" <?php if(!$showupload) echo "style=\"display:none\""; ?>> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="15" height="15" background="/liquido/gfx/x_box/coinsupg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td height="15" background="/liquido/gfx/x_box/sup.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td width="15" height="15" background="/liquido/gfx/x_box/coinsupd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
        </tr>
        <tr> 
          <td width="15" background="/liquido/gfx/x_box/g.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td background="/liquido/gfx/x_box/fond.gif" align="left" width="100%">
		   <form action="" method="post" enctype="multipart/form-data" name="uploadform">
					<?php if($n_uploads > "1") { ?>
					<a href="<?php echo $PHP_SELF ?>?crease=-1" class="smalltext">(-)</a> 
					<?php } ?>
					<br>
					<?php for($i = 1; $i <= "$n_uploads"; $i++) { ?>
					<input name="upload[file<?php echo $i ?>]" type="file" size="15">
					<br>
                <?php }	?>
                <a href="<?php echo $PHP_SELF ?>?crease=1">(+)</a> 
                <br>
                <br>
                <table width="211" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                          <td width="211" height="30"> <p><a href="#" onClick="uploadform.submit()" onMouseOver="MM_swapImage('savenewx1','','../../../gfx/save_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/save.gif" name="savenewx1" border="0" id="savenewx1"></a> 
                              <input name="upload[id]" type="hidden" id="upload[id]" value="<?php echo $temp ?>">
                              <input name="upload[n_uploads]" type="hidden" value="<?php echo $n_uploads ?>">
                            </p>
                          <p> 
                            <?php 
					  	$num = getImportObjects($thiscomp['temp']); 

						if($num) { echo "<a href=\"?import=$temp\">$num Objekte importieren </a>"; } else {
						?>
                          <table width="351" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td width="24" align="center" valign="top"><img src="../../../gfx/info2.gif" width="15" height="15"></td>
                              
                          <td width="327">Um mehrere Objekte gleichzeitig zu importieren, 
                            laden Sie die Dateien per ftp in den Ordner &quot;<?php echo $cfgcmspath ?>container/<?php echo $temp ?>/import&quot;.</td>
                            </tr>
                          </table>
                          <?php } ?>
                          <p></p></td>
                      </tr>
                </table>
            </form></td>
          <td width="15" background="/liquido/gfx/x_box/d.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
        </tr>
        <tr> 
          <td width="15" height="15" background="/liquido/gfx/x_box/coininfg.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td height="15" background="/liquido/gfx/x_box/inf.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
          <td width="15" height="15" background="/liquido/gfx/x_box/coininfd.gif"><img src="/liquido/gfx/x_box/space15_15.gif" width="15" height="15" alt="none"></td>
        </tr>
      </table>
      
        <a href="javascript:hide('addpanel')" onMouseOver="MM_swapImage('less_prop','','../../../gfx/less_o.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../../gfx/less.gif" alt="Optionen ausblenden" border="0" name="less_prop"></a> 
        <br>
      </div>
      <?php } // end uploadpanel ?></td>
  </tr>
</table>
</body>
</html>