<?php 

include("lib/functions.php");

// setze frameindex auf 290779 by default  (its my birthsdate ;-)
$folderid = $folderid ? $folderid : "290779";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php 
	if($refreshParent) { 
	?>
	<script language="JavaScript">
		parent.frames['col1'].location = 'list_left.php?folderid=<?php echo $refreshParent ?>&selectFolder=<?php echo $folderid ?>';
	</script>
	
<?php } ?>
</head>
<frameset rows="1" cols="217,*" framespacing="1" frameborder="no">
  <frame src="list_left.php?folderid=<?php echo $folderid ?>" name="col1" noresize>
  <frame src="list_right.php" name="col2" scrolling="NO">
</frameset>
<noframes></noframes>
<body>

</body></noframes>
</html>
