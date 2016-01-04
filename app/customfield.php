<?php
defined('_NOAH') or die('Restricted access');
include("oodle.php");

$customfield_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "cid"=>array(
                "type"=>"INT",
                "form hidden"
            ),
            "name"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("\$this->isFixField()===TRUE && @\$this->name"=>array("readonly", "nohidden"),
                                    "!\$this->isFixField()"=>"text"),
                "max" =>"120",
                "list",
                "details",
                "safetext",
            ),
            "userField"=>array(
                "type"=>"INT",
                "nothing selected"=>"selectUserField",
                "class"=>"customfield",
                "where"=>"cid=0 AND isCommon=0 AND columnIndex NOT LIKE '%password%' AND columnIndex!='creationtime' AND columnIndex!='lastClickTime' AND type!=".customfield_separator."  AND type!=".customfield_picture,
                "labelAttr"=>"name",
                "order"=>"sortId ASC",
                "conditions"=>array("\$gorumroll->method=='modify_form' && @\$this->userField"=>array("modify_form: readonly"),
                                    "\$gorumroll->method=='create_form'"=>"classselection"),
            ),
            "isCommon"=>array(
                "type"=>"INT",
                "values"=>array(0,1),
                "default"=>"0",
                "cols"=>"1",
                "conditions"=>array("!\$this->isFixField() && @\$this->cid"=>"radio",
                                    "@!\$this->cid"=>"modify_form: readonly"),
            ),
            /*
            "addToSubcats"=>array(
                "type"=>"INT",
                "default"=>"0",
                "no column",
                "conditions"=>array("!\$this->isFixField() && @\$this->cid"=>"create_form: bool"),
            ),
            */
/**************************************************************************
Form properties
**************************************************************************/
            "formProperties"=>array(
                "type"=>"INT",
                //"conditions"=>array("!\$this->isFixField()"=>"section"),
                "section",
                "no column",
            ),
            "showInForm"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"1",
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forAll, customfield_forAdmin, customfield_forAllInCreateButAdminInModify, customfield_forManager, customfield_forAllInCreateButManagerInModify),
            ),
            "expl"=>array(
                "type"=>"TEXT",
                //"conditions"=>array("!\$this->isFixField()"=>"textarea"),
                "textarea",
                "cols"=>50,
                "rows"=>5,
                "details",
            ),
            "type"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"selection",
                                    "\$this->isFixField()===TRUE"=>"form hidden"),
                "modify_form: readonly",
                "enum",
                "list",
                "details",
                "values"=>array(customfield_text,
                                customfield_textarea,
                                customfield_bool,
                                customfield_selection,
                                customfield_separator,
                                customfield_multipleselection,
                                customfield_checkbox,
                                customfield_picture,
                                customfield_media,
                                customfield_url,
                                customfield_date),
                "default" =>customfield_text,
            ),
            "subType"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"radio",
                                    "\$this->isFixField()===TRUE"=>"form hidden"),
                "cols"=>1,
                "values"=>array(customfield_alnum,
                                customfield_integer,
                                customfield_float),
                "default" =>customfield_alnum,
            ),
            "values"=>array(
                "type"=>"TEXT",
                "mandatory",
                "values"=>array(),
                "asmselect"=>"{
                    sortable: true, 
                    hideSelect: true, 
                    modifyLink: true,
                    addButton: true,
                    checkboxInput: true,
                    modifyLabel: 'asmModifyLabel',
                    removeLabel: 'asmRemoveLabel',
                    modifyButtonLabel: 'modifySelectFieldValue',
                    addButtonLabel: 'addSelectFieldValue'
                }",
                "multipleselection",
                "conditions"=>array("@in_array(\$this->type, 
                                             array(".customfield_selection.", 
                                                   ".customfield_multipleselection.", 
                                                   ".customfield_checkbox."))"=>"details"),
            ),
            "values_upload"=>array(
                "type"=>"TEXT",
                "no column"
            ),
            "useVariableSubstitution"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "conditions"=>array("!\$this->isFixField()"=>"bool"),
            ),
            "default"=>array(
                "type"=>"TEXT",
                "default"=>" ",
                "conditions"=>array("@in_array(\$this->type, 
                                             array(".customfield_text.", 
                                                   ".customfield_textarea.",
                                                   ".customfield_selection.",
                                                   ".customfield_bool.",
                                                   ".customfield_multipleselection.",
                                                   ".customfield_checkbox."))"=>"details"),
            ),
            "default_text"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("!\$this->isFixField()"=>"text"),
                "no column"
            ),
            "default_textarea"=>array(
                "type"=>"TEXT",
                "cols"=>50,
                "rows"=>19,
                "conditions"=>array("!\$this->isFixField()"=>"textarea"),
                "no column"
            ),
            "default_bool"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"bool"),
                "no column"
            ),
            "default_multiple"=>array(
                "type"=>"TEXT",
                "cols"=>50,
                "rows"=>5,
                "values"=>array(),
                "conditions"=>array("!\$this->isFixField()"=>"multipleselection"),
                "no column"
            ),
            "fieldExpirationDays"=>array(
                "type"=>"INT",
                "default"=>"0",
                "length"=>3,
                "filterCharacters"=>"numeric()",
                "conditions"=>array("!\$this->isFixField()"=>"text",
                                    "\$this->type==".customfield_bool=>"details")
            ),
            "checkboxCols"=>array(
                "type"=>"VARCHAR",
                "max"=>5,
                "default"=>3,
                "length"=>5,
                "min"=>1,
                "mandatory",
                "filterCharacters"=>"numeric()",
                "conditions"=>array("!\$this->isFixField()"=>"text",
                                    "@in_array(\$this->type,".customfield_checkbox.")"=>"details"),
            ),
            "mandatory"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"bool"),
            ),
            "allowHtml"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"bool"),
                "default"=>"0",
            ),
            "useMarkitup"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"bool"),
                "default"=>"0",
            ),
            "useMarkitupSimple"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"bool"),
                "default"=>"0",
            ),
            "dateDefaultNow"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"bool"),
                "default"=>"0",
            ),
            "fromyear"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>20,
                "default"=>"now",
            ),
            "toyear"=>array(
                "type"=>"VARCHAR",
                "text",
                "max"=>20,
                "default"=>"now",
            ),
