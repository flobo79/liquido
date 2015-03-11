<? 

$result = getObjectData($id); 

?>
<table width="100%" border="0" cellpadding="1" cellspacing="2">
  <tr> 
    <td width="23" valign="top">&nbsp;</td>
    <td width="36" height="138" valign="top"><p><img src="gfx/folder.gif" width="25" height="25"><br>
        <br>
      </p></td>
    <td width="168" valign="top"><p> <span class="headline"> <?php echo $result[name] ?></span></p>
      <p> <?php echo $result[info] ?> </p>
      <p><span class="headline"> </span></p>
      </td>
    <td valign="top"><p>erstellt: <?php echo $result[date] ?><br>
        ge&auml;ndert: <?php echo $result[changed] ?></p>
      <span class="headline"></span></td>
  </tr>
</table>
