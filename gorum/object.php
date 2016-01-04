<?php
defined('_NOAH') or die('Restricted access');

// TypeInfo Help
// ---------------------------------
// A kovetkezo pelda egy olyan attributumot mutat, ami a DB-ben INT-kent
// van tarolva, default erteke 1, es auto increment.
// - Az a_form-ban text mezokent jelenik meg - a mezo hossza 10, az
//   input hossza 20.
// - A b_form-ban textarea-kent jelenik meg, 30x40-es mezoben,
// - A c_form-ban multiple selection-kent jelenik meg, a lista
//   eredmenyekent kaphato ertekek: 1, 2, 3, 4. A listaban lathato
//   sorok: "egy", "ketto", "harom", "negy". A lista magassaga 2.
// - Az attributum minden mas form eseten date-mezokent jelenik meg.
//
// Az attributum az a_form-ban mandatory, a d_formban hidden, az
// e_form-ban pedig invisible.
//
//
//    "textareaAttr"=>array(
//        "type"=>"INT",
//        "default" => 1,
//        "auto increment",
//        "a_form: text",
//        "max" => 10,
//        "length" => 20,
//        "b_form: textarea",
//        "rows" => 30,
//        "cols" => 40,
//        "c_form: multipleselection",
//        "values" => array(1,2,3,4),
//        "size" => 2,
//        "date",
//        "a_form: mandatory",
//        "d_form: form hidden",
//        "e_form: form invisible"
//     )
//
// Az SQL tablat meghatarozo kulcsszavak osztalyszinten:
// tableName, primary_key, unique_keys, keys, heap, select
//
// Az SQL tablat meghatarozo kulcsszavak attributumszinten:
// type, default, auto increment, no column, length, max, values
//
// A form egeszet meghatarozo kulcsszavak:
// submit, delete_confirm
//
// Az egyes form mezoket meghatarozo kulcsszavak:
// form hidden, form invisible, mandatory
// text, textarea, readonly, password, button, file, multipleselection,
// selection, date, bool, radio, classselection
// max, min, length, rows, cols, values, names, size, class, labelAttr,
// query
//
// A listas megjelenest meghatarozo kulcsszavak:
// list, sorta, sortd, notools, centered,
// sort_criteria_attr, sort_criteria_dir, sort_criteria_sql
//
// Egyeb kulcsszavak: details
//
// Specialitasok:
// - a selection mezo egy olyan erteket var, ami a values tombben benne
//   van - ez lesz a listaban alapbol szelektalva. Ha nem ilyet kap, az
//   elso elem lesz a listaban kiszelektalva. Vissza is egy ilyen
//   erteket ad.
// - a multipleselection mezo olyan ertekeknek egy tombjet varja,
//   amelyek a values tombben szerepelnek - ezek lesznek a listaban
//   alapbol szelektalva. Ha a tomb ures (vagy nem is tomb), akkor semmi
//   se lesz szelektalva. Vissza is egy ilyen tombot ad, vagy ha semmit
//   se valasztottunk ki akkor az az init() altal megallapitott default
//   marad.
// - a date mezo egy timestamp-et var. Ha nullat kap, az aktualis
//   datum lesz. Vissza egy aszociativ tombot ad az attributumban, ahol
//   a kulcsok: year, month es day.
// - a radio mezo ugyanugy mukodik, mint a selection
//
// A date tipusu mezonek a DB-ben INT-nek kell lenni, a
// multipleselectionnak pedig valamilyen sztringnek
//
// Egy pelda a datetext tipusra:
//
//"startDate" = array(
//  "type"=>"DATETIME",   // DATE, v. DATETIME, v. TIME tipus
//  "datetext",
    // "format" adja meg a az inpurmezohoz tartozo regularis kifejezest,
    // itt azt is figyelembe kell venni, ha az attr nem mandatori,
    // s igy az ures string is ervenyes.
    // az alabbi kifejezes egy nem mandatory "dd/mm/yyyy hh:mm" formatumot ir le
    // az egyes datumelemeker zarojelbe kell tenni, hogy aztan az ereg szet tudja valogatni oket!                
//  "format"=>"^$|([0-9]{2})/([0-9]{2})/([0-9]{4}) ([0-9]{2}):([0-9]{2})$",
    // a beolvasasnal az ereg szet tudja valogatni az egyes datumelemeket,
    // de nem "tudja" a sorrendet kozottuk. Az "order" a sorrend meghatarozasara szolgal.
    // Ha nem adunk meg "order"-t, akkor year, month, day, hour, minute ervenyes
//  "order"=>array("day", "month", "year", "hour", "minute"),
    // Ez jeleniti meg a DB-bol olvasott erteket az input mezoben.
    // Osszhangban kell hogy legyen a "format"-ban megadott regexp-pel
//  "display_format"=>"d/m/Y H:i",
    // a default barmilyen stringet elfogad, amit a strtotime fg is elfogad
//  "default"=>"next week +2 hours",



