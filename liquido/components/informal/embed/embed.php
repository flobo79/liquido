<?php

//
// embed informal in an alien environment
//
if (!defined('INFORMAL_EMBEDDED')) {
    
    function informal_embed($path_to_informal) {
        // where did the spaceship land? find out the file location of the
        // embedding script
            $path_to_embedder = str_replace(
                strrchr($_SERVER["SCRIPT_FILENAME"],"/"), '' ,
                $_SERVER["SCRIPT_FILENAME"]) . '/';
        
            define('INFORMAL_EMBEDDED', true);
            define('INFORMAL_SUBDIR', $path_to_informal);
        
            require_once($path_to_informal . 'bootstrap.php');
    }
    
    function informal_embed_all() {
        // FIXME: this needs to become re-usable code
        //        (also used in index.php)
        if ($_GET['a']) {
            $page = new admin_page;
        } else if ($_GET['f']) {
            $page = new form_page;
        } else {
            $page = new admin_page_list;
        }
        $page->display();
    }
    
    function informal_embed_formlist() {
        $all_forms = new all_forms;
        $form_list = $all_forms->get_list();
        return $form_list;
    }
    
    function informal_embed_formexists($form_id) {
        $all_forms = new all_forms;
        return $all_forms->form_exists($form_id);
    }
    
    function informal_embed_selectform($fid) {
        $GLOBALS['informal_form_id'] = intval($fid);
    }

}

?>
