<?php

class admin_page_settings extends admin_page
{
    var $headline = 'Admin';
    var $name = 'settings';

    function create_content_array()
    {
        //
        // details part
        //
        $form_id = $GLOBALS['informal_form_id'];
        $informal = new informal($form_id);
        $content['details']['name'] = $informal->name;
        
        //
        // settings part
        //

        // set action url
        $action = INFORMAL_URLBASE . '?'
            . $_SERVER['QUERY_STRING'];

        $form = new form('settings', 'post', $action);
    
        // add text input field and make mandatory
        $field = $form->createElement('text', 'name', 'Name', array(
            'class' => 'inputText',
            'size' => 50,
            'maxlength' => 200
        ));
		
        $field->setValue($informal->name);
        $form->addElement($field);
        $form->set_mandatory('name');

        // add text input field and make mandatory
        $field = $form->createElement('textarea', 'thank_you_message'
            , 'Bestätigungs Nachricht', array(
                'class' => 'inputText',
                'cols' => 50,
                'rows' => 3,
            ));
        $field->setValue($informal->thank_you_message);
        $form->addElement($field);
        
		// thankyou url
        $field = $form->createElement('text', 'thank_you_url'
            , 'Bestätigungs Link', array(
                'class' => 'inputText',
                'size' => 50,
                'maxlength' => 200
            ));
        $field->setValue($informal->thank_you_url);
        $form->addElement($field);
		
		// checkbox weiterleiten
        $field = $form->createElement('checkbox', 'redirect','', 'nach dem Absenden weiterleiten');
        $field->setValue($informal->redirect);
        $form->addElement($field);

        // mail2customer
        $field = $form->createElement('textarea', 'mail2customer'
            , '<b>E-Mail an Kunden:</b>', array(
                'class' => 'inputText',
                'cols' => 50,
                'rows' => 8,
            ));
        $field->setValue($informal->mail2customer);
        $form->addElement($field);

		// id for address
        $field = $form->createElement('text', 'mail2customer_addressfieldid'
            , 'ID für Email-Feld (zB \'e312\'):', array(
                'class' => 'inputText',
                'size' => 10,
                'maxlength' => 50
            ));
        $field->setValue($informal->mail2customer_addressfieldid);
        $form->addElement($field);
		

        $field = $form->createElement('text', 'mail2customer_sender'
            , 'Absendername:', array(
                'class' => 'inputText',
                'size' => 50,
                'maxlength' => 200
            ));
        $field->setValue($informal->mail2customer_sender);
        $form->addElement($field);
		

        $field = $form->createElement('text', 'mail2customer_returnmail'
            , 'Absender e-Mail-Adresse:', array(
                'class' => 'inputText',
                'size' => 50,
                'maxlength' => 200
            ));
        $field->setValue($informal->mail2customer_returnmail);
        $form->addElement($field);
		
        $field = $form->createElement('text', 'mail2customer_subject'
            , 'Betreff:', array(
                'class' => 'inputText',
                'size' => 50,
                'maxlength' => 200
            ));
        $field->setValue($informal->mail2customer_subject);
        $form->addElement($field);

       
	    // mail2admin
        $field = $form->createElement('textarea', 'mail2admin'
            , '<b>E-Mail an Formularauswertung:</b>', array(
                'class' => 'inputText',
                'cols' => 50,
                'rows' => 8,
            ));
        $field->setValue($informal->mail2admin);
        $form->addElement($field);
	
	   $field = $form->createElement('text', 'mail2admin_returnmail'
            , 'Absender e-Mail-Adresse:', array(
                'class' => 'inputText',
                'size' => 50,
                'maxlength' => 200
            ));
        $field->setValue($informal->mail2admin_returnmail);
        $form->addElement($field);
		
        $field = $form->createElement('text', 'mail2admin_subject'
            , 'Betreff:', array(
                'class' => 'inputText',
                'size' => 50,
                'maxlength' => 200
            ));
        $field->setValue($informal->mail2admin_subject);
        $form->addElement($field);

        $field = $form->createElement('text', 'mail2admin_email'
            , 'Zieladresse:', array(
                'class' => 'inputText',
                'size' => 50,
                'maxlength' => 200
            ));
        $field->setValue($informal->mail2admin_email);
        $form->addElement($field);

		
	
	
        // add buttons
        $button_submit = $form->createElement('submit', 'submit'
            , 'Save settings', 'class="submitButton"');
        $button_reset = $form->createElement('reset', 'reset'
            , 'Reset', 'class="submitButton"');
        $form->addGroup(array($button_submit, $button_reset));

		$fields = array(
			"name",
			"thank_you_url",
			"redirect",
			"thank_you_message",
			"redirect",
			"mail2customer",
			"mail2customer_addressfieldid",
			"mail2customer_sender",
			"mail2customer_returnmail",
			"mail2customer_subject",
			"mail2admin",
			"mail2admin_returnmail",
			"mail2admin_subject",
			"mail2admin_email");
			

        if ($form->validate()) {
			
			foreach($fields as $field) { 
				$settings[$field] = $form->getElementValue($field); 
			}
		
		/*
            $settings['name'] = $form->getElementValue('name');
            $settings['thank_you_url'] =
                $form->getElementValue('thank_you_url');
            $settings['thank_you_message'] =
                $form->getElementValue('thank_you_message');
           $settings['redirect'] =
                $form->getElementValue('redirect');
		   $settings['mail2admin'] =
                $form->getElementValue('mail2admin');
		   $settings['mail2customer'] =
                $form->getElementValue('mail2customer');
		*/
		   
		    $all_forms = new all_forms;
            $all_forms->update_settings($form_id, $settings);
            $form->message = 'gespeichert';
			
        }

        // render form
        $content['settings_form'] = $form->smarty_html($this);

        return $content;
    }

}
?>