class Object
{
    
function get_class()
{
    return strtolower(get_class($this));
}
function get_parent_class()
{
    if( $parent = get_parent_class($this) ) return strtolower($parent);
    else return "";
}

function get_table()
{
    return $this->get_class();
}
    
function & getTypeInfo($withPreprocessing=FALSE)
{
    $typ = $this->get_class()."_typ";
    global ${$typ};
    if( !isset(${$typ}) )
    {
        $parent = gget_parent_class($this);
        $typ = $parent."_typ";
        global ${$typ};
        if( !isset(${$typ}) )
        {
            $obj = new $parent;
            $typ = gget_parent_class($obj)."_typ";
            global ${$typ};
            if( !isset(${$typ}) )
            {
                if( $t = gget_parent_class($obj) )
                {
                    $obj = new $t;
                    $typ = gget_parent_class($obj)."_typ";
                    global ${$typ};
                }
                if( !isset(${$typ}) )
                {
                    $dummy = 0;
                    return $dummy;
                }
            }
        }
    }
    if( $withPreprocessing )
    {
        // TypeInfo "preprocessing":
        // Ezekre hivatkozhatunk a feltetelek kiertekelesenel:
        global $gorumroll, $gorumuser, $gorumrecognised, $scriptName, $whatComp, $wRep, $printView, $clientView, $gorumevent, $gLight;
        $_S = new AppSettings();
        $_EC = EComm::createObject();
        if( class_exists("ECommSettings") ) $_ES = new ECommSettings();
        hasAdminRights($isAdm);
        // vegignezzuk a typeinfot, hogy vannak-e benne felteteles elemek definialva
        $attrs = & ${$typ}["attributes"];
        foreach( $attrs as $attr=>$attrInfo )
        {
            // ha egy elozo getTypeInfo hivas mar beallitott kelteteles mezoket,
            // akkor azokat eloszor toroljuk:
            if( isset($attrInfo["conditional_indexes"]) )
            {
                foreach( $attrInfo["conditional_indexes"] as $key )
                {
                    unset($attrs[$attr][$key]);
                }
            }
            if( isset($attrInfo["conditions"]) ) // vannak feltetelek
            {
                // vegigmegyunk a felteteleken:
                foreach( $attrInfo["conditions"] as $cond=>$tag ) 
                {
                    //echo "$attr $cond: ";
                    $cond = addcslashes ($cond, '"');     
                    eval ("\$cond = ($cond);");
                    //echo $cond ? "true" : "false";echo "<br>";
                    if( $cond ) // kiertekeljuk a feltetelt
                    {
                        // egy feltetelhez tobb tag is tartozhat:
                        if(is_array($tag)) 
                        {
                            // mindet betesszuk a typeinfoba:
                            foreach($tag as $key=>$tagitem) 
                            {
                                if( is_int($key) ) 
                                {
                                    $attrs[$attr][]=$tagitem;
                                    end($attrs[$attr]);
                                    $attrs[$attr]["conditional_indexes"][]=key($attrs[$attr]);
                                }
                                else 
                                {
                                    $attrs[$attr][$key]=$tagitem;
                                    $attrs[$attr]["conditional_indexes"][]=$key;
                                }
                            }    
                        }    
                        else 
                        {
                            $attrs[$attr][]=$tag;
                            end($attrs[$attr]);
                            $attrs[$attr]["conditional_indexes"][]=key($attrs[$attr]);
                        }
                    }    
                }
            }
        } 
        if( isset(${$typ}["conditions"]) ) // vannak feltetelek
        {
            // ha egy elozo getTypeInfo hivas mar beallitott kelteteles mezoket,
            // akkor azokat eloszor toroljuk:
            if( isset(${$typ}["conditional_indexes"]) )
            {
                foreach( ${$typ}["conditional_indexes"] as $key )
                {
                    unset(${$typ}[$key]);
                }
            }
            // vegigmegyunk a felteteleken:
            foreach( ${$typ}["conditions"] as $cond=>$tag ) 
            {
                $cond = addcslashes ($cond, '"');                    
                eval ("\$cond = ($cond);");
                if( $cond ) // kiertekeljuk a feltetelt
                {
                    // egy feltetelhez tobb tag is tartozhat:
                    if(is_array($tag)) 
                    {
                        // mindet betesszuk a typeinfoba:
                        foreach($tag as $key=>$tagitem) 
                        {
                            if( is_int($key) ) 
                            {
                                ${$typ}[]=$tagitem;
                                end(${$typ});
                                ${$typ}["conditional_indexes"][]=key(${$typ});
                            }
                            else 
                            {
                                ${$typ}[$key]=$tagitem;
                                ${$typ}["conditional_indexes"][]=$key;
                            }
                        }    
                    }    
                    else 
                    {
                        ${$typ}[]=$tag;
                        end(${$typ});
                        ${$typ}["conditional_indexes"][]=key(${$typ});
                    }
                }    
            }
        }
    }   
    return ${$typ};
}

function getVisibility( &$attrInfo, $attr )
{
    global $gorumroll;

    // Ez a fg nem csak a formok esteben lesz meghivva:
    $method = strstr($gorumroll->method, "_form") ?
              $gorumroll->method : $gorumroll->method."_form";
    if( in_array("$method: form invisible",$attrInfo) ){
        $visibility = Form_invisible;
    }
    elseif( in_array("$method: form hidden",$attrInfo) ){
        $visibility = Form_hidden;
    }
    elseif( in_array("$method: readonly",$attrInfo) ){
        $visibility = Form_readonly;
    }
    elseif( in_array("form hidden",$attrInfo) ){
        $visibility = Form_hidden;
    }
    elseif( in_array("form invisible",$attrInfo) ){
        $visibility = Form_invisible;
    }
    elseif( in_array("form readonly",$attrInfo) ){
        $visibility = Form_readonly;
    }
    else
    {
        $visibility = Form_visible;
    }
    return $visibility;
}

function init( $members="" )
{
    $typ =& $this->getTypeInfo();
    $attrs = array_keys( $typ["attributes"] );
    foreach( $members as $attr=>$value )
    {
        if( isset($members[$attr]) &&
            in_array($attr, $attrs) )
        {
            $this->{$attr} = $value;
        }
        else if( !isset($members[$attr]) ) {
            // Vajon mi lesz, ha ezt kikommentezem?
            unset($this->{$attr});
        }
        if( isset($this->{$attr}) && isset($typ["attributes"][$attr]["prototype"]) )
        {
            $this->{$attr} = new $typ["attributes"][$attr]["prototype"]($this->{$attr});
        }
    }
    return ok;
}

function initClassVars($classVars=0)
{
    global $gorumroll;
    
    if( !$typ =& $this->getTypeInfo(TRUE) ) return;  // ha nincs typeInfo
    $isAction = !isset($gorumroll) || $gorumroll->isAction();
    hasAdminRights($isAdm);
    foreach( $typ["attributes"] as $attr=>$val )
    {
        if( $classVars )  // ha classVarsban jon barmi, akkor csak a classVarsbol inicializalunk
        {
            if( isset($classVars[$attr]) ) 
            {
//                if( !in_array("allow_html", $val) || 
                if( !$isAdm ) $classVars[$attr] = filterInput($classVars[$attr]);
                $this->initAttr($attr, $val, $classVars[$attr]);
            }
        }
        else  // kulonben a szokasos modon a REQUEST globalokbol
        {
            if( !$isAction && isset($_GET[$attr])) // GET-bol csak akkor inicializalhatunk, ha nem action-rol van szo
            {
                $this->initAttr($attr, $val, $_GET[$attr]);
            }
            elseif (isset($_POST[$attr])) 
            {
                // hogy admin barmilyen html-t betehessen egy hirdetesbe:
//              if( !in_array("allow_html", $val) || 
                if( !$isAdm ) $_POST[$attr] = filterInput($_POST[$attr]);
                $this->initAttr($attr, $val, $_POST[$attr]);
            }
            elseif( !$isAction && isset($_SESSION["post"]->$attr))  // invalid form eseten kerul ra sor 
            {
                $this->initAttr($attr, $val, $_SESSION["post"]->$attr);
            }
            elseif (isset($_COOKIE[$attr])) {
                $this->initAttr($attr, $val, $_COOKIE[$attr]);
            }
        }
        if(!isset($this->{$attr}) )
        {
            $x = NULL;
            $this->initAttr($attr, $val, $x);
        }
    }
}

function initAttr( $attr, &$attrInfo, &$value )
{
    global $gorumroll;
    
    if (is_array($value) )
    {
        $this->{$attr} = array();
        foreach($value as $key=>$val)
        {
            if (get_magic_quotes_gpc())
            {
                $this->{$attr}[$key]=stripslashes($val);
            }
            else $this->{$attr}[$key]=$val;
        }
        ksort($this->{$attr});
    }
    elseif( isset($value) && !is_object($value) )
    {
        if( !in_array("notrim", $attrInfo) ) $value=trim($value);
        if (get_magic_quotes_gpc())
        {
            $this->{$attr}=stripslashes($value);
        }
        else $this->{$attr}=$value;
    }
    elseif( isset($value) && Object::inAttrInfo("selection", $attrInfo) ) $this->$attr = array($value);
    else
    {
        // Ez azert kell, hogy a bool attributum FALSE erteke is
        // atjojjon a formbol:
        if( Object::inAttrInfo("bool", $attrInfo) && !in_array("default null", $attrInfo) &&
           $this->getVisibility($attrInfo, $attr)==Form_visible &&
           !strstr($gorumroll->method, "_form")) {
            $this->{$attr} = FALSE;
            $_POST[$attr]='';  // hogy a validAttribute, ne return-ozzon rogton az elejen
        }
        // Ez azert kell, hogy a multipleselection attributum
        // ures erteke is atjojjon a formbol:
        if(!in_array("default null", $attrInfo) && (Object::inAttrInfo("multipleselection", $attrInfo) ||
           Object::inAttrInfo("multipleclassselection", $attrInfo) || Object::inAttrInfo("checkbox", $attrInfo)) &&
           $this->getVisibility($attrInfo, $attr)==Form_visible &&
           !strstr($gorumroll->method, "_form")) {
            $this->{$attr} = array();
            $_POST[$attr]='';
        }
    }
    if( isset($this->{$attr}) && isset($attrInfo["prototype"]) )
    {
        $this->{$attr} = new $attrInfo["prototype"]($this->{$attr});
    }
}

function inAttrInfo($type, &$attrInfo)
{
    global $gorumroll;
    
    if( in_array($type, $attrInfo) ) return TRUE;
    foreach( $attrInfo as $val ) if( is_string($val) && isset($gorumroll->method) && preg_match("/^$gorumroll->method(_form|): $type$/", $val) ) return TRUE;
    return FALSE;
}

function getDefault( &$typ, $attr )
{
    if( !isset($typ["attributes"][$attr] ) ) return "";
    $attrInfo = & $typ["attributes"][$attr];
    if( isset($attrInfo["prototype"]) )
    {
        $defaultInitVal = isset($attrInfo["default"]) ? $attrInfo["default"] : "";
        return new $attrInfo["prototype"]($defaultInitVal);
    }
    if( isset($attrInfo["default"]) ) return $attrInfo["default"];
    if( strstr($attrInfo["type"], "INT") )
    {
        if( isset($attrInfo["default"]) && $attrInfo["default"]==="" ) return "";
        else return 0;
        // Note: even if min==1 !!!
    }
    if( strstr($attrInfo["type"], "CHAR") ) return "";
    if( strstr($attrInfo["type"], "TEXT") ) return "";
}

function validAttribute( &$typ, $attr )
{
    global $lll, $gorumroll;

    if( !isset($_GET[$attr]) && !isset($_POST[$attr]) )
    {
        return ok;
    }
    $value = $this->{$attr};
    if( !isset( $typ["attributes"][$attr] ) )
    {
        return ok;
    }
    else $attrInfo = & $typ["attributes"][$attr];

    $lllProp = new LllProperties( $this, $attr, FALSE );
    $attrName = $lllProp->getLabel();
    if( is_object($value) )
    {
        if( $err = $value->getError() ) return Roll::setFormInvalid($err);
        if( in_array("mandatory", $attrInfo) && method_exists($value, "isEmpty") && $value->isEmpty() )
        {
            return Roll::setFormInvalid("mandatoryField", $attrName);
        }
    }
    elseif( is_array($value) )  // vagy multipleselection, vagy date
    {
        if( isset($attrInfo["min"]) && count($value)<$attrInfo["min"] )
        {
            return Roll::setFormInvalid("selectAtLeastOne",$attrInfo["min"], $attrName );
        }
    }
    elseif( isset($attrInfo["format"]) )
    {
        return ok;  // TODO
        if( !in_array("mandatory", $attrInfo) && !$value ) 
        {
        }
        elseif( !ereg($attrInfo["format"], $value, $regs) )
        {
            return Roll::setFormInvalid(sprintf( "Invalid format: %s", $attrName));
        }
    }
    elseif( isset($attrInfo["pformat"]) )
    {
        if( !in_array("mandatory", $attrInfo) && !$value ) 
        {
        }
        elseif( !preg_match($attrInfo["pformat"], $value) )
        {
            return Roll::setFormInvalid(sprintf( "Invalid format: %s", $attrName));
        }
    }
    //if( !isset($attrInfo["type"]) ) echo $attr;
    elseif( strstr($attrInfo["type"], "INT") )
    {
        if( !ereg("^[0-9-]*$", $value)) return Roll::setFormInvalid("mustBeInt",$attrName);
        if( isset($attrInfo["min"]) && $value<$attrInfo["min"] )
        {
            return Roll::setFormInvalid("mustBeGreaterInt", $attrName, $attrInfo["min"] );
        }
        if( isset($attrInfo["max"]) && $value>$attrInfo["max"] )
        {
            return Roll::setFormInvalid("mustBeSmallerInt", $attrName, $attrInfo["max"] );
        }
        return ok;
    }
    elseif( strstr($attrInfo["type"], "FLOAT") )
    {
        if( $value && !ereg("^-?[0-9]*\.?[0-9]+$", $value))
        {
            return Roll::setFormInvalid("mustBeFloat",$attrName);
        }
        if( isset($attrInfo["min"]) && $value<$attrInfo["min"] )
        {
            return Roll::setFormInvalid("mustBeGreaterInt", $attrName, $attrInfo["min"] );
        }
        if( isset($attrInfo["max"]) && $value>$attrInfo["max"] )
        {
            return Roll::setFormInvalid("mustBeSmallerInt", $attrName, $attrInfo["max"] );
        }
        return ok;
    }
    //echo "$attr<br>";
    elseif( strstr($attrInfo["type"], "CHAR") )
    {
        if( isset($attrInfo["min"]) &&
            strlen($value)<$attrInfo["min"] )
        {
            if ($attrInfo["min"]=="1")  $err = sprintf( $lll["mandatoryField"],$attrName);
            else  $err = sprintf( $lll["mustBeGreaterString"], $attrName, $attrInfo["min"] );
            return Roll::setFormInvalid($err);
        }
        //echo "$attr - len: ".strlen($value)."<br>";
        if( isset($attrInfo["max"]) &&
            strlen($value)>$attrInfo["max"] )
        {
            return Roll::setFormInvalid("mustBeSmallerString", $attrName, $attrInfo["max"] );
        }
        if( in_array("file", $attrInfo) )
        {
            if (isset($_FILES[$attr]["name"]) && strstr($_FILES[$attr]["name"]," "))
            {
                return Roll::setFormInvalid("spacenoatt");
            }
        }
        return ok;
    }
    elseif( strstr($attrInfo["type"], "TEXT") )
    {
        if( isset($attrInfo["min"]) && 
            (strlen($value)<$attrInfo["min"] || (is_numeric($value) && $value < $attrInfo["min"])))
        {
            if ($attrInfo["min"]=="1")  $err = sprintf( $lll["mandatoryField"], $attrName);
            else $err = sprintf( $lll["mustBeGreaterString"], $attrName, $attrInfo["min"] );
            return Roll::setFormInvalid($err);
        }
        if( isset($attrInfo["max"]) &&
            strlen($value)>$attrInfo["max"] )
        {
            return Roll::setFormInvalid("mustBeSmallerString", $attrName, $attrInfo["max"] );
        }
        return ok;
    }
    return ok;
}

function valid()
{
    $this->validateAttributes();
    if( !Roll::isFormInvalid() ) $this->validateCaptcha();
}

function validateAttributes()
{
    $typ =& $this->getTypeInfo();
    $object_vars = get_object_vars($this);
    foreach( $object_vars as $attr=>$value )
    {
        $this->validAttribute( $typ, $attr );
        if( Roll::isFormInvalid() ) break;
    }
}

function validateCaptcha()
{
    if( $this->hasCaptcha() )
    {
      $_S = new AppSettings();
 
      switch ($_S->captchaType) {
       case 1:
        return $this->validatereCaptcha();
        break;
      default:
        return $this->validateNoahCaptcha();
        break;
      } 
    }
    return TRUE;
}


function validatereCaptcha()
{
    require_once(GORUM_DIR . '/recaptcha/recaptchalib.php');
    $_S = new AppSettings();
    $privatekey = $_S->recaptchaPrivateKey;
    $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {
        return Roll::setFormInvalid("invalidCaptcha");
    }
    return TRUE;
}


function validateNoahCaptcha()
{
  include_once(GORUM_DIR . '/captcha/php-captcha.inc.php');
  if( !PhpCaptcha::Validate($_POST['captchaField']) ) 
  {
    return Roll::setFormInvalid("invalidCaptcha");
  }
  return TRUE;
}

function hasCaptchaInForm()
{
    return $this->hasCaptcha("_form");
}

function hasCaptcha()
{
    return Object::inAttrInfo("captcha", $this->getTypeInfo(TRUE));
}

function copy( &$base, $whereFields="" )
{

    $typ =& $this->getTypeInfo();
    if( $whereFields=="" ) $whereFields=getPrimaryKey($typ);
    foreach( $whereFields as $attribute )
    {
        if( isset($base->{$attribute}) )
        {
            $this->{$attribute} = $base->{$attribute};
        }
        else
        {
            unset($this->{$attribute});
        }
    }
}

function createForm($elementName="")
{
    global $gorumroll;

    $this->hasObjectRights($hasRight, "create", TRUE);
    $this->generForm($elementName);
}

function modifyForm($elementName="")
{
    global $gorumroll;

    $this->id = $gorumroll->rollid;
    if( !Roll::isPreviousFormSubmitInvalid() )
    {
        $ret = $this->load();
        if( $ret )
        {
            handleErrorNotFound($this,__FILE__,__LINE__);
        }
    }
    $this->hasObjectRights($hasRight, "modify", TRUE);
    $this->generForm($elementName);
}

function deleteForm($elementName="")
{
    global $gorumroll;

    $this->id = $gorumroll->rollid;
    if( $this->load() ) handleErrorNotFound($this,__FILE__,__LINE__);
    $this->hasObjectRights($hasRight, "delete", TRUE);
    $this->generDeleteForm($elementName);                               
}

function generForm($elementName="")
{
    global $gorumview;
    
    /* if( !Roll::isPreviousFormSubmitInvalid() )  */LocationHistory::resetPost();
    $formPresentationClassName = G::getSetting($this->getTypeInfo(TRUE), "formPresentationClassName");
    $temp = new $formPresentationClassName($this);
    return $temp->gener($gorumview->addElement($elementName));
}

function generDeleteForm($elementName="")
{
    $deleteFormPresentationClassName = G::getSetting($this->getTypeInfo(TRUE), "deleteFormPresentationClassName");
    $temp = new $deleteFormPresentationClassName($this);
    $view =& View::getContentView();
    return $temp->gener($view->addElement($elementName));
}

function redirectForm()
{
    echo FormPresentation::generRedirectForm($this);
    die();
}

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    $hasRight->objectRight = TRUE;
    $hasRight->generalRight = TRUE;
}

