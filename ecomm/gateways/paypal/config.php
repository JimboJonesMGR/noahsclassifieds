<?php
$GW = 'paypal';

// The gateway host URL where the processing occurs:
${"processorPages_$GW"} = array(
    ecomm_test=>array(
        ecomm_simpleIntegration=>"https://www.sandbox.paypal.com/cgi-bin/webscr",
        ecomm_advancedIntegration=>"https://api-3t.sandbox.paypal.com/nvp"
    ),    
    ecomm_live=>array(
        ecomm_simpleIntegration=>"https://www.paypal.com/cgi-bin/webscr",
        ecomm_advancedIntegration=>"https://api-3t.paypal.com/nvp"
    )    
);

// The host of the IPN verification:
${"responseValidationHosts_$GW"} = array(
    ecomm_test=>"https://www.sandbox.paypal.com/cgi-bin/webscr",
    ecomm_live=>"https://www.paypal.com/cgi-bin/webscr"
);

// The fileds credit card details fields that will appear in the purchase form in case of the advanced integration.
// They may depend on the payment gateway. The possible values are:
// "countryCode": The country code is mandatory in PayPal and this field displays a drop down list of all the countries, in order to select the proper code,
//                Note that this is not the same as the "country" field of the purchase form! The Country field provides a country name which is not suitable for PayPal                  
// "cardDetails": This is just the separator of the card details section in the form,
// "cardName":    Name on card,
// "cardType":    Card type,
// "cardNumber":  Card number,
// "cardExp":     Card expiration,
// "startDate":   Start date,
// "issueNumber": Issue number,
${"creditCardDetailsFields_$GW"} = array("countryCode", "cardDetails", "cardType", "cardNumber", "cardExp");

// If cardType is included, the possible card types must be specified, too:
${"cardTypes_$GW"} = array("Visa", "MasterCard", "Discover", "Amex" );  // Other possibilities: "Maestro", "Solo"
// Note: we could add Maestro and Solo, too, but in that case, the currency must be GBP 
// and either 'startDate' or 'issueNumber' must be added to the credit card details fields!

// Using the following data construct, you can add gateway specific fields to the 'E-commerce settings' form.
// If you do that, admin can enable/disable the gateway and set all the other parameters necessary to
// process transactions from the admin interface. If you create a new gateway and don't want to make a new
// installation of the program, you have to add the necessary database fields that store the values of these
// parameters manually. In case of this gateway, it could be achieved with the following query:

/*
ALTER TABLE `ecommsettings` 
ADD `paypal_enabled`           INT( 11 ) NOT NULL DEFAULT '1',
ADD `paypal_integrationMethod` INT( 11 ) NOT NULL DEFAULT '0',
ADD `paypal_environment`       INT( 11 ) NOT NULL DEFAULT '0',
ADD `paypal_user`              VARCHAR( 255 ) NOT NULL
ADD `paypal_apiUser`           VARCHAR( 255 ) NOT NULL
ADD `paypal_apiPassword`       VARCHAR( 255 ) NOT NULL
ADD `paypal_apiSignature`      VARCHAR( 255 ) NOT NULL
*/

// In case of a new install, the install script creates the above fields automatically.
// If you add fields to the E-commerce settings form, you must define the corresponding
// language texts, too!. You can do that in the 'ecomm/gateways/<your_gateway>/lang/lang_admin.php' file.

${"settingsFormFields_$GW"} = array(
    $GW."Section"=>array(
        "type"=>"INT",
        "section",
        "no column",
    ),
    $GW."_enabled"=>array(
        "type"=>"INT",
        "bool",
        "default"=>"0",
        "show_relation"=>$GW
    ),
    $GW."_integrationMethod"=>array(
        "type"=>"INT",
        "selection",
        "mandatory",
        "values"=>array(0,1,2), //nothing selected, ecomm_advancedIntegration, ecomm_simpleIntegration
        "default"=>"0",  //nothing selected
        "relation"=>$GW,
        "show_relation"=>array(1=>$GW."_aim")
    ),
    $GW."_environment"=>array(
        "type"=>"INT",
        "radio",
        "default"=>"0", 
        "cols"=>"1", 
        "values"=>array(0,1), // ecomm_test, ecomm_live 
        "relation"=>$GW,
    ),
    $GW."_user"=>array(
        "type"=>"VARCHAR",
        "max"=>255,
        "min"=>1,
        "text",
        "mandatory",
        "relation"=>$GW,
    ),
    $GW."_apiUser"=>array(
        "type"=>"VARCHAR",
        "max"=>255,
        "min"=>1,
        "text",
        "mandatory",
        "relation"=>$GW."_aim"
    ),
    $GW."_apiPassword"=>array(
        "type"=>"VARCHAR",
        "max"=>255,
        "min"=>1,
        "text",
        "mandatory",
        "relation"=>$GW."_aim"
    ),
    $GW."_apiSignature"=>array(
        "type"=>"VARCHAR",
        "max"=>255,
        "min"=>1,
        "text",
        "mandatory",
        "relation"=>$GW."_aim"
    ),
    $GW."_cvv2"=>array(
        "type"=>"INT",
        "bool",
        "default"=>"0",
        "relation"=>$GW."_aim"
    ),
);

// If you make a new gateway integration, but don't want to add the gateway specific fields to
// the 'E-commerce settings' form, you can also simply define them as global variables. E.g. it would
// like like this in case of PayPal:

/*
$paypal_enabled           = TRUE;         
$paypal_environment       = 0; // 0: test, 1: live
$paypal_integrationMethod = 1; // 1: ecomm_advancedIntegration, 2: ecomm_simpleIntegration
$paypal_user              = 'some@address.com';
$paypal_apiUser           = 'fgt-four_api1.sdk.com';
$paypal_apiPassword       = 'QFZYUHGFFD78VBG7Q';
$paypal_apiSignature      = 'A.d9eRKfd1ykjgg766jhfjh57a6AyodL0SJkhYztxUi8W9pCXF6.4HU';
*/
?>
