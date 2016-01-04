<?php
defined('_NOAH') or die('Restricted access');

$itemfield_typ = $customfield_typ;
$itemfield_typ["attributes"]["showInDetails"]["values"] = array(customfield_forNone, customfield_forAll, customfield_forLoggedin, customfield_forOwner, customfield_forAdmin, customfield_forManager);
$itemfield_typ["attributes"]["listProperties"]["conditions"]=
$itemfield_typ["attributes"]["detailsProperties"]["conditions"]=
$itemfield_typ["attributes"]["showInDetails"]["conditions"]=
$itemfield_typ["attributes"]["miscProperties"]["conditions"]=
$itemfield_typ["attributes"]["searchable"]["conditions"]=
$itemfield_typ["attributes"]["showInList"]["conditions"]=array("@\$this->columnIndex=='rememberPassword' || @\$this->columnIndex=='remindPasswordLink'"=>"form invisible");
$itemfield_typ["attributes"]["formProperties"]["conditions"]=
$itemfield_typ["attributes"]["values"]["conditions"]=
$itemfield_typ["attributes"]["showInForm"]["conditions"]=array("@\$this->isFixField()"=>"form invisible");
$itemfield_typ["attributes"]["isCommon"]["conditions"]["\$gorumroll->rollid"]="list";
$itemfield_typ["attributes"]["isCommon"]["conditions"]["@\$this->cid===0"]="form hidden";

