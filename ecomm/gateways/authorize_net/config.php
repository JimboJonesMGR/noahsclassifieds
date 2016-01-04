<?php
$GW = 'authorize_net';

// The gateway host URL where the processing occurs:
${"processorPages_$GW"} = array(
    ecomm_test=>"https://test.authorize.net/gateway/transact.dll",
    ecomm_live=>"https://secure.authorize.net/gateway/transact.dll"
);

// The fileds credit card details fields that will appear in the purchase form in case of the advanced integration.
// They may depend on the payment gateway. The possible values are:
// "countryCode": The country code may be mandatory in some gateways (not in Authorize.NET, however!) and this field displays a drop down list of all the countries, in order to select the proper code,
//                Note that this is not the same as the "country" field of the purchase form! The Country field provides a country name which is not suitable for PayPal                  
// "cardDetails": This is just the separator of the card details section in the form,
// "cardName":    Name on card,
// "cardType":    Card type,
// "cardNumber":  Card number,
// "cardExp":     Card expiration,
// "startDate":   Start date,
// "issueNumber": Issue number,
${"creditCardDetailsFields_$GW"} = array("cardDetails", "cardType", "cardNumber", "cardExp");

// If cardType is included, the possible card types must be specified, too:
${"cardTypes_$GW"} = array("Visa", "MasterCard", "Discover", "Amex" );  // Other possibilities: Discover, JCB, Diner's Club, or EnRoute
// Note: "cardType" is not mandatory in Authorize.NET and if you leave it out, you need not specify the possible card types either!

// Using the following data construct, you can add gateway specific fields to the 'E-commerce settings' form.
// If you do that, admin can enable/disable the gateway and set all the other parameters necessary to
// process transactions from the admin interface. If you create a new gateway and don't want to make a new
// installation of the program, you have to add the necessary database fields that store the values of these
// parameters manually. In case of this gateway, it could be achieved with the following query:

/*
ALTER TABLE `ecommsettings` 
ADD `authorize_net_enabled`           INT( 11 ) NOT NULL DEFAULT '1',
ADD `authorize_net_integrationMethod` INT( 11 ) NOT NULL DEFAULT '0',
ADD `authorize_net_environment`       INT( 11 ) NOT NULL DEFAULT '0',
ADD `authorize_net_user`              VARCHAR( 255 ) NOT NULL ,
ADD `authorize_net_key`               VARCHAR( 255 ) NOT NULL ,
ADD `authorize_net_test`              INT( 11 ) NOT NULL DEFAULT '1',
ADD `authorize_net_cvv2`              INT( 11 ) NOT NULL DEFAULT '0',
ADD `authorize_net_md5Hash`           VARCHAR( 255 ) NOT NULL
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
        "show_relation"=>array(1=>$GW."_aim", 2=>$GW."_sim")
    ),
    $GW."_environment"=>array(
        "type"=>"INT",
        "radio",
        "default"=>"0", 
        "cols"=>"1", 
        "values"=>array(0,1), // ecomm_test, ecomm_live 
        "relation"=>$GW,
        "show_relation"=>array(1=>"live"),
    ),
    $GW."_user"=>array(
        "type"=>"VARCHAR",
        "max"=>255,
        "min"=>1,
        "text",
        "mandatory",
        "relation"=>$GW
    ),
    $GW."_key"=>array(
        "type"=>"VARCHAR",
        "max"=>255,
        "min"=>1,
        "text",
        "mandatory",
        "relation"=>$GW
    ),
    $GW."_test"=>array(
        "type"=>"INT",
        "bool",
        "default"=>1,
        "relation"=>"live"
    ),
    $GW."_cvv2"=>array(
        "type"=>"INT",
        "bool",
        "default"=>"0",
        "relation"=>$GW
    ),
    $GW."_md5Hash"=>array(
        "type"=>"VARCHAR",
        "max"=>255,
        "text",
        "relation"=>$GW
    ),
    $GW."_merchantInterface_sim"=>array(
        "type"=>"INT",
        "readonly",
        "no column",
        "relation"=>$GW."_sim"
    ),
    $GW."_merchantInterface_aim"=>array(
        "type"=>"INT",
        "readonly",
        "no column",
        "relation"=>$GW."_aim"
    )
);

// If you make a new gateway integration, but don't want to add the gateway specific fields to
// the 'E-commerce settings' form, you can also simply define them as global variables. E.g. it would
// look like this in case of Authorize.net:

/*
$authorize_net_enabled           = TRUE;         
$authorize_net_integrationMethod = 1; // 1: AIM, 2: SIM
$authorize_net_environment`      = 0; // 0: test, 1: live
$authorize_net_user`             = 'ukeriyuergfuyeg';
$authorize_net_key`              = '7364yt34fgy3';
$authorize_net_test`             = FALSE;
$authorize_net_cvv2`             = TRUE;
$authorize_net_md5Hash`          = 'foo';
*/
?>
