<table width="100%" border="0" cellpadding="1" cellspacing="0">
  <tr> 
    <td width="25" valign="top">&nbsp;</td>
    <td width="110" valign="top">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
    <td width="497" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td width="25" valign="top">&nbsp;</td>
    <td width="110" valign="top"><p><a href="#" onClick="window.open('swf_popup.php?file=<?php echo $cfgcmslibdir.$result['id'] ?>','swf','resizable=yes,width=350,height=250'); return false "><img src="gfx/swf_big.gif" border="0"></a><br>
        <br>
        Flash-Document </p></td>
    <td width="261" valign="top"><p> <span class="headline"> <?php echo $result[name] ?></span><br>
        Nummer: <?php echo $result['id'] ?></p>
      <p> <?php echo $result['info'] ?> </p>
      <p>&nbsp;</p>
      <p>erstellt: <?php echo $result['date'] ?><br>
        ge&auml;ndert: <?php echo $result['changed'] ?> </p>
      <p> 
        <?php if($access['c5']) { ?>
        [<a href="list_edit.php?id=<?php echo $id ?>">bearbeiten</a>] 
        <?php } ?>
        <?php if($access['c6']) { ?>
        [<a href="list_delete.php?id=<?php echo $id ?>">l&ouml;schen</a>] 
        <?php } ?>
        <br>
      </p></td>
    <td colspan="2" valign="top"><p class="headline">&nbsp;</p>
      </td>
  </tr>
</table>
