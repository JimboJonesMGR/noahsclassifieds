<?php

class ECommFull extends EComm
{
 
function initialize()
{
    // Saving the enabled mode:
//    hasAdminRights($isAdm);
//    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));


    $_S = new AppSettings();
    $_S->ecommerceEnabled = Settings_ecommTestMode;
    modify($_S);
    
    PurchaseItem::initialize();
    ECommSettings::initialize();
    ECommUser::addTestUser();
    CreditRule::addDefaultCreditRules();
}

function confirmRules($cid, $oldItem=0) 
{
    ECommRule::confirmRules($cid, $oldItem);
}

function isAdvancedModelEnabled()
{
    $_ES = new ECommSettings();
    return isset($_ES->model) && $_ES->model==ecomm_advanced;
}

function showPurchaseLink() 
{
    global $gorumrecognised, $gorumuser;
    
    hasAdminRights($isAdm);
    if( $isAdm || !$gorumrecognised ) return FALSE;
    if( ECommFull::isAdvancedModelEnabled() ) return TRUE;
    // megnezzuk, hogy van-e a usernek pending purchase item-je:
    getDbCount( $count, array("SELECT COUNT(*) FROM @purchaseitem WHERE uid=#uid#", $gorumuser->id) );
    return $count;
}

function checkConsumptionOfAction(&$purchaseItem, &$consumption, &$item, $oldItem=0) 
{
    return ECommRule::checkConsumptionOfAction($purchaseItem, $consumption, $item, $oldItem);
}

}
?>
