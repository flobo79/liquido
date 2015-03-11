<?php
    
class Page extends Sprite {
	var $id;
	var $template;
	var $pagedata = array();
	var $cache;
	var $pagenotfound = false;
	
	function Page() {
		$this->Sprite();
		global $_GET;
		global $_POST;
		global $L;
		
		$pageId = false;
		// determine current page
		if($_GET['page']) {
			$pageId = $_GET['page'];
		}
		elseif (isset($_POST['page'])) {
			$pageId = $_POST['page'];
		}
		
		// clean URL addon
		
		// no page link was given, use start page
		if(!$pageId) {
			$this->id = $this->get_startpage();
		
		// page ID was given
		} elseif (intval($pageId)) {
			$page = $this->db->getRow("select * from ".db_table('contents')." where id = $pageId");
			if(isset($page['id'])) {
				$this->id = $page['id'];
			} else {
				$this->pagenotfound = true;
			}
		
		// systemCleanURL was given
		} else {
			$sql = "select 
				 `id` 
				from 
				 `".db_table('contents')."` 
				where 
				`cleanURL` = '".mysql_real_escape_string($pageId)."' 
				and  
				 `del` = '' order by id desc";
				 
			$list = $this->db->getArray($sql);
				
			if(count($list)) {
				$this->id = $list[0]['id'];
			} else {
				$this->pagenotfound = true;
			}
		}
		
		if($this->pagenotfound) {
			$this->id = 1315;
		}
		
		$_SESSION['public']['page'] = $this->id;
		
		$this->node = new Node($id);
		$this->data = $this->get_pagedata($this->id);
		$this->template = $this->get_template($this->data['template']);
	}
	
