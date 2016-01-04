<?php
defined('_NOAH') or die('Restricted access');

class Filter
{
var $width='';
var $filterText='';
var $resetOnClick=FALSE;
var $enable=FALSE;
const settingName='clientSideTableFilter';
    
function Filter(&$typ)
{
    foreach( array('width', 'filterText', 'resetOnClick', 'enable') as $a )
    {
        $v=G::getSetting( $typ, Filter::settingName, $a);
        if( $v!==NULL ) $this->{$a}=$v;
    }
}

function generField($filterConf, &$list, $attr)
{
    // Lokalis parameterek inicializalasa az osztalyvaltozok alapjan:
    foreach( array('width', 'filterText', 'resetOnClick', 'enable') as $a ) $$a = $this->{$a};
    // A $filterConf-ban erkezo ertekek felulirhatjak a lokalis parametereket:
    if( is_array($filterConf) )
    {
        foreach( array('width', 'filterText', 'resetOnClick', 'enable') as $a )
        {
            if( isset($filterConf[$a]) ) $$a = $filterConf[$a];
        }
        $type = $filterConf['type'];
    }
    else $type = $filterConf;
    if( !$enable ) return "";
    if( $type=="text_filter" )
    {
        $onclick = $resetOnClick ? "onclick=\"this.value='';Table.filter(this,this)\"" : "";
        $s=GenerWidget::generTextField($type,"filter",$filterText,$width, "",
                                " onkeyup=\"Table.filter(this,this)\" $onclick");
    }
    elseif( $type=="select_filter" )
    {
        $values = array_unique(array_map(create_function('$v', "return strip_tags(\$v->showListVal('$attr'));"), $list));
        $values[]="";
        sort($values);
        $labels=$values;
        $labels[0]="All";
        $s=GenerWidget::generSelectField("filter",$labels,$values,"", "All", 0, $width, "", "onchange=\"Table.filter(this,this)\"");
    }
    return $s;
}

}

?>