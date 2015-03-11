<?php

function listcomponents() {
	include("lib/cfg.php");

	echo "<table>
		<tr>";
	
	$sql = "select * from $cfgtablecomponents where status = '1' order by pos";
	$q = mysql_query($sql);
	$i = 0;
	
	while ($result = mysql_fetch_array($q)) {
		
		$sql_r = "select access from ".$dbprefix."_liquido_r_".$result['dest']." where egroup = '".$_SESSION['user']['groupid']."' LIMIT 1";

		$access = mysql_fetch_row(mysql_query($sql_r));
		if($access[0]) {
			include("components/".$result['dest']."/lang.inc.php");
			$lang['components'][$result['dest']] = $lng[$_SESSION['user']['lang']];
			echo "<td align=\"center\" width=\"180\">
				<a href=\"body.php?setmod=$result[dest]\">
					<img src=\"components/".$result['dest']."/gfx/logo.gif\" border=\"0\"><br>
					".$lang['components'][$result['dest']]['titel']."<br>";
					if(file_exists($thisfile = "components/".$result['dest']."/start.inc.php")) include($thisfile);
			echo"	</a>
			</td>
			";
			
			$i++;
			if($i == 3) {
				echo "</tr><tr>
				";
				$i = 0;
			}
		}
		
	}
	echo "</tr>
	</table";
}

?>