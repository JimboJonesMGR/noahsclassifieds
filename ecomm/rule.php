<?php
defined('_NOAH') or die('Restricted access');

$ecommrule_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "model"=>array(
                "type"=>"INT",
            ),
            "action"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "mandatory",
                "details",
                "list",
                "sorta",
                "enum",
                "modify_form: readonly",
            ),
            "consumption"=>array(
                "type"=>"FLOAT",
                "text",
                "default"=>"0",
                "mandatory",
                "list",
                "sorta",
                "details",
                "safetext",
            ),
            "viewNum"=>array(
                "type"=>"INT",
                "text",
                "default"=>"1",
                "min"=>"1",
                "mandatory",
                "safetext",
                "conditions"=>array("@\$this->action==".rule_view=>"details"),
                "filterCharacters"=>"numeric()",
            ),
            "replyNum"=>array(
                "type"=>"INT",
                "text",
                "default"=>"1",
                "min"=>"1",
                "mandatory",
                "safetext",
                "conditions"=>array("@\$this->action==".rule_reply=>"details"),
                "filterCharacters"=>"numeric()",
            ),
            /*
            "daysNum"=>array(
                "type"=>"INT",
                "text",
                "default"=>"1",
                "min"=>"1",
                "mandatory",
                "safetext",
                "conditions"=>array("@\$this->action==".rule_beingRegistered." || @\$this->action==".rule_beingSubmitted=>"details"),
                "filterCharacters"=>"numeric()",
            ),
            "sendNotification"=>array(
                "type"=>"INT",
                "bool",
                "yesno",
                "default"=>"0",
                "conditions"=>array("@\$this->action==".rule_beingRegistered." || @\$this->action==".rule_beingSubmitted=>"details"),
            ),
            "onExpiry_registered"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "default"=>1,
                "enum",
                "values"=>array(1,2),
            ),
            "onExpiry_submitted"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "default"=>1,
                "enum",
                "values"=>array(1,2),
            ),
            */
            "cid"=>array(
                "type"=>"INT",
                "classselection",
                "class"=>"category",
                "labelAttr"=>"wholeName",
                "nothing selected"=>"allCategories",
                "get_values_callback"=>'getSelectFromTree()',
                "conditions"=>array("@\$this->action!=".rule_registration=>"details"),
                "list",
                "sorta"
            ),
            "includeSubcats"=>array(
                "type"=>"INT",
                "bool",
                "yesno",
                "default"=>"0",
                "conditions"=>array("@\$this->action!=".rule_registration." && @\$this->action!=".rule_setField." && @\$this->action!=".rule_setFieldToValue." && @\$this->cid"=>"details"),
            ),
            "ruleField"=>array(
                "type"=>"INT",
                "values"=>array(),
                "mandatory",
                "labelAttr"=>"name",
                "conditions"=>array("@\$this->action==".rule_setField." || @\$this->action==".rule_setFieldToValue=>"details",
                                    "strstr(\$gorumroll->method,'modify') && 
                                    (@\$this->action==".rule_setField." || @\$this->action==".rule_setFieldToValue.")"=>"classselection",
                                    "\$gorumroll->method=='create_form'"=>"selection",
                                    "@\$this->action==".rule_setFieldToValue=>array("get_values_callback"=>"getFields(TRUE)"),
                                    "@\$this->action==".rule_setField       =>array("get_values_callback"=>"getFields()")),
            ),
            "ruleValue"=>array(
                "type"=>"INT",
                "selection",
                "mandatory",
                "values"=>array(),
                "conditions"=>array("@\$this->action==".rule_setFieldToValue=>"details",
                                    "\$gorumroll->method=='create_form'"=>array("values"=>array()),
                                    "\$gorumroll->method=='modify_form' && @\$this->action==".rule_setFieldToValue=>array("values"=>"\$this->base->getFieldValues()")),
            ),
            "interactionTexts"=>array(
                "type"=>"INT",
                "section",
                "no column"
            ),
            "confirmationTextType"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "values"=>array(rule_generic, rule_customized),
                "default"=>"0",
                "enum",
                "details",
            ),
            "confirmationText"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>'740px',
                "rows"=>3,
                "allow_html",
                "markitup"=>array("set"=>"ad_html"),
                "widecontent_form",
                "conditions"=>array("@\$this->confirmationTextType==".rule_customized=>"details"),
                "htmltext",
            ),
            "successTextType"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "values"=>array(rule_generic, rule_customized),
                "default"=>"0",
                "enum",
                "details",
            ),
            "successText"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>'740px',
                "rows"=>5,
                "allow_html",
                "markitup"=>array("set"=>"ad_html"),
                "widecontent_form",
                "conditions"=>array("@\$this->successTextType==".rule_customized=>"details"),
                "htmltext",
            ),
            "failTextType"=>array(
                "type"=>"INT",
                "radio",
                "cols"=>1,
                "values"=>array(rule_generic, rule_customized),
                "default"=>"0",
                "enum",
                "details",
            ),
            "failText"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>'740px',
                "rows"=>5,
                "allow_html",
                "markitup"=>array("set"=>"ad_html"),
                "widecontent_form",
                "conditions"=>array("@\$this->failTextType==".rule_customized=>"details"),
                "htmltext",
            ),
        ),
        "primary_key"=>"id",
        "sort_criteria_sql"=>"id ASC",
    );
    