class ItemField extends CustomField 
{
    
  
function getManagedTable() { return "item"; }
   
function displayInDetails( &$attrInfo, $ownerId )
{
    // a status es az expirationTime beallitasa a showDetails-ben tortenik 
    if( $this->columnIndex=="status" || $this->columnIndex=="expirationTime" ) return;
    parent::displayInDetails( $attrInfo, $ownerId );
}

function displayInDetailsCondition($ownerId=0)
{
    global $gorumuser;
    
    hasAdminRights($isAdm);
    return parent::displayInDetailsCondition($ownerId) || 
        ($this->showInDetails==customfield_forOwner && ($gorumuser->id==$ownerId || $isAdm));
}
function displayInList( &$attrInfo )
{
    // az expirationTime beallitasa a showDetails-ben tortenik 
    if( $this->columnIndex=="expirationTime" ) return;
    parent::displayInList($attrInfo);
}

function displayInListCondition()
{
    global $gorumroll;
    
    return parent::displayInListCondition() && ($this->columnIndex!="ownerId" || $gorumroll->list!="item_my");
}

function displayInForm( &$attrInfo )
{
    parent::displayInForm( $attrInfo );
}

function filterCompatibleCategories($cid, &$categories)
{
    G::load( $refFields, array("SELECT type, sortId FROM @customfield WHERE cid=#cid# ORDER BY sortId ASC", $cid));
    $refFieldsCount = count($refFields);
    $newCatList = array();
    foreach( $categories as $c )
    {
        G::load( $fields, array("SELECT type, sortId FROM @customfield WHERE cid=#cid# ORDER BY sortId ASC", $c->id));
        if( count($fields)!=$refFieldsCount ) continue;
        for( $i=0; $i<$refFieldsCount; $i++  )
        {
            if( $fields[$i]->type!=$refFields[$i]->type ) continue(2);
        }
        $newCatList[]=$c;
    }
    $categories = $newCatList;
}

function initOodle()
{
    global $oodleFields;
    global $itemfield_typ, $gorumroll, $lll, $jQueryLib;
    
    $_S = new AppSettings();
    //$attrInfo = & $customfield_typ["attributes"];

    //$itemfield_typ["attributes"]["oodleField"]["values"][]='';
    //$lll["customfield_oodleField_"] = '';


    foreach($oodleFields as $name => $value)
    {
            $itemfield_typ["attributes"]["oodleField"]["values"][]=$name;
            $lll["customfield_oodleField_".$name] = $value;
    }
   
}

function modifyForm()
{
    global $itemfield_typ, $gorumroll, $lll, $jQueryLib;

    $this->id = $gorumroll->rollid;    
    
//    $this->initOodle();
    
    if( !Roll::isPreviousFormSubmitInvalid() ) $ret = $this->load();

    // hogy ezek ne legyenek a formban, mikor egy global common field-et nezunk:
    if( $this->isCommon && !$this->cid )
    {
        $fieldsToLeaveOut = array("detailsProperties", "showInDetails", "formProperties", "expl", "default_text", "mandatory", "allowHtml");
        foreach( $fieldsToLeaveOut as $attr )
        {
            $itemfield_typ["attributes"][$attr][] = "form invisible";
        }
        // hogy a customfield.js-ben a feltetelek jol mukodjenek:
        $fieldsToMakeHidden = array("type","subType");
        foreach( $fieldsToMakeHidden as $attr )
        {
            $itemfield_typ["attributes"][$attr][] = "form hidden";
        }
    }
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.center.js");  // to center the loading animation image
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/field.js");  // to retrieve the form field values
    
    // Propagate into all other categories:
    $propagatePostfix = OverlayController::addPropagateOverlay($this->id);
    
    // Propagate into the subcategories only:
    if( $this->cid ) // ha nem common scope
    {
        getDbCount( $count, array("SELECT COUNT(*) FROM @category WHERE up=#cid#", $this->cid) );
        if( $count )  // ha leteznek egyaltalan sub category-k
        {
            $propagatePostfix .= " ".OverlayController::addPropagateOverlay( $this->id, "", "_subcat" );
        }
    }
    foreach( array_keys($itemfield_typ["attributes"]) as $attr )
    {
        if( !in_array($attr, array("name", "isCommon", "type", "userField")) )
        {
            if( isset($lll["itemfield_$attr"]) ) $lll["itemfield_$attr"].=$propagatePostfix;
            elseif(isset($lll["customfield_$attr"])) $lll["customfield_$attr"].=$propagatePostfix;
        }
    }


    parent::modifyForm();
}

function propagate( $intoSubcatsOnly=FALSE )
{
    global $gorumroll, $lll;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) die();
    if( !class_exists('rss') ) echo $lll["freeNotSupported"];
    $this->id = $gorumroll->rollid;
    $default = isset($_POST["default"]) ? $_POST["default"] : FALSE;
    $stack = isset($_POST["optionValueModificationStack"]) ? $_POST["optionValueModificationStack"] : FALSE;
    $length = $this->propagateField($attr=$_POST["attr"], $_POST["value"], $intoSubcatsOnly, $default, $stack);
    $label = isset($lll["itemfield_$attr"]) ? $lll["itemfield_$attr"] : (isset($lll["customfield_$attr"]) ? $lll["customfield_$attr"] : $lll[$attr]);
    if( $length ) echo sprintf($lll["successfullyPropagated"], $label, $length);
    else echo $lll["noPropagationOccured"];
    die();
}

function propagateSorting( $intoSubcatsOnly=FALSE )
{
    global $gorumroll, $lll;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) die();
    if( !class_exists('rss') ) echo $lll["freeNotSupported"];
    G::load( $fields, array("SELECT id, sortId FROM @itemfield WHERE cid=#cid#", $gorumroll->rollid) );
    foreach( $fields as $field )
    {
        $field->propagateField("sortId", $field->sortId, $intoSubcatsOnly);
    }
    echo $lll["sortingSuccessfullyPropagated"];
    die();
}

