<?php
defined('_NOAH') or die('Restricted access');


$user_typ=
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "min" =>"1",
                "create_form: form invisible",
                "login_form: form invisible",
                "remind_password_form: form invisible",
                "form hidden"
            ),
            "name"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"32",
                "min" =>"1",
                "mandatory",
                "detailslink",
                "remind_password_form: form invisible",
            ),
            "email"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"64",
                "min" =>"1",
            ),
            "changePassword"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "remind_password_form: form invisible",
                "create_form: form invisible",
                "login_form: form invisible",
            ),
            "password"=>array(
                "type"=>"VARCHAR",
                "max" =>"32",
                "remind_password_form: form invisible",
                "create_form: form invisible",
                "password"
            ),
            "passwordCopy"=>array(
                "type"=>"VARCHAR",
                "max" =>"32",
                "password",
                "remind_password_form: form invisible",
                "login_form: form invisible",
                "create_form: form invisible",
                "no column"
            ),
            "newPassword"=>array(
                "type"=>"VARCHAR",
                "max" =>"32",
                "default"=>"",
                "password",
                "form invisible",
            ),
            "rememberPassword"=>array(
                "type"  =>"INT",
                "bool",
                "default"=>"0",
                "remind_password_form: form invisible",
                "create_form: form invisible",
            ),
            "isAdm"=>array(
                "type"  =>"INT",
                "default"=>"0",
                "form invisible",
            ),
            "creationtime"=>array(
                "type"=>"DATETIME",
                "form invisible",
            ),
            "lastClickTime"=>array(
                "type"=>"DATETIME",
                "prototype"=>"date",
                "form invisible",
            ),
            "active"=>array(
                "type"  =>"INT",
                "default"=>"0",
                "yesno",
                "conditions"=>array("!\$isAdm"=>"form invisible",
                                    "\$isAdm"=>"details"),
            ),
            "isManager"=>array(
                "type"  =>"INT",
                "default"=>"0",
                "yesno",
                "conditions"=>array("!\$isAdm"=>"form invisible",
                                    "\$isAdm"=>"details"),
            ),
            "captchaField"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("\$this->hasCaptchaInForm()"=>"text"),
                "max" =>"250",
                "length"=>10,
                "no column",
            ),
            "remindPasswordLink"=>array(
                "type"=>"INT",
                "no column",
                "txtsection"
            ),
            "favorities"=>array(
                "type"=>"TEXT",
                "form invisible",
            ),
            "viewAdsLink"=>array(
                "type"=>"INT",
                "no column",
                "form invisible",
            ),
            "ecommType"=>array(
                "type"=>"INT",
                //"conditions"=>array("\$isAdm && \$settings->ecommerceEnabled()"=>"radio"),
                "cols"=>1,
                "values"=>array(1, 2), // ecomm_credit, ecomm_subscription
                "default"=>"1", //ecomm_credit
                "show_relation"=>array(1=>"credit", 2=>"subscription"),
            ),
            "credits"=>array(
                "type"=>"INT",
                "conditions"=>array("\$isAdm && \$_S->ecommerceEnabled() && \$_EC->isAdvancedModelEnabled()"=>"text",
                                    "!\$_S->ecommerceEnabled()"=>"form invisible"),
                "relation"=>"credit",
                "safetext"
            ),
            "expirationTime"=>array(
                "type"=>"DATE",
                "conditions"=>array("\$isAdm && \$_S->ecommerceEnabled() && \$_EC->isAdvancedModelEnabled()"=>"datetext",
                                    "!\$_S->ecommerceEnabled()"=>"form invisible"),
                "prototype"=>"date",
                "relation"=>"subscription",
            ),
            "responded"=>array(
                "type"=>"INT",
                "form invisible",
                "sorta"
            ),
        ),
        "primary_key"=>"id",
        "unique_keys"=>"name",
        "delete_confirm"=>"name",
        "sort_criteria_attr"=>"name",
        "sort_criteria_dir"=>"a",
        "detailsTemplate"=>"item_details.tpl.php",
        "detailsPresentationClassName"=>"ItemDetailsPresentation",
    );


