<?php
$form_id = $_SESSION['informal']['form_id'];

if (informal_embed_formexists($form_id)) {
    $page = new admin_page_settings();
    $page->display();
    informal_newform();
    informal_deleteform();
} else {
    informal_formlist();
}
?>
