<?php
defined('_NOAH') or die('Restricted access');

function gorumMain()
{
    global $gorumroll;

    $init = Init::createObject();
    $init->initializeSystemSettings();
    $gorumroll->processMethod();
    if( !$gorumroll->isAction() )
    {        
        $init->getTemplate();
        $init->showApp();
    }
}

//----------------------------------------------------------------------
//  Begin - Handle Error
//----------------------------------------------------------------------
//Ezt mar nem szabadna hivni, csak az alatta levoket
function handleError($error="",$query="",$file="",$line="")
{
    global $dieOnError;
    if ($error=="mysql") {
        $s="$query<br><br>\n".mysql_error();
        if ($file) {
            $s.="<br><br>query error in $file, row:$line";
        }
    }
    else $s=$error;
    trigger_error($s,E_USER_ERROR);
    //ide nem jutunk el csak lokalisan, mert az appl err handler megall
    $errMsg = ob_get_contents();
    @ob_end_clean();
    if( $dieOnError ) die($errMsg);
}
function handleErrorPerm($file,$line)
{
    global $hePerm, $dieOnError;

    $hePerm=1;
    $s="<br>Permission denied error in <font color='red'><b>$file</b></font> on line <font color='red'><b>$line</b></font><br>";
    trigger_error($s,E_USER_ERROR);
    //ide nem jutunk el csak lokalisan, mert az appl err handler megall
    $errMsg = ob_get_contents();
    @ob_end_clean();
    if( $dieOnError ) die($errMsg);
}
function handleErrHasObj($base,$txt,$file,$line)
{
    global $gorumuser,$gorumrecognised, $dieOnError;

    $info="Class: ".get_class($base);
    $info.="<br>\nObject dump:<br>\n".g_dump($base);
    if (isset($base->id)) $info.="<br>\nobject ID:$base->id";
    $s="<br>Permission denied error!<br>$info<br>\n<font color='red'><b>$file</b></font>,on line <font color='red'><b>$line</b></font><br>";

    trigger_error($s,E_USER_ERROR);
    //ide nem jutunk el csak lokalisan, mert az appl err handler megall
    $errMsg = ob_get_contents();
    @ob_end_clean();
    if( $dieOnError ) die($errMsg);
}
function handleErrorNotFound($base,$file,$line)
{
    global $dieOnError;
    $s="<br>Object not found in db!<br> Object dump: ".g_dump($base)."<br>Error occured in <font color='red'><b>$file</b></font>, on line <font color='red'><b>$line</b></font><br>";
    trigger_error($s,E_USER_ERROR);
    //ide nem jutunk el csak lokalisan, mert az appl err handler megall
    $errMsg = ob_get_contents();
    @ob_end_clean();
    if( $dieOnError ) die($errMsg);
}
function handleErr($error,$file,$line)
{
    global $dieOnError;
    $s="<br>$error in <font color='red'><b>$file</b></font>, on line <font color='red'><b>$line</b></font><br>";
    trigger_error($s,E_USER_ERROR);
    //ide nem jutunk el csak lokalisan, mert az appl err handler megall
    if( $dieOnError ) die($errMsg);
}
function handleErrorSql($query)
{
    global $dieOnError;
    
    if( mysql_error()=="MySQL server has gone away" )
    {
        // reconnect:
        global $dbHost, $dbUser, $dbUserPw, $dbName;
        connectDb($dbHost, $dbUser, $dbUserPw, $dbName);
        // reissue the query:
        executeQuery($query);
        return;
    }
    $s="<br>\n".htmlspecialchars($query)."<br>\n".mysql_error();
    //echo("$s<br>");die();
    trigger_error($s,E_USER_WARNING);
    //ide nem jutunk el csak lokalisan, mert az appl err handler megall
    //$errMsg = ob_get_contents();
    //ob_end_clean();
    //if( $dieOnError ) die($errMsg);
    //die();
}
/*
function localHandleErrorEnd($s)
{
    $errMsg = ob_get_contents();
    ob_end_clean();
    die($errMsg.nl2br(htmlspecialchars($s)));
}
*/
//----------------------------------------------------------------------
//  End - Handle Error
//----------------------------------------------------------------------

function g_dump($var)
{
    ob_start();
    var_dump($var);
    $retDump = ob_get_contents();
    ob_end_clean();
    return $retDump;
}
function z_specchars($s)
{
    $s = str_replace("<","&lt;",$s);
    $s = str_replace(">","&gt;",$s);
    $s = str_replace('"',"&quot;",$s);
    return $s;
}
function gg_mt($list,$method,$rollid=0)
{
    $ctrl = new AppController();
    $ctrl->method=$method;
    if ($list) $ctrl->list=$list;
    if ($rollid) $ctrl->rollid=$rollid;
    return $ctrl;
}
function gg_mta($method,$id)
{
    $ctrl = new AppController();
    $ctrl->ap=$id;
    return $ctrl;
}
//php5 backward compatibility

function gget_parent_class($obj)
{
    return strtolower(get_parent_class($obj));
}
function gclone($a)
{
    if( phpversion() >= "5" ) {
        return clone($a);
    }
    else{
        return $a;
    }
}

// egy integert alakit ilyesmi formatumuva:
// 128 bytes; 1.34 KB; 1,011.34 KB; 5.67 MB; 10 GB
// ha complex=TRUE, akkor a byte erteket is utana irja zarojelben
function num2byteStr($val, $complex=FALSE)
{
    $val = intval($val);
    if( !$val ) $s="0 byte";
    elseif( $val==1 ) $s= "1 byte";
    elseif( $val<1024 ) $s= number_format($val)." bytes";
    elseif( $val<1048576 )  $s= number_format($val/1024, 2)." KB";
    elseif( $val<1073741824 )  $s= number_format($val/1048576, 2)." MB";
    else $s= number_format($val/1073741824, 2)." GB";
    if( $complex && $val>=1024 ) $s.=" (".number_format($val)." bytes)";
    return $s;
}

// az elozo fg forditottja:
function byteStr2num($s)
{
    
    $s = strtoupper(preg_replace("{[, ]}", "", trim($s)));
    if( is_numeric($s) ) return intval($s);
    if( preg_match('{(\d+)(BYTES?|KB|MB|GB|M|G|K)$}', $s, $matches) )
    {
        if( $matches[2]=="BYTE" || $matches[2]=="BYTES" ) return intval($matches[1]);
        elseif( $matches[2]=="K" || $matches[2]=="KB" ) return intval($matches[1])*1024;
        elseif( $matches[2]=="M" || $matches[2]=="MB" ) return intval($matches[1])*1048576;
        elseif( $matches[2]=="G" || $matches[2]=="GB" ) return intval($matches[1])*1073741824;
        else return FALSE; // bar ebbe az agba nem johet
    }
    else return FALSE;  // unrecognizable format
}

// 111,222,333,,444,5,,,6,,,7 =>
// (
//      "111",
//      "222",
//      "333,444",
//      "5,",
//      "6,",
//      "7"
// )
function splitByCommas($s, $withHtmlEncoding=TRUE)
{    
    if( $s==="" ) return array();    
    if( is_array($s) ) $ret = $s;
    else $ret = array_map(create_function('$v', 'return str_replace(",,", ",", $v);'), 
                          preg_split("/((?<!,)|((?<=(?<!,),,))),(?!,)/", $s));
    if( $withHtmlEncoding )
    {
        return array_map(create_function('$v', 'return htmlspecialchars($v);'),$ret);
    }
    else return $ret;
}

?>
