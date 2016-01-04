<?php
defined('_NOAH') or die('Restricted access');
function executeQuery( $queryOrQueryAndParams )
{
    global $trackDbSpeed, $traceSqlQueries, $sqlQueryDump, $dbPrefix, $dbClasses;

    if( is_array($queryOrQueryAndParams) )
    {
        $query = array_shift($queryOrQueryAndParams);
        $args = $queryOrQueryAndParams;
    }
    else
    {
        $query = $queryOrQueryAndParams;
        $args = func_get_args();
        if( count($args)>1 ) array_shift($args);
        else $args=array();
    }
    $query = preg_replace("/@(".implode("|", $dbClasses).")/", "$dbPrefix$1", $query);
    if( count($args) )
    {
        $query = preg_replace(array("/'%/", "/%'/"), array("'%%", "%%'"), $query);
        $query = preg_replace(array("/#[^#]+#/", "/`[^`]+`/"), array("'%s'", "`%s`"), $query);
        $query = vsprintf($query, array_map("quoteSQL", $args));
    }
    if (isset($trackDbSpeed) && $trackDbSpeed) {
        $result=speedTrackExecuteQuery($query);
    }
    else {
        $result=mysql_query($query);
    }
    if( $result==0 ) {
        handleErrorSql($query);
    }
    if( $traceSqlQueries )
    {
        require_once GORUM_DIR . "/sqlparser.php";
        $parsed_sql = PMA_SQP_parse($query);
        $sqlQueryDump .= PMA_SQP_formatHtml($parsed_sql);
        $sqlQueryDump .= "<br><br>";
    }
    return $result;
}
function speedTrackExecuteQuery($query)
{
    global $mysqlSpeedString,$swMysqlSum,$mysqlSlowQuery;
    global $printMysqlSpeedString;
    
    if (!isset($mysqlSpeedString)) $mysqlSpeedString="";
    if (!isset($printMysqlSpeedString)) $printMysqlSpeedString=FALSE;
    if (!isset($swMysqlSum)) $swMysqlSum=0;
    if (!isset($mysqlSlowQuery)) $mysqlSlowQuery=1.0;
    $sw = new Stopwatch;
    $sw->start();
    
    $result=mysql_query($query);

    $sw->stop();
    $ela=$sw->elapsed();
    $hh = (float)$sw->elapsed();
    $swMysqlSum+=$hh;
    if ($hh > $mysqlSlowQuery) $ela="<font color='red'>$ela</font>";
    if ($printMysqlSpeedString) {
        $mysqlSpeedString.="<br>$query - <b>$ela</b>";
    }
    if( class_exists("mysqlspeed") ) {
        writeMysqlSpeedRecord($query,$hh);
    }

    return $result;
}

function loadSQL( &$base, $query="")
{
    if( $query=="" ) {
        $table = $base->get_table();
        $query = "SELECT * FROM @$table";
        //TODO: default order by nem kellene?
    }
    $row=mysql_fetch_array(executeQuery($query), MYSQL_ASSOC);
    if( $row==0 ) {
        return not_found_in_db;
    }
    $base->init( $row );
    return ok;
}

function loadObjectsSQL( $base, $query="",&$objArr)
{
    $objArr = array();
    $tableName=$base->get_table();
    $className=$base->get_class();
    if( $query=="" ) $query = "SELECT * FROM @$tableName";
    $result=executeQuery($query);
    $num = mysql_num_rows($result);
    if ($num==0) {
        return not_found_in_db;
    }
    for($i=0;$i<$num;$i++) {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        $objArr[$i] = new $className;
        $objArr[$i]->init($row);
    }
    return ok;
}

function load( &$base, $whereFields="", $whatFields="*" )
{
    $whereExists = FALSE;
    $query = $base->getSelect();
    if( !$query )
    {
        $typ =& $base->getTypeInfo();
        $table = $base->get_table();
        $firstField = TRUE;
        $query = "SELECT $whatFields FROM @$table";
        if( $whereFields=="" ) $whereFields=getPrimaryKey( $typ );
        foreach( $whereFields as $index=>$attribute ) {
            if( !isset($base->{$attribute}) ) unset($whereFields[$index]);
        }
        if( sizeof($whereFields)==0 ) {
            $whereFields = array_keys( $typ["attributes"] );
            foreach( $whereFields as $index=>$attribute ) {
                if(!isset($base->{$attribute})) unset($whereFields[$index]);
            }
        }
        $sqlParams = array();
        foreach( $whereFields as $key ) {
            if( isset($base->{$key}) ) {
                $value = $base->{$key};
                if( is_object($value) ) $value = $value->getDbFormat($typ["attributes"][$key]["type"]);
                $sqlParams[] = $value;
                if( $firstField ) {
                    $query .= " WHERE @$table.$key=#param#";
                    $firstField = FALSE;
                    $whereExists = TRUE;
                }
                else $query .= " AND @$table.$key=#param#";
            }
        }
        array_unshift($sqlParams, $query);
        $query = $sqlParams;
    }
    else {
        if (stristr($query,"WHERE")) $whereExists=TRUE;
    }
    if( $whereExists ) $ret = loadSQL( $base, $query );
    else trigger_error("Load without WHERE: ".print_r($query, TRUE),E_USER_ERROR);
    return $ret;
}

