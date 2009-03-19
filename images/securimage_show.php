<?php

include dirname(__FILE__) . '/../core/captchalib/securimage.php';

$img = new securimage();

$img->show(); // alternate use:  $img->show('/path/to/background.jpg');

?>