/**************************************************************************
Display formatting
**************************************************************************/
            "formatSection"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField() || \$this->columnIndex=='id'"=>"section"),
                "no column",
            ),
            "formatPrefix"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("!\$this->isFixField() || \$this->columnIndex=='id'"=>"text"),
                "max"=>255,
                "notrim",
                "length"=>5,
            ),
            "formatPostfix"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("!\$this->isFixField() || \$this->columnIndex=='id'"=>"text"),
                "max"=>255,
                "notrim",
                "length"=>5,
            ),
            "precision"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"text"),
                "default"=>2,
                "length"=>1,
            ),
            "precisionSeparator"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("!\$this->isFixField()"=>"text"),
                "max"=>1,
                "notrim",
                "length"=>1,
                "default"=>$defaultPrecisionSeparator,
            ),
            "thousandsSeparator"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("!\$this->isFixField()"=>"text"),
                "max"=>1,
                "length"=>1,
                "notrim",
                "default"=>$defaultThousandsSeparator,
            ),
            "format"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("!\$this->isFixField() || \$this->columnIndex=='id'"=>"text"),
                "notrim",
                "max"=>255,
            ),
/**************************************************************************
List properties
**************************************************************************/
            "listProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
            ),
            "showInList"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"0",
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forAll, customfield_forLoggedin, customfield_forAdmin, customfield_forManager),
            ),
            "customListPlacement"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
            ),
            "innewline"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
            ),
            "rowspan"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
            ),
            "displaylength"=>array(
                "type"=>"INT",
                "text",
                "length" =>"5",
            ),
            "sortable"=>array(
                "type"=>"INT",
                "bool",
                "default" =>"0",
            ),
            "mainPicture"=>array(
                "type"=>"INT",
                "bool",
                "default" =>"0",
            ),
/**************************************************************************
Details properties
**************************************************************************/
            "detailsProperties"=>array(
                "type"=>"INT",
                "no column",
                "section"
            ),
            "showInDetails"=>array(
                "type"=>"INT",
                "default"=>"1",
                "cols"=>"1",
                "radio"
            ),
            "customDetailsPlacement"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
            ),
            "displayLabel"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"1",
            ),
            "detailsPosition"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"0",
                "cols"=>1,
                "values"=>array(customfield_normal, customfield_topright, customfield_bottomright), 
            ),
