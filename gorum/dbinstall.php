<?php
defined('_NOAH') or die('Restricted access');

class DbInstall
{
    
function DbInstall($autoInstall)
{
    global $phpVersionMin, $mySqlVersionMin;
    
    $host = $autoInstall->hostName;
    if ($autoInstall->dbPort!="") $host.=":".$autoInstall->dbPort;
    if ($autoInstall->dbSocket!="") $host.=":".$autoInstall->dbSocket;
    $autoInstall->out("Connecting to database server");
    $ret = @mysql_connect($host, $autoInstall->dbUser, $autoInstall->dbUserPw);
    if( !DbInstall::checkComponentVersions( $mySqlVersion, $phpVersion ) )
    {
        $autoInstall->outDie("Required minimum MySql version is $mySqlVersionMin. The current one is $mySqlVersion. Required minimum MySql version is $phpVersionMin. The current one is $phpVersion. Installation failed.");
    }
    if (!$ret) $autoInstall->outDie("Mysql connection failed with: Host: $host, Username: $autoInstall->dbUser, Password: $autoInstall->dbUserPw. Installation failed.");
    $autoInstall->out("Selecting classifieds database: $autoInstall->dbName.");
    if (!@mysql_select_db($autoInstall->dbName)) 
    {
        $autoInstall->out("Classifieds database doesn't exist - creating.");
        $query="CREATE DATABASE $autoInstall->dbName DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
        if( !@mysql_query($query) ) $autoInstall->outDie("Couldn't create classifieds database. Installation failed.");
        $autoInstall->out("Selecting classifieds database: $autoInstall->dbName.");
        if (!@mysql_select_db($autoInstall->dbName)) 
        {
            $autoInstall->outDie("Couldn't select classifieds database: $autoInstall->dbName. Installation failed.");
        }
    }
    // Switch off strict mode:
    mysql_query( "SET SESSION sql_mode=''");
    // checking if tables are already installed:
    $result = executeQuery("SHOW TABLES");
    $tables = array();
    for( $i=0; $i<mysql_num_rows($result); $i++ ) 
    {
        $row=mysql_fetch_array($result);
        $tables[] = $row[0];
    }
    if( !empty($autoInstall->withDrop) )
    {
        $autoInstall->out("Dropping existing tables");
        foreach( $tables as $table ) executeQuery("DROP TABLE $table");
    }
    elseif( in_array($autoInstall->dbPrefix."settings", $tables) ) $autoInstall->outDie("The program seems to be installed already. Exiting.");
    
}

function installCreateTables()
{
    global $dbClasses;
    foreach( $dbClasses as $class )
    {
        $object = new $class(FALSE);
        $ret = DbInstall::createTable($object);
        if ($ret!=ok)  return nok;
    }
    return ok;
}

function createTable($base)
{
    $typ =& $base->getTypeInfo();
    DbInstall::getCreateTableQuery( $typ, $base->get_table(), $query );
    $result=executeQuery($query);
}

function getCreateTableQuery( $typ, $table, &$query )
{

    $query = "CREATE TABLE @$table ( ";
    $firstField = TRUE;
    foreach( $typ["attributes"] as $attribute=>$attrInfo )
    {
        if( in_array("no column", $attrInfo) ) continue;
        if( !$firstField ) $query.=", ";
        $firstField = FALSE;
        //if( $attrInfo["type"]=="DATE" ) $query .= "  $attribute INT";
        //else $query .= "  $attribute ".$attrInfo["type"];
        $query .= "  `$attribute` ".$attrInfo["type"];
        if( strstr($attrInfo["type"], "INT") &&isset($attrInfo["length"]))
        {
            $query.="(".$attrInfo["length"].")";
        }
        else if( strstr($attrInfo["type"], "CHAR") &&
                 isset($attrInfo["max"]) )
        {
            $query.="(".$attrInfo["max"].")";
        }
        if( in_array("unsigned", $attrInfo) ) {
            $query.=" UNSIGNED ";
        }
        if( strstr($attrInfo["type"], "CHAR") || strstr($attrInfo["type"], "TEXT") )
        {
            $query.=" COLLATE utf8_unicode_ci ";
        }
        if( !isset($attrInfo["default null"]) )
        {
            if( isset($attrInfo["default"]) && $attrInfo["type"]!="TEXT")
            {
                $query.=" DEFAULT '".$attrInfo["default"]."'";
            }
            elseif( !isset($attrInfo["default"]) && $attrInfo["type"]=="VARCHAR")
            {
                $query.=" DEFAULT ''";
            }
            elseif( !isset($attrInfo["default"]) && $attrInfo["type"]=="INT" && !in_array("auto increment", $attrInfo))
            {
                $query.=" DEFAULT 0";
            }
            $query.=" NOT NULL";
        }
        if( in_array("auto increment", $attrInfo) )
        {
            $query.=" AUTO_INCREMENT";
        }
    }
    if( isset($typ["primary_key"]) )
    {
        $query.=DbInstall::getKeySectionForCreateTableQuery($typ["primary_key"],
                                                 "PRIMARY KEY" );
    }
    if( isset($typ["unique_keys"]) )
    {
        $query.=DbInstall::getKeySectionForCreateTableQuery($typ["unique_keys"],
                                                 "UNIQUE" );
    }
    if( isset($typ["keys"]) )
    {
        $query.=DbInstall::getKeySectionForCreateTableQuery($typ["keys"],
                                                 "KEY" );
    }
    $query.=" ) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    if( in_array("heap", $typ) ) $query.=" TYPE=HEAP";
    if( isset($typ["select"]) ) $query.=" ".$typ["select"];
    $query.=";";
    return $query;
}

function getKeySectionForCreateTableQuery( $keys,$primaryOrKeyOrUnique)
{

    $query = "";
    if( $primaryOrKeyOrUnique=="PRIMARY KEY" )
    {
        $query.=",   $primaryOrKeyOrUnique ";
        if( is_string($keys) )  // the simplest case
        {
            $query.="($keys)";
        }
        else
        {
            $innerFirstField = TRUE;
            foreach( $keys as $attrOrIndex=>$attrOrLength )
            {
                if( $innerFirstField )
                {
                    $query.="(";
                    $innerFirstField = FALSE;
                }
                else $query.=",";
                if( is_numeric($attrOrIndex) ) $query.=$attrOrLength;
                else $query.="$attrOrIndex($attrOrLength)";
            }
            $query.=")";
        }
    }
    else
    {
        if( is_string($keys) )  // the simplest case
        {
            $query.=",   $primaryOrKeyOrUnique ($keys)";
        }
        else
        {
            foreach( $keys as $keyOrIndex=>$keyOrLength )
            {
                $query.=",   $primaryOrKeyOrUnique ";
                if( is_numeric($keyOrIndex) )
                {
                     if( is_string($keyOrLength))//the simplest case
                     {
                        $query.="($keyOrLength)";
                     }
                     else
                     {
                         $innerFirstField = TRUE;
                         foreach( $keyOrLength as
                                  $attrOrIndex=>$attrOrLength )
                         {
                             if( $innerFirstField )
                             {
                                 $query.="(";
                                 $innerFirstField = FALSE;
                             }
                             else $query.=",";
                             if( is_numeric($attrOrIndex) )
                             {
                                 $query.=$attrOrLength;
                             }
                             else
                             {
                                 $query.= "$attrOrIndex($attrOrLength)";
                             }
                        }
                        $query.=")";
                    }
                }
                else $query.="$keyOrIndex($keyOrLength)";
            }
        }
    }
    return $query;
}
  
function checkComponentVersions( &$mySqlVersion, &$phpVersion )
{
    global $phpVersionMin, $mySqlVersionMin;
    
    if( !($mySqlVersion = mysql_get_server_info()) )
    {
        $ret = mysql_fetch_array(mysql_query("SELECT VERSION() as mysql_version"), MYSQL_ASSOC);
        if( !($mySqlVersion = $ret["mysql_version"]) )
        {
            ob_start();
            phpinfo(INFO_MODULES);
            $info = ob_get_contents();
            @ob_end_clean();
            $info = stristr($info, 'Client API version');
            preg_match('/[1-9].[0-9].[1-9][0-9]/', $info, $match);
            $mySqlVersion = $match[0]; 
        }
    }
    $phpVersion = phpversion();
    
    $mainVersion = intval($mySqlVersion[0]);
    $subVersion = intval($mySqlVersion[2]);
    $mainVersionMin = intval($mySqlVersionMin[0]);
    $subVersionMin = intval($mySqlVersionMin[2]);
    if( $mainVersion && ($mainVersion<$mainVersionMin || ($mainVersion==$mainVersionMin && $subVersion<$subVersionMin)) ) return FALSE;

    $mainVersion = intval($phpVersion[0]);
    $subVersion = intval($phpVersion[2]);
    $mainVersionMin = intval($phpVersionMin[0]);
    $subVersionMin = intval($phpVersionMin[2]);
    if( $mainVersion && ($mainVersion<$mainVersionMin || ($mainVersion==$mainVersionMin && $subVersion<$subVersionMin)) ) return FALSE;
    return TRUE;
}
    
}
?>
