<?php

$root = dirname(dirname(dirname(__FILE__)));
require_once($root."/lib/init.php");

class Slideshow extends Sprite {
	var $folder;	// id of the selected folder from medialibrary
	var $data;
	var $childs;
	var $parent;
	var $thumbs = '';
	var $delay = 5;
	
	public function Slideshow($parent=false) {
		$this->Sprite();
		$this->table = db_table('contentobjects');
		$this->table_medialib = db_table('medialib');
		$this->parent = $parent;
		
		if($parent['smalltext1']) {
			$this->delay = $parent['text2'];
			$this->thumbs = $parent['text3'];
			$this->setFolder($parent['smalltext1']);
		}
	}
	
	public function getData() {
		$return = $this->data;
		$return['childs'] = $this->childs;
		return $return;
	}
	
	public function setFolder($id) {
		$this->folder = $id;
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
		$this->data = $this->db->getRow('select * from '.$this->table_medialib.' where id = '.$this->folder.' limit 1');
		$this->childs = $this->db->getArray('select id,name,info,mime from '.$this->table_medialib.' where parent = '.$this->folder.' order by name');
	}
	
	public function getItem($id) {
		return $this->childs = $this->db->getArray('select * from '.$this->table_medialib.' where id = '.intval($id).' && parent = '.$this->folder.' order by name');
	}
	

	public function display($verbose=false) {
		if($this->folder) {
			ob_start();
			include(dirname(__FILE__)."/tpl_page.php");
		
			$return = ob_get_contents();
			ob_end_clean();
			
			if(!$verbose) echo $return;
			return $return;
		}
	}
	
	public function loadGal() {
		if($this->folder) {
			include(dirname(__FILE__)."/tpl_gallery.php");
		}
	}
}
?>