function hasGeneralRights(&$rights)
{
    $rights = array();
    $this->hasObjectRights($hasRight1, "load");
    if( !empty($hasRight1->generalRight) ) $rights["load"] = $hasRight1->objectRight;
    $this->hasObjectRights($hasRight2, "create");
    if( !empty($hasRight2->generalRight) ) $rights["create"] = $hasRight2->objectRight;
    $this->hasObjectRights($hasRight3, "modify");
    if( !empty($hasRight3->generalRight) ) $rights["modify"] = $hasRight3->objectRight;
    $this->hasObjectRights($hasRight4, "delete");
    if( !empty($hasRight4->generalRight) ) $rights["delete"] = $hasRight4->objectRight;
}

function load( $whereFields="",$whatFields="*" )
{
    return load($this, $whereFields,$whatFields) ;
}

function loadObjectsSQL($query, &$objArr )
{
    return loadObjectsSql($this, $query, $objArr );
}

function create()
{
    //$this->checkAndUnsetInvisibleFields();
    create($this);
}

function modify( $whereFields="" )
{
    $this->checkAndUnsetInvisibleFields();
    modify($this, $whereFields);
}

function delete( $whereFields="" )
{
    delete($this, $whereFields);
}

// Ellenorizzuk, hogy nem-e a private attributumokat modositotta vki
function checkAndUnsetInvisibleFields()
{
    $typ =& $this->getTypeInfo(TRUE);
    $attrs = get_object_vars($this);
    foreach( $attrs as $attr=>$value )
    {
        // Ha a requestben benne van, de nem kellene ott lennie, akkor unseteljuk:
        if( isset($_REQUEST[$attr]) && !$this->fieldExistsInForm($typ, $attr) )  
        {
            //echo("$attr<br>");
            unset($this->$attr);
        }
    }
}

