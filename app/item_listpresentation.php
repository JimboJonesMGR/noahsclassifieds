<?php
defined('_NOAH') or die('Restricted access');

class ItemListPresentation extends ListPresentation
{

function processContent(&$tpl)
{
    parent::processContent($tpl);
    $fieldNames = array();
    foreach( $tpl->cellFieldNames as $attr )
    {
        $fieldNames[] = ($cf = $this->base->getField($attr)) ? $cf->name : "";
    }
    foreach( $tpl->customListPlacementAttrList as $attr )
    {
        $fieldNames[$attr] = ($cf = $this->base->getField($attr)) ? $cf->name : "";
    }
    $columnCount = count($tpl->cells[0]);
    $cellsByNames = array();
    $clp = count($tpl->customListPlacementList);
    for( $i=0; $i<count($tpl->cells); $i++ )
    {
        for( $j=0; $j<$columnCount; $j++ )
        {
            if( $fieldNames[$j] ) $cellsByNames[$i][$fieldNames[$j]] =& $tpl->cells[$i][$j];
        }
        if( $clp ) foreach( $tpl->customListPlacementList[$i] as $attr=>$value ) $cellsByNames[$i][$fieldNames[$attr]] = $value;
    }
    $tpl->assign("cellsByNames", $cellsByNames);
}

} // end class
?>
