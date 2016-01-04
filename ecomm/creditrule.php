<?php
defined('_NOAH') or die('Restricted access');

$creditrule_typ = $ecommrule_typ;
$creditrule_typ["attributes"]["consumption"]["filterCharacters"]="numeric({allow:'-'})";
//$creditrule_typ["attributes"]["action"]["values"]=range(1, rule_setFieldToValue);
$creditrule_typ["attributes"]["action"]["values"]=array(rule_registration, rule_submit, rule_setField, rule_setFieldToValue);

class CreditRule extends ECommRule
{

function validRule()
{
    global $lll, $gorumroll;
    
    if( !parent::validRule() ) return FALSE;
    if( $this->action==rule_view && !$this->viewNum ) return Roll::setFormInvalid("mustBeGreaterInt", $lll["creditrule_viewNum"], 1 );
    if( $this->action==rule_reply && !$this->replyNum ) return Roll::setFormInvalid("mustBeGreaterInt", $lll["creditrule_replyNum"], 1 );
    if( $this->action==rule_registration && $this->consumption>0 ) return Roll::setFormInvalid("regRuleMustbeNegative");
    return TRUE;
    
}

function addDefaultCreditRules()
{    
    $cl = new CreditRule;
    $cl->model = ecomm_advanced;
    $cl->action = rule_registration;
    $cl->consumption = -100;
    $cl->create();
    
    $cl = new CreditRule;
    $cl->model = ecomm_advanced;
    $cl->action = rule_submit;
    $cl->consumption = 10;
    $cl->create();
    
    /*
    $cl = new CreditRule;
    $cl->model = ecomm_advanced;
    $cl->action = rule_view;
    $cl->consumption = 1;
    $cl->viewNum = 5;
    $cl->create();
    */    
}        

}

?>