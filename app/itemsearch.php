<?php
defined('_NOAH') or die('Restricted access');

class ItemSearch extends Search
{
    
function getManagedTable() { return "item"; }

function getSelectFromTree()
{
    return Item::getSelectFromTree(TRUE /*$forTheSearchForm*/);
}

function createForm($elementName="")
{
    global $gorumroll, $lll;

    $_S = new AppSettings();
    $this->cid=$gorumroll->rollid;
    $this->activateVariableFields();
    Object::createForm($elementName); 
    JavaScript::addInclude(GORUM_JS_DIR . "/core.js");  // a multipleSelectionManager miatt
    $_S->handleCategorySelect("itemsearch-create_form");
}

function makeSearchQuery($fromInstall=FALSE)
{
    $cond = $this->makeSearchQueryAdvanced($fromInstall);
    $userQueryPieces = ItemField::getUserQueryPieces($this->cid);
    $this->query = "SELECT n.*, c.wholeName AS cName, c.permaLink AS catPermaLink, c.immediateAppear AS immediateAppear $userQueryPieces[as]
                    FROM @item AS n, @category AS c $userQueryPieces[from]
                    WHERE $userQueryPieces[where] c.id=n.cid";
    // alapbol csak az aktiv itemek kozt keresunk, kiveve ha admin direct valami mast ad meg a search formben:                
    if( !isset($this->status) ) $this->query.=" AND n.status='1'";
    if( $cond ) $this->query.=" AND $cond";
    else $this->query.=" AND 0";  // ha nincs feltetel, semmit se mutatunk
}

function makeSearchQuerySimple()
{
    // Ha nem egy adott kategoriara vonatkozik a kereses, akkor az
    // osszes szoba joheto kategoriaban keresunk:
    if( !$this->str ) return "";  // ures -> eredmeny az osszes ad
    $word = quoteSQL($this->str);
    G::load( $categories, "SELECT id FROM @category WHERE allowAd=1 AND directItemNum>0" );
    $condOut = array();
    foreach( $categories as $cat )
    {
        $condIn = $this->getSimpleCustomFieldConditions($word, $cat->id);
        if( count($condIn) ) $condOut[]="(cid='$cat->id' AND (" . implode(" OR ", $condIn) . "))";
    }
    if( count($condOut) ) return "(".implode(" OR ", $condOut).")";
    else return "";
}

function activateVariableFields()
{
    $typ = & $this->getTypeInfo(TRUE);
    $table = $this->getManagedTable();
    $obj = new $table;
    $obj->cid = empty($this->cid) ? 0 : $this->cid;
    if( $obj->cid ) list($recursive, $allowAd) = G::getAttr($obj->cid, "appcategory", "recursive", "allowAd");
    $showAdvancedSearch = (!$obj->cid || (!$allowAd && !$recursive));
    $showCategorySearch = FALSE;
    $typ["order"][]="str";
    if( $showAdvancedSearch ) $fields = ItemField::getFixAndCommonFields();
    else $fields = $obj->getFields();
    foreach( $fields as $field )
    {
        // a cName searchable attributuma hatarozza meg, hogy van-e kategoria szelektor a search formban:
        if( $field->columnIndex=="cName" ) 
        {
            $showCategorySearch = $field->displayInSearchFormCondition();
            break;
        }
    }
    if( $showCategorySearch )
    {
        $typ["order"][]="categorySearch";
        $typ["order"][]="cid";
    }
    if( $showAdvancedSearch ) 
    {
        $typ["order"][]="advancedSearch";
    }
    foreach( $fields as $field )
    {
        if( $field->columnIndex!="cName" ) $this->activateField($field);
    }
    // hogy a keresesek alapbol az aktiv itemekre menjenek:
    if( isset($typ["attributes"]["status"]) ) $typ["attributes"]["status"]["default"] = 1;
    $typ["order"][]="relationBetweenFields";
    return $fields;
}

function deleteColumn( $field )
{
    if( $field->isCommon ) $cidCond = "";
    else $cidCond = " AND cid=#cid#";
    // ha nem common a custom field, amit torlunk, csak azoknak a custom listeknek az oszlopaibol kell torolni,
    // amik a field categoriajara specifikusak:
    $query=array("SELECT id, `columns`, cache FROM @search WHERE FIND_IN_SET(#id#, `columns`)!=0 $cidCond", "columns", $field->id, "columns", $field->cid);
    loadObjectsSql($lists = new CustomList, $query, $lists);
    foreach( $lists as $l )
    {
        $f = preg_replace("{(,)?\\b$this->id\\b(?(1)|(,|$))}", "", $l->columns);
        executeQuery(array("UPDATE @search SET `columns`=#f# WHERE id=#id#", "columns", $f, $l->id));
        if( $l->cache ) CacheManager::resetCache($l->id, TRUE, FALSE);
    }
    $query=array("SELECT *, '' AS str FROM @search WHERE query LIKE '%$field->columnIndex%' $cidCond", $field->cid);
    $lists = new CustomList;
    $lists->cid = $field->cid;
    $lists->activateVariableFields();
    loadObjectsSql($lists, $query, $lists);
    foreach( $lists as $l )
    {
        unset($l->{$field->columnIndex});
        $l->makeSearchQuery(TRUE);
        modify($l);
        if( $l->cache ) CacheManager::resetCache($l->id, TRUE, FALSE);
    }
}

}
?>
