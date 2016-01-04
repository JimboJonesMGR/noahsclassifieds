<?php
global $lll;
$GW = 'authorize_net';
$lll["{$GW}Section"]="Configure Authorize.NET";
$lll["ecommsettings_{$GW}_enabled"]="Enable Authorize.NET";
$lll["ecommsettings_{$GW}_user"]="Authorize.NET login ID";
$lll["ecommsettings_{$GW}_user_expl"]="Note that if you change the environment from test to live, you must also replace the test Login ID and Transaction Key with the live ones!";
$lll["ecommsettings_{$GW}_key"]="Authorize.NET transaction key";
$lll["ecommsettings_{$GW}_key_expl"]="Enter the transaction key you have received from Authorize.Net. To obtain the transaction
key from the Merchant Interface, do the following:
<ol>
<li>Log into the Merchant Interface,</li>
<li>Click on Settings,</li>
<li>Under the Security heading, click on 'API Login ID and Transaction Key',</li>
<li>You will be prompted to submit the Secret Question/Answer for the account in order to receive your
transaction key.</li>
</ol>";
$lll["ecommsettings_{$GW}_test"]="Test transactions only";
$lll["ecommsettings_{$GW}_test_expl"]="The second stage of the testing is when you use the live environment in test mode. You can do that by checking in this field.<br><br>The third stage is when you test live transactions in the live environment with a real credit card number. Note that to test live transactions, besides unchecking this field, you may also need to turn off the Test Mode in your Authorize.NET Merchant Interface!";
$lll["ecommsettings_{$GW}_merchantInterface_sim"]=$lll["ecommsettings_{$GW}_merchantInterface_aim"]="Authorize.NET Merchant Interface";
$lll["ecommsettings_{$GW}_merchantInterface_sim_expl"]="If you use the SIM method, you must also perform the following steps on your Merchant Interface (on its Settings page), in order to complete the configuration.";
$lll["{$GW}_merchantInterface_sim_details"]="
<ol>
<li>Set the 'Silent Post URL' to this:<br><b>%sprocess.php</b><br><br></li>
<li>Set the 'Receipt Link URL' to this:<br><b>%sreturn.php</b><br>
(Settings > Receipt Page > Receipt Method)<br><br></li>
<li>Set the 'Receipt Method' to 'POST' on the same page, and enter a Receipt Link Text<br><br></li>
<li>Configure the purchase form fields under Settings > Payment Form > Fields.<br><br></li>
<li>Set the 'MD5 Hash' value to the same that you set in the above 'MD5 Hash' field of this form. It can be any random text or number - the only important thing is that the values you enter there and here have to be really equal!<br><br></li>
<li>If you enabled the CVV2 code above, you must enable it on the Merchant Interface, too, under 'Card Code Verification'!<br><br></li>
<li>Make sure that you have enabled the 'Password-required mode'!</li>
</ol>
You can learn how to perform the above steps from the <a href='http://www.authorize.net/support/Merchant/default.htm' target='_blank'>Merchant Integration Guide</a> of Authorize.NET.
";
$lll["ecommsettings_{$GW}_merchantInterface_aim_expl"]="If you use the AIM method, you must also perform the following steps on your Merchant Interface (on its Settings page), in order to complete the configuration.";
$lll["{$GW}_merchantInterface_aim_details"]="
<ol>
<li>Set the 'Silent Post URL' to this:<br><b>%sprocess.php</b><br><br></li>
<li>Set the 'MD5 Hash' value to the same that you set in the above 'MD5 Hash' field of this form. It can be any random text or number - the only important thing is that the values you enter there and here have to be really equal!<br><br></li>
<li>If you enabled the CVV2 code above, you must enable it on the Merchant Interface, too, under 'Card Code Verification'!<br><br></li>
<li>Make sure that you have enabled the 'Password-required mode'!</li>
</ol>
You can learn how to perform the above steps from the <a href='http://www.authorize.net/support/Merchant/default.htm' target='_blank'>Merchant Integration Guide</a> of Authorize.NET.
";
$lll["ecommsettings_{$GW}_cvv2"]="Enable CVV2 code";
$lll["ecommsettings_{$GW}_cvv2_expl"]="If this option is enabled, a customer making a payment by a credit card has to
enter the CVV2 number at transaction time to verify that the card is present on hand. To configure the filter to
reject certain Card Code responses, do the following:
<ol>
<li>Log into the Merchant Interface,</li>
<li>Select 'Settings' from the Main Menu,</li>
<li>Click on the Card Code Verification link from the 'Security' section,</li>
<li>Check the box(es) next to the Card Codes that the system should reject,</li>
<li>Click Submit to save changes.
</ol>
";
$lll["ecommsettings_{$GW}_md5Hash"]="MD5 Hash number";
$lll["ecommsettings_{$GW}_md5Hash_expl"]="Enter the MD5 Hash Value to use the MD5 security checks. You have to set the
same MD5 Hash Value in your Merchant Interface:
<ol>
<li>Log into the Merchant Interface,</li>
<li>Select 'Settings' from the Main Menu,</li>
<li>Click on MD5 Hash in the 'Security' section,</li>
<li>Enter the MD5 Hash Value,</li>
<li>Confirm the MD5 Hash Value entered,</li>
<li>Click Submit to save changes.</li>
</ol>
";
$lll["ecommsettings_{$GW}_environment"]="Payment processing environment";
$lll["ecommsettings_{$GW}_environment_0"]="Developer test environment";
$lll["ecommsettings_{$GW}_environment_1"]="Live merchant environment";
$lll["ecommsettings_{$GW}_environment_expl"]="The payment processing is ideally tested in three stages. The first one is using an Authorize.Net developer test account. In order to use this environment, you must have an Authorize.Net developer test account with an associated API Login ID and Transaction Key. Test transactions to this environment are accepted with these credentials only. If you do not have a developer test account, you may sign up for one at <a href='http://developer.authorize.net' target='_blank'>http://developer.authorize.net</a>.<br><br><a href='http://developer.authorize.net/guides/AIM/Test_Transactions/Test_Transactions.htm' target='_blank'>Click here</a> for more details on testing Authorize.Net transactions!";
$lll["ecommsettings_{$GW}_integrationMethod"]="Integration method";
$lll["ecommsettings_{$GW}_integrationMethod_0"]="-- Select integration method --";
$lll["ecommsettings_{$GW}_integrationMethod_".ecomm_advancedIntegration]="Advanced Integration Method (AIM)";
$lll["ecommsettings_{$GW}_integrationMethod_".ecomm_simpleIntegration]="Server Integration Method (SIM)";
$lll["ecommsettings_{$GW}_integrationMethod_expl"]="There are two different methods to integrate a payment processing service into your site.
The decision basically depends on whether your server supports Secure Sockets Layer (SSL) and you have an SSL certificate. If it does and you have, 
AIM is the preferred way of the integration. With AIM, your customer can stay on your site during the payment process. The configuration of AIM is much simpler, too.
As opposed to this, in absence of an SSL certificate, you must choose the Server Integration Method. With SIM, the collection of credit card information occurs on the secure hosted payment form of the processing service itself<br><br>
Note: if your server doesn't supports SSL and you still select AIM, the purchase form will not be accessible!";
// Error texts:
$lll["securityCodeMismatch"]="Security code mismatch.";
?>