function fieldExistsInForm(&$typ, $attr)
{
    global $gorumroll;
    
    if( !@$attrInfo =& $typ["attributes"][$attr] ) 
    {
        return FALSE;  // ha nincs ilyen attr
    }
    if( ($visibility = $this->getVisibility( $attrInfo, $attr ))==Form_invisible || 
        ($visibility==Form_readonly && in_array("nohidden",$attrInfo))) 
    {
        return FALSE;  // ha invisible
    }
    if( $visibility==Form_hidden || $visibility==Form_readonly ) 
    {
        return TRUE;
    }
    if( !FormFieldType::getFormDisplayType($attrInfo, $gorumroll->method, $attr) ) 
    {
        return FALSE;  // ha egyaltalan nincs is a formban
    }
    return TRUE;
}

function loadHtmlList(&$list)
{
    return loadHtmlList($this,$list);
}

function showHtmlList($elementName="", $cacheManager=0)
{
    global $gorumview;
    
    $listPresentationClassName = G::getSetting($this->getTypeInfo(TRUE), "listPresentationClassName");
    $temp = new $listPresentationClassName($this);
    return $temp->gener($gorumview->addElement($elementName, $cacheManager));
}

function getCacheTimeFrameAndCategorySpecificity()
{
    return array(0, 0);  // no caching
}

