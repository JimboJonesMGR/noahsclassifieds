<?php

require_once('recaptchalib.php');


$settings = new AppSettings;

$publickey = $settings->recaptchaPublicKey;  // you got this from the signup page
echo recaptcha_get_html($publickey);

?>