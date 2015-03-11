<?php switch ($part) {
	case "start":
	?>
<table border="0" cellspacing="0" cellpadding="0">
<?php
		break;
	case "group":
	?>
  <tr> 
    <td width="80" align="center"><a href="?&select[id]=<?php echo $obj[id] ?>"><img src="gfx/group.gif" border="0"></a></td>
    <td width="229"><a href="?&select[id]=<?php echo $obj[id] ?>"><?php echo $obj[title] ?></a></td>
  </tr>
<?php break;
	case "space":
	?>
  <tr> 
    <td class="centerline" height="5"></td>
    <td></td>
  </tr>
<?php break;
	case "page":
	?> 
  <tr>
    <td align="center"><a href="?&select[id]=<?php echo $obj[id] ?>"><img src="gfx/page.gif" border="0"></a></td>
    <td><a href="?&select[id]=<?php echo $obj[id] ?>"><?php echo $obj[title] ?></a></td>
  </tr>
<?php break;


	case "end":
	 ?>
  <tr> 
    <td class="centerline">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php break;

} ?>