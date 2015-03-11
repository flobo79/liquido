<?php

ob_start();
include ("../../lib/init.php");
include($path."../../lib/fnc_frontend.inc.php");

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
<link rel="stylesheet" type="text/css" href="../../css/liquidoo.css" />
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<link rel="stylesheet" type="text/css" href="css/liquido.css" />
<title>liquido</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

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
        print '<li><a href="' . $link . '" target="middle">'
            . $form['name'] . '</a></li>' . "\n";
    }
    ?>
    </ul>
</div>
<div class="left_pane_bottom"></div>

</body>
</html>
<?php ob_end_flush(); ?>
