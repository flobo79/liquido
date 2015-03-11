<?php

/**
 * A Block is a collection of nodes to display all at ones based on 
 * display parameters
 * 
 */


class Block extends Sprite {
	var $id = 0;
	var $title = '';
	var $description = '';
	var $link = '';
	
	function Block($id=false) {
		
		$this->Sprite();
		$this->table = db_table('blocks');
		
		if($id) {
			$sql = "select * from ".$this->table." where id = ".intval($id)." or `link` = '".mysql_real_escape_string($id)."' LIMIT 1";
			$data = $this->db->getRow($sql);
			foreach($data as $k => $v) { $this->$k = $v; }
			$this->nodes = explode(",",$this->nodes);
			
			
			
			$nodes = array();
			foreach($this->nodes as $node) {
				if($node) {
					$node = explode(":", $node);
					$node = new Node($node[0]);
					$nodes[] = $node;
				}
			}
			
			
			
			$this->nodes = $nodes;
			
		}
	}
	
	function update() {
		// this nodes
		$nodes = array();
		
		foreach($this->nodes as $n) { $nodes[] = $n->id; }
		$nodes = join(",",$nodes);
		
		$sql = "update ".$this->table." set 
			`title` = '".mysql_real_escape_string($this->title)."',
			`link` = '".mysql_real_escape_string($this->link)."',
			`description` = '".mysql_real_escape_string($this->description)."',
			`nodes` = '$nodes' 
			 where id = ".intval($this->id)." LIMIT 1";
		$this->e($sql);
	}
	
	function create($o) {
		$sql = "insert into ".$this->table." set 
			`title` = '".mysql_real_escape_string($o['title'])."',
			`link` = '".mysql_real_escape_string($o['link'])."',
			`description` = '".mysql_real_escape_string($o['description'])."'
			";
		$this->db->execute($sql);
		return $this->db->insert_ID();
	}
	
	function data() {
		$vars = get_object_vars($this);
		foreach($vars['nodes'] as $k => $n) {
			$vars['nodes'][$k] = $n->data();
		}
		unset($vars['table'], $vars['db']);
		return $vars;
	}
	
	function delete() {
		$this->db->execute('delete from '.$this->table.' where id = \''.$this->id.'\' LIMIT 1');
	}
	
	function addNode($node) {
		if(intval($node)) {
			$this->nodes[] = new Node($node);
			$this->update();
		}
	}
	
	function removeNode($node) {
		if(intval($node)) {
			foreach($this->nodes as $k => $n) {
				if ($n->id == $node) {
					unset($this->nodes[$k]);
				}
			}
			$this->update();
		}
	}
	
	function updateNodeOrder($str_order) {
		$order = split(",",$str_order);
		$nodes = array();
		
		foreach($order as $id) {
			foreach($this->nodes as $node) {
				if($node->id == $id) {
					$nodes[] = $node;
					break;
				}
			}
		}
	
		$this->nodes = $nodes;
		$this->update();
	}
}
	
	
?>
