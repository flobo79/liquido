<?php

include("../../../lib/init.php");
include("../functions.inc.php");

$type = $_SESSION['components'][$comp]['type'];

if ($messageid = $_GET['selMessage']) {
	$_SESSION['components'][$comp]['message'] = $messageid;
	$updateMessage = true;
	
	if($read) {
		readMessage($messageid);
		$updatePanel = true;
	}
}


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../../css/liquido.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
	<?php if ($updateMessage) echo "parent.message.location.href='message.php?selMessage=$selMessage';"; ?>
	<?php if ($updatePanel) echo "parent.parent.left.location.href='../left_pane.php';"; ?>
</script>
</head>

<body><table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p><b><?php echo $type == "in" ? "empfangene Nachrichten" : "gesendete Nachrichten"; ?> </b></p><?php listMessages($type) ?></td>
  </tr>
</table>


</body>
</html>
