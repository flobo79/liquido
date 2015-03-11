<?php

class admin_page_list extends admin_page
{
    var $headline = 'Welcome';
    var $name = 'list';

    function build_menu()
    {
    }

    function create_content_array()
    {
        $all_forms = new all_forms;
        $form_list = $all_forms->get_list();

        $page = new page;
        $admin_page = new admin_page;

        foreach ($form_list as $form) {
            $form['link'] = $page->build_link(NULL, $form['id']);
            $form['admin_link'] = $admin_page->build_link('editor', $form['id']);
            $form['delete_link'] = $admin_page->build_link('form_delete', $form['id']);
            $forms[] = $form;
        }

        $content['form_add_link'] = $this->build_link('form_add');
        $content['forms'] = $forms;
        return $content;
    }

}

?>
