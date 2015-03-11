<?php

class content_stats {
	function content_stats() {
		global $LQ;
		
		$this -> table = $LQ -> db_table("content_stats");
		
	}
	
	function get_page_stats($page) {
		global $LQ;
		$tree = $LQ -> getTree($page);
	}
	
	function get_tree_stats($parent) {
	
	}
	
	function get_content_stats() {
	
	}
	
}

$c_stats = new content_stats();


?>