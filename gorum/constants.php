<?php
defined('_NOAH') or die('Restricted access');

if( checkNoahConfigFile() ) include($CONFIG_FILE_DIR. "/config.php");

ini_set("xdebug.collect_params", 2);
ini_set("xdebug.collect_return", 1);

define( "Loginlib_NewUser", 1 );
define( "Loginlib_GuestLevel", 2 );
define( "Loginlib_BasicLevel", 3 );
define( "Loginlib_LowLevel", 4 );
define( "Loginlib_ExpirationDate", 2000000000 );

define( "User_noUserFromGorum", 0 );
define( "User_simpleReg", 1 );
define( "User_emailCheck", 2 );
define( "User_adminApproval", 3 );
define( "User_checkNumber", 4 ); // meg nem implementalt
define( "User_highLevel", 5 ); 
define( "User_name_nocheck", 11 );

define( "Explanation_no", 0 );
define( "Explanation_text", 1 );
define( "Explanation_qhelp", 2 );
define( "Explanation_popup", 3 );

define( "Form_visible", 1 );
define( "Form_hidden", 2 );
define( "Form_invisible", 3 );
define( "Form_readonly", 4 );

define("search_all",1);
define("search_any",2);

define("Init_register",10);
define("Init_login",20);
define("Init_loginDifferent",30);
define("Init_cangePwd",40);
define("Init_logout",50);
define("Init_myProfile",60);
define("Init_myItems",70);
define("Init_addItem",80);
define("Init_recentItems",90);
define("Init_popularItems",100);
define("Init_search",110);
define("Init_home",120);
define("Init_settings",130);
define("Init_modStyle",140);
define("Init_userList",150);
define("Init_activeItems",170);
define("Init_inactiveItems",180);
define("Init_cronjobs",190);
define("Init_notifications",200);
define("Init_addCategory",210);
define("Init_modCategory",220);
define("Init_delCategory",230);
define("Init_organizeCategory",240);
define("Init_content",250);

define("Notification_initialPassword", 1);
define("Notification_remindPassword", 2);

$maxInputLength=40;
$maxFieldLength=250;

$showIcon = FALSE;
$autoLogout = FALSE;
$autoLogoutTime = 0;
$boxWidthFrame = FALSE;
$boxShadow = FALSE;
$vertSpacer="10";
$saveSearchSupport=FALSE;
$chAdmAct=FALSE;
$enableCsvExport=FALSE;
$htmlNotifications=FALSE;
$emailAccount=FALSE;
$methodsAtTheEnd=FALSE;
$withShoppingCart=FALSE;
$suppressErrors=TRUE;
$includeGuestsInCurrentlyOnline=TRUE;

$necessaryAuthLevel=Loginlib_BasicLevel;
$rangeBlockSize = 10;

$textAreaRows = 10;
$textAreaCols = 50;
$showExplanation = Explanation_qhelp;
$minPasswordLength = 1;
$language = "en";
$registrationType = User_simpleReg;

$listPresentationClassName = "ListPresentation";
$formPresentationClassName = "FormPresentation";
$deleteFormPresentationClassName = "DeleteFormPresentation";
$detailsPresentationClassName = "DetailsPresentation";
$cookiePath = "/";
$treeIdxBase = 1073741824;
$yahooStylePagerTool = FALSE;
$showFirstLast = TRUE;
$showPrevNextText = FALSE;
$showPrevNextIcon = FALSE;

$contextSensitiveHTMLTitles = FALSE;
$dieOnError = TRUE;

$autoImapUserCreateMode = FALSE;
$traceSqlQueries = FALSE;
$sqlQueryDump = "";

define("ok",0);
define("nok",1);
define("already_in_db",3);
define("permission_denied",5);
define("deep_struct",10);
define("no_father",11);
define("input_param",12);
define("general_mysql_error",51);
define("not_found_in_db",52);
define("cannot_connect_to_server",53);
define("cannot_create_db",54);
define("select_db_failed",55);
define("wrong_object",101);
define("no_such_user",1102);
define("mysql_host_error",1301);
define("mysql_access_denied",1302);
define("mysql_connect_error",1303);

if (!defined("SWIFT_SMTP_ENC_TLS")) define("SWIFT_SMTP_ENC_TLS", 2);
if (!defined("SWIFT_SMTP_ENC_SSL")) define("SWIFT_SMTP_ENC_SSL", 4);
if (!defined("SWIFT_SMTP_ENC_OFF")) define("SWIFT_SMTP_ENC_OFF", 8);
if (!defined("SWIFT_LOG_NOTHING")) define("SWIFT_LOG_NOTHING", 0);
if (!defined("SWIFT_LOG_ERRORS")) define("SWIFT_LOG_ERRORS", 1);
if (!defined("SWIFT_LOG_FAILURES")) define("SWIFT_LOG_FAILURES", 2);
if (!defined("SWIFT_LOG_NETWORK")) define("SWIFT_LOG_NETWORK", 3);
if (!defined("SWIFT_LOG_EVERYTHING")) define("SWIFT_LOG_EVERYTHING", 4);

function checkNoahConfigFile()
{
    global $CONFIG_FILE_DIR;
    if( strstr($_SERVER["SCRIPT_NAME"], "install.php") ) return FALSE;
    if( @fopen($CONFIG_FILE_DIR. "/config.php","r")===FALSE )
    {
        echo <<< EOF
            <head>
                <meta http-equiv='refresh' content='3;url=install.php'>
            </head>
            <body bgcolor='white'>
                It seems that Noah's Classifieds is not installed on your system.
                <br><br>
                You will be forwarded to the installation process.
                <br><br>
                If your browser doesn't forward you, please click
                <a href='install.php'>here</a>.
            </body>
EOF;
die();
    }    
    return TRUE;
}

function initDefaultLanguage()
{
    global $language, $lll;
    
    $language="en";
    include(LANG_DIR . "/lang_$language.php");
    include(LANG_DIR . "/lang_admin_$language.php");
}

?>
