<?php
defined('_NOAH') or die('Restricted access');
class G
{
    
function load( &$obj, $idOrQuery, $class="", $triggerError=FALSE)
{
    global $dbClasses;
    
    if( $class )
    {
        if( !class_exists($class) )
        {
            $s = "Class doesn't exists: $class";
            trigger_error($s, E_USER_WARNING);
        }
        if( is_callable(array($class, "createObject")) ) $obj = call_user_func(array($class, "createObject"));  // factory method
        else $obj = new $class;
        $obj->id = $idOrQuery;
        if( ($ret = load($obj)) && $triggerError )
        {
            $s = "Object not found in DB: class: $class, id: $idOrQuery";
            trigger_error($s, E_USER_WARNING);
        }
        return $ret;
    }
    else 
    {
        $idOrQueryRef = is_array($idOrQuery) ? $idOrQuery[0] : $idOrQuery;
        preg_match( "/\bFROM +@?(\w+)\b/i", $idOrQueryRef, $matches);
        $class=$matches[1];
        if( class_exists("app$class") ) $class="app$class";
        if( !class_exists($class) )
        {
            $s = "Class doesn't exists: $class";
            trigger_error($s, E_USER_WARNING);
        } 
        if( is_callable(array($class, "createObject")) ) $obj = call_user_func(array($class, "createObject"));  // factory method
        else $obj = new $class;
        // ha a class egy olyan leszarmazott osztaly, hogy a hozza tartozo table az ososztaly neve alatt fut:
        if( !in_array($class, $dbClasses) )
        {
            // akkor a class nevet kicsereljuk az ososztaly nevere a query-ben:
            $idOrQuery = preg_replace( "/\b(FROM +@?)($class)\b/i", "$1".$obj->get_table(), $idOrQuery);
        }
        loadObjectsSql( $obj, $idOrQuery, $obj );
        return count($obj);  // ilyenkor azt adja vissza, hogy hany elemet talalt
    }
}

// Az $id id-ju $class objektumbol visszaad egy attributumot, 
// vagy attributumoknak egy tombjet. Pl. G::getAttr( 1, "Dog", "attr1", "attr2" )
function getAttr( $id, $class)
{
    $attrNameArr = array_slice(func_get_args(), 2); // class es id levagva
    $attrNames = implode(",",  $attrNameArr);
    if( !class_exists($class) )
    {
        $s = "Class doesn't exists: $class";
        trigger_error($s, E_USER_WARNING);
    }
    $obj = new $class;
    $obj->id = $id;
    if( $ret = load($obj, "", $attrNames) )
    {
        $s = "Object not found in DB: class: $class, id: $id";
        trigger_error($s, E_USER_WARNING);
    }
    if( count($attrNameArr)==1 ) return $obj->{$attrNames};
    else 
    {
        $ret = array();
        foreach( $attrNameArr as $attrName ) $ret[]=$obj->{$attrName};
        return $ret;
    }
}

function & getTemplate($file, $path=0)
{
    $path = $path===0 ? TEMPLATE_DIR . "/" : ($path==="" ? "" : "$path/");
    $content =& join('', file ("$path$file"));
    return addcslashes ($content, '"');      
}

function getFindInSetCondition( &$cond, $value, $column, $allowNull=FALSE )
{
    $cond='';
    if( is_array($value) )
    {
        if( ($length=count($value))>1 ) $cond="FIND_IN_SET($column, '".implode(",", $value)."')!=0";
        elseif( $length==1 && (($allowNull && $value[0]>=0) || (!$allowNull && $value[0]>0)) ) $cond="$column=".$value[0];
    }
    else
    {
        if( strstr($value, ',') ) $cond="FIND_IN_SET($column, '$value')!=0";
        elseif( $value!='' ) $cond="$column=$value";
    }
    return $cond;
}

function addAsExtraRows( &$table, $rowsToInsert )
{
    $table = str_replace("<!-- add extra rows here -->", "$rowsToInsert<!-- add extra rows here -->", $table);
}

function getSetting( &$typ, $settingName, $fieldName="" )
{
    global $$settingName, $gorumroll;
    
    $ret = G::getSettingVal($$settingName, $fieldName);
    if( isset($typ[$settingName]) && ($v=G::getSettingVal($typ[$settingName], $fieldName))!==NULL) $ret=$v;
    if( isset($typ["$gorumroll->list: $settingName"])  && ($v=G::getSettingVal($typ["$gorumroll->list: $settingName"], $fieldName))!==NULL) $ret=$v;
    elseif( isset($typ["$gorumroll->method: $settingName"])  && ($v=G::getSettingVal($typ["$gorumroll->method: $settingName"], $fieldName))!==NULL) $ret=$v;
    if( isset($typ["$gorumroll->list-$gorumroll->method: $settingName"])  && ($v=G::getSettingVal($typ["$gorumroll->list-$gorumroll->method: $settingName"], $fieldName))!==NULL) $ret=$v;
    return $ret;
}

function getSettingVal( $attr, $fieldName="" )
{
    if( $fieldName )
    {
        if( is_array($attr) && isset($attr[$fieldName]) ) return G::getSettingVal($attr[$fieldName]);
        return NULL;
    }
    else
    {
        if( $attr===FALSE || $attr==="off" || $attr==="no" ) return FALSE;
        elseif( $attr===TRUE || $attr==="on" || $attr==="yes" ) return TRUE;
        else return $attr;
    }
}

// prepares the text parameters for passing them over to a JavaScript function
function js()
{
    global $lll;
    
    $replaced = array();
    foreach( func_get_args() as $arg ) $replaced[] = "'".addcslashes(!is_numeric($arg) && isset($lll[$arg]) ? $lll[$arg] : $arg, "'")."'";
    return implode(", ", $replaced);
}

}

function array_map_objects($member_function, $array) {
    $values = array();

    if(is_string($member_function) && is_array($array)) {
        $callback = create_function('$e', 'return call_user_func(array($e, "' . $member_function .'"));');
        $values = array_map($callback, $array);
    }

    return $values;
}

?>
