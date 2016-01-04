<?php
defined('_NOAH') or die('Restricted access');

global $purchaseitem_typ;
$purchaseitem_typ =  
    array(
        "attributes"=>array(   
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "iid"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$_EC->isAdvancedModelEnabled()"=>"list"),
            ),
            "uid"=>array(
                "type"=>"INT",
            ),
            "userName"=>array(
                "type"=>"INT",
                "conditions"=>array("\$isAdm && !\$_EC->isAdvancedModelEnabled()"=>"list"),
                "link_to"=>array("class"=>"user", "id"=>"uid", "other_attr"=>"name"),
                "no column"
            ),
            "description"=>array(
                "type"=>"TEXT",
                "textarea",
                "rows"=>5,
                "cols"=>50,
                "list",
                "safetext_br"
            ),
            "type"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "values"=>array(ecomm_credit, ecomm_subscription),
                "default"=>"1", //ecomm_credit
                "show_relation"=>array(ecomm_subscription=>"subscription"),
                "conditions"=>array("\$isAdm && \$_EC->isAdvancedModelEnabled()"=>"list"),
                "enum"
            ),
            "amount"=>array(
                "type"=>"INT",
                "default"=>1,
                "text",
            ),
            "unit"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "values"=>array(ecomm_days, ecomm_weeks, ecomm_months, ecomm_years),
                "default"=>"0", //ecomm_days
                "relation"=>"subscription",
                "enum"
            ),
            "price"=>array(
                "type"=>"FLOAT",
                "text",
                "list"
            ),
            "sortId"=>array(
                "type"=>"INT",
                "conditions"=>array("\$isAdm && \$_EC->isAdvancedModelEnabled()"=>"list"),
            ),
            "creationtime"=>array(
                "type"=>"DATETIME",
                "prototype"=>"date",
                "conditions"=>array("\$isAdm && !\$_EC->isAdvancedModelEnabled()"=>"list"),
                "sorta",
                "default_format",
            ),
            "fields"=>array(  // a sort form outputjanak tarolasara
                "type"=>"INT",
                "no column",
            ),
            "purchase"=>array(
                "type"=>"INT",
                "no column",
                "conditions"=>array("!\$isAdm"=>"list"),
            ),
        ),    
        "primary_key"=>"id",
        "delete_confirm"=>"description",
        "conditions"=>array("\$isAdm && \$_EC->isAdvancedModelEnabled()"=>"wrap_form",
                            "!\$_EC->isAdvancedModelEnabled()"=>array("sort_criteria_sql"=>"creationtime DESC"),
                            "\$_EC->isAdvancedModelEnabled()"=>array("sort_criteria_sql"=>"sortId ASC")),
        "smartform",
        "sortfield_form: submit"=>array("customfield_savesorting"),
        "no_pager",
    );        
    

class PurchaseItem extends Object
{

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll, $gorumroll, $gorumuser;

    hasAdminRights($isAdm);
    $hasRight->generalRight = TRUE;
    if( ECommFull::isAdvancedModelEnabled() )
    {
        $hasRight->objectRight = $isAdm || $method=="load";
    }
    else
    {
        $hasRight->objectRight = ($isAdm && $method!="create" && $method!="modify") || $method=="load" || 
                                 (!ECommFull::isAdvancedModelEnabled() && $method=="delete");
    }
    if( !$hasRight->objectRight && $giveError ) {
        handleError($lll["permission_denied"]);
    }
}

function initialize()
{
    $pi = new PurchaseItem;
    $pi->description = "One credit";
    $pi->amount=1;
    $pi->price=1;
    $pi->type=ecomm_credit;
    $pi->create(TRUE);
    
    $pi = new PurchaseItem;
    $pi->description = "Five credits";
    $pi->amount=5;
    $pi->price=4;
    $pi->type=ecomm_credit;
    $pi->create(TRUE);
    
    $pi = new PurchaseItem;
    $pi->description = "Ten credits";
    $pi->amount=10;
    $pi->price=7;
    $pi->type=ecomm_credit;
    $pi->create(TRUE);
    
    $pi = new PurchaseItem;
    $pi->description = "Twenty credits";
    $pi->amount=20;
    $pi->price=12;
    $pi->type=ecomm_credit;
    $pi->create(TRUE);
}

function sortFieldForm($elementName="")
{
    global $jQueryLib;
    
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/form.js");
    JavaScript::addInclude(JS_DIR . "/sort_custom_fields.js");
    $this->showHtmlList($elementName);
}   

function getAdditionalHiddens(&$fieldList)
{
    global $gorumroll;
    
    if( $gorumroll->method!="sortfield_form" ) return "";
    $s = "";
    foreach( $fieldList as $field )
    {
        $s.="<input type='hidden' id='i$field->id' name=\"fields[$field->id]\" value='$field->sortId'>\n";
    }
    return $s;
}

function sortField()
{
    global $gorumroll;
    
    asort( $this->fields, SORT_NUMERIC );  // rendezes a tombindexek megtartasaval
    $sortId = 900;
    foreach( $this->fields as $id=>$sId )
    {
        executeQuery("UPDATE @purchaseitem SET sortId=#index# WHERE id=#id#", $sortId+=100, $id);
    }
    Roll::setInfoText("purchaseitem_sortingsaved");
    $this->nextAction = new AppController("$gorumroll->list/sortfield_form/$gorumroll->rollid");
}   