class User extends CustomFieldContainer
{

function lowLevelLogin()
{
  return (security::lowLevelLogin());
}

function removeCookies()
{
}

function setCookies()
{
} 
        
function createObject() // factory method
{
    $_S = new AppSettings();
    if( EComm::isEnabledGlobally() /*$_S->ecommerceEnabled()*/ ) return new ECommUser();
    return new User();
}

function getCustomFieldClass() { return "userfield"; }

function getPicDir() { return USER_PIC_DIR; }
function getUploadDir() { return USER_UPLOAD_DIR; }

function getUniqueAttr()
{
    global $emailAccount;
    return $emailAccount ? "email" : "name";
}

function getUniqueValue()
{
    return isset($this->{$this->getUniqueAttr()}) ? $this->{$this->getUniqueAttr()} : null;
}

function setUniqueValue($value)
{
    return $this->{$this->getUniqueAttr()} = $value;
}

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $gorumrecognised, $gorumuser;

    hasAdminRights($isAdm);
    $hasRight->generalRight = TRUE;
    if( $method=="login" || $method=="logout" || $method=="remind_password" )  $hasRight->objectRight=TRUE;
    elseif( $method=="delete" )  $hasRight->objectRight=$isAdm;
    elseif( $method=="load" || $method=="create" )  $hasRight->objectRight=TRUE;
    elseif( $method=="modify" || $method=="change_password" )  
    {
        $hasRight->objectRight= $isAdm || ($gorumrecognised && @$this->id==$gorumuser->id);
    }
    elseif( $method="remove_favorities" || $method=="add_favorities" ) $hasRight->objectRight=TRUE;  
    else $hasRight->objectRight=FALSE;  
    if( !$hasRight->objectRight && $giveError ) handleErrorPerm(__FILE__,__LINE__);
}

function getFields()
{
    if( !$this->fields ) 
    {
        G::load($this->fields, "SELECT * FROM @userfield WHERE cid=0 AND isCommon=0 ORDER BY sortId ASC");
    }
    return $this->fields;
}

function loginForm($elementName="")
{
    global $gorumuser, $gorumauthlevel, $user_typ, $lll, $gorumroll;

    $_S = new AppSettings();
    if ($_S->loginLink) 
    {
        header("Location: ".$_S->loginLink);
        return;
    } 

    if( !Roll::isPreviousFormSubmitInvalid() )
    {
        $this->password="";
        if( $gorumauthlevel<=Loginlib_GuestLevel ) $this->rememberPassword = TRUE;
        elseif( $gorumauthlevel==Loginlib_BasicLevel )
        {
            // Ha egy initial password emailben kattintanak ra a linkre,
            // akkor a $this->name ki lesz toltve, kulonben pedig az
            // azonositas soran megallapitott juzernevet kell a Name
            // mezoben megjeleniteni
            if( $this->getUniqueValue()==null ) $this->setUniqueValue($gorumuser->getUniqueValue());
            $this->rememberPassword = FALSE;
        }
        else return; // nagyobb egyenlo, mint low level
    }
    $ctrl = new AppController("user/remind_password_form");
    $lll["remindPasswordLink"] = $ctrl->generAnchor($lll["remind_me_pw"]);
    $this->activateVariableFields();
    $this->generForm($elementName);
}

function remindPasswordForm($elementName="")
{
    $this->activateVariableFields();
    $this->generForm($elementName);
}

function modifyForm($elementName="")
{
    global $gorumroll, $user_typ, $emailAccount, $gorumuser;

    $this->id = $gorumroll->rollid ? $gorumroll->rollid : $gorumuser->id;
    hasAdminRights( $isAdm );
    $this->hasObjectRights($hasRight, "modify", TRUE);
    $this->activateVariableFields();
    $this->initClassVars();
    if( !Roll::isPreviousFormSubmitInvalid() )
    {
        $ret = $this->load();
        if( $ret ) handleErrorNotFound($this,__FILE__,__LINE__);
    }
    if( !$isAdm && !$emailAccount ) // az emailt csak az adm valtoztathatja meg
    {
        $user_typ["attributes"]["email"][]="modify_form: form invisible";
    }
    // A password mezok kezdetben mindig uresek:
    $this->password = $this->passwordCopy = "";
    $this->addDeletePictureStuff();
    $this->addDeleteMediaStuff();
    $this->generForm($elementName);
}

