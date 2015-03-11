<?php 

$topic = $_GET['topic'];
@include("components/$topic/lang.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido hilfe</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/liquido.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
	<!--
	 top.head.location.href = 'head.php?location=help&topic=<?php echo $topic ?>'
	//-->
</script>
</head>

<body>
<table width="596" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td width="181" height="99"><img src="gfx/help.gif"></td>
    <td width="415" class="bigheadline"><p> <span class="bigbigheadline">Hilfe</span><br>
        <br>
        Bereich: <?php echo $lng[$user['lang']]['titel'] ?><br>
        <br>
      </p></td>
  </tr>
  <tr valign="top"> 
    <td>
	<?php
	 if(file_exists("components/$topic/help/toc.php")) { ?>
	 	Themen:<br>
	<?php include("components/$topic/help/toc.php"); } ?>
	</td>
    <td> 
      <?php 
	if($toc) { 
		$file = "components/$topic/help/$toc.php";
	} else {
		$file = "components/$topic/help/index.php";
	}
	
	if (file_exists($file)) { 
		include($file); 
	} else { 
?>
      Leider konnte kein Hilfethema gefunden werden. 
      <?php } ?>
    </td>
  </tr>
</table>
</body>
</html>
