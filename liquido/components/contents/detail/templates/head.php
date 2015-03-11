<?php switch ($part) {
	case "start":
	?>
<table border="0" cellspacing="0" cellpadding="0">
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
    <td align="center" width="80"><a href="?&select[id]=<?php echo $obj['id'] ?>"><img src="gfx/page_tn.gif" alt="page" /></a></td>
    <td><a href="?select[id]=<?php echo $obj['id'] ?>"><?php echo $obj['title'] ?></a></td>
  </tr>
<?php break;

	case "end":
	 ?>
  <tr> 
    <td class="centerline" style="height:10px;"></td>
    <td></td>
  </tr>
</table>
<?php break;

} ?>