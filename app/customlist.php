<?php
defined('_NOAH') or die('Restricted access');

$customlist_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "listTitle"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"255",
                "min"=>1,
                "mandatory",
                "list",
                "sorta",
            ),
            "listDescription"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>"40",
                "rows"=>"5",
                "safetext_br",
                "list",
                "in new line",
            ),
            "str"=>array(  // csak hogy a simple search ne legyen benne a customlist create formban
                "type"=>"VARCHAR",
                "form invisible",
                "no column"
            ),
            "listDisplayProperties"=>array(
                "type"=>"INT",
                "section",
                "no column"
            ),
            "primarySort"=>array(
                "type"=>"INT",
                "classselection",
                "get_values_callback"=>"getSortFields()",
                "labelAttr"=>"name",
                "show_relation"=>"primarySort",
                "nothing selected"=>"randomOrder",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "primaryDir"=>array(
                "type"=>"VARCHAR",
                "max"=>4,
                "radio",
                "values"=>array("DESC", "ASC"),
                "default"=>"ASC",
                "cols"=>2,
                "relation"=>"primarySort",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "primaryPersistent"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "relation"=>"primarySort",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "secondarySort"=>array(
                "type"=>"INT",
                "classselection",
                "get_values_callback"=>"getSortFields()",
                "labelAttr"=>"name",
                "show_relation"=>"secondarySort",
                "relation"=>"primarySort",
                "nothing selected"=>"randomOrder",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "secondaryDir"=>array(
                "type"=>"VARCHAR",
                "max"=>4,
                "radio",
                "values"=>array("DESC", "ASC"),
                "cols"=>2,
                "default"=>"ASC",
                "relation"=>"secondarySort",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "secondaryPersistent"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "relation"=>"secondarySort",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "limit"=>array(
                "type"=>"VARCHAR",
                "max"=>10,
                "text",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "columns"=>array(
                "type"=>"TEXT",
                "multipleclassselection",
                "asmselect"=>"{sortable: true}",
                "asmselect_label"=>"selectField",
                "get_values_callback"=>"getColumnFields()",
                "labelAttr"=>"name",
                //"ordered"=>"sortId ASC",
                "size"=>10,
            ),
            "displayedFor"=>array(
                "type"=>"INT",
                "radio",
                "default"=>"1",
                "cols"=>"1",
                "values"=>array(customfield_forAll, customfield_forLoggedin, customfield_forAdmin, customfield_forManager),
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "pages"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>"40",
                "rows"=>"5",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "displayInMenu"=>array(
                "type"=>"INT",
                "radio",
                "values"=>array(0, customlist_loginMenu, customlist_userMenu, customlist_adminMenu, customlist_categoryMenu),
                "cols"=>1,
                "nodefaultselected",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "categorySpecific"=>array(
                "type"=>"INT",
                "conditions"=>array("@\$this->cid==0"=>"bool",  // csak akkor lehet egy search result list category spec, ha a search nem egy adott kategoriara vonatkozik
                                    "@\$this->id==1"=>"form invisible"),
                "default"=>"0",
                "show_relation"=>"categorySpecific",
            ),
            "recursive"=>array(
                "type"=>"INT",
                "conditions"=>array("@\$this->cid==0"=>"bool",
                                    "@\$this->id==1"=>"form invisible"),
                "default"=>"0",
                "relation"=>"categorySpecific",
            ),
            "listStyle"=>array(
                "type"=>"INT",
                "radio",
                "values"=>array(customlist_normal, customlist_scrollable),
                "default"=>"0", // normal
                "cols"=>1,
                "show_relation"=>array(customlist_normal=>"normal", customlist_scrollable=>"scrollable"),
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "loop"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"0", // normal
                "relation"=>"scrollable",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "autoScroll"=>array(
                "type"=>"INT",
                "text",
                "default"=>"60", // 1 minute
                "length"=>"10", 
                "relation"=>"scrollable",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "positionNormal"=>array(
                "type"=>"VARCHAR",
                "max"=>20,
                "checkbox",
                "values"=>array(customlist_aboveContent, customlist_belowContent),
                "cols"=>1,
                "relation"=>"normal",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "positionScrollable"=>array(
                "type"=>"VARCHAR",
                "max"=>20,
                "checkbox",
                "values"=>array(customlist_aboveContent, customlist_belowContent, customlist_top, customlist_bottom, customlist_left, customlist_right),
                "cols"=>1,
                "relation"=>"scrollable",
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "cache"=>array(
                "type"=>"INT",
                "text",
                "default"=>"60", // 1 hour
                "length"=>"10", 
                "conditions"=>array("@\$this->id==1"=>"form invisible"),
            ),
            "customAdListTemplate"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
             ),
            "exportProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "conditions"=>array("@\$gorumroll->method=='modify_form' && @\$this->id<=2"=>"form invisible"),
            ),
            "exportFormat"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"1",
                "conditions"=>array("@\$gorumroll->method=='modify_form' && @\$this->id<=2"=>"form invisible"),
                "show_relation"=>"export"
            ),
            "xmlType"=>array(
                "type"=>"VARCHAR",
                "max"=>20,
                "selection",
                "default"=>"RSS2.0",
                "values"=>array("RSS2.0", "RSS1.0", "ATOM"),
                "conditions"=>array("@\$gorumroll->method=='modify_form' && @\$this->id<=2"=>"form invisible"),
                "relation"=>"export"
            ),
            "exportFields"=>array(
                "type"=>"TEXT",
                "multipleclassselection",
                "asmselect"=>"{sortable: true}",
                "asmselect_label"=>"selectField",
                "get_values_callback"=>"getColumnFields()",
                "labelAttr"=>"name",
                "size"=>10,
                "conditions"=>array("@\$gorumroll->method=='modify_form' && @\$this->id<=2"=>"form invisible"),
                "relation"=>"export"
            ),
        ),
        "primary_key"=>"id",
        "empty_list",
        "smartform",
        "sort_criteria_sql"=>"id ASC",
        "delete_confirm"=>"listTitle",
    );
    
    
class CustomList extends ItemSearch
{

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll;

    hasAdminRights($isAdm);
    $hasRight->generalRight = TRUE;
    if( $method=="delete" )
    {
        $hasRight->generalRight = FALSE;
        $hasRight->objectRight = $isAdm && (isset($this->id) && $this->id!=1 && $this->id!=2);
    }
    else $hasRight->objectRight=($method=="load" || $isAdm);
    if( !$hasRight->objectRight && $giveError ) {
        handleError($lll["permission_denied"]);
    }
}

function getSortFields()
{
    return $this->getColumnFields("FIND_IN_SET(type, '1,3,4,6,7,11')!=0 AND columnIndex!='title'");
}

function getColumnFields($cond = "type!=5")
{
    $query = "SELECT id, name, userField FROM @customfield WHERE ".$this->getFieldsForForm($cond);
    G::load( $fields, $query );
    // ha a user fieldek neve uresen van hagyva, ki kell olvasni a megfelelo user fieldbol:
    for( $i=0; $i<count($fields); $i++ )
    {
        if( !$fields[$i]->name && $fields[$i]->userField )
        {
            $fields[$i]->name = G::getAttr($fields[$i]->userField, "customfield", "name");
        }
    }
    return $fields;
}

function getFieldsForForm($typeCond)
{
    global $gorumroll;
    
    $cid = $gorumroll->method=="create_form" ? $gorumroll->rollid : $this->cid;
    $where = "$typeCond AND cid='".quoteSQL($cid)."'";
    if( !$cid ) $where.=" AND isCommon=1";
    return $where;
}

function getListSelect()
{
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));     
    
    return "SELECT * FROM @search WHERE uid=0";
}

function create($fromInstall=FALSE)
{    
    global $lll, $customlist_typ;
    
    //if( !$this->listTitle ) return Roll::setFormInvalid("mandatoryField", $lll["customlist_listTitle"]);
    $this->str="";
    if( !isset($this->relationBetweenFields) ) $this->relationBetweenFields=search_allFields;
    if( !isset($this->cid) ) $this->cid=0;
    $this->makeSearchQuery($fromInstall);
    unset($customlist_typ["attributes"]["creationtime"]);
    Object::create();
    if( !Roll::isFormInvalid() )
    {
        $this->nextAction = new AppController("customlist/list");
    }
}

function modify($fromInstall=FALSE)
{        
    $this->str="";
    $this->makeSearchQuery($fromInstall);
    Object::modify();
    if( !Roll::isFormInvalid() )
    {
        if( !$fromInstall ) $this->nextAction = new AppController("customlist/list");
        if( $this->cache ) CacheManager::resetCache($this->id, TRUE, FALSE);
    }
}

function modifyForm()
{
    global $gorumroll;

    if( $gorumroll->rollid!=1 )  // special custom list for search result lists
    {
        $this->cid = G::getAttr($gorumroll->rollid, "search", "cid");
        $this->activateVariableFields();
    }
    else $this->cid=0;
    Object::modifyForm(); 
}

function activateVariableFields()
{
    global $search_typ, $customlist_typ;

    $typ = & $this->getTypeInfo(TRUE);
    $keys=array_keys($customlist_typ["attributes"]);
    while( $keys[0]!="listDisplayProperties" ) $typ["order"][]=array_shift($keys);
    $fields = parent::activateVariableFields();
    // search_typ attributumait bemasoljuk customlist_typ-be:
    foreach( $search_typ["attributes"] as $attr=>$attrInfo ) 
    {
        if( !isset($typ["attributes"][$attr]) ) $typ["attributes"][$attr] = $attrInfo;
    }
    $typ["order"] = array_merge($typ["order"], $keys);  // a maradekot is hozzaadjuk
    return $fields;
}

function addCustomColumns()
{
    executeQuery("ALTER TABLE @search 
      ADD `listTitle` varchar(255) NOT NULL default '',
      ADD `listDescription` TEXT NOT NULL,
      ADD `iid` int(11) NOT NULL,
      ADD `creationtime` datetime NOT NULL,
      ADD `creationtime_from` datetime NOT NULL,
      ADD `creationtime_to` datetime NOT NULL,
      ADD `status` int(11) NOT NULL default '-1',
      ADD `clicked` varchar(255) NOT NULL default '',
      ADD `responded` varchar(255) NOT NULL default '',
      ADD `title` varchar(255) NOT NULL default '',
      ADD `description` varchar(255) NOT NULL default '',
      ADD `ownerName` TEXT NOT NULL,
      ADD `expirationTime` datetime NOT NULL,
      ADD `expirationTime_from` datetime NOT NULL,
      ADD `expirationTime_to` datetime NOT NULL,
      ADD `primarySort` int(11) NOT NULL,
      ADD `primaryDir` varchar(4) NOT NULL default 'ASC',
      ADD `primaryPersistent` int(11) NOT NULL,
      ADD `secondarySort` int(11) NOT NULL,
      ADD `secondaryDir` varchar(4) NOT NULL default 'ASC',
      ADD `secondaryPersistent` int(11) NOT NULL,
      ADD `limit` varchar(10) NOT NULL,
      ADD `columns` TEXT NOT NULL,
      ADD `displayedFor` int(11) NOT NULL default '1',
      ADD `pages` TEXT NOT NULL,
      ADD `displayInMenu` int(11) NOT NULL,
      ADD `categorySpecific` int(11) NOT NULL,
      ADD `recursive`int(11)  NOT NULL,
      ADD `listStyle` int(11) NOT NULL,
      ADD `loop` int(11) NOT NULL default 0,
      ADD `autoScroll` int(11) NOT NULL default 60,
      ADD `cache` int(11) NOT NULL default 60,
      ADD `positionNormal` varchar(10) NOT NULL,
      ADD `positionScrollable` varchar(10) NOT NULL,
      ADD `exportFields` TEXT NOT NULL,
      ADD `exportFormat` int(11) NOT NULL DEFAULT 1,
      ADD `xmlType` varchar(20) NOT NULL DEFAULT 'RSS2.0',
      ADD `customAdListTemplate` VARCHAR( 255 ) NOT NULL
      ");
    $customSearchIndexes = CustomField::getCustomColumnIndexes("search");
    $newIndexes = array();
    foreach( CustomField::getCustomColumnIndexes("item") as $ci )
    {
        if( !in_array($ci, $customSearchIndexes) ) $newIndexes[]=$ci;
    }
    $pieces = array_map(create_function('$v', 'return "ADD $v TEXT NOT NULL";'), $newIndexes);
    if( count($pieces) )executeQuery("ALTER TABLE @search ".implode(",", $pieces));    
}

function addDefaultCustomLists()
{
    global $includeDumpJs;
    
    $v1 = ItemField::getFixOrCommonField('title');
    $v2 = ItemField::getFixOrCommonField('cName');
    $v3 = ItemField::getFixOrCommonField('creationtime');
    $v4 = ItemField::getFixOrCommonField('description');
    $v5 = ItemField::getFixOrCommonField('clicked');
    $v6 = ItemField::getFixOrCommonField('responded');
    $v7 = ItemField::getFixOrCommonField('ownerName');
    // Kivalasztjuk a common picture field-et, ha letezik:
    $fields = ItemField::getFixAndCommonFields();
    for( $pictureField=0, $i=0; 
         !$pictureField && $i<count($fields); 
         $pictureField = $fields[$i++]->type==customfield_picture ? $fields[$i-1]->id : 0 );
    $cl = new CustomList;
    $cl->listTitle = "Search result list";
    $cl->listDescription = "This is a special custom list you can use to configure the columns of a non-category specific search result list.";
    // sort by date
    $cl->primarySort = $v3->id;
    $cl->primaryDir = "DESC";
    $cl->secondarySort = $v3->id;
    $cl->secondaryDir = "DESC";
    $cl->columns = "$v1->id,$v2->id,$v4->id,$v7->id".($pictureField ? ",$pictureField" : "");
    $cl->create(TRUE);
    
    $cl = new CustomList;
    $cl->listTitle = "My ads";
    $cl->listDescription = "The list of ads of a user. This means both the 'My ads' list (the list of the currently logged in user), and the 'Advertisements of user XY' lists.";
    $cl->ownerName = array(0);
    $cl->primarySort = $v3->id;
    $cl->primaryDir = "DESC";
    $cl->columns = "$v1->id,$v2->id,$v5->id,$v6->id,$v4->id";
    $cl->displayedFor = customfield_forLoggedin;
    $cl->displayInMenu = customlist_userMenu;
    $cl->relationBetweenFields = search_allFields;
    $cl->create(TRUE);
    
    $cl = new CustomList;
    $cl->listTitle = "Recent ads";
    $cl->listDescription = "List of 100 most recent ads";
    $cl->status = array(1);
    $cl->primarySort = $v3->id;
    $cl->primaryDir = "DESC";
    $cl->limit = '100';
    $cl->columns = "$v1->id,$v2->id,$v3->id,$v4->id".($pictureField ? ",$pictureField" : "");
    $cl->displayedFor = customfield_forAll;
    $cl->displayInMenu = customlist_loginMenu;
    $cl->create(TRUE);
    
    $cl = new CustomList;
    $cl->listTitle = "Popular ads";
    $cl->listDescription = "List of 100 most viewed ads";
    $cl->status = array(1);
    $cl->primarySort = $v5->id;
    $cl->primaryDir = "DESC";
    $cl->secondarySort = $v3->id;
    $cl->secondaryDir = "DESC";
    $cl->limit = '100';
    $cl->columns = "$v1->id,$v2->id,$v5->id,$v6->id,$v4->id".($pictureField ? ",$pictureField" : "");
    $cl->displayedFor = customfield_forAll;
    $cl->displayInMenu = customlist_loginMenu;
    $cl->create(TRUE);
    
    $cl = new CustomList;
    $cl->listTitle = "Pending ads";
    $cl->listDescription = "The list of ads that you haven't approved yet.";
    $cl->status = array(0);
    $cl->primarySort = $v3->id;
    $cl->primaryDir = "ASC";
    $cl->columns = "$v1->id,$v2->id,$v3->id,$v7->id,$v4->id";
    $cl->displayedFor = customfield_forManager;
    $cl->displayInMenu = customlist_loginMenu;
    $cl->create(TRUE);
    
    $cl = new CustomList;
    $cl->listTitle = "Featured ads: Gold level";
    $cl->listDescription = "This is a featured ad list that demonstrate a way you can set up the 'featured ads' feature yourself. It contains all the ads where the 'Promotion level' common custom field has been set to 'Gold'.";
    $cl->status = array(1);
    $cl->columns = "$v1->id".($pictureField ? ",$pictureField" : "").",$v4->id";
    foreach( $fields as $field ) if( $field->name=="Promotion level" ) $cl->{$field->columnIndex} = array("Gold");
    $cl->displayedFor = customfield_forAdmin;
    $cl->listStyle = customlist_scrollable;
    $cl->positionScrollable = customlist_aboveContent;
    $cl->pages = $includeDumpJs ? "" : "/";
    $cl->limit = 10;
    $cl->relationBetweenFields = search_allFields;
    $cl->create(TRUE);
        
    // vegig kell menni a common fieldeken
    reset($fields);
    foreach( $fields as $field )
    {
        if( strstr($field->columnIndex, "col_") ) $field->updateDefaultOfSelectionTypeFieldOfCustomList(); 
    }
}        

function showDetailsTool()
{
    return "";
}

function showListVal($attr)
{
    global $lll;

    $s="";
    if( ($s=parent::showListVal($attr))!==FALSE ) return $s;
    if ($attr=="cid") // a modify formban readonly a cid
    {
        if( !$this->cid ) return $lll["allCategories"];
        else return htmlspecialchars(G::getAttr($this->cid, "appcategory", "name"));
    }
    elseif ($attr=="listTitle")
    {
        if( $this->id==1 ) return parent::showListVal($attr, "safetext");
        else return parent::showListVal($attr, "detailslink");
    }
    else $s=Object::showListVal($attr, "safetext");
    return $s;
}

function showDetails($whereFields="", $withLoad=TRUE, $elementName="")
{
    global $gorumroll;
    
    $ctrl = new AppController("item_search/list/$gorumroll->rollid");
    $gorumroll->processMethod($ctrl, $elementName );
}

// az adott customlist objekltum alapjan beallitjuk, hogy az item lista hogy nezzen ki.
// Mivel ezt az is nbefolyasolja, hogy az item lista hol jelenik meg az oldalon (vizszintesen, vagy fuggolegesen),
// ezert az $elementName-et is at kell ida adni:
function setupCustomListAppearance( $elementName )
{
    global $lll, $item_typ, $jQueryLib, $curvyCorners, $gorumroll;
    
    // ha tobb item list is van egy oldalon, mindegyiknek teljesen kulonbozo typeinfo-ja lehet:
    include("item_typ.php");  // resetting $item_typ
    CustomField::addCustomColumns("item");
    $lll["item_search_ttitle"] = htmlspecialchars($this->listTitle);
    $columns = $gorumroll->list=="export" ? $this->exportFields : $this->columns;
    G::load( $columns, "SELECT * FROM @itemfield WHERE FIND_IN_SET(id, '$columns')!=0" );
    $item = new Item;
    $item_typ["listOrder"] = array();
    foreach( explode(",", $this->columns) as $id )
    {
        for( $i=0; $i<count($columns); $i++ )
        {
            if( $columns[$i]->id==$id ) 
            {
                $columns[$i]->showInList=1;
                if( !$columns[$i]->customListPlacement ) $item_typ["listOrder"][] =$columns[$i]->columnIndex;
                $item_typ["attributes"][$columns[$i]->columnIndex][] = "list";
                if( $columns[$i]->customListPlacement ) $item_typ["attributes"][$columns[$i]->columnIndex][] = "customListPlacement";
                break;
            }
        }
    }
    $item->fields =& $columns;
    $item->cid = $this->cid;
    $item->activateVariableFields();
    $item->fields = 0;
    CustomList::getSortingSql($this->primarySort, $this->primaryDir, $this->primaryPersistent, 
                         $this->secondarySort, $this->secondaryDir, $this->secondaryPersistent); 
    if( $specialSortAttrs = $item->getSpecialSortAttrs($this->cid ? 0 : 1, $this->cid) )
    {
        $this->query = str_replace( "n.*", "n.* $specialSortAttrs", $this->query);
    }
    if( $this->limit ) $item_typ["limit"] = $this->limit;
    if( $this->listStyle!=customlist_scrollable && $gorumroll->list!="export" )
    {
        $_S = new AppSettings();
        if( $this->customAdListTemplate ) $item_typ["listTemplate"] = $this->customAdListTemplate;
        elseif( $_S->customAdListTemplate ) $item_typ["listTemplate"] = $_S->customAdListTemplate;
    }
    //var_dump($item_typ);
    if( $this->listStyle==customlist_scrollable && $gorumroll->list!="export" ) 
    {
        // Neheny szajton, az orientattiont egyszeruen nem tudtam a typeInfoban atvinni a 
        // item_scrollablepresentationbe - kenytelen voltan globalba tenni:
        global $scrollablePlacement, $orientation;
        
        if( !isset($item_typ["listTemplate"]) ) $item_typ["listTemplate"] = "scrollable_widget.tpl.php";
        $item_typ["listPresentationClassName"]="ItemScrollablePresentation";
        $params = "";
        $scrollablePlacement = $elementName;
        if( $elementName=="customListLeft"  || $elementName=="customListRight" )
        {
            $item_typ["scrollableOrientation"]=$orientation="vertical";
            $scrollableParams = "vertical: true";
        }
        else 
        {
            $scrollableParams = "vertical: false";
            $item_typ["scrollableOrientation"]=$orientation="horizontal";
        }
        if( $this->loop ) $scrollableParams.=", loop: true";
        include_once(NOAH_APP . "/item_scrollablepresentation.php");
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.dimensions.js");
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.center.js");
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.scrollable.js");
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.em.js");
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.jscrollpane.js");
        JavaScript::addInclude(JS_DIR . "/scrollable.js");
        JavaScript::addCss(CSS_DIR . "/scrollable.css");
        JavaScript::addCss(GORUM_JS_DIR . "/jquery/jscrollpane.css");
        JavaScript::addOnload("$.noah.globalScrollableOnLoad();", "scrollable");
        JavaScript::addOnload("$.noah.scrollableOnLoad(" . G::js($this->id, $elementName, $scrollableParams) . ");");
        if( $this->autoScroll )
        {
            JavaScript::addOnload("$.noah.autoscrollOnLoad(" . G::js($this->id, $elementName, $this->autoScroll) . ");");
        }
    }
}

function getSortingSql($primarySort, $primaryDir, $primaryPersistent, $secondarySort, $secondaryDir, $secondaryPersistent)
{
    global $item_typ;
    
    if( $primarySort )
    {
        $item_typ["sort_criteria_sql"] = G::getAttr($primarySort, "itemfield", "columnIndex");
        if( $item_typ["sort_criteria_sql"]=="ownerName" ) $item_typ["sort_criteria_sql"]="ownerId";
        $item_typ["sort_criteria_sql"] .= " $primaryDir";
        if( $primaryPersistent ) $item_typ["sort_criteria_sql_pers"] = $item_typ["sort_criteria_sql"];
    }
    else $item_typ["sort_criteria_sql"] = "RAND()";
    if( $secondarySort )
    {
        $attr = G::getAttr($secondarySort, "itemfield", "columnIndex");
        if( $attr=="ownerName" ) $attr="ownerId";
        $item_typ["sort_criteria_sql"] .= ", " . $attr;
        $item_typ["sort_criteria_sql"] .= " $secondaryDir";
        // secondaryPersistent-nek csak akkor van ertelme, ha primaryPersistent-et is becsekkeltek:
        if( $primaryPersistent && $secondaryPersistent ) $item_typ["sort_criteria_sql_pers"] = $item_typ["sort_criteria_sql"];
    }
    elseif( $primarySort ) $item_typ["sort_criteria_sql"].=", RAND()";
}

function & getListToPageAssignment()
{
    global $gorumroll;
    static $listToPageAssignment = 0;
    if( $listToPageAssignment ) return $listToPageAssignment;
    
    $listToPageAssignment = array_fill(0, 6, array());
    loadObjectsSql( $lists = new CustomList, "SELECT * FROM @search WHERE pages!='' ORDER BY id ASC", $lists );
    $lists = array_filter($lists, array('customlist', 'customListFilter'));
    $qs = trim($gorumroll->queryString, "/");
    if (($gorumroll->list == "appcategory") && ($gorumroll->rollid > 0))
    {
        $qs = 'list/'.$gorumroll->rollid;
    } elseif ($gorumroll->list == "item")
    {
        $qs = 'item/'.$gorumroll->rollid;
    } 

    foreach( $lists as $list )
    {
        $condArr = explode("\n", $list->pages);
        $composedConditionYes = array();
        // ha a customlist "details" page-et nezzuk, ne legyen rajta a list meg egyszer:
        $composedConditionNo = array("\$qs=='customlist/$list->id'");
        foreach( $condArr as $condPiece )
        {
            $condPiece = trim(str_replace("'", "", $condPiece));
            if( $not = ($condPiece[0]=="!") ) $condPiece = substr($condPiece, 1);
            $condPiece = trim($condPiece, "/");
            if( strstr($condPiece, "*") )
            {
                $condPiece = str_replace("*", "[^/]*", $condPiece);
                $condPiece = "preg_match('{".$condPiece."}', \$qs)";
            }
            else $condPiece = "\$qs=='$condPiece'";
            if( $not ) $composedConditionNo[] = $condPiece;
            else $composedConditionYes[] = $condPiece;
        }
        $composedCondition = implode(" || ", $composedConditionYes);
        if( $composedCondition ) $composedCondition="($composedCondition) && ";
        $composedCondition.="!(" . implode(" || ", $composedConditionNo) . ")";
        //echo("$qs<br>$composedCondition<br>");
        eval( "\$cond = $composedCondition;" );
        if( $cond ) 
        {
            if( $list->listStyle==customlist_normal ) $positionAttr="positionNormal";
            elseif( $list->listStyle==customlist_scrollable ) $positionAttr="positionScrollable";
            foreach( explode(",", $list->$positionAttr) as $position )
            {
                $listToPageAssignment[$position][]=$list->id;
            }
        }
    }
    CustomList::addSidebarDependentCss($listToPageAssignment);
    return $listToPageAssignment;
}

function addSidebarDependentCss($listToPageAssignment)
{
    if( !count($listToPageAssignment[customlist_left]) && !count($listToPageAssignment[customlist_right]) )
    {        
        View::assign("mainClass", 'main_withoutSidebar');
        View::assign("outerMainClass", 'outerMain_withoutSidebar');
    }
    elseif( count($listToPageAssignment[customlist_left]) )
    {
        View::assign("mainClass", 'main_twoSidebars');
        View::assign("outerMainClass", 'outerMain_twoSidebars');
    }
    elseif( count($listToPageAssignment[customlist_right]) )
    {
        View::assign("mainClass", 'main_rightSidebar');
        View::assign("outerMainClass", 'outerMain_rightSidebar');
    }
    if( !count($listToPageAssignment[customlist_left]) )
    {        
        JavaScript::addOnload("
            $('#sidebarLeft').hide();
        "); 
    }    
    if( !count($listToPageAssignment[customlist_right]) )
    {        
        JavaScript::addOnload("
            $('#sidebarRight').hide();
        "); 
    }    
}

function getList( $position )
{
    global $gorumview, $gorumroll, $ajaxMethods;
    
    if( !class_exists("rss") ) return;
    $positionMapping=array("customListAboveContent","customListBelowContent", "customListTop","customListBottom","customListLeft","customListRight");
    $listToPageAssignment =& CustomList::getListToPageAssignment();
    $ajaxMethods["item_search"]["showhtmllist"]=array();
    foreach( $listToPageAssignment[$position] as $listId )
    {
        // hogy a page title, description es keyword-be ne zavarjon be:
        $ajaxMethods["item_search"]["showhtmllist"][]=$listId;
        $ctrl = new AppController("customlist/$listId");
        $gorumroll->processMethod($ctrl, $positionMapping[$position] );
    }
}

function customListFilter( $v )
{
    return AppSettings::isEnabled($v->displayedFor);
}

function delete()
{
    load($this);
    parent::delete();
    if( $this->cache ) CacheManager::resetCache($this->id, TRUE, FALSE);
}

function applyCategoryFilterToSearchQuery()
{
    global $gorumcategory;
    
    if( $this->recursive && $gorumcategory )
    {
        $wholeName = G::getAttr( $gorumcategory, "appcategory", "wholeName" );
        $this->query.=" AND c.wholeName LIKE '".quoteSQL($wholeName)."%'";
    }
    elseif( $this->categorySpecific && $gorumcategory )
    {
        $this->query.=" AND n.cid='".quoteSQL($gorumcategory)."'";
    }
}

function showDelTool($rights)
{
    global $lll;

    $s = parent::showDelTool($rights);
    if( $this->exportFormat && class_exists("rss")) 
    {
        if( $s ) $s.=" | ";
        $ctrl = new AppController("export/create/$this->id");
        $s.=$ctrl->generAnchor($lll["export"]);
    }
    return $s;
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
    
    $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    $navBarPieces[$lll["customlist_ttitle"]] = $gorumroll->method=="showhtmllist" ? "" : new AppController("customlist/list");
    return $navBarPieces;
}
}

?>