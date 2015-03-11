<?php echo '<?xml version="1.0" ?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
	<title>liquido</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="<?php echo LIQUIDO ?>/css/liquido.css" rel="stylesheet" type="text/css" />
	<link href="styles.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo LIQUIDO ?>/css/objects.css" rel="stylesheet" type="text/css" />
	<?php foreach($cfg['components']['contents']['css'] as $lnk) { ?>
	<link href="<?php echo $lnk; ?>" rel="stylesheet" type="text/css" />
	<?php } ?>
	<script language="JavaScript" type="text/JavaScript" src="/liquido/js/mootools.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="/liquido/js/utils.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="/liquido/components/medialibrary/browser/mediabrowser.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="/liquido/js/liquido.js"></script>
	
	<style type="text/css">
		ul, li { padding:0; margin:0; list-style-type:none; cursor:pointer; }
		li { }
		#toolbar {
			position:fixed;
			right:0;
			top:0px;
			padding-top: 40px;
			background-image:url(/liquido/templates/blue/gfx/bg.jpg);
      height:100%;
		}
	</style>
</head>

<body class="compose">
<div id="img_saved"></div>


<?php
	if($access['c9']) {
		if($data['locked']) {
			$locked = split(":", $data['locked']);
			$locked_typ = $data['type'] == "page" ? "Seite" : "Gruppe";
			$locked_user = db_entry($sql = "select a.name,a.id,a.mail from $cfgtableeditors as a where a.id = '$locked[1]' LIMIT 1");
		
//			print_r($locked_user);
			$locked_since = round((time() - $locked[0]) / 60);

			// wenn editor nicht der eigentümer ist
			if($locked[1] != $user['id']) {	
				// wenn die session des eigentümers abgelaufen ist übernehme
				if($locked_since > 240) {
					$lock = time().":".$user['id'];
					$db->execute("update $cfgtablecontents set locked = '$lock' where id = '$obj[id]' LIMIT 1");
				} else {
					include("locked.php");
					$is_locked = 1;
				}
			} else {
				$lock = time().":".$user['id'];
				$db->execute("update $cfgtablecontents set locked = '$lock' where id = '$obj[id]' LIMIT 1");
			}
		}
		
		if(!$is_locked) {
			if($cfg['components']['contents']['compose']['lock']) lockObject($data['id']);
			if($data['type'] == "page") {
				include("page.php");
			} else {
				$cfg['components']['contents']['compose']['enable_groups'] ? include("group.php") : include("group_nocompose.php");
			}
		}
	} else { 
		
		
		include("noaccess.php");
	}
?>

</body>
</html>