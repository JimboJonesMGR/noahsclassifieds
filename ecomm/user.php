<?php
defined('_NOAH') or die('Restricted access');

class ECommUser extends User
{

function get_table() { return "user"; }    

function lowLevelLogin()
{ 
    $_S = new AppSettings();
    if( !parent::lowLevelLogin() || !$_S->ecommerceEnabled() ) return;
    hasAdminRights($isAdm);
    load($this);
    if( !$isAdm && $this->isPurchaseAdvised() )
    {
        $this->nextAction = new AppController("purchaseitem");
    }
}

function getEcommType() 
{ 
    if( $this->getDaysLeft()>0 ) return ecomm_subscription;
    else return ecomm_credit; 
}

function getCredits() 
{ 
    return $this->credits; 
}

function getExpirationTime() 
{ 
    if( $this->expirationTime->isEmpty() ) return 0;
    return $this->expirationTime->lastSecondOfDay(); 
}

function getDaysLeft() 
{ 
    if( !($ex = $this->getExpirationTime()) ) return 0;
    $s=ceil($ex->getDayDiff());
    if( $ex->isPast() ) $s = "-$s";
    return $s; 
}

function isPurchaseNecessary()
{
    if( !ECommFull::isAdvancedModelEnabled() ) return FALSE;
    return $this->getDaysLeft()<=0 && $this->getCredits()<=0; 
}

function isPurchaseAdvised()
{
    if( !ECommFull::isAdvancedModelEnabled() ) return FALSE;
    if( $this->isPurchaseNecessary() ) return TRUE;
    $_ES = new ECommSettings();
    if( $this->getEcommType()==ecomm_subscription ) 
    {
        return $_ES->expNoticeBefore_subscription==0 || 
               $this->getDaysLeft() < $_ES->expNoticeBefore_subscription;
    }
    else return $_ES->expNoticeBefore_credits==0 || 
                $this->getCredits() <= $_ES->expNoticeBefore_credits;
}

function showECommStatus()
{
    global $lll;
    
    if( !ECommFull::isAdvancedModelEnabled() ) return FALSE;
    if( $this->getEcommType()==ecomm_subscription ) 
    {
        return sprintf($lll["ecommuser_daysLeft"], $this->getDaysLeft());
    }
    else return sprintf($lll["ecommuser_creditsLeft"], $this->getCredits());
}

function addTestUser()
{
    // Tesztjuzerek:
    $u = new User;
    $u->activateVariableFields();
    $u->id = "100";
    $u->name="ecommtest";
    $u->email="";
    $u->active=1;
    $u->password=getPassword("a");
    $u->set("First name", "EComm");
    $u->set("Last name", "Test");
    $u->set("State", "Arizona");
    $u->set("Country", "United States");
    $u->set("City", "Chicago");
    $u->set("Post code", "55555");
    $u->set("Street", "Apple st. 15");
    $u->set("Married", TRUE);
    $u->set("Age", 77);
    $u->set("Date of birth", new Date("1931-10-23"));
    $u->set("About me", "");
    $u->set("Picture", "");
    create($u);
}

function copyPurchaseFormFields( &$obj, $addCSlashes=FALSE )
{
    global $ecommAssignmentToFieldMapping;
    
    $this->activateVariableFields();
    load($this);
    $obj->email = $this->email;
    foreach( $this->getFields() as $field )
    {
        if( $field->ecommAssignment ) 
        {
            $val = $field->type==customfield_text || $field->type==customfield_textarea ? 
                   ($addCSlashes ? addcslashes($this->{$field->columnIndex}, "'\"") : $this->{$field->columnIndex}) : 
                   $this->showListVal($field->columnIndex);
            $obj->{$ecommAssignmentToFieldMapping[$field->ecommAssignment]} = $val;
        }
    }
    $_ES = new ECommSettings();
    $fieldsToDisplay = explode(",", $_ES->purchaseFormFields);
    $ecommAssignmentToFieldMappingFlipped = array_flip($ecommAssignmentToFieldMapping);
    foreach( array('firstName','lastName','address','city','state','zip','country','phone','fax','email') as $field )
    {
        if( !in_array( $ecommAssignmentToFieldMappingFlipped[$field], $fieldsToDisplay ) || !isset($obj->$field) ) $obj->$field='';
    }
    
}

function giftUsers($days=FALSE)
{
    global $gorumroll, $lll;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) return;
    $what = $days ? "expirationTime" : "credits";
    //G::load( $users, "SELECT id,  FROM " )
    if( $days )
    {
        $what = "expirationTime";
        $amount="IF(expirationTime=0,NOW() + INTERVAL $gorumroll->rollid DAY, expirationTime + INTERVAL $gorumroll->rollid DAY)";
        $txt = $lll["daysSuccessfullyAdded"];
    }
    else
    {
        $what = "credits";
        $amount="credits + $gorumroll->rollid";
        $txt = $lll["creditsSuccessfullyAdded"];
    }
    executeQuery("UPDATE @user SET $what=$amount WHERE id!=name AND isAdm=0");
    echo "<div id='infoText'>$gorumroll->rollid $txt</div>";
    die();
}

function create()
{
    if( !$pwd = parent::create() ) return FALSE;
    load($this);
    $this->applyCreditRules(rule_registration);
    return $pwd;
}

function applyCreditRules( $action, $cid=0, $field=0, $value=0 )
{
    if( !ECommFull::isAdvancedModelEnabled() ) return; 
    if( !($rule = ECommRule::loadRule($action, $cid, $field, $value)) ) return;
    $this->credits-=$rule->consumption;
    modify($this); 
}

function checkCreditConsumption( $action, $cid=0, $field=0, $value=0 )
{
    if( !ECommFull::isAdvancedModelEnabled() ) return TRUE; 
    if( !($rule = ECommRule::loadRule($action, $cid, $field, $value)) ) return TRUE;
    return $this->credits>=$rule->consumption;
}

}
?>
