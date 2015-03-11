<?php

include ("../../lib/init.php");
include ("../../lib/parser.php");
include ("functions.inc.php");
//
// set form_id if there is a get parameter given
//
$form_id = $_GET['select']['id'];

// if deleteform is selected and form is switched
// show details, not delete form
if (($_GET['select']['id']) && (($_SESSION['components'][$comp]['current'] == "deleteform") || $_SESSION['components'][$comp]['current'] == "newform")) {
    $_SESSION['components'][$comp]['current'] = "detail";
}
// qick hack for cancel at new form page
if ($_SESSION['components'][$comp]['current'] == "newform"
    && $_POST['cancel']) {
    $_SESSION['components'][$comp]['current'] = "detail";
    unset($_POST);
}
// qick hack for cancel at delete form page
if ($_SESSION['components'][$comp]['current'] == "deleteform"
    && $_POST['cancel']) {
    $_SESSION['components'][$comp]['current'] = "detail";
    unset($_POST);
}

// if a form_id is given via get write id to session
if ($form_id) {
    $_SESSION['informal']['form_id'] = $form_id;
} else {
    $form_id = $_SESSION['informal']['form_id'];
}

// if no mode is selected show detail view
if (!$_SESSION['components'][$comp]['current']) {
    $_SESSION['components'][$comp]['current'] = "detail";
}

$mode = $_SESSION['components'][$comp]['current'];

// render body
include ($mode . "/functions.inc.php");
include ("tpl_head.php");
informal_embed_selectform($form_id);
include ($mode . "/body.php");
include ("tpl_footer.php");

?>