function csvExport($full=FALSE)
{
    return csvExport($this, $full);
}
function showOneRow($rights,&$s)
{
    return showOneRow($this,$rights,$s);
}
function showTools($rights)
{
    return showTools($this,$rights);
}
function showListHeader($isEmpty=FALSE)
{
    return showListHeader($this, $isEmpty);
}
function showListEntry($rights,$tdClass="cell")
{
    return showListEntry($this, $rights, $tdClass);
}
function showDelTool($rights,$from="showHtmlList")
{
    return showDelTool($this, $rights);
}
function showDetailsTool()
{
    return showDetailsTool($this);
}

function showListVal($attr, $format="", $absolute=FALSE)
{
    global $gorumroll, $lll;
    $methodName = "showApp".ucfirst($attr);
    //echo "format: $format, $methodName<br>";
    if( !$format && method_exists($this, $methodName) ) return $this->$methodName($format);
    $typ =& $this->getTypeInfo();
    if( !($attrInfo = & $typ["attributes"][$attr]) ) return FALSE;
    //echo "$attr:<br>";var_dump($attrInfo);
    if( $format=="detailslink" || in_array("detailslink", $attrInfo) )
    {
        $ctrl = new AppController($this->get_class(), "showdetails", $this->id);
        $s=$ctrl->generAnchor($this->getAttr($attr), "", $absolute);
    }
    elseif( isset($attrInfo["link_to"]) )
    {
        $obj = new $attrInfo["link_to"]["class"];
        $obj->id = $this->{$attrInfo["link_to"]["id"]};
        if( !empty($this->{$attr}) )
        {
            $obj->{$attrInfo["link_to"]["other_attr"]} = $this->{$attr};
            $s = $obj->showListVal($attrInfo["link_to"]["other_attr"], "", $absolute);
        }
        elseif( !load($obj) ) 
        {
            //var_dump($attrInfo["link_to"]["other_attr"]);
            $s = $obj->showListVal($attrInfo["link_to"]["other_attr"], "", $absolute);
            //var_dump($s);
            //if( !$s ) var_dump($obj);
        }
        elseif( isset($attrInfo["link_to"]["not_exists"]) ) $s=$attrInfo["link_to"]["not_exists"];
        else $s = "";
    }
    elseif( $format=="safetext" || in_array("safetext", $attrInfo) )
    {
        $s=htmlspecialchars($this->getAttr($attr));
    }
    elseif( $format=="htmltext" || in_array("htmltext", $attrInfo) )
    {
        $s=$this->getAttr($attr);
    }
    elseif( $format=="safetext_br" || in_array("safetext_br", $attrInfo) )
    {
        $s=nl2br(htmlspecialchars($this->getAttr($attr)));
    }
    elseif( isset($attrInfo["prototype"]) && in_array("default_format", $attrInfo))
    {
        $s=isset($this->{$attr}) ? $this->{$attr}->format() : "";
    }
    elseif( $format=="enum" || in_array("enum", $attrInfo) )
    {
        $s = $this->displayEnumValue($attr);
    }
    elseif( $format=="yesno" || in_array("yesno", $attrInfo) )
    {
        $s=$this->{$attr} ? $lll["yes"] : $lll["no"];
    }
    else return FALSE;
    return $s;
}

