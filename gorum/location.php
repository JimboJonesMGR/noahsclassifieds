<?php
defined('_NOAH') or die('Restricted access');

$locationHistoryLimit = 10;

class LocationHistory
{

function push( $queryString )
{
    global $locationHistoryLimit;
    
    if( !isset($_SESSION["locations"]) ) LocationHistory::reset();
    if( end($_SESSION["locations"])!==$queryString && !preg_match("/\.(css|ico|js|jpg|gif|png)$/i", $queryString) ) 
    {
        array_push($_SESSION["locations"], $queryString);
    }
    if( count($_SESSION["locations"]) > $locationHistoryLimit ) array_shift($_SESSION["locations"]);
}

function reset()
{
    $_SESSION["locations"] = array();
}

// vagy egy szam erkezik, ami megmondja, hanyat lepjunk vissza a history-ban, vagy egy Controller, 
// ami meghatarozza a kovetkezo oldelt, amire menni kell:
function rollBack( $numOrController=1 )
{
    if( is_int($numOrController) )
    {
        if( !isset($_SESSION["locations"]) ) $newQueryString="/";
        else for( ; $numOrController; $numOrController-- ) $newQueryString = array_pop($_SESSION["locations"]);
        if( !$newQueryString ) $newQueryString="/";
        $numOrController = new AppController($newQueryString);
    }
    $newQueryString = $numOrController->makeUrl(TRUE);  // absolute
    header("location: $newQueryString");
    die();
}

function savePost( &$base )
{
    $_SESSION["post"] = gclone($base);
    Object::trimUnnecessaryAssociations($_SESSION["post"]);
}

function resetPost()
{
    unset($_SESSION["post"]);
}

function isPostSaved()
{
    return isset($_SESSION["post"]);
}

function saveInfoText()
{
    global $infoText;
    $_SESSION["infoText"] = $infoText;
}

function getInfoText()
{
    if( !empty($_SESSION["infoText"]) )
    {
        $temp = $_SESSION["infoText"];
        $_SESSION["infoText"]=0;
        return $temp;
    }
    return "";
}

function getBack( $num )
{
    $count = count($_SESSION["locations"]); 
    if( isset($_SESSION["locations"][$count-$num]) ) return $_SESSION["locations"][$count-$num];
    return "";
}

function saveGorumCategory($cid)
{
    global $gorumcategory;
    $_SESSION["category"] = $gorumcategory = $cid;
}

function getCategory()
{
    global $gorumcategory;
    if( empty($_SESSION["category"]) || !is_numeric($_SESSION["category"]) ) $_SESSION["category"]=0;
    return $gorumcategory = empty($_SESSION["category"]) ? 0 : $_SESSION["category"];
}

}

?>
