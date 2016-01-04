<?php
defined('_NOAH') or die('Restricted access');

global $gorumjavascript, $gorumjavascript_cache;
$gorumjavascript = new JavaScript();
$gorumjavascript_cache = 0;

class JavaScript
{
var $includes;
var $css;
var $scripts;
var $onload;
var $hiddenContent;

function JavaScript()
{
    $this->includes=array();
    $this->css=array();
    $this->scripts=array();
    $this->onload=array();
    $this->hiddenContent=array();
}

function addScript( $script, $key=0 )
{
    global $gorumjavascript, $gorumjavascript_cache;
    $gorumjavascript->_addScript( $script, $key );
    if( $gorumjavascript_cache ) $gorumjavascript_cache->_addScript( $script, $key );
}

function addOnload( $script, $key=0 )
{
    global $gorumjavascript, $gorumjavascript_cache;
    $gorumjavascript->_addOnload( $script, $key );
    if( $gorumjavascript_cache ) $gorumjavascript_cache->_addOnload( $script, $key );
}

function addHiddenContent( $content, $key=0 )
{
    global $gorumjavascript, $gorumjavascript_cache;
    $gorumjavascript->_addHiddenContent( $content, $key );
    if( $gorumjavascript_cache ) $gorumjavascript_cache->_addHiddenContent( $content, $key );
}

function addEvent( $selector, $eventName, $event )
{
    global $gorumjavascript, $gorumjavascript_cache;
    $gorumjavascript->_addEvent( $selector, $eventName, $event );
    if( $gorumjavascript_cache ) $gorumjavascript_cache->_addEvent( $selector, $eventName, $event );
}

function addInclude( $file )
{
    global $gorumjavascript, $gorumjavascript_cache;
    $gorumjavascript->_addInclude( $file );
    if( $gorumjavascript_cache ) $gorumjavascript_cache->_addInclude( $file );
}

function addCss( $file )
{
    global $gorumjavascript, $gorumjavascript_cache;
    $gorumjavascript->_addCss( $file );
    if( $gorumjavascript_cache ) $gorumjavascript_cache->_addCss( $file );
}

function getScript()
{
    global $gorumjavascript;
    return $gorumjavascript->_getScript();
}

function getIncludes()
{
    global $gorumjavascript;
    return $gorumjavascript->_getIncludes();
}

function getHiddenContent()
{
    global $gorumjavascript;
    return $gorumjavascript->_getHiddenContent();
}

function initClueTip()
{
    global $jQueryLib;
    
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.dimensions.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.hoverIntent.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.bgiframe.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/cluetip/jquery.cluetip.js");
}

function _addScript( &$script, $key=0 )
{
    if( $key && !isset($this->scripts[$key]) ) $this->scripts[$key]=$script;
    elseif( !$key ) $this->scripts[]=$script;
}

function _addHiddenContent( &$content, $key=0 )
{
    if( $key && !isset($this->hiddenContent[$key]) ) $this->hiddenContent[$key]=$content;
    elseif( !$key ) $this->hiddenContent[]=$content;
}

function _addOnload( $script, $key=0 )
{
    global $jQueryLib;
    
    $this->_addInclude(GORUM_JS_DIR . $jQueryLib);
    if( $key && !isset($this->onload[$key]) ) $this->onload[$key]=$script;
    elseif( !$key ) $this->onload[]=$script;
}

// Pl. ha $additionalData={foo: "bar"} azzal a handlernek atadjuk "bar"-t a foo-ban:
// function handler(event) {
//   alert(event.data.foo);
// }
function _addEvent( $selector, $eventName, $event, $additionalData='' )
{
    $eventName = strtolower($eventName);
    // az event csak egy szimpla fuggvenynev lehet, ezert ha nem az erkezik,
    // hanem valami tetszoleges JS kod, akkor azt elobb "be kell agyazni" egy
    // fuggvenybe es azt a fuggvenyt tovabbadni:
    if( !preg_match("{^[\w]+$}", $event) )
    {
        $event = "function(event){
            $event
        }";
    }
    if( $additionalData ) $this->_addOnload("$('$selector').bind('$eventName', $additionalData, $event);");
    else $this->_addOnload("$('$selector').bind('$eventName', $event);");
}

