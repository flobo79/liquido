<?php

if(!isset($access)) {  $access = loadAccessTable($user,"contents"); }

// beim verlasses den composemodus setze seite frei
if($cfg['components']['contents']['compose']['enable_groups'] and $mode != "compose") {
	global $cfgtablecontents;
	mysql_query("update `$cfgtablecontents` set locked = '' where `id` = '$obj[id]' LIMIT 1");
}

if(!isset($mode)) $mode = "detail";

if(isset($_GET['refresh'])) {
	refreshPage($_GET['refresh']);
}

if(isset($_GET['refreshall'])) {
	refreshAll();
}

if(isset($_GET['setmode'])) {
	$update_rightframe = true;
}

if(isset($_GET['select']['id'])) {
	if(getdata(intval($_GET['select']['id']))) {
		
		if($mode != "compose" and $mode != "preview" and $mode != "detail") {
			$_SESSION['components']['contents']['current'] = "detail";
			$mode = "detail";
			
		}
		
		$_SESSION['components']['contents']['id'] = $_GET['select']['id'];
		$thiscomp = $_SESSION['components']['contents'];
		//$update_leftframe = true;
		$update_rightframe = true;
		
	} else {
		$nosearchresult = true;
	}
}


// load details for current page
$data = getdata($thiscomp['id']);
$node = new Node($thiscomp['id']);

/**
 * set the page to be parked for editing
 * 
 * @param object $id
 * @return 
 */
function parkPage($id) {
	//db_query("update ".db_table("contents_cache")." set refresh = '6' where page = '$id' and refresh != '-1' LIMIT 1");
	
	    echo "update ".db_table("node_cache")." set refresh = '6' where page = '$id' and refresh != '-1'";
	db_query("update ".db_table("node_cache")." set refresh = '6' where page = '$id' and refresh != '-1'");
}

/** 
 * set the page to be punlic and cacheable
 * 
 * @param object $id
 * @return 
 */
function refreshPage($id) {
	db_query("update ".db_table("contents_cache")." set refresh = '0' where page = '$id' LIMIT 1");
	db_query("update ".db_table("node_cache")." set refresh = '0' where refresh = '6' and refresh != '-1'");
}

/** 
 * set all page to be public and cacheable
 * 
 * @param object $id
 * @return 
 */
function refreshAll() {
	db_query("update ".db_table("contents_cache")." set refresh = '0' where refresh = '6' and refresh != '-1'");
	db_query("update ".db_table("node_cache")." set refresh = '0' where refresh = '6' and refresh != '-1'");
}

/**
 * delete $content[type]
 * 
 * @param object $content
 * @return 
 */
function movetotrash($content) {
	$user = $_SESSION['user'];
	$table = db_table($content['type']);
	$sql = "update $table set del = '$user[id]' where id = '".intval($content['id'])."' LIMIT 1";
	mysql_query($sql);
}