/**************************************************************************
Misc properties
**************************************************************************/
            "miscProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
            ),
            "searchable"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"0",
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forAll, customfield_forLoggedin, customfield_forAdmin, customfield_forManager),
            ),
            "rangeSearch"=>array(
                "type"=>"INT",
                "bool",
            ),
            "seo"=>array(
                "type"=>"INT",
                "conditions"=>array("@\$this->columnIndex!='clicked' && @\$this->columnIndex!='responded' && @\$this->columnIndex!='ownerName' && @\$this->cid"=>"radio"),
                "cols"=>1,
                "values"=>array(0, customfield_title,
                                customfield_description,
                                customfield_keywords),
                "default" =>"0",
            ),
            "css"=>array(
                "type"=>"VARCHAR",
                "max"=>250,
                "text"
            ),
            "columnIndex"=>array(
                "type"=>"VARCHAR",
                "max"=>20,
                //"list"
            ),
            "oldColumnIndex"=>array(  // just for updating purposes
                "type"=>"VARCHAR",
                "max"=>255,
            ),
            "sortId"=>array(
                "type"=>"INT",
                "list",
            ),
            "fields"=>array(  // a sort form outputjanak tarolasara
                "type"=>"INT",
            ),
            "ecommAssignment"=>array(  // a sort form outputjanak tarolasara
                "type"=>"INT",
                "cols"=>1,
                "values"=>array(0,10,20,30,40,50,60,70,80,90,100), //ecomm_none - ecomm_cardCode
                "default"=>"0", //ecomm_none
            ),

/**************************************************************************
oodle properties
**************************************************************************/
            "oodleProperties"=>array(
                "type"=>"INT",
                "conditions"=>array("!\$this->isFixField()"=>"section"),
                "no column",
            ),
             "oodleField"=>array(
                "type"=>"VARCHAR",
                "max"=>250,
                "conditions"=>array("!\$this->isFixField()"=>"selection"),
                "values"=>array(),
                "default" =>"",
            ),


        ),
        "primary_key"=>"id",
        "sort_criteria_sql"=>"sortId ASC",
        "delete_confirm"=>"name",
        "zebraList"=>"no",
        "sortfield_form: submit"=>array("customfield_savesorting"),
        "wrap_form",
        "no_pager",
        "keys"=>array("cid", "isCommon", "userField", "columnIndex"),

    );

//CustomField::initOodle();    
class CustomField extends Object 
{
 
function get_table() { return "customfield"; }

function initOodle()
{
    global $lll, $customfield_typ, $oodleFields;
    
    $_S = new AppSettings();
    
    $customfield_typ["attributes"]["oodleField"]["values"][]='';


    foreach($oodleFields as $name => $value)
    {
            $customfield_typ["attributes"]["oodleField"]["values"][]=$name;
            $lll["customfield_oodleField_".$name] = $value;
    }
   
}

// hogy ne legyen lapozo tool:
function getLimit() { return "";}
   
function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll;

    hasAdminRights($isAdm);
    $hasRight->generalRight = TRUE;
    if( $method=="delete" )
    {
        $hasRight->generalRight = FALSE;
        $hasRight->objectRight = $isAdm && $this->isFixField()===FALSE;
    }
    else $hasRight->objectRight=($method=="load" || $isAdm);
    if( !$hasRight->objectRight && $giveError ) {
        handleError($lll["permission_denied"]);
    }
}

function isFixField()
{
    if( !isset($this->columnIndex) && !empty($this->id) ) $this->columnIndex = G::getAttr( $this->id, "customfield", "columnIndex" ); 
    return isset($this->columnIndex) ? substr($this->columnIndex, 0, 4)!="col_" : null;
}

function updateDefaultOfSelectionTypeFieldOfCustomList()
{
    if( in_array($this->type, array(customfield_bool, customfield_picture, customfield_media)) )
    {
        // ezeknel a tipusoknal a -1 a default ertek - az osszes customlist-et updatelni kell, ami az adott categoriara vonatkozik
        executeQuery("UPDATE @search SET $this->columnIndex='-1' WHERE uid=0 AND cid='$this->cid'");
    }
}

function showListVal($attr)
{
    if( ($s=parent::showListVal($attr))!==FALSE ) return $s;
    if(  $attr=="sortId" )
    {
        $s="<span style='display:none;'>$this->sortId</span>";
        $s.=CustomField::showMoveTool($this->id);
    }
    else
    {
        $s=parent::showListVal($attr, "safetext");
    }
    return $s;
}

