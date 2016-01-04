<?php
defined('_NOAH') or die('Restricted access');
$settings_typ =  
    array(
        "attributes"=>array(   
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),            
            "expirationProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "expNoticeBefore"=>array(
                "type"=>"INT",
                "text",
                "default"=>5, //days
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "renewal"=>array(
                "type"=>"INT",
                "text",
                "lenght"=>"3",
                "default"=>"5",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "deleteAdsOnExpiry"=>array(
                "type"=>"INT",
                "bool",
                "default"=>1,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "imageProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "maxPicSize"=>array(
                "type"=>"INT",
                "text",
                "lenght"=>"7",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "maxPicWidth"=>array(
                "type"=>"INT",
                "text",
                "lenght"=>"4",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "maxPicHeight"=>array(
                "type"=>"INT",
                "text",
                "lenght"=>"4",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "downsizeWidth"=>array(
                "type"=>"INT",
                "text",
                "lenght"=>"4",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "downsizeHeight"=>array(
                "type"=>"INT",
                "text",
                "lenght"=>"4",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "menuPointsSep"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "logoImage"=>array(
                "type"=>"VARCHAR",
                "file",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "headerBackground"=>array(
                "type"=>"VARCHAR",
                "file",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "menuPoints"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "checkbox",
                "cols"=>2,
                "values"=>array(2, 3, 4,5 ,6 ,7, 10, 11, 12),
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "extraHead"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>'740px',
                "rows"=>5,
                "allow_html",
                "markitup"=>array("set"=>"head", "previewParserVar"=>"extraHead"),
                "widecontent_form",
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "extraBody"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>'740px',
                "rows"=>5,
                "allow_html",
                "markitup"=>array("set"=>"html", "previewParserVar"=>"extraBody"),
                "widecontent_form",
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "extraTopContent"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>'740px',
                "rows"=>5,
                "allow_html",
                "markitup"=>array("set"=>"html", "previewParserVar"=>"extraTopContent"),
                "widecontent_form",
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "extraBottomContent"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>'740px',
                "rows"=>5,
                "allow_html",
                "markitup"=>array("set"=>"html", "previewParserVar"=>"extraBottomContent"),
                "widecontent_form",
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "extraFooter"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>'740px',
                "rows"=>5,
                "allow_html",
                "markitup"=>array("set"=>"html", "previewParserVar"=>"extraFooter"),
                "widecontent_form",
                "conditions"=>array("\$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "themeProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "defaultTheme"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "selection",
                "default"=>"modern",
                "values"=>array(),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "allowSelectTheme"=>array(
                "type"=>"INT",
                "bool",
                "default"=>1,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
                //"show_relation"=>"allowSelectTheme"
            ),
            "allowedThemes"=>array(
                "type"=>"TEXT",
                "multipleselection",
                //"relation"=>"allowSelectTheme",
                "values"=>array(),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "languageProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "defaultLanguage"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "selection",
                "default"=>"en",
                "values"=>array(),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "allowSelectLanguage"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                //"show_relation"=>"allowSelectLanguage"
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "allowedLanguages"=>array(
                "type"=>"TEXT",
                "multipleselection",
                //"relation"=>"allowSelectLanguage",
                "values"=>array(),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "langDir"=>array(
                "type"=>"VARCHAR",
                "max"=>3,
                "radio",
                "cols"=>1,
                "default"=>"ltr",
                "values"=>array("ltr", "rtl"),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "mailProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "adminEmail"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "adminFromName"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "replytoEmail"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "replytoName"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "smtpServer"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "smtpUser"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "smtpPass"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "smtpPort"=>array(
                "type"=>"VARCHAR",
                "max"=>5,
                "text",
                "length"=>5,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "smtpSecure"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>3,
                "values"=>array(SWIFT_SMTP_ENC_OFF, SWIFT_SMTP_ENC_TLS, SWIFT_SMTP_ENC_SSL),
                "default"=>SWIFT_SMTP_ENC_OFF,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "fallBackNative"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "swiftLog"=>array(
                "type"=>"INT",
                "selection",
                "values"=>array(SWIFT_LOG_NOTHING, SWIFT_LOG_ERRORS, SWIFT_LOG_FAILURES, SWIFT_LOG_NETWORK, SWIFT_LOG_EVERYTHING),
                "default"=>"0", //SWIFT_LOG_NOTHING
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "seoProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "titlePrefix"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "mainTitle"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "mainDescription"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>50,
                "rows"=>5,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "mainKeywords"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>50,
                "rows"=>5,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "enablePermalinks"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "show_relation"=>"enablePermalinks",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "ommitCatPermaLink"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "relation"=>"enablePermalinks",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "adDisplayProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "charLimit"=>array(
                "type"=>"INT",
                "text",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "blockSize"=>array(
                "type"=>"INT",
                "text",
                "length"=>"5",
                "min" =>"1",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "dateFormat"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "timeFormat"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "linksAndDefaultPages"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "homeLocation"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "loginLink"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "registrationLink"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "redirectFirstLogin"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "redirectLogin"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "redirectAdminLogin"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "joomlaLink"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "helpLink"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "enableDisableProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "applyCaptcha"=>array(
                "type"=>"VARCHAR",
                "max"=>20,
                "checkbox",
                "values"=>range(Settings_response, Settings_submitAd),
                "cols"=>1,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "captchaType"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"0",  // default captcha
                "cols"=>"1",
                "values"=>array(captcha_default, captcha_recaptcha),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible"),
                "show_relation"=>array(1=>"recaptcha")                
            ),
            "recaptchaPublicKey"=>array(
                "type"=>"VARCHAR",
                "text",
                "mandatory",
                "max"=>255,
                "min"=>1,
                "relation"=>"recaptcha",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "recaptchaPrivateKey"=>array(
                "type"=>"VARCHAR",
                "text",
                "mandatory",
                "max"=>255,
                "min"=>1,
                "relation"=>"recaptcha",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "allowModify"=>array(
                "type"=>"INT",
                "bool",
                "default"=>1,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "enableFavorities"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"5",  // all but admin
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forManager, customfield_forAllButAdmin),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "subscriptionType"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"5",  // all but admin
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forManager, customfield_forAllButAdmin),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")                
            ),
            "enableUserSearch"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"1",  // all
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forManager),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")                
            ),
            "cascadingCategorySelect"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),            
            "displayResponseLink"=>array(
                "type"=>"INT",
                "radio",
                "safetext",
                "default"=>"1",  // customfield_forAll
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forManager, customfield_forAllButAdmin),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "displayFriendmailLink"=>array(
                "type"=>"INT",
                "radio",
                "safetext",
                "default"=>"1",  // customfield_forAll
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forManager, customfield_forAllButAdmin),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "displayFlaggedLink"=>array(
                "type"=>"INT",
                "radio",
                "safetext",
                "default"=>"1",  // customfield_forAll
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forManager, customfield_forAllButAdmin),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "ecommerceEnabled"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>"1",
                "default"=>Settings_ecommTestMode,  
                "values"=>array(Settings_ecommDisabled, Settings_ecommEnabled, Settings_ecommTestMode),
                "conditions"=>array("\$gorumroll->list=='appsettings_content' || !file_exists(ECOMM_DIR)"=>"form invisible")                
            ),
            "otherProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "maxMediaSize"=>array(
                "type"=>"INT",
                "text",
                "lenght"=>"7",
                "default"=>"50000",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "showExplanation"=>array(
                "form invisible",
                "type"  =>"TINYINT",
                "values"=>array(Explanation_text,
                                Explanation_qhelp,
                                Explanation_no),
                "selection",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "versionFooter"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>50,
                "rows"=>5,
                "conditions"=>array("!class_exists('rss') || \$gorumroll->list=='appsettings'"=>"form invisible")
            ),
            "customAdListTemplate"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
             ),
            "templateDebug"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),            
            "alternativeOrganizer"=>array(
                "type"=>"INT",
                "default"=>"0",
            ),            
            "enableCombine"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),            
            "oodleProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
            "enableOodle"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),          
/*              
            "oodleSerial"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>255,
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),
*/            
            "oodleLocation"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "selection",
                "default"=>"usa",
                "values"=>array(), //"canada","uk","usa","india","ireland"),
                "conditions"=>array("\$gorumroll->list=='appsettings_content'"=>"form invisible")
            ),


        ),
        "primary_key"=>"id",
        "conditions"=>array("\$gorumroll->list=='appsettings'"=>"smartform")
    );
    
class AppSettings extends Settings
{
    
function get_table()
{
    return "settings";
}

function modifyForm()
{
    global $gorumroll;
    
    $gorumroll->rollid=1;
    if( $gorumroll->list=="appsettings" )
    {
        $this->initDirectoryRelatedFields("Theme", THEMES_DIR);
        $this->initDirectoryRelatedFields("Language", LANG_DIR);
        $this->initOodleRegions();
    }
    Settings::modifyForm();
}

function initOodleRegions()
{
    global $lll, $settings_typ;

    $attrInfo = & $settings_typ["attributes"];
    $attrInfo["oodleLocation"]["values"]=array("canada","uk","usa","india","ireland");
}

function initDirectoryRelatedFields($what, $dirName)
{
    global $lll, $settings_typ;

    $attrInfo = & $settings_typ["attributes"];
    $attrInfo["allowed{$what}s"]["values"]=array();
    $attrInfo["default{$what}"]["values"]=array();
    $dir = opendir($dirName);
    while( ($file = readdir($dir)) !== false) 
    {
        if( $what=="Theme" )
        {
            if( (preg_match("/^\./", $file) || $file=="common_templates" || !is_dir(THEMES_DIR . "/$file")) ) continue;
            $item = $file;
        }
        else
        {
            // az admin language file-nak is leteznie kell:
            if( !preg_match("/lang_(\w{2})\.php/", $file, $matches) /*|| !file_exists("lang_admin_$matches[1].php")*/ ) continue;
            $item = $matches[1];
        }
        $attrInfo["allowed{$what}s"]["values"][]=$item;
        $attrInfo["default{$what}"]["values"][]=$item;
        if( !isset($lll["allowed{$what}s_$item"]) ) 
        {
            $lll["allowed{$what}s_$item"] = $lll["default{$what}_$item"] = ucfirst(str_replace("_", " ", $item));
        }
    }
    closedir($dir);
    $attrInfo["allowed{$what}s"]["size"]=min(10, count($attrInfo["default{$what}"]["values"]));
}

function modify() 
{
    global $lll, $siteDemo, $allowedMethods;
    
    $found=FALSE;
    if( $siteDemo || !class_exists('rss') )
    {
        // It is disabled to save these attributes in the demo version:
        foreach( array("extraHead", "extraBody", "extraTopContent", "extraBottomContent", "extraFooter", "logoImage", "headerBackground") as $attr )
        {
            if( !empty($this->$attr) )
            {
                $found=TRUE;
                $this->$attr="";
            }
        }
    }
    
    foreach( array("homeLocation", "redirectFirstLogin", "redirectLogin", "redirectAdminLogin") as $attr )
    {
        $ctrl = new AppController();
        if( $this->$attr )
        {
            if( !$ctrl->init($this->$attr) || !isset($allowedMethods[$ctrl->method]) || !class_exists($ctrl->getClass())) 
            {
                return Roll::setFormInvalid("invalidInternalLink", $this->$attr);
            }
        }
    }

/*
   if (!empty($this->oodleSerial))
   {
       $returned = $this->validate_oodle_license();
       if ($returned[status] != 'active')
          return Roll::setFormInvalid("oodleSerial_invalid");
   } 
*/

    modify($this);
    
    $this->uploadImages();
    if( $found ) Roll::setInfoText("This feature is not available in the Lite (and demo) version of the program!");
}   

/*
function validate_oodle_license()
{
    
    $returned=oodlelicensing::verifyOodle($this->oodleSerial);
    return $returned;
}
*/
function showSubmitAd()
{
    return in_array(Settings_showSubmitAd, explode(",", $this->menuPoints));
}

function initThemeProperties()
{
    global $theme, $keysToCssFiles, $keysToJsFiles;
    
    $theme = $this->defaultTheme;
    if( isset($_COOKIE["noahTheme"]) && file_exists(THEMES_DIR . "/$_COOKIE[noahTheme]") ) $theme = $_COOKIE["noahTheme"];
    defined('THEME_DIR') or define("THEME_DIR", THEMES_DIR . "/$theme");
    defined('JS_DIR') or define("JS_DIR", THEME_DIR . "/javascripts");
    defined('CSS_DIR') or define("CSS_DIR", THEME_DIR . "/css");
    defined('TEMPLATE_DIR') or define("TEMPLATE_DIR", THEME_DIR . "/templates");
    defined('IMAGES_DIR') or define("IMAGES_DIR", THEME_DIR . "/images");
    $dir = opendir(CSS_DIR);
    while( ($file = readdir($dir)) !== false) 
    {
        if( strstr($file, '.css') ) $keysToCssFiles[$theme."@".substr($file, 0, -4)] = CSS_DIR . "/$file";
    }
    closedir($dir);
    $keysToJsFiles[$theme] = THEME_DIR . "/javascripts/$theme.js";
}

function initLanguageProperties()
{
    global $language;

    $language = $this->defaultLanguage;
    if( isset($_COOKIE["noahLanguage"]) && file_exists(LANG_DIR . "/lang_$_COOKIE[noahLanguage].php") ) $language = $_COOKIE["noahLanguage"];
}

function getPageTitle()
{
    return $this->getAttr("mainTitle");
}

function getPageDescription()
{
    return $this->getAttr("mainDescription");
}

function getPageKeywords()
{
    return $this->getAttr("mainKeywords");
}

function getTitlePrefix()
{
	return $this->getAttr("titlePrefix");
}

function favoritiesEnabled()
{
    $_GS = new GlobalStat;
    return (class_exists("response") || $_GS->creationtime->isLessThan(new Date("2008-05-13"))) &&
           $this->isEnabled("enableFavorities");
}

function notifyEnabled()
{
    return class_exists("response") && $this->isEnabled("subscriptionType");
}

function isEnabled( $what )
{
    global $gorumrecognised;
    hasAdminRights($isAdm);
    hasManagerRights($isManager);    
    // hogy ne csak egy attributumnevvel, hanem egy attributumertekkel 
    // is fel lehessen hivni statikusan:
    $value = is_numeric($what) ? $what : $this->$what;
    return ($value==customfield_forAll ||
        ($value==customfield_forManager && $isManager) ||
        ($value==customfield_forAdmin && $isAdm) ||
        ($value==customfield_forAllButAdmin && !$isAdm) ||
        ($value==customfield_forLoggedin && $gorumrecognised));
}

function getProAttr($what)
{
    return class_exists("response") ? $this->$what : "";
}

function save()
{
    global $settings_typ, $siteDemo;
    
    hasAdminRights($isAdm);
    if(!$isAdm) handleErrorPerm( __FILE__, __LINE__ );
    if( $siteDemo ) 
    {
        echo "MIU:DISABLED";
        die();
    }
    foreach( $_POST as $attr=>$val )
    {
        if( isset($settings_typ["attributes"][$attr]) )
        {
            executeQuery("UPDATE @settings SET $attr=#val# WHERE id=1", $val);
        }
    }
    echo "MIU:OK";
    die();
}

function ecommerceEnabled()
{
    global $gorumuser, $gorumrecognised, $gorumroll;
    
    if( !EComm::isEnabledGlobally() ) return FALSE;
    hasAdminRights($isAdm);
    return isset($this->ecommerceEnabled) && 
           ($this->ecommerceEnabled==Settings_ecommEnabled || 
           ($this->ecommerceEnabled==Settings_ecommTestMode && 
               ($isAdm || 
               ($gorumrecognised && $gorumuser->name=="ecommtest") || 
               (isset($gorumroll) && $gorumroll->list=="purchase" && ($gorumroll->method=="silent_post" || $gorumroll->method=="relay_response")))));
}

function handleCategorySelect($tableId, $excludeAdminOnlySubmitCats=FALSE)
{
    global $gorumroll, $jQueryLib;
    
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addInclude(JS_DIR . "/categoryselect.js");
    if( $this->cascadingCategorySelectEnabled() && !$gorumroll->rollid && $gorumroll->list!="customlist" )
    {
        $method = "get_one_level_of_categories";
        if( $excludeAdminOnlySubmitCats ) $method.="_without_adminonly_submit";
        $ctrl = new AppController("cat/$method");  // Ajax target
        $url = $ctrl->makeUrl();
        JavaScript::addScript("\$JQ.noah.addNextSelectRow(" . G::js($url, "subCategory", $tableId) . ");");
        JavaScript::addOnload("$.noah.cascadingSelectOnLoad('$tableId');");
    }
    elseif( !$this->cascadingCategorySelectEnabled() || $gorumroll->list=="customlist")
    {        
        JavaScript::addOnload("$.noah.simpleCategoryReload();");
    }
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
    
    $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    $navBarPieces[$gorumroll->list=="appsettings_content" ? $lll["contentManagement"] : $lll["adminsett"]] = "";
    return $navBarPieces;
}

function uploadImages()
{
    global $siteDemo;
    if( !class_exists('rss') || $siteDemo ) return;    
    $err = "";
    //$pattern = "{(\\<div id='header'\\>\\<img src='\\<\\?php echo \\\$this->imagesDir \\?\\>)(/[^']+)('\\>\\</div\\>)}ms";
    $pattern = '{(/.+\?logoImage)|(/headpic\.gif)}';
    $this->uploadImagesCore("logoImage", TEMPLATE_DIR."/layout.tpl.php", $pattern, $err );
    if( $err ) return Roll::setFormInvalid($err);
    $pattern = '{(/[^/]+\?headerBackground)|(/top_shadow\.jpg)}';
    $this->uploadImagesCore("headerBackground", CSS_DIR."/layout.css", $pattern, $err );
    if( $err ) return Roll::setFormInvalid($err);
}

function uploadImagesCore($attr, $fileName, $pattern, &$err)
{
    global $lll;
    
    if( empty($_FILES[$attr]["name"]) || $_FILES[$attr]["size"]==0 || !is_uploaded_file($_FILES[$attr]["tmp_name"]) ) return;
    $fname=$_FILES[$attr]["tmp_name"];
    if( !($size = getimagesize( $fname )) ) 
    {
        $err = $lll["notValidImageFile"];
        return;
    }
    $type = $size[2]; // az image tipus, 1=>GIF, 2=>JPG, 3=>PNG
    $extensions = array("", "gif", "jpg", "png");
    if (!isset($extensions[$type]) ) 
    {
        $err = $lll["notValidImageFile"];
        return;
    }
    $basename = "/".basename($_FILES[$attr]['name']);
    $uploadfile = IMAGES_DIR . $basename;
    
    if( !move_uploaded_file($_FILES[$attr]['tmp_name'], $uploadfile) ) 
    {
        $err = sprintf($lll["noPermissionDir"], IMAGES_DIR);
        return;
    }
    // attempt to chmod the file, so that an FTP user can have read and write access to it, too:
    chmod($uploadFile, 0666);
    if( !($s = file_get_contents($fileName)) || !($f = fopen($fileName, "w") ) )
    {
        $err = sprintf($lll["noPermissionFile"], $fileName);
        return;
    }
    $s = preg_replace($pattern, "$basename?$attr", $s);
    fwrite($f, $s);
    fclose($f);
    if( $attr=="headerBackground" )
    {
        $dir = opendir(FEED_DIR);
        while( ($f = readdir($dir)) !== false) 
        {
            if( (preg_match("/cache.*css/", $f) )) unlink(FEED_DIR."/$f");
        }
    }
}

function cascadingCategorySelectEnabled()
{
    return class_exists("rss") && $this->cascadingCategorySelect;
}

function permaLinksEnabled()
{
    return class_exists("rss") && !empty($this->enablePermalinks);
}

}    
?>
