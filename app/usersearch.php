<?php
defined('_NOAH') or die('Restricted access');

class UserSearch extends Search
{
    
function getManagedTable() { return "user"; }

function createForm()
{
    $this->activateVariableFields();
    Object::createForm(); 
}

function create()
{
    $_S = new AppSettings();
    if( $_S->isEnabled("enableUserSearch") ) parent::create();
}

function makeSearchQuery($fromInstall=FALSE)
{
    if( !($cond = $this->makeSearchQueryAdvanced($fromInstall)) ) $cond = $this->makeSearchQuerySimple();
    $this->query = "SELECT n.* FROM @user AS n WHERE id!=name && isAdm=0 AND active=1";
    if( $cond ) $this->query.=" AND $cond";
}

function makeSearchQuerySimple()
{
    // Ha nem egy adott kategoriara vonatkozik a kereses, akkor az
    // osszes szoba joheto kategoriaban keresunk:
    if( empty($this->str) ) return "";  // ures -> eredmeny az osszes ad
    $word = quoteSQL($this->str);
    return "(".implode(" OR ", $this->getSimpleCustomFieldConditions($word)).")";
}

function activateVariableFields()
{
    global $search_typ;
    
    $table = $this->getManagedTable();
    $obj = new $table;
    $fields = $obj->getFields();
    $search_typ["order"] = array("str", "advancedSearch");
    foreach( $fields as $field )
    {
        $this->activateField($field);
        // user search eseten nem taroljuk db-ben a mezoertekeket:
        $search_typ["attributes"][$field->columnIndex][]="no column";
    }
    $search_typ["order"][]="relationBetweenFields";
    return $fields;
}

function activateField( $v )
{
    $attrInfo = parent::activateField( $v );
    if( $attrInfo ) $attrInfo[] = "no column";
    return $attrInfo;
}
}
?>
