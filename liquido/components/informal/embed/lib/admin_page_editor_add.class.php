<?php

class admin_page_editor_add extends admin_page
{
	var $name = 'editor_add';

	function create_content_array() {
		// skip form validation if "cancel" was pressed
		if (informal_fetch_post('cancel',false)) {
			MY_redirect(informal_fetch_post('referer'));
		} else {
			// read element type from page request
			$element_type = $this->fetch_get('type');
			// create new element object and process
			$new_element = element::create_object($element_type);

			// see if user input is needed for element
			if (!$new_element->has_no_options) {
				// collect input for form
				$content['title'] = $new_element->title;
				$content['form'] = $new_element->form();
			} else {
				// elements that do not require input will be added
				// to the form straight away
				$informal = new informal;
				$informal->add_form_element($new_element);

				$this->redirect($_SERVER['HTTP_REFERER']);
				exit;
			}
		}
		return $content;
	}

}

?>
