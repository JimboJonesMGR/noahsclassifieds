<?php
global $lll;
// ControlPanel:
$lll["purchaseItem"]="Purchase items";
$lll["purchaseItemDescription"]="Create the credit and subscription packages your users can buy, in order to use the program.";
$lll["pendingPurchaseItems"]="Pending purchases";
$lll["pendingPurchaseItemsDescription"]="Some description";
$lll["ecommSettings"]="E-commerce settings";
$lll["ecommsettings_model"]="Select E-commerce model";
$lll["ecommsettings_model_".ecomm_simple]="Simple";
$lll["ecommsettings_model_".ecomm_advanced]="Advanced";
$lll["ecommsettings_model_expl"]="With the 'Simple' model, you can set up the program so that the users must pay for submitting ads directly during the ad submission itself.<br><br>
With the 'Advanced' model, you can set up a credit based, or subscription based system (or you can even apply both at once).";
$lll["ecommSettingsDescription"]="Select the used eCommerce model, set up the purchase form fields and the price display formatting. Configure the payment processing gateways.";
// PurchaseItem:
$lll["purchaseitem_sortingsaved"]="The new purchase item sorting has been successfully saved.";
// ECommSettings:
$lll["priceSection"]="Price display formatting";
$lll["ecommsettings_modify_form"]="Modify E-commerce settings";
$lll["ecommsettings_currency"]="Currency";
$lll["ecommsettings_currency_expl"]="Three letter curency code. Necessary for the payment processing gateway.";
$lll["ecommsettings_currencySymbol"]="Currency symbol";
$lll["ecommsettings_currencySymbol_expl"]="Necessary for the payment processing gateway.";
$lll["ecommsettings_formatPrefix"]="Prefix";
$lll["ecommsettings_formatPrefix_expl"]="Anything you enter here will preceed the price values. (This is usually either the 'Currency' or the 'Currency symbol' from above!)";
$lll["ecommsettings_formatPostfix_expl"]="Anything you enter here will follow the price values.";
$lll["ecommsettings_type"]="E-commerce business model";
$lll["ecommsettings_type_".ecomm_credit]="Credit based";
$lll["ecommsettings_type_".ecomm_subscription]="Subscription based";
$lll["ecommsettings_type_".ecomm_both]="Both";
$lll["ecommsettings_expNoticeBefore_subscription"]="Number of days the user must be informed about the expiration of his/her paid subscription before";
$lll["ecommsettings_expNoticeBefore_subscription_expl"]="Also, when the user has less than this number of days left from the subscription, whenever he logs in, he will be forvarded to the purchase page.<br><br>Set it to 0 to disable this feature!";
$lll["ecommsettings_expNoticeBefore_credits"]="When the user goes below this number of credits, he/she will be advised by mail to buy more credits";
$lll["ecommsettings_expNoticeBefore_credits_expl"]="Also, when the user has less than this number of credits left, whenever he logs in, he will be forvarded to the purchase page.<br><br>Set it to 0 to disable this feature!";
$lll["ecommsettings_purchaseFormFields"]="Purchase form fields";
$lll["ecommsettings_purchaseFormFields_expl"]="You can preview the purchase form if you log in as 'ecommtest' (password: 'a'), 
click on 'Purchase' then try to buy one of the items.<br><br>You can change the order of the fields by drag and drop.<br><br>
Some further notes:<ul>
<li>On the merchant interface of your payment processing service, you can set it so that an email receipt will be sent to the user upon the successfull payment. 
If you intend to use this feature of the payment processing service, you should include the 'Email' field in the purchase form.</li>
<li>If you use an Address Verification Service of your payment processor, you must include the 'Address' and 'Zip' fields.</li>
<li>Whether the user details fields are optional, or required, it depends on the payment processing service. E.g.: they are optional in the Authorize.NET AIM, but the Address, City, State, Zip and Country are required in Paypal Website Payments Pro!</li>
</ul>
Users need not fill out the whole purchase form every time they buy something if you establish a link between the purchase form fields and 
their corresponding user registration form fields. You can do that in the custom field modify form of the corresponding user custom field.<br><br>
If you select a simple Integration Method below (e.g. SIM in Authorize.NET, or Website Payments Standard in PayPal), you wont's have a purchase form on your Noah's site actually. Instead, the purchase form will be hosted on the secure site of the payment processing service. In this case, you may have to also configure the form fields on the Merchant Interface of the processing service itself!";
// UserField:
$lll["userfield_ecommAssignment"]="Use this field to pre-populate the following purchase form field";
$lll["userfield_ecommAssignment_expl"]="Users need not fill out the whole purchase form every time they buy something if you establish a link between the purchase form fields and their corresponding user registration form fields.<br><br>Note: although you can create custom user fields for the card number, card expiration and card code, too, it is not really advised from security point of view!";
$lll["userfield_ecommAssignment_".ecomm_none]="-- None --";
$lll["ecommsettings_purchaseFormFields_".ecomm_firstName]=$lll["userfield_ecommAssignment_".ecomm_firstName]="First name";
$lll["ecommsettings_purchaseFormFields_".ecomm_lastName]=$lll["userfield_ecommAssignment_".ecomm_lastName]="Last name";
$lll["ecommsettings_purchaseFormFields_".ecomm_address]=$lll["userfield_ecommAssignment_".ecomm_address]="Address";
$lll["ecommsettings_purchaseFormFields_".ecomm_city]=$lll["userfield_ecommAssignment_".ecomm_city]="City";
$lll["ecommsettings_purchaseFormFields_".ecomm_state]=$lll["userfield_ecommAssignment_".ecomm_state]="State";
$lll["ecommsettings_purchaseFormFields_".ecomm_zip]=$lll["userfield_ecommAssignment_".ecomm_zip]="Zip";
$lll["ecommsettings_purchaseFormFields_".ecomm_country]=$lll["userfield_ecommAssignment_".ecomm_country]="Country";
$lll["ecommsettings_purchaseFormFields_".ecomm_phone]=$lll["userfield_ecommAssignment_".ecomm_phone]="Phone";
$lll["ecommsettings_purchaseFormFields_".ecomm_fax]=$lll["userfield_ecommAssignment_".ecomm_fax]="Fax";
$lll["ecommsettings_purchaseFormFields_".ecomm_email]=$lll["userfield_ecommAssignment_".ecomm_email]="Email";
$lll["ecommsettings_purchaseFormFields_".ecomm_cardName]=$lll["userfield_ecommAssignment_".ecomm_cardName]="Name on card";
$lll["ecommsettings_purchaseFormFields_".ecomm_cardNumber]=$lll["userfield_ecommAssignment_".ecomm_cardNumber]="Card number";
$lll["ecommsettings_purchaseFormFields_".ecomm_cardExp]=$lll["userfield_ecommAssignment_".ecomm_cardExp]="Card expiration";
$lll["ecommsettings_purchaseFormFields_".ecomm_cardCode]=$lll["userfield_ecommAssignment_".ecomm_cardCode]="Card code";
$lll["ecommsettings_purchaseFormFields_".ecomm_cardType]=$lll["userfield_ecommAssignment_".ecomm_cardType]="Card type";
$lll["ecommsettings_purchaseFormFields_".ecomm_startDate]=$lll["userfield_ecommAssignment_".ecomm_startDate]="Month and year that Maestro or Solo card was issued, the MMYYYY format";
$lll["ecommsettings_purchaseFormFields_".ecomm_issueNumber]=$lll["userfield_ecommAssignment_".ecomm_issueNumber]="Issue number of Maestro or Solo card";
$lll["presentUsers"]="Present users with credits or days";
$lll["ecommsettings_presentCredits"]="Number of credits";
$lll["ecommsettings_presentCredits_expl"]="With this, you can add gift credits to every users' credit pool. This is especially useful if you have updated your installation to the E-commerce edition and you want to give a starter credit pack to your old users.";
$lll["ecommsettings_presentDays"]="Number of days";
$lll["ecommsettings_presentDays_expl"]="With this, you can add gift days to every users' paid subscription. This is especially useful if you have updated your installation to the E-commerce edition and you want to give a starter subscription period to your old users.";
$lll["daysSuccessfullyAdded"]="The days have been successfully added.";
$lll["creditsSuccessfullyAdded"]="The credits have been successfully added.";
$lll["clickToAdd"]="Click here to add";
// CreditRules:
$lll["creditRules"]=$lll["creditrule_ttitle"]="Credit rules";
$lll["creditRulesDescription"]="Create and manage the credit rules of the advanced eCommerce model.";
$lll["selectRuleField"]="-- Select field --";
$lll["interactionTexts"]="Texts to interact with the users";
$lll["creditrule"]="Credit rule";
$lll["ecommrule_action"]="Action";
$lll["creditrule_action_expl"]="The user action this rule is all about. E.g.:
<ul>
<li>Select 'Registration' to create a rule like \"Users get 10 credits after the registration, so that they have a starter credit pool.\"<br><br></li>
<li>Select 'Ad submission' to create a rule like \"The ad submission in category 'A' costs 2 credits for the users.\"<br><br></li>".
//<li>Select 'Ad prolong' to create a rule like \"Every ad prolong costs 1 credit for its owner.\"<br><br></li>
//<li>Select 'Ad view' to create a rule like \"Every time the details page of an ad is displayed, it costs 1 credit for its owner.\"<br><br></li>
//<li>Select 'Ad reply' to create a rule like \"Every time an ad is replied, it costs 1 credit for its owner.\"<br><br></li>
"<li>Select 'Set field' to create a rule like \"The upload of a Picture costs 1 credit for the user during the ad submission.\"<br><br></li>
<li>Select 'Set field to value' to create a rule like \"The user can set his ad to featured (e.g. he can check an 'Is featured' field) for an additional cost.\". It is also possible to assign different costs to different ad expiration times.<br><br></li>
</ul>";
$lll["ecommrule_action_0"]="-- Select action --";
$lll["creditrule_action_".rule_registration]="Registration";
$lll["ecommrule_action_".rule_submit]="Ad submission";
$lll["creditrule_action_".rule_prolong]="Ad prolong";
$lll["creditrule_action_".rule_view]="Ad view";
$lll["creditrule_action_".rule_reply]="Ad reply";
$lll["ecommrule_action_".rule_setFieldToValue]="Set field to value";
$lll["ecommrule_action_".rule_setField]="Set field";
$lll["creditrule_consumption"]="Credit consumption";
$lll["creditrule_consumption_expl"]="How many credits do you want that the action consumes. If you enter a negative number, the user will actually be rewarded for the action! E.g. '-10' for 'Registration' means, the user gets 10 credits on the registration.";
$lll["ecommrule_cid"]="Category";
$lll["ecommrule_cid_expl"]="The category the rule is applied in";
$lll["ecommrule_includeSubcats"]="Including the sub categories";
$lll["ecommrule_includeSubcats_expl"]="Checking this field means: apply this rule in the above selected category and in all of its sub categories.";
$lll["ruleField"]="Field";
$lll["ruleField_expl"]="The field you want to charge the user for if he or she sets it.";
$lll["ruleValue"]="Value";
$lll["ruleValue_expl"]="The field value you want to charge the user for if he or she sets the field just to this value.";
$lll["creditrule_viewNum"]="Number of views";
$lll["creditrule_viewNum_expl"]="How many viewes should consume that many credits you set above?";
$lll["creditrule_replyNum"]="Number of replies";
$lll["creditrule_replyNum_expl"]="How many replies should consume that many credits you set above?";
$lll["ecommrule_confirmationTextType"]="Customize confirmation text?";
$lll["ecommrule_confirmationText"]="Confirmation text";
$lll["ecommrule_confirmationTextType_".rule_generic]=$lll["creditrule_successTextType_".rule_generic]=$lll["creditrule_failTextType_".rule_generic]="Use the generic text";
$lll["ecommrule_confirmationTextType_".rule_customized]=$lll["creditrule_successTextType_".rule_customized]=$lll["creditrule_failTextType_".rule_customized]="Use a customized text";
$lll["ecommrule_confirmationTextType_expl"]="If the user is about to do something that consumes credits, a confirmation box can be popped up. Per default, this is just a generic text that warns about the credit consumption and asks the user to click 'Ok' to continue.";
$lll["ecommrule_confirmationText_expl"]="You can specify here a custom confirmation text that belongs to this rule. If you leave it blank, no confirmation will take place at all!";
$lll["creditrule_successTextType"]="Customize text on success?";
$lll["creditrule_successText"]="Text on success";
$lll["creditrule_successTextType_expl"]="If credits have been added or subtracted succesfully, a popup box will notify the user about this. Per default, this is just a generic text that reports the credit consumption/reward.";
$lll["creditrule_successText_expl"]="You can specify here a custom success-text that belongs to this rule. Leave it blank to skip this notification.";
$lll["creditrule_failTextType"]="Customize text on fail?";
$lll["creditrule_failText"]="Text on fail";
$lll["creditrule_failTextType_expl"]="If the action fails because the user had not enough credits in his/her credit pool, a popup box will notify the user about this. Per default, this is just a generic text that reports the failure.";
$lll["creditrule_failText_expl"]="You can specify here a custom failure-text that belongs to this rule. This popup box can't be skipped - if you leave this blank, the generic text will be applied.";
$lll["creditrule_newitem"]="Add new credit rule";
$lll["creditrule_create_form"]="Create credit rule";
$lll["creditrule_modify_form"]="Modify credit rule";
$lll["creditrule_duplicateRule"]="Duplicate credit rule! A rule with the same parameters (action, category, field or value) already exists.";
$lll["regRuleMustbeNegative"]="The credit consumption of the 'Registration' can only be a negative number. (You can only add credits on registration!)";
// PaymentRules:
$lll["paymentRules"]=$lll["paymentrule_ttitle"]="Payment rules";
$lll["paymentRulesDescription"]="Create and manage the payment rules of the simple eCommerce model.";
$lll["paymentrule"]="Payment rule";
$lll["paymentrule_action_expl"]="The user action this rule is all about. E.g.:
<ul>
<li>Select 'Ad submission' to create a rule like \"The ad submission in category 'A' costs $2 for the users.\"<br><br></li>
<li>Select 'Set field' to create a rule like \"The upload of a Picture costs $1 for the user during the ad submission.\"<br><br></li>
<li>Select 'Set field to value' to create a rule like \"The user can set his ad to featured (e.g. he can check an 'Is featured' field) for an additional cost.\". It is also possible to assign different costs to different ad expiration times.<br><br></li>
</ul>";
$lll["paymentrule_consumption"]="Price";
$lll["paymentrule_consumption_expl"]="The price the action will cost to the users";
$lll["paymentrule_confirmationTextType_expl"]="If the user is about to do something that is not free of charge, a confirmation box can be popped up. Per default, this is just a generic text that warns about the amount being charged and asks the user to click 'Ok' to continue.";
$lll["paymentrule_newitem"]="Add new payment rule";
$lll["paymentrule_create_form"]="Create payment rule";
$lll["paymentrule_modify_form"]="Modify payment rule";
$lll["paymentrule_duplicateRule"]="Duplicate payment rule! A rule with the same parameters (action, category, field or value) already exists.";
// Misc.:
$lll["selectIntegrationMethod"] = "You must select an integration method!";
?>