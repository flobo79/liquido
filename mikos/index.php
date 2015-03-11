<?php
session_start();
session_destroy();

header('Location: docs/html/index.html');

?>