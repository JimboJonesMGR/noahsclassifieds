<?php
$nVersion = "7.0.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$globalStat = new GlobalStat;
if( $globalStat->instver<$nVersion )
{
    alterDatabaseColumns("customfield", "ADD", array("`fieldExpirationDays` INT NOT NULL DEFAULT '0'"), __FILE__, __LINE__);     

    updateGlobalstatAndFooter($nVersion);
}




?>
