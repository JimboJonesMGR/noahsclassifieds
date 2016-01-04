<?php

global $ecommsettings_typ, $defaultCurrency, $defaultPrecisionSeparator, $defaultThousandsSeparator;
$ecommsettings_typ =  
    array(
        "attributes"=>array(   
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ), 
            "model"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "values"=>array(1,2), // ecomm_simple, ecomm_advanced 
                "default"=>2, // ecomm_advanced
                "show_relation"=>array(ecomm_advanced=>"advanced"),
            ),
            "expNoticeBefore_subscription"=>array(
                "type"=>"INT",
                "text",
                "default"=>5, //days
                "relation"=>"advanced",
                "filterCharacters"=>"numeric()",
            ),
            "expNoticeBefore_credits"=>array(
                "type"=>"INT",
                "text",
                "default"=>10, 
                "relation"=>"advanced",
                "filterCharacters"=>"numeric()",
            ),
            "purchaseFormFields"=>array(
                "type"=>"TEXT",
                "multipleselection",
                "asmselect"=>"{sortable: true}",
                "asmselect_label"=>"selectField",
                "values"=>array(150,160,170,180,190,10,20,30,40,50,60,70,80,90,100), 
                "size"=>10,
            ),
            /*
            "invoiceNumberPrefix"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
            ),
            */
/**************************************************************************
Display formatting
**************************************************************************/
            "priceSection"=>array(
                "type"=>"INT",
                "section",
                "no column",
            ),
            "currency"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "notrim",
                "length"=>5,
                "default"=>$defaultCurrency,
            ),
            "currencySymbol"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "notrim",
                "length"=>5,
                "default"=>$defaultCurrencySymbol,
            ),
            "formatPrefix"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "notrim",
                "length"=>5,
                "default"=>$defaultCurrencySymbol,
            ),
            "formatPostfix"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "notrim",
                "length"=>5,
            ),
            "precision"=>array(
                "type"=>"INT",
                "text",
                "default"=>2,
                "length"=>1,
                "filterCharacters"=>"numeric()",
            ),
            "precisionSeparator"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>1,
                "notrim",
                "length"=>1,
                "default"=>$defaultPrecisionSeparator,
            ),
            "thousandsSeparator"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>1,
                "length"=>1,
                "notrim",
                "default"=>$defaultThousandsSeparator,
            ),
            "format"=>array(
                "type"=>"VARCHAR",
                "text",
                "notrim",
                "max"=>255,
            ),
/**************************************************************************
Present users
**************************************************************************/
            "presentUsers"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "relation"=>"advanced",
            ),
            "presentCredits"=>array(
                "type"=>"INT",
                "text",
                "length"=>5,
                "no column",
                "filterCharacters"=>"numeric()",
                "relation"=>"advanced",
            ),
            "presentDays"=>array(
                "type"=>"INT",
                "text",
                "length"=>5,
                "no column",
                "filterCharacters"=>"numeric()",
                "relation"=>"advanced",
            ),
        ),
        "primary_key"=>"id",
        "smartform"
    );

// adding the peyment gateway specific settings for fields:    
foreach( GateWay::getGateways() as $gateway )
{
    global ${"settingsFormFields_$gateway"};    
    if( isset(${"settingsFormFields_$gateway"}) ) 
    {
        $ecommsettings_typ["attributes"] = array_merge($ecommsettings_typ["attributes"], ${"settingsFormFields_$gateway"});
    }
}