function countTrashItems () {
	//include("../../lib/cfg.php");
	$user = $_SESSION['user'];	
	
	global $cfgtablecontentobjects;
	global $cfgtablecontents;
	
	$countobjects = db_entry("select COUNT(a.id)  
					from 	".db_table("contentobjects")." as a left join 
							".db_table("contents")." as b
							on b.id = a.parent
					where 	a.del = '$user[id]' and b.type = 'page'");

	
	$countcontents = db_entry("select COUNT(id) from $cfgtablecontents where del = '$user[id]' and type = 'page'");
	
	
	return $countobjects[0]+$countcontents[0];	
}


function load_contentobjectfunctions($content,$fncdata) {
	include("../../lib/cfg.php");
	$cfgcmspath = "../../";
	
	$svSQL = "select * 
				from $cfgtablecontentobjects
				where parent = '$content[id]' and del != '1'
				order by rank";
	
	// kennzeichne administrationsbereich
	$admin = 1;
	
	// lade die "load"-trigger
	$fncpart = "load";
	
	$testquery = mysql_query($svSQL);
	$query = mysql_query($svSQL);
	if (mysql_fetch_array($testquery)) {
		while ($result = mysql_fetch_array($query) and !$endfunction) 
		{	
			$objectid = $result['id'];
			include($cfgcmspath."objects/$result[type]/$result[layout]/functions.php");
		}
	}
	
	return $fncdata;
}

function page($page,$part,$inc=0) {
/*
der parameter inc gibt an, dass die seite included
wurde, und daher keine angaben wie parents oder template benötigt
*/

	$pagedata = array();
	if(!isset($page)) die ("page(): keine id übergeben");
	   
	// lade pagedata
	$pagedata = getdata($page);

	//$cache = get_page_cache($page);

	$content = listobjects($pagedata,$part);
	
	// write statistik
	if(!$composemode) {
		$content = parsePage($pagedata,$content);
	}

	return $content;
}


function getdata($content) {

	// PageInformationen
	$where = intval($content) ? " `id` = '$content'" : "`type` = 'page' order by `title`";
	$t = db_table('contents');
	
	$sql = "select * from $t where $where limit 1";
	$content = mysql_fetch_array(mysql_query($sql),MYSQL_ASSOC);
	
	if($content['id']) {
		// cache information
		$content['cache'] = db_entry("select page,refresh,lastupdate from `".db_table("contents_cache")."` where page = '$content[id]' LIMIT 1");

		if(!$content['cache']['page']) {
			db_query("insert into `".db_table("contents_cache")."` (`page`) values ('$content[id]')");
		}
		
		// Änderungsdatum
		$t2 = db_table('contents_changes');
		$sql = "select * from $t2 where obj = '$content[id]' ORDER BY id DESC LIMIT 1";
		$changes = mysql_fetch_array(mysql_query($sql),MYSQL_ASSOC);
		
		if($changes['date']) { 
			$content['changedate'] = strftime(getDay($changes['date'])." %H:%M",$changes['date']); 
		} else { 
			$content['changedate'] = "keine Änderungen"; 
		}
	
		// parents
		$content['parents'] = getparents($content['parent']);
		
		// clean URL System Link
		global $L;
		$content['cleanURLSystem'] = $L->getSystemURL($content['title']);
	
		// erstellungsdatum
		$content['date'] = strftime(getDay($content['date'])." %H:%M",$content['date']);
		
		// vererbe seitenbreite
		if(!$content['width']) $content['width'] = $content['parents']['width'];
		
		return $content;
	}
}
	

function getstatus($status) {
############################################
	switch ($status) {
		case "0":
			return "offline";
			break;
		case "1":
			return "online";
			break;
		case "2":
			return "zeitgesteuert";
			break;
	}
}


function showstatus($status) {
############################################
	switch ($status) {
		case "0":
			echo "offline";
			break;
		case "1":
			echo "online";
			break;
		case "2":
			echo "zeitgesteuert";
			break;
	}
}



function showchilds($content,$new) {
#############################################

	include("../../lib/cfg.php");
	global $access;

	$sql = "select * from $cfgtablecontents where parent = '$content[id]' and del = '0' and type = 'page' order by rank"; //echo $sql;
	$num = mysql_num_rows(mysql_query($sql));

	// finde Unterobjekte
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query,MYSQL_ASSOC)) {
		
		$grf = (!$new or !$access['c1']) && $num == 1 ? "../../gfx/tree_end.gif" : "../../gfx/tree_body.gif";

		if($access['c6']) $rankbuttons = "<a href=\"body.php?rank[id]=$result[id]&rank[dir]=up&rank[rank]=$result[rank]\" onMouseOver=\"MM_swapImage('up$result[id]','','../../components/contents/gfx/move_up_o.gif',1)\" onMouseOut=\"MM_swapImgRestore()\"><img src=\"../../components/contents/gfx/move_up.gif\" alt=\"Objekt 1 nach oben verschieben\" border=\"0\" name=\"up$result[id]\"></a><a href=\"body.php?rank[id]=$result[id]&rank[dir]=down&rank[rank]=$result[rank]\" onMouseOver=\"MM_swapImage('down$result[id]','','../../components/contents/gfx/move_down_o.gif',1)\" onMouseOut=\"MM_swapImgRestore()\"><img src=\"../../components/contents/gfx/move_down.gif\" alt=\"Seite mit darunterliegender tauschen\" border=\"0\"  name=\"down$result[id]\"></a>"; 
		$status = $result['status'] ? "online" : "offline";
		
		$cache = db_entry("select refresh from ".db_table("contents_cache")." where page = '$result[id]' LIMIT 1");
		$refresh = $cache['refresh'] == "6" ? "&nbsp;<a href=\"?refresh=$result[id]\" alt=\"Änderungen veröffentlichen\"><img src=\"gfx/zahnradsm.gif\" border=\"0\"></a>" : "";
		
		$cell .= "
		<tr id=\"row_$result[id]\">
			<td width=\"5\">
				<img src=\"$grf\"><br />
			</td>
			<td width=\"25\">
				<a href=\"body.php?&select[id]=$result[id]\"><img src=\"gfx/".$result['type']."_tn.gif\" border=\"0\"></a>
			</td>
			<td width=\"250\">
				<a href=\"body.php?&select[id]=$result[id]\">$result[title]</a>
			</td>
			<td width=\"150\">
				<a href=\"body.php?&select[id]=$result[id]\">$status</a> $refresh
			</td>
			<td width=\"50\">
				<img src=\"".LIQUIDO."/gfx/updown.png\" class=\"sort\" /> 
			</td>
		</tr>
		";
				
		$num--;
	}

	// zeiche tabellenbuffer dar und lösche ihn
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"childlist-list\">
			$cell
	</table>";
	
	// wenn neuanlegen von Seiten erlaubt ist
	if($new and $access['c1']) { 
		echo "
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		<tr>
			<td width=\"5\">
				<img src=\"../../gfx/tree_end.gif\">
			</td>		
			<td valign=\"top\" width=\"25\">
				<div onclick=\"$('box_newPage').style.display='block';\" style=\"cursor:pointer\" ><img src=\"gfx/page_new_tn.gif\" border=\"0\"></div>
			</td>
			<td colspan=\"2\">
				<div onclick=\"$('box_newPage').style.display='block';\" style=\"cursor:pointer\" >neue Seite</div>
			</td>
		</tr>
		</table>
		";
	}
}


