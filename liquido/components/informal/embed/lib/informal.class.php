<?php

class informal
// a class to control a selected form
{
    var $database_object = null;
    var $form_elements = array();
    var $id;
    var $name;
    var $thank_you_message;
    var $thank_you_url;
	var $redirect;
	var $mail2customer;
	var $mail2customer_addressfieldid;
	var $mail2customer_sender;
	var $mail2customer_returnmail;
	var $mail2customer_subject;
	var $mail2admin;
	var $mail2admin_returnmail;
	var $mail2admin_subject;
	var $mail2admin_email;

    function informal($id = 0)
    {
        if (!$id) $id = $GLOBALS['informal_form_id'];
        $this->id = intval($id);
        $this->db_obj = new database();
        $this->load_form_elements_from_db();
        $this->load_preferences_from_db();
		
		//print_r($this);
    }

    function add_form_element($element, $options = array())
    {
        $form_element = new form_element($element);

        // get an unused form element id
        $new_id = $this->get_fresh_id();

        // trim empty options from the bottom for multiple options fields
        if ($options['options']) $options['options'] =
            $this->trim_multiple_options($options['options']);

        // add data to new form element object
        $form_element->data = array(
            'id' => $new_id,
            'type' => $element->name,
            'options' => $options);

        // add new form element to database
        $this->form_elements[] = $form_element;
        $this->store_form_elements_to_db();
    }

    function add_submission($form)
    {
		
		// pack submitted data as wddx and write them to db
        $collector_elements = $this->get_collector_elements();
        $form_data = array();
		
        foreach ($collector_elements as $element) {
            $e_id = $element->data['id'];
            $data = $form->getElementValue(INFORMAL_FORM_ELEMENT_NAME_PREFIX . $e_id);
			$form_data[$e_id] = $data;
        }
		
		// quick and dirty
		// set searches and replaces
		// use the form object for convenience reasons
		foreach ($form->_elements as $element) {

			switch($element->_type) {
				default:
					$searches[] = "#".$element->_attributes['name'];
					$replaces[] = $element->_value;
					break;
					
				 case "select":
					$searches[] = "#".$element->_attributes['name'];
					$replaces[] = $element->_options[$element->_values[0]]['text'];
					break;
				
				case "text":
					$searches[] = "#".$element->_attributes['name'];
					$replaces[] = $element->_attributes['value'];
					break;
				
				case "checkbox":
					$searches[] = "#".$element->_attributes['name'];
					$replaces[] = $element->_text;
					break;
					
				 case "group":
				 	$searches[] = "#".$element->_name;
					foreach($element->_elements as $block) {
						if($block->_attributes['checked']) {
							$replaces[] = $block->_text;
						}
					}
					break;
			}
		}
		
        $wddx = wddx_pack($form_data);
        $this->db_obj->insert_row('submissions', array('form' => $this->id
            , 'last_edit' => time(), 'timestamp' => time()
            , 'data' => addslashes($wddx)));
		
		//print_r($this);
		$mail2customer = str_replace($searches,$replaces,$this->mail2customer);
		$mail2admin = str_replace($searches,$replaces,$this->mail2admin);
		
		
		
		// send mails to participients
		if($this->mail2customer and $tomail = $form_data[$this->mail2customer_addressfieldid]) {
			mail($tomail,$this->mail2customer_subject,$mail2customer,"from: $mail2customer_sender <$mail2customer_returnmail>");
		}
		
		if($this->mail2admin) {
			mail($this->mail2admin_email,$this->mail2admin_subject,$mail2admin,"from: liquido <".$this->mail2admin_returnmail.">");
		}		
		
		// redirect if wanted
		if($this->redirect and $this->thank_you_url) header("location:".$this->thank_you_url);

    }

    function get_submissions_from_db($id)
    {
        return $this->db_obj->fetch_rows('submissions',0,0,'form',$this->id);
    }

    function forms($page, $editor = false)
    {
        $form_elements = $this->form_elements;

        // create a form object
        $action = INFORMAL_URLBASE . '?f=' . $GLOBALS['informal_form_id'].'&amp;page='.$_GET['page'];
        $form = new form('informal', NULL, $action);

        // add data to elements
        foreach($form_elements as $fe) {

            $content_input['id'] = $fe->data['id'];

            // check if form is shown in editor mode
            if ($editor) {
    
                // disable form fields
                $disabled = true;

                // add links and other things
                // FIXME: there must be nicer ways to do the links

                // copy form element data to content input array
                $content_input = $fe->data;

                if (!$fe->element->has_no_options) {
                    $content_input['edit_link'] = $page->build_link('editor_edit')
                    . '&amp;id=' . $fe->data['id'];
                }
    
                $content_input['move_up_link'] = $page->build_link('editor_move')
                    . '&amp;id=' . $fe->data['id'] . '&amp;d=u';
    
                $content_input['move_down_link'] = $page->build_link('editor_move')
                    . '&amp;id=' . $fe->data['id'] . '&amp;d=d';
    
                $content_input['remove_link'] = $page->build_link('editor_remove')
                    . '&amp;id=' . $fe->data['id'];
    
                $content_input['type_title'] = $fe->element->title;
            }

            // render html for form element
            $content_input['html'] = $fe->html($disabled, $page, $form);

            $form_elements_array[] = $content_input;
        }

        // create two types of forms
        // 1. the informal form with all additional design
        // 2. a quickform with data collecting elements only

        $forms['informal'] = $form_elements_array;
        $forms['quickform'] = $form;

        return $forms;
    }

    function get_collector_elements()
    {
        $collector_elements = array();
        foreach ($this->form_elements as $element) {
            if ($element->element->collects_input) {
                $collector_elements[] = $element;
            }
        }
        return $collector_elements;
    }
    
    function get_fresh_id()
    {
        // get last element id
        $fresh_id = $this->db_obj->fetch_field('registry', '1', 'elements_last_id');
        // increment id counter
        $this->db_obj->write_field('registry', '1', 'elements_last_id', $fresh_id + 1);
        return $fresh_id;
    }

    function get_form_element_by_id($id)
    {
        foreach ($this->form_elements as $form_element) {
            if ($form_element->data['id'] == $id) {
                return $form_element;
                break;
            }
        }
    }

    function get_form_element_by_position($position)
    {
        foreach ($this->form_elements as $form_element) {
            if ($form_element->position == $position)
                return $form_element;
        }
    }

    function load_form_elements_from_db()
    {
        // read wddx containing the elements array from db
        $wddx = $this->db_obj->fetch_field('forms', $this->id, 'elements');
        if ($wddx) {
            $array = wddx_unpack($wddx);
            foreach ($array as $index => $data) {
                $element = element::create_object($data['type']);
                $object = new form_element($element);
                $object->position = $index;
                $object->data = $data;
                $this->form_elements[] = $object;
            }
        }
    }

    function load_preferences_from_db()
    {
        $this->name = $this->db_obj->fetch_field('forms', $this->id,
            'name');
        $this->thank_you_message = $this->db_obj->fetch_field('forms', $this->id,
            'thank_you_message');
        $this->thank_you_url = $this->db_obj->fetch_field('forms', $this->id,
            'thank_you_url');
		$this->redirect = $this->db_obj->fetch_field('forms', $this->id,
            'redirect');
		$this->mail2customer = $this->db_obj->fetch_field('forms', $this->id,
            'mail2customer');
		$this->mail2customer_addressfieldid = $this->db_obj->fetch_field('forms', $this->id,
            'mail2customer_addressfieldid');
		$this->mail2customer_subject = $this->db_obj->fetch_field('forms', $this->id,
            'mail2customer_subject');
		$this->mail2customer_returnmail = $this->db_obj->fetch_field('forms', $this->id,
            'mail2customer_returnmail');
		$this->mail2customer_sender = $this->db_obj->fetch_field('forms', $this->id,
            'mail2customer_sender');

		$this->mail2admin = $this->db_obj->fetch_field('forms', $this->id,
            'mail2admin');
		$this->mail2admin_returnmail = $this->db_obj->fetch_field('forms', $this->id,
            'mail2admin_returnmail');
		$this->mail2admin_subject = $this->db_obj->fetch_field('forms', $this->id,
            'mail2admin_subject');
		$this->mail2admin_email = $this->db_obj->fetch_field('forms', $this->id,
            'mail2admin_email');
		
    }

    function move_form_element($id, $move_number)
    {
        $form_element = $this->get_form_element_by_id($id);

        $old_position = $form_element->position;
        $new_position = $old_position + $move_number;

        // don't let anyone fall off the edge
        $max = count($this->form_elements) - 1;
        if ($new_position < 0) $new_position = 0;
        if ($new_position > $max) $new_position = $max;

        // swap old and new position
        $temp = $this->form_elements[$new_position];
        $this->form_elements[$new_position] = $this->form_elements[$old_position];
        $this->form_elements[$old_position] = $temp;
        $this->store_form_elements_to_db();
    }

    function remove_element($id)
    {
        // loop through elements and push all elements except the one
        // that needs to be removed into a new array
        foreach ($this->form_elements as $element) {
            if ($element->data['id'] != $id) {
                $elements_left[] = $element;
            }
        }
        $this->form_elements = $elements_left;
        $this->store_form_elements_to_db();
    }

    function store_form_elements_to_db()
    {
        // pack form_elements as wddx and write them to db
        foreach ($this->form_elements as $element) {
            $form_elements[] = $element->data;
        }
        $wddx = wddx_pack($form_elements);
        $this->db_obj->write_field('forms', $this->id, 'elements', addslashes($wddx));
    }

    function trim_multiple_options($options)
    {
        // trim empty array elements from the end
        foreach ($options as $dummy) {
            if (end($options) == '') array_pop($options);
            else break;
        }
        return $options;
    }


    function update_form_element_options($id, $new_options)
    {
        // trimm empty options at the end (for multiple collectors)
        if ($new_options['options']) $new_options['options'] =
            $this->trim_multiple_options($new_options['options']);

        //FIXME: this probably can be done nicely with references
        $fe = $this->get_form_element_by_id($id);
        $old_options =& $this->form_elements[$fe->position]->data['options'];
        $old_options = $new_options;
        $this->store_form_elements_to_db();
    }
    
}

?>
