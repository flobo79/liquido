<?php

class all_forms
// a class to control the form registry
{
    var $forms = array();

    function add_form($name)
    {
        $fields['name'] = $name;
        $db = new database;
        $insert_id = $db->insert_row('forms', $fields);
        return $insert_id;
    }

    function delete_form($form_id)
    {
        $db = new database;
        $db->delete_row('forms', $form_id);
    }

    function form_exists($form_id)
    {
        $db = new database;
        $forms = $this->get_list();
        foreach ($forms as $form) {
            if ($form['id'] == $form_id) {
                $exists = true;
                break;
            }
        }
        return $exists;
    }

    function get_list()
    {
        $db = new database;
        $forms = $db->fetch_rows('forms', array('id', 'name'), 'name');
        return $forms;
    }

    function update_settings($form_id, $settings)
    {
        $db = new database;
        $db->update_row('forms', $form_id, $settings);
    }

}

?>