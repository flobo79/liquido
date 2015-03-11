<?php
session_start();
include("../../../lib/init.php");
include("../functions.inc.php");

$type = $_SESSION['components'][$comp]['type'];

if($selMessage) $message = getMessage($selMessage);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../../css/liquido.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php if($message) { ?>
<table width="336" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="336"><?php
	echo $message['fromname']." schrieb:";
	
	
	?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="336" border="0" cellspacing="0" cellpadding="5" class="solidborder">
  <tr>
    <td width="324" class="headline"><?php echo $message['subject'] ?></td>
  </tr>
  <tr>
    <td><?php echo $message['message'] ?><br>
      <br>
    </td>
  </tr>
  <tr>
    <td align="center" class="ro"> 
      <?php if($type != "out") { ?>
      <a href="#" onClick="parent.location='../body.php?answer=<?php echo $message['id'] ?>'">antworten</a> |
      <?php } ?>
      <a href="#" onClick="parent.location='../body.php?forward=<?php echo $message['id'] ?>'">weiterleiten</a> | 
	  <a href="#" onClick="parent.location='../body.php?delete=<?php echo $message['id'] ?>'">l&ouml;schen</a></td>
  </tr>
</table>


<?php } ?>
</body>
</html>
