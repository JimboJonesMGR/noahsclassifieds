<?php
defined('_NOAH') or die('Restricted access');

class LllProperties
{

var $anchestors;
var $lll;
var $attr;
var $class;

var $label="";    
var $expl="";    
var $afterField="";    
var $embedField="";    
var $colHeader="";    

function LllProperties( &$obj, $attr, $dropNotice=TRUE )
{
    global $lll;
    
    $this->attr = $attr;
    $this->lll = & $lll;    
    $this->getAnchestors($this->class = $obj->get_class());
    foreach( array("label"=>"", "expl"=>"_expl", "afterField"=>"_afterfield", "embedField"=>"_embedfield", "colHeader"=>"_colhead") as $var=>$postfix )
    {
        for( $i=0; $i<count($this->anchestors) && !$this->$var; $i++ )
        {
            $x = "{$this->anchestors[$i]}_$attr$postfix";
            if(isset($lll[$x]) ) $this->$var=$lll[$x];
        }
        if( !$this->$var && isset($lll[$attr.$postfix]))
        {
            $this->$var=$lll[$attr.$postfix];
        }
        elseif( $dropNotice && !$this->$var && $var=="label" ) trigger_error( "Uninitialized object label of class $this->class: $attr", E_USER_NOTICE );
    }
    //var_dump($this->anchestors);
}

function getAnchestors ($class)
{         
     for( $this->anchestors[]=$class; $class=get_parent_class($class); )
        if( ($class=strtolower($class))!="object") $this->anchestors[]=$class;
}

function getLabel() { return $this->label; }
function getExpl() { return $this->expl; }
function getAfterField() { return $this->afterField; }
function getEmbedField() { return $this->embedField; }
function getColHeader() { return $this->colHeader; }

function & getSelectLabels( &$valueList )
{
    $labels = array();
    foreach($valueList as $key=>$value)
    {
        for( $i=0; $i<count($this->anchestors) && !isset($labels[$key]); $i++ )
        {
            $x = "{$this->anchestors[$i]}_{$this->attr}_$value";
            if(isset($this->lll[$x]) ) $labels[$key]=$this->lll[$x];
        }
        if( !isset($labels[$key]) && isset($this->lll[$this->attr."_".$value]) )
        {
            $labels[$key]=$this->lll[$this->attr."_".$value];
        }
        elseif( !isset($labels[$key]) ) trigger_error( "Uninitialized select field label of class $this->class: $this->attr, field: $value", E_USER_NOTICE );
    }
    return $labels;
}

}
?>