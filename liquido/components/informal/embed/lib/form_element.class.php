<?php

class form_element
{
	var $data;
	var $element;
	var $position;

	function form_element($element)
	{
		$this->element = $element;
	}

	function html($disabled = false, $page, &$form)
	{
		// get variables for template fields
		$vars = $this->element->render($this->data, $disabled, $form);

		// build template name 
		$template_name = 'form_element_' . $this->data['type'];

		// create admin_page object for fetch_template function
		$html = $page->fetch_template($template_name, $vars);

		return $html;
	}

}

?>
