<?php

class element_text extends element
{
	var $name = 'text';
	var $title = 'Textzeile';

	function element_text()
	{
		$this->add_collector('title','text','Titel',
			array('size' => '30','maxlength' => '40'), '', '', '', true);

		$this->add_collector('value','text','Text',
			array('size' => '60'));

		$this->add_collector('description','textarea','Beschreibung',
			array('cols' => '60','rows' => '3'));

		$this->add_collector('size','text','Breite (in Zeichen)',
			array('size' => '3','maxlength' => '3'), '60');

		$this->add_collector('maxlength','text','Maximallenge (Anzahl Zeichen)',
			array('size' => '3','maxlength' => '3'));

		$this->allow_test('email');
		$this->allow_test('number');
	}

	function render($form_element_data, $disabled = false, &$form)
	{
		$options = $form_element_data['options'];

		$attributes = array(
			'size' => $options['size'],
			'maxlength' => $options['maxlength']
		);
		$attributes['class'] = 'inputText';

		if ($disabled) $attributes['disabled'] = 'disabled';

		$name = INFORMAL_FORM_ELEMENT_NAME_PREFIX . $form_element_data['id'];

		$input_field = &$form->addElement('text', $name, $options['title'],
			$attributes);

		$form->setDefaults(array($name => $options['value']));

		$error_message = 'Bitte ausfüllen';
		if ($options['mandatory']) $form->addRule($name, $error_message, 'required');

		$form->validate();
		$template_vars['error'] = $form->getElementError($name);
		
		$template_vars['title'] = $options['title'];
		$template_vars['required'] = $options['mandatory'];
		$template_vars['input_field'] = $input_field->toHTML();
		$template_vars['description'] = $options['description'];

		return $template_vars;
	}


}

?>
