<?php

class element_textarea extends element
{
	var $name = 'textarea';
	var $title = 'Textfeld';
	var $toggle_visibility = false;

	function element_textarea()
	{
		$this->add_collector('title','text','Titel',
			array('size' => '30','maxlength' => '40'), '', '', '', true);

		$this->add_collector('value','textarea','Text',
			array('cols' => '60','rows' => '4'));

		$this->add_collector('description','textarea','Beschreibung',
			array('cols' => '60','maxlength' => '3'));

		$this->add_collector('cols','text','Breite (in Zeichen)',
			array('size' => '3','maxlength' => '3'), '60');

		$this->add_collector('rows','text','Höhe (in Zeilen)',
			array('size' => '3','maxlength' => '3'), '4');
	}

	function render($form_element_data, $disabled = false, &$form)
	{
		$options = $form_element_data['options'];

		$attributes = array(
			'cols' => $options['cols'],
			'rows' => $options['rows']
		);
		if ($disabled) $attributes['disabled'] = 'disabled';
		$attributes['class'] = 'inputText';

		$name = INFORMAL_FORM_ELEMENT_NAME_PREFIX . $form_element_data['id'];

		$textarea = &$form->addElement('textarea', $name, $options['title'],
			$attributes);

		$form->setDefaults(array($name => $options['value']));

		$error_message = 'Bitte ausfüllen';
		if ($options['mandatory']) $form->addRule($name, $error_message, 'required');

		$form->validate();
		$template_vars['error'] = $form->getElementError($name);

		$template_vars['title'] = $options['title'];
		$template_vars['required'] = $options['mandatory'];
		$template_vars['textarea'] = $textarea->toHTML();
		$template_vars['description'] = $options['description'];

		return $template_vars;
	}
}

?>
