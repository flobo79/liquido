<?php
    /**
     * a sprite is a base object for other liquido objects
     * 
     */
	
	class Sprite {
		static $db;
		
		function Sprite () {
			global $db;
			$this->db = $db;
		}
		
		function e ($query) {
			return $this->db->execute($query);
		}
		
		function r ($query) {
			return $this->db->getRow($query);
		}
		
		function a ($query) {
			return $this->db->getArray($query);
		}
	}
	
?>
