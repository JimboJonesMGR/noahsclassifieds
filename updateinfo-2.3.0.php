<?php
/* Files to delete */
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$nVersion = "2.3.0";
$_GS = new GlobalStat;
if( $_GS->instver<$nVersion )
{
    executeQueryForUpdate("ALTER TABLE @settings ADD `applyCaptcha` VARCHAR( 20 ) NOT NULL AFTER `dateFormat`;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings ADD `showEmail` INT NOT NULL DEFAULT '4' AFTER `applyCaptcha`;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD `displayLabel` INT NOT NULL DEFAULT '1' AFTER `innewline`", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD `detailsPosition` INT NOT NULL DEFAULT '0' AFTER `displayLabel` ;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD `showInDetails` INT NOT NULL DEFAULT '1';", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD `hideFromForm` INT NOT NULL DEFAULT '0';", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET hideFromForm=1, showInDetails=4 WHERE hidden=1", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield DROP `hidden`", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET showInDetails=4 WHERE seo=3", __FILE__, __LINE__);
    executeQueryForUpdate("DELETE FROM @item WHERE cid=0", __FILE__, __LINE__);
    @copy("config.php", "app/config.php");
    @unlink("config.php");
    if( file_exists("test_config.php") )
    {
        @copy("test_config.php", "app/test_config.php");
        @unlink("test_config.php");
    }
    updateGlobalstatAndFooter($nVersion);
}
?>
