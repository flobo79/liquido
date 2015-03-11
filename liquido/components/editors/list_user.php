<table width="180" id="<?php echo $id ?>" border="0" cellspacing="0" cellpadding="0" onClick="selectUser(<?php echo $id ?>)"  <?php if ($curr) echo "bgcolor='#EFEFEF'"; ?>>
  <tr onmouseover="con.over(this)" onmouseout="con.out(this)" onclick="con.click(this);"> 
    <td height="16"><?php echo ($name = strlen($result['name']) > 22 ? substr($result['name'],0,20)."..." : $result['name']) ?></td>
  </tr>
</table>
