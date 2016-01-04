<?php
$nVersion = "5.0.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$globalStat = new GlobalStat;
if( $globalStat->instver<$nVersion )
{
    executeQueryForUpdate("ALTER TABLE @settings ADD `enableOodle` INT( 11 ) NOT NULL DEFAULT '0'", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings ADD `oodleLocation` varchar(255) NOT NULL", __FILE__, __LINE__);   

    executeQueryForUpdate("ALTER TABLE @category ADD `enableOodle` INT( 11 ) NOT NULL DEFAULT '0'", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @category ADD `oodleRegion` varchar(255) NOT NULL", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @category ADD `oodleCategory` varchar(255) NOT NULL", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @category ADD `oodleLocation` varchar(255) NOT NULL", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @category ADD `oodleRadius` varchar(255) NOT NULL DEFAULT '30'", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @category ADD `oodleSearch` varchar(255) NOT NULL", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @category ADD `oodleNum` varchar(255) NOT NULL DEFAULT '10'", __FILE__, __LINE__);
    
    executeQueryForUpdate("ALTER TABLE @customfield ADD `oodleField` varchar(255) NOT NULL", __FILE__, __LINE__);   

    executeQueryForUpdate("ALTER TABLE @item ADD `oodleType` INT (11) NOT NULL DEFAULT '0'", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @item ADD `oodleID` varchar(255) NOT NULL", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @item ADD `oodleUrl` varchar(255) NOT NULL", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @item ADD `oodleImageUrl` varchar(255) NOT NULL", __FILE__, __LINE__);   

    executeQueryForUpdate("ALTER TABLE @settings ADD `oodleSerial` VARCHAR(100) NOT NULL", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings ADD `oodle_license_local_key` BLOB NOT NULL", __FILE__, __LINE__);   
    executeQueryForUpdate("ALTER TABLE @settings ADD `oodle_license_best_method` BLOB NOT NULL", __FILE__, __LINE__);   
        
   updateGlobalstatAndFooter($nVersion);
}
?>
