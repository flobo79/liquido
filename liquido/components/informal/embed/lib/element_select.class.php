<?php

class element_select extends element
{
	var $name = 'select';
	var $title = 'Selectbox';
	var $toggle_mandatory = false;
	var $toggle_visibility = false;

	function element_select()
	{
		$this->add_collector('title','text','Titel',
			array('size' => '30','maxlength' => '40'), '', '', '', true);

		$this->add_collector('description','textarea','Beschreibung',
			array('cols' => '60','rows' => '3'));

		$this->add_collector('options','text','Option',
			array('size' => '60'), '' , true, 3);

	}

	function render($form_element_data, $disabled = false, &$form)
	{
		$options = $form_element_data['options'];

		if ($disabled) $attributes['disabled'] = 'disabled';
		$attributes['class'] = 'inputText';

		$name = INFORMAL_FORM_ELEMENT_NAME_PREFIX . $form_element_data['id'];

		$select_box = &$form->addElement('select', $name, $options['title'],
			$options['options'], $attributes);

		// pre-selected one option
		$form->setDefaults(array($name => $options['selected_option']));

		$template_vars['title'] = $options['title'];
		$template_vars['select_box'] = $select_box->toHTML();
		$template_vars['label'] = $options['label'];
		$template_vars['description'] = $options['description'];

		return $template_vars;
	}

}

?>
