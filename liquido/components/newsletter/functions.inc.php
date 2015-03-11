<?php
global $_GET;
global $_POST;
foreach($_GET as $k => $v) { $$k = $v; }
foreach($_POST as $k => $v) { $$k = $v; }


// cfg ergänzungen
$cfgtables['nlpublishs'] = $prefix."_liquido_nl_publishs";
define("NLTOOLS",HOST.$cfg['components']['newsletter']['tools']);


//for an old liquido frmaework
$cfg['tables']['contentobjects'] = db_table('contentobjects');
$cfg['tables']['contents'] = db_table('contents');
$cfg['tables']['nllinktracking'] = db_table("nl_linktracking");
$cfg['tables']['nlpublishs'] = db_table('nl_publishs');
$cfg['tables']['nlareas'] = db_table("nl_areas");
$cfg['tables']['nlabos']  = db_table("nl_abos");
$cfg['tables']['nlabogroups']  = db_table("nl_abogroups");
$cfg['tables']['templates'] = db_table("templates");

$db->con = $db;

// load areas and make it a globally accessible variable
$areas = $db->getArray("select * from ".db_table("nl_areas")." order by title");


if($select = $_GET['select']) {
	if($_SESSION['components']['newsletter']['current'] != "compose" and $_SESSION['components']['newsletter']['current'] != "preview") {
		$_SESSION['components']['newsletter']['current'] = "detail";
		$update_rightpane = true;
	}
	
	$_SESSION['components']['newsletter']['objtype'] = "redaction";
	$_SESSION['components']['newsletter']['id'] = $select['id'];
}

if($selectarea = $_GET['selectarea']) {
	$mode = $_SESSION['components']['newsletter']['current'];
	if($mode != "compose" and $mode != "preview" and $mode != "detail") {
		$_SESSION['components']['newsletter']['mode'] = "detail";
	}
	
	$_SESSION['components']['newsletter']['objtype'] = "area";
	$_SESSION['components']['newsletter']['area'] = $selectarea;
	//$thiscomp = $_SESSION['components'][$comp];
}

if ($mode = $_GET['setmode']) {
	$_SESSION['components']['newsletter']['current'] = $mode;
}




if($_GET['loadtemplate']) {
	$_SESSION['components']['newsletter']['loadtemplate'] = $_SESSION['components']['newsletter']['loadtemplate'] == "1" ? "0" : "1";
}

if(!$_SESSION['components']['newsletter']['loadtemplate']) $_SESSION['components']['newsletter']['loadtemplate'] == "1";

$thiscomp = $_SESSION['components']['newsletter'];
$mode = $_SESSION['components']['newsletter']['current'];

if(!isset($ispublishing)) $access = loadAccessTable($_SESSION['user'], "newsletter");

function movetotrash($content) {
	global $user;
	global $cfg;
	global $db;
	
	$table = db_table($content['type']);
	$sql = "update $table set del = '".intval($user['id'])."' where id = '".intval($content['id'])."' LIMIT 1";
	$db->execute($sql);
}

function checkEmailSyntax($email) { {
    $atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
    $domain = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    return eregi("^$atom+(\\.$atom+)*@($domain?\\.)+$domain\$", $email);
}

	
	
}

function countTrashItems () {
	global $path;
	global $cfg;
	global $user;	
	global $db;
	
	$countobjects = $db->getRow("select COUNT(id) as num from ".$cfg['tables']['contentobjects']." where del = '$user[id]'");
	$countcontents = $db->getRow("select COUNT(id) as num from ".$cfg['tables']['contents']." where del = '$user[id]'");

	return $countobjects['num']+$countcontents['num'];	
}