function showMoveTool($fieldId)
{
    return "
    <img src='".IMAGES_DIR . "/arrow_bottom.gif' onclick=\"move(this, '$fieldId', 'bottom');\"> 
    <img src='".IMAGES_DIR . "/arrow_down.gif' onclick=\"move(this, '$fieldId', 'down');\"> 
    <img src='".IMAGES_DIR . "/arrow_up.gif' onclick=\"move(this, '$fieldId', 'up');\">  
    <img src='".IMAGES_DIR . "/arrow_top.gif' onclick=\"move(this, '$fieldId', 'top');\">";    
}   

function create($fromInstall=FALSE)
{
    global $gorumroll, $gorumuser, $gorumrecognised;
    
    $this->sortId = PurchaseItem::getNextSortId();
    parent::create();
    if( !Roll::isFormInvalid() && !$fromInstall)
    {
        $this->nextAction = new AppController("$gorumroll->list/sortfield_form");
    }
}

// visszaadja a kovetkezo felhasznalhato sortId-t egy kategoriaban, 
// vagy globalisan, ha nullaval hivjak meg:
function getNextSortId()
{
    $query = "SELECT MAX(sortId) as sortId FROM @purchaseitem";
    loadSQL( $fieldStat = new PurchaseItem, $query );
    return isset($fieldStat->sortId) ? $fieldStat->sortId+100 : 1000;
}

function showListVal($attr)
{
    global $gorumroll, $lll;
    global $gorumuser, $gorumrecognised;

    $s=FALSE;
    if( ($s=parent::showListVal($attr))!==FALSE )
    {
        return $s;
    }
    elseif ($attr=="price") 
    {
        $_ES = new ECommSettings();
        $s = $_ES->formatPrice($this->$attr);
    }
    elseif ($attr=="iid") 
    {
        $item = new Item;
        $item->id = $this->iid;
        CustomField::addCustomColumns("item");
        load($item);
        $s = $item->showListVal("title");
    }
    elseif(  $attr=="sortId" )
    {
        $s="<span style='display:none;'>$this->sortId</span>";
        $s.=PurchaseItem::showMoveTool($this->id);
    }
    return $s;
}

function showAppPurchase()
{
    $_ES = new ECommSettings();
    $buttons = array();
    foreach( $_ES->getEnabledPaymentGateways() as $gateway )
    {
        $buttons[] = $gateway->getPurchaseButton($this);
    }
    if( count($buttons)>1 ) return $this->showMoreButtons($buttons);
    elseif( count($buttons)==0 ) return "";
    else return $buttons[0];
}

function showMoreButtons($buttons)
{
    return "
    <table style='width: 1%;'>
      <tr>".
        implode("", array_map(create_function('$v', 'return "<td style=\"padding-right: 20px;\">$v</td>";'), $buttons)).
      "</tr>
    </table>";  
}

function showHtmlList($elementName="")
{
    global $purchaseitem_typ, $jQueryLib, $noFileUpload, $gorumrecognised;
    
    if( !$gorumrecognised ) LocationHistory::rollBack(new AppController("/"));

    $_ES = new ECommSettings();
    hasAdminRights($isAdm);
    $purchaseitem_typ[]="wrap_form";
    if( !$isAdm ) 
    {
        $noFileUpload = TRUE;
        $purchaseitem_typ[]="nosubmit";  // a purchase list-be nem kell submit button
        $purchaseitem_typ["formid"]="purchaseForm";  // hogy egyedi ID-je legyen
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        JavaScript::addInclude(JS_DIR . "/purchase.js");
    }
    parent::showHtmlList();
}

function showDetailsTool()
{
    return "";
}

function getListSelect()
{
    global $gorumuser;

    if( ECommFull::isAdvancedModelEnabled() )
    {
        return "SELECT * FROM @purchaseitem WHERE type!=".ecomm_pending;
    }
    hasAdminRights($isAdm);
    if( $isAdm )
    {
        return "SELECT p.*, u.name AS userName FROM @purchaseitem AS p, @user AS u WHERE u.id=p.uid AND p.type=".ecomm_pending;
    }
    else 
    {
        $query = "SELECT * FROM @purchaseitem WHERE uid=#uid# AND type=".ecomm_pending;
        return array($query, $gorumuser->id);
    }
}

function deleteForm()
{
    global $lll, $gorumroll;
    
    $this->id = $gorumroll->rollid;
    load($this);
    if( $this->type==ecomm_pending )
    {
        $lll["beforeDelete"].=$lll["deleteCorrespondingItemToo"];        
    }
    parent::deleteForm();
}

function delete()
{
    global $gorumroll, $gorumuser;

    hasAdminRights($isAdm);
    load($this);
    if( !$isAdm && $gorumuser->id!=$this->uid ) handleErrorPerm( __FILE__, __LINE__ );
    if( $this->iid )
    {
        $item = new Item;
        $item->id = $this->iid;
        $item->delete();
    }
    delete($this);
}

function save($item)
{
    if( loadSQL($old = new PurchaseItem, "SELECT * FROM @purchaseitem WHERE iid='$item->id' LIMIT 1") )
    {
        $this->iid = $item->id;
        create($this);
    }
    else
    {
        $old->description.="\n$this->description";
        $old->price+=$this->price;
        $old->creationtime = time();
        modify($old);
    }
}
    
function cleanUp($item)
{
    executeQuery("DELETE FROM @purchaseitem WHERE iid=#id#", $item->id);
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
    
    $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    $navBarPieces[$lll["purchaseItem"]] = $gorumroll->method=="sortfield_form" ? "" : new AppController("purchaseitem/sortfield_form");
    return $navBarPieces;
}
}
?>
