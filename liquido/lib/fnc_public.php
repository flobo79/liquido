<?php

	
function get_template_id ($page) {
	$t_contents = db_table("contents");

	while ($parent) {
		$sql = "SELECT id,title,parent,template FROM $t_contents WHERE id = '$page' and del != '1' LIMIT 1";
		$result = db_entry($sql);
		if($result[0]) {
			$parent = $result['parent'];
			if($result['template']) return $result['template'];
		}
	}
	return 0;
}


function frame($id) {
	include("cfg.php");

	$sql = "select * from $cfgtabletemplates where id = '$id' LIMIT 1";
	$result = mysql_fetch_array(mysql_query($sql));

	$obj['template']['id'] = $id;
	$html = parseCode($obj,$result['code']);
	
	echo $html;
}

function showlink($title,$id,$group,$addon,$class=0) {
	include("cfg_general.inc.php");
	
	if($modrewrite) {
		echo "<a href=\"$linkprefix,$id,$group,$addon.html\" class=\"$class\">$title</a>";
	} else {
		if($addon) $addon = "&".$addon;
		if($class) $class = " class=\"$class\"";
		echo "<a href=\"?vars[id]=$id&vars[group]=$group$addon\" class=\"$class\">$title</a>";
	}
}


/*
function textobject($thisobject) {
	while (list($key,$value) = each($thisobject)) {
		$$key = $value;
	}
	
	$field = $thisobject['field'] ? $thisobject['field'] : "text";
	
	switch ($part) {
		case "compose":
			// ermittle die anzahl der form-zeilen
			$rows = ($rowsx = ceil((strlen($result[$field]) / ($textwidth / 5.5)))) < $formrows ? $formrows : $rowsx;	
			
			// füge linebreaks als zeilen hinzu
			$rows += substr_count($result[$field],"\n");
		
			// wenn ein wrap-typ eingegeben wurde
			$wrap = $wrap ? " wrap=\"$wrap\"" : "";
			
			echo "<textarea name=\"objectdata[$result[id]][$field]\" rows=\"$rows\" class=\"$css_class\" style=\"width:".$textwidth."px\" $wrap>htmlentities($result[$field])</textarea>";
		break;
	case "public":
		if($nl2br == "no") {
			echo $result[$field]."</br>\n";
		} else {
			echo nl2br($result[$field])."</br>\n";
		}
		break;
	}
}

*/

/*
function getDay($date) {
	if(strftime("%D",$date) == strftime("%D",time())) {
		$day = "heute";
	} elseif (strftime("%D",$date) == strftime("%D",(time() - 86400))){
		$day = "gestern";
	} else {
		$day = strftime("am %d.%m.%y",$date);
	}
	return $day;
}
*/
/*
function formattime($timestamp) {
	setlocale("LC_TIME", "de_DE");
	$time = strftime("%d.%m.%y",$timestamp);
	return $time;
}
*/


function listpictures($id,$type,$path=0) {
	include("cfg.php");
	global $db;
	global $fe;
	global $fmode;

	$sql = "select a.id,a.libid,a.cid,a.info,b.link,b.smalltext1 from $cfgtablecontentimgs as a, $cfgtablecontentobjects as b where a.cid = '$id' and b.id = a.cid";
	$pictures = db_array($sql);
	
	foreach($pictures as $picture) {
		$pic = IMAGES.'/'.$id.'/'.$picture['libid'].'/thumbnail.jpg';
		$pic2 = IMAGES.'/'.$id.'/'.$picture['libid'].'/small.jpg';
		$pic3 = $_SERVER['DOCUMENT_ROOT'].$fe->cfg['env']['cmspicdir'].'/'.$id.'/'.$picture['libid'].'/original.jpg';
		
		$imagesize2 = GetImageSize($_SERVER['DOCUMENT_ROOT'].$pic2);
		$imagesizex = GetImageSize($_SERVER['DOCUMENT_ROOT'].$pic);
		if($imagesizex[0] > $imagesize[0]) $imagesize = $imagesizex;
		
		if($type == "size") {
			// 
			
		} else {
			
			if($type == 'compose') {
				if($access['c14']) $delbutton = '<a href="?delpic[picid]='.$picture['id'].'"><img src="'.$cfg['env']['cmspath'].'/components/contents/gfx/delobject.gif" alt="dieses Bild l&ouml;sche" /></a>';
				echo '<img src="'.$pic.'" alt="Bild bearbeiten">'.$delbutton;
				
			} else {
				if($picture['link']) {
					
					if($picture['link'] == "show") {
						echo "<a href=\"$pic\"><img src=\"$pic\" border=\"0\"></a>\n";
					} elseif ($picture['link'] == "popup") {
						echo "<a href=\"#\" onClick=\"window.open('/liquido/lib/pic_popup.php?pic=$pic2','imagepopup','width=$imagesize2[0],height=$imagesize2[1]'); return false \"><img src=\"$pic\" border=\"0\"></a>\n";
					} else {
						echo "<a href=\"$picture[link]\" target=\"$picture[smalltext1]\"><img src=\"$pic\" border=\"0\"></a>\n";
					}
				} else {
					echo "<img src=\"$pic\" border=\"0\">\n";
				}
			}
		}
	}
	return $imagesize;
}

function checkAdmin() {
#######################################
	include("cfg.php");
	
	global $sessionid;
	global $user;
	
	if($user['id']) {
		$check_session = mysql_fetch_row(mysql_query("select editor,timestamp from $cfgtablesessions where sessid = '$sessionid' and editor = '$user[id]' and status != '1' limit 1"));
	
		// wenn keine gültige session besteht
		if($check_session[0] and $check_session[0] == $user['id']) {
			$currenttime = time();
			// wenn max lifetime abgelaufen ist (cfg_general.php);
			if($cfgSessionLifetime and ($currenttime - $check_session[1]) > $cfgSessionLifetime) {
				//$location = $REQUEST_URI;
				mysql_query("update $cfgtablesessions set status = '1' where sessid = '$sid'");
				return false;
			} else {
				// aktualisiere Zeitstempel
				mysql_query("update $cfgtablesessions set timestamp = '$currenttime' where sessid = '$sid'");
				return true;
			}
		}
	} else {
		return false;
	}
}



function write_page_cache($page) {
	
}

function write_statistic ($page) {
	db_query("insert into ".db_table("content_stats")." values ('$page', ".time().", '".$_SERVER['REMOTE_ADDR']."')");
}


?>
