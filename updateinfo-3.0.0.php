<?php
/* Files to delete */
$nVersion = "3.0.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
if( $_GS->instver<$nVersion )
{
    executeQueryForUpdate("ALTER TABLE @customfield CHANGE `columnIndex` `columnIndex` VARCHAR( 20 ) NOT NULL  ", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET columnIndex=CONCAT('col_', columnIndex)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD `showInForm` INT NOT NULL DEFAULT '1'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInForm=4 WHERE hideFromForm=1", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInForm=1 WHERE hideFromForm=0", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield DROP hideFromForm", __FILE__, __LINE__);
    $settings=mysql_fetch_array(executeQuery("SELECT * FROM @settings WHERE id=1"), MYSQL_ASSOC);
    executeQueryForUpdate("update @customfield set showInDetails=$settings[showEmail] WHERE cid=0 AND columnIndex='email'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInForm=$settings[enableRememberPassword] WHERE cid=0 AND columnIndex='rememberPassword'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInForm=$settings[enablePasswordReminder] WHERE cid=0 AND columnIndex='passwordReminder'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInList=$settings[showCreatedInLists] WHERE cid!=0 AND columnIndex='creationtime'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInList=$settings[showExpInLists] WHERE cid!=0 AND columnIndex='expirationTime'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInList=$settings[showOwnerInLists] WHERE cid!=0 AND columnIndex='ownerName'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInDetails=$settings[showCreatedInDetails] WHERE cid!=0 AND columnIndex='creationtime'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInDetails=".($settings["showExpInDetails"] ? 1 : 3)." WHERE cid!=0 AND columnIndex='expirationTime'", __FILE__, __LINE__);
    executeQueryForUpdate("update @customfield set showInDetails=$settings[showOwnerInDetails] WHERE cid!=0 AND columnIndex='ownerName'", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings DROP `showEmail` ,
                    DROP `enableRememberPassword` ,
                    DROP `enablePasswordReminder` ,
                    DROP `showCreatedInDetails` ,
                    DROP `showExpInDetails` ,
                    DROP `showOwnerInDetails` ;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD `userField` INT NOT NULL DEFAULT '0' AFTER `name`;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD `checkboxCols` VARCHAR( 5 ) NOT NULL DEFAULT '3' AFTER `default_multiple` ;", __FILE__, __LINE__);
    if( $settings["subscriptionType"]==1 ) executeQueryForUpdate("UPDATE @settings SET subscriptionType=2 WHERE id=1", __FILE__, __LINE__);
    elseif( $settings["subscriptionType"]==2 ) executeQueryForUpdate("UPDATE @settings SET subscriptionType=5 WHERE id=1", __FILE__, __LINE__);
    if( $settings["enableFavorities"]==1 ) executeQueryForUpdate("UPDATE @settings SET enableFavorities=5 WHERE id=1", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings ADD `enableUserSearch` INT NOT NULL DEFAULT '1';", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings ADD `joomlaLink` VARCHAR( 255 ) NOT NULL DEFAULT '';", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings ADD `langDir` VARCHAR( 3 ) NOT NULL DEFAULT 'ltr' AFTER `allowedLanguages` ;", __FILE__, __LINE__);
    global $langDir;
    if( $langDir=="rtl" ) executeQueryForUpdate("UPDATE @settings SET langDir='rtl' ;", __FILE__, __LINE__);
    executeQueryForUpdate("INSERT INTO @customfield (`cid`, `name`, `userField`, `showInForm`, `expl`, `type`, `subType`, `values`, `default_text`, `default_bool`, `default_multiple`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`) VALUES 
    (0, 'Name', 0, 1, '', 1, 1, '', '', 0, '', '3', 1, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 1, 0, 0, 0, 1, 0, 1, 1, 0, 1, 0, 1, 'name', '', 100, 0),
    (0, 'Email', 0, 4, '', 1, 1, '', '', 0, '', '3', 1, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 4, 0, 0, 0, 1, 0, 4, 1, 0, 1, 0, 0, 'email', '', 200, 0),
    (0, 'Change password', 0, 1, '', 5, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'changePassword', '', 300, 0),
    (0, 'Password', 0, 1, '', 1, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'password', '', 400, 0),
    (0, 'Repeat password', 0, 1, '', 1, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'passwordCopy', '', 500, 0),
    (0, 'Remember password', 0, 1, '', 3, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'rememberPassword', '', 600, 0),
    (0, 'Password reminder', 0, 1, '', 9, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'remindPasswordLink', '', 700, 0),
    (0, 'First name', 0, 1, '', 1, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 'col_0', '', 800, 0),
    (0, 'Last name', 0, 1, '', 1, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 'col_1', '', 900, 0);", __FILE__, __LINE__);
    G::load( $cats, "SELECT id FROM @category");
    foreach( $cats as $c )
    {
        executeQueryForUpdate("INSERT INTO @customfield (`cid`, `name`, `userField`, `showInForm`, `expl`, `type`, `subType`, `values`, `default_text`, `default_bool`, `default_multiple`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`) VALUES 
        ($c->id, 'Category', 0, 0, '', 9, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 'cName', '', 100, 0),
        ($c->id, 'Created', 0, 0, '', 11, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 0, 'creationtime', '', 200, 0),
        ($c->id, 'Status', 0, 4, '', 4, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 4, 1, 0, 0, 0, 0, 'status', '', 300, 0),
        ($c->id, 'Views', 0, 0, '', 1, 2, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 3, 1, 0, 0, 0, 0, 'clicked', '', 400, 0),
        ($c->id, 'Responses', 0, 0, '', 1, 2, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 3, 1, 0, 0, 0, 0, 'responded', '', 500, 0),
        ($c->id, 'Owner', 0, 0, '', 9, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 'ownerName', '', 600, 0),
        ($c->id, 'Days left until expiration', 0, 0, '', 11, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 3, 1, 0, 0, 0, 0, 'expirationTime', '', 700, 0);", __FILE__, __LINE__);
    }
    executeQueryForUpdate("ALTER TABLE @user ADD col_0 TEXT NOT NULL", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @user ADD col_1 TEXT NOT NULL", __FILE__, __LINE__);
    updateGlobalstatAndFooter($nVersion);
}
?>
