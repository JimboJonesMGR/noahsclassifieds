<?php
/* Files to delete */
$nVersion = "2.4.1";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
if( $_GS->instver<$nVersion )
{
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @cronjob", __FILE__, __LINE__);
    $num = mysql_num_rows($result);
    for( $j=0; $j<$num; $j++ ) 
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if( $row["Field"]=="lastExecutionTime" && strstr($row["Type"], "int") )
        {
            executeQueryForUpdate("ALTER TABLE @cronjob CHANGE `lastExecutionTime` `lastExecutionTime` DATETIME NOT NULL  ;", __FILE__, __LINE__);
            break;
        }
    }
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @user", __FILE__, __LINE__);
    $num = mysql_num_rows($result);
    for( $j=0; $j<$num; $j++ ) 
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if( ($row["Field"]=="creationtime" || $row["Field"]=="lastClickTime") && strstr($row["Type"], "int") )
        {
            executeQueryForUpdate("ALTER TABLE @user CHANGE `creationtime` `creationtime` DATETIME NOT NULL ,
                          CHANGE `lastClickTime` `lastClickTime` DATETIME NOT NULL ;", __FILE__, __LINE__);
            executeQueryForUpdate("UPDATE @user SET lastClickTime=NOW();", __FILE__, __LINE__);
            break;
        }
    }
    executeQueryForUpdate("REPLACE INTO @cronjob (`id` ,`title` ,`lastExecutionTime` ,`frequency` ,`active` ,`function`) VALUES (
                 '3', 'Delete inactive guests', '', '24', '1', 'deleteInactiveGuests();')", __FILE__, __LINE__);
    updateGlobalstatAndFooter($nVersion);
}
?>
