<?php

function listcontents() {
	include("lib/cfg.php");
	
	global $user;

	$sql = "select dest from $cfgtablecomponents where status = '1' order by pos";
	$q = mysql_query($sql);
	
	while ($result = mysql_fetch_array($q)) {
		$sql_r = "select access from ".$dbprefix."_liquido_r_".$result['dest']." where egroup = '$user[groupid]' LIMIT 1";
		$access = mysql_fetch_row(mysql_query($sql_r));
		if($access[0]) {
			include("components/".$result['dest']."/lang.inc.php");
			$lang['components'][$result['dest']] = $lng[$user['lang']];
			echo "<a href=\"?location=help&topic=".$result['dest']."\">".$lang['components'][$result['dest']]['titel']."</a><br>\n";
		}
	}
}

?>
<p><a href="?location=help&topic=start">Willkommen</a><br>
  <a href="?location=help&topic=start&toc=firststeps">Erste Schritte</a><br>
        Tipps und Tricks<br>
        Support</p>
      <p>Module:</p>
     <?php listcontents(); ?>
