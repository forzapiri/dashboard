<?php

require_once('../core/Image.php');
$im = new Image($_GET);
$im->render();

?>