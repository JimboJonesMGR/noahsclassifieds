<?php
/* Files to delete */
$nVersion = "4.0.1";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
if( $_GS->instver<$nVersion )
{
    executeQueryForUpdate("UPDATE @customfield SET allowHtml=1 WHERE columnIndex='name';");        
    
    updateGlobalstatAndFooter($nVersion);
}

?>
