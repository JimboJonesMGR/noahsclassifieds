<?php
defined('_NOAH') or die('Restricted access');

$allowedMethods = array_merge($allowedMethods, array(
    "recalculate"=>'$base->recalculateAllItemNums();',
    "prolong_expiration"=>'$base->prolongExpiration();',
    "approve"=>'$base->approve();',
    "remove_first_check"=>'$base->removeFirstCheck();',
    "payment_processed"=>'paymentProcessed();',
    "customer_return"=>'customerReturn();',
    "callback_failed"=>'callbackFailed();',
    "get"=>'$base->getFeed();',
    "get_dump"=>'$base->getDump();',
    "sortfield_form"=>'$base->sortFieldForm($elementName);',
    "sortfield"=>'$base->sortField();',
    "advanced_form"=>'$base->generForm($elementName);',
    "advanced"=>'$base->advancedOperations();',
    "organize_form"=>'$base->organizeForm($elementName);',
    "organize"=>'$base->organize();',
    "show"=>'$base->show();',
    "preview"=>'$base->preview();',
    "inst_file_remove"=>'$base->removeInstFiles();',
    "app_file_remove"=>'$base->removeAppFiles();',
    "backup_file_remove"=>'$base->removeBackupFiles();',
    "mailtest"=>'$base->mailTest();',
    "delete_expired"=>'$base->deleteExpiredAds();',
    "download_oodle"=>'$base->downloadOodle();',
    "check_expired"=>'$base->checkExpiration();',
    "remove_favorities"=>'$base->manageFavorities("remove");',
    "add_favorities"=>'$base->manageFavorities("add");',
    "updates"=>'$base->updates();',
    "check_updates"=>'$base->checkUpdates();',
    "register"=>'$base->register();',
    "do_register"=>'$base->doRegister();',
    "do_update"=>'$base->doUpdate();',
    "move_form"=>'$base->moveForm($elementName);',
    "move"=>'$base->move();',
    "save"=>'$base->save();',
    "get_json_tree"=>'$base->getJsonTree();',
    "remind_password_form"=>'$ret=$base->remindPasswordForm($elementName);',
    "remind_password"=>'$ret=$base->remindPassword();',
    "login_form"=>'$ret=$base->loginForm($elementName);',
    "login"=>'$ret=$base->lowLevelLogin();',
    "logout"=>'$ret=logout();',
    "clone"=>'$ret=$base->cloneCategory();',
    "relay_response"=>'$ret=$base->relayResponse();',
    "silent_post"=>'$ret=$base->silentPost();',
    "delete_picture"=>'$ret=$base->deletePicture();',
    "delete_media"=>'$ret=$base->deleteMedia();',
    "get_fields_for_rules"=>'$ret=$base->getFieldsForRulesAjax();',
    "get_select_fields_for_rules"=>'$ret=$base->getFieldsForRulesAjax(TRUE);',
    "get_values_for_rules"=>'$ret=$base->getValuesForRulesAjax();',
    "add_credits"=>'$ret=$base->giftUsers();',
    "add_days"=>'$ret=$base->giftUsers(TRUE);',
    "propagate"=>'$ret=$base->propagate();',
    "propagate_subcat"=>'$ret=$base->propagate(TRUE);',
    "propagate_cat"=>'$ret=$base->propagate();',
    "propagate_cat_subcat"=>'$ret=$base->propagate(TRUE);',
    "propagate_sorting"=>'$ret=$base->propagateSorting();',
    "propagate_sorting_subcat"=>'$ret=$base->propagateSorting(TRUE);',
    "get_one_level_of_categories"=>'$ret=$base->getOneLevelOfCategoriesAjax();',
    "get_one_level_of_categories_without_adminonly_submit"=>'$ret=$base->getOneLevelOfCategoriesAjax(TRUE);',
    "tranform_enum_values"=>'$ret=CustomField::tranformEnumValuesWrapper();',
));    

