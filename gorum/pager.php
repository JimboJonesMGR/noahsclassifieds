<?php
defined('_NOAH') or die('Restricted access');

class Pager
{

var $base;    
var $off=0; // offset
var $ro=0;  // range offset
var $count=0;
var $blockSize=0;
var $rangeBlockSize=0;

function Pager($base)
{
    global $gorumroll, $rangeBlockSize;
    
    $_S = new AppSettings();
    $this->base = $base;
    $base->getCount($this->count); 
    $typ =& $base->getTypeInfo();
    // ha a customlistben limitet allitottak be es az kisebb, mint ahany rekord valojaban van:
    if( isset($typ["limit"]) && $typ["limit"]<$this->count ) $this->count = $typ["limit"];
    $classVars = $gorumroll->getClassVars();
    // a query stringben levo parameterekbol inicializalunk: pl.: item/list/1/off/5
    if( !empty($classVars["off"]) ) $this->off = $classVars["off"];
    $this->blockSize=min($_S->blockSize, $this->count);
    $this->rangeBlockSize=$rangeBlockSize;
}

function retrieveRangeOffset()
{
    if( $this->off<(floor($this->rangeBlockSize/2)+1)*$this->blockSize ) $this->ro=0;
    else $this->ro=floor($this->off/$this->blockSize)-floor($this->rangeBlockSize/2);
    if( $this->ro+$this->rangeBlockSize>ceil($this->count/$this->blockSize) ) $this->ro=ceil($this->count/$this->blockSize)-$this->rangeBlockSize;
    if( $this->ro<0 ) $this->ro=0;
}

function showPagerTool()
{
    global $lll, $showFirstLast, $showPrevNextText, $showPrevNextIcon;

    if( $this->count<=$this->blockSize || $this->blockSize==0 || $this->rangeBlockSize==0 ) return "";
    $this->retrieveRangeOffset();

    $pager = array();
    $pager[] = "(".ceil($this->count/$this->blockSize)." $lll[pages])";
    if( $this->off!=0 )
    {
        if( $showFirstLast )
        {
            $ctrl = new AppController(array());  // ez lemasolja a list,method,rollid-t, de a classVars-t lenullazza
            $pager[]=$ctrl->generImageAnchor(IMAGES_DIR . "/first.gif", $lll["first"]);
        }
        $newOffset = max($this->off-$this->blockSize, 0);
        if( $showPrevNextText )
        {
            $ctrl = new AppController(array("off"=>$newOffset));
            $pager[]=$ctrl->generAnchor($lll["prev"]);
        }
        if( $showPrevNextIcon )
        {
            $ctrl = new AppController(array("off"=>$newOffset));
            $pager[]=$ctrl->generImageAnchor(IMAGES_DIR . "/prev.gif", $lll["prev"]);
        }
    }
    $upperRange=$this->count;
    for( $i=$this->ro; $i<$this->ro+$this->rangeBlockSize; $i++ )
    {
        $newOffset = $i * $this->blockSize;
        if( $newOffset>=$this->count ) break;
        if( $this->off/$this->blockSize==$i ) 
        {
            $pager[]=$i+1;
        }
        else {
            $ctrl = new AppController(array("off"=>$newOffset));
            $pager[]=$ctrl->generAnchor($i+1);
        }
        $upperRange = min($newOffset+$this->blockSize, $this->count);
    }
    if( $this->off + $this->blockSize < $this->count )
    {
        $newOffset = $this->off+$this->blockSize;
        if( $showPrevNextIcon )
        {
            $ctrl = new AppController(array("off"=>$newOffset));
            $pager[]=$ctrl->generImageAnchor(IMAGES_DIR . "/next.gif", $lll["next"]);
        }
        if( $showPrevNextText )
        {
            $ctrl = new AppController(array("off"=>$newOffset));
            $pager[]=$ctrl->generAnchor($lll["next"]);
        }
        if( $showFirstLast )
        {
            if( $this->count % $this->blockSize ) $newOffset = $this->count - ($this->count % $this->blockSize);
            else $newOffset = $this->count - $this->blockSize;
            $ctrl = new AppController(array("off"=>$newOffset));
            $pager[]=$ctrl->generImageAnchor(IMAGES_DIR . "/last.gif", $lll["last"]);
        }
    }
    return $pager;
}

// TODO:
function showRangeSelector( $base )
{
    global $gorumroll, $lll, $imagesDir;
    global $blockSize, $rangeBlockSize;
    global $yahooStylePagerTool;

    if( function_exists("appShowRangeSelector") ) {
        return appShowRangeSelector($base);
    }
    if( $yahooStylePagerTool )
    {
        return showYahooStyleRangeSelector($base);
    }
    
    $typ =& $base->getTypeInfo();
    $bs=$blockSize;
    $rbs=$rangeBlockSize;
    $ro=isset($_COOKIE["kuki_rangeoffset_$gorumroll->list"]) ? 
        $_COOKIE["kuki_rangeoffset_$gorumroll->list"] : 
        (isset($_COOKIE["kuki_rangeoffset"]) ? $_COOKIE["kuki_rangeoffset"] : 0);
    $off=isset($_COOKIE["kuki_offset_$gorumroll->list"]) ? 
        $_COOKIE["kuki_offset_$gorumroll->list"] : 
        (isset($_COOKIE["kuki_offset"]) ? $_COOKIE["kuki_offset"] : 0);
    $base->getCount($count);
    if( $count<=$bs || $bs==0 || $rbs==0 )
    {
        return "";
    }
    $ctrlParams = array();
    $ctrlParams["method"] = "range";
    $s="";
    $s.="<div class='pager'>";
    if( $off!=0 )
    {
        $ctrlParams["rangeoffset"] = $ro;
        $ctrlParams["offset"] = 0;
        $s.="<span>";
        $ctrl = new AppController($ctrlParams);
        $s.=$ctrl->generImageAnchor(IMAGES_DIR . "/first.gif", $lll["first"]);
        $s.="</span>\n";
        $newOffset = max($off-$bs, 0);
        $ctrl["offset"] = $newOffset;
        $s.="<span>";
        $ctrl = new AppController($ctrlParams);
        $s.=$ctrl->generImageAnchor(IMAGES_DIR . "/prev.gif", $lll["prev"]);
        $s.="</span>\n";
    }
    if( $ro!=0 )
    {
        $newOffset = max($ro-$rbs, 0);
        $ctrlParams["rangeoffset"] = $newOffset;
        $ctrlParams["offset"] = $off; //*
        $s.="<span>";
        $ctrl = new AppController($ctrlParams);
        $s.=$ctrl->generAnchor("...");
        $s.="</span>\n";
    }
    $upperRange=$count;
    for( $i=$ro; $i<$ro+$rbs; $i++ )
    {
        $newOffset = $i * $bs;
        if( $newOffset>=$count ) break;
        $ctrlParams["offset"] = $newOffset;
        $ctrlParams["rangeoffset"] = $ro;
        if( $off/$bs==$i ) {
            $s.="<span>";
            $s.=($i+1);
            $s.="</span>\n";
        }
        else {
            $s.="<span>";
            $ctrl = new AppController($ctrlParams);
            $s.=$ctrl->generAnchor($i+1);
            $s.="</span>\n";
        }
        $upperRange = min($newOffset+$bs, $count);
    }
    if( $count > $upperRange )
    {
        if(($ro+$rbs-1)*$bs>$count) $newOffset=($count/$bs)+1-$rbs;
        else $newOffset = $ro + $rbs;
        $ctrlParams["rangeoffset"] = $newOffset;
        $ctrlParams["offset"] = $off; //*
        $s.="<span>";
        $ctrl = new AppController($ctrlParams);
        $s.=$ctrl->generAnchor("...");
        $s.="</span>\n";
    }
    if( $off + $bs < $count )
    {
        $newOffset = $off+$bs;
        $ctrlParams["offset"] = $newOffset;
        $ctrlParams["rangeoffset"] = $ro;
        $s.="<span>";
        $ctrl = new AppController($ctrlParams);
        $s.=$ctrl->generImageAnchor(IMAGES_DIR . "/next.gif", $lll["next"]);
        $s.="</span>\n";
        if( $count % $bs ) $newOffset = $count - ($count % $bs);
        else $newOffset = $count - $bs;
        $ctrlParams["offset"] = $newOffset;
        $ctrlParams["rangeoffset"] = $ro;
        $s.="<span>";
        $ctrl = new AppController($ctrlParams);
        $s.=$ctrl->generImageAnchor(IMAGES_DIR . "/last.gif", $lll["last"]);
        $s.="</span>\n";
    }
    $s.="</div>\n";
    return $s;
}

function getLimit()
{
    return  "LIMIT $this->off, $this->blockSize";
}

}

?>
