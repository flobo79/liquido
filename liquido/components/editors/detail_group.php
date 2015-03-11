<?php 
include("lib/functions.php");
$details = userData($group,"");
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
<?php if ($updatebottom) { ?>
<script language="JavaScript">
	<!-- 
		parent.bottom.location.href='bottom.php?group=<?php echo $group ?>';
	-->
</script>
<?php } ?>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="730" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="27" height="70"><img src="../../gfx/spacer.gif" width="25" height="8"></td>
    <td width="53" valign="top"><br> <img src="gfx/keybound.gif" width="50" height="53"> 
    </td>
    <td width="650" valign="top"><p>&nbsp;</p>
      <p class="headline">Gruppe <span class="headline"><?php echo $details['name'] ?></span></p></td>
  </tr>
  <tr>
    <td height="70">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><form name="detailsform" method="post" action="">
 <?php 

	switch($part) {
		case "":
?>
        Freigabe: 
        <?php if($access['c8']) { ?>
        <input id="status" name="changestatus[status]" type="checkbox" onClick="detailsform.submit()" value="1" <?php if ($details['status']) echo "checked" ?> <?php if(!$access['c8']) echo "disabled"; ?>>
        <input name="changestatus[group]" type="hidden" id="changestatus[group]" value="<?php echo $group ?>">
        <?php } else { echo ($details['status'] ? "aktiv" : "gesperrt"); } ?>
      </p>
      <p> 
        <?php if($access['c3']) { ?>
        [<a href="?part=delete&group=<?php echo $group ?>">Gruppe 
        l&ouml;schen</a>] 
        <?php }  break;
	case "delete":
 ?>
      </p>
        <table width="290" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="290"><p>Soll die Gruppe <span class="headline"><?php echo $details['name'] ?></span> 
                wirklich gel&ouml;scht werden?</p>
              <p>Sollen die Mitglieder dieser Gruppe in eine andere Gruppe verschoben 
                werden?<br>
                <br>
                <?php dropbox_groups("togroup",$group); ?>
                &nbsp; <a href="#" onClick="detailsform.submit(); return false">ok</a> 
                &nbsp;&nbsp;<a href="#" onClick="javascript:history.back();">abbrechen</a> 
                <input name="group" type="hidden" id="group" value="<?php echo $group ?>">
                <input name="deletegroup" type="hidden" value="1">
              </p>
              <p>&nbsp;</p></td>
          </tr>
        </table>

      <?php 

	break;
} ?>
      </form></td>
  </tr>
</table>
</body>
</html>