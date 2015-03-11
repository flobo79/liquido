<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="40"><img src="gfx/group.gif" border="0"></td>
    <td> Ausgabe <b><?php echo $data['title']; ?></b><br>
		<span class="smalltext">(<?php showstatus($data['status']) ?>)</span>
	</td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td align="center"><br>
     <?php echo listobjects($nlobj); ?>
      <br>
	</td>
  </tr>
</table>