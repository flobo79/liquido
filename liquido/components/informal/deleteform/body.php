<?php
$form_id = $_SESSION['informal']['form_id'];

if (informal_embed_formexists($form_id)) {
    $page = new admin_page_form_delete($fid);
    $page->display();
}
?>
