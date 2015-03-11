<table width="199" id="<?php echo $result[id] ?>" border="0" cellspacing="0" cellpadding="0" onClick="selectFolder(<?php echo $result[id] ?>)">
  <tr onmouseover="con.over(this)" onmouseout="con.out(this)" onclick="con.click(this);"> 
    <td width="8" height="25">&nbsp;</td>
    <td width="30" valign="top"><img src="gfx/folder.gif"></td>
    <td> <span class="headline"><?php if($result[id] == $current) echo "<a name=\"current\"></a>"; echo ($name = strlen($result[name]) > 22 ? substr($result[name],0,20)."..." : $result[name]) ?></span> 
      <br>
    </td>
    <td width="10" class="smalltext"><img src="gfx/arrow_right.gif" width="5" height="10"></td>
  </tr>
</table>
