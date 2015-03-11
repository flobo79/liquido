<?php


if(is_array($groups = $_POST['publish']['group']) ) {
	$groups = implode("-",$groups);
} else {
	$groups = "x";
}

if(intval($publish['id'])) {
	// speichere q in publishs
	$sql = "insert into `".$cfg['tables']['nlpublishs']."` (`pb_issue`, `pb_date`, `user_id`, `pb_groups`) values ('".$publish['id']."', '".time()."', '".$user['id']."', '$groups')";
	$db->execute($sql);
	$id = $db->insert_id();
	
	// starte forkscript
	$scriptpath = dirname( __FILE__ );
	$forkme = $scriptpath.'/fork.php '.$id;
	echo $q = PHP_BIN." $forkme >> ".DOCUMENT_ROOT."/liquido_log/newsletter.log &";
	
	passthru($q, $return);
	
	print_r($return);
	
?>
<script language="javascript"> parent.details.window.reload(); </script>
<div class="content_centered">
	<p><strong>Der Newsletter wird jetzt im Hintergrund 
		versendet.</strong></p>
		<p>Info: Wenn es sich um sehr viele Abonnenten handelt, kann dieser Vorgang 
		etwas Zeit in Anspruch nehmen. <br>
		(10000 Abonnenten = ca.30 Minuten) </p>
</div>

<p>&nbsp;</p>
<?php } else { ?>
<p>&nbsp;</p>
Folgender Fehler ist aufgetreten: Die übergebene Newsletter ID ist ungültig.
<p>&nbsp;</p>
<?php } ?>