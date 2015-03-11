<?php

class form_page extends page
{
    var $design = 'public';
    var $disabled = false;
    var $headline = 'Welcome';
    var $name = 'form';
    var $template = 'page';

    function form_page($disabled = false)
    {
        // mainly used in embedded mode
        if ($disabled) $this->disabled = true;
    }
    
    function build_page_array()
    {
        $vars['headline'] = $this->title;
        $vars['content'] = $this->create_content();

        return $vars;
    }

    function create_content_array()
    {
        // get form from db
        $informal = new informal($GLOBALS['informal_form_id']);
        
        $forms = $informal->forms($this, $this->disabled);

        $quickform = $forms['quickform'];
        $form_elements = $forms['informal'];

        //
        // see if the form validates
        //
        if($quickform->validate()) {
            // write submission to database
            $informal->add_submission($quickform);
            $vars['done'] = true;
            $vars['thank_you_message'] = $informal->thank_you_message;
            $vars['thank_you_url'] = $informal->thank_you_url;
        } else {
            // generate form attributes
            
            $quickform_array = $quickform->toArray();
            $attributes = $quickform_array['attributes'];
    
            // show an error message if there were errors
            $problems = $quickform_array['errors'];
            if ($problems) $vars['problems'] = true;
    
            $vars['attributes'] = $attributes;
            $vars['form_elements'] = $form_elements;
        }

        return $vars;
    }

}

?>
