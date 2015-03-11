<?php

class admin_page_editor extends admin_page
{
    var $headline = 'Form Editor';
    var $name = 'editor';

    function create_content_array()
    {
        // fetch elements from classes and gather information for
        // "add" select box
        $element = new element;
        foreach ($element->all as $name) {
            $element_object = $element->create_object($name);
            $element_properties = array();
            $element_properties['name'] = $element_object->name;
            $element_properties['title'] = $element_object->title;
            $elements_array[] = $element_properties;
        }
        
        // fetch elements from database
        $informal = new informal;
        $forms = $informal->forms($this, true);
        $form_elements_array = $forms['informal'];

        //fill content array
        $content['form_element_add_action'] = $this->build_link('editor_add');
        $content['form_id'] = $GLOBALS['informal_form_id'];
        $content['area'] = $this->area;
        $content['page'] = 'editor_add';
        $content['form_elements'] = $form_elements_array;
        $content['available_elements'] = $elements_array;
        return $content;
    }
}

?>
