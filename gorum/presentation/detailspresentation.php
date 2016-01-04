<?php
defined('_NOAH') or die('Restricted access');
if( !isset($gorumdetailstemplate) ) $gorumdetailstemplate = "default_details.tpl.php";

class DetailsPresentation extends Presentation
{
    
var $zebraDetails;

function DetailsPresentation(&$base)
{
    $this->Presentation($base, "details");  
    $this->zebraDetails = G::getSetting($this->typ, "zebraDetails" );
}

function processContent(&$tpl)
{
    global $lll,$gorumroll,$list2Colors;
    
    $tpl->assign("zebraDetails", $this->zebraDetails);
    $tpl->assign("listAndMethod", "$gorumroll->list-$gorumroll->method");
    $tpl->assign("detailsMethods", "");
    $class = $this->base->get_class();
    $attrs=$this->typ["attributes"];
    $this->base->hasGeneralRights($rights);
    $attributeList = isset($this->typ["order"]) ?
                     $this->typ["order"] : array_keys($this->typ["attributes"]);
    $headerMethods=array();
    if( $s=$this->base->showModTool($rights) ) $headerMethods[]=$s;
    if( $s=$this->base->showDelTool($rights) ) $headerMethods[]=$s;

    $lllGlobProp = new LllGlobalProperties( $this->base );
    $tpl->assign("title", sprintf($lll["detail_info"],ucfirst($lllGlobProp->getLabel())));
    
    $rows = array();
    foreach( $attributeList as $attr )
    {
        $val = & $this->typ["attributes"][$attr];
        if ( in_array("details",$val) )
        {
            if( in_array("section",$val) )
            {
                if( isset($lll[$attr]) )$rows[$attr]=array("separator"=>$lll[$attr]);
            }
            elseif( in_array("widecontent_details",$val) )
            {
                if( !($valTxt=$this->base->showListVal($attr)) ) $valTxt="&nbsp;";
                $rows[$attr]=array("widecontent"=>$valTxt);
            }
            elseif( in_array("notable",$val) )
            {
                $valTxt=$this->base->showListVal($attr);
                $rows[$attr]=array("notable"=>$valTxt);
            }
            else
            {
                $lllProp = new LllProperties( $this->base, $attr );
                $txt = $lllProp->getLabel();
                if( !($valTxt=$this->base->showListVal($attr)) ) $valTxt="&nbsp;";
                $rows[$attr]=array("label"=>$txt, "value"=>$valTxt);
            }    
        }
    }
    $tpl->assign("headerMethods", $headerMethods);
    $tpl->assign("rows", $rows);
}

} // end class
?>