function listpictures($id,$type,$path=0) {
	global $cfg;
	global $path;
	global $db;
	global $access;
	
	$sql = "select a.id,a.libid,a.cid,a.info,a.link from ".$cfg['tables']['contentimgs']." as a, ".$cfg['tables']['contentobjects']." as b where a.cid = '$id' and b.id = a.cid";
	$list = $db->getArray($sql);
	
	foreach($list as $result) {
		$imagesizex = @getimagesize($_SERVER['DOCUMENT_ROOT'].IMAGES."/".$result['id']."/thumbnail.jpg");
		if($imagesizex[0] > $imagesize[0]) $imagesize = $imagesizex;
		
		if($type == "size") {
			// simply do nothing
		} else {
			$pic = $cfg['env']['host'].IMAGES."/".$result['id']."/thumbnail.jpg";
			$subtitle = $result['info'] ? "\n".nl2br($result['info']) : "";
			
			if($type == "compose") {
				echo "\n<a href=\"#\" onclick=\"javascript:window.open('compose/image.php?id=$result[id]&libid=$result[libid]','liquido','width=500,height=400'); return false\"><img src=\"$pic\" title=\"Bild bearbeiten\" /></a>\n".$subtitle;
				if($access['c10']) echo "\n<br><a href=\"#\" onclick=\"ConfirmAction('Dieses Bild löschen?','document.location.href=\'?delpic[picid]=$result[id]\'');\" ><img src=\"".LIQUIDO."/gfx/pibu_x.gif\" title=\"Bild l&ouml;schen\" name=\"delpic$id\"></a>";
						
			} else {
				if($result['link']) {
					echo "<a href=\"$result[link]\"><img src=\"$pic\" border=\"0\" /></a>\n".$subtitle;
				} else {
					echo "<img src=\"$pic\" border=\"0\" />\n".$subtitle;
				}
			}
		}
	}
	return $imagesize;
}


function load_contentobjectfunctions($content,$fncdata) {

	global $path;
	global $cfg;
	$cfgcmspath = "../../";
	
	$svSQL = "select * 
				from ".$cfg['tables']['contentobjects']."
				where `parent` = '$content[id]' and `del` != '1'
				order by `rank`";
	
	// kennzeichne administrationsbereich
	$admin = 1;
	
	// lade die "load"-trigger
	$fncpart = "load";
	
	$testquery = mysql_query($svSQL);
	$query = mysql_query($svSQL);
	if (mysql_fetch_array($testquery)) {
		while ($result = mysql_fetch_array($query) and !$endfunction) {	
			$objectid = $result['id'];
			include($_SERVER['DOCUMENT_ROOT'].LIQUIDO."/objects/$result[type]/$result[layout]/functions.php");
		}
	}
	
	return $fncdata;
}




function getdata($id) {
	global $path;
	global $cfg;
	global $db;
	global $L;

	if(intval($id)) {
		$sql = "select * from ".db_table("contents")." where  `id` = '".($id)."' limit 1";
		$content = $db->getRow($sql);
	
		// erstellungsdatum
		$content['date'] = strftime($L->getDay($content['date'])." %H:%M",$content['date']);
		
		// aenderungsdatum
		if($changes['date']) { $content['changedate'] = strftime(getDay($changes['date'])." %H:%M",$changes['date']); } else { $content['changedate'] = "keine Änderungen"; }
		
		
		if($content['status'] >= 3)  {
			$sql = "select * from `".$cfg['tables']['nlpublishs']."` where pb_issue  = '$id'";
			$content['publishs']  = $db->getArray($sql);
			
			foreach($content['publishs'] as $key => $publish) {
				$content['publishs'][$key]['bounces'] = $db->getRow("select count(id) as number from `".db_table('nl_bounce_emails')."` where newsletterID = '$publish[pb_id]'");
				$content['publishs'][$key]['clickedlinks'] = $db->getArray("select count(lt_id) as lt_clicks, lt_link from `".db_table('nl_linktracking')."` where pb_id = '$publish[pb_id]' group by lt_link ");
			}
		}
		
		return $content;
	}
}



