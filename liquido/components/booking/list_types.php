<?php 
include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/init.php");
auth();



// coupons speichern
if($_POST['edit']) {
	if(is_array($_POST['edit'])) {
		foreach($_POST['edit'] as $id => $entry) {
			if($entry['tr_designation']) {
				$sql = "update `fs_b_trainings` set `tr_designation` = '".mysql_escape_string($entry['tr_designation'])."', tr_description = '".mysql_escape_string($entry['tr_description'])."' where training_id = '$id' LIMIT 1";
				$db->execute($sql);
			} else {
				$error[$id] = "Bitte geben Sie eine Bezeichnung ein";
			}
		}
	}
}

if($entry = $_POST['add']) {
	if($entry['tr_designation']) {
		$ok=$db->execute("insert into `fs_b_trainings` (tr_designation,tr_description) values ('".mysql_escape_string($entry['tr_designation'])."','".mysql_escape_string($entry['tr_description'])."')");
    if(!$ok) {
      $add_title_error = "Bezeichnung bereits vergeben!";
    }
	} else {
		$add_title_error = "Bitte geben Sie eine Bezeichnung ein";
	}
}

$sql = "select * from fs_b_trainings";
$types = db_array($sql,MYSQL_ASSOC);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Trainingsarten</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="/liquido/components/booking/js.js"></script>
<link href="/liquido/components/booking/booking.css" rel="stylesheet" type="text/css">
<link href="/liquido/components/booking/fm.css" rel="stylesheet" type="text/css">
<style type="text/css">
	td { 
		font-family:verdana;
		font-size:11px;
	}
	
	th {
		font-family:verdana;
		font-size:11px;
		text-align:left;
		font-weight:bold;
	}
	img {
		border:0;
	}
	a {
		color:#333333;
	}
</style>

</head>

<body>
<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F8">
    <tr>
      <td>
	  <form action="<?php echo $PHP_SELF ?>" method="post" enctype="application/x-www-form-urlencoded">
        <table width="801" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <th width="213" height="41"><p>Bezeichnung:</p></th>
            <th width="588" colspan="2">Beschreibung (250 Zeichen): </th>
          </tr>
          <?php foreach($types as $type) { ?>
          <tr> 
            <td width="213" height="81" valign="top"><p> 
                <input name="edit[<?php echo $type['training_id'] ?>][tr_designation]" type="text" value="<?php echo $type['tr_designation'] ?>" size="30" maxlength="50" />
                <br>
                <?php echo $error[$type['training_id']] ?><br>
                <br>
                <br>
              </p></td>
            <td width="294" valign="top"> <textarea name="edit[<?php echo $type['training_id'] ?>][tr_description]" cols="40"><?php echo $type['tr_description'] ?></textarea> 
            </td>
            <td width="294" valign="top"><!-- <a href="#" onclick="confirmAction('');"><img src="gfx/searchdel.gif" width="14" height="14"> 
              l&ouml;schen </a>--></td>
          </tr>
          <?php } ?>
          <tr> 
            <td colspan="3"><p> 
                <input type="submit" name="Submit" value="speichern"  class="formbutton">
              </p>
              <p>&nbsp; </p>
              <p> <strong>Neue Eventart erstellen</strong></p></td>
          </tr>
          <tr> 
            <td width="213" height="81" valign="top"> <p> 
                <input name="add[tr_designation]" type="text" value="<?php echo $_POST['add']['tr_designation'] ?>" size="30" maxlength="50" />
                <br>
                <?php echo $add_title_error; ?><br>
                <br>
                <br>
              </p></td>
            <td width="588" colspan="2" valign="top"> <textarea name="add[tr_description]" cols="40"><?php echo $_POST['add']['tr_description'] ?></textarea></td>
          </tr>
          <tr> 
            <td height="65" colspan="3"> <input type="submit" name="Submit2" value="speichern"  class="formbutton"> 
              <?php echo $savstat; ?> </td>
          </tr>
        </table>
    	</form>
    	</td>
    </tr>
  </table>
  </body>
</html>
