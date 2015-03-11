<?php

$root = dirname(dirname(dirname(__FILE__)));
$auth_noredirect = true;

class Votemodul extends Sprite {
	
	var $noAuth = true;
	
	function Votemodul() {
		$this->Sprite();
		$this->obj_id = false;
		$this->answer = false;
		$this->tbl_objects = db_table('contentobjects');
	}
	
	function getStat($obj) {
		if(!intval($obj['id'])) die("wrong parameter");
		
		$data = $this->r("select * from ".$this->tbl_objects." where id = ".$obj['id']." LIMIT 1");
		$questions = explode("\n",$data['text2']);
		$answers = explode(',',$data['text3']);
		
		$return['sum'] = 0;
		$return['av'] = array();
		foreach($answers as $a) { $return['sum'] += $a; }
		foreach($answers as $k => $a) {
			$return['av']['a'.($k)] = $a > 0 ? round((100 / ($return['sum']) * $a)*10) / 10 : 0;
		}
		
		echo json_encode($return);
	}
	
	function setVote($obj) {
		$i = substr($obj['vote'],1);
		if(intval($obj['id']) && intval($i)) {
			$data = $this->r("select * from ".$this->tbl_objects." where id = ".$obj['id']." LIMIT 1");
			if(!$data['id']) die ("");
			
			$questions = explode("\n",$data['text2']);
			$answers = explode(',',$data['text3']);
			
			// initial
			if(count($answers) != count($questions)) {
				$answers = array();
				for($ii=0;$ii<count($questions);$ii++) { $answers[] = 0; }
			}
			
			$answers[$i-1]++;
			$this->e('update '.$this->tbl_objects.' set text3 = \''.implode(',',$answers).'\' where id = \''.$obj['id'].'\' LIMIT 1');

			$this->getStat($obj);
		} else {
			
		}
	}
}
?>