function sortFieldForm($elementName="")
{
    global $jQueryLib, $gorumroll;
    
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/form.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.center.js");  // to center the loading animation image
    JavaScript::addInclude(JS_DIR . "/sort_custom_fields.js");
    JavaScript::addInclude(JS_DIR . "/propagate.js");
    
    // Propagate into all other categories:
    $propagatePostfix = OverlayController::addPropagateOverlay($gorumroll->rollid, "_sorting");
    
    // Propagate into the subcategories only:
    if( $gorumroll->rollid ) // ha nem common scope
    {
        getDbCount( $count, array("SELECT COUNT(*) FROM @category WHERE up=#cid#", $gorumroll->rollid) );
        if( $count )  // ha leteznek egyaltalan sub category-k
        {
            $propagatePostfix .= " ".OverlayController::addPropagateOverlay( $gorumroll->rollid, "_sorting", "_subcat" );
        }
    }
    JavaScript::addOnload("
        $('#itemfield-sortfield_form .submitfooter').append(" . G::js($propagatePostfix) . ");
    ");
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
        executeQuery("UPDATE @customfield SET sortId=#index# WHERE id=#id#", $sortId+=100, $id);
    }
    Roll::setInfoText("customfield_sortingsaved");
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

function createForm()
{
    global $gorumroll, $lll;
    $this->cid = $gorumroll->rollid;
    $this->initializeMultipleSelectionFieldsAndDefaults();
    $lll["customfield_values_afterfield"]="<p>".$lll["orUploadValuesFromFile"]."<br>".
        GenerWidget::generFileField("values_upload","40");
    $lll["customfield_values_expl"].=$lll["uploadValuesFromFileExpl"];   
    parent::createForm();
}

function generForm()
{
    global $gorumroll, $jQueryLib;
    if( $gorumroll->method=="modify_form" || $gorumroll->method=="create_form" )
    {
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/field.js");
        JavaScript::addInclude(JS_DIR . "/custom_field_form.js");
    }

    $this->initOodle();
    parent::generForm();
}

function create()
{
    global $gorumroll, $gorumuser, $gorumrecognised, $shoppingCartClassName;
    
    if( empty($this->columnIndex) )
    {
        $this->columnIndex = "col_".CustomField::getNextColumnIndex($this->cid);
    }
    $this->sortId = CustomField::getNextSortId($this->cid);
    $this->getDefaultValue();
    $this->getEnumValuesFromFile();
    parent::create();
    if( !Roll::isFormInvalid() )
    {
        if( !empty($this->seo) ) $this->handleSeoChange();
        if( !empty($this->mainPicture) ) $this->handleMainPictureChange();
        // Uj oszlopot kell letrehoznunk, ha az ujonan krealt fielddel egyutt a szukseges oszlopok szama meghaladja az eddigi maximumot:
        $this->addNewColumnToManagedTable();
        load($this);
        $this->handleDefaultValue();
        if( isset($gorumroll) ) $this->nextAction = new AppController("$gorumroll->list/sortfield_form/$this->cid");
    }
}

// visszaadja a kovetkezo felhasznalhato columnIndex-et egy kategoriaban, 
// vagy globalisan, ha nullaval hivjak meg:
function getNextColumnIndex( $cid=0 )
{
    $cidCond = $cid ? "cid=#cid# AND" : "";
    $query = "SELECT MAX(0+SUBSTRING(columnIndex, 5)) as columnIndex FROM @customfield WHERE $cidCond columnIndex LIKE 'col_%'";
    loadSQL( $fieldStat = new CustomField, array($query, $cid) );
    return isset($fieldStat->columnIndex) ? $fieldStat->columnIndex+1 : 0;
}

// visszaadja a kovetkezo felhasznalhato sortId-t egy kategoriaban, 
// vagy globalisan, ha nullaval hivjak meg:
function getNextSortId( $cid )
{
    $query = "SELECT MAX(sortId) as sortId FROM @customfield WHERE cid=#cid#";
    loadSQL( $fieldStat = new CustomField, array($query, $cid) );
    return isset($fieldStat->sortId) ? $fieldStat->sortId+100 : 1000;
}

function addNewColumnToManagedTable()
{
    $table = $this->getManagedTable();
    // TODO: optimalizalni, hogy a getCustomColumnIndexes ne csinaljon annyi query-t minden esetben,
    // ha tobbszor meghivjak (common field letrehozasanal):
    if( $this->type!=customfield_separator && !$this->isFixField() &&
        !in_array( $this->columnIndex, CustomField::getCustomColumnIndexes($this->getManagedTable()) ) )
    {
        if( empty($this->userField) ) executeQuery("ALTER TABLE @$table ADD $this->columnIndex TEXT NOT NULL;");
        if( $table=="item" && !in_array( $this->columnIndex, CustomField::getCustomColumnIndexes("search")) )
        {
            executeQuery("ALTER TABLE @search ADD $this->columnIndex TEXT NOT NULL;");
            $this->updateDefaultOfSelectionTypeFieldOfCustomList(); 
        }
        return TRUE;
    }
    return FALSE;
}

function modifyForm()
{
    global $gorumroll, $customfield_typ;

//    $this->initOodle();


    $this->id = $gorumroll->rollid;
    if( !Roll::isPreviousFormSubmitInvalid() )
    {
        if( $this->load() ) handleErrorNotFound($this,__FILE__,__LINE__);
    }
    $this->hasObjectRights($hasRight, "modify", TRUE);
    $this->initializeMultipleSelectionFieldsAndDefaults();
    
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/json.js");
    JavaScript::addInclude(JS_DIR . "/propagate.js");
    JavaScript::addOnload('$.noah.submitOptionValueModificationStack();');
    
    if( $this->isFixField() ) $customfield_typ["attributes"]["values"][] = "form invisible";
    $this->generForm();
    if( $this->isFixField() ) Roll::setInfoText("customfield_fixInfoText");
}

function initializeMultipleSelectionFieldsAndDefaults()
{
    global $lll;
    
    $typ =& $this->getTypeInfo();
    if( !isset($this->type) ) return;  // create form
    if( $this->type==customfield_selection || $this->type==customfield_checkbox || $this->type==customfield_multipleselection )
    {
        $this->default_multiple = !empty($this->default) ? $this->default : "";
        $this->activateEnumAttrInfo( $typ["attributes"]["values"], "customfield", "values" );
        $this->activateEnumAttrInfo( $typ["attributes"]["default_multiple"], "customfield", "default_multiple" );
        $typ["attributes"]["default_multiple"]["values"] = $typ["attributes"]["default_multiple"]["default"];
    }
    elseif( $this->type==customfield_text ) $this->default_text = $this->default;
    elseif( $this->type==customfield_textarea ) $this->default_textarea = $this->default;
    elseif( $this->type==customfield_bool ) $this->default_bool = $this->default;
}

function modify()
{
    $this->getDefaultValue();

    parent::modify();
    if( !Roll::isFormInvalid() )
    {
        if( !empty($this->seo) ) $this->handleSeoChange();
        if( !empty($this->mainPicture) ) $this->handleMainPictureChange();
        $this->handleEnumValueChange();
    }
}

// Ha uj custom fieldet adunk egy olyan kategoriahoz, aminek mar vannak itemei, az itemekben be kell allitani az uj field default ertekeit:
function handleDefaultValue()
{
    if( !$this->isFixField() && empty($this->userField) && $this->type!=customfield_separator )
    {
        $query = "UPDATE @". $this->getManagedTable() ." SET $this->columnIndex=#default#";
        if( $this->cid ) $query.=" WHERE cid=#cid#";
        executeQuery($query, $this->default, $this->cid);
    }
}

function handleEnumValueChange($stack=FALSE, $oldValue=FALSE, $newValue=FALSE)
{
    if( $stack===FALSE )
    {
        if( !isset($_POST["optionValueModificationStack"]) || 
            !count($stack = JavaScript::jsonDecode($_POST["optionValueModificationStack"])) ) return; // ha nem vol modositas, vagy torles
    }
    if( $oldValue!==FALSE )
    {
        // ha propagate van, nem csak azokat a modositasokat kell figyelembe venni, amik az adott modifyban tortentek,
        // hanem a korabbiakat is. Ezt a 'values' regi es uj ertekenek osszehasonlitasaval erjuk el. Ha talalunk olyat,
        // ami nincs benne az uj 'values'-ban, azt hozzaadjuk $stack-hoz egy 'delete' action-nel:
        $oldValueArr = splitByCommas($oldValue, FALSE); // without HTML encoding
        $modified = array_unique(array_map(create_function('$v', 'return $v[0]=="modify" ? $v[1] : "";'), $stack));       
        foreach( $oldValueArr as $val )
        {
            if( !in_array($val, $newValue) && !in_array($val, $modified) ) 
            {
                $stack[]=array("delete", $val);
            }
        }
    }
    if( !$stack ) return; // ha az old es new values osszehasonlitasa utan se derul ki, hogy lett volna torles v. modositas
    
    CustomField::addCustomColumns($this->getManagedTable());
    $affectedValues = array_map(create_function('$v', 'return quoteSQL(str_replace(",", ",,", $v[1]));'), $stack);
    $regexp = array();
    $columnIndex = G::getAttr($this->id, "itemfield", "columnIndex");
    foreach( $affectedValues as $v ) $regexp[]="$columnIndex LIKE '%$v%'";
    $whereCond = " WHERE (".implode(" OR ", $regexp).")";
    if( $this->cid ) $whereCond.=" AND (cid=$this->cid OR cid=0)";         
    $query = "SELECT id, $columnIndex FROM @". $this->getManagedTable(). $whereCond;
    
    G::load( $objs, $query );
    
    $customLists = new CustomList;
    $customLists->activateVariableFields();
    $query = "SELECT * FROM @search $whereCond";
    if( !loadObjectsSql($customLists, $query, $customLists) )
    {
        $objs = array_merge($objs, $customLists);
    }
    
    foreach( $objs as $obj )
    {
        $vals = splitByCommas($obj->$columnIndex, FALSE);
        $map = array_flip($vals);
        foreach( $stack as $action )
        {
            if( isset($map[$action[1]]) )
            {
                // modositjuk, ha modify, uresre allitjuk, ha delete:
                $vals[$map[$action[1]]] = ($action[0]=='modify') ? $action[2] : "";
            }            
        }
        $obj->$columnIndex = array_filter($vals); // removes the empty values
        if( is_a($obj, "search") ) $obj->modify(TRUE);  // frominstall 
        else modify($obj);
    }
}

function getEnumValuesFromFile()
{
    if( !isset($_FILES["values_upload"]["name"]) || 
        $_FILES["values_upload"]["name"]=="" || 
        $_FILES["values_upload"]["size"]==0 || 
        ($fname=$_FILES["values_upload"]["tmp_name"])=="none" || 
        !is_uploaded_file($fname) ||
        !($lines = file($fname))) return;
    $this->values = array_filter(array_unique(array_map(create_function('$v', 'return trim($v);'), $lines)));
    $this->default = array_filter($this->values, create_function('$v', 'return strstr($v, ":default:");'));
    if( count($this->default) )
    {
        $this->default = array_map(create_function('$v', 'return str_replace(":default:", "", $v);'), $this->default);
        $this->values = array_map(create_function('$v', 'return str_replace(":default:", "", $v);'), $this->values);
    }
}

function getDefaultValue()
{
    $typ =& $this->getTypeInfo();
    $typ["attributes"]["default"][]="text";  // kulonben a create es a modify visszautasitana a default beallitasat
    if( !empty($this->default) && !is_array($this->default) ) return; // ha mar egyszer meg lett hivva ez a fg
    switch($this->type)
    {
    case customfield_text: 
        $this->default = isset($this->default_text) ? $this->default_text : "";
        break;
    case customfield_bool: 
        $this->default = isset($this->default_bool) ? $this->default_bool : 0;
        break;
    case customfield_textarea: 
        $this->default = isset($this->default_textarea) ? $this->default_textarea : "";
        break;
    case customfield_selection: 
    case customfield_multipleselection: 
    case customfield_checkbox:
        // mar eleve a default-ban erkezik az ertek
        break;
    default: $this->default = "";            
        break;
    }
}

function handleSeoChange()
{
    // hogy egy kategorian belul pl. csak egy TITLE lehessen:
    executeQuery(array("UPDATE @customfield SET seo=0 WHERE cid=#cid# AND id!=#id# AND seo=#seo#", $this->cid, $this->id, $this->seo));
}

function handleMainPictureChange()
{
    // hogy egy kategorian belul pl. csak egy main picture lehessen:
    executeQuery(array("UPDATE @customfield SET mainPicture=0 WHERE cid=#cid# AND id!=#id# AND mainPicture=1", $this->cid, $this->id));
}

function showNewToolPlusUrl()
{
    global $gorumroll;
    return $gorumroll->rollid;
}

function getSortType( &$sortType, &$sortSqlAttr, $isCommon, $cid, $attr )
{
    $sortType = 0;
    $sortSqlAttr = "";
    if( preg_match("/col_(\d+)/", $attr, $matches) )
    {
        if( !loadSQL( $cf=new CustomField, array("SELECT * FROM @customfield WHERE isCommon=#isCommon# AND cid=#cid# AND columnIndex='$attr' LIMIT 1", $isCommon, $cid) ) )
        {
            if( $cf->userField ) 
            {
                list($cf->type, $cf->subType, $attr) = G::getAttr($cf->userField, "customfield", "type", "subType", "columnIndex");
                $sortSqlAttr = "u.$attr";
            }
            else $sortSqlAttr = "n.$attr";
            if( $cf->type==customfield_date ) $sortType = customfield_date;
            elseif( $cf->subType==customfield_integer || $cf->subType==customfield_float ) $sortType = $cf->subType;
        }
    }
}

function addCustomColumns( $table )
{
    global ${"{$table}_typ"};
    static $maxColumnIndex=0;
    
    // hogy a load a custom fieldeket is betoltse az objektumba:
    //$customColumnIndexes or $customColumnIndexes = self::getCustomColumnIndexes($table);
    $maxColumnIndex or $maxColumnIndex = CustomField::getNextColumnIndex()-1;
    //foreach( $customColumnIndexes as $columnIndex )
    //{
    //    if( !isset(${"{$table}_typ"}["attributes"][$columnIndex]) ) ${"{$table}_typ"}["attributes"][$columnIndex]=array("type"=>"TEXT");
    //}
    for( $i=0; $i<=$maxColumnIndex; $i++ )
    {
        if( !isset(${"{$table}_typ"}["attributes"]["col_$i"]) ) ${"{$table}_typ"}["attributes"]["col_$i"]=array("type"=>"TEXT");
    }
}

function getCustomColumnIndexes( $table )
{
    $result = executeQuery("SHOW COLUMNS FROM @$table");
    $num = mysql_num_rows($result); 
    $columnIndexes = array();
    for( $i=0, $count=0; $i<$num; $i++ ) 
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if( preg_match( "/^col_/", $row["Field"] ) ) $columnIndexes[]=$row["Field"];
    }
    return $columnIndexes;
}

