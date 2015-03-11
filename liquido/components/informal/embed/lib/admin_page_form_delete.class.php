<?php

class admin_page_form_delete extends admin_page
{
    var $name = 'form_delete';

    function create_content_array()
    {
        // see if delete or cancel was pressed
        if ($this->fetch_post('delete', false)) {
            // delete the form
            $all_forms = new all_forms;
            $all_forms->delete_form($GLOBALS['informal_form_id']);
            // redirect to refering page
            $this->redirect($this->fetch_post('referer', false));
        } else if ($this->fetch_post('cancel', false)) {
            // redirect to refering page
            $this->redirect($this->fetch_post('referer', false));
        } else {
            // set action url
            $action = INFORMAL_URLBASE . '?'
                . $_SERVER['QUERY_STRING'];
    
            // create form instance
            $form = new form('delete_form', 'post', $action);
            
            // generate confirmation question
            $informal = new informal($GLOBALS['informal_form_id']);
            $form_name = $informal->name;
            $question =
                'Sie wollen das Formular "<strong>'
                . $form_name . '</strong>" löschen?';
            $form->addElement('static', '', $question);
            
            // add buttons
            $button_submit = &HTML_QuickForm::createElement('submit',
                'delete', 'ja löschen', 'class="submitButton"');
            $button_cancel = &HTML_QuickForm::createElement('submit',
                'cancel', 'abbrechen', 'class="submitButton"');
    
            // group buttons
            $form->addGroup(array($button_submit, $button_cancel));

            // add hidden field for referer
            $form->addElement('hidden', 'referer',
                $_SERVER['HTTP_REFERER']);

            // render form html
            $content['form'] = $form->smarty_html($this);

            // return content html for page
            return $content;
        }
    }
}

?>
