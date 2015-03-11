<?php

// a wrapper for pear quickform.
// FIXME: is this wrapper obsolete? scan files for functions

class form extends HTML_QuickForm
{
    var $message = '';

    function add_radio_set($name, $title, $separator = ' ', $choices)
    {
        foreach ($choices as $choice)
        {
            $radio_set[] = &HTML_QuickForm::createElement('radio', null, null,
                $choice['label'], $choice['value']);
        }
        $this->addGroup($radio_set, $name, $title);
    }

    function set_mandatory($name)
    {
        $this->addGroupRule($name, 'bitte ausfüllen','*',
            null, 1, 'server', true);
    }

    function set_value($name, $value)
    {
        $this->setDefaults(array($name => $value));
    }

    function smarty_html($page)
    {
        $form_array = $this->toArray();
        $vars = array('form' => $form_array);
        
        // add form message
        if ($this->message) $vars['message'] = $this->message;
    
        $html = $page->fetch_template('form', $vars);
        return $html;
    }

}

?>