/* TODO
$lll["creditrule_action_".rule_submit]="Ad submission";
$lll["creditrule_action_".rule_beingSubmitted]="Being submitted";
$lll["creditrule_daysNum"]="Number of days";
$lll["creditrule_sendNotification"]="Send notification";
$lll["creditrule_sendNotification_expl"]="If checked, the program will send a notification mail to the user whenever credits are drawn from his/her pool by this credit rule.";
$lll["creditrule_onExpiry_registered"]=$lll["creditrule_onExpiry_submitted"]="On expiry";
$lll["creditrule_onExpiry_registered_expl"]=$lll["creditrule_onExpiry_submitted_expl"]="What happens, if the user has no more credits to deduct from.";
$lll["creditrule_onExpiry_registered_1"]="Block user";
$lll["creditrule_onExpiry_registered_2"]="Delete user";
$lll["creditrule_onExpiry_submitted_1"]="Set to inactive";
$lll["creditrule_onExpiry_submitted_2"]="Delete ad";
*/  

class ECommRule extends Object
{
    
function get_table() { return "ecommrule"; }

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll;

    hasAdminRights($isAdm);
    $hasRight->generalRight = TRUE;
    $hasRight->objectRight=($method=="load" || $isAdm);
    if( !$hasRight->objectRight && $giveError ) {
        handleError($lll["permission_denied"]);
    }
}

function getSelectFromTree($overrideCascading=0)
{
    return Item::getSelectFromTree($forTheSearchForm = FALSE, $noFilter=FALSE, $attrs="", $overrideCascading);
}

function getFields($onlySelectFields=FALSE)
{
    return CustomField::getFieldsForRules($this->cid, $onlySelectFields);    
}

function getFieldValues()
{
    global $lll;
    
    CustomField::getValuesForRules($this->ruleField, $labels, $values);
    for( $i=0; $i<count($values); $i++ )
    {
        $lll["ruleValue_$i"]=$labels[$i];
    }
    return $values;
}

function create($fromInstall=FALSE)
{    
    if( !$this->validRule() ) return FALSE;
    $_ES = new ECommSettings();
    $this->model = $_ES->model;
    Object::create();
}

function modify()
{   
    if( !$this->validRule() ) return FALSE;
    Object::modify();
}