function showDetailsTool()
{
    return "";
}

function displayInDetails( &$attrInfo, $ownerId )
{
    if( $this->displayInDetailsCondition($ownerId) ) $attrInfo[]="details";
}

function displayInDetailsCondition($ownerId=0)
{
    global $gorumrecognised;
    
    if( $this->ecommFieldVisibilityDisabled() ) return FALSE;
    hasAdminRights($isAdm);    
    hasManagerRights($isManager);    
    return $this->showInDetails==customfield_forAll ||
        ($this->showInDetails==customfield_forManager && $isManager) ||
        ($this->showInDetails==customfield_forAdmin && $isAdm) ||
        ($this->showInDetails==customfield_forLoggedin && $gorumrecognised);
}

function displayInForm( &$attrInfo )
{
    global $gorumroll;
    
    hasAdminRights($isAdm);
    hasManagerRights($isManager);    
    if( $this->showInForm==customfield_forNone || 
        (!$isManager && $this->showInForm==customfield_forManager) || 
        (!$isAdm && $this->showInForm==customfield_forAdmin) || 
        (!$isAdm && $this->showInForm==customfield_forAllInCreateButAdminInModify && $gorumroll->method=='modify_form') ||
        (!$isManager && $this->showInForm==customfield_forAllInCreateButManagerInModify && $gorumroll->method=='modify_form') ||
        $this->ecommFieldVisibilityDisabled()) 
    {
        $attrInfo[]="form invisible";
    }
}

