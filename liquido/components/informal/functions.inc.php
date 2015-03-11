<?php

function informal_deleteform()
{
    global $smarty;
    $content_array['delete_link'] = 'body.php?setmode=deleteform';
    $smarty->assign($content_array);
    $smarty->display('deleteform.tpl');
}

function informal_formlist()
{
    $formlist = informal_embed_formlist();
    
    foreach($formlist as $form) {
        $form['url'] = 'body.php?select[id]=' . $form['id'];
        $content_array['forms'][] = $form;
    }
    global $smarty;
    $smarty->assign($content_array);
    $smarty->display('formlist.tpl');
    
    informal_newform();
}

function informal_newform()
{
    global $smarty;
    $content_array['newform_link'] = 'body.php?setmode=newform';
    $smarty->assign($content_array);
    $smarty->display('newform.tpl');
}

?>