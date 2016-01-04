<?php
global $lll;
$GW = 'authorize_net';
$lll["purchase_paymentMethod_{$GW}"]="Authorize.NET";
// AIM response texts:
// If you want to translate the response texts that Authorize.NET returns, you can do that 
// here based on their response reason codes. Check out the following page for the list of codes and the 
// corresponding English texts: 
// http://developer.authorize.net/guides/AIM/Transaction_Response/Response_Reason_Codes_and_Response_Reason_Text.htm
// You can override the response texts using language string definitions like the below three examples:
$lll["{$GW}_errorText_1"]="This transaction has been approved.";
$lll["{$GW}_errorText_5"]="A valid amount is required.";
$lll["{$GW}_errorText_6"]="The credit card number is invalid.";
// etc.
?>
