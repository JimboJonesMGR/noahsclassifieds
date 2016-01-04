<?php
defined('_NOAH') or die('Restricted access');

$fieldset_typ =
    array(
        "attributes"=>array(
            "cid"=>array(
                "type"=>"INT",
                "form hidden"
            ),
            "deleteAll"=>array(
                "type"=>"INT",
                "bool"
            ),
            "cloneToSubcats"=>array(
                "type"=>"INT",
                "bool"
            ),
            "cloneToCats"=>array(
                "type"=>"INT",
                "multipleclassselection",
                "asmselect"=>"{sortable: false}",
                "asmselect_label"=>"selectCategory",
                "class"=>"category",
                "labelAttr"=>"wholeName",
                "ordered"=>"wholeName ASC",
                "where"=>"\$this->base->getWhere()", 
                "size"=>10,
            ),
            "cloneFromCat"=>array(
                "type"=>"INT",
                "classselection",
                "nothing selected"=>"selectCategory",
                "class"=>"category",
                "labelAttr"=>"wholeName",
                "ordered"=>"wholeName ASC",
                "where"=>"\$this->base->getWhere()", 
            )
        ),
        "formid"=>"fieldset_form"
    );
    
class FieldSet extends Object 
{
   
function getWhere()
{
    return "id!=$this->cid";
}

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll;

    hasAdminRights($isAdm);
    $hasRight->generalRight = TRUE;
    $hasRight->objectRight = $isAdm;
    if( !$hasRight->objectRight && $giveError ) {
        handleError($lll["permission_denied"]);
    }
}

function createForm()
{
    global $gorumroll, $jQueryLib, $fieldset_typ;
    
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.dimensions.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/field.js");
    JavaScript::addInclude(JS_DIR . "/fieldset_form.js");
    $this->cid = $gorumroll->rollid;
    // A deleteAll es cloneToSubcats mezoket csak akkor tesszuk ki, ha van ertelmuk:
    getDbCount( $subcatNum, array("SELECT COUNT(*) FROM @category WHERE up=#cid#", $this->cid) );
    if( !$subcatNum || !$this->cid ) $fieldset_typ["attributes"]["cloneToSubcats"][]="form invisible";
    getDbCount( $nonFixFieldNum, array("SELECT COUNT(*) FROM @customfield WHERE cid=#cid# AND columnIndex LIKE 'col_%'", $this->cid) );
    if( !$nonFixFieldNum ) $fieldset_typ["attributes"]["deleteAll"][]="form invisible";
    parent::createForm();
}

function create()
{
    if( !$this->cid || !class_exists("response") ) return; // ha veletlenul
    $this->nextAction = new AppController("field/sortfield_form/$this->cid");
    ini_set("max_execution_time", 0);
    if( $this->deleteAll )
    {
        $this->deleteAll();
        $label = "deleteAll";
    }
    elseif( $this->cloneToSubcats )
    {
        $this->cloneToSubcats($this->getFields());
        $label = "cloneToSubcats";
    }
    elseif( $this->cloneToCats )
    {
        $this->cloneToCats($this->getFields());
        $label = "cloneToCats";
    }
    elseif( $this->cloneFromCat )
    {
        // visszavezetjuk az elozore:
        $this->cloneToCats = array($this->cid);
        $this->cloneToCats($this->getFields('cloneFromCat'));
        $label = "cloneFromCat";
    }
    else return;
    Roll::setInfoText("fieldset_{$label}_successful");
}

function getFields( $attrAsCid='cid', $what='*' )
{
    G::load( $fields, array("SELECT $what FROM @itemfield WHERE cid=#cid#", $this->$attrAsCid) );
    return $fields;
}

function deleteAll( $includingFixFields=FALSE )
{
    $fields = $this->getFields("cid", "id, columnIndex, isCommon");
    foreach( $fields as $field ) 
    {
        if( $includingFixFields || (!$field->isFixField() && !$field->isCommon)) 
        {
            $field->delete(FALSE); // without the related common fields of other categories
        }
    }
}

function cloneToSubcats( &$fields )
{
    G::load( $children, array("SELECT id FROM @category WHERE up=#cid#", $this->cid) );
    foreach( $children as $child ) 
    {
        $this->cid = $child->id;
        $this->deleteAll(TRUE);
        foreach( $fields as $field ) $field->cloneToCategory($this->cid);
        $this->cloneToSubcats($fields);
    }       
}

function cloneToCats( &$fields )
{
    foreach( $this->cloneToCats as $cid ) 
    {
        $this->cid = $cid;
        $this->deleteAll(TRUE);
        foreach( $fields as $field ) $field->cloneToCategory($this->cid);
    }       
}

}// end class CustomField

?>
