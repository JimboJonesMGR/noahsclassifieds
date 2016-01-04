<?php
/* Files to delete */
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$nVersion = "2.1.2";
$_GS = new GlobalStat;
if( $_GS->instver<"2.1.2" )
{
    if( class_exists("rss") ) 
    {
        getDbCount( $count, "SELECT COUNT(*) FROM @rss" );
        if( !$count ) Rss::initialize();
    }
    
    // Cleanup the settings table:
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @settings", __FILE__, __LINE__);
    $num = mysql_num_rows($result);    
    $rows = array();
    for( $i=0, $count=0; $i<$num; $i++ ) 
    {
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $rows[]=$row["Field"];
    }
    $newCols = array(
        "showCreatedInLists"=>"ALTER TABLE @settings ADD `showCreatedInLists` INT NOT NULL DEFAULT '0'",
        "showCreatedInDetails"=>"ALTER TABLE @settings ADD `showCreatedInDetails` INT NOT NULL DEFAULT '1'",
        "showExpInLists"=>"ALTER TABLE @settings ADD `showExpInLists` INT NOT NULL DEFAULT '0'",
        "showExpInDetails"=>"ALTER TABLE @settings ADD `showExpInDetails` INT NOT NULL DEFAULT '1'",
        "dateFormat"=>"ALTER TABLE @settings ADD `dateFormat` VARCHAR( 100 ) NOT NULL DEFAULT 'Y-m-d'",
        "enableFavorities"=>"ALTER TABLE @settings ADD `enableFavorities` INT NOT NULL DEFAULT '1'",
        "enableRememberPassword"=>"ALTER TABLE @settings ADD `enableRememberPassword` INT NOT NULL DEFAULT '1'",
        "enablePasswordReminder"=>"ALTER TABLE @settings ADD `enablePasswordReminder` INT NOT NULL DEFAULT '1'",
        "updateCheckInterval"=>"ALTER TABLE @settings ADD `updateCheckInterval` INT NOT NULL DEFAULT '7'",
    );
    foreach( $newCols as $col=>$query )
    {
        if( !in_array( $col, $rows ) ) executeQueryForUpdate($query, __FILE__, __LINE__);
    }
    
    // Cleanup the globalstat table:
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @globalstat", __FILE__, __LINE__);
    $num = mysql_num_rows($result);    
    $rows = array();
    for( $i=0, $count=0; $i<$num; $i++ ) 
    {
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $rows[]=$row["Field"];
    }
    if( !in_array( "lastUpdateCheck", $rows )) executeQueryForUpdate("ALTER TABLE @globalstat ADD `lastUpdateCheck` DATE NOT NULL AFTER `lastUpdate`", __FILE__, __LINE__);
    
    updateGlobalstatAndFooter($nVersion);
}
?>