function ecommFieldVisibilityDisabled()
{
    $_S = new AppSettings();
    return !$_S->ecommerceEnabled() && ($this->columnIndex=="credits" || $this->columnIndex=="expirationTime");
}

function displayInList( &$attrInfo )
{
    if( $this->displayInListCondition() ) $attrInfo[]="list";
}

function displayInListCondition()
{
    global $gorumrecognised, $gorumuser;
    
    hasAdminRights($isAdm);
    hasManagerRights($isManager);    
    return $this->showInList==customfield_forAll ||
        ($this->showInList==customfield_forManager && $isManager) ||
        ($this->showInList==customfield_forAdmin && $isAdm) ||
        ($this->showInList==customfield_forLoggedin && $gorumrecognised);
}

function displayInSearchFormCondition()
{
    return AppSettings::isEnabled($this->searchable);
}

function getFieldsForRules($cid, $onlySelectFields=FALSE)
{
    $cidCond = "cid='".quoteSQL($cid)."'";
    $typeCond = "type!=".customfield_separator." AND type!=".customfield_date;
    if( $onlySelectFields ) $typeCond.=" AND type!=".customfield_text." AND type!=".customfield_textarea." AND type!=".customfield_url." AND type!=".customfield_picture." AND type!=".customfield_media; 
    if( !intval($cid) ) $cidCond.=" AND isCommon=1";
    $query = "SELECT id, name, columnIndex, type FROM @itemfield 
              WHERE $cidCond AND $typeCond
              AND showInForm>".customfield_forNone." AND showInForm!=".customfield_forAdmin." AND showInForm!=".customfield_forManager." ORDER BY sortId ASC";
    //FP::log($query);          
    G::load($fields, $query);
    return $fields;
}

