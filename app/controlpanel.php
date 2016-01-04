<?php
defined('_NOAH') or die('Restricted access');

class ControlPanel extends Object
{

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    hasAdminRights($isAdm);
    $hasRight->objectRight = $isAdm;
    if( !$hasRight && $giveError )
    {
        handleError($lll["permission_denied"]);
    }
}

function showHtmlList()
{
    global $lll;

    $_S = new AppSettings();
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    JavaScript::addCss(CSS_DIR . "/category.css");
    $catArr = array();
    $adminsettCtrl = new AppController("settings/modify_form");
    $contentManagementCtrl = new AppController("content/modify_form");
    $usersCtrl = new AppController("user/list");
    $NotificationsCtrl = new AppController("notification/list");
    $checkconfCtrl = new AppController("checkconf/show");
    $checkUpdatesCtrl = new AppController("checkconf/updates");
    $customListsCtrl = new AppController("customlist/list");
    $rssCtrl = new AppController("rss/modify_form/1");
    $purchaseItemCtrl = new AppController("purchaseitem/sortfield_form");
    $pendingPurchaseItemsCtrl = new AppController("purchaseitem/list");
    $ecommSettingsCtrl = new AppController("ecommsettings/modify_form");
    $creditRulesCtrl = new AppController("creditrule/list");
    $paymentRulesCtrl = new AppController("paymentrule/list");
    $subscription_ttitleCtrl = new AppController("subscription/list");
    $itemfield_ttitle_globalCtrl = new AppController("field/sortfield_form/0");
    $oodleCtrl = new AppController("item/download_oodle");
    
    $items = array("adminsett", "contentManagement", "users", "Notifications", "customLists", "itemfield_ttitle_global");

    if( class_exists("rss") ) $items[]="rss";
    if( $_S->subscriptionType )
    {
        $items[]="subscription_ttitle";
    }
    if( $_S->ecommerceEnabled() ) 
    {
        $_ES = new ECommSettings();
        $items[]="ecommSettings";
        if( $_ES->model==ecomm_advanced ) 
        {
            $items[]="creditRules";
            $items[]="purchaseItem";
        }
        else 
        {
            $items[]="paymentRules";
            $items[]="pendingPurchaseItems";
        }
    }
    
    if ($_S->enableOodle)
    {
        $items[]="oodle";
    }        

    $i=0;
    foreach( $items as $item )
    {
        $catArr[$i]->title=$lll[$item];
        $catArr[$i]->description=$lll["{$item}Description"];
        $catArr[$i]->link=${$item."Ctrl"}->makeUrl();
        $catArr[$i]->picture="";
        $catArr[$i]->title=$lll[$item];
        $i++;
    }
    View::assign( "categories", $catArr );
}

function getNavBarPieces($linkOnTheEnd=FALSE)
{
    global $lll;
    
    $navBarPieces = array($lll["home"] => new AppController("/"));
    $navBarPieces[$lll["controlPanel"]] = $linkOnTheEnd ? new AppController("control_panel") : "";
    return $navBarPieces;
}

}

?>