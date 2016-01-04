<?php
defined('_NOAH') or die('Restricted access');

global $FormPresentation_fieldTypes;
$FormPresentation_fieldTypes = array("section","txtsection","freepart","text","file","datetext","password","button","submit",
                       "textarea","multipleselection","checkbox","selection",
                       "classselection","multipleclassselection","date",
                       "time","bool","radio","url","readonly","voice","fieldgroup");

class FormFieldType 
{
    
function getFormDisplayType( &$attrInfo, $method, $attr )
{
    global $FormPresentation_fieldTypes;
    
    if( isset($attrInfo["freepart"]) ) return "freepart";
    foreach( $attrInfo as $key=>$val )
    {
        if( is_string($val) && strstr($val, "$method:") )
        {
            $arr = split(": *", $val);
            if( in_array( $type = $arr[1], $FormPresentation_fieldTypes ) ) return $type;
        }
    }
    foreach( $attrInfo as $key=>$val )
    {
        if( is_string($val) && is_int($key) && in_array($val, $FormPresentation_fieldTypes) )
        {
            return $val;
        }
    }
    return "";
}

}
?>