$actionMethods = array_merge($actionMethods, array(
    "prolong_expiration",
    "approve",
    "remove_first_check",
    "payment_processed",
    "customer_return",
    "callback_failed",
    "get_feed",
    "get_dump",
    "sortfield",
    "advanced",
    "recalculate",
    "delete_expired",
    "download_oodle",
    "check_expired",
    "remove_favorities",
    "add_favorities",
    "inst_file_remove",
    "app_file_remove",
    "backup_file_remove",
    "do_update",
    "move",
    "save",
    "organize",
    "get_json_tree",
    "remind_password",
    "change_password",
    "login",
    "logout",
    "clone",
    "delete_picture",
    "delete_media",
    "get_fields_for_rules",
    "get_select_fields_for_rules",
    "get_values_for_rules",
    "add_credits",
    "add_days",
    "propagate",
    "propagate_subcat",
    "propagate_cat",
    "propagate_cat_subcat",
    "propagate_sorting",
    "propagate_sorting_subcat"
));  

$ajaxMethods = array_merge($ajaxMethods, array(
    "appcategory"=>array(
        "propagate_cat",
        "propagate_cat_subcat",
        "organize",
        "get_json_tree",
        "delete_picture",
        "delete_media",
        "get_one_level_of_categories",
        "get_one_level_of_categories_without_adminonly_submit"
    ),
    "customlist"=>array(
        "showdetails"
    ),
    "purchase"=>array(
        "silent_post"
    ),
    "item"=>array(
        "delete_picture",
        "delete_media"
    ),
    "customfield"=>array(
        "get_fields_for_rules",
        "get_select_fields_for_rules",
        "get_values_for_rules"
    ),
    "ecommuser"=>array(
        "add_credits",
        "add_days",
    ),
    "itemfield"=>array(
        "propagate",
        "propagate_subcat",
        "propagate_sorting",
        "propagate_sorting_subcat"
    )  ,  
    "rss"=>array(
        "get"
    ),
));  

$controllerShortcuts = array(
    "list" =>"showhtmllist",
    "view" =>"showdetails",
    "cat"  =>"appcategory",
    "cart" =>"shoppingcart",
    "user" =>"user",
    "field"=>"itemfield",
    "settings"=>"appsettings",
    "content"=>"appsettings_content"
);    
$reverseShortcuts = array_flip($controllerShortcuts);
    
$includeOnceList = array(
    "clonecat"=>array(NOAH_APP . "/clonecat.php"),
    "export"=>array(NOAH_APP . "/export.php"),
    "overlaycontroller"=>array(NOAH_APP . "/overlay.php")
);

