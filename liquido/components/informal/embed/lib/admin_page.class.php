<?php

/*
note to myself, when creating a new admin page:
1. create a template 'themes/default/admin/page_<name>.tpl' based on default
2. create a new class 'lib/admin_page_<name>.class.php' based on default
(only var $name = '<name>' must be set)
3. add <name> to admin_page's $all array

*/

class admin_page extends page
{
    var $all = array(
        'default',
        'editor',
        'editor_add',
        'editor_edit',
        'editor_remove',
        'editor_move',
        'editorliquido',
        'email',
        'error',
        'form_add',
        'form_delete',
        'list',
        'settings',
        'start',
        'submissions',
    );

    var $area = 'admin';
    var $form_id = 0;
    var $headline = 'Admin';
    var $logged_in = true;
    var $name = 'default';
    var $template = 'page';
    var $title = 'Admin';
    var $design = 'admin';

    function build_menu()
    {
        $menu_items = array();
        #$menu_items[] = array('title' => 'Admin Home','link' =>
        #    $this->build_link('start'));
        $menu_items[] = array('title' => 'Form Editor','link' =>
            $this->build_link('editor'));
        $menu_items[] = array('title' => 'View Submissions','link' =>
            $this->build_link('submissions'));
        $menu_items[] = array('title' => 'Properties','link' =>
            $this->build_link('settings'));
        $menu_items[] = array('title' => 'Properties','link' =>
            $this->build_link('settings'));
        $menu_items[] = array('title' => 'Exit form editor','link' => './');
        return $menu_items;
    }

    function build_page_array()
    {
        // find out which content needs to be displayed.
        // if an admin_page_xyz class is called directly
        // there is no need to fetch the page name from the get
        // request.
        if ($this->name && $this->name != 'default' && !$_GET['p']) {
            $page = $this;
        } else {
            $page_name = $this->which_page();
            $class_name = 'admin_page_' . $page_name;
            $page = new $class_name;
        }

        // create content
        $content = $page->create_content();

        if ($this->logged_in) {
            $menu_items = $this->build_menu();
            $logout_link = $this->build_link('logout');
            $username = 'nobody';
        } else {
            $login_link = $this->build_link('login');
        }

        // add error message
        global $error_message;
        if ($error_message) {
            $error_html = $this->fetch_template('error', array('message' =>
                $error_message));
            $content = $error_html . $content;
        }

        $vars['headline'] = $page->headline;
        $vars['content'] = $content;
        $vars['username'] = $username;
        $vars['logout_link']= $logout_link;
        $vars['menu_items'] = $menu_items;
        $vars['login_link'] = $login_link;

        return $vars;
    }

}

?>
