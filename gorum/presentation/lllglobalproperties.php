<?php
defined('_NOAH') or die('Restricted access');

class LllGlobalProperties
{

var $anchestors;
var $class;

function LllGlobalProperties( &$obj )
{
    $this->getAnchestors($this->class = $obj->get_class());
}

function getAnchestors ($class)
{         
     for( $this->anchestors[]=$class; $class=get_parent_class($class); )
        if( ($class=strtolower($class))!="object") $this->anchestors[]=$class;
}

function getLabel($label="", $dropNotice=TRUE) 
{ 
    global $lll;
    if( $label )
    {
        for( $i=0; $i<count($this->anchestors) && empty($this->$label); $i++ )
        {
            $x = "{$this->anchestors[$i]}_$label";
            if(isset($lll[$x]) ) $this->$label=$lll[$x];
        }
    }
    else
    {
        for( $i=0; $i<count($this->anchestors); $i++ )
        {
            $x = $this->anchestors[$i];
            if(isset($lll[$x]) ) return $lll[$x];
        }
    }
    if( $dropNotice && (!$label || empty($this->$label)) ) trigger_error( "Uninitialized label of class $this->class: $label", E_USER_NOTICE );
    return $label ? (empty($this->$label) ? "" : $this->$label) : ""; 
}

}
?>