<?php
defined('_NOAH') or die('Restricted access');

class AppInit extends Init
{

function initializeSystemSettings()
{
    global $user_typ, $noahVersion;

    Init::initializeSystemSettings();
    $_S = new AppSettings;
    $_GS = new GlobalStat();
    hasAdminRights($isAdm);
    if( $_GS->instver!=$noahVersion ) 
    {
        header( "location: ".Controller::getBaseUrl()."update.php\n");
        die();
    }
    header("Noahs-Classifieds: $_GS->instver\n" );
    Date::setFormat($_S->getAttr("timeFormat"));
    Date::setFormatIgnoreSecond($_S->getAttr("dateFormat"));
    Date::setFormatIgnoreHour($_S->getAttr("dateFormat"));
    GenerWidget::initCaptchaField();
    LocationHistory::getCategory();  // initializing $gorumcategory
}

function initializeUserSettings()
{
    global $jQueryLib, $gorumroll;
    
    $_S = new AppSettings;
    $_S->initLanguageProperties();
    Init::initializeUserSettings();
    if( class_exists("gateway") ) Gateway::includeLanguageFiles();
    $gorumroll->checkForPostMaxSizeError();
    $_S->initThemeProperties();
    // In case of the organize page, the 1.3 version of the jquery library must be loaded:
    $jQueryLib = $gorumroll->method=="organize_form" ? "/jquery/interface/jquery.js" : "/jquery/jquery-1.6.1.min.js";
    if( file_exists(THEME_DIR . "/theme_config.php") ) include_once(THEME_DIR . "/theme_config.php");
}

function showApp()
{
    global $navBarText, $categoryColumnsNum, $language, $jQueryLib;
    
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addCss(CSS_DIR . "/layout.css");
    JavaScript::addCss(CSS_DIR . "/pages.css");
    if( is_callable(array("ThemeConfig", "init")) ) ThemeConfig::init();
    $this->makeLoginMenu();
    $this->makeAdminMenu();
    $this->applyDebugMode();
    if( class_exists('rss') ) Rss::makeRssFeed();
    else
    {
        View::assign("mainClass", 'main_withoutSidebar');
        View::assign("outerMainClass", 'outerMain_withoutSidebar');
    }
    CustomList::getList(customlist_top);
    CustomList::getList(customlist_bottom);
    CustomList::getList(customlist_aboveContent);
    CustomList::getList(customlist_belowContent);
    CustomList::getList(customlist_right);
    CustomList::getList(customlist_left);
    
    $_S = new AppSettings;
    View::assign("baseUrl", Controller::getBaseUrl());
    View::assign("userStatus", $this->showUserStatus());
    View::assign("themeSelector", $this->showSelector("Theme"));
    View::assign("languageSelector", $this->showSelector("Language"));
    View::assign("versionFooter", $_S->versionFooter);
    View::assign("infoText", $this->showInfoText());
    View::assign("jsIncludes", JavaScript::getIncludes());
    View::assign("javaScript", JavaScript::getScript());
    View::assign("titlePrefix", $_S->getAttr("titlePrefix"));
    View::assign("categoryColumnsNum", $categoryColumnsNum);
    View::assign("cssDir", CSS_DIR);
    View::assign("imagesDir", IMAGES_DIR);
    View::assign("language", $language);
    View::assign("langDir", $_S->langDir);
    View::assign("extraBody", $_S->getProAttr("extraBody"));
    View::assign("extraFooter", $_S->getProAttr("extraFooter"));
    View::assign("extraHead", $_S->getProAttr("extraHead"));
    View::assign("extraTopContent", $_S->getProAttr("extraTopContent"));
    View::assign("extraBottomContent", $_S->getProAttr("extraBottomContent"));
    AppCategory::assignCurrentCategoryFields();
    User::assignCurrentUserFields();    
}

function applyDebugMode()
{
    global $noahDebugMode;
    
    if( $noahDebugMode ) return;
    $_S = new AppSettings();
    if( $_S->templateDebug )
    {
        JavaScript::addOnload("
            var href = location.href;
            window.open(
                href + '/noahdebug',
                'noahdebug',
                'menubar=0, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1'
            );
        ");
    }
}

function getTemplate()
{
    global $gorumroll, $gorumuser, $gorumrecognised, $tA, $noahDebugMode;

    if( $noahDebugMode ) 
    {
        View::setMainTemplateFile("debug.tpl.php");
    }
    else View::setMainTemplateFile("layout.tpl.php");
    
    // a beloginozottsagtol is fuggove tehetjuk, hogy milyen template jelenik meg:
    $auth = $gorumrecognised ? ($gorumuser->isAdm ? "admin" : "loggedin") : "loggedout";
    if( isset($tA[$gorumroll->list."-".$gorumroll->method."-".$gorumroll->rollid."-".$auth]) )
    {
        View::setContentTemplateFile($tA[$gorumroll->list."-".$gorumroll->method."-".$gorumroll->rollid."-".$auth]);
    }
    elseif( isset($tA[$gorumroll->list."-".$gorumroll->method."-".$gorumroll->rollid]) )
    {
        View::setContentTemplateFile($tA[$gorumroll->list."-".$gorumroll->method."-".$gorumroll->rollid]);
    }
    elseif( isset($tA[$gorumroll->method."-".$gorumroll->rollid."-".$auth]) )
    {
        View::setContentTemplateFile($tA[$gorumroll->method."-".$gorumroll->rollid."-".$auth]);
    }
    elseif( isset($tA[$gorumroll->method."-".$gorumroll->rollid]) )
    {
        View::setContentTemplateFile($tA[$gorumroll->method."-".$gorumroll->rollid]);
    }
    elseif( isset($tA[$gorumroll->list."-".$gorumroll->method."-".$auth]) )
    {
        View::setContentTemplateFile($tA[$gorumroll->list."-".$gorumroll->method."-".$auth]);
    }
    elseif( isset($tA[$gorumroll->list."-".$gorumroll->method]) )
    {
        View::setContentTemplateFile($tA[$gorumroll->list."-".$gorumroll->method]);
    }
    elseif( isset($tA[$gorumroll->list]) )
    {
        View::setContentTemplateFile($tA[$gorumroll->list]);
    }
}

function display( $what )
{
    global $withShoppingCart, $gorumrecognised, $gorumroll, $gorumuser;

    $_S = new AppSettings();
    $menuPoints = explode(",", $_S->menuPoints);
    hasAdminRights($isAdm);
    $_GS = new GlobalStat();
    switch( $what )
    {
    case Init_adminhelp:
    case Init_checkUpdates:
    case Init_confcheck:
    case Init_merchants:
    case Init_controlPanel:
        return $isAdm;
    case Init_registerNoah:
        return $isAdm ;
    case Init_search:
        return in_array(Settings_showSearch, $menuPoints);
    case Init_register:
        return in_array(Settings_showRegister, $menuPoints) && Init::display($what);
    case Init_login:
        return in_array(Settings_showLogin, $menuPoints) && Init::display($what);
    case Init_logout:
        return in_array(Settings_showLogout, $menuPoints) && Init::display($what);
    case Init_myProfile:
        return in_array(Settings_showMyProfile, $menuPoints) && Init::display($what);
    case Init_addItem:
        return  (in_array(Settings_showSubmitAd, $menuPoints) || $isAdm);
    case Init_home:
        return in_array(Settings_showHome, $menuPoints) && Init::display($what);
    case Init_catSubscriptions:
        return $isAdm && $gorumroll->list=="appcategory" &&
               $gorumroll->method=="showhtmllist" && $gorumroll->rollid &&
               $_S->notifyEnabled();
    case Init_mySubscriptions:
        return !$isAdm && $gorumrecognised && $_S->notifyEnabled();
    case Init_favorities:
        return !empty($gorumuser->favorities) && $_S->favoritiesEnabled();
    case Init_help:
        return !$isAdm && $gorumrecognised && in_array(Settings_displayHelp, $menuPoints);
    case Init_addCategory:
        return $isAdm;
    case Init_organizeCategory:
        return $isAdm && class_exists('rss');
    case Init_cloneCategory:
        return $isAdm && class_exists('rss') && $gorumroll->rollid && $gorumroll->list=="appcategory" && $gorumroll->method=="showhtmllist";
    case Init_modCategory:
    case Init_delCategory:
        return $isAdm && $gorumroll->rollid && $gorumroll->list=="appcategory" && $gorumroll->method=="showhtmllist";
    default:
        return Init::display($what);
    }
}

function makeLoginMenu()
{
    global $gorumuser, $gorumroll;
    global $gorumauthlevel, $gorumrecognised, $gorumcategory;
    global $lll;

    $_S = new AppSettings();
    $loginMenu = $userMenu = array();    
    if( $_S->joomlaLink )
    {
        $loginMenu["mainSite"]["link"]=$_S->joomlaLink;
        $loginMenu["mainSite"]["label"]=$lll["mainSite"];
    }
    if( $this->display( Init_register ))
    {
        $ctrl = new AppController("user/create_form");
        if( $_S->registrationLink ) $loginMenu["register"]["link"]=$_S->registrationLink;
        else $loginMenu["register"]["link"]=$ctrl->makeUrl();
        $loginMenu["register"]["label"]=$lll["register"];
    }
    if( $this->display( Init_login ))
    {
        $ctrl = new AppController("user/login_form");
        if( $_S->loginLink ) $loginMenu["login"]["link"]=$_S->loginLink;
        else $loginMenu["login"]["link"]=$ctrl->makeUrl();
        $loginMenu["login"]["label"]=$lll["login"];
    }
    if( $this->display( Init_logout ))
    {
        $ctrl = new AppController("user/logout");
        $loginMenu["logout"]["link"]=$ctrl->makeUrl();
        $loginMenu["logout"]["label"]=$lll["logout"];
    }
    // My profile:
    if( !$_S->registrationLink )
    {    
        if( $this->display( Init_myProfile ))
        {
            $ctrl = new AppController("user/modify_form");
            $userMenu["myProfile"]["link"]=$ctrl->makeUrl();
            $userMenu["myProfile"]["label"]=$lll["my_profile"];
        }
    }
    // Add item:
    if( $this->display( Init_addItem ))
    {
        // TODO:
        $ctrl = new AppController("item/create_form/$gorumcategory");
        $loginMenu["addAd"]["link"]=$ctrl->makeUrl();
        $loginMenu["addAd"]["label"]=$lll["item_newitem"];
    }
    // Recent added items:
    if( $this->display( Init_recentItems ))
    {
        $ctrl = new AppController("item_active/list");
        $loginMenu["recentAds"]["link"]=$ctrl->makeUrl();
        $loginMenu["recentAds"]["label"]=$lll["item_recent"];
    }
    // Most popular items:
    if( $this->display( Init_popularItems ))
    {
        $ctrl = new AppController("item_popular/list");
        $loginMenu["popularAds"]["link"]=$ctrl->makeUrl();
        $loginMenu["popularAds"]["label"]=$lll["item_popular"];
    }
    // Home link:
    if( $this->display( Init_home ))
    {
        $ctrl = new AppController("/");
        $loginMenu["home"]["link"]=$ctrl->makeUrl();
        $loginMenu["home"]["label"]=$lll["home"];
    }

    // Search form:
    if( $this->display( Init_search ))
    {
        // TODO:
        $ctrl = new AppController("search/create_form/$gorumcategory");
        $loginMenu["searchAds"]["link"]=$ctrl->makeUrl();
        $loginMenu["searchAds"]["label"]=$lll["search"];
    }
    if( $this->display( Init_mySubscriptions ))
    {
        $ctrl = new AppController("subscription_my/list");
        $userMenu["mySubscriptions"]["link"]=$ctrl->makeUrl();
        $userMenu["mySubscriptions"]["label"]=$lll["mySubscriptions"];
    }
    if( $this->display( Init_favorities ))
    {
        $ctrl = new AppController("item_favorities/list");
        $loginMenu["favorities"]["link"]=$ctrl->makeUrl();
        $loginMenu["favorities"]["label"]=$lll["favorities"];
    }
    if( $this->display( Init_help ))
    {
        $userMenu["help"]["link"]=$_S->helpLink;
        $userMenu["help"]["label"]=$lll["help"];
    }
    $this->addEcommMenuPoints($userMenu);
    View::assign("userMenu", $userMenu);
    View::assign("loginMenu", $loginMenu);
    View::assign("menu", array_merge($loginMenu, $userMenu));
    $this->makeCustomMenu(customlist_loginMenu, "customLoginMenuPoints");
    $this->makeCustomMenu(customlist_userMenu, "customUserMenuPoints");
}

function addEcommMenuPoints($userMenu)
{
}

function makeCustomMenu( $which, $templateAttrName )
{
    global $theme;
    
    if( $theme=="classic" ) 
    {
        if( $which==customlist_userMenu ) $where = "displayInMenu=$which OR displayInMenu=".customlist_loginMenu;
        elseif( $which==customlist_adminMenu ) $where = "displayInMenu=$which OR displayInMenu=".customlist_categoryMenu;
        else $where = "displayInMenu=$which";
    }
    else $where = "displayInMenu=$which";
    loadObjectsSql( $lists = new CustomList, "SELECT id, listTitle, displayedFor FROM @search WHERE $where ORDER BY id ASC", $lists );
    $customMenu = array_map(array('appinit', 'customListMapper'), array_filter($lists, array('customlist', 'customListFilter')));
    View::assign($templateAttrName, $customMenu);
}

function customListMapper( $v )
{
    $ctrl = new AppController("customlist/$v->id");
    return array("link"=>$ctrl->makeUrl(), "label"=>htmlspecialchars($v->getAttr("listTitle")));
}

function makeAdminMenu()
{
    global $gorumroll, $lll, $adminHelp, $merchantsLink, $updateLink;
    $menu1 = $menu2 = array();
    if( $this->display( Init_myProfile ))
    {
        $ctrl = new AppController("user/modify_form");
        $menu1["myProfile"]["link"]=$ctrl->makeUrl();
        $menu1["myProfile"]["label"]=$lll["my_profile"];
    }
    if( $this->display( Init_settings ))
    {
        $ctrl = new AppController("settings/modify_form");
        $menu1["settings"]["link"]=$ctrl->makeUrl();
        $menu1["settings"]["label"]=$lll["adminsett"];
    }
    if( $this->display( Init_content ))
    {
        $ctrl = new AppController("content/modify_form");
        $menu1["content"]["link"]=$ctrl->makeUrl();
        $menu1["content"]["label"]=$lll["contentManagement"];
    }
    // User list:
    if( $this->display( Init_userList ))
    {
        $ctrl = new AppController("user/list");
        $menu1["userList"]["link"]=$ctrl->makeUrl();
        $menu1["userList"]["label"]=$lll["users"];
    }
    // Approved items:
    if( $this->display( Init_activeItems ))
    {
        $ctrl = new AppController("item_active/list");
        $menu1["activeAds"]["link"]=$ctrl->makeUrl();
        $menu1["activeAds"]["label"]=$lll["item_Active"];
    }
    // Pending items:
    if( $this->display( Init_inactiveItems ))
    {
        $ctrl = new AppController("item_inactive/list");
        $menu1["inactiveAds"]["link"]=$ctrl->makeUrl();
        $menu1["inactiveAds"]["label"]=$lll["item_Inctive"];
    }
    // Cronjobs:
    if( $this->display( Init_cronjobs ))
    {
        $ctrl = new AppController("cronjob/list");
        $menu1["cronjobs"]["link"]=$ctrl->makeUrl();
        $menu1["cronjobs"]["label"]=$lll["Cronjobs"];
    }
    // Notifications:
    if( $this->display( Init_notifications ))
    {
        $ctrl = new AppController("notification/list");
        $menu1["notifications"]["link"]=$ctrl->makeUrl();
        $menu1["notifications"]["label"]=$lll["Notifications"];
    }
    // Create category:
    if( $this->display( Init_addCategory ))
    {
        // TODO:
        $ctrl = new AppController("cat/create_form/$gorumroll->rollid");
        $menu2["addCategory"]["link"]=$ctrl->makeUrl();
        $menu2["addCategory"]["label"]=$lll["category_newitem"];
    }
    // Category organizer:
    if( $this->display( Init_organizeCategory ))
    {        
        // TODO:
        $ctrl = new AppController("cat/organize_form");
        $menu2["organizeCategory"]["link"]=$ctrl->makeUrl();
        $menu2["organizeCategory"]["label"]=$lll["category_organize"];
    }
    // Clone category:
    if( $this->display( Init_cloneCategory ))
    {        
        // TODO:
        $ctrl = new AppController("clonecat/create_form/$gorumroll->rollid");
        $menu2["cloneCategory"]["link"]=$ctrl->makeUrl();
        $menu2["cloneCategory"]["label"]=$lll["category_clone"];
    }
    // Modify category:
    if( $this->display( Init_modCategory ))
    {
        $ctrl = new AppController("cat/modify_form/$gorumroll->rollid");
        $menu2["modifyCategory"]["link"]=$ctrl->makeUrl();
        $menu2["modifyCategory"]["label"]=$lll["category_mod"];
    }
    // Delete category:
    if( $this->display( Init_delCategory ))
    {
        $ctrl = new AppController("cat/delete_form/$gorumroll->rollid");
        $menu2["deleteCategory"]["link"]=$ctrl->makeUrl();
        $menu2["deleteCategory"]["label"]=$lll["category_del"];
    }

    if( $this->display( Init_adminhelp ))
    {
        $menu1["adminHelp"]["link"]=$adminHelp;
        $menu1["adminHelp"]["label"]=$lll["help"];
    }
    if( $this->display( Init_checkUpdates ))
    {
        //$ctrl = new AppController("checkconf/updates");
        $menu1["checkUpdates"]["link"]=$updateLink;
        $menu1["checkUpdates"]["label"]=$lll["checkUpdates"];
    }
    if( $this->display( Init_registerNoah ))
    {
        $ctrl = new AppController("checkconf/register");
        $menu1["registerNoah"]["link"]=$ctrl->makeUrl();
        $menu1["registerNoah"]["label"]=$lll["registerNoah"];
    }
    if( $this->display( Init_merchants ))
    {
        $menu1["merchants"]["link"]=$merchantsLink;
        $menu1["merchants"]["label"]=$lll["merchants"];
    }
    if( $this->display( Init_controlPanel ))
    {
        $ctrl = new AppController("controlpanel/showhtmllist");
        $menu1["controlPanel"]["link"]=$ctrl->makeUrl();;
        $menu1["controlPanel"]["label"]=$lll["controlPanel"];
    }
    if( $this->display( Init_confcheck ))
    {
        $ctrl = new AppController("checkconf/show");
        $menu1["checkConfiguration"]["link"]=$ctrl->makeUrl();
        $menu1["checkConfiguration"]["label"]=$lll["checkconf"];
    }
    if( $this->display( Init_catSubscriptions ))
    {
        $ctrl = new AppController("subscription_cat/list/$gorumroll->rollid");
        $menu2["categorySubscriptions"]["link"]=$ctrl->makeUrl();
        $menu2["categorySubscriptions"]["label"]=$lll["catSubscriptions"];
    }
    if( $this->display( Init_rss ))
    {
        $ctrl = new AppController("rss/modify_form/1");
        $menu1["rss"]["link"]=$ctrl->makeUrl();
        $menu1["rss"]["label"]=$lll["rss"];
    }
    hasAdminRights($isAdm);
    $this->addEcommMenuPoints($menu1);
    if( $isAdm ) View::assign("userMenu", $menu1);
    View::assign("categoryMenu", $menu2);
    if( $isAdm ) View::assign("adminMenu", array_merge($menu1, $menu2));
    else View::assign("adminMenu", array());
    $this->makeCustomMenu(customlist_categoryMenu, "customCategoryMenuPoints");
    $this->makeCustomMenu(customlist_adminMenu, "customAdminMenuPoints");
}

function showInfoText()
{
    global $infoText;
    
    $s="";
    if( !empty($infoText) ) $s=$infoText;
    else $s = LocationHistory::getInfoText();
    if( $s && is_callable(array("ThemeConfig", "showInfoText")) ) ThemeConfig::showInfoText($s);
    return $s;
}

function showSelector( $what )
{
    global $lll;
    
    $_S = new AppSettings(); 
    if( !$_S->{"allowSelect{$what}"} ) return "";
    
    $labels = array($lll["change{$what}"]);
    $values = array("0");
    $allowedItems = explode(",", $_S->{"allowed{$what}s"});
    foreach( $allowedItems as $item ) 
    {
        $values[$item]=$item;
        if( isset($lll["allowed{$what}s_$item"]) )
        {
            $labels[$item] = $lll["allowed{$what}s_$item"];
        }
        else
        {
            $labels[$item] = str_replace("_", " ", $item);
        }
    }
    JavaScript::addInclude(GORUM_JS_DIR . "/cookie.js");
    $base = Controller::getBaseUrl();
    JavaScript::addOnload("$.noah.themeSelectorWidget(" . G::js($what, $base) . ")");
    return GenerWidget::generSelectField("{$what}SelectorWidget",$labels,$values,"{$what}SelectorWidget","0");

}

}
?>
