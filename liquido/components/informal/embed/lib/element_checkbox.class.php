<?php

class element_checkbox extends element
{
	var $name = 'checkbox';
	var $title = 'Checkbox';
	var $toggle_visibility = false;

	function element_checkbox()
	{
		$this->add_collector('title','text','Titel',
			array('size' => '30','maxlength' => '40'), '', '', '', true);

		$this->add_collector('label','text','Checkbox Name',
			array('size' => '30','maxlength' => '40'), '', '', '', true);

		$this->add_collector('description','textarea','Beschreibung',
			array('cols' => '60','rows' => '3'));

		$this->add_collector('checked','checkbox','', 'ausgewählt');
	}

	function render($form_element_data, $disabled = false, &$form)
	{
		$options = $form_element_data['options'];

		if ($disabled) $attributes['disabled'] = 'disabled';
		$attributes['class'] = 'inputText';

		$name = INFORMAL_FORM_ELEMENT_NAME_PREFIX . $form_element_data['id'];

		$checkbox = &$form->addElement('checkbox', $name, $options['title'],
			$options['label'], $attributes);

		$form->setDefaults(array($name => $options['checked']));

		$error_message = 'bitte angeben';
		if ($options['mandatory']) $form->addRule($name, $error_message, '*');

		$form->validate();
		$template_vars['error'] = $form->getElementError($name);

		$template_vars['title'] = $options['title'];
		$template_vars['required'] = $options['mandatory'];
		$template_vars['checkbox'] = $checkbox->toHTML();
		$template_vars['label'] = $options['label'];
		$template_vars['description'] = $options['description'];

		return $template_vars;
	}


}

?>
