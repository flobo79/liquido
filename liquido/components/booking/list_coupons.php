<?php

include($_SERVER['DOCUMENT_ROOT']."/liquido/lib/init.php");
auth();

//$sql = "select * from fs_b_coupons as a left outer join fs_b_reserv as b on a.cp_rs_id = b.rs_id group by a.cp_id desc";
$sql = "SELECT c.*,d.date_id,DATE_FORMAT(d.dt_date,'%d.%m.%Y') AS datum,DATE_FORMAT(d.dt_time,'%H:%i Uhr') AS uhrzeit,r.rs_id,r.rs_firstname,r.rs_lastname FROM fs_b_coupons c LEFT JOIN fs_b_reserv r ON c.cp_rs_id = r.rs_id LEFT JOIN fs_b_dates d ON r.date_id = d.date_id ORDER BY d.dt_date DESC";
$coupons = db_array($sql,MYSQL_ASSOC);

// coupons speichern
if($_POST['add_coupons']) {
	$coupons = explode(",",trim($_POST['add_coupons']));
	$time = time();
	foreach($coupons as $coupon) {
		if($coupon) $db->execute("insert into `fs_b_coupons` values ('','".mysql_escape_string($coupon)."','$time','','')");
		$savestat = "Gutscheine gespeichert";
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gutscheinliste</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="booking.css" rel="stylesheet" type="text/css" title="Normal" media="screen">
<link href="print.css" rel="stylesheet" type="text/css" media="print">
<script language="javascript">
function Invers(){
temp = document.dates.elements.length ;
for (i=0; i < temp; i++){
	if(document.dates.elements[i].checked == 1) {
		document.dates.elements[i].checked = 0;
	} else {
		document.dates.elements[i].checked = 1}
	}
}

</script>
</head>

<body>
<form action="" method="post" name="dates" class="borderless" id="dates">
<?php switch ($_GET['action']) { 
	default: ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" width="20" class="highlight">&nbsp;</td>
    <th scope="col" width="19%">*Gutschein-Nr.</td>
    <th scope="col" width="18%">Erstellungsdatum</td>
    <th scope="col" width="30%">Eventdatum</td>
    <th scope="col" width="15%">Gutscheininhaber</td>
  </tr>
  <?php foreach($coupons as $cp) { ?>
  <tr>
    <td><input name="coupons[<?php echo $entry['id'] ?>" type="checkbox" value="check"></td>
    <td><?php echo $cp['cp_nr'] ?></td>
    <td><?php echo $cp['cp_createdate']; ?></td>
    <td><?php if($cp['cp_usedate']) echo "<a href=\"list_dates.php?action=edit&id=".intval($cp['date_id'])."\">".$cp['datum']." ".$cp['uhrzeit']."</a>"; ?>&nbsp;</td>
    <td><?php if($cp['cp_usedate']) echo "<a href=\"list_bookings.php?action=edit&id=".intval($cp['rs_id'])."\">".trim($cp['rs_firstname']." ".$cp['rs_lastname'])."</a>"; ?>&nbsp;</td>
  </tr>
  <?php } ?>
</table>
  <?php 	break; case "add": ?>
    <p>Geben Sie eine oder mehrere Gutscheinnummern kommasepariert ein:<br>
    <textarea name="add_coupons" cols="60" rows="10" id="add_coupons"></textarea>
    <br>
    <input type="submit" name="Submit" value="speichern"> <?php echo $savstat; ?>
  </p>
</form>
  <?php  break; } ?>
</body>
</html>
