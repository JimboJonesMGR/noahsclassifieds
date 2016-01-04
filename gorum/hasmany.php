<?php
defined('_NOAH') or die('Restricted access');
class HasManyAttrs
{
    var $hasManyAttrs;
    
    function HasManyAttrs() {
        $args = func_get_args();
        call_user_func_array(array(&$this, "__construct"), $args);
    }
    function __construct($base)
    {
        $object_vars = get_object_vars($base);
        $typ =& $base->getTypeInfo();
        $this->hasManyAttrs=array();
        foreach( $object_vars as $attribute=>$value )
        {
            if( @in_array("has_many", $typ["attributes"][$attribute]) ) 
            {
                $this->hasManyAttrs[] = HasMany::construct($base, $attribute, $typ["attributes"][$attribute]);
            }
        }
        //var_dump($this->hasManyAttrs);
    }    
    function create(){ $this->iterate("create"); }
    function modify(){ $this->iterate("modify"); }
    function delete(){ $this->iterate("delete"); }
    
    function iterate($fg)
    {
        foreach( $this->hasManyAttrs as $attr ) $attr->$fg();
    }
}

/*abstract*/ class HasMany
{
    var $thisTable;
    var $otherTable;
    var $thisAttr;
    var $labelAttr;
    var $thisObj;
    
    function HasMany() {
        $args = func_get_args();
        call_user_func_array(array(&$this, "__construct"), $args);
    }
    function __construct($base, $attribute, $attrInfo)
    {
        $this->thisTable = $base->get_table();
        $otherObj = new $attrInfo["class"];
        $this->otherTable=$otherObj->get_table();
        $this->thisAttr = $attribute;
        $this->labelAttr = $attrInfo["labelAttr"];
        $this->thisObj = $base;
    }

    /*public static*/ function construct($base, $attribute, $attrInfo)
    {
        if( in_array("has_many", $attrInfo) ) 
        {
            if( in_array("no column", $attrInfo) ) return new HasManyWithLinkClass($base, $attribute, $attrInfo); 
            else return new HasManyWithoutLinkClass($base, $attribute, $attrInfo);
        }
        else return FALSE;
    }
    
    /*abstract*/ function create(){}
    /*abstract*/ function modify(){}
    /*abstract*/ function delete(){}
}

class HasManyWithoutLinkClass extends HasMany
{
    var $otherAttr;
    var $oldValues;
    
    function HasManyWithoutLinkClass() {
        $args = func_get_args();
        call_user_func_array(array(&$this, "__construct"), $args);
    }
    function __construct($base, $attribute, $attrInfo)
    {
        parent::__construct($base, $attribute, $attrInfo);
        $this->otherAttr = $attrInfo["otherAttr"];
        $this->oldValues = !empty($base->id) ? G::getAttr( $base->id, $base->get_class(), $attribute) : 0;
    }
    
    function create()
    {
        $this->insertIntoOtherAttr($this->thisObj->{$this->thisAttr});
    }
    
    function modify()
    {
        // osszevetjuk a jogok regi beallitasat az ujakkal:
        $oldValues = $this->oldValues ? explode(",", $this->oldValues) : array();
        $newValues = $this->thisObj->{$this->thisAttr};
        if( !is_array($newValues) ) $newValues = explode(",", $newValues);
        // a juzerek listaja, akiknek a jogosultsagat toroltuk:
        $toDelete=array();
        foreach( $oldValues as $r ) if( !in_array($r, $newValues) ) $toDelete[]=$r;
        // a juzerek listaja, akiknek most adtunk jogot:
        $toInsert = array();
        foreach( $newValues as $r ) if( !in_array($r, $oldValues) ) $toInsert[]=$r;
        
        $this->deleteFromOtherAttr($toDelete);  
        $this->insertIntoOtherAttr($toInsert);
    }

    function delete()
    {
        $this->deleteFromOtherAttr($this->thisObj->{$this->thisAttr});
    }
    
    function getSelectFieldQuery()
    {
        return "SELECT id, $this->labelAttr FROM @$this->otherTable";
    }
    
    /* private */ function insertIntoOtherAttr($values)
    {
        if( is_array($values) ) $values = implode(",", $values);
        // ha a kategoria $gr-jeben beallitunk egy juzert, akkor a juzer $gr-jeben is beallitjuk ezt a kategoriat:
        executeQuery("UPDATE @$this->otherTable SET $this->otherAttr=CONCAT($this->otherAttr, ',', '{$this->thisObj->id}') WHERE FIND_IN_SET(id, '$values')!=0 AND $this->otherAttr!=''");
        // ha a juzer $gr-je ures, akkor nem hozzakonkatenalni kell, hanem a $gr egyszeruen egyenlo lesz ezzel a kategoriaval:
        executeQuery("UPDATE @$this->otherTable SET $this->otherAttr='{$this->thisObj->id}' WHERE FIND_IN_SET(id, '$values')!=0 AND $this->otherAttr=''");
    }
    
    /* private */ function deleteFromOtherAttr($values)
    {
        if( is_array($values) ) $values = implode(",", $values);
        $query="SELECT id, $this->otherAttr FROM @$this->otherTable WHERE FIND_IN_SET(id, '$values')!=0";
        G::load($otherObjects, $query);
        foreach( $otherObjects as $s )
        {
            $f = preg_replace("{(,)?\\b".$this->thisObj->id."\\b(?(1)|(,|$))}", "", $s->{$this->otherAttr}); 
            executeQuery("UPDATE @$this->otherTable SET $this->otherAttr='$f' WHERE id=$s->id");
        }
    }

}

class HasManyWithLinkClass extends HasMany
{
    var $linkTable;
    
    function HasManyWithLinkClass() {
        $args = func_get_args();
        call_user_func_array(array(&$this, "__construct"), $args);
    }
    function __construct($base, $attribute, $attrInfo)
    {
        parent::__construct($base, $attribute, $attrInfo);
        $classNames = array($this->thisTable, $this->otherTable);
        sort($classNames);
        $this->linkTable = implode("_", $classNames);   // pl. event_user
    }
    
    function create()
    {
        $this->delete();
        foreach( $this->thisObj->{$this->thisAttr} as $val )
        {
            executeQuery("INSERT INTO @$this->linkTable SET {$this->thisTable}_id={$this->thisObj->id}, {$this->otherTable}_id=$val");
        }
    }
    
    function modify()
    {
        $this->create();
    }
    
    function delete()
    {
        executeQuery("DELETE FROM @$this->linkTable WHERE {$this->thisTable}_id={$this->thisObj->id}");
    }
    
    function getSelectFieldQuery()
    {
        $id = isset($this->thisObj->id) ? $this->thisObj->id : 0;
        global ${"{$this->otherTable}_typ"};
        ${"{$this->otherTable}_typ"}["attributes"]["selected"]=array();  // hogy erteket kapjon
        return "SELECT c.id, $this->labelAttr, !ISNULL(l.id) AS selected ".
               "FROM @$this->otherTable AS c LEFT JOIN @$this->linkTable AS l ".
               "ON c.id=l.{$this->otherTable}_id AND l.{$this->thisTable}_id=$id";
    }
}

?>
