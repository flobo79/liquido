<script language="JavaScript" type="text/javascript">
	<!--
	searchValue = function () {
		var value = document.form1.searchvalue.value;
		parent.mainFrame.iframe.frames[0].location.href='list_left.php?searchvalue='+escape(value);
	}
	-->
</script>
<table width="100%" height="95%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="37">&nbsp;</td>
    <td width="363" valign="top"> <p class="headline"><br>
        Media-Library</p>
      <p>Bitte eine Mappe ausw&auml;hlen oder eine Mappe anlegen</p>
      <p>&nbsp;</p>
      <form name="form1" method="post" action="">
        Suche: 
        <input name="searchvalue" type="text" class="text" value="<?php echo $searchvalue ?>" maxlength="25">
        <a href="#" onClick="searchValue(); return false">ok</a> </form></td>
    <td width="703" valign="top"><p><br>
		Quota-Informationen:<br>
        <br>
<?php 

function dirsize($dir) { 
   // calculate the size of files in $dir, (it descends recursively into other dirs) 
	$dh = opendir($dir); 
  
   $size = 0; 
   while (($file = readdir($dh)) !== false) 
       if ($file != "." and $file != "..") { 
           $path = $dir."/".$file; 
           if (is_dir($path)) 
             $size += dirsize($path); 
           elseif (is_file($path)) 
               $size += filesize($path); 
      } 
   closedir($dh); 
   return $size; 
}

$size = dirsize($_SERVER['DOCUMENT_ROOT'].MEDIALIB);
?>

        Verwendeter Speicherplatz:
        <?php echo number_format($size / 1024 / 1024,2,",",".")  ?> MB
        <br>
        Verf&uuml;gbarer Speicherplatz: 
        <?php echo  number_format(diskfreespace($_SERVER['DOCUMENT_ROOT'].MEDIALIB) / 1024 / 1024,2,",",".") ?> MB
      </p>
      </td>
  </tr>
</table>

