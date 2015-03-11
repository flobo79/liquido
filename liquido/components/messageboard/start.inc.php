<?php

include ("functions.inc.php");

$anz = getMessageInfo();

if($anz['unread']) echo $anz['unread']." ungelesen";


?>