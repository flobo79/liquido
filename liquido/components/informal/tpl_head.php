<?php

ob_start();

//
// include "informal_embed_" functions
//
$path_to_informal = 'embed/';
include($path_to_informal . 'embed.php');
informal_embed($path_to_informal);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../../css/liquidoo.css" />
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<link rel="stylesheet" type="text/css" href="css/liquido.css" />
<title>liquido</title>
</head>

<body>

<div id="informal_main-content">

<div class="left_pane">
  <div class="left_pane_top"></div>
  <div class="left_pane_content">
    <h3>Formulare</h3>
    <ul>
<?php

$form_list = informal_embed_formlist();
$page = new page;
$admin_page = new admin_page;

foreach ($form_list as $form) {
    $link =  'body.php?select[id]=' . $form['id'];
    print '    <li><a href="' . $link . '">'
        . $form['name'] . '</a></li>' . "\n";
}

?>
    </ul>
  </div>
  <div class="left_pane_bottom"></div>
</div>

<div id="informal_workspace">