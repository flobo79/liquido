<?php 

/**
 * The parser searches html code for static and dynamic liquido tags and replaces them with the 
 * calculated output.
 * 
 * Following static tags are known:
 * - xstructure|structure|xclass|class|xcontainer|container|page|node
 * 
 * Note: page and node are the same, node is the replacement for page
 * 
 */


class Parser extends Sprite {
	var $count = 0; // number of tag replacements
	public $html = '';
	
	public function Parser($html=false, $node=false) {
		$this->Sprite();
		if($html) $this->html = $html;
		if($node) $this->node = $node;
	}
	
	public function setHtml($html) {
		$this->html = $html;
	}
	
	public function getHtml ($html) {
		return $this->html;
	}
		
	public function setNode($id) {
		$this->node = $id;
	}
	
	public function getNode() {
		return $this->node;
	}
	
	public function parse() {
		$iterations = 10;
		
		while($count = $this->_parse() && $i<$iterations) {
			//echo $count;
		}
		
		return $this->html;
	}
	
	private function _parse() {
		// suche nach klassen
		$pattern = array(
			"/<(xstructure|structure|xclass|class|xcontainer|container|page|node|block)(:[a-z0-9-]*)>/",
			"/#(host|createdate|changedate|template|breadcrump|pageid|host|xstructure|structure|xclass|class|xcontainer|container|page|node|block)(:[a-z0-9-]*)#/",
			"/<(host|createdate|changedate|template|breadcrump|pageid|host|xstructure|xcontainer)>/",
			"/#(host|createdate|changedate|template|breadcrump|pageid|host|xstructure|xcontainer)#/"
		);
		
		$count = 0;
		$this->html = preg_replace_callback($pattern, array($this,'parseTag'), $this->html, 100, $count);
		return $count;
	}
	
	function parseTag ($match) {
		include("cfg.php");
		
		$param = trim(substr($match[2],1)); // cut off ":"
		$tag = trim($match[1]);

		switch($tag) {
			case "host":
				return $cfg['env']['host'];
				break;
				
			case "changedate":
				return date("d.m.y",$this->node['changed']);
				break;
				
			case "pageid":
				return $this->node['id'];
				break;
				
			case "createdate":
				return date("d.m.y",$this->node['date']);
				break;
			
			case "breakcrumb":
				return "";
				break;
			
			case "page":
				$node = new Node($param);
				return $node->listobjects();
				break;
				
			case "node":
				$node = new Node($param);
				return $node->listobjects();
				break;
				
			case "block":
				$block = new Block($param);
				$html = '';
				
				foreach($block->nodes as $node) {
					$html .= "<div id=\"blocknode".$node->id."\" class=\"blocknode\">".$node->listobjects()."</div>";
				}
				
				return $html;
				
				break;
				
			case "structure":
				if($param) {
					global $cfgtablestructures;
					if(intval($param)) {
						$data = $this->db->getRow("select code from ".db_table('temp_structures')." where tpl = '".$this->node['template']."' and obj = '$param' LIMIT 1");
						if(count($data)) {
							return $data['code'];
						} else {
							return "<!-- structure $param not exist -->";
						}
					} else {
						return "<!-- structure wrong parameter: $param -->";
					}
				} else {
					return "<!-- structure wrong parameter: $param -->";
				}
				break;
				
			case "xstructure":
				if($param) {
					global $cfgtablestructures;
					if(intval($param)) {
						$data = $this->db->getRow("select code from ".db_table('temp_structures')." where tpl = '9999' and obj = '$param' LIMIT 1");
						if(count($data)) {
							return $data['code'];
						} else {
							return "<!-- xstructure $param not exist -->";
						}
					} else {
						return "<!-- xstructure wrong parameter: $param -->";
					}
				} else {
					//
				}
				break;
				
			case "container":
				if($param) {
					global $cfgtablecontainer;
					if(intval($param)) {
						$data = $this->db->getRow("select title from ".db_table('temp_container')." where tpl = '".$this->node['template']."' and obj = '$param' LIMIT 1");
						if(count($data)) {
							return CONTAINERDIR.$this->node['template']."/".$data['title'];
						} else {
							return "<!-- container $param not exist -->";
						}
					} else {
						return "<!-- container wrong parameter: $param -->";
					}
				} else {
					return CONTAINERDIR.$this->node['template']."/";
				}
				break;
				
			case "xcontainer":
				if($param) {
					
					if(intval($param)) {
						$data = $this->db->getRow("select obj, title from ".db_table('temp_container')." where tpl = '9999' and obj = '$param' LIMIT 1");
						if(count($data)) {
							return CONTAINERDIR."9999/".$data['title'];
						} else {
							return "<!-- xcontainer $param not exist -->";
						}
					} else {
						return "<!-- xcontainer wrong parameter: $param -->";
					}
				} else {
					return CONTAINERDIR."9999/";
				}
				break;
				
			case "class":
				if(intval($param)) {
					$class = $this->db->getRow("select * from ".db_table('temp_classes')." where tpl = '".$this->node['template']."' and obj = '$param' LIMIT 1");
					return $this->parseClass($class);
				} else {
					return "<!-- class $param wrong parameter -->";
				}
				break;
				
			case "xclass":
				if(intval($param)) {
					$class = $this->db->getRow("select * from ".db_table('temp_classes')." where tpl = '9999' and obj = '$param' LIMIT 1");
					return $this->parseClass($class);
				} else {
					return "<!-- xclass $param wrong parameter -->";
				}
				break;
		}
		
		if($sql) {
			$obj = mysql_fetch_array(mysql_query($sql));
			if($obj) {
				$code = ($type == "class" or $type == "xclass") ? $this->parseClass($obj) : $obj[0];
				$code = ($type == "container") ? "<container>".$code : $code;
				$code = ($type == "xcontainer") ? "<xcontainer>".$code : $code;
			} else {
				$code = "<!-- $type $id nicht vorhanden -->";
			}
		}
		return $code;
	}
	
	
	function parseClass($class) {
		ob_start();
			try {
				eval($class['code']);
			}
			catch(Exception $e) {

			}
			
			$code = ob_get_contents();
		ob_end_clean ();
		
		return $code;
	}
}
?>