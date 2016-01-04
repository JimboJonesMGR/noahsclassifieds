<?php
defined('_NOAH') or die('Restricted access');

$paymentrule_typ = $ecommrule_typ;
unset($paymentrule_typ["attributes"]["viewNum"]);
unset($paymentrule_typ["attributes"]["replyNum"]);
unset($paymentrule_typ["attributes"]["successTextType"]);
unset($paymentrule_typ["attributes"]["successText"]);
unset($paymentrule_typ["attributes"]["failTextType"]);
unset($paymentrule_typ["attributes"]["failText"]);
$paymentrule_typ["attributes"]["consumption"]["filterCharacters"]="numeric({allow:'$defaultPrecisionSeparator'})";
$paymentrule_typ["attributes"]["action"]["values"]=array(rule_submit, rule_setField, rule_setFieldToValue);

class PaymentRule extends ECommRule
{

function showListVal($attr)
{
    if ($attr=="consumption")
    {
        $_ES = new ECommSettings();
        $s = $_ES->formatPrice($this->$attr);
    }
    else $s=parent::showListVal($attr);
    return $s;
}

}

?>