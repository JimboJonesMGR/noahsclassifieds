<?php
defined('_NOAH') or die('Restricted access');

class FormDisplayType
{
    
var $textTypes = array("text","file","datetext","password","button","submit",
                       "textarea","multipleselection","checkbox","selection",
                       "classselection","multipleclassselection","date",
                       "time","bool","radio","url","readonly","voice","fieldgroup");
                           
function getFormDisplayType( &$attrInfo, $method, $attr )
{
    $type="";
    foreach( $attrInfo as $key=>$val )
    {
        if( is_string($val) && strstr($val, "$method:") && $val!="$method: mandatory")
        {
            $arr = split(": *", $val);
            $type = $arr[1];
            break;
        }
    }
    if( !$type )
    {
        foreach( $attrInfo as $key=>$val )
        {
            if( is_string($val) && is_int($key) && in_array($val, $this->textTypes) )
            {
                $type = $val;
                break;
            }
        }
    }
    return $type;
}
}

?>
