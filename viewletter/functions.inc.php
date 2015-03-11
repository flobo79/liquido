<?php
$path = "liquido/";

function getdata($nlobj) {
################################
	global $path;
	include("../liquido/lib/cfg.php");
	

	$sql = "select * from $cfgtablenlcontents where  id = '$nlobj' limit 1";
	$content = mysql_fetch_array(mysql_query($sql),MYSQL_ASSOC);

	return $content;
}



function listpictures($id,$type,$path=0) {
############################################
	
	global $path;
	include("../liquido/lib/cfg.php");
	$cfgcmspicdir = "nlbilder/"; 
	global $access;
	
	$sql = "select a.id,a.libid,a.cid,a.info,b.link,b.smalltext1 from $cfgtablenlcontentimgs as a, $cfgtablenlcontentobjects as b where a.cid = '$id' and b.id = a.cid";
	//cho $sql;
	$q = mysql_query($sql);
	while($result = mysql_fetch_array($q)) {
		$pic = $cfg['env']['host']."/liquido/".$cfgcmspicdir.$id."/".$result['libid']."/thumbnail.jpg";
		
		$imagesizex = GetImageSize($cfg['env']['host']."/liquido/".$cfgcmspicdir.$id."/".$result['libid']."/thumbnail.jpg");
		if($imagesizex[0] > $imagesize[0]) $imagesize = $imagesizex;
		
		if($type == "size") {
			// placeholder
		} else {
			if($type == "compose") {
				if($access['c14']) $delbutton = "<a href=\"?delpic[picid]=$result[id]\" onMouseOver=\"MM_swapImage('delpic$id','','../../components/contents/gfx/delobject_o.gif',1)\" onMouseOut=\"MM_swapImgRestore()\"><img src=\"../../components/contents/gfx/delobject.gif\" alt=\"dieses Bild l&ouml;schen\" border=\"0\" name=\"delpic$id\"></a><br>";
						
				echo "<a href=\"compose/image.php?id=$id&libid=$result[libid]\"><img src=\"$pic\" border=\"0\" alt=\"Bild bearbeiten\"></a>
						$delbutton
						";
			} else {
				
				if($result['link']) {
					if($result['link'] == "show") {
						echo "<a href=\"$pic\"><img src=\"$pic\" border=\"0\"></a><br>\n";
					} elseif ($result['link'] == "popup") {
							echo "<a href=\"#\" onClick=\"window.open('pic_popup.php?pic=$pic','imagepopup','width=$imagesize[0],height=$imagesize[1]'); return false \"><img src=\"$pic\" border=\"0\"></a><br>\n";
					} else {
						echo "<a href=\"$result[link]\" target=\"$result[smalltext1]\"><img src=\"$pic\" border=\"0\"></a><br>\n";
					}
				} else {
					echo "<img src=\"$pic\" border=\"0\"><br>\n";
				}
			}
		}
	}
	return $imagesize;
}





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
			
			// füge linebreaks als zeilen hinzu
			$rows += substr_count($result[$field],"\n");
		
			// wenn ein wrap-typ eingegeben wurde
			$wrap = $wrap ? " wrap=\"$wrap\"" : "";
			
			echo "<textarea name=\"objectdata[$result[id]][$field]\" rows=\"$rows\" class=\"$css_class\" style=\"width:".$textwidth."px\" $wrap>$result[$field]</textarea>";
		break;
	case "public":

			if($nl2br != "no") {

				echo nl2br($result[$field])."</br>";
			} else {
				echo $result[$field]."</br>";
			}
		break;
	}
}

function getTemplate($id) {
#################################################
	global $path;
	include("../liquido/lib/cfg.php");

	$sq = "SELECT `code` FROM $cfgtabletemplates WHERE `id` = '$id' LIMIT 1";
	$q = mysql_query($sq);
	$gettemplate = mysql_fetch_row($q);

	// splitte template in anfang und ende anhand von "<content>"
	$template = split("<content>",$gettemplate[0]);

	return $template;

}

