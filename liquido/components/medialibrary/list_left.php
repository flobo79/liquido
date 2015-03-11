<?php 

include("../../lib/init.php");
auth();





include("lib/functions.php");

// setze defaultfolderid wenn nicht vorhanden
$folderid = isset($_GET['folderid']) ? $_GET['folderid'] : "290779";
$searchvalue = isset($_GET['searchvalue']) ? $_GET['searchvalue'] : "";

// schneide den suchstring auf max 25 zeichen herunter
if($searchvalue and strlen($searchvalue) > 25) $searchvalue = substr($searchvalue,0,25);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/liquido.css" rel="stylesheet" type="text/css">
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/markRows.js"></script>
<script language="JavaScript" type="text/javascript">

	selectFolder = function(id) {
		parent.col2.location.href='list.php?folderid='+id;
		top.content.Details.location.href='list_details.php?id='+id;
	}
	
	selectSearch = function(searchvalue) {
		parent.col2.location.href='list.php?search='+searchvalue;
		top.content.Details.location.href='list_details.php?searchvalue='+searchvalue;
	}
	
	<?php if ($searchvalue) echo "parent.col2.location.href='list.php?search=$searchvalue';"; ?>

</script>
<?php
	// wenn ein suchbegriffe eingegeben wurde verbreitere den iframe
	if (isset($_GET['searchvalue']) or isset($_GET['search'])) {
		setIframeWidth(0,434);
	} else {
		setIframeWidth($folderid,217);
	}
	
	if (isset($_GET['selectFolder'])) updateDetails($_GET['selectFolder']);
?>

</head>
<body <?php echo $body ?>>
	<?php if($searchvalue) { ?>
	<div onClick="selectSearch('<?php echo $searchvalue; ?>'); con.click(this); return false" onMouseOver="con.over(this)" onMouseOut="con.out(this)"  class="ru row" id="y">
		<div class="icon"><img src="gfx/lupe.gif" alt="o"/></div>
		<div class="arrow">&nbsp;</div>
		<div class="label"><?php echo urldecode($searchvalue) ?></div>
	</div>
	<?php } ?>

	<?php ListFolder($folderid,"name",$current,$search,22); ?>

	<?php if ($access['c1'] and !$search) { ?>
	<div class="row" onMouseOver="con.over(this)" onMouseOut="con.out(this)"  onClick="parent.col2.location.href='list_newFolder.php?folderid=<?php echo $folderid ?>'; con.click(this);">
		<div class="icon"><img src="gfx/addfolder.gif" alt="+" /></div>
		<div class="arrow">&nbsp;</div>
		<div class="label">Mappe anlegen</div>
	</div>
	  <?php } ?>
</body>
</html>
