<?php 

/**
* class to manage page statistics
*/ 
class Statistic extends Sprite {
	private $table = false;
	
	function __construct() {
		$this->Sprite();
	}
	
	function writeStat($id) {
		$this->e(sprintf('insert into '.$this->table." set visit_timestamp = ".time().", visit_remote_addr='".$_SERVER['REMOTE_ADDR']."', page_id = %d", $id));
	}
	
	function setTable($identifier) {
		$this->table = db_table($identifier);
		return $this;
	}
}