class AppController extends Controller
{
var $permaLink="";

function init($queryString)
{    
    global $allowedMethods;
    
    $_S = new AppSettings();
    hasAdminRights($isAdm);

    if( !count($queryPieces = AppController::getQueryPieces($queryString)) ) 
    {
        $_GS = new GlobalStat();
        if( $_GS->defPageConf ) $this->Controller("checkconf", "show");  // config check page
        elseif( !empty($_S->homeLocation) && $_S->homeLocation!="/") $this->Controller($_S->homeLocation);
        else $this->Controller("appcategory", "showhtmllist", 0);  // default application home
    }
    elseif( is_numeric($queryPieces[0]) ) 
    {
        // Pl: /123     /123/attr1/val1/attr2/val2
        $this->Controller("item", "showdetails", array_shift($queryPieces), $queryPieces);
    }
    elseif( $queryPieces[0]=="list" )
    {
        array_shift($queryPieces);
        if( is_numeric($queryPieces[0]) || $queryPieces[0]=='*' )
        {
            // Pl: /list/23     /list/23/attr1/val1/attr2/val2
            // ha nincs ilyen category id, de van olyan user, aminek ez a neve:
            if( G::load( $obj, $queryPieces[0], "appcategory" ) && 
                !loadSQL( $obj=new User, array("SELECT id FROM @user WHERE name=#name# LIMIT 1", $queryPieces[0]) ) )
            {
                $this->Controller("item_my", "showhtmllist", array_shift($queryPieces), $queryPieces);
            }
            else $this->Controller("appcategory", "showhtmllist", array_shift($queryPieces), $queryPieces);
        }
        else
        {
            // Egy user osszes iteme: Pl: /list/henry
            $this->Controller("item_my", "showhtmllist", urldecode(array_shift($queryPieces)), $queryPieces);
        }
    }
    elseif( $queryPieces[0]=="rss" )
    {
        // Pl: /rss/category/10/latest/20/days/3
        array_shift($queryPieces);
        if($queryPieces[0]=="modify_form" )
        {
          if (!$isAdm) LocationHistory::rollBack(new AppController("/"));
          $this->Controller("rss", "modify_form", "1");
        } 
        else $this->Controller("rss", "get", "0", $queryPieces);
    }
    elseif( count($queryPieces)==1 )
    {
        if( $queryPieces[0]=="control_panel" )
        {
            $this->Controller("controlpanel", "showhtmllist");
        }
        elseif( $queryPieces[0]=="purchaseitem" && class_exists("purchaseitem") )
        {
            $this->Controller("purchaseitem", "showhtmllist");
        }
        elseif( !$_S->permaLinksEnabled() || !$this->validPermaLink($queryPieces) )
        {
            $this->Controller("staticpage", "show", $queryPieces[0]); // Pl: /faqpage
            $template = "$queryPieces[0].tpl.php";
            if( !file_exists(GORUM_TEMPLATE_DIR . "/$template") && !file_exists(TEMPLATE_DIR . "/$template") && !file_exists(COMMON_TEMPLATES . "/$template") )
            {
    global $lll, $language, $langDir;

    include_once(LANG_DIR . "/lang_$language.php");
    include_once(LANG_DIR . "/lang_admin_$language.php");
                
                return Roll::setFormInvalid("nonExistentStaticPage", $queryPieces[0]);
                
            }
        }
    }
    elseif( is_numeric($queryPieces[1]) || $queryPieces[1]=='*' ) 
    {
        // Pl: /item/123     /item/123/attr1/val1/attr2/val2
        $this->Controller(array_shift($queryPieces), "showdetails", array_shift($queryPieces), $queryPieces);
    }
    elseif( $_S->permaLinksEnabled() && !$this->isExistingMethod($queryPieces[1]) )
    {
        if( !$this->validPermaLink($queryPieces) ) 
        {
            trigger_error( "Invalid query string: $queryString", E_USER_ERROR );
            return Roll::setFormInvalid("invalidInternalLink", $queryString);
        }
    }
    elseif( count($queryPieces)==2 )
    {
        
        
        if( $queryPieces[0]=="item_inactive" )
        {
          if (!$isAdm) LocationHistory::rollBack(new AppController("/"));
        }
        // Pl: /user/create_form/
        $this->Controller(array_shift($queryPieces), array_shift($queryPieces), 0);
    }
    elseif( count($queryPieces)>=3 )
    {
        if( $queryPieces[2]=="off" ) //pl. notification/list/off/3
        {
            $this->Controller(array_shift($queryPieces), array_shift($queryPieces), 0, $queryPieces);
        }
        else $this->Controller(array_shift($queryPieces), array_shift($queryPieces), array_shift($queryPieces), $queryPieces);
    }
    else 
    {
        trigger_error( "Invalid query string: $queryString", E_USER_ERROR );
        return Roll::setFormInvalid("invalidInternalLink", $queryString);
    }
    return TRUE;
}

function isExistingMethod($queryPiece)
{
    global $allowedMethods, $controllerShortcuts;
    
    if( isset($allowedMethods[$queryPiece]) ) return TRUE;
    if( isset($controllerShortcuts[$queryPiece]) && isset($allowedMethods[$controllerShortcuts[$queryPiece]]) ) return TRUE;
    return FALSE;
}

function setPermaLink($s)
{
    $this->permaLink = $s;
}

function validPermaLink($queryPieces)
{
    $_S = new AppSettings();
    if( count($queryPieces)==1 && !$_S->ommitCatPermaLink )
    {
        // Pl: /cars
        if( !loadSQL($cat = new AppCategory, array("SELECT id FROM @category WHERE up=0 AND permaLink=#name# LIMIT 1", strtolower($queryPieces[0])) ) )
        {
            $this->Controller("appcategory", "showhtmllist", $cat->id);
            return TRUE;
        }
    }
    else
    {
        if( ($pos = array_search("off", $queryPieces))!==FALSE )
        {
            $catNameArr = array_slice($queryPieces, 0, $pos);
            $restOfTheQuery = array_slice($queryPieces, $pos); 
        }
        else 
        {
            $catNameArr =& $queryPieces;
            $restOfTheQuery = array();
        }
        
        // Oodle        
        // Pl: cars/O1-audi_for_sale 
        if( preg_match("/^O(\d+)_/", $catNameArr[count($catNameArr)-1], $matches) )
        {
            $query = "SELECT id FROM @item WHERE oodleID=#id#";
            if( !loadSQL($itm = new Item, array($query, $matches[1]) ) )
            {
                $this->Controller("item", "showdetails", $itm->id);
                return TRUE;
            } else
            {
                $this->Controller("item", "showdetails", "O".$matches[1]);
                return TRUE;
            }
        }
        // Oodle

        // Pl: cars/1_audi_for_sale
        if( preg_match("/^(\d+)_/", $catNameArr[count($catNameArr)-1], $matches) )
        {
            $this->Controller("item", "showdetails", $matches[1]);
            return TRUE;
        }
        // Pl: /cars/economy_cars
        if( !loadSQL($cat = new AppCategory, array("SELECT id FROM @category WHERE permaLink=#name# LIMIT 1", strtolower(implode("/", $catNameArr)) ) ))
        {
            $this->Controller("appcategory", "showhtmllist", $cat->id, $restOfTheQuery);
            return TRUE;
        }
    }
    return FALSE;    
}

function getQueryPieces( $queryString )
{
    if( !$queryString || $queryString=="/" ) return array();
    $queryPieces = explode("/", $queryString );
    // ha az elejere vagy a vegere valahogy ures kerult, azt levagdossuk:
    if( $queryPieces[0]==="" ) array_shift($queryPieces);
    if( end($queryPieces)==="" ) array_pop($queryPieces);
    return $queryPieces;
}

// Gyakorlatilag az init() ellentete:
function makeQueryString()
{
    global $reverseShortcuts;
    
    if( $this->permaLink ) return $this->permaLink;
    
    $_S = new AppSettings();
    if( !count($this->classVars) && $this->list=="appcategory" && $this->method=="showhtmllist" && $this->rollid==0) return "";
    if( $this->list=="appcategory" && $this->method=="showhtmllist" ) 
    {
        if( $_S->permaLinksEnabled() )
        {
            $permaLink = G::getAttr($this->rollid, "appcategory", "permaLink");
            if( $classVars = $this->encodeClassVars() ) $permaLink.= "/$classVars";
            $qs = $permaLink;
        }
        else $qs = "list/" . $this->makeQueryStringFromRollIdAndClassVars();
    }
    elseif( $this->list=="controlpanel" && $this->method=="showhtmllist" ) 
    {
        $qs = "control_panel";
    }
    elseif( $this->list=="staticpage" && $this->method=="show" ) 
    {
        $qs = urlencode($this->rollid);
    }
    elseif( $this->method=="showdetails" ) 
    {
        if( $_S->permaLinksEnabled() && $this->list=="item" )
        {
            //todo
            $permaLink = G::getAttr($this->rollid, "appcategory", "permaLink");
        }
        $list = isset($reverseShortcuts[$this->list]) ? $reverseShortcuts[$this->list] : $this->list;
        $qs = "$list/" . $this->makeQueryStringFromRollIdAndClassVars();
    }
    elseif( $this->list=="item_my" && $this->method=="showhtmllist"  && is_string($this->rollid) ) 
    {
        $qs = "list/" . $this->makeQueryStringFromRollIdAndClassVars();
    }
    elseif( $this->list=="rss" && $this->method=="get" ) 
    {
        $qs = "rss/" . $this->makeQueryStringFromRollIdAndClassVars();
    }
    else
    {
        $list = isset($reverseShortcuts[$this->list]) ? $reverseShortcuts[$this->list] : $this->list;
        $method = isset($reverseShortcuts[$this->method]) ? $reverseShortcuts[$this->method] : $this->method;
        $qs = "$list/$method/" . $this->makeQueryStringFromRollIdAndClassVars();
    }
    if( $qs==$_S->homeLocation ) $qs="";
    return $qs;
}

function makeQueryStringFromRollIdAndClassVars()
{
    if( !$this->rollid && !count($this->classVars) ) return "";
    $pieces = array();
    if( $this->rollid && $this->rollid=='00' ) $pieces[] = '0';
    elseif( $this->rollid  ) $pieces[] = urlencode($this->rollid);
    if( $classVars = $this->encodeClassVars() ) $pieces[] = $classVars;
    return implode("/", $pieces);
}

function encodeClassVars()
{
    if( !count($this->classVars) ) return "";
    $pieces = array();
    foreach( $this->classVars as $key=>$val ) $pieces[]="$key/" . urlencode($val);
    return implode("/", $pieces);
}

}
?>
