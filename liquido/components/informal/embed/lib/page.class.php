<?php

class page
{

    var $design = 'admin';
    var $title = 'informal';
    var $template = 'page';
    var $theme = 'default';
    var $error_message;

    function build_menu()
    {
    }

    function build_link($page = false, $form_id = false)
    {
        $base = INFORMAL_URLBASE;
        $parameters = array();

        if ($form_id) {
            $parameters[] = 'f=' . $form_id.'&page='.$_GET['page'];
        } else if ($GLOBALS['informal_form_id'] != 0) {
            $parameters[] = 'f=' . $GLOBALS['informal_form_id'].'&page='.$_GET['page'];
        }

        if ($this->area) $parameters[] = 'a=' . $this->area;
        if ($page) $parameters[] = 'p=' . $page;

        $link = $base . '?' . implode($parameters, '&amp;');
        return $link;
    }

    function build_page_array()
    {
        $vars['headline'] = $this->title;
        return $vars;
    }

    function build_template_path($name)
    {
        $template_path = INFORMAL_FILEROOT . $this->build_theme_path()
            . $name . '.tpl';

        return $template_path;
    }

    function build_theme_path()
    {
        $theme_path = 'themes/' . $this->theme . '/' . $this->design . '/';
        return $theme_path;
    }

    function create_content()
    {
        $template_name = 'page_' . $this->name;
        $vars = $this->create_content_array();
        $content = $this->fetch_template($template_name, $vars);
        return $content;
    }

    function create_content_array()
    {
    }

    function display()
    {
        $title = $this->title . INFORMAL_PAGE_TITLE_SUFFIX;
        $theme_path = $this->build_theme_path();
        $template_path = $this->build_template_path($this->template);
        $css_path = INFORMAL_WEBROOT . $theme_path . 'styles.css';

        // build the page content variables
        $vars = $this->build_page_array();

        // set title
        $vars['title'] = $title;

        // set css
        $vars['css_link'] = $css_path;

        // render page, embedded or not?
        if (INFORMAL_EMBEDDED) {
            $html = $vars['content'];
        } else {
            $html = $this->fetch_template($this->template, $vars);
        }

        // tada! the page has been rendered and now we send it to the
        // browser
        print $html;
    }
    
    function error($message = 'Unknown Error', $fatal = false)
    {
        if ($fatal) {
            // throw raw error and abort execution
            print 'informal Error: ' . $message;
            exit;
        } else {
            global $error_message;
            $error_message = $message;
        }
    }
    
    function fetch_get($parameter, $fatal = true)
    {
        if ($_GET[$parameter]) {
            return $_GET[$parameter];
        } else if($fatal) {
            page::error('Internal error (necessary GET parameter "'
                . $parameter . '" not given)', true);
        }
    }
    
    function fetch_post($parameter, $fatal = true)
    {
        if ($_POST[$parameter]) {
            return $_POST[$parameter];
        } else if($fatal) {
            page::error('Internal error (necessary POST parameter "'
                . $parameter . '" not given)', true);
        }
    }

    function fetch_template($name, $array = array())
    {
        $smarty = new MY_smarty();
        $smarty->assign($array);
        $path = $this->build_template_path($name);
        return $smarty->fetch($path);
    }

    function redirect($url)
    {
        header("Location: $url");
    }

    function which_page()
    {
        foreach ($this->all as $page_name) {
            if ($page_name == $_GET['p']) {
                $page = $page_name;
                break;
            }
        }
        if ($page) return $page;
        else return $this->name;
    }

}
?>