function getParents($parent) {
	//include("../../lib/cfg.php");

	$list = array();
	$i=0;
	global $cfgtablecontents;
	
	while ($parent) {
		$sql = "SELECT id,title,parent,template,type,width FROM $cfgtablecontents WHERE id = '$parent' and del != '1' LIMIT 1";
		$result = mysql_fetch_array(mysql_query($sql));
		if($result) {
			$list['obj'][$result[0]] = $result;
			$idlist = $idlist.",".$result[0];
			$parent = $result['parent'];
			
			// Seitenbreite vererben
			if($result['width'] and !$list['width']) $list['width'] = $result['width'];
			
			$i++;
		} else {
			$parent = 0;
		}
	}
	
	$list["list"] = $idlist;
	$list["num"] = $i;
	
	return $list;
}


/**
Function zum anzeigen der ParentObjekte eines Objektes
2.7.03 flobo
*/
function showParents($obj) {

	$parents = getParents($obj['parent']);
	
	if($parents['obj']) {
		$parents['obj'] = array_reverse($parents['obj']);
		
		$part = "start";
		include("detail/templates/head.php");
		
		$part = "space";
		while(list($key,$val) = each($parents['obj'])) {
			$obj = $parents['obj'][$key];
			
			//include("detail/templates/head.php");
			
			$part = $obj['type'];
			include("detail/templates/head.php");
		}
	}
	
	$part = "end";
	
	include("detail/templates/head.php");
}


