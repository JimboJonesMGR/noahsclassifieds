<?php
global $dbClasses, $defaultCurrency, $ecommAssignmentToFieldMapping;

$dbClasses[]="purchaseitem";
$dbClasses[]="purchase";
$dbClasses[]="ecommsettings";
$dbClasses[]="ecommrule";
define("ecomm_both", 0);
define("ecomm_credit", 1);
define("ecomm_subscription", 2);
define("ecomm_pending", 3);

define("ecomm_simple", 1);
define("ecomm_advanced", 2);

define("ecomm_days", 0);
define("ecomm_weeks", 1);
define("ecomm_months", 2);
define("ecomm_years", 3);
define("ecomm_new", 0);
$defaultCurrency = "USD";
$defaultCurrencySymbol = "$";

define("Init_purchase", 300);
define("Init_purchaseHistory", 310);

define("ecomm_none", 0);
define("ecomm_firstName", 10);
define("ecomm_lastName", 20);
define("ecomm_address", 30);
define("ecomm_city", 40);
define("ecomm_state", 50);
define("ecomm_zip", 60);
define("ecomm_country", 70);
define("ecomm_phone", 80);
define("ecomm_fax", 90);
define("ecomm_email", 100);
define("ecomm_cardName", 110);
define("ecomm_cardNumber", 120);
define("ecomm_cardExp", 130);
define("ecomm_cardCode", 140);
define("ecomm_itemProperties", 150);
define("ecomm_description", 160);
define("ecomm_price", 170);
define("ecomm_notes", 180);
define("ecomm_customerDetails", 190);
define("ecomm_cardDetails", 200);
define("ecomm_cardType", 210);
define("ecomm_startDate", 220);
define("ecomm_issueNumber", 230);

define("ecomm_test", 0);
define("ecomm_live", 1);

define("ecomm_advancedIntegration", 1);
define("ecomm_simpleIntegration", 2);

define("rule_registration", 1);
define("rule_submit", 2);
define("rule_prolong", 3);
define("rule_view", 4);
define("rule_reply", 5);
define("rule_setField", 6);
define("rule_setFieldToValue", 7);
//define("rule_beingSubmitted", 4);
//define("rule_beingRegistered", 2);
define("rule_generic", 0);
define("rule_customized", 1);

$ecommAssignmentToFieldMapping = array(ecomm_none=>"",ecomm_firstName=>"firstName",ecomm_lastName=>"lastName",ecomm_address=>"address",
                                       ecomm_city=>"city",ecomm_state=>"state",ecomm_zip=>"zip",ecomm_country=>"country",
                                       ecomm_phone=>"phone",ecomm_fax=>"fax",ecomm_email=>"email", ecomm_cardName=>"cardName",
                                       ecomm_cardNumber=>"cardNumber",ecomm_cardExp=>"cardExp",ecomm_cardCode=>"cardCode",ecomm_cardType=>"cardType",
                                       ecomm_itemProperties=>"itemProperties", ecomm_description=>"description", ecomm_price=>"price", 
                                       ecomm_notes=>"notes", ecomm_customerDetails=>"customerDetails", ecomm_cardDetails=>"cardDetails",
                                       ecomm_startDate=>"startDate", ecomm_issueNumber=>"issueNumber"); 

$subAmountToDays = array(ecomm_days=>1, ecomm_weeks=>7, ecomm_months=>31, ecomm_years=>365);

include_once("purchaseitem.php");
include_once("init.php");
include_once("ecomm_full.php");
include_once("gateways/gateway.php");
// including the payment gateway specific files:    
foreach( GateWay::getGateways() as $gateway )
{
    include_once("gateways/$gateway/config.php");
    include_once("gateways/$gateway/$gateway.php");
}

include_once("settings.php");
include_once("user.php");
include_once("purchase.php");
include_once("rule.php");
include_once("creditrule.php");
include_once("paymentrule.php");

define("ECOMM_COMPLETED", 1);
define("ECOMM_DENIED", 2);
define("ECOMM_ERROR", 3);
define("ECOMM_PENDING", 4);
?>
