<?php
defined('_NOAH') or die('Restricted access');
$search_typ =  
    array(
        "attributes"=>array(   
            "id"=>array(
                "type"=>"INT",
                "form hidden",
                "auto increment",
            ),            
            "uid"=>array(
                "type"=>"INT",
            ),            
            "str"=>array(
                "type"=>"VARCHAR",
                "max" =>"200",
                "text",
                "no column",
                "modify_form: form invisible"
            ),
            "advancedSearch"=>array(
                "type"=>"INT",
                "section",
                "no column",
            ),
            "name"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
                "mandatory",
                "create_form: form invisible",
                "list"
            ),            
            "autoNotify"=>array(
                "type"=>"INT",
                "bool",
                "create_form: form invisible",
                "list"
            ),            
            "query"=>array(
                "type"=>"TEXT",
                "form invisible"
            ),          
            "relationBetweenFields"=>array(
                "type"=>"INT",
                "selection",
                //"conditions"=>array("!empty(\$this->cid) || \$gorumroll->list=='usersearch'"=>"selection"),
                "values"=>array(search_allFields, search_anyFields),
                "default"=>search_allFields,
             ),
            "userFieldExists"=>array(
                "type"=>"INT",
                "form invisible",
                "no column"
            ),          
            "categorySearch"=>array(
                "type"=>"INT",
                "no column",
                "conditions"=>array("@\$gorumroll->list=='itemsearch' || @\$gorumroll->list=='customlist'"=>"section"),            
            ),
            "cid"=>array(
                "type"=>"INT",
                "class"=>"category",
                "labelAttr"=>"wholeName",
                "nothing selected"=>"allCategories",
                "modify_form: readonly",
                "get_values_callback"=>'getSelectFromTree()',
                "conditions"=>array("isset(\$gorumroll) && (\$gorumroll->list=='itemsearch' || \$gorumroll->list=='customlist') &&            
                                     \$gorumroll->method=='create_form' && \$gorumroll->rollid && \$_S->cascadingCategorySelectEnabled()"=>"form hidden",
                                    "isset(\$gorumroll) && (\$gorumroll->list=='itemsearch' || \$gorumroll->list=='customlist') &&            
                                     (\$gorumroll->method!='create_form' || !\$gorumroll->rollid || !\$_S->cascadingCategorySelectEnabled())"=>"classselection")
            ),
        ),    
        "primary_key"=>"id, name",
        "conditions"=>array("isset(\$gorumroll) && \$gorumroll->method=='create_form' && 
                            !\$gorumroll->rollid && 
                            \$_S->cascadingCategorySelectEnabled()"=>array("submit"=>array("continue", "cancel")))
    );

class Search extends Object
{

function get_table() { return "search"; }

// ha a query-ben letezik userField, beallitja a userFieldExists valtozot,
// plusz viszsaadja az adott mezo (user, vagy item) query-beli meghatarozasat:
function setUserFieldExists( $field )
{
    if( !empty($field->userField) )
    {
        $userColumnIndex = G::getAttr( $field->userField, "customfield", "columnIndex" );
        $this->userFieldExists = TRUE;
        return "u.$userColumnIndex";
    }
    return "n.$field->columnIndex";
}

function createForm()
{
    global $gorumroll;
    
    $_S = new AppSettings();
    $ctrl = new AppController("itemsearch/create_form/$gorumroll->rollid");
    $gorumroll->processMethod($ctrl);
    if( $_S->isEnabled("enableUserSearch") && class_exists("response") )
    {
        $ctrl = new AppController("usersearch/create_form");
        $gorumroll->processMethod($ctrl);
    }
}

function create()
{
    global $gorumuser, $search_typ;
    
    // a search nem mukodik cookie-k nelkul:
    if( !isset($_COOKIE["globalUserId"]) ) return;
    // eloszor kitoroljuk, ha mar letezik:
    $this->uid=$gorumuser->id;
    executeQuery(array("DELETE FROM @search WHERE uid=#uid# AND name=''", $this->uid));
    // TODO: valid
    $this->makeSearchQuery();
    unset($search_typ["attributes"]["creationtime"]);
    //var_dump($this);die();
    parent::create();
    $this->nextAction = new AppController($this->getManagedTable(). "_search/list");
    Roll::setInfoText("");
}

function string2KeyedArray($string) 
{ 

  $words = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[\s,]+/", $string, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); 
  return $words; 
} 

function getSimpleCustomFieldConditions( $word, $cid=0 ) 
{ 
    $table = $this->getManagedTable(); 
    $obj = new $table; 
    $obj->cid = $cid; 
    $cond=array(); 
    foreach( $obj->getFields() as $v ) 
    { 
        if( $v->displayInSearchFormCondition() && $v->columnIndex!="cName" && $v->columnIndex!="ownerName" && 
            ($v->type==customfield_text || $v->type==customfield_textarea || 
             $v->type==customfield_selection || $v->type==customfield_multipleselection || $v->type==customfield_checkbox) ) 
        { 
            $columnIndexField = $this->setUserFieldExists($v); 
        
             $srch = $this->string2KeyedArray($word); 
             foreach ($srch as $val) 
             { 
                $cond[] = "$columnIndexField LIKE '%$val%'"; 
             } 
        } 
    } 
    return $cond; 
} 

function makeSearchQueryAdvanced($fromInstall=FALSE)
{
    global $gorumroll;
    
    if( $fromInstall ) $cid = $this->cid;
    elseif( $gorumroll->method=="modify" ) $cid = $this->cid = isset($_POST["cid"]) ? $_POST["cid"] : 0;
    elseif( $gorumroll->method=="create" ) $cid = $this->cid = $gorumroll->rollid;
    else $cid = $this->cid = 0;

    $fields = $this->activateVariableFields();
    // az install soran nem form submit reven hivodik a create - ezert initClassVars-ra nincs szukseg:
    if( !$fromInstall )
    {
        $this->initClassVars();
        LocationHistory::savePost($this);
    }
    $condition = array();
    if( $word = @quoteSQL($this->str) )
    {
        if( $cid ) $condition[]="(" . implode(" OR ", $this->getSimpleCustomFieldConditions( $word, $cid )) . ")";
        elseif( $simpleCond = $this->makeSearchQuerySimple() ) $condition[]=$simpleCond;
    }
    $condition = array_merge( $condition, $this->getAdvancedCustomFieldConditions( $fields ));
    if( $cid )
    {
        list($recursive, $wholeName) = G::getAttr($cid, "appcategory", "recursive", "wholeName");
        $cidCond = $recursive ? "wholeName LIKE '".quoteSQL($wholeName)."%'" : "cid='".quoteSQL($cid)."'";
    }
    else $cidCond="";
    if( $this->relationBetweenFields==search_allFields )
    {
        if( $cid ) $condition[]=$cidCond;
        return implode(" AND ", $condition);
    }
    elseif( count($condition) ) 
    {
        if( $cid ) return "($cidCond AND (".implode(" OR ", $condition)."))";
        else return "(".implode(" OR ", $condition).")";
    }
    else return $cidCond;
}

function getAdvancedCustomFieldConditions( &$fields )
{
    $cond=array();
    foreach( $fields as $v )
    {
        if( !$v->displayInSearchFormCondition() || !isset($this->{$v->columnIndex}) ) continue;
        if( $v->columnIndex=="title" || $v->columnIndex=="description" )
        {
            if( $tdCond = $this->getTitleDescriptionCondition($v->columnIndex) ) $cond[]=$tdCond;
            continue;
        }
        $columnIndexField = $this->setUserFieldExists($v);
        $subCond=array();
        switch( $v->type )
        {
        case customfield_text:
            // pl.: $-1234,345.99-$698.00
            if( $v->columnIndex=="iid" ) $columnIndexField="n.id";
            if( $v->rangeSearch )
            {
                if( ereg("^[\$]*([\-]*[0-9\.\,]+)[ ]*-[ ]*[\$]*([\-]*[0-9\.\,]+)", $this->{$v->columnIndex}, $regs) )
                {
                    $cond[]="(0+$columnIndexField>=$regs[1] AND 0+$columnIndexField<=$regs[2])";
                    break;
                }
                elseif( ereg("^[\$]*([\-]*[0-9\.\,]+)[ ]*-", $this->{$v->columnIndex}, $regs) )
                {
                    $cond[]="0+$columnIndexField>=$regs[1]";
                    break;
                }
                elseif( ereg("[ ]*-[ ]*[\$]*([\-]*[0-9\.\,]+)", $this->{$v->columnIndex}, $regs) )
                {
                    $cond[]="0+$columnIndexField<=$regs[1]";
                    break;
                }
            }
        case customfield_text:
        case customfield_textarea:
            // hogy ne akadjunk ossze a hiddenben erkezo 'id' valueval a custom list modify eseten:
            $val = $v->columnIndex=="id" ? $this->iid : $this->{$v->columnIndex};
            if( $val!=='' )
            {
                $word = quoteSQL($val);
                if( $v->subType==customfield_alnum || $v->type==customfield_textarea ) $cond[]="$columnIndexField LIKE '%$word%'";
                else $cond[]="$columnIndexField='$word'";
            }
            break;
        case customfield_bool:
            if( ($val=$this->{$v->columnIndex})!=-1 ) // ha nem 'Any'
            {
                if( $v->type==customfield_bool && $val==0 ) $val="";  // mert a FALSE bool ertekek a TEXT fieldben ""-kent tarolodnak
                $cond[]="$columnIndexField='$val'";
            }
            break;
        case customfield_selection:
        case customfield_multipleselection:
        case customfield_checkbox:
            $enumVal = $this->{$v->columnIndex};
            if( $enumVal==-1 || $enumVal==="" ) break;
            if( is_string($enumVal) ) 
            {
                //$enumVal = $v->type==customfield_selection ? array($enumVal) :  splitByCommas($enumVal, FALSE);
                $enumVal = splitByCommas($enumVal, FALSE);
            }
            $enumVal = array_map(create_function('$v', 'return str_replace(",", ",,", $v);'), $enumVal);
            if( !($count = count($enumVal)) ) break;
            
            if( $v->columnIndex=="ownerName" )
            {
                // ha egy db. 0 erkezik, az a gorumjuzert jeloli ('My ads' custom list),
                // akkor viszont itt csak egy helyettesitot teszunk a querybe:
                if( $count==1 && !$enumVal[0] ) $cond[]="n.ownerId=#gorumuser#";
                elseif( $count==1 ) $cond[]="n.ownerId='".quoteSQL($enumVal[0])."'";
                else
                {
                    foreach( $enumVal as $val ) 
                    {
                        $subCond[] = $val ? quoteSQL($val) : "'#gorumuser#'";
                    }
                    $cond[]="FIND_IN_SET(n.ownerId, '".implode(",", $subCond)."')!=0";
                }
                break;
            }
            
            foreach( $enumVal as $val ) 
            {
                if( $v->type==customfield_selection ) $subCond[]="$columnIndexField='".quoteSQL($val)."'";
                else $subCond[]=$this->composeSearchRegexp($columnIndexField, $val);
            }
            $cond[]="(".implode(" OR ", $subCond).")";
            break;
        case customfield_date:
            if( $dateCond = $this->getDateCondition($v->columnIndex, $columnIndexField) ) $cond[]=$dateCond;
            break;
        case customfield_picture:
        case customfield_media:
            if( ($val=$this->{$v->columnIndex})!=-1 ) // ha nem 'Any'
            {
                $cond[]= $val ? "$columnIndexField!=''" : "$columnIndexField=''";
            }
            break;
        default:
            break;
        }
    }
    return $cond;
}

function composeSearchRegexp($columnName, $s)
{
    return "$columnName REGEXP '(^|,)" . quoteSQL(preg_quote($s)) . "(,[^,]|$)'";
}

function getDateCondition( $columnIndex, $columnIndexField )
{
    $cond = "";
    if( !empty($this->{$columnIndex}) && !$this->{$columnIndex}->isEmpty() )
    {
        $cond = "CAST($columnIndexField AS DATE)='" . $this->{$columnIndex}->getDbFormat() . "'";
    }
    elseif( isset($this->{"{$columnIndex}_from"}) && isset($this->{"{$columnIndex}_to"}) ) 
    {
        if( !$this->{"{$columnIndex}_from"}->isEmpty() && !$this->{"{$columnIndex}_to"}->isEmpty() )
        {
            $cond = "CAST($columnIndexField AS DATE) BETWEEN '" . $this->{"{$columnIndex}_from"}->getDbFormat() . "' AND '" . $this->{"{$columnIndex}_to"}->getDbFormat() . "'";
        }
        elseif( !$this->{"{$columnIndex}_from"}->isEmpty() )
        {
            $cond = "CAST($columnIndexField AS DATE)>='" . $this->{"{$columnIndex}_from"}->getDbFormat() . "'";
        }
        elseif( !$this->{"{$columnIndex}_to"}->isEmpty() )
        {
            $cond = "CAST($columnIndexField AS DATE)<='" . $this->{"{$columnIndex}_to"}->getDbFormat() . "'";
        }
    }
    if( $cond ) $cond.=" AND CAST($columnIndexField AS DATE)!=0";  // hogy 0000-00-00 datumok ne legyenek az eredmenyben
    return $cond;
}

function getTitleDescriptionCondition( $columnIndex )
{
    if( $this->{$columnIndex}==='' ) return "";
    $word = quoteSQL($this->$columnIndex);
    
    G::load( $categories, "SELECT id FROM @category WHERE allowAd=1 AND directItemNum>0" );
    $condOut = array();
    $tag = $columnIndex=="title" ? customfield_title : customfield_description;
    // az osszes kategoria title ill. description szerepkoru attributumaban keresunk:
    foreach( $categories as $cat )
    {
        if( !loadSQL( $v = new CustomField, "SELECT columnIndex, type, subType FROM @customfield WHERE cid='$cat->id' AND seo=$tag") )
        {
            if( $v->subType==customfield_alnum || $v->type==customfield_textarea ) $cond="n.$v->columnIndex LIKE '%$word%'";
            else $cond="n.$v->columnIndex='$word'";
            $condOut[]="(cid='$cat->id' AND $cond)";
        }
    }
    if( count($condOut) ) return "(".implode(" OR ", $condOut).")";
    else return "";
    
}

function activateField( $v )
{
    global $lll;
    
    $class = $this->get_class();
    $typ = & $this->getTypeInfo(TRUE);
    $attrInfo = null;
    if( !$v->displayInSearchFormCondition() ) return $attrInfo;
    // az ID mezot iid-re kell atirni:
    if( $v->columnIndex=="id" ) $v->columnIndex="iid";
    $typ["attributes"][$v->columnIndex] = array("type"=>"TEXT");
    $attrInfo = & $typ["attributes"][$v->columnIndex];
    $lll["{$class}_$v->columnIndex"]=$v->getAttr("name");
    $typ["order"][]=$v->columnIndex;
    switch( $v->type )
    {
    case customfield_text:
    case customfield_textarea:
        $attrInfo[]="text";
        $attrInfo["max"]=200;
        $attrInfo["default"]="";
        $lll["{$class}_$v->columnIndex"]=$v->getAttr("name");
        $lll["{$class}_$v->columnIndex"] .= $v->subType==customfield_alnum ? $lll["contains"] : $lll["is"];
        if( $v->rangeSearch ) $lll["{$class}_$v->columnIndex"."_expl"]=sprintf($lll["rangeSearchExpl"], $v->getAttr("name"));
        break;
    case customfield_bool:
    case customfield_picture:
    case customfield_media:
        $attrInfo[]="selection";
        $attrInfo["values"][]=-1;
        $lll[$v->columnIndex."_-1"]=$lll["any"];
        $attrInfo["values"][]=0;
        $lll[$v->columnIndex."_0"]=$lll["no"];
        $attrInfo["values"][]=1;
        $lll[$v->columnIndex."_1"]=$lll["yes"];
        $attrInfo["default"]=-1;
        if( $v->type==customfield_bool ) $lll["{$class}_$v->columnIndex"]=$v->getAttr("name").$lll["is"];
        else $lll["{$class}_$v->columnIndex"]=$v->getAttr("name").$lll["hasUploaded"];
        break;
    case customfield_selection:
    case customfield_multipleselection:
        if( $v->columnIndex=="ownerName" )  // special case
        {
            $attrInfo[]="multipleclassselection";
            $attrInfo[]="variablesize";
            $attrInfo["size"]=10;
            $attrInfo["class"]="user";
            $attrInfo["labelAttr"]="name";
            $attrInfo["where"]="id!=name";
            $attrInfo["nothing selected"] = "currentUser";
            $lll["{$class}_$v->columnIndex"]=$v->getAttr("name").$lll["isAnyOf"];
            $lll["{$class}_{$v->columnIndex}_expl"]=$lll["customlist_ownerName_expl"];
        }
        elseif( $v->columnIndex=="status" )  // special case
        {
            $attrInfo[]="selection";
            $attrInfo["values"]=array(-1, 0, 1);  // Any, Inactive, Active
            $attrInfo["default"]=-1;
            $lll["{$v->columnIndex}_-1"]=$lll["any"];
            $lll["{$class}_$v->columnIndex"]=$v->getAttr("name").$lll["is"];
        }
        else
        {
            $valNum = $v->activateEnumAttrInfo( $attrInfo, $this->get_table(), $v->columnIndex, FALSE );
            if( $valNum>2 )
            {
                $attrInfo[]="multipleselection";
                $attrInfo["size"]=min(10, $valNum);
                $lll["{$class}_$v->columnIndex"]=$v->getAttr("name").$lll["isAnyOf"];
            }
            else 
            {
                $attrInfo[]="selection";
                $tempArr = array_reverse($attrInfo["values"]);
                $tempArr[""]="";
                $attrInfo["values"] = array_reverse($tempArr);
                $attrInfo["default"]="";
                $lll["{$v->columnIndex}_"]=$lll["any"];
                $lll["{$class}_$v->columnIndex"]=$v->getAttr("name").$lll["is"];
            }
        }
        break;
    case customfield_checkbox:
        $attrInfo[]="checkbox";
        $attrInfo["cols"]=$v->checkboxCols;
        $lll["{$class}_$v->columnIndex"]=$v->getAttr("name").$lll["isAnyOf"];
        $v->activateEnumAttrInfo( $attrInfo, $class, $v->columnIndex, FALSE );
        break;
    case customfield_date:
        $attrInfo["type"]="DATETIME";
        $attrInfo["prototype"]="date";
        $attrInfo["format"]="([0-9]{4})-([0-9]{2})-([0-9]{2})$";
        $attrInfo["order"]=array("year", "month", "day");
        $attrInfo["display_format"]="Y-m-d";
        $attrInfo["length"]=16;
        $attrInfo[]="jscalendar";
        $attrInfo[]="datetext";
        $attrInfo["fromyear"]=$v->fromyear ? $v->fromyear : "now";
        $attrInfo["toyear"]=$v->toyear ? $v->toyear : "now";

        $lll["{$class}_$v->columnIndex"]=$v->getAttr("name").$lll["is"];
        if( $v->rangeSearch )
        {
            $typ["attributes"]["{$v->columnIndex}_from"] = array("type"=>"TEXT", "no column");
            $fromInfo = & $typ["attributes"]["{$v->columnIndex}_from"];
            $fromInfo["type"]="DATETIME";
            $fromInfo["prototype"]="date";
            $fromInfo["format"]="([0-9]{4})-([0-9]{2})-([0-9]{2})$";
            $fromInfo["order"]=array("year", "month", "day");
            $fromInfo["display_format"]="Y-m-d";
            $fromInfo["length"]=16;
            $fromInfo[]="jscalendar";
            $fromInfo[]="datetext";
            $fromInfo["fromyear"]=$v->fromyear ? $v->fromyear : "now";
            $fromInfo["toyear"]=$v->toyear ? $v->toyear : "now";
            $typ["attributes"]["{$v->columnIndex}_to"] = $typ["attributes"]["{$v->columnIndex}_from"];
            
            $lll["{$class}_$v->columnIndex"."_from"]=$v->getAttr("name").$lll["isAfter"];
            $lll["{$class}_$v->columnIndex"."_to_expl"]=$lll["dateRangeSearchExpl"];
            $lll["{$class}_$v->columnIndex"."_to"]=$v->getAttr("name").$lll["isBefore"];
            $typ["order"][]="{$v->columnIndex}_from";
            $typ["order"][]="{$v->columnIndex}_to";
        }
        break;
    case customfield_separator:
        $attrInfo[]="section";
        $attrInfo["name"]=$v->getAttr("name");
        $lll[$v->columnIndex] = $v->getAttr("name");
        break;
    default:
        break;
    }
    // visszaallitjuk az eredetire:
    if( $v->columnIndex=="iid" ) $v->columnIndex="id";
    return $attrInfo;
}

}
?>
