<?php

// a skeleton for new admin pages

class admin_page_editor_remove extends admin_page
{
	var $name = 'editor_remove';

	function create_content_array()
	{
		if ($this->fetch_post('yes', false) != '') {
			// delete and redirect if yes was pressed
			$element_id = $this->fetch_get('id');
			$informal = new informal;
			$element = $informal->remove_element($element_id);
			// redirect
			$this->redirect($this->fetch_post('referer'));
			exit;
		} else if ($this->fetch_post('cancel', false) != '') {
			// redirect back if cancel was pressed
			$this->redirect($this->fetch_post('referer'));
			exit;
		} else {
			// fill form if no button was pressed

			// find out element name/type
			$element_id = $this->fetch_get('id');
			$informal = new informal;
			$element = $informal->get_form_element_by_id($element_id);
			$element_type = $element->data['type'];

			// find out element title
			// FIXME: include element object in form_element class
			$element_object = element::create_object($element_type);
			$element_title = $element_object->title;

			$content['element_id'] = $element_id;
			$content['element_title'] = $element_title;
			$content['referer_url'] = $_SERVER['HTTP_REFERER'];
			return $content;
		}
	}
}

?>
