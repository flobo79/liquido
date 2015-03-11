<?php


	
	/*
	CSS-Modul
	basierend auf der class_css von Contor
	
	
	Variblen:
	$plugindata 			Sessionarray des Moduls
		[cssfile]			id der ausgewählten CSS-Datei	
		['currstyleid']		id des ausgewählten stiles
	
	$cssfile				CSS-Datei			
	
	
	
	
	*/
	
	if(!$plugindata) $plugindata = $_SESSION['contor']['plugin']['css'];
	
	include($path."lib/class_css.php");
	$css = new CSS;
	
	if($edit = $_POST['edit']) {
		foreach($edit as $entry) {
			db_getupdatesql ("cssfiles", $entry, "css_id", 1);
		}
	}
	
	// füge css-datei eintrag hinzu
	if($_POST['add']['css_file'] && $_POST['add']['css_desc']) {
		db_getinsertsql(db_table("cssfiles"),$_POST['add'],1);
	}
	
	// lösche css-eintrag aus css-file liste
	if($_GET['delcss']) db_query("delete from ".db_table("cssfiles")." where css_id = '".$_GET['delcss']."' LIMIT 1");
		
	/*
	lade css-files aus der css-file tabelle
	von verwendeten Modulen oder erweiterungen
	*/
	$dbcssfiles = db_array("select * from ".db_table("cssfiles")." order by css_id");
	$firstid = $dbcssfiles[0]['css_id'];
	foreach($dbcssfiles as $dbcssfile) { $cssfiles[$dbcssfile['css_id']] = array(str_replace("_contorpath_",$settings['contorpath'],$dbcssfile['css_file']),$dbcssfile['css_desc']); }

	// default-css file
	if($cssfile = $_POST['selectcssfile']) {
		if($cssfile == "editlist") { $editlist = true; }
			
		unset($_SESSION['contor']['plugin']['css']['currstyleid'],$plugindata,$_GET['selectstyle']);
		$plugindata['cssfile'] = $cssfile;
		$_SESSION['contor']['plugin']['css']['cssfile'] = $cssfile;
	}
	if($plugindata['cssfile'] == "editlist") $editlist = true;
	

	if(!$plugindata['cssfile']) {
		echo "hier";
		unset($_SESSION['contor']['plugin']['css']['currstyleid'],$plugindata);
		$plugindata['cssfile'] = $firstid;
		$_SESSION['contor']['plugin']['css']['cssfile'] = $plugindata['cssfile'];
	}
	
	$cssfile = $cssfiles[$plugindata['cssfile']][0];
		
	// lese css-file ein
	$styles = $css -> readCss($_SERVER['DOCUMENT_ROOT']."/".$cssfile);	
	
	// lösche style
	if($delstyle = $_POST['delstyle']) {
		$css -> removeStyle ($styles,$delstyle['id'],$_SERVER['DOCUMENT_ROOT']."/".$cssfile,$delstyle['replace']);
		$styles = $css -> readCss($_SERVER['DOCUMENT_ROOT']."/".$cssfile);	// lese css-file erneut
		unset($plugindata['currstileid'],$_SESSION['contor']['plugin']['css']['currstyleid']);
	}
	
	// füge style hinzu
	if($add = $_POST['addstyle']) {
		// ergänze ausgewählten stiltyp
		$add = $_POST['addstyle_type'].$add;
	
		// prüfe syntax bei objekt-stilen
		if($cssfile == $cssfiles["1"][0]) {
			if(!$add) $add = ".Stil".$id;
			if(preg_match("/^#/",$add)) $add = ".".substr($add,1);
			if(!preg_match("/^\./",$add)) $add = ".".$add;
		}
		
		$css -> addStyle($add,$_SERVER['DOCUMENT_ROOT']."/".$cssfile);
		$styles = $css -> readCss($_SERVER['DOCUMENT_ROOT']."/".$cssfile);	// lese css-file erneut
		
		// finde position und selectiere neuen stil
		foreach($styles as $id => $findstyle) {
			if($findstyle['title'] == $add) {
				$selectstyle = $id;
				break;
			}
		}

		unset($findstyle,$id);
		reset($styles);
	}
	
	// speichere änderungen
	if($set = $_POST['set']) {
	
		// prüfe ob stilname schon existiert
		foreach($styles as $id => $checkthis) {
			if($checkthis['title'] == $set['title'] && $id != $plugindata['currstyleid']) {
				$error = "Fehler: Bezeichnung existiert schon. Bitte wählen Sie eine andere Bezeichnung.";
			}
		}
		
		if(!$error) {
			// prüfe syntax bei objekt-stilen
			if($cssfile == $cssfiles["1"][0]) {
				if(!$set['title']) $set['title'] = ".Stil".$id;
				if(preg_match("/^#/",$set['title'])) $set['title'] = ".".substr($set['title'],1);
				if(!preg_match("/^\./",$set['title'])) $set['title'] = ".".$set['title'];
				
				// aktualisere alle verwendungen dieses stils
				if(($old_title = substr($styles[$plugindata['currstyleid']]['title'],1)) != ($to_title = substr($set['title'],1))) {
					db_query("update ".db_table("contents")." set contents_css = '$to_title' where contents_css = '$old_title'");
				}		
			}
			
			$css->updateCSS($set,$plugindata['currstyleid'],$styles,$_SERVER['DOCUMENT_ROOT']."/".$cssfile);
			$styles = $css->readCss($_SERVER['DOCUMENT_ROOT']."/".$cssfile);	// reload css-file
			
			// möglicherweise hat sich die id geändert
			if($set['title'] != $styles[$id]['title']) {
				foreach($styles as $id => $style) {
					if($style['title'] == $set['title']) {
						$selectstyle = $id;
					}
				}
			}
		}
	}	
	
	if($selectstyle or ($selectstyle = $_GET['selectstyle'])) {
		$_SESSION['contor']['plugin']['css']['currstyleid'] = $selectstyle;
		$plugindata['currstyleid'] = $selectstyle;
	}

	$currstyle = $styles[$plugindata['currstyleid']];
	
	// prüfe ob datei schreibbar ist
	$iswriteable = is_writeable($_SERVER['DOCUMENT_ROOT']."/".$cssfile);

	/*
	function checkUses($currstyle) {
		$sql =  "select distinct(title),count(b.id) as num from `".db_table("pageinfos")."` as a left outer join `".db_table("contents")."` as b on b.parent = a.id where contents_css = '".$currstyle['title']."' group by b.id";
		$uses = db_array($sql);
		return $uses;
	}
	*/

?>