function create(&$base, $withReplace=FALSE)
{
    global $globQuery, $user_typ;
    $base->valid();
    if( Roll::isFormInvalid() ) return;

    $typ =& $base->getTypeInfo(TRUE);
    $table = $base->get_table();
    $cmd = $withReplace ? "REPLACE" : "INSERT";
    $query =  "$cmd INTO @$table";
    $aia = getAutoIncrementAttribute( $typ );
    getCreateSetStr($base, $typ, TRUE, $s, $sqlParams);
    if( $s!="" ) 
    {
        $query.=" SET $s";
        array_unshift($sqlParams, $query);
        $query = $sqlParams;
    }
    $globQuery=$query;
    executeQuery($query);
    // Setting the auto increment key:
    if( $aia )  $base->{$aia} = mysql_insert_id();
    $hasMany = new HasManyAttrs($base);
    $hasMany->create();
}

function getCreateSetStr(&$base, &$typ , $create, &$query, &$sqlParams)
{
    $object_vars = get_object_vars($base);
    $firstField = TRUE;
    $query = "";
    $hasMany=0;
    $sqlParams = array();
    foreach( $object_vars as $attribute=>$value )
    {
        if( !isset($typ["attributes"][$attribute]) ) continue;
        if( !in_array("no column", $typ["attributes"][$attribute]) &&
            ($attribute!="creationtime" || !$create) &&
            $attribute!="modificationtime" && $value!==NULL)
        {
            if( !$firstField ) $query .= ", ";
            convertToDbFormat($value, $typ["attributes"][$attribute], $attribute);
            // DATETIME eseten lehetoseg van az erteket NULL-ra allitani, ha a 
            // typeinfoiban benne van az 'undef'. Ha null-ra allitottak, akkor a
            // convertToDbFormat @NULL@-t ad vissza a konnyu 
            // megkulonboztethetoseg kedveert:
            $sqlParams[]=$attribute;
            if( $value==="@NULL@" ) $query .= "`param`=NULL";
            else
            {
                $query .= "`param`=#param#";
                $sqlParams[]=$value;
            }
            $firstField = FALSE;
        }
    }
    global $dontSetCreationTime, $now;
    if( isset($typ["attributes"]["creationtime"]) && $create && !isset($dontSetCreationTime))
    {
        $query.=", creationtime=#param# ";
        $sqlParams[]=$now->getDbFormat();
    }
    elseif( isset($dontSetCreationTime) && !empty($base->creationtime) && !$base->creationtime->isEmpty() )
    {
        $query.=", creationtime=#param# ";
        $sqlParams[]=$base->creationtime->getDbFormat();
    }
}

// a formbol erkezo erteket alakitja at olyan formatumuva, amilyennek a 
// DB-ben kell lennie:
function convertToDbFormat( &$value, &$attrInfo, $attr )
{
    if( is_object($value) )
    {
        $value = $value->getDbFormat();
    }
    elseif( is_array($value) )
    {
        if(in_array("url", $attrInfo))
        {
            //if( !preg_match("{^https?://}", $value[0] ) ) $value[0] = "http://$value[0]";
            $value = "<a href='$value[0]' target='_blank'>$value[1]</a>";
        }
        elseif(in_array("multimask", $attrInfo)) {
            $tmp = "";
            foreach($value as $val) $tmp+=$val;
            $value = $tmp;
        }
        else // multipleselection
        {
            $value = dbEncodeEnumValue($value);
        }
    }
}

function dbEncodeEnumValue($val)
{
    if( is_array($val) ) return join( ",", array_map(create_function('$v', 'return str_replace(",", ",,", $v);'), $val) );
    else return str_replace(",", ",,", $val);
}