function propagateField( $attr, $value, $intoSubcatsOnly=FALSE, $default=FALSE, $stack=FALSE )
{
    global $lll;
    
    load($this);
    if( $intoSubcatsOnly )
    {
        $wholeName = G::getAttr( $this->cid, "appcategory", "wholeName" );
        $query = "SELECT f.* FROM @itemfield AS f, @category AS c WHERE c.id=f.cid AND c.wholeName LIKE '".quoteSQL($wholeName)."%' AND
                 ((f.name!='' AND f.name=#name# AND f.type=#type#) OR (f.name='' AND userField!=0 AND userField=#uf#)) 
                 AND cid!=#cid#";
    }
    else
    {
        $query = "SELECT * FROM @itemfield WHERE 
                 ((name!='' AND name=#name# AND type=#type#) OR (name='' AND userField!=0 AND userField=#uf#)) 
                 AND cid!=#cid#";
    }
    // ha egy masik kategoriaban letezik olyan field aminek neve es tipusa megegyezik az eppen letrehozottal,
    // vagy ami ugyanarra a userFieldre mutat, azt atallitjuk common-ra:
    G::load( $fields, array($query, $this->name, $this->type, $this->userField, $this->cid ) );
    
    // a 'values' es a 'default' fieldek propagalasa specialis, mert ezekben egy tomb erkezhet:
    if( $default!==FALSE )
    {
        $values = JavaScript::jsonDecode($value);
        $defaults = JavaScript::jsonDecode($default);
        $stack = JavaScript::jsonDecode($stack);
        $value = dbEncodeEnumValue($values);
        $default = dbEncodeEnumValue($defaults);
    }
    foreach( $fields as $field )
    {
        if( $default===FALSE )
        {
            if( strstr($attr, "default_") ) $attr = "default";
            executeQuery("UPDATE @customfield SET `attr`=#value# WHERE id=#id#", $attr, $value, $field->id);
        }
        else 
        {
            executeQuery("UPDATE @customfield SET `attr`=#value#, `default`=#default# WHERE id=#id#", $attr, $value, "default", $default, $field->id);
            $field->handleEnumValueChange($stack, $field->values, $values);
        }
        if( $attr=="mainPicture" && $value!="0" ) 
        {
            $field->mainPicture = $value;
            $field->handleMainPictureChange();
        }
        elseif($attr=="seo" && $value!="0" )  
        {
            $field->seo = $value;
            $field->handleSeoChange();
        }
    }
    return count($fields);
}

function getListSelect()
{
    global $gorumroll;

    $query = "SELECT id, name, type, isCommon, sortId, userField FROM @customfield WHERE cid=#rollid#";
    // a 0 rollid jelzi, hogy a globalis commonok listajat akarjuk:
    if( !$gorumroll->rollid ) $query.=" AND isCommon=1";
    return array($query, $gorumroll->rollid);
}

function loadHtmlList(&$list)
{
    global $gorumroll, $lll;

    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));     

    parent::loadHtmlList($list);
    if( $gorumroll->rollid )
    {
        G::load($fatherCategory, $gorumroll->rollid, "appcategory");
        $lll["itemfield_ttitle"]=sprintf($lll["itemfield_ttitle"], $fatherCategory->showListVal("name"));
    }
    else $lll["itemfield_ttitle"]=$lll["itemfield_ttitle_global"];
}


function showListVal($attr)
{
    global $lll;
    
    if(  $attr=="name" )
    {
        if( !$this->name && $this->userField )
        {
            return htmlspecialchars(G::getAttr($this->userField, "customfield", "name"));
        }
        return htmlspecialchars($this->name);
    }
    elseif(  $attr=="type" )
    {
        if( $this->userField ) return $lll["userField"];
        return parent::showListVal($attr);
    }
    elseif(  $attr=="isCommon" )
    {
        if( $this->isCommon || $this->isFixField() ) return $lll["common"];
        else return $lll["unique"];
    }
    elseif(  $attr=="userField" )
    {
        if( $this->userField ) 
        {
            G::load( $uf, $this->userField, "userfield" );
            return $uf->showListVal("name");
        }
        return "";
    }
    elseif( ($s=parent::showListVal($attr))!==FALSE ) return $s;
    else
    {
        $s=parent::showListVal($attr, "safetext");
    }
    return $s;
}

function cloneToCategory( $cid )
{
    $this->cid = $cid;
    $this->id = 0;
    create($this);
    $this->handleDefaultValue();
}

function getUserQueryPieces( $cid )
{
    $pieces = array("as"=>"", "where"=>"n.ownerId=u.id AND ", "from"=>", @user AS u");
    $query = "SELECT i.columnIndex, u.columnIndex AS name 
              FROM @customfield AS i, @customfield AS u 
              WHERE i.userField=u.id AND i.cid=#rollid#";// AND i.showInList!=".customfield_forNone;
    G::load( $userFields, array($query, $cid ));
    if( count($userFields) )
    {
        $pieces["as"] = "";
        $pieces["from"] = ", @user AS u";
        $pieces["where"] = "n.ownerId=u.id AND ";
        foreach( $userFields as $uf ) if( $uf->name!="viewAdsLink" ) $pieces["as"].=", u.$uf->name AS $uf->columnIndex";
    }
    return $pieces;
}

function sortFieldForm($elementName="")
{
    global $gorumroll;
    
    parent::sortFieldForm($elementName);
    if( $gorumroll->rollid )
    {
        LocationHistory::saveGorumCategory($gorumroll->rollid);
        $ctrl = new AppController("fieldset/create_form/$gorumroll->rollid");
        $gorumroll->processMethod($ctrl, $elementName);
    }
}   

function create()
{
    // nem a kategoria specifikus, hanem az osszes kategoriara vonatkozoan kovetkezo columnIndexet allitjuk be.
    // Igy elerjuk, hogy a columnIndex biztos ne legyen meg foglalt egyetlen mas kategoriaban sem.
    if( $this->isCommon && !$this->isFixField() ) 
    {
        if( $this->commonFieldAlreadyExists() ) return;
        $this->columnIndex = "col_".CustomField::getNextColumnIndex();
    }
    parent::create();
    if( !Roll::isFormInvalid() && $this->isCommon && !$this->isFixField() ) $this->propagateCommonField();
}

function modify()
{
    list($oldIsCommon, $oldName, $oldColumnIndex, $this->userField) = G::getAttr( $this->id, "customfield", "isCommon", "name", "columnIndex", "userField" );
    // ha most allitjuk common-ra, uj columnIndex kell:
    if( !$oldIsCommon && $this->isCommon )
    {
        if( $this->commonFieldAlreadyExists() ) return;
        $this->columnIndex = "col_".CustomField::getNextColumnIndex();
    }
    parent::modify();
    if( !Roll::isFormInvalid() && !$this->isFixField() )
    {
        if( $oldIsCommon!=$this->isCommon )  // ha az isCommon valtozott
        {
            if( $this->isCommon ) 
            {
                load($this);
                $newColumnAdded = $this->addNewColumnToManagedTable();
                // az item tablaban minden erteket atmasolunk a regi columnIndexrol az ujba:
                if( $newColumnAdded ) 
                {
                    executeQuery("UPDATE @item SET $this->columnIndex=$oldColumnIndex, $oldColumnIndex='' WHERE cid=#cid#", $this->cid);
                    $this->updatePictureNames( $oldColumnIndex, $this->cid );
                }
                // TODO: a customlistek search felteteleinek update-ezese!
                $this->nextAction = new AppController("field/sortfield_form/$this->cid");
                $this->propagateCommonField();
            }
            else 
            {
                // a globalis common torlese:
                executeQuery("DELETE FROM @customfield WHERE cid=0 AND isCommon=1 AND  columnIndex=#ci#", $this->columnIndex);
                // az osszes tobbi kategoriaban atallitjuk ezt a field-et unique-ra:
                executeQuery("UPDATE @customfield SET isCommon=0 WHERE cid!=#cid# AND isCommon=1 AND columnIndex=#ci#", 
                             $this->cid, $this->columnIndex );
            }
        }
        // ha egy common field nevet megvaltoztatjuk, az osszeset meg kell:
        elseif( $this->isCommon && $oldName!=$this->name ) 
        {
            executeQuery("UPDATE @customfield SET name=#name# WHERE cid!=#cid# AND isCommon=1 AND columnIndex=#ci#", 
                         $this->name, $this->cid, $this->columnIndex );
        }
    }
    if( !Roll::isFormInvalid() ) CacheManager::resetAllCache();
}

function commonFieldAlreadyExists()
{
    $id = isset($this->id) ? $this->id : 0;
    $query = "SELECT COUNT(*) FROM @customfield WHERE isCommon=1 AND columnIndex LIKE 'col_%' AND id!=#id# AND
             ((name!='' AND name=#name# AND type=#type#) OR (name='' AND userField!=0 AND userField=#uf#))";
    getDbCount( $count, array($query, $id, $this->name, $this->type, $this->userField) );
    if( $count ) Roll::setFormInvalid("commonFieldAlreadyExists");
    return $count;
}

function propagateCommonField()
{
    $this->createGlobalCommonField($this->id, $this->cid);
    if( isset($this->nextAction) ) $nextAction = $this->nextAction;  // hogy meglegyen kesobb
    G::load( $cats, array("SELECT id FROM @category WHERE id!=#cid#", $this->cid) );
    $this->isCommon = FALSE; // to avoid infinite loop
    // az osszes tobbi kategoriaban letrehozunk egy ugyanilyen mezot:
    foreach( $cats as $c )
    {
        $query = "SELECT id, columnIndex FROM @customfield WHERE 
                 ((name!='' AND name=#name# AND type=#type#) OR (name='' AND userField!=0 AND userField=#uf#)) 
                 AND cid=#cid# AND columnIndex LIKE 'col_%' LIMIT 1";
        // ha egy masik kategoriaban letezik olyan field aminek neve es tipusa megegyezik az eppen letrehozottal,
        // vagy ami ugyanarra a userFieldre mutat, azt atallitjuk common-ra:
        if( G::load( $field, array($query, $this->name, $this->type, $this->userField, $c->id ) ) )
        {
            // megvaltoztatjuk a columnIndexet ugy, hogy minden kategoriaban ugyanaz legyen:
            executeQuery("UPDATE @customfield SET isCommon=1, columnIndex='$this->columnIndex' WHERE id=".$field[0]->id);
            // az item tablaban minden erteket atmasolunk a regi columnIndexrol az ujba:
            if( !$this->userField && $this->type!=customfield_separator ) 
            {
                executeQuery("UPDATE @item SET $this->columnIndex={$field[0]->columnIndex} WHERE cid=#cid#", $c->id);
                $this->updatePictureNames( $field[0]->columnIndex, $c->id );
                // TODO: a customlistek search felteteleinek update-ezese!
            }
        }
        else
        {
            $this->cid = $c->id;
            unset($this->id);
            $this->create();
            executeQuery("UPDATE @customfield SET isCommon=1 WHERE id=$this->id");
        }
    }
    if( isset($nextAction) ) $this->nextAction = $nextAction; // restoring the original
}

// ha egy oszlop neve megvaltozik, akkor a picture es media file-ok nevet is megfalaloen valtoztatni kell:
function updatePictureNames( $oldColumnIndex, $cid )
{
    global $item_typ;
    
    if( $this->type==customfield_picture )
    {
        $index = split("_", $this->columnIndex);
        $newIndex = $index[1];
        $index = split("_", $oldColumnIndex);
        $oldIndex = $index[1];
        // hogy az $items tomb megfeleloen inicializalodhasson, a typeinfoba be kell tennunk az uj fieldet:
        if( !isset($item_typ["attributes"][$this->columnIndex]) ) $item_typ["attributes"][$this->columnIndex]=array("type"=>"TEXT");
        G::load( $items, array("SELECT id, $this->columnIndex FROM @item WHERE cid=#cid# AND $this->columnIndex!=''", $cid) );
        foreach( $items as $item )
        {
            foreach( array("", "th_", "th_large_", "th_medium_", "th_small_") as $prefix )
            {
                $oldPicName = AD_PIC_DIR . "/{$prefix}$item->id"."_$oldIndex.".$item->{$this->columnIndex};
                $newPicName = AD_PIC_DIR . "/{$prefix}$item->id"."_$newIndex.".$item->{$this->columnIndex};
                if( file_exists($oldPicName) ) rename($oldPicName, $newPicName);
            }
        }
    }
}

function createGlobalCommonField($id, $cid)
{
    if( $cid ) // csak ha meg nem letezik a global common field 
    {
        unset($this->id);
        $this->cid=0;      // a globalis common custom field listahoz akkor tartozik valami, ha cid==0 && isCommon==TRUE
        Object::create();  // a globalis common custom field listahoz is krealunk egy masolatot
        $this->cid=$cid;   // visszaallitas
        $this->id = $id;
    }
}

function delete($includingRelatedCommonFields=TRUE)
{
    if( load($this) ) return;  // ha mar nem letezik
    parent::delete();
    if( $this->isCommon && $includingRelatedCommonFields ) 
    {
        // ha egy common fieldet torlunk, az osszes azonos nevut torolni kell:
        executeQuery("DELETE FROM @customfield WHERE columnIndex=#ci# AND cid!=#cid# AND isCommon=1", 
                     $this->columnIndex, $this->cid );
        CacheManager::resetAllCache();
    }
    ItemSearch::deleteColumn($this);
    getDbCount( $count, "SELECT COUNT(*) FROM @search WHERE uid=0");
    if( $count )
    {
        Roll::setInfoText("checkCustomLists");
        $this->nextAction = new AppController("customlist/list");
    }
}

// azokba az item field-ekbe, amik user fieldekre utalnak, 
// betoltjuk a megfelelo user fieldek azokat a mezoit, 
// amik csak a user fieldekben vannak definialva
function updateFromUserFields( &$fields )
{
    global $lll;
    
    if( $fields ) 
    {
        for( $i=0; $i<count($fields); $i++ )
        {
            if( $ufId = $fields[$i]->userField ) 
            {
                G::load( $userField, $ufId, "userfield" );
                foreach( array("type", "subType", "values", "allowHtml", "formatPrefix", "format",
                               "formatPostfix", "precision", "precisionSeparator", "thousandsSeparator" ) as $attr )
                {
                    $fields[$i]->$attr = $userField->$attr;
                }
                if( !$fields[$i]->name ) $fields[$i]->name = $userField->name;
                $fields[$i]->showInForm = customfield_forNone;
            }
        }
    }
}

function getFixAndCommonFields()
{
    static $fields=0;
    if( !$fields && G::load($fields, "SELECT * FROM @customfield WHERE cid=0 AND isCommon=1 ORDER BY sortId ASC") )
    {
        ItemField::updateFromUserFields($fields);
    }
    return $fields;
}

function getFixOrCommonField($which)
{
    $fields = ItemField::getFixAndCommonFields();
    foreach( $fields as $field ) if( $field->columnIndex==$which ) return $field;
}

function addDefaultCustomFields($fromInstall = FALSE, $cid=0)
{
    global $lll;
    
    // Creating the fix fields:
    $v = new ItemField;
    $v->cid = $cid;
    $v->isCommon = !$cid;
    $v->name = $lll["item_id"];
    $v->showInForm = customfield_forNone;
    $v->type = customfield_text;
    $v->subType = customfield_integer;
    $v->sortable = TRUE;
    $v->columnIndex = "id";
    $v->searchable = customfield_forNone;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forNone;
    $v->create();
    
    $v = new ItemField;
    $v->cid = $cid;
    $v->isCommon = !$cid;
    $v->name = $lll["appcategory"];
    $v->showInForm = customfield_forNone;
    $v->type = customfield_selection;
    $v->columnIndex = "cName";
    $v->searchable = customfield_forAll;
    $v->create();
    if( !$v->cid )
    {
        $v->showInList = customfield_forAll;
        $v->modify();
    }
    
    $v = new ItemField;
    $v->cid = $cid;
    $v->isCommon = !$cid;
    $v->name = $lll["creationtime"];
    $v->showInForm = customfield_forNone;
    $v->type = customfield_date;
    $v->searchable = customfield_forAll;
    $v->rangeSearch = TRUE;
    $v->columnIndex = "creationtime";
    $v->create();
    if( !$v->cid )
    {
        $v->showInList = customfield_forAll;
        $v->modify();
    }

    $v = new ItemField;
    $v->cid = $cid;
    $v->isCommon = !$cid;
    $v->name = $lll["item_status"];
    $v->showInForm = customfield_forAdmin;
    $v->showInDetails = customfield_forAdmin;
    $v->type = customfield_selection;
    $v->values = "0,1";
    $v->columnIndex = "status";
    $v->searchable = customfield_forAdmin;
    $v->create();
    if( !$v->cid )
    {
        $v->showInList = customfield_forAdmin;
        $v->modify();
    }

    $v = new ItemField;
    $v->cid = $cid;
    $v->isCommon = !$cid;
    $v->name = $lll["item_clicked"];
    $v->showInForm = customfield_forNone;
    $v->showInDetails = customfield_forOwner;
    $v->type = customfield_text;
    $v->subType = customfield_integer;
    $v->columnIndex = "clicked";
    $v->searchable = customfield_forAdmin;
    $v->rangeSearch = TRUE;
    $v->create();
    if( !$v->cid )
    {
        $v->showInList = customfield_forLoggedin;
        $v->modify();
    }

    $v = new ItemField;
    $v->cid = $cid;
    $v->isCommon = !$cid;
    $v->name = $lll["item_responded"];
    $v->showInForm = customfield_forNone;
    $v->showInDetails = customfield_forOwner;
    $v->type = customfield_text;
    $v->subType = customfield_integer;
    $v->columnIndex = "responded";
    $v->searchable = customfield_forAdmin;
    $v->rangeSearch = TRUE;
    $v->create();
    if( !$v->cid )
    {
        $v->showInList = customfield_forAdmin;
        $v->modify();
    }

    $v = new ItemField;
    $v->cid = $cid;
    $v->isCommon = !$cid;
    $v->name = $lll["item_ownerName"];
    $v->showInForm = customfield_forNone;
    $v->showInDetails = customfield_forAll;
    $v->type = customfield_multipleselection;
    $v->columnIndex = "ownerName";
    $v->searchable = customfield_forAdmin;
    $v->create();
    if( !$v->cid )
    {
        $v->showInList = customfield_forAll;
        $v->modify();
    }

    $v = new ItemField;
    $v->cid = $cid;
    $v->isCommon = !$cid;
    $v->name = $lll["exp"];
    $v->showInForm = customfield_forNone;
    $v->showInDetails = customfield_forOwner;
    $v->type = customfield_date;
    $v->searchable = customfield_forAdmin;
    $v->rangeSearch = TRUE;
    $v->columnIndex = "expirationTime";
    $v->create();
    if( !$v->cid )
    {
        $v->showInList = customfield_forAdmin;
        $v->modify();
    }
    
    // ha uj kategoriat hozunk letre, akkor a tobbi categoriaban common-na tett mezoket bele kell masolni:
    if( $cid )
    {
        $query = "SELECT * FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex LIKE 'col_%'";
        G::load( $commonFields, $query);
        $customCommonFields = array();
        foreach( $commonFields as $field )
        {
            if( empty($customCommonFields[$field->name][$field->type]) )
            {
                $field->cid = $cid;
                unset($field->id);
                create($field);
                $customCommonFields[$field->name][$field->type]=1;
            }
        }
    }
    if( !$fromInstall )
    {
        // a kovetkezo mezoket csak kkor hozzuk letre, ha meg nem leteznek.
        // Akkor letezhetnek, ha az iment mar letrehoztuk oket, mert common-ok:
        if( !$cid || empty($customCommonFields[$lll["title"]][customfield_text]) )
        {
            $v = new ItemField;
            $v->cid = $cid;
            $v->isCommon = !$cid;
            $v->name = $lll["title"];
            $v->type = customfield_text;
            $v->seo = customfield_title;
            $v->showInList = customfield_forAll;
            $v->mandatory = TRUE;
            $v->searchable = customfield_forAll;
            if( !$cid ) $v->columnIndex = "title";
            $v->create();
        }
        if( !$cid || empty($customCommonFields[$lll["description"]][customfield_textarea]) )
        {
            $v = new ItemField;
            $v->cid = $cid;
            $v->isCommon = !$cid;
            $v->name = $lll["description"];
            $v->type = customfield_textarea;
            $v->seo = customfield_description;
            $v->showInList = customfield_forAll;
            $v->innewline=TRUE;
            $v->searchable = customfield_forAll;
            if( !$cid ) $v->columnIndex = "description";
            $v->create();
        }
        if( $cid && empty($customCommonFields[$lll["item_picture"]][customfield_picture]) )
        {
            $v = new ItemField;
            $v->cid = $cid;
            $v->isCommon = FALSE;
            $v->name = $lll["item_picture"];
            $v->type = customfield_picture;
            $v->mainPicture = 1;
            $v->searchable = customfield_forAll;
            $v->showInList = customfield_forAll;
            $v->rowspan = TRUE;
            $v->create();
        }
    }
}

function showNewTool($rights)
{
    global $gorumroll;
    if( $gorumroll->rollid ) return parent::showNewTool($rights);
    else return "";
}

function getNavBarPieces()
{
    global $lll, $gorumroll, $gorumcategory;
    
    $cid = !empty($this->cid) ? $this->cid : $gorumcategory;
    if( ($gorumroll->method=="sortfield_form" && $gorumroll->rollid!==0) || !empty($this->cid) ) 
    {
        G::load( $cat, $cid, "appcategory" );
        $navBarPieces = $cat->getNavBarPieces();
    }
    else $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    $label = $cid ? "itemfield_ttitle_simple" : "itemfield_ttitle_global";
    if( $gorumroll->method=="sortfield_form" ) $navBarPieces[$lll[$label]] = "";
    else
    {
        $navBarPieces[$lll[$label]] = new AppController("field/sortfield_form/$this->cid");
    }
    return $navBarPieces;
}

function getAttr($attr)
{
    global $lll, $useHtmlInCustomFieldNames;
    
    if( isset($this->id) && isset($lll[$this->id]["customfield"][$attr]) ) return $lll[$this->id]["customfield"][$attr];
    if( $attr!="name" ) return $this->$attr;
    if( !empty($this->userField) )
    {
        if( isset($lll[$this->userField]["customfield"][$attr]) ) return $lll[$this->userField]["customfield"][$attr];
        list($columnIndex, $name) = G::getAttr($this->userField, "customfield", "columnIndex", "name");
        if( $name!=$this->name ) return htmlspecialchars($this->name);  
        if( isset($lll["user_$columnIndex"]) ) return $lll["user_$columnIndex"];
        return $useHtmlInCustomFieldNames ? $name : htmlspecialchars($name);
    }
    if( isset($lll["item_$this->columnIndex"]) ) return $lll["item_$this->columnIndex"];
    return $useHtmlInCustomFieldNames ? $this->name : htmlspecialchars($this->name);
    
}

}// end class ItemField

?>