function getareadata($area) {
################################
	if($area) {
		global $path;
		include("../liquido/lib/cfg.php");
		global $user;
		global $thiscomp;
		
		// ermittle ob es schon diese area zu der ausgabe gibt
		// wenn nicht, füge area, zu diesem newsletter in die nlcontents ein
		$sql = "SELECT `id` FROM `$cfgtablenlcontents` WHERE `parent` = '$thiscomp[id]' AND `area` = '$area' LIMIT 1";
		$content = mysql_fetch_array(mysql_query($sql),MYSQL_ASSOC);
	
		if(!$content['id']) {
			$insert['date'] = time();
			$insert['author'] = $user['id'];
			$insert['parent'] = $thiscomp['id'];
			$insert['area'] = $area;
			$insert['type'] = "area";
			$insert['table'] = "nlcontents";
			
			$id = insert($insert);
			
			$content = $insert;
			$content['id'] = $id;
		}
		
		// ermittle area-infos
		$content['nlcid'] = $content['id'];
		
		$sql = "select * from $cfgtablenlareas where id = '$area' limit 1";
		$content['area'] = mysql_fetch_array(mysql_query($sql),MYSQL_ASSOC);
	
		// erstellungsdatum formatieren
		//$content['date'] = strftime(getDay($content['date'])." %H:%M",$content['date']);
		
		return $content;
	}
}


function getAreas () {
###############################################
	global $path;
	include("../liquido/lib/cfg.php");
	global $thiscomp;
	$sql = "select * from $cfgtablenlareas order by rank";
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$areadata = getareadata($result['id']);
		$return[$areadata['nlcid']] = $areadata;
	}
	return $return;
}


function trace($obj=0) {
###########################################
	include("../../lib/cfg.php");
	
	//$pagedata = getPagedata($obj);
	$pagedata['id'] = $obj;
	$pagedata['code'] = listobjects($pagedata,"public");

	// render html-code
	$html = parseCode($pagedata,$mode);
	
	echo $html;
}



function listobjects($nlobj) {
###############################################
	include("../liquido/lib/cfg.php");
	global $thiscomp;

	$areas = getareas($nlobj['id']);

	$contentwidth = $nlobj['width'];
	
	$cfgcmspath = "../liquido/";
	$incms = 1;
	$fncpart = "build";
	$part = "public";
	$useob = 1;

ob_start();

	$svSQL = "	select 	* 
				from 	$cfgtablenlcontentobjects
				where 	parent = '$nlobj[id]' and del = '0' 
				order 	by rank"; 

	$query = mysql_query($svSQL);

	
	
	while ($result = mysql_fetch_array($query,MYSQL_ASSOC) and !$endfunction) 	// die schleife kann von einem modul mit endfunction=true beendet werden
	{	
		$objectid = $result['id'];
		if(file_exists($fncfile = realpath("../liquido/objects/$result[type]/$result[layout]/functions.php"))) include_once($fncfile);
		include ("../liquido/objects/$result[type]/$result[layout]/file.php");
		$thisobject = "";
	}
	
	$code = ob_get_contents();
	
	ob_end_clean();

	return $code;
}



function getPagedata($content) {
################################
	include("../liquido/lib/cfg.php");

	// PageInformationen
	$sql = "select * from $cfgtablecontents where id='$content' limit 1"; //echo $sql;
	$content = mysql_fetch_array(mysql_query($sql));

	// setze pageview-zähler
	$sql_update = "update $cfgtablecontents set views = views+1 where id='$content[0]' limit 1"; //echo $sql_update;
	mysql_query($sql_update);
	
	// erstellungsdatum
	$content['createdate'] = strftime(getDay($content['date'])." %H:%M",$content['date']);
	
	// änderungsdatum
	$sql = "select * from $cfgtablecontentschanges where obj = '$content[0]' LIMIT 1";
	$changes = mysql_fetch_array(mysql_query($sql));
	if($changes['date']) { $content['changedate'] = strftime(getDay($changes['date'])." %H:%M",$changes['date']); } else { $content['changedate'] = "keine Änderungen"; }
	
	// parents
	$content['parents'] = getparents($content['parent']);
	
	return $content;
}



function showlink($title,$theme,$article,$addon,$class=0) {
##############################################
# 
	include("../liquido/lib/cfg_general.inc.php");
	echo "<a href=\"?$addon\">$title</a>";
}

?>