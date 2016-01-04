<?php
/* Files to delete */
$nVersion = "2.4.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
global $versionFooterText;
if( $_GS->instver<$nVersion )
{
    executeQueryForUpdate("ALTER TABLE @category ADD `expirationEnabled` INT NOT NULL DEFAULT '0' AFTER `expiration` ,
                  ADD `expirationOverride` INT NOT NULL DEFAULT '0' AFTER `expirationEnabled`,
                  ADD `allowSubmitAdAdmin` INT NOT NULL DEFAULT '0' AFTER `allowAd`,
                  ADD `sortId` INT NOT NULL ;", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @category SET expirationEnabled=1 WHERE expiration>0", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings DROP `expiration`, DROP `immediateAppear`,
                  ADD `extraTopContent` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `extraBody`,
                  ADD `extraBottomContent` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `extraTopContent`;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @item ADD `expiration` INT NOT NULL DEFAULT '0' AFTER `expirationTime` ;", __FILE__, __LINE__);
    executeQueryForUpdate("INSERT INTO @cronjob (`id` ,`title` ,`lastExecutionTime` ,`frequency` ,`active` ,`function`) VALUES (
                 '3', 'Delete inactive guests', '', '24', '1', 'deleteInactiveGuests();')", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD `formatPrefix` VARCHAR( 255 ) NOT NULL AFTER `rangeSearch` ,
                    ADD `formatPostfix` VARCHAR( 255 ) NOT NULL AFTER `formatPrefix` ,
                    ADD `precision` INT NOT NULL DEFAULT '2' AFTER `formatPostfix` ,
                    ADD `precisionSeparator` VARCHAR( 1 ) NOT NULL DEFAULT '.' AFTER `precision` ,
                    ADD `thousandsSeparator` VARCHAR( 1 ) NOT NULL DEFAULT ',' AFTER `precisionSeparator` ,
                    ADD `useMarkitup` INT NOT NULL DEFAULT '0' AFTER `allowHtml` ;", __FILE__, __LINE__);
    updateGlobalstatAndFooter($nVersion);
}
?>
