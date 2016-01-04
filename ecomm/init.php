<?php
defined('_NOAH') or die('Restricted access');

class ECommInit extends AppInit
{
    
function initializeUserSettings()
{
    global $language;

    parent::initializeUserSettings();
    // a megfelelo nyelvi file-okat behozzuk:
    if( file_exists(ECOMM_DIR . "/" . ECOMM_LANG_DIR . "/lang_$language.php") )
    {
        include(ECOMM_DIR . "/" . ECOMM_LANG_DIR . "/lang_$language.php");
    }
    else include(ECOMM_DIR . "/" . ECOMM_LANG_DIR . "/lang_en.php");
    if( file_exists(ECOMM_DIR . "/" . ECOMM_LANG_DIR . "/lang_admin_$language.php") )
    {
        include(ECOMM_DIR . "/" . ECOMM_LANG_DIR . "/lang_admin_$language.php");
    }
    else include(ECOMM_DIR . "/" . ECOMM_LANG_DIR . "/lang_admin_en.php");
    if( file_exists(ECOMM_DIR . "/" . ECOMM_LANG_DIR . "/lang_custom_$language.php") ) include(LANG_DIR . "/lang_custom_$language.php");
}

function showApp()
{
    View::assign("ecommStatus", $this->showECommStatus());
    parent::showApp();
}

function showECommStatus()
{
    global $gorumuser, $gorumrecognised;
    hasAdminRights($isAdm);
    if( !$gorumrecognised || $isAdm || $gorumuser->isPurchaseNecessary() ) return "";
    return $gorumuser->showECommStatus();
}

function display( $what )
{
    global $gorumrecognised, $gorumroll, $gorumuser;

    $_S = new AppSettings();
    hasAdminRights($isAdm);
    switch( $what )
    {
    case Init_purchase:
        return ECommFull::showPurchaseLink();
    case Init_purchaseHistory:
        return $gorumrecognised && $_S->ecommerceEnabled();
    default:
        return AppInit::display($what);
    }
}

function addEcommMenuPoints(&$menu)
{
    global $lll;
    
    $_S = new AppSettings();
    if( !$_S->ecommerceEnabled() ) return;
    if( $this->display( Init_purchase ))
    {
        $ctrl = new AppController("purchaseitem");
        $menu["purchase"]["link"]=$ctrl->makeUrl();
        $menu["purchase"]["label"]=$lll["purchase"];
    }
    if( $this->display( Init_purchaseHistory ))
    {
        $ctrl = new AppController("purchase/list");
        $menu["purchaseHistory"]["link"]=$ctrl->makeUrl();
        $menu["purchaseHistory"]["label"]=$lll["purchaseHistory"];
    }
}

}
?>