function getFieldsForRulesAjax($onlySelectFields=FALSE)
{
    global $gorumroll, $lll;
    
    $fields = $this->getFieldsForRules($gorumroll->rollid, $onlySelectFields);
    $values = array_map(create_function('$v', 'return $v->id;'), $fields);
    $labels = array_map(create_function('$v', 'return $v->name;'), $fields);  
    array_unshift($values, 0);
    array_unshift($labels, $lll["selectRuleField"]);  
    echo GenerWidget::generSelectOptions($labels,$values);
    die();
}

function getValuesForRules($id, &$labels, &$values)
{
    global $gorumroll, $lll;
    
    G::load( $field, $id, "itemfield" );
    if( $field->type==customfield_bool )
    {
        $labels = array($lll["no"], $lll["yes"]);
        $values = array(0, 1);
    }
    else
    {
        $labels = split(", *", $field->getAttr("values"));
        $values = range(0, count($labels)-1);
    }
}

function getValuesForRulesAjax()
{
    global $gorumroll, $lll;
    
    $this->getValuesForRules($gorumroll->rollid, $labels, $values);
    echo GenerWidget::generSelectOptions($labels,$values);
    die();
}

function activateEnumAttrInfo( &$attrInfo, $className, $attr, $withDefaults=TRUE )
{
    global $lll, $useHtmlInEnumValues;
    
    $attrInfo["default"]=array();
    $attrInfo["values"] = splitByCommas($this->getAttr("values"), !$useHtmlInEnumValues);
    $defs = splitByCommas($this->getAttr("default"), !$useHtmlInEnumValues);
    foreach( $attrInfo["values"] as $val )
    {
        $lllLabel = "{$className}_{$attr}_{$val}";
        if( !isset($lll[$lllLabel]) ) $lll[$lllLabel] = $val;
        if( $withDefaults && in_array($val, $defs) ) $attrInfo["default"][] = $val;
    }
    return count($attrInfo["values"]);
}