function modify()
{
    global $cookiePath, $gorumuser;
    
    $this->activateVariableFields();
    $this->initClassVars();
    LocationHistory::savePost($this);
    if( !$this->validModify() ) return;
    if( $this->password )
    {
        $this->password = getPassword($this->password);
    }
    else unset($this->password);
    parent::modify();
    if( !Roll::isFormInvalid() )
    {
        $this->storeAttachment();
        // Ha a sajat passwordjet modositja:
        if( $this->id==$gorumuser->id && !empty($this->password) )
        {
            setcookie("usrPassword", $this->password, Loginlib_ExpirationDate, $cookiePath);
            Roll::setInfoText("passwordModified");
        }
    }
}

function validModify()
{
    global $minPasswordLength, $siteDemo;
    
    if( $siteDemo )
    {
        Roll::setInfoText("This operation is not permitted in the demo.");
        return;
    }
    if( $this->password )
    {
        if( $this->password!=$this->passwordCopy )
        {
            return Roll::setFormInvalid("mistypedPassword");
        }
        elseif( strlen($this->password)<$minPasswordLength )
        {
            return Roll::setFormInvalid("passwordTooShort", $minPasswordLength);
        }
    }
    return TRUE;
}

function createForm($elementName="")
{
    global $gorumrecognised;

    hasAdminRights( $isAdm );
    if( $gorumrecognised && !$isAdm )
    {
        Roll::setInfoText("cantRegisterUntilLoggedIn");
    }
    else 
    {
        $this->activateVariableFields();
        $this->initClassVars();
        parent::createForm($elementName);
    }
}

function create()
{
    global $gorumuser, $gorumauthlevel;

    $this->activateVariableFields();
    LocationHistory::resetPost();
    $this->initClassVars();
    LocationHistory::savePost($this);
    if( !$this->validRegistration() ) return FALSE;
    
    unset($this->isAdm);
    $this->active=FALSE; // Majd az elso bejelentkezes utan lesz true
    $plainPassword = $this->generatePassword();
    $this->setDefaultsOfFieldsThatDontAppearInForm();
    if( $gorumauthlevel==Loginlib_GuestLevel )
    {
        // don't create a new user, only updating the current
        // nameless user with the newly registered username and
        // password:
        $this->id = $gorumuser->id;
        modify($this);
        if( Roll::isFormInvalid()) return;
    }
    else if( $gorumauthlevel==Loginlib_BasicLevel  || $gorumauthlevel==Loginlib_LowLevel )
    {
        generateRandomId( $randomId );
        $this->id = $randomId;
        create($this);
        if( Roll::isFormInvalid()) return;
    }
    $this->storeAttachment();
    load($this); // hogy a notification minden mezot tartalmazhasson
    $this->sendPassword( $plainPassword, Notification_initialPassword, "youWillGetAEmailCheckEmail" );
    return $plainPassword;
}

