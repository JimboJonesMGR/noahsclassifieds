<?php

global $clonecat_typ;
$clonecat_typ =
    array(
        "attributes"=>array(
            "cid"=>array(
                "type"=>"INT",
                "form hidden",
            ),
            "amount"=>array(
                "type"=>"INT",
                "text",
                "default"=>1,
            ),
            "name"=>array(
                "type"=>"VARCHAR",
                "max" =>"250",
                "text",
            ),
            "recursive"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
            ),
            "withPictures"=>array(  
                "type"=>"INT",
                "bool",
                "default"=>"0",
            ),
        ),
        "primary_key"=>"id",
        "sort_criteria_attr"=>"id",
        "sort_criteria_dir"=>"d"
    );

class CloneCat extends Object
{
    
function createForm()
{
    global $gorumroll, $lll;

    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));    
    
    // Called via Ajax from the category organizer:
    $this->cid = $gorumroll->rollid;
    G::load( $category, $this->cid, "appcategory" );
    $this->name = sprintf($lll["copyOfCategory"], $category->name);
    parent::createForm();
    //parent::createForm("cloneForm");
    //$tpl =& View::getView("cloneForm");
    //echo $tpl->__toString();
    //die();
}

function create()
{
    global $siteDemo;
    
    ini_set("max_execution_time", 0);
    hasAdminRights( $isAdm );
    if( $siteDemo ) Roll::setInfoText("Cloning is disabled in the site demo!");
    if( !$isAdm || $siteDemo ) return;

    G::load( $category, $this->cid, "appcategory" );
    if( empty($this->amount) ) $this->amount=0;
    $sortId = $category->sortId;
    for( $i=1; $i<=$this->amount; $i++ )
    {
        $category->name = sprintf($this->name, $i);
        $this->cloneCategory( $category, $sortId+$i );
    }
    Roll::setInfoText("categoriesCloned");
    //LocationHistory::rollBack(new AppController("cat/organize_form"));
}

function cloneCategory( $category, $sortId=0 )
{
    $id = $category->id;
    unset($category->id);
    unset($category->creationtime);
    unset($category->wholeName);
    unset($category->permaLink);
    $category->sortId = $sortId;
    $category->subCatNum = $category->directSubCatNum = $category->itemNum = $category->directItemNum = 0;
    if( !$this->withPictures ) $category->picture = "";
    $category->create(FALSE, TRUE);  // fromClone=TRUE
    if( $this->withPictures && $category->picture ) 
    {
        copy( CAT_PIC_DIR . "/$id.$category->picture", CAT_PIC_DIR . "/$category->id.$category->picture" );
    }
    
    // Cloning the custom fields:
    G::load($fields, array("SELECT * FROM @customfield WHERE cid=#cid#", $id));
    foreach( $fields as $field )
    {
        unset($field->id);
        $field->cid = $category->id;
        create($field);
    }
    if( $this->recursive ) 
    {
        G::load( $subCats, array("SELECT * FROM @category WHERE up=#id#", $id) );
        foreach( $subCats as $sc )
        {
            $sc->up = $category->id;
            $this->cloneCategory($sc, $sc->sortId);
        }
    }
}

}

?>