function validRule()
{
    global $lll, $gorumroll;
    
    if( !$this->consumption ) return Roll::setFormInvalid("mandatoryField", $lll[$this->get_class()."_consumption"]);
    if( ($this->action==rule_setField || $this->action==rule_setFieldToValue) && !$this->ruleField ) return Roll::setFormInvalid("mandatoryField", $lll["ruleField"]);
    $query = "SELECT COUNT(*) FROM @ecommrule WHERE ".ECommRule::getWhereCond($this->action);
    if( $gorumroll->method=="modify" ) $query.=" AND id!=".quoteSQL($this->id);
    getDbCount( $count, array($query, $this->action, @$this->cid, @$this->ruleField, @$this->ruleValue, 0) );
    if( $count ) return Roll::setFormInvalid($this->get_class()."_duplicateRule");
    return TRUE;
    
}

function generForm()
{
    global $gorumroll, $jQueryLib, $lll;
    
    if( $gorumroll->method=="modify_form" || $gorumroll->method=="create_form" )
    {
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/field.js");
        JavaScript::addInclude(JS_DIR . "/credit_rule_form.js");
    }
    if( $gorumroll->method=="modify_form" ) 
    {
        $lll["ecommrule_action_expl"]="";
    }
    parent::generForm();
}

function showListVal($attr)
{
    global $lll, $gorumroll;

    $s="";
    if( ($s=parent::showListVal($attr))!==FALSE ) return $s;
    if ($attr=="cid") // a modify formban readonly a cid
    {
        if( !$this->cid ) return $this->action==rule_registration ? "" : $lll["allCategories"];
        elseif( $gorumroll->method=="showdetails" ) return htmlspecialchars(G::getAttr($this->cid, "appcategory", "wholeName"));
        else return htmlspecialchars(G::getAttr($this->cid, "appcategory", "name"));
    }
    elseif ($attr=="ruleField")
    {
        return htmlspecialchars(G::getAttr($this->ruleField, "itemfield", "name"));
    }
    elseif ($attr=="ruleValue") 
    {
        G::load( $field, $this->ruleField, "itemfield" );
        if( $field->type==customfield_bool )
        {
            return $this->ruleValue ? $lll["yes"] : $lll["no"];
        }
        else
        {
            $labels = split(", *", $field->values);
            return htmlspecialchars($labels[$this->ruleValue]);
        }
        
    }
    else $s=Object::showListVal($attr, "safetext");
    return $s;
}