function validRegistration()
{
    global $gorumuser, $gorumauthlevel, $gorumrecognised;

    if( !$this->validateCaptcha() ) return FALSE;
    if( $gorumauthlevel==Loginlib_NewUser )  // nem tud kukizni
    {
        return Roll::setFormInvalid("cannotAcceptCookie");
    }
    if( $gorumrecognised && !$gorumuser->isAdm )
    {
        return Roll::setFormInvalid("cantRegisterUntilLoggedIn");
    }
    if( !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', $this->email) )
    {
        return Roll::setFormInvalid("invalidEmail");
    }
    if( $this->userExistsAlready() ) return FALSE;
    if( $this->checkMandatoryFileUpload() ) return FALSE;
    return TRUE;
}

// Stores an encoded password in $this->password and returns the plain password:
function generatePassword( $passwordField="password" )
{
    mt_srand((double)microtime()*1000000);
    $plainPassword = mt_rand(1000000, 10000000);
    settype($plainPassword, "string");
    $this->$passwordField = getPassword($plainPassword);
    return $plainPassword;
}

function userExistsAlready()
{
    $userCheck = new User;
    $userCheck->name = $this->name;
    if( !load($userCheck, array("name"))  )
    {
        return !Roll::setFormInvalid("userAllreadyExists");
    }
    $userCheck = new User;
    $userCheck->email = $this->email;
    if( !load($userCheck, array("email"))  )
    {
        return !Roll::setFormInvalid("userAllreadyExistsWithEmail");
    }
    return FALSE;
}

function sendPassword( $plainPassword, $notification, $infoTextLabel )
{
    G::load( $n, $notification, "notification" );
    $ctrl = new AppController("user/login/".urlencode($this->name)."---".urlencode($plainPassword));
    $this->getEmailParams($params, FALSE);
    $params["uname"] = $params["name"]       = $this->getUniqueValue();
    $params["pwd"]   = $params["Password"]   = $plainPassword;
    $params["url"]   = $ctrl->makeUrl(TRUE);
    $n->send( $this->email, $params );
    Roll::setInfoText($infoTextLabel);
}

function remindPassword()
{
    if( !$this->validRemindPassword($users) ) return;
    foreach( $users as $user )
    {
        $newPassword = $user->generatePassword("newPassword");
        modify($user);
        $user->sendPassword( $newPassword, Notification_remindPassword, "remindmail_sent" );
    }
}

function validRemindPassword( &$users )
{
    if( !$this->email ) return Roll::setFormInvalid("mandatoryField","email");
    $this->activateVariableFields();
    if( !G::load( $users, array("SELECT * FROM @user WHERE email=#this->email#", $this->email) ) )
    {
        return Roll::setFormInvalid("invalid_email");
    }
    return TRUE;
}

function hasCaptcha($postfix="")
{
    global $gorumroll;
    
    if( empty($gorumroll) ) return FALSE; //install
    $_S = new AppSettings();
    if( $gorumroll->method=="create$postfix" && 
        in_array(Settings_register, explode(",", $_S->applyCaptcha))) return TRUE;
    if( $gorumroll->method=="login$postfix" && 
        in_array(Settings_login, explode(",", $_S->applyCaptcha))) return TRUE;
    return FALSE;
}

function showListVal($attr, $format="", $absolute=FALSE)
{
    global $lll,$gorumroll;
    $s=FALSE;
    if( ($s=parent::showListVal($attr, $format, $absolute))!==FALSE )
    {
        return $s;
    }
    if ($attr=="creationtime" || $attr=="lastClickTime")
    {
        $s = $this->showDateField($attr); 
    }
    elseif ($attr=="expirationTime" )
    {
        $s = $this->showDateField($attr, TRUE); 
    }
    elseif( $attr=="email" )
    {
        if( $this->{$attr} )
        {
            $m=htmlspecialchars($this->{$attr});
            $s="<a href='mailto:$m'>$m</a>";
        }
    }
    elseif( $attr=="viewAdsLink" )
    {
        $ctrl = new AppController("item_my/list/$this->name");
        $s=$ctrl->generAnchor($lll["viewAds"], "", $absolute);
    }
    else $s=parent::showListVal($attr, "safetext", $absolute);
    return $s;
}

function getListSelect()
{
    global $lll, $gorumroll, $gorumuser;
    
    if ($gorumroll->list=="user" || $gorumroll->list=="user_inactive" ) 
    {
        $select = "SELECT n.* ".$this->getSpecialSortAttrs()." FROM @user AS n WHERE id!=name && isAdm=0 AND active=";
        $select .= $gorumroll->list=="user" ? "1" : "0";
    }
    elseif ($gorumroll->list=="user_search") 
    {
        loadSQL($search = new Search, array("SELECT query FROM @search WHERE uid=#uid# AND name=''", $gorumuser->id));
        $select = $search->query;
    }
    CustomField::addCustomColumns("user");
    //echo("$select<br><br>");
    return $select;
}

function showDetailsTool()
{
    return "";
}

function showDetails($whereFields="", $withLoad=TRUE, $elementName="")
{
    global $gorumroll;
    
    $this->id = $gorumroll->rollid;
    $this->activateVariableFields();
    if( class_exists("response" ) ) $this->showEmailLinks();
    parent::showDetails($whereFields, $withLoad, $elementName);
}

function showEmailLinks()
{
    global $lll;

    $_S = new AppSettings();
    if( $_S->isEnabled("displayResponseLink") )
    {
        $ctrl = new AppController("response_user/create_form/$this->id");
        View::assign("responseLink", $ctrl->generAnchor($lll["new_resp_user"], '', '_blank'));
    }
    if( $_S->isEnabled("displayFriendmailLink") )
    {
        $ctrl = new AppController("friendmail_user/create_form/$this->id");
        View::assign("friendmailLink", $ctrl->generAnchor($lll["new_frie_user"], '', '_blank'));
    }
    
    if( $_S->isEnabled("displayFlaggedLink") )
    {
        $ctrl = new AppController("flagged_user/create_form/$this->id");
        View::assign("flaggedLink", $ctrl->generAnchor($lll["new_flag_user"], '', '_blank'));
    }
}
function delete()
{
    global $siteDemo;
    
    if( $siteDemo )
    {
        Roll::setInfoText("This operation is not permitted in the demo.");
        return;
    }
    parent::delete();
    G::load( $items, array("SELECT * FROM @item WHERE ownerId=#this->id#", $this->id) );
    foreach( $items as $item ) $item->delete("", "userDelete");    
    executeQuery("DELETE FROM @subscription WHERE uid=#uid#", $this->id);
}

// hozzaad es torol kedvenceket:
function manageFavorities($which)
{
    global $gorumuser, $gorumroll;
    
    if( !isset($gorumuser->favorities) ) 
    {
        Roll::setInfoText("cannotAcceptCookieFav");
    }
    else
    {
        if( $which=="add" )
        {
            if( $gorumuser->favorities ) $gorumuser->favorities.=",";
            $gorumuser->favorities.=$gorumroll->rollid;
            Roll::setInfoText("favAdded");
        }
        else
        {
            $gorumuser->favorities = preg_replace("{(,)?\\b$gorumroll->rollid\\b(?(1)|(,|$))}", "", $gorumuser->favorities);
            Roll::setInfoText("favRemoved");
        }
        executeQuery( "UPDATE @user SET favorities=#gorumuser->favorities# WHERE id=#gorumuser->id#", 
                      $gorumuser->favorities, $gorumuser->id );
    }
    $this->rollBackNum = 1;
}

function showFavoritiesTool($itemId)
{
    global $lll;
    $_S = new AppSettings();
    if( !$_S->favoritiesEnabled()) return "";
    if( !isset($this->favorities) ) $favorities=array();
    elseif( !is_array($this->favorities) ) $favorities = explode(",", $this->favorities );
    if( in_array($itemId, $favorities) )
    {
        $ctrl = new AppController("user/remove_favorities/$itemId");
        return $ctrl->generAnchor($lll["removeFavorities"]);
    }
    else
    {
        $ctrl = new AppController("user/add_favorities/$itemId");
        return $ctrl->generAnchor($lll["addFavorities"]);
    }
}

// azert kell felulirni, hogy a capchca validation ne legyen benne
function valid()
{
    parent::valid();
    if( !Roll::isFormInvalid() ) $this->validateAttributes();
}

function redirectAfterLogin()
{
    global $gorumuser;
    
    $_S = new AppSettings();
    hasAdminRights($isAdm);
    if( $isAdm ) 
    {
        if( $_S->redirectAdminLogin ) $this->nextAction = new AppController($_S->redirectAdminLogin);
    }
    else
    {
        $firstLogin = $this->lastClickTime->isEmpty();    
        if( $firstLogin && $_S->redirectFirstLogin ) $this->nextAction = new AppController($_S->redirectFirstLogin);
        elseif( $firstLogin ) $this->nextAction = new AppController("user/modify_form");
        elseif( $_S->redirectLogin ) $this->nextAction = new AppController($_S->redirectLogin);
    }
}

function validLogin()
{
    $user = new User;
    $user->setUniqueValue($this->getUniqueValue());
    if( load($user, array($this->getUniqueAttr())) || $user->id==$user->name ) Roll::setFormInvalid();
    else
    {
        if( getPassword($this->password)!=$user->password && $user->newPassword )
        {
            if( getPassword($this->password)==$user->newPassword )
            {
                executeQuery(array("UPDATE @user SET password='$user->newPassword', newPassword='' WHERE id=#id#", $user->id));
            }
            else Roll::setFormInvalid();
        }        
        elseif( getPassword($this->password)!=$user->password ) Roll::setFormInvalid();
        $this->id = $user->id;
        $this->lastClickTime = $user->lastClickTime;
    }
    if( Roll::isFormInvalid() ) Roll::setInfoText("loginInvalid");    
    return !Roll::isFormInvalid();
}

function updateUserAfterLogin()
{
    global $gorumuser;
    
    // modositjuk a rememberPassword-ot, ha szukseges:
    if( !isset($this->rememberPassword) ) $this->rememberPassword=0;
    if( $this->rememberPassword!=$gorumuser->rememberPassword || !$gorumuser->active )
    {
        $gorumuser->rememberPassword = $this->rememberPassword;
        $gorumuser->active = 1;
        executeQuery("UPDATE @user SET rememberPassword=#rememberPassword#, active=#active# WHERE id=#id#",
                     $gorumuser->rememberPassword, $gorumuser->active, $gorumuser->id);
    }
}

function showDetailsMethods()
{
    global $lll,$gorumroll,$gorumuser,$chAdmAct;

    $s="";
    hasAdminRights($isAdm);
    if( $chAdmAct && $isAdm ) 
    {
        $ctrl = new AppController();
        $ctrl->list = "user";
        $ctrl->method = "changeAdmStatus";
        $ctrl->id = $this->id;
        $ctrl->rollid = 0;
        saveInFrom($ctrl);
        $s.="<tr><td class='cell' colspan='2'>";
        if ($this->isAdm) $s.=$ctrl->generAnchor($lll["removeAdmRights"]);
        else $s.=$ctrl->generAnchor($lll["giveAdmRights"]);
        $s.="</td></tr>\n";
    }
    return $s;
}

function changeAdmStatus()
{
    hasAdminRights( $isAdm );
    if( !$isAdm ) handleErrorPerm(__FILE__,__LINE__);
    load($this);
    $this->isAdm = $this->isAdm ? FALSE : TRUE;
    modify($this);
    Roll::setInfoText("admstatchanged");
}

function showHtmlList()
{
    global $gorumroll;
    
    $_S = new AppSettings();
    hasAdminRights($isAdm);
    if (!$_S->isEnabled("enableUserSearch") && !$isAdm) LocationHistory::rollBack(new AppController("/"));     

    $this->activateVariableFields();
    parent::showHtmlList();
    if( $gorumroll->list=="user" )
    {
        $ctrl = new AppController("user_inactive/list");
        $gorumroll->processMethod($ctrl, "inactiveList" );
    }
}

function getNavBarPieces($absolute=FALSE)
{
    global $gorumroll, $lll;

    hasAdminRights($isAdm);
    if( !$isAdm ) return array();
    $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    if( $gorumroll->method=="showhtmllist" ) $navBarPieces[$lll["users"]] = "";
    else
    {
        $ctrl = new AppController("user/list");
        $ctrl->setAbsolute($absolute);
        $navBarPieces[$lll["users"]] = $ctrl;
    }
    if( $gorumroll->method=="showdetails" ) 
    {
        $navBarPieces[htmlspecialchars($this->name)] = "";
    }
    elseif( $gorumroll->list=="user" && ($gorumroll->method=="modify_form" || $gorumroll->method=="delete_form"))
    {
        $ctrl = new AppController("user/showdetails/$this->id");
        $ctrl->setAbsolute($absolute);
        $navBarPieces[htmlspecialchars($this->name)] = $ctrl;
    }
    return $navBarPieces;
}

function getEmailParams(&$params, $withLoad=TRUE, $withOwner=TRUE, $extraParams=TRUE, $excludeAttr=0)
{
    if( $withLoad )
    {
        $this->activateVariableFields();
        load($this); 
    }
    $params = array();
    $this->getEmailParamsCore($params, $excludeAttr);
    $ctrl = $this->getLinkCtrl($this->name);
    if( !isset($params["url"]) ) $params["url"] = $ctrl->makeUrl(TRUE);
    if( !isset($params["listing"]) ) $params["listing"] = htmlspecialchars($this->name);
    return $this->email;
}

function assignCurrentUserFields()
{
    global $gorumuser, $gorumrecognised;
    
    if( $gorumrecognised )
    {
        $user = User::createObject();
        $user->activateVariableFields();
        G::load( $user, $gorumuser->id, "user" );
        View::assign("loggedIn", 1);
        $userArr = array();
        foreach( $user->getFields() as $field )
        {
            if( !isset($user->{$field->columnIndex}) || 
                in_array($field->columnIndex, array("password", "passwordCopy", "newPassword", "rememberPassword", "remindPasswordLink")) ) continue;
            elseif( $field->columnIndex=="name" || $field->columnIndex=="email" )
            {
                $userArr[$field->columnIndex."Link"] = $user->showListVal($field->columnIndex, "", TRUE);
                $userArr[$field->columnIndex] = $userArr[$field->name] = htmlspecialchars($user->{$field->columnIndex});
            }
            elseif( $field->type==customfield_picture )
            {
                $userArr[$field->name] = $userArr[$field->columnIndex] = ($user->{$field->columnIndex} ? $user->showListVal($field->columnIndex, "", FALSE) : "");
            }
            elseif( $field->type!=customfield_separator ) $userArr[$field->name] = $user->{$field->columnIndex} = $user->showListVal($field->columnIndex, "", TRUE);
        }
        View::assign("isAdmin", $user->isAdm);
        View::assign("currentUser", $userArr);
    }
    else 
    {
        View::assign("loggedIn", 0);
        View::assign("isAdmin", 0);
        View::assign("currentUser", 0);
    }
}

} // end class

