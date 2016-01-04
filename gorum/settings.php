<?php
defined('_NOAH') or die('Restricted access');
class Settings extends Object
{

function Settings($withInit = TRUE)
{
    global $dbPrefix;
    static $singleton=array();

    // Pl. A Settings form elotti initClassVars elott 
    // inicializalas nelkul kell letrehozni egy init objektumot:
    if( !$withInit ) return;
    // get classname
    $class = get_class($this);

    if( !array_key_exists($class, $singleton) )
    {
        if( !mysql_num_rows(executeQuery("SHOW TABLES LIKE '$dbPrefix".$this->get_table()."'")) ) return;  // ha nem letezik meg a settings table (install) 
        $this->id=1;
        if( load($this) ) return; // ha a table mar letezik, de nincs nne semmi
        $singleton[$class] = $this;
    }
    // PHP doesn't allow us to assign a reference to $this, so we do this
    // little trick and fill our new object with references to the original
    // class' variables:
    $typ = & $this->getTypeInfo();
    foreach( $typ["attributes"] as $attr=>$value )
    {
        if( isset($singleton[$class]->$attr) ) $this->$attr =& $singleton[$class]->$attr;
    }
}

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll;
    
    hasAdminRights($isAdm);
    $hasRight->objectRight = (($method=="modify" || $method=="load") && $isAdm);
    if( !$hasRight->objectRight && $giveError )
    {
        handleError($lll["permission_denied"]);
    }
}

function getPageTitle()
{
    return "";
}

function getPageDescription()
{
    return "";
}

function getPageKeywords()
{
    return "";
}

function getTitlePrefix()
{
	return "";
}

}    

?>
