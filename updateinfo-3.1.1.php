<?php
/* Files to delete */
$nVersion = "3.1.1";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
if( $_GS->instver<$nVersion )
{
    executeQueryForUpdate("ALTER TABLE @search ADD `relationBetweenFields` INT NOT NULL DEFAULT '1';", __FILE__, __LINE__);

    $result = executeQueryForUpdate("SHOW COLUMNS FROM @search", __FILE__, __LINE__);
    $num = mysql_num_rows($result); 
    $searchColumnIndexes = array();
    for( $i=0, $count=0; $i<$num; $i++ ) 
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if( preg_match( "/^col_/", $row["Field"] ) ) $searchColumnIndexes[]=$row["Field"];
    }
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @item", __FILE__, __LINE__);
    $num = mysql_num_rows($result); 
    $itemColumnIndexes = array();
    for( $i=0, $count=0; $i<$num; $i++ ) 
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if( preg_match( "/^col_/", $row["Field"] ) ) $itemColumnIndexes[]=$row["Field"];
    }
    foreach( $itemColumnIndexes as $ci )
    {
        if( !in_array($ci, $searchColumnIndexes) )
        {
            executeQueryForUpdate("ALTER TABLE @search ADD `$ci` TEXT NOT NULL;", __FILE__, __LINE__);
        }
    }
    updateGlobalstatAndFooter($nVersion);
}
?>