function displayEnumValue($attr)
{
    global $useHtmlInEnumValues;
    
    if( $this->$attr==="" ) return "";
    $vals = splitByCommas($this->{$attr}, !$useHtmlInEnumValues);
    $lllProp = new LllProperties( $this, $attr );
    $vals =& $lllProp->getSelectLabels($vals);
    return implode(", ", $vals);
}

function getAttr($attr)
{
    global $lll;
    
    if( isset($this->id) && isset($lll[$this->id][$this->get_table()][$attr]) ) $s= $lll[$this->id][$this->get_table()][$attr];
    else $s= $this->$attr;
    //echo("$attr, id: ".$this->id.", class: ".$this->get_table()."<br>");
    //echo("$s<br>");
    return $s;
}

function showDetailsLink($id, $name, $class, $objName="")
{
    if( empty($this->{$name}) )
    {
        if( $this->{$id} )
        {
            if( G::load($obj, $this->{$id}, $class) ) return "Not exists";
            else $this->{$name}=$obj->{$objName};
        }
        else return "None";
    }
    $ctrl = new AppController($class, "showdetails", $this->{$id});
    return $ctrl->generAnchor($this->{$name});
}

function showDetails($whereFields="", $withLoad=TRUE, $elementName="")
{
    global $gorumroll;
    
    if( $withLoad )
    {
        //A gorumroll->rollid-bol,vagy id, vagy name jon attol fuggoen,
        //hogy egyszeru showDetailsrol, vagy showUserLinkrol van-e szo:
        $this->{$whereFields} = $gorumroll->rollid;
        $ret=$this->load(array($whereFields));
        if ($ret==not_found_in_db) return Roll::setInfoText("not_found_deleted");
    }
    $detailsPresentationClassName = G::getSetting($this->getTypeInfo(TRUE), "detailsPresentationClassName");
    $temp = new $detailsPresentationClassName($this);
    $view =& View::getContentView();
    return $temp->gener($view->addElement($elementName));
}

