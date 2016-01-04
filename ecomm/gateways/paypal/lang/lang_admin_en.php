<?php
global $lll;
$GW = 'paypal';
$lll["{$GW}Section"]="Configure PayPal";
$lll["ecommsettings_{$GW}_enabled"]="Enable PayPal";
$lll["ecommsettings_{$GW}_integrationMethod"]="Integration method";
$lll["ecommsettings_{$GW}_integrationMethod_0"]="-- Select integration method --";
$lll["ecommsettings_{$GW}_integrationMethod_".ecomm_advancedIntegration]="Website Payments Pro with direct payment";
$lll["ecommsettings_{$GW}_integrationMethod_".ecomm_simpleIntegration]="Website Payments Standard";
$lll["ecommsettings_{$GW}_integrationMethod_expl"]="There are two different methods to integrate a PayPal into your site.
With Website Payments Standard, only registered PayPal users can purchase, while anyone with a credit card can purchase if you choose Website Payments Pro. 
With Website Payments Standard, the checkout process occurs on the PayPal site, while the Pro integration makes it possible that the users don't leave your site during the payment process.
Because the credit card details are geathered on your site during the direct payment, you will need an SSL certificate, in order to apply this option securely!
Note: if your server doesn't supports SSL and you still select Pro, the purchase form will not be accessible!";
$lll["ecommsettings_{$GW}_user"]="PayPal business name";
$lll["ecommsettings_{$GW}_user_expl"]="The email address you use to log in to PayPal.";
$lll["ecommsettings_{$GW}_environment"]="Payment processing environment";
$lll["ecommsettings_{$GW}_environment_0"]="Test environment (sandbox)";
$lll["ecommsettings_{$GW}_environment_1"]="Live environment";
$lll["ecommsettings_{$GW}_apiUser"]="API user name";
$lll["ecommsettings_{$GW}_apiUser_expl"]="The API user name, password and signature are together called 'API credentials'. 
<a href='https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_WPNVPAPIBasics#id084E30I30RO' target='_blank'>Click here</a> to learn more about how to retrieve the API credentials!<br><br>
Please note, that you need to obtain different credentials for the live and the test environment!";
$lll["ecommsettings_{$GW}_apiPassword"]="API password";
$lll["ecommsettings_{$GW}_apiSignature"]="API signature";
$lll["ecommsettings_{$GW}_cvv2"]="Enable CVV2 code";
$lll["ecommsettings_{$GW}_cvv2_expl"]="If this option is enabled, a customer making a payment by a credit card has to
enter the CVV2 number at transaction time to verify that the card is present on hand. Note that you must enable the CVV2 number checking in your PayPal merchant account, too, if you want to use this option!";
$lll["wrongReceiverEmail"]="Suspicious: wrong receiver email: %s";
$lll["{$GW}ConnectFailed"]="Failed to open connection to PayPal to verify the transaction.";
$lll["ipnValidationFailed"]="IPN validation failed.";
?>
