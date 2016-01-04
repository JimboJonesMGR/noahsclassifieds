<?php
$nVersion = "4.1.3";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$globalStat = new GlobalStat;
if( $globalStat->instver<$nVersion )
{
   executeQueryForUpdate("ALTER TABLE @settings ADD `loginLink` VARCHAR( 255 ) NOT NULL DEFAULT '';", __FILE__, __LINE__);   
   executeQueryForUpdate("ALTER TABLE @settings ADD `registrationLink` VARCHAR( 255 ) NOT NULL DEFAULT '';", __FILE__, __LINE__);   
   executeQueryForUpdate("ALTER TABLE @settings ADD `serial` VARCHAR(100) NOT NULL", __FILE__, __LINE__);
   executeQueryForUpdate("ALTER TABLE @settings ADD `license_local_key` BLOB NOT NULL", __FILE__, __LINE__);   
   executeQueryForUpdate("ALTER TABLE @settings ADD `license_best_method` BLOB NOT NULL", __FILE__, __LINE__);   
    
   updateGlobalstatAndFooter($nVersion);
}




?>
