<?php
    
/**
 * a node is a collection of content objects
 * 
 */
class Node extends Sprite {
	var $compose = false;
	var $contentwidth = 0;
	var $id = 0;
	var $objects = array(); // nodes list;
	var $cache = false;
	var $nocache = false;
	var $request = false;
	public $rel_absolute = false;	// defines wheter external links use full absolute path or relative path
	
	function Node($id = 0, $verbose = false) {
		$this->Sprite();
		$this->table = db_table('contents');
		$this->id = $id;
		
		global $ispublishing;
		if($ispublishing) $this->rel_absolute = true;
		
		
		$stat = new Statistic();
		$stat->setTable('content_stats')->writeStat($this->id);
		
		if($id) {
			$get = $this->r('select * from '.$this->table." where id = $id LIMIT 1");
			
			if($get['id']) {
				foreach($get as $k => $n) { $this->$k = $n; }
				unset($get, $k, $n);
				
				$this->get_parents();
				$this->cache = $this->r('select * from '.db_table('node_cache')." where page = '{$this->id}' LIMIT 1");
				if(!$this->cache['page']) {
					$this->r("insert into ".db_table('node_cache')." set `page` =  ".$this->id);
					$this->cache = $this->r('select * from '.db_table('node_cache')." where page = '{$this->id}' LIMIT 1");
				}
				
			} else {
				if(!$verbose) echo "error: node '$id' not found";
			}
		}
	}
	
	
	function data() {
		$vars = get_object_vars($this);
		unset($vars['table'], $vars['db']);
		return $vars;
	}
	
	
	function listpictures($id,$type) {
		global $access;
		global $db;
		global $cfgtablecontentimgs;
		global $cfgtablecontentobjects;
		
		$delbutton='';
		$imagesize = array(0,0);
		$html = '';
			
		$sql = "select a.id,a.libid,a.cid,a.info,a.link,b.smalltext1 from $cfgtablecontentimgs as a, $cfgtablecontentobjects as b where a.cid = '$id' and b.id = a.cid";
		$images = $db->getAll($sql);
		$add = ($this->compose || $this->nocache) ? '?'.time() : '';
		
		
		// List all pictures of this object
		foreach($images as $img) {
			$file = IMAGES."/".$id."/".$img['libid']."/thumbnail.jpg";
			
			
			$original = file_exists(($original = $IMAGES."/".$id."/".$img['libid']."/large.jpg")) ? $original : IMAGES."/".$id."/".$img['libid']."/original.jpg";
			
			if($type === 'compose') $delbutton = "<div class=\"delbutton\" onclick=\"delpic('$img[id]');\" title=\"dieses Bild löschen\" id=\"delpic$img[id]\"></div>";	
	
			if(file_exists(DOCUMENT_ROOT.$file)) {
				$imagesizex = @GetImageSize(DOCUMENT_ROOT.$file);
			} else {
				$file = LIQUIDO."/gfx/Unknownxx.png";
				$imagesizex = array(128,128);
				$img['alt'] = DOCUMENT_ROOT.$file;
			}
			
			// if this image is bigger than possible previous images of this list
			if($imagesizex[0] > $imagesize[0]) $imagesize = $imagesizex;

			if($type === "compose") {
				$html .= "<div id=\"compose_imgbox_$img[id]\" class=\"compose_imgbox\">";
				$img['link'] = '';
			}
			
			$host = $this->rel_absolute ? HOST : "";
			$html_img = "<img src=\"{$host}{$file}{$add}\" border=\"0\" alt=\"$img[alt]\" class=\"contentimg\" id=\"img$img[id]\" />";
				
			if($img['link']) {
				if($img['link'] == "-") {
					$html .=  $html_img."\n".$delbutton."\n";
					
				} elseif ($img['link'] == "popup") {

					$imagesize = @GetImageSize($_SERVER['DOCUMENT_ROOT'].$original);
					$html .=  "<a href=\"#\" onClick=\"window.open('/liquido/pic_popup.php?pic=$original','imagepopup','width=$imagesize[0],height=$imagesize[1]'); return false \">$html_img</a>$delbutton\n";
				
				} else {
					$html .=  "<a href=\"$img[link]\" target=\"$img[smalltext1]\">$html_img</a>$delbutton\n";
				}
			} else {
				$html .=  "$html_img $delbutton\n";
			}
				
			if($type === "compose") { $html .= "</div>"; }

		}
		return array($html, $imagesize, $images);
	}

	
	
