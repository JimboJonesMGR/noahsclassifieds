<?php
/* Files to delete */
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$nVersion = "2.1.1";
$_GS = new GlobalStat;
if( $_GS->instver<"2.1.1" )
{
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @settings", __FILE__, __LINE__);
    $num = mysql_num_rows($result);    
    $found=FALSE;
    for( $i=0, $count=0; $i<$num && !$found; $i++ ) 
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if( $row["Field"]=='updateCheckInterval' ) $found=TRUE;
    }
    if( !$found ) executeQueryForUpdate("ALTER TABLE @settings ADD `updateCheckInterval` INT NOT NULL DEFAULT '7';", __FILE__, __LINE__);
    
    updateGlobalstatAndFooter($nVersion);
}
?>