function _addInclude( $file )
{
    global $jQueryLib;
    
    if( !in_array($file, $this->includes) ) 
    {
        $this->includes[]=$file;
        // so that the inclusion of noah.js always immediately follows the inclusion of jquery.php:
        if( strstr($file, $jQueryLib) && !in_array(JS_DIR . "/noah.js", $this->includes)) $this->includes[]= JS_DIR . "/noah.js";
    }
}

function _addCss( $file )
{
    if( !in_array($file, $this->css) ) $this->css[]=$file;
}

function _getScript()
{    
    $scripts = implode("\n", $this->scripts);
    $s="
    <script type='text/javascript'>
    <!--
    $scripts";
    if( count($this->onload) )
    {
        $onload = implode("\n", $this->onload);
        $s.="                
        jQuery(document).ready(function($) {
            $onload;
        })
        ";
    }
    $s.="
    -->
    </script>";
    return $s;
}
    
function _getIncludes()
{
    global $keysToJsFiles, $keysToCssFiles, $theme, $jQueryLib;

    $_S = new AppSettings();
    $jsFilesToKeys = array_flip($keysToJsFiles);
    $cssFilesToKeys = array_flip($keysToCssFiles);
    $s=$additionalCss=$additionalJs="";
    $param = array();
    foreach( $this->css as $inc )
    {
        if( $_S->enableCombine && isset($cssFilesToKeys[$inc]) ) $param[] = $cssFilesToKeys[$inc];
        // ha nincs a mapping tombben, a regi modszerrel adjuk hozza:
        else $additionalCss.="<style type='text/css'>@import url($inc);</style>\n";
    }
    $param = implode(",", $param);
    if( $param ) $s.="<link rel='StyleSheet' href='combine.php?type=css&theme=$theme&files=$param' type='text/css'>\n";
    $s.=$additionalCss;
    $param = array();
    foreach( $this->includes as $inc )
    {
        if( $_S->enableCombine && isset($jsFilesToKeys[$inc]) ) $param[] = $jsFilesToKeys[$inc];
        // ha nincs a mapping tombben, a regi modszerrel adjuk hozza:
        else $additionalJs.="<script src='$inc' type='text/javascript'></script>\n";
        // in order to avoid conflict with other JS libraries, $JQ will be used instead of $:
        if( strstr($inc, $jQueryLib) )
        {
            // This has been moved into noah.js:
            //$additionalJs.="<script  type='text/javascript'>var \$JQ = jQuery.noConflict();</script>\n";
        }
    }
    $param = implode(",", $param);
    if( $param ) $s.="<script src='combine.php?type=javascript&theme=$theme&files=$param' type='text/javascript'></script>\n";
    $s.=$additionalJs;
    return $s;
}
    
function _getHiddenContent()
{
    $s="";
    foreach( $this->hiddenContent as $key=>$content )
    {
        $id = is_numeric($key) ? "" : "id='$key'";
        $s.="<div $id style='display:none'>\n$content\n</div>\n";
    }
    return $s;
}

function mergeCache( $otherObject )
{
    $methodMapping = array("includes"=>"addInclude", "css"=>"addCss", "scripts"=>"addScript", "onload"=>"addOnload", "hiddenContent"=>"addHiddenContent"); 
    foreach( get_object_vars($otherObject) as $attr=>$value )
    {
        foreach( $value as $key=>$val )
        {
            if( is_numeric($key) ) call_user_func(array("JavaScript", $methodMapping[$attr]), $val);
            else call_user_func(array("JavaScript", $methodMapping[$attr]), $val, $key);
        }
    }
}
  
function jsonDecode($s)
{
    if( !$s ) return array();
    if ( function_exists('json_decode') ) return json_decode($s);
    include_once(GORUM_DIR. "/FastJSON.class.php");
    return FastJSON::decode($s);
}

} // end class
?>
