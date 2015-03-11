<?php

$thiscomp = $_SESSION['components'][$comp];

if(($thiscomp['action'] == "answer" or $thiscomp['action'] == "forward") and $thiscomp['message']) $message = getMessage($thiscomp['message']);

if($thiscomp['action'] == "answer") {
	$send['reciepient'] = $message['from'];
	$send['subject'] = "re: ".$message['subject'];
	$send['message'] = "\n\n\n\n------------------------------\nOriginalnachricht:\n\n".$message['message'];
}

if($thiscomp['action'] == "forward") {
	$send['subject'] = "fw: ".$message['subject'];
	$send['message'] = "\n\n------------------------------\nOriginalnachticht\nvon: ".$message['fromname'].":\n\n".$message['message'];
}
$_SESSION['components'][$comp] = $thiscomp;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><form name="form1" method="post" action="">
        <?php if(!$sendresult) { ?>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="81">Empf&auml;nger: </td>
            <td width="419"><select name="send[reciepient]" id="send[reciepient]">
                <option value=""></option>
                <?php listUser ($send['reciepient']) ?>
              </select> </td>
          </tr>
          <tr> 
            <td>Betreff: </td>
            <td><input name="send[subject]" type="text" value="<?php echo  $send['subject'] ?>" size="40" maxlength="150"></td>
          </tr>
          <tr> 
            <td valign="top">Mitteilung:</td>
            <td><textarea name="send[message]" cols="40" rows="15"><?php echo  $send['message'] ?></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="send[permail]" type="checkbox" value="1" checked>
              auch als Email zustellen</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><a href="#" onClick="form1.submit(); return false">absenden</a> 
              <input name="send[submit]" type="hidden" id="send[submit]" value="send"></td>
          </tr>
        </table>
		<?php } else { ?>
        <table width="500" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Nachricht wurde versendet</td>
          </tr>
        </table>
		<?php  } ?>
        <br>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
