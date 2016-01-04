<?php
defined('_NOAH') or die('Restricted access');
$noahVersions = array("2.0.0", "2.0.1", "2.0.2", "2.1.0", "2.1.1", "2.1.2", 
                      "2.2.0", "2.2.1", "2.2.2", "2.3.0", "2.3.1", "2.4.0", 
                      "2.4.1", "3.0.0", "3.0.1", "3.0.2", "3.1.0", "3.1.1", 
                      "3.1.2", "3.1.3", "3.1.4", "3.2.0", "4.0.0", "4.0.1",
                      "4.0.2", "4.0.3", "4.1.0", "4.1.1", "4.1.2", "4.1.3",
                      "5.0.0", "5.0.1", "5.0.2", "5.0.3", "5.0.4", "5.0.5",
                      "6.0.0", "6.1.0", "7.0.0","7.0.1");
$noahVersion = $noahVersions[count($noahVersions)-1];

define("GORUM_DIR", NOAH_BASE . "/gorum");
define("ECOMM_DIR", NOAH_BASE . "/ecomm");
include(GORUM_DIR . "/constants.php");

$seoSeparator="_";
$language="en";
$phpVersionMin="5.0.0"; //"4.3.0";
$mySqlVersionMin="4.0.0";

// Directories for the uploaded item and category pictures:
define("AD_PIC_DIR", NOAH_BASE . "/pictures/listings");
define("USER_PIC_DIR", NOAH_BASE . "/pictures/users");
define("CAT_PIC_DIR", NOAH_BASE . "/pictures/cats");
define("UPLOAD_DIR", NOAH_BASE . "/upload");
define("USER_UPLOAD_DIR", NOAH_BASE . "/upload/users");
define("THEMES_DIR", NOAH_BASE . "/themes");
define("LANG_DIR", NOAH_BASE . "/lang");
define("COMMON_TEMPLATES", THEMES_DIR . "/common_templates");
define("FEED_DIR", NOAH_BASE . "/feedcreator");
define("CACHE_DIR", NOAH_BASE . "/feedcreator");
define("GORUM_JS_DIR", GORUM_DIR . "/js");
define("GORUM_TEMPLATE_DIR", GORUM_DIR . "/templates");
define("JS_DIR", NOAH_BASE . "/js");
define("ECOMM_LANG_DIR", "/lang");

$gorumlisttemplate = "default_list.tpl.php";
$gorumformtemplate = "default_form.tpl.php";
$gorumdetailstemplate = "default_details.tpl.php";
$gorumdeleteformtemplate = "default_deleteform.tpl.php";
$thumbnailSizes = array(
    "small" =>array("width"=>55, "height"=>41),  // used as the small thumbnails on the ad details pages
    "medium"=>array("width"=>120, "height"=>90), // used in the ad lists
    "large" =>array("width"=>187, "height"=>140), // used as the large thumbnail on the ad details pages
    "big" =>array("width"=>300, "height"=>225) // used as the largest thumbnail on the ad details pages
    );

// error handling
$errorReportingLevel = 2047;
define("LOG_DIR", NOAH_BASE . "/logs");
$logExtension = "html";
$errorFileSizeLimit = 1024*1024; // 1M
// The program stores only the last 10 error log files - this can take 10M altogether if the file size limit is 1M
$maxNumberOfArchivedErrorFiles = 10;  

// Private - don't change the rest of the file:
$scriptName = "index.php";

$blockSortDirection="lastBlockLast";

$dbClasses[]="settings";
$dbClasses[]="globalstat";
$dbClasses[]="customfield";
$dbClasses[]="search";
$dbClasses[]="category";
$dbClasses[]="item";
$dbClasses[]="subscription";
$dbClasses[]="user";
$dbClasses[]="notification";
//$dbClasses[]="fieldcolumn";

$dbSettings = TRUE;
$showIcon = FALSE;
$noTreeIdx = TRUE;
$showExplanation=1; 
$rangeBlockSize=5;
$showPrevNextIcon = TRUE;
$noCookieCount = TRUE;
$saveSearchSupport=FALSE;
$registrationType = 2;
$defaultMethod = "showhtmllist";
$defaultList = "appcategory";
$defaultRollId = 0;
$withShoppingCart=FALSE;
$adminHelp = "http://noahsclassifieds.org/documentation";
$merchantsLink = "http://owners.noahsclassifieds.org";
$updateLink ="http://noahsclassifieds.org/update.html";
$dontRemoveInstallFiles=FALSE;
$siteDemo=FALSE;
$firePHP=FALSE;
$deleteInactiveGuestsAfterDays = 7;
$deleteInactiveGuestsWithFavoritiesAfterDays = 30;
$deleteNonActivatedRegistrationsAfterDays = 30;
$defaultPrecisionSeparator = ".";
$defaultThousandsSeparator = ",";
$navBarSeparator = " &raquo; ";
$paginateCategoryOrganizerFromNumberOfCats = 100;
$useHtmlInEnumValues = FALSE;
$useHtmlInCustomFieldNames = FALSE;

