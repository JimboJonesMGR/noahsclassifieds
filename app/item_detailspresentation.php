<?php
defined('_NOAH') or die('Restricted access');
class ItemDetailsPresentation extends DetailsPresentation
{

function processContent(&$tpl)
{
    global $lll,$gorumroll,$list2Colors, $jQueryLib;
    
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
    $tpl->assign("headerMethods", $headerMethods);
    

    $tpl->assign("title", sprintf($lll["detail_info"],ucfirst($lll[$class])));
    
    $rows = $customCss = array();
    $pictures = array();
    $sideBarContent = array("fields"=>array(), "top"=>array(), "bottom"=>array());
    $mainPicture = "";
    $picFieldExists = FALSE;
    foreach( $attributeList as $attr )
    {
        $val = & $this->typ["attributes"][$attr];
        $valTxt = "";
        $customPlacement = in_array("customDetailsPlacement",$val);
        if ( in_array("details",$val) )
        {
            if( isset($val["customCss"]) ) $customCss[$attr] = $val["customCss"];
            if( isset($val["sidebar"]) )
            {
                $valTxt = $this->base->showListVal($attr);
                if( !$customPlacement )
                {
                    $sideBarContent["fields"][] = $attr;
                    $sideBarContent[$val["sidebar"]][] = $valTxt;
                }
            }
            if( in_array("section",$val) )
            {
                if( isset($lll[$attr]) )$rows[$attr]=array("separator"=>$lll[$attr]);
            }
            elseif( in_array("widecontent_details",$val) )
            {
                if( !($valTxt=$this->base->showListVal($attr)) ) $valTxt="&nbsp;";
                if( !$customPlacement ) $rows[$attr]=array("widecontent"=>$valTxt);
            }
            elseif( in_array("notable",$val) )
            {
                $valTxt=$this->base->showListVal($attr);
                if( !$customPlacement ) $rows[$attr]=array("notable"=>$valTxt);
            }
            else
            {
                if( !in_array("file",$val) || in_array("media",$val) )
                {
                    $lllProp = new LllProperties( $this->base, $attr );
                    $txt = $lllProp->getLabel();
                    if( ($valTxt=$this->base->showListVal($attr))==="" ) $valTxt="&nbsp;";
                    if( !$customPlacement ) $rows[$attr]=array("label"=>$txt, "value"=>$valTxt);
                }
                else
                {
                      if( !$customPlacement ) $picFieldExists = TRUE;
                      if( in_array("pictureTag",$val) ) 
                      {
                          $valTxt = $this->base->showPicture($attr, "large");
                          if( !$customPlacement ) $mainPicture = $valTxt;
                          $valTxt = $valTxt["tag"];
                      }
                      $pic = $this->base->showPicture($attr, "small");
                      if( !in_array("pictureTag",$val) ) $valTxt = $pic["tag"];
                      if( $pic["tag"] && !$customPlacement )
                      {
                          $pictures[]=$pic;
                      }
                }
            }    
        }
        elseif( !in_array("section",$val) ) $valTxt=$this->base->showListVal($attr);
        if( !in_array("section",$val) )
        {
            if( !stristr($attr, "password") && 
                ($cf = $this->base->getField($attr))!==FALSE && 
                $cf->name ) $tpl->{$cf->name} = $valTxt;
        }
    }
    if( !$picFieldExists ) $pictures=FALSE;
    if( class_exists("rss") )
    {
        JavaScript::addCss(CSS_DIR . "/thickbox.css");
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/thickbox.js");
    }
    if( $picFieldExists && empty($mainPicture["tag"]) )
    {
        if( count($pictures) ) $mainPicture = $pictures[0];
        elseif ($this->base->oodleType) $mainPicture["tag"] = $this->base->showOodlePicture(TRUE); 
        else $mainPicture["tag"] = $this->base->showEmptyPicture();
    }
    $tpl->assign("rows", $rows);
    $tpl->assign("customCss", $customCss);
    $tpl->assign("pictures", $pictures);
    $tpl->assign("sideBarContent", $sideBarContent);
    $tpl->assign("mainPicture", $mainPicture);
}

} // end class
?>
