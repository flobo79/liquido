<?php

class admin_page_editor_move extends admin_page
{
	var $name = 'editor_move';

	function create_content_array()
	{
		$element_id = $this->fetch_get('id');
		$direction = $this->fetch_get('d');
		if ($direction == 'u') {
			$move_number = -1;
		} else {
			$move_number = 1;
		}
		$informal = new informal;
		$informal->move_form_element($element_id, $move_number);
		$this->redirect($_SERVER['HTTP_REFERER']);
		exit();
	}
}

?>
