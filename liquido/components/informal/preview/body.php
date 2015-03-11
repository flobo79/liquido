<?php
$form_id = $_SESSION['informal']['form_id'];

if (informal_embed_formexists($form_id)) {
    $page = new form_page(true);
    $page->display();
} else {
    informal_formlist();
}
?>
