<?php
$nVersion = "6.0.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$globalStat = new GlobalStat;
if( $globalStat->instver<$nVersion )
{
// update search custom list to include sort order.
   executeQueryForUpdate("UPDATE @search SET primarySort=3, primaryDir = 'DESC', secondarySort=3, secondaryDir='DESC' where id=1", __FILE__, __LINE__);
   updateGlobalstatAndFooter($nVersion);
}
?>