function tranformEnumValuesWrapper()
{
    hasAdminRights($isAdm);
    if( !$isAdm ) return;
    ini_set("max_execution_time", 0);
    CustomField::tranformEnumValues();
}

function tranformEnumValues($file=0, $line=0)
{
    CustomField::addCustomColumns("item");
    CustomField::addCustomColumns("user");
    CustomField::addCustomColumns("search");
    G::load( $fields, "SELECT cid, columnIndex, `values`, `type` 
                       FROM @customfield 
                       WHERE cid=0 AND isCommon=0 AND columnIndex LIKE 'col_%' AND (type=4 OR type=6 OR type=7)" );
    foreach( $fields as $field )
    {
        CustomField::tranformEnumValuesForClass($field, "user", $file, $line);
    }
    
    $query = "SELECT cid, columnIndex, `values`, `type` 
              FROM @customfield 
              WHERE cid!=0 AND columnIndex LIKE 'col_%' AND (type=4 OR type=6 OR type=7)";
    iterateLargeDatabaseTable($query, array("CustomField", "tranformEnumValuesInner"));
}

function tranformEnumValuesInner($field)
{
    CustomField::tranformEnumValuesForClass($field, "item", __FILE__, __LINE__);
    CustomField::tranformEnumValuesForClass($field, "search", __FILE__, __LINE__);
}

function tranformEnumValuesForClass($field, $className, $file, $line)
{
    $values = split(", *", $field->values);
    $cidCond = $className=="user" ? "" : "cid=$field->cid AND ";
    G::load( $objs, "SELECT id, $field->columnIndex FROM @$className WHERE $cidCond $field->columnIndex!=''" );
    foreach( $objs as $obj )
    {
        $numValues = split(", *", $obj->{$field->columnIndex});
        $obj->{$field->columnIndex} = array();
        for( $i=0; $i<count($numValues); $i++ ) 
        {
            if( isset($values[$numValues[$i]]) ) $obj->{$field->columnIndex}[]=$values[$numValues[$i]];
            elseif( in_array($numValues[$i], $values) ) $obj->{$field->columnIndex}[]=$numValues[$i];
        }
        $newValue = quoteSQL(join( ",", array_map(create_function('$v', 'return str_replace(",", ",,", $v);'), $obj->{$field->columnIndex}) ));
        $query = "UPDATE @$className SET $field->columnIndex='$newValue' WHERE id=$obj->id";
        if( $file ) executeQueryForUpdate($query, $file, $line);
        else executeQuery($query);
    }
}

function checkFieldExpiration()
{
    G::load( $fields, "SELECT * FROM @customfield WHERE fieldExpirationDays>0" );
    foreach( $fields as $field )
    {
        $query = "UPDATE @item SET $field->columnIndex = NOT CAST($field->columnIndex AS UNSIGNED) WHERE DATEDIFF(NOW(), creationtime)=$field->fieldExpirationDays";
		if( $field->cid ) $query.=" AND cid=$field->cid";
	    executeQuery($query);
    }
}

}// end class CustomField

?>
