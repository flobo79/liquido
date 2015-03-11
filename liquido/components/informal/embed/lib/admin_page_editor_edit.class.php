<?php

class admin_page_editor_edit extends admin_page
{
	var $name = 'editor_edit';

	function create_content_array()
	{
		// skip form processing if "cancel" was pressed
		if (informal_fetch_post('cancel',false)) {

			MY_redirect(informal_fetch_post('referer'));

		} else {

			// read element id from page request
			$element_id = $this->fetch_get('id');

			// fetch form element
			$informal = new informal;
			$form_element = $informal->get_form_element_by_id($element_id);

			// collect input for form
			$content['title'] = $form_element->element->title;
			$content['form'] =
				$form_element->element->form($form_element->data);
		}
		return $content;
	}
}

?>