$noahsHost = "noahsclassifieds.net";
$noahsRegisterScript = "/versioninfo/register.php";
$noahsVersionCheckScript = "/versioninfo/get_version_info.php";
$noahsUpdateScript = "/versioninfo/get_update.php";

define("Cronjob_checkExpiration", 1);
define("Cronjob_deleteExpired", 2);
define("Cronjob_deleteInactiveUsers", 3);
define("Cronjob_downloadOodle", 4);

// Notifications
define("Notification_adCreated", 101);
define("Notification_adDeleted", 102);
define("Notification_adExpired", 103);
define("Notification_adApproved", 104);
define("Notification_adReply", 105);
define("Notification_adToAFriend", 106);
define("Notification_newPurchase", 108);
define("Notification_autoNotify", 109);
define("Notification_adCreatedOwner", 110);
define("Notification_adFlagged", 111);

// Customfield types:
define("customfield_text", 1);
define("customfield_textarea", 2);
define("customfield_bool", 3);
define("customfield_selection", 4);
define("customfield_separator", 5);
define("customfield_multipleselection", 6);
define("customfield_checkbox", 7);
define("customfield_picture", 8);
define("customfield_url", 9);
define("customfield_media", 10);
define("customfield_date", 11);

define("customfield_title", 1);
define("customfield_description", 2);
define("customfield_keywords", 3);

// Captcha types
define("captcha_default", 0);
define("captcha_recaptcha",1);
// Display types
define("customfield_nopic", 0);
define("customfield_thumbnail", 2);
define("customfield_mouseover", 3);
define("customfield_inlineThumbnail", 4);
define("customfield_inlineMouseover", 5);

// Field visibility
define("customfield_forNone", 0);
define("customfield_forAll", 1);
define("customfield_forLoggedin", 2);
define("customfield_forOwner", 3);
define("customfield_forAdmin", 4);
define("customfield_forAllButAdmin", 5);
define("customfield_forAllInCreateButAdminInModify", 6);
define("customfield_forManager", 7);
define("customfield_forAllInCreateButManagerInModify", 8);

// Orientation
define("customfield_top", 1);
define("customfield_left", 2);
define("customfield_bottom", 3);
define("customfield_right", 4);

define("customfield_alnum", 1);
define("customfield_integer", 2);
define("customfield_float", 3);

define("customfield_normal", 0);
define("customfield_topright", 1);
define("customfield_bottomright", 2);

define("customlist_normal", 0);
define("customlist_scrollable", 1);

define("customlist_aboveContent", 0);
define("customlist_belowContent", 1);
define("customlist_top", 2);
define("customlist_bottom", 3);
define("customlist_left", 4);
define("customlist_right", 5);

define("customlist_loginMenu", 1);
define("customlist_userMenu", 2);
define("customlist_adminMenu", 3);
define("customlist_categoryMenu", 4);

define("customlist_xml", 1);
define("customlist_csv", 2);

define("search_allFields",1);
define("search_anyFields",2);

define("Init_adminhelp",202);
define("Init_confcheck",204);
define("Init_myCart",112);
define("Init_recentPurchases",113);
define("Init_trackPurchases",114);
define("Init_catSubscriptions",232);
define("Init_mySubscriptions",75);
define("Init_favorities",118);
define("Init_help",119);
define("Init_rss",121);
define("Init_merchants",205);
define("Init_checkUpdates",206);
define("Init_registerNoah",207);
define("Init_controlPanel",208);
define("Init_cloneCategory",209);

define("Shoppingcart_new",1);
define("Shoppingcart_payed",2);
define("Shoppingcart_processed",3);

// menu points:
define("Settings_showLogout", 2);
define("Settings_showLogin", 3);
define("Settings_showRegister", 4);
define("Settings_showMyProfile", 5);
define("Settings_showMyAds", 6);
define("Settings_showSubmitAd", 7);
define("Settings_showSearch", 10);
define("Settings_showHome", 11);
define("Settings_displayHelp", 12);

define("Settings_ecommDisabled", 0);
define("Settings_ecommEnabled", 1);
define("Settings_ecommTestMode", 2);

// Captcha:
define("Settings_response", 1);
define("Settings_login", 2);
define("Settings_register", 3);
define("Settings_submitAd", 4);

define("putWhiteSpaceAbove", 1);
define("putWhiteSpaceBelow", 2);
define("putWhiteSpaceAboveAndBelow", 2);

// DB related:
@$dbHost=$hostName;
if (!empty($dbPort)) $dbHost.=":".$dbPort;
if (!empty($dbSocket)) $dbHost.=":".$dbSocket;

$versionFooterText = addcslashes("Powered by <a href='http://noahsclassifieds.org'>Noah's Classifieds</a> $noahVersion - 
                      <a href='http://open-classifieds.com' title='Best classifieds software script'>Update now to Open Classifieds</a>","'\\");
$paypalMarketingText = addcslashes("","'\\");

if( file_exists($CONFIG_FILE_DIR . "/test_config.php")) include($CONFIG_FILE_DIR . "/test_config.php");
if( file_exists(NOAH_BASE . "/my_constants.php")) include(NOAH_BASE . "/my_constants.php");
?>