function showNewTool($rights)
{
    return showNewTool($this,$rights);
}
function showCsvExportTool()
{
    return showCsvExportTool($this);
}
function showModTool($rights)
{
    return showModTool($this,$rights);
}

function showNewToolPlusUrl()
{
    global $gorumroll;
    return $gorumroll->rollid;
}

function showHtmlListTitle(&$s)
{
    $s="";
    return ok;
}
function showObjectTools(&$s)
{
    $s="";
    return ok;
}
function showDetailsMethods()
{
    return "";
}

function seoConvert($string, $replacement = '_', $map = array())
{
        if (is_array($replacement)) {
            $map = $replacement;
            $replacement = '_';
        }

        $quotedReplacement = preg_quote($replacement, '/');

      $default = array(
                '/à|á|å|â/' => 'a',
                '/è|é|ê|ẽ|ë/' => 'e',
                '/ì|í|î/' => 'i',
                '/ò|ó|ô|ø/' => 'o',
                '/ù|ú|ů|û|ű/' => 'u',
                '/ç/' => 'c',
                '/ñ/' => 'n',
                '/ä|æ/' => 'ae',
                '/ö/' => 'oe',
                '/ü/' => 'ue',
                '/Ä/' => 'Ae',
                '/Ü/' => 'Ue',
                '/Ö/' => 'Oe',
                '/ß/' => 'ss',
                '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
                '/\\s+/' => $replacement,
                sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
            );

        $map = array_merge($default, $map);
        $newUrl=preg_replace(array_keys($map), array_values($map), $string);
        $buffer=str_replace("%C5%91","o", urlencode($newUrl));
        return urldecode($buffer);
}

function hasAdminRights( &$hasRight, $method="" )
{
    return hasAdminRights( $hasRight, $this, $method );
}
function showBelowList()
{
    return "";
}
function getSelect()
{
    return "";
}
function getLimit()
{
    return getLimit($this);
}
function getOrderBy()
{
    return getOrderBy($this);
}

function getListSelect()
{
    return "SELECT * FROM @".$this->get_table();
}

