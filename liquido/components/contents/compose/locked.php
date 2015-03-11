<table width="425" border="0" cellpadding="0" cellspacing="0">
    <td width="80" height="200" align="center" valign="top"><p>&nbsp;</p></td>
    <td valign="top"><p><br>
          <b><?php echo $typ." ".$data['title'] ?> kann nicht bearbeitet werden.</b><br>
          <br>
		  Diese <?php echo $locked_typ ?> wird seit <?php echo $locked_since ?> Minuten 
          von <a href="mailto:<?php echo $locked_user[2] ?>"><?php echo $locked_user[0]; ?></a> bearbeitet.</p>
        <p><?php if ($access['c18']) { ?>Möchten Sie die Bearbeitung übernehmen? Änderungen werden 
          möglicherweise überschrieben.</p>
        
      <p><a href="?overridelock=1">ja übernehmen</a></p>
      <?php } ?></td>
  </tr>
  <tr> 
    <td colspan="2"><table border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="40">&nbsp;</td>
            <td width="382">&nbsp; </td>
        </tr>
      </table></td>
  </tr>
</table>
