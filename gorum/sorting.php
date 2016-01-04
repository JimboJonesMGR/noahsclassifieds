<?php
defined('_NOAH') or die('Restricted access');
$sorting_typ =  
    array(
        "attributes"=>array(   
            "id"=>array(
            ),            
            "dir"=>array(
            ),            
            "attr"=>array(
            )
        )
    );    

class Sorting extends Object
{

var $id="";    
var $dir=0;    
var $attr="";
var $sql="";

function Sorting( $base=0, $attr=0 )
{
    global $gorumroll;
    
    if( $base===0 || $base===FALSE) return;
    $this->id = "$gorumroll->list-$gorumroll->method";
    if( $gorumroll->rollid ) $this->id.="-$gorumroll->rollid";
    $this->initFromSession($base);
    if( !$this->isDefined() ) $this->initFromTypeInfo( $base, $attr );
}

function initFromSession($base)
{
    if( isset($_SESSION["sorting"][$this->id]) )
    {
        $this->dir  = $_SESSION["sorting"][$this->id]["dir"];
        $this->attr = $_SESSION["sorting"][$this->id]["attr"];
        // ha perzisztens rendezes van:
        $typ =& $base->getTypeInfo();
        if( isset($typ["sort_criteria_sql_pers"]) ) 
        {
            $this->sql = $typ["sort_criteria_sql_pers"];
            $this->sql.=", $this->attr " . ($this->dir=="d" ? "DESC" : "ASC");
        }
    }
}

function initFromTypeInfo( $base, $attr )
{
    $typ =& $base->getTypeInfo(TRUE);
    if( $attr )
    {
        $val=$typ["attributes"][$attr];
        if( !in_array("sorta",$val) && !in_array("sortd",$val)) return;
    }
    if( isset($typ["sort_criteria_dir"]) ) $this->dir  = $typ["sort_criteria_dir"];
    if( isset($typ["sort_criteria_attr"])) $this->attr = $typ["sort_criteria_attr"];
    if( isset($typ["sort_criteria_sql"])) $this->sql = $typ["sort_criteria_sql"];
}

function isDefined()
{
    return ($this->dir!==0 || $this->sql!=="");
}

function getAttr()
{
    return $this->attr;
}

function getAttrs()
{
    if( $this->sql )
    {
        $attrs = array();
        $pieces = split("[ ,]+", $this->sql);
        foreach( $pieces as $p ) if( $p!="DESC" && $p!="ASC" ) $attrs[]=$p;
        return $attrs;
    }
    elseif( $this->attr ) return array($this->attr);
    return array();
}

function showSortTool(&$base, $attr)
{
    global $gorumroll, $lll;
    $typ =& $base->getTypeInfo(TRUE);
    $sorting = new Sorting($base, $attr);
    if( !$sorting->isDefined() ) return "";
    $val=$typ["attributes"][$attr];
    // ha az attr egyaltalan nem sortolhato:
    if( $sorting->attr!=$attr && !in_array("sorta",$val) && !in_array("sortd",$val)) return;
    $s=" ";  
    if( $sorting->attr!=$attr || $sorting->dir=="d") 
    {
        $ctrl = new AppController("sorting", "modify", $sorting->id, array("dir","a","attr",$attr));
        $s.=$ctrl->generImageAnchor( IMAGES_DIR . "/asc.gif",$lll["icon_asc"] );
            // a felirat azt mutatja, hogy eppen milyen rendezes van, a nyil 
            // viszont azt mutatja, hogy milyen lesz, ha rakattintunk (phpMyAdm)
    }
    if( $sorting->attr!=$attr || $sorting->dir=="a")
    {
        $ctrl = new AppController("sorting", "modify", $sorting->id, array("dir","d","attr",$attr));
        $s.=$ctrl->generImageAnchor( IMAGES_DIR . "/desc.gif",$lll["icon_desc"] );
            // a felirat azt mutatja, hogy eppen milyen rendezes van, a nyil 
            // viszont azt mutatja, hogy milyen lesz, ha rakattintunk (phpMyAdm)
    }
    return $s;
}

function modify()
{
    global $gorumroll;
    
    $this->id = $gorumroll->rollid;  // pl.: item_active-list-12
    // Saving in the session:
    $_SESSION["sorting"][$this->id]["dir"] = $this->dir;
    $_SESSION["sorting"][$this->id]["attr"] = $this->attr;
    $this->rollBackNum = 1;
}

function getSortSql()
{
    if( $this->sql ) return $this->sql;
    return "$this->attr " . ($this->dir=="d" ? "DESC" : "ASC");
}

}

?>