	/**
	 * lists all objects of this node
	 * 
	 * if $obj is given, only this object is rendered and returned
	 * @return 
	 */
	function listobjects ($obj=false) {
		global $access;
		$css = new CSS();
		$incms = 1;
		$output = false;
		
		/** 
		 * if node has been cached deliver this node
		 */
		if($this->cache['refresh'] == '6') {
			
			
			$output = $this->cache['html'];
			$output .= '<!-- node '.$this->id.' not cached --->';
			
		}
		
		
		
		if(!$output or $this->compose or $this->nocache or in_array($this->id, $_SESSION['pages_nocache'])) {
			$contentwidth = $this->width;
			$cfgcmspath = "../../";
			
			$styles = $css->readCss(DOCROOT.LIQUIDO."/css/objects.css");
			
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
				//echo "Stile nicht geladen";
			}
			
			
			$part = $this->compose ? 'compose' : 'public';
			if($obj) {
				$svSQL = "select * 
					from ".db_table("contentobjects")."
					where `id` = '".$obj."' and del = '0' 
					order by rank";
				
				$result = db_entry($svSQL);
				$objectid = $result['id'];
				
				ob_start();
					include (OBJECTSDIR.$result['type'].'/'.$result['layout'].'/file.php');
					$html = ob_get_contents();
				ob_end_clean();
				
				$parser = new Parser($html);
				return $parser->parse();
				
			} else {
				$output =  "<div id=\"node-".$this->id."\" class=\"node\">";
				
				$svSQL = "select * 
					from ".db_table("contentobjects")."
					where `parent` = '".$this->id."' and del = '0' 
					order by rank";
				
				foreach($this->db->getArray($svSQL) as $result) {
					$objpath = OBJECTSDIR.$result['type'].'/'.$result['layout'].'/';
					
					if(file_exists($objpath)) {
						$objectid = $result['id'];
						
						include ($objpath.'functions.php');
						
						// setze ausgewählten style auf aktiv
						if($result['showstyles']) {
							$mystyles = $css_styles;
							$mystyles = ereg_replace('"'.$result['contents_css'].'">','"'.$result['contents_css'].'" selected>',$mystyles);
							$mystyles = ereg_replace("objid",$objectid,$mystyles);
						}
						
						// schneide punkt von css-class ab
						$result['contents_css'] = substr($result['contents_css'],1);
						
						ob_start();
						echo "<div id=\"obj$objectid\" class=\"objbox\">";
							include ($objpath.'file.php');
						echo "</div>";
						$html = ob_get_contents();
						ob_end_clean();
		
						$result['html'] = $html;
						$this->objects[] = $result;
						$output .= $html;
						
						// used by the password object to break the listing of objects
						if($endfunction) break;
						
						unset($result);
					}
				}
				$output .= "</div>";
				$output .=  '<!-- node '.$this->id.' not cached --->';
				// save to cache 
				if(!$this->compose && !$this->nocache) {
					$this->r("update ".db_table('node_cache')." set `html` = '".mysql_real_escape_string($output)."' where `page` =  ".$this->id." limit 1");
				}
			}
		}
		
		
		return $output;
	}
	
		
	function get_parents() {
		$t_contents = $this->table;
		$list = array();
		
		$i=0;
		$parent = $this->parent;
		
		while ($parent) {
			$sql = "SELECT id,title,parent,template,type,width FROM `$t_contents` WHERE id = $parent and del != 1 LIMIT 1";
			$result = $this->db->getRow($sql);
			
			if($result) {
				$list['obj'][$result[0]] = $result;
				$idlist = $idlist.",".$result[0];
				$parent = $result['parent'];
				
				// bubble up template
				if(!$this->template && $result['template'] ) $this->template = $result['template'];
				if($result['width'] and !$this->width) $this->width = $result['width'];
				$i++;
			} else {
				$parent = 0;
			}
		}
		
		if($list['obj']) $list['obj'] = array_reverse($list['obj']);
		$list['list'] = $idlist;
		$list['num'] = $i;
		
		//$this->width = $list['contentwidth'];
		$this->parents = $list;
	}
		
		
	function textobject($thisobject) {
	## darstellen eines Textblocks ############
		while (list($key,$value) = each($thisobject)) {
			$$key = $value;
		}
	
		$field = $thisobject['field'] ? $thisobject['field'] : "text";
		
		switch ($part) {
			case "compose":
				// ermittle die anzahl der form-zeilen
				$rows = 5;
				
				// füge linebreaks als zeilen hinzu
				$rows += substr_count($result[$field],"\n") + 2;
			
				// wenn ein wrap-typ eingegeben wurde
				$wrap = $wrap ? " wrap=\"$wrap\"" : "";
				return "<textarea name=\"objectdata[$result[id]][$field]\" id=\"$thisobject[id]\" rows=\"$rows\" class=\"$css_class\" style=\"width:".(ereg("%|px",$textwidth) ? $textwidth : $textwidth."px")."\" $wrap>".($result[$field])."</textarea>\n";
			break;
	
		case "public":
				if($nl2br != "no") {
					return nl2br($result[$field])."</br>";
				} else {
					return $result[$field]."</br>";
				}
			break;
		}
	}

}


?>