function modify( &$base, $whereFields="" )
{
    global $globQuery;

    if( ($ret = $base->valid()) || Roll::isFormInvalid() ) return $ret;

    $typ =& $base->getTypeInfo(TRUE);
    $table = $base->get_table();
    $query="UPDATE @$table SET ";
    getCreateSetStr($base, $typ, FALSE, $s, $sqlParams);
    $query.=$s;
    $hasMany = new HasManyAttrs($base);
    $whereExists = FALSE;
    if( $whereFields=="" ) $whereFields=getPrimaryKey( $typ );
    if( $whereFields )
    {
        $firstField = TRUE;
        foreach( $whereFields as $key )
        {
            if( isset($base->{$key}) )
            {
                $sqlParams[]=$key;
                $sqlParams[]=$base->{$key};
                if( $firstField )
                {
                    $whereOK=TRUE;
                    $query .= " WHERE `param`=#param#";
                    $firstField = FALSE;
                    $whereExists = TRUE;
                }
                else $query .= " AND `param`=#param#";
            }
        }
    }
    array_unshift($sqlParams, $query);
    $query = $sqlParams;
    $globQuery=$query;
    if( $whereExists ) 
    {
        executeQuery($query);
        $hasMany->modify();
    }
    else trigger_error("Modify without WHERE: ".print_r($query, TRUE),E_USER_ERROR);
    return ok;
}

function delete( &$base, $whereFields="" )
{
    global $globQuery;

    if (isset($base->up)) {//recursive delete
        // Ha veletlenul a whereFields nem az id, akkor az id-t be kell
        // tolteni, mert az kell a rekurziv delete-ben:
        if (!isset($base->id)) {
            $ret = $base->load($whereFields);
            if ($ret==not_found_in_db) {
                return $ret;
            }
        }
        getChildrenFromDb($base,$children);
        foreach($children as $child) $child->delete($whereFields);
    }
    $typ =& $base->getTypeInfo();
    $table = $base->get_table();
    $query="DELETE FROM @$table";
    $sqlParams=array();
    $whereExists = FALSE;
    if( $whereFields=="" ) $whereFields=getPrimaryKey( $typ );
    if( $whereFields )
    {
        $firstField = TRUE;
        foreach( $whereFields as $key )
        {
            if( isset($base->{$key}) )
            {
                $sqlParams[]=$key;
                $sqlParams[]=$base->{$key};
                if( $firstField )
                {
                    $query .= " WHERE `param`=#param#";
                    $firstField = FALSE;
                    $whereExists = TRUE;
                }
                else $query .= " AND `param`=#param#";
            }
        }
    }
    array_unshift($sqlParams, $query);
    $query = $sqlParams;
    $globQuery=$query;
    $hasMany = new HasManyAttrs($base);
    $hasMany->delete();
    if( $whereExists ) executeQuery($query);
    else trigger_error("Delete without WHERE: ".print_r($query, TRUE),E_USER_ERROR);
    return ok;
}

function getPrimaryKey( &$typ )
{

    if( isset($typ["primary_key"]) )
    {
        $primaryKey = &$typ["primary_key"];
        if( is_array($primaryKey) )
        {
            return $primaryKey;
        }
        elseif( strstr($primaryKey, ",") )
        {
            return split(", *", $primaryKey);
        }
        else
        {
            return array($primaryKey);
        }
    }
    return ok;
}

function getAutoIncrementAttribute( &$typ )
{
    foreach( $typ["attributes"] as $attribute=>$attrInfo )
    {
        if( in_array("auto increment", $attrInfo))
        {
            return $attribute;
        }
    }
    return ok;
}
function connectDb($host="",$user="",$pw="",$db="")
{
    $ret = mysql_connect($host, $user, $pw);
    if (!$ret) {
        $txt="Mysql connection failed. Host: $host, Username: $user";
        handleErr($txt,__FILE__,__LINE__);
    }
    $ret=mysql_select_db($db);
    if (!$ret) {
        $txt="Mysql select database failed. Database name: $db";
        handleErr($txt,__FILE__,__LINE__);
    }
    // Make sure any results we retrieve or commands we send use the same charset and collation as the database:
    $db_charset = mysql_query( "SHOW VARIABLES LIKE 'character_set_database'" );
    $charset_row = mysql_fetch_assoc( $db_charset );
    mysql_query( "SET NAMES '" . $charset_row['Value'] . "'" );
    unset( $db_charset, $charset_row );
    set_magic_quotes_runtime(0);
    // Switch off strict mode:
    mysql_query( "SET SESSION sql_mode=''");
    // on some servers, this is set to 60sec, which causes a "MySQL server has gone away"
    // error even if we set the Php execution time to unlimited. Setting back to its default:
    executeQuery("SET wait_timeout=28800");
}

function getDbCount( &$count, $query)
{
    $row=mysql_fetch_row(executeQuery($query));
    $count=$row[0];
}

