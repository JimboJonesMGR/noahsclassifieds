<?php
global $lll;
$GW = 'paypal';
$lll["purchase_paymentMethod_{$GW}"]="PayPal";
// Website Payment Pro response texts:
// If you want to translate the response texts that PayPal returns, you can do that 
// here based on their error codes. Check out the following page for the list of codes and the 
// corresponding English texts: 
// https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_errorcodes
// You can override the response texts using language string definitions like the below three examples:
$lll["{$GW}_errorText_10002"]="Authentication/Authorization Failed. Username/Password is incorrect";
$lll["{$GW}_errorText_10536"]="Invalid Data. This transaction cannot be processed.";
$lll["{$GW}_errorText_10534"]="Gateway Decline. This transaction cannot be processed. Please enter a valid credit card number and type.";
// etc.
?>
