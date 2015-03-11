<?php

/*
note to myself: when creating a new element type do the following:
1. create a new class element_<name>.class.php
2. register elelment in $all array in element.class.php
3. create element template form_element_<name>.tpl (for admin *and* public)
*/

class element
{

 var $all = array(
		'design_text',
		'design_headline',
		'design_hr',
		'design_spacer',
		'text',
		'textarea',
		'checkbox',
		'radio',
		'select',
		'submit');

	var $allowed_tests = array();
	var $collectors = array();
	var $collects_input = true;
	var $has_no_options = false;
	var $name;
	var $title;
	var $toggle_visibility = false;
	var $toggle_mandatory = true;
	var $lang = "de";
	
	function element () {
	   
		include(dirname(dirname(__FILE__))."/lang/".$this->lang.".inc.php");
	}
	
    function add_collector($name, $type, $label, $options, $default = '',
        $multiple = false, $multiple_count = 0, $mandatory = false)
    {
        $collector = array(
			'name' => $name,
            'type' => $type,
            'label' => $label,
            'options' => $options,
            'default' => $default,
            'mandatory' => $mandatory,
            'multiple' => $multiple,
            'multiple_count' => $multiple_count);
        $this->collectors[] = $collector;
    }

    function add_collector_form_element($collector)
    {
        $collector_name = INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX
            . $collector['name'];

        $this->form->addElement($collector['type'], $collector_name,
            $collector['label'], $collector['options']);

        $this->form->setDefaults(array($collector_name => $collector['default']));

        if ($collector['mandatory']) {
            $this->form->set_mandatory($collector_name);
        }
    }

    function add_multiple_collector_form_element($collector, $form_element = null)
    {
        $values = $this->form->getSubmitValues();

        if ($form_element) $edit_mode = true;

        // if a multiple_count is submitted use it
        if ($values['multiple_count']) {
            $multiple_count = $values['multiple_count'];
        } else if ($edit_mode) {
            $multiple_count = 
                count($form_element->data['options']['options']);
        } else {
            $multiple_count = $collector['multiple_count'];
        }

        // if more button is pressed, add 3 option fields
        if ($values['more']) {
            $multiple_count += 3;
        }

        // initialise select box
        $select_options = $this->initialise_select_box();
        
        // add text fields and fill select box
        for ($i = 1; $i <= $multiple_count ; $i++) {

            $collector_name = INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX
                . $collector['name'] . '[' . $i . ']';

            $collector_label = $collector['label'] . ' ' . ($i);

            $this->form->addElement($collector['type'], $collector_name,
                $collector_label, $collector['options']);

            // add option for select box
            $select_options[$i] = $collector_label;

            // at least two options are necessary
            if ($i <= 1) {
                $this->form->addRule($collector_name,
                    'bitte ausfüllen','*', null, 1,
                    'server', true);
            }
        }

        // hidden field for multiple counter
        $this->form->addElement('hidden', 'multiple_count');
        $this->form->setConstants(array('multiple_count' => $multiple_count));

        // more button
        $this->form->addElement('submit', 'more', 'mehr Optionsfelder',
            'class="submitButton"');
        
        // select field
        $this->form->addElement('select', INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX
            . 'selected_option', 'Vorauswahl', $select_options);

    }

    function allow_test($test_name)
    {
//		$string_test = new string_test;
//		$this->allowed_tests[] = $string_test->create($test_name);
    }

    function create_object($type)
    {
        $class_name = INFORMAL_ELEMENT_CLASS_PREFIX . $type;
        $object = new $class_name;
        return $object;
    }

    function form($vars = null)
    {
        // start a quickform
        $action = INFORMAL_URLBASE . '?' . $_SERVER['QUERY_STRING'];
        $this->form = new form('informal', 'post', $action);
        // create informal object for editing and adding
        // FIXME: for displaying the form this is not necessary
        $informal = new informal;

        // see if the form is called from the edit page
        if ($vars) $edit_mode = true;

        // create admin page object
        $admin_page = new admin_page;

        // add hidden fields
        $this->form->addElement('hidden', 'referer', $_SERVER["HTTP_REFERER"]);
        if ($edit_mode) {
            $this->form->addElement('hidden', 'id', $admin_page->fetch_get('id'));
            // get form element
            $form_element =
                $informal->get_form_element_by_id($admin_page->fetch_get('id'));
        } else {
            $this->form->addElement('hidden', 'type');
        }

        // add collector fields
        foreach($this->collectors as $collector)
        {
            // treat multiple collectors differently
            if ($collector['multiple']) {

                $this->add_multiple_collector_form_element($collector,
                    $form_element);

            } else {
                $this->add_collector_form_element($collector, $form_element);
            }
        }

        // add visibility buttons to form
        if ($this->toggle_visibility) {
            $field_name = INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX
                . 'public';
            $this->form->addElement('checkbox', $field_name, '',  'öffentlich sichtbar');
            $this->form->setDefaults(array($field_name => '1'));
        }

        // add mandatory buttons to form
        if ($this->toggle_mandatory) {
            $field_name = INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX
                . 'mandatory';
            $this->form->addElement('checkbox', $field_name, '',  'Pflichtfeld');
            $this->form->setDefaults(array($field_name => '0'));
        }

        // show test options
        foreach($this->allowed_tests as $test)
        {
            $field_name = INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX
                . 'test_' . $test->name;
            $this->form->addElement('checkbox', $field_name, '',  $test->description);
            $this->form->setDefaults(array($field_name => '0'));
        }

        // create button group
        // edit or add button?
        if ($edit_mode) {
            $button_submit = &HTML_QuickForm::createElement('submit', 'save',
                'Änderungen speichern', 'class="submitButton"');
                $this->form->addRule('save', '', '*');
        } else {
            $button_submit = &HTML_QuickForm::createElement('submit', 'add',
                'hinzufügen', 'class="submitButton"');
            $this->form->addRule('add', '', '*');
        }

        $button_cancel = &HTML_QuickForm::createElement('submit', 'cancel',
            'abbrechen', 'class="submitButton"');

        $this->form->addGroup(array($button_submit, $button_cancel));

        // load form_element options if in edit mode
        if ($edit_mode) {
            foreach($form_element->data['options'] as $option_key =>
                $option_value) {
                $this->form->setDefaults(array(
                    INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX
                    . $option_key => $option_value));
            }
        }

        //
        // validate
        // (ignore "show more fields" button)
        //
        if ($this->form->validate() && !$this->form->getSubmitValue('more')) {

            // FIXME: if the "more" button at an empty select box is pressed
            //        field errors are generated, this shoul be avoided

            $this->form->freeze();
            $values = $this->form->getSubmitValues();

            // select collector option data from submitted values
            $needle = INFORMAL_ELEMENT_COLLECTOR_NAME_PREFIX;
            foreach ($values as $key => $value) {
                if (strpos($key, $needle) === 0)
                {
                    $name = substr($key, strlen($needle));
                    $options[$name] = $value;
                }
            }

            // process the option data
            if ($edit_mode) {
                // update element
                $informal->update_form_element_options($values['id'], $options);
            } else {
                // add element to form
                $informal->add_form_element($this, $options);
            }

            // redirect
            $admin_page->redirect(page::fetch_post('referer'));
        }

        // get form html by filling template
        $form_html = $this->form->smarty_html($admin_page);

        return $form_html;
    }

    function initialise_select_box()
    {
        // only used in element_radio class
    }

    function render($form_element_data)
    {
        $template_vars = $form_element_data['options'];
        return $template_vars;
    }

}

?>
