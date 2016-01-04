<?php
/* Files to delete */
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$nVersion = "2.2.0";
$_GS = new GlobalStat;
global $dbClasses;
if( $_GS->instver<"2.2.0" )
{
    // retrieving the original character set:
    $db_charset = executeQueryForUpdate( "SHOW VARIABLES LIKE 'character_set_database'", __FILE__, __LINE__ );
    $charset_row = mysql_fetch_assoc( $db_charset );
    $origCharset = $charset_row['Value'];
    CustomField::addCustomColumns("item");
    
    $version = mysql_get_server_info();
    $mainVersion = intval($version[0]);
    $subVersion = intval($version[2]);
    $subSubVersion = intval($version[4]);
    if( $mainVersion>4 || ($mainVersion==4 && $subVersion>1) || ($mainVersion==4 && $subVersion==1 && $subSubVersion>=1) )
    {
        // ALTER DATABASE is available only from MySql 4.1.1
        executeQueryForUpdate("ALTER DATABASE DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci", __FILE__, __LINE__);
    }
    foreach( $dbClasses as $table ) 
    {
        if( !class_exists($table) ) continue;
        executeQueryForUpdate("ALTER TABLE @$table  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci", __FILE__, __LINE__);
        $result2 = executeQueryForUpdate("SHOW COLUMNS FROM @$table", __FILE__, __LINE__);
        $num2 = mysql_num_rows($result2);
        $textFields = array();
        for( $j=0; $j<$num2; $j++ ) 
        {
            $row2=mysql_fetch_array($result2, MYSQL_ASSOC);
            if( strstr($row2["Type"], "varchar") || strstr($row2["Type"], "text") )
            {
                $query = "ALTER TABLE @$table CHANGE `$row2[Field]` `$row2[Field]` $row2[Type] 
                          CHARACTER SET utf8  COLLATE utf8_unicode_ci NOT NULL DEFAULT '$row2[Default]'";
                if( $row2['Field']=="id" ) $query.=" auto_increment";
                executeQueryForUpdate($query, __FILE__, __LINE__);
                $textFields[]=$row2["Field"];
            }
        }
        if( $origCharset!="utf8" && count($textFields) )
        {
            global ${$table."_typ"};
            $select = array();
            $where = array();
            foreach( $textFields as $f )
            {
                ${$table."_typ"}["attributes"]["hex_$f"]=array("type"=>"TEXT");
                $select[]="`$f`, HEX(`$f`) AS `hex_$f`";
                $where[]="LENGTH(`$f`)!=CHAR_LENGTH(`$f`)";
            }  
            $select = implode(", ", $select);
            $where = implode(" OR ", $where);
            executeQueryForUpdate("SET names $origCharset", __FILE__, __LINE__);
            G::load( $objs, "SELECT id, $select from @$table WHERE $where");
            executeQueryForUpdate("SET names utf8", __FILE__, __LINE__);
            foreach( $objs as $o )
            {
                $set = array();
                foreach( $textFields as $f )
                {
                    $o->$f = bin2hex($o->$f);
                    $set[]="`$f`=UNHEX('".$o->$f."')";
                }
                $set = implode(", ", $set);
                executeQueryForUpdate("UPDATE @$table SET $set WHERE id=$o->id", __FILE__, __LINE__);
            }
        }
    }
    executeQueryForUpdate("ALTER TABLE @settings ADD `showOwnerInLists` INT NOT NULL DEFAULT '0',
    ADD `showOwnerInDetails` INT NOT NULL DEFAULT '1',
    ADD `defaultLanguage` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `allowedThemes` ,
    ADD `allowSelectLanguage` INT NOT NULL DEFAULT '0' AFTER `defaultLanguage` ,
    ADD `allowedLanguages` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `allowSelectLanguage`,
    ADD `extraHead` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `helpLink` ,
    ADD `extraBody` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `extraHead` ,
    ADD `extraFooter` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `extraBody` ;", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @settings SET defaultLanguage='en', allowedLanguages='en'", __FILE__, __LINE__);
    executeQueryForUpdate("DELETE FROM @item WHERE cid=0", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @notification ADD langDependent INT NOT NULL DEFAULT '1';", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @notification SET langDependent=0 WHERE id>=101 OR id<=104 OR id=109;", __FILE__, __LINE__);
    $c = new AppCategory;
    $c->recalculateAllItemNums(TRUE);
    
    updateGlobalstatAndFooter($nVersion);
}
?>
