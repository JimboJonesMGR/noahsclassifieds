<?php
/* Files to delete */
$nVersion = "4.0.2";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
if( $_GS->instver<$nVersion )
{
    alterDatabaseColumns("settings",  "ADD", array(
        "`downsizeWidth` INT NOT NULL DEFAULT '0' AFTER `maxPicHeight`",
        "`downsizeHeight` INT NOT NULL DEFAULT '0' AFTER `downsizeWidth`"), __FILE__, __LINE__);
    
    executeQueryForUpdate("UPDATE @customfield SET `values`='0,1' WHERE columnIndex='status'", __FILE__, __LINE__);
    
    updateGlobalstatAndFooter($nVersion);
}

?>