function getCount(&$count)
{
    global $cookiePath, $noCookieCount;

    //a kuki_count nem list-enkent tarolodik, csak egy van!
    //ez lehet, hogy eleg, de neha gondot okozhat:
    //pl. ketfele lista parhuzamos lapozgatasakor ket kulon ablakban
    if (!$noCookieCount && isset($_COOKIE["kuki_count"]) && $_COOKIE["kuki_count"]) {
        $count = $_COOKIE["kuki_count"];
    }
    else {
        $select = $this->getListSelect(TRUE);  // select only
        if( $select=="" ) {
            handleErr("No select from getSelect class:".
                       $this->get_table(),__FILE__, __LINE__);
        }
        if( is_array($select) ) $select[0] = ereg_replace("SELECT .* FROM", "SELECT COUNT(*) FROM", $select[0]);
        else $select = ereg_replace("SELECT .* FROM", "SELECT COUNT(*) FROM", $select);
        getDbCount($count, $select);
        if( !$noCookieCount )
        {
            setcookie("kuki_count",$count,0, $cookiePath);
            $_COOKIE["kuki_count"]=$count;
        }
    }
    //echo "count:$count";
}
function removeFromTypeInfo($attr,$setting, $typ="")
{

    if( $typ )
    {
        global ${$typ};
        $typ = & ${$typ};
    }
    else $typ= & $this->getTypeInfo();
    $found=FALSE;
    for($i=0;isset($typ["attributes"][$attr][$i]);$i++) {
        if ($typ["attributes"][$attr][$i]==$setting) {
            $found=TRUE;
            break;
        }
    }
    if ($found) unset($typ["attributes"][$attr][$i]);
    return $found;
}

function getNavBarPieces()
{
    return array();
}

function manageWidget()
{
    return manageWidget($this);
}
function showMWOneRow($rights,&$s,$tdClass="listmethod")
{
    return showMWOneRow($this,$rights,$s,$tdClass);
}

// egy az objektum osztalyaban feluldefinialt fg-el lehetoseget adunk
// arra, hogy az objektum erteketol fuggoen belemanipulaljunk a 
// typeInfo-ba. A showHtmlList-ben hivodik.
function preprocessRow()
{
}
function preprocessCell(&$attrInfo, $attr)
{
}

function generateRandomId( &$id )
{
    global $randIdMax,$randIdMin;
    if (!isset($randIdMin)) $randIdMin=0;
    if (!isset($randIdMax)) $randIdMax=getrandmax();
    $obj = new $this->get_class();
    mt_srand((double)microtime()*1000000);
    do
    {
        $id = (int)mt_rand($randIdMin,$randIdMax);
        $obj->id = $id;
        $ret = load($obj);
    }
    while( !$ret );
    return ok;
}

function getPageTitle()
{
    global $gorumroll, $lll;
    $_S = new AppSettings();
    $title = array();
    $cl = $gorumroll->getClass();
    $lllGlobProp = new LllGlobalProperties( new $cl );    
    if( $gorumroll->method=="showdetails" )
    {
        $title[]=sprintf($lll["detail_info"],ucfirst($lllGlobProp->getLabel()));
        if( isset($this->name) ) $title[]=htmlspecialchars($this->name);
        elseif( isset($this->title) ) $title[]=htmlspecialchars($this->title);
        elseif( isset($this->fullName) ) $title[]=htmlspecialchars($this->fullName);
        elseif( isset($this->shortName) ) $title[]=htmlspecialchars($this->shortName);
        elseif( isset($this->subject) ) $title[]=htmlspecialchars($this->subject);
    }
    elseif( $gorumroll->method=="showhtmllist" ) $title[]=$lll[$gorumroll->list."_ttitle"];
    elseif( $gorumroll->method=="modify_form" || $gorumroll->method=="delete_form") 
    {
        if( $gorumroll->method=="delete_form" ) $title[]="Delete ".$lllGlobProp->getLabel();
        else $title[]=$lllGlobProp->getLabel($gorumroll->method);
        if( isset($this->name) ) $title[]=htmlspecialchars($this->name);
        elseif( isset($this->title) ) $title[]=htmlspecialchars($this->title);
        elseif( isset($this->fullName) ) $title[]=htmlspecialchars($this->fullName);
        elseif( isset($this->shortName) ) $title[]=htmlspecialchars($this->shortName);
        elseif( isset($this->subject) ) $title[]=htmlspecialchars($this->subject);
    }
    elseif($t = $lllGlobProp->getLabel($gorumroll->method, FALSE)) $title[]=$t;
    // ha ures, a settings-bol vesszuk a title-t:
    if( !($title=strip_tags(implode(" - ", $title)))) return $_S->getPageTitle();
    return $title;    
}

function getTitlePrefix()
{
	return isset($this->s) ? $this->s->getTitlePrefix() : "";
}

function getPageDescription()
{
    $_S = new AppSettings();
    return $_S->getPageDescription();
}

function getPageKeywords()
{
    $_S = new AppSettings();
    return $_S->getPageKeywords();
}

function & getPager()
{
    if( isset($this->pager) ) return $this->pager;
    $this->pager = new Pager($this);
    return $this->pager;
}

function setInfoText($method)
{
    global $lll, $infoText;
    if( $infoText ) return;
    if( isset($lll[$this->get_class()."_{$method}_completed"]) )
    {
        Roll::setInfoText($this->get_class()."_{$method}_completed");
    }
    elseif( isset($lll[$this->get_class()]) && isset($lll["{$method}_completed"]))
    {
        Roll::setInfoText("{$method}_completed", $lll[$this->get_class()]);
    }
}

function getAdditionalHiddens()
{
    return "";
}

function applyAfterView()
{
    return TRUE;
}

function trimUnnecessaryAssociations(&$base)
{
    unset($base->fields);
}

}//End Class

?>
