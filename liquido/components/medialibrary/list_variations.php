	<?php switch($part) {
		case "start":
		?>
	<table width="250" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<?php break; case "box": ?>
          <td width="125" align="center"><table width="120" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="112" align="center" valign="top"> <img src="<?php echo $cfgcmslibdir."/".$variation['id'] ?>/small.jpg"> 
                  <br> <?php echo $variation['name'] ?> <br>
                 </td>
              </tr>
            </table>
		  </td>
          <?php break; case "end": ?>
        </tr>
      </table>
	 <?php break; } ?>