	function display($template=0) {
		// replace <content> tag in template with node reference
		$this->template['code'] = str_replace('<content>', '<node:'.$this->id.'>', $this->template['code']);		
		
		// füge template und inhalte zusammen   /parser.php
		//$html = mergeCode($this->template['code'],$this->content);
		
		$parser = new Parser($this->template['code'], $this->data);
		
		$html = $parser->parse();

		// add liquido-hint to html
		$searches = array("formx","<html>","<head>");
		$replaces = array(
			"form",
			"<html>\n".$fe->cfg['env']['html_hint'],
			"<head>
		<script type=\"text/javascript\" src=\"liquido/js/mootools.js\"></script>
		<script type=\"text/javascript\" src=\"liquido/js/utils.js\"></script>
		<script type=\"text/javascript\" src=\"liquido/js/swfobject.js\"></script>
		<script type=\"text/javascript\" src=\"liquido/js/liquido.js\"></script>
		<script type=\"text/javascript\" src=\"liquido/modules/swiff/swiffer.js\"></script>
		<!--[if lt IE 7]>
		        <script type=\"text/javascript\" src=\"liquido/js/unitpngfix.js\"></script>
		<![endif]--> 
		"
		);


    /* sorry... wird noch anders realisiert... */
    if ($this->id == 1423) {
  		$replaces = array(
  			"form",
  			"<html>\n".$fe->cfg['env']['html_hint'],
  			"<head>
        <script type=\"text/javascript\" src=\"/mikos/libs/jquery/jquery.min.js\"></script>
        <script type=\"text/javascript\" src=\"/mikos/libs/tablesort/jquery-latest.js\"></script> 
        <script type=\"text/javascript\" src=\"/mikos/libs/tablesort/tablesorter.js\"></script>
        <script type=\"text/javascript\" src=\"/mikos/libs/tablesort/tablesorter_filter.js\"></script>
        <script type=\"text/javascript\" src=\"/mikos/libs/tablesort/jquery.metadata.js\"></script>
        <script type=\"text/javascript\" src=\"/mikos/libs/tablesort/addons/pager/jquery.tablesorter.pager.js\"></script>
        <script type=\"text/javascript\">jQ = jQuery.noConflict();</script>
  			
  		  <script type=\"text/javascript\" src=\"liquido/js/mootools.js\"></script>
  		  <script type=\"text/javascript\" src=\"liquido/js/utils.js\"></script>
  		  <script type=\"text/javascript\" src=\"liquido/js/swfobject.js\"></script>
  		  <script type=\"text/javascript\" src=\"liquido/js/liquido.js\"></script>
  		  <script type=\"text/javascript\" src=\"liquido/modules/swiff/swiffer.js\"></script>
  		  <!--[if lt IE 7]>
    		        <script type=\"text/javascript\" src=\"liquido/js/unitpngfix.js\"></script>
    		<![endif]--> 
    		");    
      }


		$html = str_replace($searches, $replaces, $html);
		
		// statify Pagecache
		db_query("update `".db_table("contents_cache")."`  set `html` = '".mysql_escape_string($html)."' where page = ".$this->id." LIMIT 1");
		
		echo $html;
	}
	
	
	
	function get_page_cache($page) {
		// lese cache aus datenbank
		$cache = db_entry("select * from `".db_table("contents_cache")."` where page = '$page' LIMIT 1");
		if(!$cache['page']) db_query("insert into `".db_table("contents_cache")."` (`page`) values ('$page')");
		
		return $cache;
	}
	
	
	function get_pagedata($id,$included=0) {
		// PageInformationen
		$pagedata = db_entry("select * from `".db_table("contents")."` where `id` = ".intval($id)." and del != 1 LIMIT 1");
		
		// parents
		if(!$included) $pagedata = $this->get_parents($pagedata);
		
		return $pagedata;
	}
	
	function get_template($id) {
		if($id) {
			return db_entry("select * from ".db_table("templates")." where id = $id LIMIT 1");
		}
	}
	
	
	function get_parents($pagedata) {
		$t_contents = db_table("contents");
		$list = array();
		$i=0;
		$parent = $pagedata['parent'];
	
		while ($parent) {
			
			$sql = "SELECT id,title,parent,template,type,width FROM `$t_contents` WHERE `id` = ".intval($parent)." and `del` != 1 LIMIT 1";
			$result = db_entry($sql);
			
			if($result[0]) {
				$list['obj'][$result[0]] = $result;
				$idlist = $idlist.",".$result[0];
				
				$parent = $result['parent'];
				if($result['template'] and !$pagedata['template']) $pagedata['template'] = $result['template'];
				if($result['width'] and !$list['contentwidth']) $list['contentwidth'] = $result['width'];
				$i++;
				
			} else {
				$parent = 0;
			}
		}
		
		
		if($list['obj']) $list['obj'] = array_reverse($list['obj']);
		$list['list'] = $idlist;
		$list['num'] = $i;
		
		$pagedata['parents'] = $list;
		
		return $pagedata;
	}
	
	function get_startpage() {
		return get_setting("content","startpage");
	}
		
	function listobjects($obj,$fmode=0,$limit=0) {
	###############################################
	
		include(dirname(__FILE__)."/cfg.php");
		global $sid;
		global $css;
		global $db;
		global $fe;
		global $access;
			
		// feem vars
		global $fmode;
		global $depth;
		global $editpage;
		
		// defining some variables
		$ids = "";
		$komma = "";
		$contentwidth = $obj['contentwidth'];
		$sessionid = session_id();
		
		$limit = $limit > 0 ? "limit $limit" : "";
		
		if(!$obj['parents']) $obj = get_pagedata($obj['id']);
		
		$id = $obj['id'];
		if(!$obj['contentwitdh']) $obj['contentwitdh'] = $obj['parents']['contentwidth'];
		
		$fncpart = "build";			// für den functionsaufru
		$part  = "public";			// für die darstellung des contents
	
		ob_start();
	
		if(checkAdmin() and $access['c17']) {
			$pagedetails = db_entry("select id,title from ".db_table("contents")." where id = '$id' LIMIT 1");
			
			if($fmode == "compose" and $id == $editpage) {
				// lade css-stile
				$styles = $css -> readCss($_SERVER['DOCUMENT_ROOT']."/liquido/css/objects.css");
				if($styles) {
					reset($styles);
					$css_styles = "<select name=\"objectdata[objid][contents_css]\" class=\"css_box\">\n";
					$css_styles .= "	<option value=\"\"></option>\n";
					foreach($styles as $key => $style) {
						// ohne id-styles
						if(preg_match("/^\./",$style['title'])) {
							$title = substr($style['title'],1);
							$css_styles .= "	<option value=\"".$style['title']."\">".$title."</option>\n";
						}					
					}
					$css_styles .= "</select>";
				} else {
					echo "Stile nicht geladen";
				}
				
				$part = "compose";
				include("$cfgcmspath/feem/temp1.php");
				$access = loadAccessTable("contents");
			
			} else {
				$part = "public";
				for($i=0;$i<=$depth;$i++) $margin = "&nbsp;&nbsp;";
				echo $margin.".<a href=\"?page=$page&editpage=$id\">edit \"$pagedetails[title]\"</a><br>";
			}
			// set pageinclude-depth
			$depth++;
		}
		
		mysql_query("SET NAMES 'utf8'");
		$svSQL = "	select 	* 
					from 	$cfgtablecontentobjects
					where 	parent = '$id' and del = '0' 
					order 	by rank $limit"; 
		$objects = db_array($svSQL);
		
		foreach($objects as $objectid => $result) {			// die schleife kann von einem modul mit endfunction=true beendet werden
			$objpath = OBJECTSDIR.$result['type'].'/'.$result['layout'];
			
			// schneide punkt von css-class ab
			$result['contents_css'] = substr($result['contents_css'],1);
	
	
			@include_once($objpath.'/functions.php');
			include ($objpath.'/file.php');
			
			/*  veraltet
			$ids .= $komma.$result['id'];
			$komma = ",";
			*/
			
			unset($thisobject,$result);		// lösche objektinformationen
	
			if($break) break;		// wenn ein object $break setzt wird hier abgebrochen
		}
		
		/* kommt noch
		if($fmode == "compose" and $id == $editpage) {
			echo "<input type=\"hidden\" value=\"$ids\" name=\"objectdata[objects]\"></form>";
		}
		*/
		
		$html = ob_get_contents();
	
		ob_end_clean();
		return $html;
	}
	
		
	function getBreadcrumb($obj) {
		$parents = $obj['parents']['obj'];
		$trace = "";
			
		if($parents) {
			for ($i=1;$parents[$i];$i++) {
				$trace .= "<a href=\"page.php?page=".$parents[$i]['id']."\">".$parents[$i]['title']."</a> ";
				$mark = " > ";
			}
		}
		$trace .= $obj['title'] ? "> ".$obj['title'] : "";
		return $trace;
	}
}
?>
