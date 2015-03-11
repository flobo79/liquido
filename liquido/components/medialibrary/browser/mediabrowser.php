<?php
    
$root = dirname(dirname(dirname(dirname((__FILE__)))));
require_once($root."/lib/init.php");

class Mediabrowser extends Sprite {
	function Mediabrowser() {
		$this->Sprite();
		$this->table = db_table('medialib');
	}
	
	function getChilds($id) {
		return $this->db->getArray("select id, name, mime from ".$this->table." where parent = '$id' order by `name`");
	}
	
	function getDetails($id) {
		$row = $this->db->getRow('select * from '.$this->table.' where id = '.$id.' limit 1');
		$row['childs'] = $this->getChilds($id);
		return $row;
	}
	
	function loadTemplate($data, $template) {
		
		if(file_exists(dirname(__FILE__).'/templates/'.$template.'.php')) {
			ob_start();
			include (dirname(__FILE__).'/templates/'.$template.'.php');
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		} else {
			return dirname(__FILE__).'/templates/'.$template.'.php existiert nicht';
		}
	}
}

	
?>