function loadRule($action, $cid=0, $field=0, $value=0, $columnIndex='' )
{
    $_ES = new ECommSettings();
    $classNames = array(ecomm_simple=>"PaymentRule", ecomm_advanced=>"CreditRule");
    $query = "SELECT * FROM @ecommrule WHERE ".ECommRule::getWhereCond($action)." LIMIT 1";
    $className = $classNames[$_ES->model];
    $obj = new $className;
    if( !loadSQL($obj, array($query, $action, $cid, $field, $value, 0)) ) return $obj; 
    if( $cid && !in_array($action, array(rule_registration, rule_setField, rule_setFieldToValue)) )
    {
        // vegigmegyunk a szulo kategoriakon, hogy van-e olyan rule bennuk, ami az alkategoriakra is vonatkozik:
        $up = G::getAttr( $cid, "appcategory", "up");
        $ruleFound = FALSE;
        while( $up && !$ruleFound )
        {
            $ruleFound = !loadSQL($obj, array($query, $action, $up, 1)); //includeSubcats
            if( !$ruleFound ) $up = G::getAttr( $up, "appcategory", "up");
        }
        if( $ruleFound ) return $obj;
    }
    if( in_array($action, array(rule_setField, rule_setFieldToValue)) )
    {
        // ha category specifikus rule-t nem talaltunk, akkor meg kell nezni, hogy common field-hez kotodo rule van-e.
        // ehhez elobb a category specifikus field-nek megfelelo common field-et kerdezzuk le:
        if( !loadSQL( $cf = new ItemField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='$columnIndex'" ))
        {
            if( !loadSQL( $obj, array($query, $action, 0, $cf->id, $value, 0)) ) return $obj;
        }
    }
    elseif( !loadSQL( $obj, array($query, $action, 0, $field, $value, 0)) ) return $obj;
    return FALSE;
}

function loadSetFieldToValueRules($action, $cid=0, $field=0, $columnIndex='' )
{
    $_ES = new ECommSettings();
    $classNames = array(ecomm_simple=>"PaymentRule", ecomm_advanced=>"CreditRule");
    $query = "SELECT * FROM @ecommrule WHERE ".ECommRule::getWhereCond($action, FALSE);
    $className = $classNames[$_ES->model];
    if( loadObjectsSql( $objs = new $className, array($query, $action, $cid, $field, 0), $objs) ) 
    {
        // ha category specifikus rule-t nem talaltunk, akkor meg kell nezni, hogy common field-hez kotodo rule van-e.
        // ehhez elobb a category specifikus field-nek megfelelo common field-et kerdezzuk le:
        if( !loadSQL( $cf = new ItemField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='$columnIndex'" ))
        {
            loadObjectsSql( $objs = new $className, array($query, $action, 0, $cf->id, 0), $objs);
        }
    }
    return $objs;
}

function getWhereCond($action, $addRuleValueCondition=TRUE)
{
    $_ES = new ECommSettings();
    $cond = "model=$_ES->model AND action=#action#";
    if( $action!=rule_registration ) $cond.=" AND cid=#cid#";
    if( $action==rule_setField || $action==rule_setFieldToValue ) $cond.=" AND ruleField=#field#";
    if( $addRuleValueCondition && $action==rule_setFieldToValue ) $cond.=" AND ruleValue=#value#";
    $cond.=" AND includeSubcats>=#includeSubcats#";
    return $cond;
}

function getListSelect()
{
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));     
    
    $_ES = new ECommSettings();
    return "SELECT * FROM @ecommrule WHERE model=".$_ES->model;
}

function confirmRules($cid, $oldItem=0) 
{
    global $gorumroll, $gorumuser;
    
    hasAdminRights($isAdm);
    if( $isAdm || (ECommFull::isAdvancedModelEnabled() && $gorumuser->getDaysLeft()>0) ) return; 
    if( $gorumroll->method=="create_form" && !Roll::isPreviousFormSubmitInvalid() ) 
    {
        if( !$gorumuser->checkCreditConsumption(rule_submit, $cid) )
        {
            $rule = ECommRule::loadRule(rule_submit, $cid);
            $rule->addPopup("failText", TRUE);
        }
        elseif( ($rule = ECommRule::loadRule(rule_submit, $cid))!==FALSE )
        {
            $rule->addPopup("confirmationText");
        }
    }
    if( $gorumroll->method=="create_form" || $gorumroll->method=="modify_form" ) 
    {
        foreach( CustomField::getFieldsForRules($cid) as $field )
        {
            if( (!$oldItem || empty($oldItem->{$field->columnIndex}) ) && // csak ha meg nem volt beallitva
                $rule = ECommRule::loadRule(rule_setField, $cid, $field->id, 0, $field->columnIndex))
            {
                $rule->addInlineWarning("confirmationText", $field);
            }
            if( $oldItem )
            {
                if( $field->type==customfield_checkbox || $field->type==customfield_multipleselection )
                {
                    $oldValues = explode(",", $oldItem->{$field->columnIndex});
                }
                else $oldValues = array($oldItem->{$field->columnIndex});
            }
            $rules = ECommRule::loadSetFieldToValueRules(rule_setFieldToValue, $cid, $field->id, $field->columnIndex);
            foreach( $rules as $rule ) 
            {
                if( $oldItem && in_array($rule->ruleValue, $oldValues) ) continue; // ha ez az ertek mar benne van
                $rule->addInlineWarning("confirmationText", $field);
            }
        }
    }
    if( $gorumroll->method=="showdetails" ) 
    {
    }
}

function checkConsumptionOfAction(&$purchaseItem, &$consumption, &$item, $oldItem=0) 
{
    global $gorumroll, $gorumuser, $lll;
    
    $consumption = $purchaseItem = 0;
    $description = array();
    hasAdminRights($isAdm);
    
    if( $isAdm || (($isAdvancedModel = ECommFull::isAdvancedModelEnabled()) && $gorumuser->getDaysLeft()>0) ) return TRUE;
    if( $gorumroll->method=="modify" || $gorumroll->method=="create" ) $actions  = array(rule_setField, rule_setFieldToValue); 
    if( $gorumroll->method=="create" )                                 $actions[]= rule_submit; 



    foreach( $actions as $action )
    {
        switch( $action )
        {
        case rule_submit:
            if( $rule = ECommRule::loadRule(rule_submit, $item->cid) ) 
            {
                $consumption += $rule->consumption;
                $description[]= $rule->getDescription();
            }
            break;
        case rule_setField:
            foreach( CustomField::getFieldsForRules($item->cid) as $field )
            {
                if( $oldItem && !empty($oldItem->{$field->columnIndex}) ) continue;  // csak ha meg nem volt beallitva
                
                if( (!empty($item->{$field->columnIndex}) || (isset($_FILES[$field->columnIndex]) && !empty($_FILES[$field->columnIndex]["name"])) ) &&
                    $rule = ECommRule::loadRule(rule_setField, $item->cid, $field->id, 0, $field->columnIndex)) 
                {
                    $consumption += $rule->consumption;
                    $description[]= $rule->getDescription();
                }
            }                
            break;
        case rule_setFieldToValue:
            foreach( CustomField::getFieldsForRules($item->cid, TRUE) as $field )
            {
                if( !isset($item->{$field->columnIndex}) ) continue;
                $values = is_array($item->{$field->columnIndex}) ? $item->{$field->columnIndex} : array($item->{$field->columnIndex});
                if( $oldItem )
                {
                    if( $field->type==customfield_checkbox || $field->type==customfield_multipleselection )
                    {
                        $oldValues = explode(",", $oldItem->{$field->columnIndex});
                    }
                    else $oldValues = array($oldItem->{$field->columnIndex});
                }

                CustomField::getValuesForRules($field->id, $labels, $fldvalues);
               
                foreach( $values as $value ) 
                {
                    if( $oldItem && in_array($value, $oldValues) ) continue;  // csak ha korabban mas erteke volt
                    
                    $key = array_search($value, $labels); 
                    if( $rule = ECommRule::loadRule(rule_setFieldToValue, $item->cid, $field->id, $fldvalues[$key], $field->columnIndex) )
                    {
                        $consumption += $rule->consumption;
                        $description[]= $rule->getDescription();
                    }
                }
            }
            break;
        default: break;    
        }
    }
    
    if( $isAdvancedModel && $consumption>$gorumuser->credits )
    {
        return Roll::setFormInvalid(ECommRule::insertCreditValuesIntoText($lll["actionCostsTooManyCredits"], $consumption, $gorumuser->credits));
    }
    elseif( !$isAdvancedModel && $consumption )
    {
        Roll::setInfoText("proceedPaymentToActivateAd_$gorumroll->method");
        $purchaseItem = new PurchaseItem;
        $purchaseItem->uid = $gorumuser->id;
        $purchaseItem->iid = $item->id;
        $purchaseItem->type = ecomm_pending;
        $purchaseItem->price = $consumption;
        $purchaseItem->creationtime = time();
        $purchaseItem->description = implode("\n", $description);
        $item->nextAction = new AppController("purchaseitem");
    }
    return TRUE;
}

function addPopup($textField, $onSubmitToo=FALSE)
{
    global $gorumuser, $lll;
    
    if( !($text = $this->getText($textField)) ) return;
    $overlay = new OverlayController(array(
        "content"=>GenerWidget::generConfirmation($lll["confirmation"], $text, array("continue")),
        "id"=>"overlayConfirmation",
        "height"=>160,
        "expose"=>TRUE,
        "triggerSelector"=>"#overlayConfirmation",
        "close"=>"div.close, input.confirmation_continue",
    ));
    JavaScript::addInclude(JS_DIR . "/apply_rule.js");
    JavaScript::addOnload("$.noah.popupOverlayOnLoad('#overlayConfirmation');");
    if( $onSubmitToo )
    {
        JavaScript::addOnload("$.noah.popupOverlayOnSubmit('#overlayConfirmation');");
    }
}

function addInlineWarning($textField, $field)
{
    $attr = $field->columnIndex;
    if( !($text = $this->getText($textField)) ) return;
    JavaScript::addInclude(JS_DIR . "/apply_rule.js");
    if( $this->action==rule_setField ){
      JavaScript::addOnload("$.noah.addInlineWarningOnFocus('$attr', " . G::js($text) . ");");  
      if ($field->type == customfield_url )
      {
        JavaScript::addOnload("$.noah.addInlineWarningOnFocus('$attr\\[0\\]', " . G::js($text) . ");");
        JavaScript::addOnload("$.noah.addInlineWarningOnFocus('$attr\\[1\\]', " . G::js($text) . ");");
      }
    } 
    elseif( $this->action==rule_setFieldToValue ) 
    {
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/field.js");
      if ($field->type == customfield_multipleselection || $field->type == customfield_selection)
      {
        CustomField::getValuesForRules($this->ruleField, $labels, $values); 
        $theLabel = $labels[$this->ruleValue];
        JavaScript::addOnload("$.noah.addInlineWarningOnChange('$attr', '$theLabel', " . G::js($text) . ");");
      }
      elseif ($field->type == customfield_checkbox || $field->type == customfield_bool)
      {
        CustomField::getValuesForRules($this->ruleField, $labels, $values); 
        $theLabel = $labels[$this->ruleValue];
        if ($field->type == customfield_checkbox)
            JavaScript::addOnload("$.noah.addInlineWarningOnMultiChange('$attr\\[$this->ruleValue\\]', '$theLabel', " . G::js($text) . ");");   
        else
            JavaScript::addOnload("$.noah.addInlineWarningOnMultiChange('$attr', '$theLabel', " . G::js($text) . ");");
      } else
        JavaScript::addOnload("$.noah.addInlineWarningOnChange('$attr', '$this->ruleValue', " . G::js($text) . ");");
      

    }
}

function getText($textField)
{
    global $lll, $gorumuser;
    
    if( $this->{$textField."Type"}==rule_generic ) 
    {
        $label3 = "{$textField}Generic";
        $label2 = "{$label3}_$this->action";
        $label1 = $this->get_class()."_$label2";
        $text = isset($lll[$label1]) ? $lll[$label1] : (isset($lll[$label2]) ? $lll[$label2] : $lll[$label3]);
    }
    elseif( $this->$textField ) $text = $this->$textField;
    else return "";
    return $this->insertCreditValuesIntoText($text, $this->showListVal("consumption"), $gorumuser->credits); 
}

function insertCreditValuesIntoText($text, $creditsRequested, $creditsLeft)
{
    return preg_replace(array("/@@creditsRequested@@/", "/@@creditsLeft@@/"), array($creditsRequested, $creditsLeft), sprintf($text, $creditsRequested));
}

function getDescription()
{
    global $lll;
    
    if( $this->action==rule_setField || $this->action==rule_setFieldToValue )
    {
        return sprintf( $lll["rule_description_$this->action"], $this->showListVal("ruleField"), $this->showListVal("consumption") );
    }
    else return sprintf( $lll["rule_description_$this->action"], $this->showListVal("consumption") );
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
    
    $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    $navBarPieces[$lll["creditRules"]] = $gorumroll->method=="showhtmllist" ? "" : new AppController("creditrule/list");
    return $navBarPieces;
}
}

?>