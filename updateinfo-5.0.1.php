<?php
$nVersion = "5.0.1";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$globalStat = new GlobalStat;
if( $globalStat->instver<$nVersion )
{
   updateGlobalstatAndFooter($nVersion);
}
?>
