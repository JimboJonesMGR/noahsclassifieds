<?php
defined('_NOAH') or die('Restricted access');

class Controller
{
var $list   = "";
var $method = "";
var $rollid = "";
var $classVars = array();
var $absolute = FALSE;  // decides whether makeUrl should create a relative or absolute link

// Negyfele parameterrrel inicializalodhat:
// - queryString: pl.: appcategory/list/18/attr/foo - ebben az esetben az AppController->init() vegzi el az inicializalast
// - array:       pl.: array('list'=>'item', 'rollid'=>20, 'attr'=>'foo') - ebben az esetben a hianyzo 'method' a $gorumroll->method-bol inicializalodik
// - 4 kulon param.  : 'item', 'showdetails', '10', array('id',20,'cid',30,'name','foo') - az utolso opcionalis
// - egy masik Controller objektum: ebben az esetben masolat keszul 
function Controller()
{
    global $controllerShortcuts;
    
    $args = func_get_args();
    //var_dump($args);
    if( count($args)==0 ) return;  //permaLink
    if( count($args)==1 )
    {
        if( is_string($args[0]) ) $this->init($args[0]);
        elseif( is_object($args[0]) )
        {
            foreach( get_object_vars($args[0]) as $attr=>$val ) $this->$attr = $val;
        }
        else
        {
            global $gorumroll;
            if( isset($args[0]["list"]) )
            {
                $this->list = $args[0]["list"];
                unset($args[0]["list"]);
            }
            else @$this->list = $gorumroll->list;
            if( isset($args[0]["method"]) )
            {
                $this->method = $args[0]["method"];
                unset($args[0]["method"]);
            }
            else @$this->method = $gorumroll->method;
            if( isset($args[0]["rollid"]) )
            {
                $this->rollid = $args[0]["rollid"];
                unset($args[0]["rollid"]);
            }
            elseif( isset($gorumroll->rollid) ) $this->rollid = $gorumroll->rollid;
            else $this->rollid = 0;
            // ha marad meg valami a list, method, es rollid leszedese utan, az a classVars-ba kerul:
            if( count($args[0]) ) $this->classVars = $args[0];  
        }
    }
    else
    {
        $this->list   = isset($controllerShortcuts[$args[0]]) ? $controllerShortcuts[$args[0]] : $args[0];
        $this->method = isset($controllerShortcuts[$args[1]]) ? $controllerShortcuts[$args[1]] : $args[1];
        $this->rollid = isset($args[2]) ? $args[2] : 0;
        if( isset($args[3]) ) 
        {
            // atalakitas: array('attr1', 'val1', 'attr2', 'val2') ==> array('attr1'=>'val1', 'attr2'=>'val2')
            while( count($args[3]) ) $this->classVars[array_shift($args[3])] = array_shift($args[3]);
        }
    }
}

function init()
{
    // a leszarmazottnak kell definialni
}

function getClass() 
{ 
    return count($listParts = explode("_", $this->list)) ? $listParts[0] : $this->list;
}

function getClassVars() 
{ 
    return count($this->classVars) ? $this->classVars : 0;
}

function generHiddenFields($postfix="")
{
    $s = "";
    foreach( array("list", "method", "rollid") as $attr ) $s.=Controller::generHiddenFieldsCore($attr, $this->$attr, $postfix);
    return $s;
}

function generHiddenFieldsCore( $attr, $val, $postfix )
{
    if( !$val ) return "";
    return GenerWidget::generHiddenField($attr , $val , $postfix);
    
}

function makeUrl($absolute = FALSE)
{
    global $scriptName, $gorumroll;

    $path = $absolute || $this->absolute ? Controller::getBaseUrl() : "";
    if( !($queryString = $this->makeQueryString()) ) return Controller::getBaseUrl();
    if( empty($gorumroll->rewriteOn) ) $path.="$scriptName?";
    return $path . $queryString;
}

function makeQueryString()
{
    // AppControllerben kell definialni
}

function generAnchor( $label, $cssClass="", $absolute=FALSE, $target="", $encode=TRUE )
{
    return GenerWidget::generAnchor($this->makeUrl($absolute), $label, $cssClass, $target, $encode );
}

function generImageAnchor( $src, $alt, $width="", $height="", $cssClass="", $absolute=FALSE, $target="" )
{
    return GenerWidget::generImageAnchor($this->makeUrl($absolute), $src, $alt, $width, $height, $cssClass, $target );
}

function isAction() 
{
    global $actionMethods;
    return in_array( $this->method, $actionMethods );
}

function isAjax() 
{
    global $ajaxMethods;
    return isset($ajaxMethods[$this->list]) && (
        in_array( $this->method, $ajaxMethods[$this->list] ) ||
        isset($ajaxMethods[$this->list][$this->method]) && in_array( $this->rollid, $ajaxMethods[$this->list][$this->method] ) );
}

function getBaseUrl()
{
    global $cgiUrl;
    
    if( $cgiUrl ) return $cgiUrl; 
    $server = empty($_SERVER["HTTP_HOST"]) ? $_SERVER["SERVER_NAME"] : $_SERVER["HTTP_HOST"];
    if( empty($_SERVER["HTTPS"]) || strcasecmp($_SERVER["HTTPS"], "off") == 0 ) $s = "";
    else $s = "s";
    $hostName = "http$s://$server";
    return $hostName.substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/")) . "/";
}

function setAbsolute($absolute)
{
    $this->absolute = $absolute;
}

}

?>
