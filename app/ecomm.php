<?php

class EComm
{
    
function createObject() // factory method
{
    $_S = new AppSettings();

    if( $_S->ecommerceEnabled() ) return new ECommFull();
    return new EComm(FALSE);
}

function isEnabledGlobally()
{
    global $ecommerceDisabledGlobally;
    
    return file_exists(ECOMM_DIR . "/constants.php") && empty($ecommerceDisabledGlobally);
}

function initialize(){}

function confirmRules() {}

function checkConsumptionOfAction(&$purchaseItem, &$consumption, &$item, $oldItem=0) 
{
    $purchaseItem=$consumption=0;
    return TRUE;
}

function isAdvancedModelEnabled() { return FALSE; }

function showPurchaseLink() {return FALSE; }
}
?>
