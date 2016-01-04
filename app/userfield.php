<?php
defined('_NOAH') or die('Restricted access');

$userfield_typ = $customfield_typ;
unset($userfield_typ["attributes"]["oldColumnIndex"]);
unset($userfield_typ["attributes"]["userField"]);
unset($userfield_typ["attributes"]["isCommon"]);
unset($userfield_typ["attributes"]["fieldExpirationDays"]);
$userfield_typ["attributes"]["showInDetails"]["values"] = array(customfield_forNone, customfield_forAll, customfield_forLoggedin, customfield_forAdmin, customfield_forManager);
$userfield_typ["attributes"]["listProperties"]["conditions"]=
$userfield_typ["attributes"]["detailsProperties"]["conditions"]=
$userfield_typ["attributes"]["showInDetails"]["conditions"]=
$userfield_typ["attributes"]["miscProperties"]["conditions"]=
$userfield_typ["attributes"]["searchable"]["conditions"]=
$userfield_typ["attributes"]["showInList"]["conditions"]=array("@\$this->columnIndex=='rememberPassword' || @\$this->columnIndex=='remindPasswordLink'"=>"form invisible");
$userfield_typ["attributes"]["formProperties"]["conditions"]=
$userfield_typ["attributes"]["showInForm"]["conditions"]=array("@\$this->columnIndex=='creationtime' || @\$this->columnIndex=='lastClickTime' || @\$this->columnIndex=='viewAdsLink'"=>"form invisible");
$userfield_typ["attributes"]["ecommAssignment"]["conditions"]=array("\$_S->ecommerceEnabled() && \$this->isFixField()===FALSE"=>"selection");

class UserField extends CustomField 
{
    
function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll;

    parent::hasObjectRights($hasRight, $method, $giveError);
    if( $method=="modify" ) $hasRight->generalRight = FALSE;
    if( $hasRight->objectRight==TRUE && $method=="modify" && $this->disableModify() ) $hasRight->objectRight=FALSE;
    if( !$hasRight->objectRight && $giveError ) {
        handleError($lll["permission_denied"]);
    }
}

function disableModify()
{
    return isset($this->columnIndex) && 
           ($this->columnIndex=="password" || $this->columnIndex=="changePassword" || 
            $this->columnIndex=="passwordCopy" || $this->columnIndex=="active");
}

function getManagedTable() { return "user"; }
   
function displayInForm( &$attrInfo )
{
    global $gorumroll;
    if( (($gorumroll->method=="login_form" || $gorumroll->method=="remind_password_form") && !$this->isFixField()) ||
        ($gorumroll->method!="login_form" && $this->columnIndex=="remindPasswordLink") ) $attrInfo[]="form invisible";
    elseif( (($this->columnIndex=="email" || $this->columnIndex=="name") && $gorumroll->method=="modify_form") ||
        ($this->columnIndex!="email" && $this->columnIndex!="name"))
    {
        parent::displayInForm( $attrInfo );
    }
}

function delete()
{
    parent::delete();
    G::load( $relatedFields, array("SELECT * FROM @customfield WHERE userField=#id#", $this->id));
    foreach( $relatedFields as $f ) $f->delete();
}

function getListSelect()
{
    
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));     
    
    $_S = new AppSettings();
    $query = "SELECT id, name, type, sortId, columnIndex FROM @customfield WHERE cid=0 AND isCommon=0";
    if( !$_S->ecommerceEnabled() ) $query.=" AND columnIndex!='credits' AND columnIndex!='expirationTime'";
    return $query;
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
    
    $navBarPieces = User::getNavBarPieces(TRUE);
    $navBarPieces[$lll["userfield_ttitle"]] = $gorumroll->method=="showhtmllist" ? "" : new AppController("userfield/sortfield_form/");
    return $navBarPieces;
}

function getAttr($attr)
{
    global $lll;
    
    if( isset($this->id) && isset($lll[$this->id]["customfield"][$attr]) ) return $lll[$this->id]["customfield"][$attr];
    if( $attr!="name" ) return $this->$attr;
    if( isset($lll["user_$this->columnIndex"]) ) return $lll["user_$this->columnIndex"];
    return htmlspecialchars($this->name);        
}

}// end class UserField

?>
