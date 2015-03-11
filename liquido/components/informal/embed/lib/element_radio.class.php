<?php

class element_radio extends element
{
    var $name = 'radio';
    var $title = 'Radio-Button Set';
    var $toggle_visibility = false;

    function element_radio()
    {
        $this->add_collector('title','text','Titel',
            array('size' => '30','maxlength' => '40'), '', '', '', true);

        $this->add_collector('description','textarea','Beschreibung',
            array('cols' => '60','rows' => '3'));

        $this->add_collector('options','text','Option',
            array('size' => '60'), '' , true, 3);
    }

    function initialise_select_box()
    {
        $select_options['none'] = 'None';
        return $select_options;
    }

    function render($form_element_data, $disabled = false, &$form)
    {
        $options = $form_element_data['options'];

        if ($disabled) $attributes['disabled'] = 'disabled';
        $attributes['class'] = 'inputText';

        $name = INFORMAL_FORM_ELEMENT_NAME_PREFIX . $form_element_data['id'];

        // create individual radio buttons
        $i = 1;
        foreach($options['options'] as $option) {
            $radios[] = &HTML_QuickForm::createElement('radio', NULL, NULL,
                $option, $i, $attributes);
            $i++;
        }

        // create radio button group
        $radio_group = &$form->addGroup($radios, $name, $options['title']);

        // check selected radio button
        $form->setDefaults(array($name => $options['selected_option']));

        $error_message = 'Bitte auswählen';
        if ($options['mandatory']) $form->addRule($name, $error_message, '*');

        $form->validate();
        $template_vars['error'] = $form->getElementError($name);

        $template_vars['title'] = $options['title'];
        $template_vars['required'] = $options['mandatory'];
        $template_vars['radio_buttons'] = $radio_group->toHTML();
        $template_vars['label'] = $options['label'];
        $template_vars['description'] = $options['description'];

        return $template_vars;
    }

}

?>
