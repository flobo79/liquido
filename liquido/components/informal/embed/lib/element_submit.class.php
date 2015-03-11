<?php

class element_submit extends element
{
	var $collects_input = false;
	var $name = 'submit';
	var $title = 'Absenden Button';
	var $toggle_mandatory = false;
	var $toggle_visibility = false;

	function element_submit()
	{
		$this->add_collector('button_text','text','Button Text',
			array('size' => '30','maxlength' => '40'), '', '', '', true);

		$this->add_collector('description','textarea','Beschreibung',
			array('cols' => '60','rows' => '3'));

	}

	function render($form_element_data, $disabled = false, &$form)
	{
		$options = $form_element_data['options'];

		$attributes['class'] = 'submitButton';
		if ($disabled) $attributes['disabled'] = 'disabled';

		$name = INFORMAL_FORM_ELEMENT_NAME_PREFIX . $form_element_data['id'];

		$select_box = &$form->addElement('submit', $name,
			$options['button_text'], $attributes);

		$template_vars['submit_button'] = $select_box->toHTML();
		$template_vars['description'] = $options['description'];

		return $template_vars;
	}

}

?>
