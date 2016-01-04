<?php
/* Files to delete */
defined('_NOAH') or die('Restricted access');
$nVersion = "2.1.0";
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
if( $_GS->instver<"2.1.0" )
{
    executeQueryForUpdate("ALTER TABLE @settings ADD `showCreatedInLists` INT NOT NULL DEFAULT '0',
    ADD `showCreatedInDetails` INT NOT NULL DEFAULT '1',
    ADD `showExpInLists` INT NOT NULL DEFAULT '0',
    ADD `showExpInDetails` INT NOT NULL DEFAULT '1',
    ADD `dateFormat` VARCHAR( 100 ) NOT NULL DEFAULT 'Y-m-d',
    ADD `enableFavorities` INT NOT NULL DEFAULT '1',
    ADD `enableRememberPassword` INT NOT NULL DEFAULT '1',
    ADD `enablePasswordReminder` INT NOT NULL DEFAULT '1';");
    executeQueryForUpdate("ALTER TABLE @globalstat ADD `lastUpdateCheck` DATE NOT NULL AFTER `lastUpdate`", __FILE__, __LINE__);
    $c = new AppCategory;
    $c->recalculateAllItemNums(TRUE);
    
    updateGlobalstatAndFooter($nVersion);

}
?>
