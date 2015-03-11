<?php

$root = dirname(dirname(dirname(__FILE__)));
$auth_noredirect = true;



class Send2friend extends Sprite {
	var $noAuth = true;
	
	function Send2friend() {
		$this->Sprite();
		$this->obj_id = false;
		$this->answer = false;
		$this->tbl_objects = db_table('contentobjects');
	}
	
	function send($obj) {
		if($obj['to'] && $obj['page'] && $obj['id']) {
			
			$data = $this->r("select * from ".$this->tbl_objects." where id = ".$obj['id']." LIMIT 1");
			if(!$data['id']) die ("wrong object id");
			
			$email = str_replace(
				array('_name_','_link_','_nachricht_'),
				array($obj['name'], $obj['page'], $obj['message']),
				$data['text3']);
			
			$to = split(",", $obj['to']);
			mail($to[0],"Linkempfehlung von ".$obj['name'], $email, "FROM: Volskwagen Club GmbH <>");
			
			// count submissions
			$data['smalltext2'] = intval($data['smalltext2']);
			$this->e("update ".$this->tbl_objects." set smalltext2 = '".($data['smalltext2']++)." where id = ".$obj['id']." LIMIT 1");

		} else {
			
		}
	}
}
?>