function deleteInactiveGuests()
{
    global $deleteInactiveGuestsAfterDays, $deleteInactiveGuestsWithFavoritiesAfterDays, $deleteNonActivatedRegistrationsAfterDays;
    
    executeQuery("DELETE FROM @user WHERE id=name AND 
                  (lastClickTime < NOW() - INTERVAL $deleteInactiveGuestsWithFavoritiesAfterDays DAY OR
                   (favorities='' AND lastClickTime < NOW() - INTERVAL $deleteInactiveGuestsAfterDays DAY))");
    $whereCond = "u.id!=u.name AND u.active=0 AND ISNULL(i.id) AND 
                    ((lastClickTime!=0 AND lastClickTime < NOW() - INTERVAL $deleteNonActivatedRegistrationsAfterDays DAY) 
                    OR
                    (lastClickTime=0 AND u.creationtime < NOW() - INTERVAL $deleteNonActivatedRegistrationsAfterDays DAY))";
    // Csak azokat toroljuk, akiknek nincs hirdetesuk:                
    G::load( $users, "SELECT DISTINCT(u.id) FROM @user AS u LEFT JOIN @item AS i ON i.ownerId=u.id WHERE $whereCond" );
    foreach( $users as $u ) executeQuery("DELETE FROM @user WHERE id=$u->id");
}

function hasAdminRights( &$hasRight, $base="", $method="" )
{
    global $gorumuser, $gorumrecognised;
    if( function_exists("hasAdminRightsApp") ) {
        hasAdminRightsApp( $hasRight, $base, $method);
    }
    else $hasRight = ($gorumrecognised && !empty($gorumuser->isAdm));
    return ok;
}
function hasManagerRights( &$hasRight, $base="", $method="" )
{
    global $gorumuser, $gorumrecognised;
    hasAdminRights( $hasRight, $base, $method );
    $hasRight = $hasRight || ($gorumrecognised && !empty($gorumuser->isManager));
    return ok;
}

?>