function getareadata($area) {
	if(intval($area)) {
		global $path;
		global $db;
		global $cfg;
		global $user;
		global $thiscomp;

		// ermittle ob es schon diese area zu der ausgabe gibt
		// wenn nicht, f�ge area, zu diesem newsletter in die nlcontents ein
		$sql = "SELECT `id` FROM `".$cfg['tables']['contents']."` WHERE `parent` = '$thiscomp[id]' AND `info` = 'area_$area' LIMIT 1";
		$content = $db->getRow($sql);
	
		if(!$content['id']) {
			$insert['date'] = time();
			$insert['author'] = $user['id'];
			$insert['parent'] = $thiscomp['id'];
			$insert['info'] = "area_".$area;
			$insert['type'] = "area";
			$insert['table'] = "contents";
			
			$id = insert($insert);
			
			$content = $insert;
			$content['id'] = $id;
		}
		
		// ermittle area-infos
		$content['nlcid'] = $content['id'];
		
		$sql = "select * from ".$cfg['tables']['nlareas']." where id = '$area' limit 1";
		$content['area'] = $db->getRow($sql);
		$content['area']['checked'] = $thiscomp['check'][$content['area']['id']];
		$content['date'] = strftime(getDay($content['date'])." %H:%M",$content['date']);
		
		return $content;
	}
}


function getAreas () {
###############################################
	global $path;
	global $cfg;
	global $thiscomp;

	$sql = "select * from ".$cfg['tables']['nlareas']." order by rank";
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$areadata = getareadata($result['id']);
		$return[$areadata['nlcid']] = $areadata;
	}
	return $return;
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



function showareas($content,$new) {
#############################################
	global $path;
	global $cfg;
	global $access;

	if($new == "1") { $insert_new = "
		<tr>
			<td width=\"5\">
				<img src=\"../../gfx/tree_end.gif\">
			</td>		
			<td colspan=\"2\">
				<a href=\"?setmode=areas\">Bereiche bearbeiten</a>
			</td>
		</tr>
		"; 
		$endtree = "1";
	}


	
	// finde Unterobjekte
	for($i=0;$content['areas'][$i];$i++) {
		$result = $content['areas'][$i];

		if(!$endtree) { $grf = "../../gfx/tree_end.gif"; } else { $grf = "../../gfx/tree_body.gif"; }
		
	
		$cell .= "
		<tr>
			<td width=\"5\">
				<img src=\"$grf\"></br>
			</td>
			<td width=\"25\">
				<a href=\"body.php?&selectarea=$result[id]\"><img src=\"gfx/area_tn.gif\" border=\"0\"></a>
			</td>
			<td width=\"400\">
				<a href=\"body.php?&selectarea=$result[id]\">$result[area][title]</a>
			</td>
			<td width=\"50\">
				$rankbuttons
			</td>
		</tr>
		";
				
		$endtree = "1";
	}
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			$cell
			$insert_new
	</table>";
}


function getParents($parent) {

	global $path;
	global $cfg;
	$list = array();
	$i=0;
	
	while ($parent) {
		$sql = "SELECT id,title,parent,template,type,width FROM `".$cfg['tables']['nlcontents']."` WHERE id = '$parent' and del != '1' LIMIT 1";
		$result = mysql_fetch_array(mysql_query($sql));
		if($result) {
			$list['obj'][$result[0]] = $result;
			$idlist = $idlist.",".$result[0];
			$parent = $result['parent'];
			
			// speichere n�chst-h�here Gruppeninformation
			if($result['type'] == "group" and !$list['group']) $list['group'] = $result;
			
			$i++;
		} else {
			$parent = 0;
		}
	}
	
	$list["list"] = $idlist;
	$list["num"] = $i;
	
	return $list;
}


function getTemplate($id) {

	global $path;
	global $cfg;

	$sq = "SELECT `code` FROM `".$cfg['tables']['templates']."` WHERE `id` = '$id' LIMIT 1";
	$q = mysql_query($sq);
	$gettemplate = mysql_fetch_row($q);

	// splitte template in anfang und ende anhand von "<content>"
	$template = split("<content>",$gettemplate[0]);

	return $template;
}

