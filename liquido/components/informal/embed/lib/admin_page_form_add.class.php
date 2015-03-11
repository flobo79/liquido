<?php

class admin_page_form_add extends admin_page
{
    var $name = 'form_add';

    function create_content_array()
    {
        // see if cancel was pressed
        if ($this->fetch_post('cancel', false)) {
            $this->redirect(page::fetch_post('redirect'));
        } else {
            // set action url
            $action = INFORMAL_URLBASE . '?'
                . $_SERVER['QUERY_STRING'];
    
            // find out where this page has been called from
            $redirect = $_SERVER['HTTP_REFERER'];
            
            // create form instance
            $form = new form('add', 'post', $action);
            
            // add text input field and make mandatory
            $form->addElement('text', 'name', 'Form Name');
            $form->set_mandatory('name');
            
            // add hidden field for redirect target
            $form->addElement('hidden', 'redirect', $redirect);
            
            // add buttons
            $button_submit = &HTML_QuickForm::createElement('submit',
                'submit', 'erstelle Form', 'class="submitButton"');
            $button_cancel = &HTML_QuickForm::createElement('submit',
                'cancel', 'abbrechen', 'class="submitButton"');
            
            // group buttons
            $form->addGroup(array($button_submit, $button_cancel));
            
            // see if form validates
            if ($form->validate()) {
                $name = $form->getElementValue('name');
                $all_forms = new all_forms();
                $new_form_id = $all_forms->add_form($name);
                // redirect either to a given url or the http referer
                if ($this->redirect_url) {
                    // %d is replaced by new form id
                    $url = sprintf($this->redirect_url, $new_form_id);
                    $this->redirect($url);
                } else {
                    $this->redirect(page::fetch_post('redirect'));
                }
            } else {
                $content['form'] = $form->smarty_html($this);
            }
            
            // return content html for page
            return $content;
        }
    }
}

?>