function contents_tree ($obj=0,$current=0,$inst=-1) {

	$inst++;
	global $cfgtablecontents;
	
	// hole Liste von ParentObjecten
	$parentlist = getParents($obj);

	// listet alle contents auf, beim ersten aufruf die hauptthemen
	$sql = "select id,title,type from $cfgtablecontents where parent = '$current' and type = 'page' and del = '0' order by rank";
	$query = mysql_query($sql);

	while ($result = mysql_fetch_array($query)) {
		if($result['type'] == "group") {
			$add1 = "<b>";
			$add2 = "</b>";
		} else {
			$add1 = "";
			$add2 = "";
		}

		$titel = ($x = strlen($result[1])) > (18-$inst) ? substr($result[1],0,(17-$inst))."..." : $result[1];
		echo "<img src=\"../../gfx/spacer.gif\" width=\"".($inst*5)."\" height=\"5\" border=\"0\">$add1<a href=\"?select[id]=$result[0]\" target=\"left\">".($titel)."</a>$add2<br />
		";

		// refereziere werte
		$idlist = $parentlist["list"];
		$thisid = $result[0];
		
		// wenn es childobjekte gibt liste die auf
		if($result[0] == $obj or ereg(",".$thisid,$idlist)) {
			contents_tree($obj,$result[0],$inst);
		}
	}
}

function listpictures($id,$type=0,$path=0) {
	global $access;
	global $db;
	global $cfgtablecontentimgs;
	global $cfgtablecontentobjects;
	
	$delbutton='';
	$imagesize = array(0,0);
	$html = '';
		
	$sql = "select a.id,a.libid,a.cid,a.info,a.link ,b.smalltext1 from $cfgtablecontentimgs as a, $cfgtablecontentobjects as b where a.cid = '$id' and b.id = a.cid";
	$images = $db->getArray($sql);
	$delbutton = '';	
	
	// List all pictures of this object
	foreach($images as $img) {

		$file = IMAGES."/".$id."/".$img['libid']."/thumbnail.jpg";
		if($access['c14'] && $type === 'compose') $delbutton = "<div class=\"delbutton\" onclick=\"delpic('$img[id]');\" title=\"dieses Bild löschen\" id=\"delpic$img[id]\"></div>";	
		
		if($type === "compose") {
			$html .= "<div id=\"compose_imgbox_$img[id]\" class=\"compose_imgbox\">";
		}
		
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$file)) {
			$imagesizex = @GetImageSize($_SERVER['DOCUMENT_ROOT'].$file);

			// if this image is bigger than possible previous images of this list
			if($imagesizex[0] > $imagesize[0]) $imagesize = $imagesizex;

			
			
			$html_img = "<img src=\"".$file."?t=".time()."\" border=\"0\" alt=\"$img[alt]\" class=\"contentimg\" id=\"img$img[id]\" />";
				
			if($img['foo']) {
				if($img['link'] === "-") {
					$html .=  "<a href=\"$img[link]\">$html_img</a>$delbutton\n";
					
				} elseif ($img['link'] === "popup") {
					$html .=  "<a href=\"#\" onClick=\"window.open('pic_popup.php?pic=$pic','imagepopup','width=$imagesize[0],height=$imagesize[1]'); return false \">$html_img</a>$delbutton\n";
				
				} else {
					$html .=  "<a href=\"$img[link]\" target=\"$img[smalltext1]\">$html_img</a>$delbutton\n";
				}
			} else {
				$html .=  "$html_img $delbutton\n";
			}
			
			
			
		} else {
			if(100 > $imagesize[0]) $imagesize = array(128,128);
			$html .=  "<img src=\"".LIQUIDO."/gfx/Unknown.png\" class=\"contentimg\" />$delbutton<br />";
		}
		
		if($type === "compose") { $html .= "</div>"; }
	}
	
	$return = array($html, $imagesize, $images);
	return $return;
	
}



?>