function lock($tables)
{
    $query="LOCK TABLES ";
    if (is_string($tables)) $query.=$tables." WRITE";
    else {
        $notfirst=FALSE;
        foreach($tables as $table) {
           if ($notfirst) $query.=",";
           $query.=$table." WRITE";
           $notfirst=TRUE;
        }
    }
    executeQuery($query);
}

function unlock()
{
    executeQuery("UNLOCK TABLES");
}

function getAllColumns( $typ, $tableAlias )
{
    $s = "";
    foreach( $typ["attributes"] as $attr=>$attrInfo )
    {
        if( !in_array("no column", $attrInfo) )
        {
            $s.="$tableAlias.$attr AS $attr, ";
        }
    }
    return $s;
}

function reportError($query)
{
    $txt="";
    $txt.="query = $query\n\n";
    $txt.="POST VARS\n";
    foreach($_POST as $key=>$value) {
        $txt.="$key = $value\n";
    }
    $txt.="\n\nGET VARS\n";
    foreach($_GET as $key=>$value) {
        $txt.="$key = $value\n";
    }
    //mail("contact@phpoutsourcing.com","Serious error",$txt);
    //handleErr("A serious error is occured. If you want to help the developers to find this error, send a mail to <a href='mailto:contact@phpoutsourcing.com'>contact@phpoutsourcing.com</a> and describe the steps you have made before this error occured. The better your description is, the easier we can find the bug. Thanks.",__FILE__, __LINE__);
    echo $txt;
    handleErr("An error occured.",__FILE__, __LINE__);
}

function getPassword( $s )
{
    $s=addcslashes($s,"'\\");
    $version = mysql_get_server_info();
    $mainVersion = intval($version[0]);
    $subVersion = intval($version[2]);
    $pwdQuery = ($mainVersion==4 && $subVersion==0) || $mainVersion<4 ? "password" : "old_password";
    $data = mysql_query("select $pwdQuery('$s')");
    $row = mysql_fetch_row($data);
    return $row[0];
}

function quoteSQL($text) 
{
    $output = addcslashes($text,"'\\");
    if (version_compare(phpversion(),"4.3.0", "<")) mysql_escape_string($output);
    else mysql_real_escape_string($output);
    return $output;
}

function executeQueryForUpdate( $query, $file="", $line="" )
{
    global $dbPrefix;
    
    //  When working with a replacement pattern where a backreference is immediately followed by another number 
    // (i.e.: placing a literal number immediately after a matched pattern), you cannot use the familiar \\1 notation 
    // for your backreference. \\11, for example, would confuse preg_replace() since it does not know whether you want 
    // the \\1 backreference followed by a literal 1, or the \\11 backreference followed by nothing. 
    // In this case the solution is to use \${1}1. This creates an isolated $1 backreference, leaving the 1  as a literal.
    $query = preg_replace("/(\W)@/", "\${1}$dbPrefix", $query );
    $ret = mysql_query( $query );
    if( $err = mysql_error() )
    {
        if( !defined("NOAH_BASE") ) define('NOAH_BASE', "." );
        if( !defined("LOG_DIR") ) define("LOG_DIR", NOAH_BASE . "/logs");
        if( $f = fopen(LOG_DIR . "/update-".date("Y-m-d-H-i").".log", "a") )
        {
            $error = "Error occurred in: $file - line: $line\n";
            $error.= "Query: $query\n";
            $error.= "Error: ".mysql_errno()." - $err\n";
            $error.= "--------------------------------------------------------------------------------------------------\n";
            fwrite( $f, $error );
            fclose($f);
        }
    }
    return $ret;
}

function alterDatabaseColumns($table, $operation, $columns, $file="", $line="")
{
    foreach( $columns as $column )
    {
        executeQueryForUpdate("ALTER TABLE @$table $operation $column", $file, $line);
    }
}

// elofordult, hogy az update leallt memory overflow-val egy olyan muvelet soran, 
// ahol pl az osszes category-t le kellett kerni. Hogy ezt elkeruljuk, blokkonkent 
// hajtjuk vegre a muveletet - igy kisebb lesz az egyszerre lekert adat merete:
// $operation egy globalis fuggvenynev, vagy egy (osztalynev, fg) par, 
// hogy statikus osztalyfuggvenyt is lehessen hasznalni
function iterateLargeDatabaseTable($query, $operation)
{
    $blockSize = 100;
    $offset = 0;
    G::load( $objs, $query." LIMIT $offset, $blockSize" );
    while( count($objs) )
    {
        foreach( $objs as $obj )
        {
            if( is_array($operation) ) call_user_func($operation, $obj);
            else $operation($obj);
        }
        $offset+=$blockSize;
        G::load( $objs, $query." LIMIT $offset, $blockSize" );
    }
}

?>