class ECommSettings extends Settings
{

function get_table()
{
    return "ecommsettings";
}

function ECommSettings($withInit = TRUE)
{
    global $siteDemo, $demo_authorize_net_user, $demo_authorize_net_key;
    $this->Settings($withInit);
    // so that we can use valid authnet user and kay in the site demo that is not visible on the interface:

    if( $siteDemo )
    {
        if( isset($demo_authorize_net_user) ) $this->authorize_net_user = $demo_authorize_net_user;
        if( isset($demo_authorize_net_key) ) $this->authorize_net_key = $demo_authorize_net_key;
    }    
}

function modifyForm()
{
    global $lll, $gorumroll;

    JavaScript::addOnLoad('
        var textBox = $("#presentCredits");
        var link = textBox.next();
        link.click( function() {
            $(this).attr("href", $(this).attr("href") + $(this).prev().val());
        });
    ');
    $overlayCredit = new OverlayController(array(
        "id"=>"creditOverlay",
        "triggerSelector"=>'a[rel=#creditOverlay]',
        "ajaxFromHref"=>TRUE,
        "expose"=>TRUE,
        "height"=>70,
        "onClose"=>'
            var textBox = $("#presentCredits");
            var link = textBox.next();
            textBox.val(0);
            link.attr("href", link.attr("href").replace(/\/\d+$/, "/"));
        ',
	));
    JavaScript::addOnLoad('
        var textBox = $("#presentDays");
        var link = textBox.next();
        link.click( function() {
            $(this).attr("href", $(this).attr("href") + $(this).prev().val());
        });
    ');
    $overlayDays = new OverlayController(array(
        "id"=>"daysOverlay",
        "triggerSelector"=>'a[rel=#daysOverlay]',
        "ajaxFromHref"=>TRUE,
        "expose"=>TRUE,
        "height"=>70,
        "onClose"=>'
            var textBox = $("#presentDays");
            var link = textBox.next();
            textBox.val(0);
            link.attr("href", link.attr("href").replace(/\/\d+$/, "/"));
        ',
    ));
    $ajaxFromHrefCredits = new AppController("ecommuser/add_credits");
    $ajaxFromHrefDays = new AppController("ecommuser/add_days");
    $lll["ecommsettings_presentCredits_afterfield"]=$overlayCredit->generAnchor($lll["clickToAdd"], "overlay", $ajaxFromHrefCredits->makeUrl());
    $lll["ecommsettings_presentDays_afterfield"]=$overlayDays->generAnchor($lll["clickToAdd"], "overlay", $ajaxFromHrefDays->makeUrl());
    $gorumroll->rollid=1;
    Settings::modifyForm();
}

function initialize()
{
    global $test_authorize_net_user, $test_authorize_net_key, $test_paypal_user;
    
    $test_authorize_net_user = isset($test_authorize_net_user) ? $test_authorize_net_user : "";
    $test_authorize_net_key = isset($test_authorize_net_key) ? $test_authorize_net_key : "";
    $test_paypal_user = isset($test_paypal_user) ? $test_paypal_user : "";
    executeQuery("
    INSERT INTO @ecommsettings (`id`, `purchaseFormFields` 
    ) VALUES (1, '150,160,170,180,190,10,20,30,40,50,60,70,80,90,100');");
    if( $test_authorize_net_user && $test_authorize_net_key )
    {
        executeQuery("UPDATE @ecommsettings SET authorize_net_user='$test_authorize_net_user', authorize_net_key='$test_authorize_net_key' WHERE id=1;");
    }
    if( $test_paypal_user )
    {
        executeQuery("UPDATE @ecommsettings SET paypal_user='$test_paypal_user' WHERE id=1;");
    }
    
}

function formatPrice($s)
{
    $s = number_format( $s, $this->precision, $this->precisionSeparator, $this->thousandsSeparator );
    if( $this->formatPrefix ) $s = $this->formatPrefix.$s;
    if( $this->formatPostfix ) $s = $s.$this->formatPostfix;
    if( $this->format )
    {
        // ha definialva van egy spec formatum, akkor alkallmazzuk:
        $s = sprintf( $this->format, $s );
    }
    return $s;
}

function showListVal($attr)
{
    global $lll;
    
    if( strstr($attr, "authorize_net_merchantInterface") )
    {
        return sprintf($lll["{$attr}_details"], $base = Controller::getBaseUrl(), $base);
    }
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
    
    $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    $navBarPieces[$lll["ecommSettings"]] = "";
    return $navBarPieces;
}

function modify() 
{
    global $lll, $siteDemo;

    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
   
    if( $siteDemo )
    {
        $oldSettings = new ECommSettings();
        $disabledAttrs=array();
        // It is disabled to save these attributes in the demo version:
        foreach( array("authorize_net_environment", "authorize_net_user", "authorize_net_key", "authorize_net_cvv2", "authorize_net_md5Hash", "paypal_user") as $attr )
        {
            if( !empty($this->$attr) && $this->$attr!=$oldSettings->$attr ) 
            {
                $disabledAttrs[]="'".$lll["ecommsettings_$attr"]."'";
                unset($this->$attr);
            }
        }
    }
    if( $siteDemo && count($disabledAttrs) ) return Roll::setFormInvalid("It is disabled to modify the following field in the demo version: ".implode(", ", $disabledAttrs) );
    if( !$this->checkMandatoryFields() ) return;
    parent::modify();
} 

function checkMandatoryFields()
{
    global $ecommsettings_typ;
    
    foreach( Gateway::getGateways() as $gateway )
    {
        if( isset($ecommsettings_typ["attributes"][$gateway."_integrationMethod"]) && 
            $this->{$gateway."_enabled"} &&
            !$this->{$gateway."_integrationMethod"}) 
        {
            return Roll::setFormInvalid("selectIntegrationMethod");
        }
    }
    return TRUE;
}

function getEnabledPaymentGateways()
{
    $gateways = Gateway::getGateways();
    $enabledGateways = array();
    foreach( Gateway::getGateways() as $gateway ) if( $this->getGatewayProperty("enabled", $gateway) ) $enabledGateways[]=new $gateway;
    return $enabledGateways;
}

function getPaymentEnvironment($gateway)
{
    global ${"processorPages_$gateway"};
    
    if( ($test=$this->getGatewayProperty("environment", $gateway))===FALSE ) $test=ecomm_live; 
    $host = ${"processorPages_$gateway"}[$test];
    if( is_array($host) ) return $host[$this->getGatewayProperty("integrationMethod", $gateway)];
    return $host;
}

function getResponseValidationHost($gateway)
{
    global ${"responseValidationHosts_$gateway"};

    if( !isset(${"responseValidationHosts_$gateway"}) ) return $this->getPaymentEnvironment($gateway);   
    if( ($test=$this->getGatewayProperty("environment", $gateway))===FALSE ) $test=ecomm_live; 
    return ${"responseValidationHosts_$gateway"}[$test];
}

function getGatewayProperty($property, $gateway)
{
    $gwp = "{$gateway}_$property";
    if( isset($this->$gwp) ) return $this->$gwp;
    global $$gwp;
    if( isset($$gwp) ) return $$gwp;
    else return FALSE;
}

}
?>