function contents_tree ($obj=0,$current=0) {
	
	global $path;
	global $cfg;
	
	// wenn es keine parent-objekte gibt sortiere nach title sonst nach rank
	$order = $current ? "rank" : "title";
	
	// listet alle contents auf, beim ersten aufruf die hauptthemen
	$sql = "select * from `".$cfg['tables']['nlcontents']."` where type = 'redaction' and del = '0' order by `date`";
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query)) {
		$titel = ($x = strlen($result['title'])) > (18-$inst) ? substr($result['title'],0,(17-$inst))."..." : $result['title'];
		echo "<img src=\"../../gfx/spacer.gif\" width=\"5\" height=\"5\" border=\"0\"><a href=\"left_pane.php?select[id]=$result[0]\" target=\"left\" onClick=\"parent.middle.location.href='body.php?&select[id]=$result[0]'\"><b>$titel</b></a><br>
		";
	}
}

function getIssues ($obj=0,$current=0) {
	
	global $path;
	global $cfg;
	global $db;
	// wenn es keine parent-objekte gibt sortiere nach title sonst nach rank
	$order = $current ? "rank" : "title";
	
	// listet alle contents auf, beim ersten aufruf die hauptthemen
	$sql = "select * from `".db_table('contents')."` where type = 'nl_issue' and `del` = '0' order by `title`";
	$issues = $db->getArray($sql);

	foreach($issues as $key => $issue) {
		$issues[$key]['publishs'] = $db->getArray("select * from ".db_table('nl_publishs')." where pb_issue = '$issue[id]'");
		$foo = count($issues[$key]['publishs']);
		if($foo) $issues[$key]['publishs'][$foo-1]['bounces'] = $db->getRow("select count(id) as number from ".$cfg['tables']['nl_bounce_emails']." where newsletterID = '$issue[id]'");
	}
	
	return $issues;
}


function list_nl_objects ($nlobj,$part = 0) {
###################################################
	/* shortcut */
	global $cfg;
	$content = listobjects($nlobj,$part,"",$nlobj['width']);
	return $content;
}

/*
function textobject($thisobject)
## darstellen eines Textblocks ############
{
	while (list($key,$value) = each($thisobject)) {
		$$key = $value;
	}

	$field = $thisobject['field'] ? $thisobject['field'] : "text";

	switch ($part) {
		case "compose":
			// ermittle die anzahl der form-zeilen
			$rows = ($rowsx = ceil((strlen($result[$field]) / ($textwidth / 5.5)))) < $formrows ? $formrows : $rowsx;
			
			// f�ge linebreaks als zeilen hinzu
			$rows += substr_count($result[$field],"\n");
		
			// wenn ein wrap-typ eingegeben wurde
			$wrap = $wrap ? " wrap=\"$wrap\"" : "";
			
			echo "<textarea name=\"objectdata[$result[id]][$field]\" rows=\"$rows\" class=\"$css_class\" style=\"width:".$textwidth."px\" $wrap id=\"textbox_$result[id]\">$result[$field]</textarea>";
		break;
		case "public":
			$text = ereg_replace("  ","&nbsp; ",$result['text']);
			
			if($nl2br != "no") {
				echo nl2br($result[$field])."</br>";
			} else {
				echo $result[$field]."</br>";
			}
		break;
	}
}
*/


function getGroups() {
	global $cfg;
	global $db;
	
	return $db->getArray("select * from ".$cfg['tables']['nlabogroups']." order by `title`");
}

function editGroups($groups) {
	global $cfg;
	global $db;

	foreach($groups as $id => $group) {
		$db->execute("update ".$cfg['tables']['nlabogroups']." set title = '".mysql_escape_string($group['title'])."' where id = '$id' LIMIT 1");
	}
	return $result;
}

?>