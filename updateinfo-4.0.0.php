<?php
/* Files to delete */
if( file_exists(ECOMM_DIR . "/update.php") ) include(ECOMM_DIR . "/update.php");
$nVersion = "4.0.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
global $category_typ;
if( $_GS->instver<$nVersion )
{
    $ecommerceEnabled = class_exists("ecommfull");
    alterDatabaseColumns("settings",  "ADD", array(
        "`ecommerceEnabled` INT NOT NULL DEFAULT '2'",
        "`timeFormat` VARCHAR( 255 ) NOT NULL AFTER `dateFormat`",
        "`smtpPort` VARCHAR( 5 ) NOT NULL AFTER `smtpPass`",
        "`smtpSecure` INT NOT NULL DEFAULT '8' AFTER `smtpPort`",
        "`enablePermalinks` TINYINT NOT NULL DEFAULT '0' AFTER `mainKeywords`",
        "`customAdListTemplate` VARCHAR( 255 ) NOT NULL",
        "`templateDebug` TINYINT NOT NULL DEFAULT '0'",
        "`deleteAdsOnExpiry` TINYINT NOT NULL DEFAULT '1' AFTER `renewal`",
        "`homeLocation` VARCHAR( 255 ) NOT NULL AFTER `helpLink`",
        "`redirectFirstLogin` VARCHAR( 255 ) NOT NULL AFTER `homeLocation`",
        "`redirectLogin` VARCHAR( 255 ) NOT NULL AFTER `redirectFirstLogin`",
        "`redirectAdminLogin` VARCHAR( 255 ) NOT NULL AFTER `redirectLogin`",
        "`alternativeOrganizer` TINYINT NOT NULL DEFAULT '0'",
        "`cascadingCategorySelect` INT NOT NULL DEFAULT '0'",
        "`replytoEmail` VARCHAR( 255 ) NOT NULL AFTER `adminFromName`",
        "`replytoName` VARCHAR( 255 ) NOT NULL AFTER `replytoEmail`",
        "`ommitCatPermaLink` TINYINT NOT NULL DEFAULT '0' AFTER `enablePermalinks`",
        "`enableCombine` TINYINT NOT NULL DEFAULT '0'",
        "`swiftLog` TINYINT NOT NULL DEFAULT '0' AFTER `fallBackNative`"), __FILE__, __LINE__);
    alterDatabaseColumns("item",  "ADD", array(
        "`subscribtionsNotified` text NOT NULL AFTER expiration"), __FILE__, __LINE__);
    
    if( $ecommerceEnabled ) executeQueryForUpdate("UPDATE @settings SET ecommerceEnabled=2;", __FILE__, __LINE__);  // test mode
    $_S = new AppSettings();
    executeQueryForUpdate("UPDATE @settings SET timeFormat='$_S->dateFormat H:i';", __FILE__, __LINE__);

    G::load( $fields, "SELECT id FROM @customfield WHERE columnIndex='id' AND cid!=0 AND isCommon=0" );
    foreach( $fields as $field )
    {
        executeQueryForUpdate("UPDATE @customfield SET isCommon=1 WHERE id='$field->id'", __FILE__, __LINE__);
    }
    
    $cf = new ItemField;
    $cf->columnIndex = "id";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (`cid`, `isCommon`, `name`, `userField`, `showInForm`, `expl`, `type`, `subType`, `values`, `default_text`, `default_bool`, `default_multiple`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`) VALUES 
        (0, 1, 'ID', 0, 0, '', 1, 2, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 'id', '', 50, 0)", __FILE__, __LINE__);
    }
    $cf = new UserField;
    $cf->columnIndex = "id";
    $cf->isCommon = 0;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (`cid`, `isCommon`, `name`, `userField`, `showInForm`, `expl`, `type`, `subType`, `values`, `default_text`, `default_bool`, `default_multiple`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`) VALUES 
        (0, 0, 'ID', 0, 0, '', 1, 2, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 'id', '', 50, 0)", __FILE__, __LINE__);
    }
    
    $cf = new UserField;
    $cf->columnIndex = "credits";
    $cf->isCommon = 0;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (`id`, `cid`, `name`, `userField`, `isCommon`, `showInForm`, `expl`, `type`, `subType`, `values`, `default_text`, `default_bool`, `default_multiple`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`) VALUES 
                           (0, 0, 'Credits', 0, 0, 4, '', 1, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 4, 1, 0, 4, 1, 0, 'credits', '', 2700, 0)", __FILE__, __LINE__);
    }
    $cf = new UserField;
    $cf->columnIndex = "expirationTime";
    $cf->isCommon = 0;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (`id`, `cid`, `name`, `userField`, `isCommon`, `showInForm`, `expl`, `type`, `subType`, `values`, `default_text`, `default_bool`, `default_multiple`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`) VALUES 
                           (0, 0, 'Expiration time', 0, 0, 4, '', 11, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 4, 1, 0, 4, 1, 0, 'expirationTime', '', 2800, 0);", __FILE__, __LINE__);
    }
    alterDatabaseColumns("category",  "ADD", array(
        "`displayResponseLink` INT NOT NULL DEFAULT '1'",
        "`displayFriendmailLink` INT NOT NULL DEFAULT '1'",
        "`permaLink` TEXT NOT NULL AFTER `wholeName`",
        "`customAdMeta` TEXT NOT NULL AFTER `keywords`",
        "`descriptionMeta` TEXT NOT NULL AFTER `description`",
        "`customAdListTemplate` VARCHAR( 255 ) NOT NULL",
        "`customAdDetailsTemplate` VARCHAR( 255 ) NOT NULL",
        "`recursive` TINYINT NOT NULL DEFAULT '0'",
        "`renewOnModify` TINYINT NOT NULL DEFAULT '0' AFTER `inactivateOnModify`"), __FILE__, __LINE__);
    
    $category_typ["attributes"]["showDescription"] = array("type"=>"INT");
    executeQueryForUpdate("ALTER TABLE @category ADD `showDescription` INT NOT NULL DEFAULT '1';", __FILE__, __LINE__);  // ha veletlenul nem lenne benne
    iterateLargeDatabaseTable("SELECT id, description, showDescription FROM @category", "setDescriptionAndDescriptionMeta" );
    alterDatabaseColumns("category", "DROP", array("`showDescription`"), __FILE__, __LINE__);
    
    alterDatabaseColumns("notification", "DROP", array("`variables`", "`fixRecipent`", "`fixCC`", "`recipent`"), __FILE__, __LINE__);
    alterDatabaseColumns("search", "ADD", array( 
        "`exportFields` TEXT NOT NULL", 
        "`exportFormat` INT NOT NULL DEFAULT '1'", 
        "`xmlType` VARCHAR( 20 ) NOT NULL  DEFAULT 'RSS2.0'",
        "`customAdListTemplate` VARCHAR( 255 ) NOT NULL"), __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET `allowHtml` = '1' WHERE columnIndex='email'", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET 
                              `values`=replace(replace(`values`, \"\n\", \"\"), \", \", \",\"), 
                              `default_text`=replace(replace(`default_text`, \"\n\", \"\"), \", \", \",\"), 
                              `default_multiple`=replace(replace(`default_multiple`, \"\n\", \"\"), \", \", \",\")", __FILE__, __LINE__);
    alterDatabaseColumns("customfield", "ADD", array(
        "`default` TEXT NOT NULL AFTER `values`", 
        "`useVariableSubstitution` TINYINT NOT NULL DEFAULT '0' AFTER `values`", 
        "`customListPlacement` TINYINT NOT NULL DEFAULT '0'", 
        "`customDetailsPlacement` TINYINT NOT NULL DEFAULT '0'", 
        "`css` VARCHAR( 255 ) NOT NULL AFTER `seo`", 
        "`ecommAssignment` INT NOT NULL DEFAULT '0'"), __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET `default` = default_text WHERE type=1 OR type=4", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET `default` = default_text WHERE type=6 OR type=7", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET `default` = default_bool WHERE type=3", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET showInForm=1 WHERE columnIndex='cName'", __FILE__, __LINE__);
    alterDatabaseColumns("customfield", "DROP", array("`default_text`", "`default_bool`", "`default_multiple`"), __FILE__, __LINE__);

    CustomField::tranformEnumValues(__FILE__, __LINE__);
    updateCustomLists();
    
    iterateLargeDatabaseTable("SELECT id, wholeName FROM @category", "updatePermaLinks" );
          
    executeQueryForUpdate("UPDATE @customfield SET customListPlacement=1, showInList=1 WHERE showInList=0 AND columnIndex='creationtime'", __FILE__, __LINE__);

    alterDatabaseColumns("subscription", "ADD", array("`creationtime` DATETIME NOT NULL",
                                                      "`unsub` TINYINT NOT NULL DEFAULT '0'"), __FILE__, __LINE__);
    if( function_exists('addEcommerceTables') ) addEcommerceTables();
    alterDatabaseColumns("user", "ADD", array("`credits` INT NOT NULL DEFAULT '0'",
                        "`expirationTime` DATE NOT NULL" ,
                        "`ecommType` TINYINT NOT NULL DEFAULT '1'"), __FILE__, __LINE__);
        
    
    updateGlobalstatAndFooter($nVersion);
}

function updateCustomLists()
{
    $customLists = new CustomList;
    G::load( $customLists, "SELECT id, cid FROM @customlist WHERE uid=0" );
    foreach( $customLists as $cl )
    {
        $cl->activateVariableFields();
        load($cl);
        $cl->modify(TRUE);
    }
}

function setDescriptionAndDescriptionMeta($cat)
{
    $descriptionMeta = strip_tags(nl2br($cat->description));
    $description = $cat->showDescription ? $cat->description : "";
    executeQueryForUpdate("UPDATE @category SET description='".quoteSql($description)."', descriptionMeta='".quoteSql($descriptionMeta)."' WHERE id=$cat->id", __FILE__, __LINE__);
}

function updatePermaLinks($cat)
{
    $parts = explode(" - ", $cat->wholeName);
    for( $i=0; $i<count($parts); $i++ ) $parts[$i] = strtolower(preg_replace("/[\W]/", "_", $parts[$i]));        
    $permaLink = implode("/", $parts);
    executeQueryForUpdate("UPDATE @category SET permaLink='".quoteSql($permaLink)."' WHERE id=$cat->id", __FILE__, __LINE__);
}

?>
