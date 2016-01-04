<?php
defined('_NOAH') or die('Restricted access');
class ItemScrollablePresentation extends ListPresentation
{

function processContent(&$tpl)
{
    global $lll,$gorumroll,$list2Colors, $orientation, $scrollablePlacement;
    
    $this->base->loadHtmlList($list);
    $tpl->assign("zebraList", $this->zebraList);
    $isEmptyList = !count($list);
    if( !count($list) ) return 1;  // ezzel azt jelezzuk, a hivo fg-nek, hogy ures sztringgel kell visszaternie rogton
    $tpl->assign("title", $lll[$gorumroll->list."_ttitle"]);
    
    $attributeList = isset($this->typ["listOrder"]) ? $this->typ["listOrder"] : array_keys($this->typ["attributes"]);
    $tpl->assign("orientation", $orientation);
    $tpl->assign("id", $gorumroll->rollid."_$scrollablePlacement");
    $cells=array();
    for( $i=0; $i<count($list); $i++ ) 
    {
        $listItem = $list[$i];
        $cells[$i]           = array();
        $cells[$i]["rows"]   = array();
        $cells[$i]["title"]  = "";
        $j=0;
        $ctrl = $listItem->getLinkCtrl();
        $cells[$i]["link"]  = $ctrl->makeUrl();
        foreach( $attributeList as $attr )
        {
            $val = & $this->typ["attributes"][$attr];
            if ( in_array("list",$val) )
            {
                if( in_array("titleTag",$val) ) 
                {
                    $cells[$i]["title"] = $listItem->getTitle();
                }
                elseif( in_array("in new line",$val) )
                {
                    $cells[$i]["rows"][$j++] = array("value"=>$listItem->showListVal($attr), "class"=>"cell");
                }
                else
                {
                    if( !in_array("file",$val) || in_array("media",$val) )
                    {
                        $lllProp = new LllProperties( $listItem, $attr );
                        $label = "<span class='label'>".$lllProp->getLabel()."</span>";
                        $value = $listItem->showListVal($attr);
                        $cells[$i]["rows"][$j++] = array("value"=>"$label: $value", "class"=>"cell");
                    }
                    elseif( $listItem->$attr )
                    {
                        $value = $listItem->showPicture($attr, "small", TRUE);  // no href
                        $cells[$i]["rows"][$j++] = array("value"=>$value["tag"], "class"=>"picture");
                    }
                }    
            }
        }
    }
    $tpl->assign("cells", $cells);
}

} // end class
?>
