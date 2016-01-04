<?php

include_once("item_typ.php");

class Item extends CustomFieldContainer
{

// Ezt a scrollable widget miatt kell ide tenni. Ott a list-hez tartozo select-et meg a htmlList elejen
// le kell kerdezni, hogy a setupCustomListAppearance-t vegrehajthassuk es hogy az beallithassa a
// $item_typ["listTemplate"]-et es $item_typ["listPresentationClassName"]-et
var $select = array();

// custom list megjelenitese eseten, a get list selectben beleirjuk a customlist listTitle, listDescription
// mezejet ezekbe, hogy az afterView a getPageTitle es a getPageDescription fuggvenyekkel lekerdezhesse:
var $pageTitle = "";
var $pageDescription = "";
var $pageKeywords = "";

function getCustomFieldClass() { return "itemfield"; }
    
function getFields()
{
    if( !$this->fields && ($cid=$this->getCid())!==null ) 
    {
        $query = "SELECT * FROM @itemfield WHERE cid=#cid# ORDER BY sortId ASC";
        G::load($this->fields, array($query, $cid));
        ItemField::updateFromUserFields($this->fields);
    }
    elseif( !$this->fields ) $this->fields = ItemField::getFixAndCommonFields();
    return $this->fields;
}

function getCid()
{
    if( empty($this->cid) && !empty($this->id) ) $this->cid = intval(G::getAttr($this->id, "item", "cid"));
    return empty($this->cid) ? NULL : $this->cid;
}

function getCategory()
{
    if( $this->getCid() ) return G::load( $this->cid, "appcategory" );
    else return NULL;
}

function getImmediateAppear($consumption=0, $considerInactivateOnModify=FALSE)
{
    global $gorumuser;
    
    $_EC = EComm::createObject();
    // ha simple modell eseteben consumption van, akkor Inactive lesz a status, amig a user nem fizet:
    if( $consumption && !$_EC->isAdvancedModelEnabled() ) return FALSE;
    if( empty($this->immediateAppear) && $this->getCid() ) $this->immediateAppear = intval(G::getAttr($this->cid, "appcategory", "immediateAppear"));
    if( !empty($this->immediateAppear) ) return TRUE;
    elseif( $considerInactivateOnModify )
    {
        if( empty($this->inactivateOnModify) && $this->getCid() ) $this->inactivateOnModify = intval(G::getAttr($this->cid, "appcategory", "inactivateOnModify"));
        return empty($this->inactivateOnModify);
    }
    else return FALSE;
}

function getInactivateOnModify()
{
    if( empty($this->inactivateOnModify) && $this->getCid() ) $this->inactivateOnModify = intval(G::getAttr($this->cid, "appcategory", "inactivateOnModify"));
    return !isset($this->inactivateOnModify) ? NULL : $this->inactivateOnModify;
}

function getRenewOnModify()
{
    if( empty($this->renewOnModify) && $this->getCid() ) $this->renewOnModify = intval(G::getAttr($this->cid, "appcategory", "renewOnModify"));
    return !isset($this->renewOnModify) ? NULL : $this->renewOnModify;
}

function getExpiration()
{
    if( empty($this->expiration) && $this->getCid() ) $this->expiration = intval(G::getAttr($this->cid, "appcategory", "expiration"));
    return !isset($this->expiration) ? NULL : $this->expiration;
}

function getExpirationEnabled()
{
    if( empty($this->expirationEnabled) && $this->getCid() ) $this->expirationEnabled = intval(G::getAttr($this->cid, "appcategory", "expirationEnabled"));
    return !isset($this->expirationEnabled) ? NULL : $this->expirationEnabled;
}

function getExpirationOverride()
{
    if( empty($this->expirationOverride) && $this->getCid() ) $this->expirationOverride = intval(G::getAttr($this->cid, "appcategory", "expirationOverride"));
    return !isset($this->expirationOverride) ? NULL : $this->expirationOverride;
}

function getPicDir($absolute=FALSE) { return AD_PIC_DIR; }
function getUploadDir($absolute=FALSE) { return UPLOAD_DIR; }

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll,$gorumrecognised,$gorumuser, $gorumroll;
    
    if( $method=="prolong_expiration" ) 
    {
        $this->id = $gorumroll->rollid;
        $this->hasObjectRights($hasRight, "modify", $giveError);
        return;
    }
    $hasRight->objectRight=FALSE;
    $hasRight->generalRight = TRUE;
    if( $method=="load" )
    {
        $hasRight->objectRight=TRUE;
    }
    elseif( !$gorumrecognised )
    {
        $hasRight->objectRight=FALSE;
    }
    elseif( $gorumuser->isAdm || $gorumuser->isManager )
    {
        $hasRight->objectRight=TRUE;
    }
    elseif( $method=="create" )
    {
        $hasRight->objectRight=$gorumrecognised;
    }
    elseif( $method=="approve" )
    {
        $hasRight->objectRight=FALSE;
    }
    elseif( isset($this->ownerId) && $this->ownerId==$gorumuser->id )
    {
        if ($this->status==1) $hasRight->objectRight=TRUE; // users cannot modify ads that are pending approval
        $hasRight->generalRight = FALSE;
    }
    // Ez akkor van, mikor a modify az invalid formra visz:
    elseif( !isset($this->ownerId) && ($method=="modify" || $method=="delete"))
    {
        $hasRight->generalRight = FALSE;
        if( !isset($this->id) && $gorumroll->rollid && $gorumroll->list=="item" && $gorumroll->method=="showdetails" ) $this->id = $gorumroll->rollid;
        if( isset($this->id ) )
        {
            $query = array("SELECT ownerId FROM @item WHERE id=#this->id#", $this->id);
            $ret = loadSql( $this, $query );
            $hasRight->objectRight = (!$ret && $this->ownerId==$gorumuser->id);
        }
        else $hasRight->objectRight = FALSE;
    }
    if( !$hasRight->objectRight && $giveError )
    {
        handleError($lll["permission_denied"]);
    }
}

function hasCaptcha($postfix="")
{
    global $gorumroll;
    $_S = new AppSettings();
    if( !empty($this->cid) && $gorumroll->method=="create$postfix" && 
        in_array(Settings_submitAd, explode(",", $_S->applyCaptcha))) return TRUE;
    return FALSE;
}

function showNewTool($rights)
{
    global $lll,$gorumroll, $gorumrecognised, $gorumuser;

    $_S = new AppSettings();
    $s=parent::showNewTool($rights);
    if( $gorumroll->list=="item" && $_S->notifyEnabled() )
    {
        if( $gorumrecognised )
        {
            $query = array("SELECT * FROM @subscription WHERE uid=#gorumuser->id# AND cid=#gorumroll->rollid#", 
                           $gorumuser->id, $gorumroll->rollid);
            $subscription = new Subscription;
            if( $ret = loadSQL($subscription,$query ) )
            {
                $ctrl = new AppController("subscription/create/$gorumroll->rollid");
                if( $s ) $s.=" | ";
                $s.=$ctrl->generAnchor($lll["autoNotifyCat"]);
            }
            else
            {
                $ctrl = new AppController("subscription/delete/$gorumroll->rollid");
                if( $s ) $s.=" | ";
                $s.=$ctrl->generAnchor($lll["unsubscribeCat"]);
            }
        }
        else
        {
            $ctrl = new AppController("subscription/create_form/$gorumroll->rollid");
            if( $s ) $s.=" | ";
            $s.=$ctrl->generAnchor($lll["autoNotifyCat"]);
        }
    }
    return $s;
}

function showModTool($rights)
{
    global $lll, $gorumuser;

    $_S = new AppSettings();
    hasManagerRights($isManager);    
    $tools = array();
    if( $isManager && !$this->status )
    {
        $ctrl = new AppController("item/approve/$this->id");
        $tools[]=$ctrl->generAnchor($lll["approve"]);
    }
    if( ($isManager || $_S->allowModify) && ($modTool = parent::showModTool($rights)) ) $tools[]=$modTool;
    if( $isManager )
    {
        $ctrl = new AppController("item/move_form/$this->id");
        $tools[]=$ctrl->generAnchor($lll["move"]);
    }
    if( $this->status && $_S->favoritiesEnabled())
    {
        $tools[]=$gorumuser->showFavoritiesTool($this->id);
    }
    return implode(" | ", $tools);
}

function approve()
{
    global $lll, $gorumroll;

    $this->id = $gorumroll->rollid;
    $this->getCid();
    $this->activateVariableFields();
    load($this);
    hasManagerRights($isManager);    
    if( !$isManager ) return;
    $this->status=TRUE;
    $this->changeStatus(TRUE);    
    Roll::setInfoText("adApproved");
    $this->rollBackNum = 1;
}

function changeStatus( $newStatus )
{
    $_S = new AppSettings();
    $_EC = EComm::createObject();
    if( $newStatus ) // approve
    {
        G::load($c, $this->cid, "appcategory");
        // ha van expiration es ez az item meg sosem volt aktivalva, vagy ha restartExpOnModify van, 
        // akkor az approve-tol indul az expiration
        $setStr = "status=1";
        if( $this->expiration && ($this->expirationTime->isEmpty() || $c->restartExpOnModify) )
        {
            $this->expEmailSent=FALSE;
            $this->expirationTime = Date::add($this->expiration, Date_Day);
            $setStr .= ", expEmailSent=0, expirationTime='".$this->expirationTime->getDbFormat()."'";
        }
        executeQuery("UPDATE @item SET $setStr WHERE id=#id#", $this->id);
        $c->increaseDirectItemNum();
    
        // mailt kuldunk rola a tulajnak:
        G::load($n, Notification_adApproved, "notification");
        if( $n->active )
        {
            $ownerEmail = $this->getEmailParams($params, FALSE);
            $n->send( $ownerEmail, $params );
        }
        $this->sendNotificationsToSubscribedUsers($params);
        if( $_S->ecommerceEnabled() && !$_EC->isAdvancedModelEnabled() ) PurchaseItem::cleanUp($this);
    }
    else  // approve visszavonasa
    {
        G::load($c, $this->cid, "appcategory");
        $c->decreaseDirectItemNum();
    }
    CacheManager::resetCache($this->cid);
}

function delete( $whereFields="", $calledFrom='itemDelete' )
{
    global $gorumroll, $siteDemo;

    $_S = new AppSettings();
    if( $siteDemo ) return Roll::setInfoText("This operation is not permitted in the demo.");
    parent::delete($whereFields);
    G::load($cat, $this->cid, "appcategory");
    if( $calledFrom!='categoryDelete' && $this->status ) $cat->decreaseDirectItemNum();
    $query=array("SELECT id, favorities FROM @user WHERE FIND_IN_SET(#this->id#, favorities)!=0", $this->id);
    $users = new User;
    loadObjectsSql($users, $query, $users);
    foreach( $users as $u )
    {
        $f = preg_replace("{(,)?\\b$this->id\\b(?(1)|(,|$))}", "", $u->favorities);
        executeQuery("UPDATE @user SET favorities=#f# WHERE id=#u->id#", $f, $u->id);
    }
    if( $_S->ecommerceEnabled() )
    {
        executeQuery("DELETE FROM @purchaseitem WHERE iid=#id#", $this->id);
    }
    // Ha az admin torolte ki az ad-et, akkor emailt kell kuldeni a
    // tulajnak:
    hasManagerRights($isManager);        
    // Ha a kategoria torleserol jutunk ide, nem kell levelet kuldeni:
    if( $isManager && $calledFrom=='itemDelete' )
    {
        G::load($n, Notification_adDeleted, "notification");
        if( $n->active )
        {
            if( $ownerEmail = $this->getEmailParams($params) )
            {
                $n->send( $ownerEmail, $params );
            }
        }
    }
    CacheManager::resetCache($this->cid);
}

function showListVal($attr, $format="", $absolute=FALSE, $fromGetEmailParams=FALSE)
{
    global $gorumroll, $lll, $gorumuser, $gorumrecognised;

    $s="";
    if( ($s=parent::showListVal($attr, $format, $absolute, $fromGetEmailParams))!==FALSE )
    {
        return $s;
    }
    if ($attr=="title") 
    {
        $ctrl = $this->getLinkCtrl($title = $this->getTitle(FALSE));
        $s = $ctrl->generAnchor($title, "", $absolute);
    }
    elseif( $attr=="expirationTime")
    {
        if( $this->status && !$this->expirationTime->isEmpty() )
        {
            $_S = new AppSettings();
            //var_dump($this);
            $s=round($this->expirationTime->getDayDiff());
            if( $this->expirationTime->isPast() ) $s = "-$s";
            //echo "$this->renewalNum $renewal";
            if( $this->expEmailSent && $this->ownerId==$gorumuser->id &&
                $gorumrecognised && $this->renewalNum < $_S->renewal)
            {
                $ctrl = new AppController("item/prolong_expiration/$this->id");
                $s.=" ".$ctrl->generAnchor($lll["prolongExp"], "", $absolute);
            }
        }
        else $s = $lll["N/A"];
    }
    elseif ($attr=="shoppingCartLink" && $withShoppingCart)
    {
        $ctrl = new AppController("shoppingcart/create_form/$this->id");
        $s=$ctrl->generImageAnchor("i/add2cart.gif", $lll["addToChart"]);
    }
    elseif ($attr=="responded" || $attr=="clicked" )
    {
        $s = $this->$attr;
    }
    else
    {
        $s=Object::showListVal($attr, $format, "safetext");
    }
    return $s;
}

function prolongExpiration()
{
    global $lll, $gorumroll, $now;

    $_S = new AppSettings();
    $this->id = $gorumroll->rollid;
    load($this);
    if( $this->renewalNum < $_S->renewal )
    {
        $this->expirationTime = $this->expirationTime->add($this->getDefaultExpiration(), Date_Day);
        $this->expEmailSent = FALSE;
        $this->renewalNum++;
        if( $this->getRenewOnModify() ) $this->creationtime = $now;
        modify($this);
        $it = $lll["expirationProlonged"];
        if( $this->renewalNum==$_S->renewal ) $it.=$lll["lastRenewal"];
        Roll::setInfoText($it);
        CacheManager::resetCache($this->cid);
    }
    $this->nextAction = $this->getLinkCtrl();
}

function create($fromInstall=FALSE)
{
    global $gorumuser;

    $_S = new AppSettings();
    $_EC = EComm::createObject();
    if( empty($this->cid) ) return Roll::setFormInvalid("selectCategoryNecessary");
    hasAdminRights($isAdm);
    if( !$_S->showSubmitAd() && !$isAdm ) handleError("Permission denied");
    $this->activateVariableFields();
    LocationHistory::resetPost();
    $this->initClassVars();
    LocationHistory::savePost($this);
    if( !$fromInstall )
    {
        if( !$this->checkAgainstEarlySubmission() || !$this->checkCharacterLimit() ||
             $this->checkMandatoryFileUpload()    || !$this->checkAndSetExpirationDays() ||
             !$_EC->checkConsumptionOfAction($purchaseItem, $consumption, $this) ) return;
    }
    if( !$isAdm || !isset($this->status) ) 
    {
        $this->status = $this->getImmediateAppear($consumption);  // ha viszont isAdm, akkor a status benne van a formban
    }
    if( $this->status )  // ha aktivkent krealjuk akkor az expiration is szamlalodni kezd:
    {
        if( !empty($this->expiration) ) $this->expirationTime = Date::add($this->expiration, Date_Day);
    }
    $this->setDefaultsOfFieldsThatDontAppearInForm();
    if( !isset($this->ownerId) ) $this->ownerId = $gorumuser->id;
    parent::create();
    if( !Roll::isFormInvalid() )
    {
        G::load($c, $this->cid, "appcategory");
        if( $this->status ) $c->increaseDirectItemNum();
        if( $fromInstall ) return;
        elseif( !$purchaseItem && !$this->status ) Roll::addInfoText("adScheduled");
        $this->storeAttachment();
        // hogyy hogy nem cName es ownerName itt 0-ra beallitva, ami bezavarhat a getEmailParams-ban:
        unset($this->cName);
        unset($this->ownerName);
        $ownerEmail = $this->getEmailParams($params, TRUE);
        if( !$isAdm )  // csak akkor kell ertesites, ha nem admin krealta
        {
            $_S = new AppSettings();
            G::load($n, Notification_adCreated, "notification");
            if( $n->active ) $n->send( $_S->adminEmail, $params );
            G::load($n, Notification_adCreatedOwner, "notification");
            if( $n->active ) $n->send( $ownerEmail, $params );
        }
        
//handleError("consumption: ".$consumption);
        if( $purchaseItem ) $purchaseItem->save($this);
        elseif( !$isAdm && $consumption ) executeQuery("UPDATE @user SET credits=credits-$consumption WHERE id=#id#", $gorumuser->id);
        $this->sendNotificationsToSubscribedUsers($params);
        if( empty($this->nextAction) ) $this->nextAction = $this->getLinkCtrl();
        CacheManager::resetCache($this->cid);
    }
}

function sendNotificationsToSubscribedUsers($params)
{
    $_S = new AppSettings();
    if( $this->status && class_exists("response") && $_S->subscriptionType!=customfield_forNone)
    {
        ini_set("max_execution_time", 0);
        G::load($n, Notification_autoNotify, "notification");
        if( $n->active )
        {
            ini_set("max_execution_time", 0);
            $queries = array();
            $deleteLinks = array();
            $_S = new AppSettings();
            if( $_S->subscriptionType==customfield_forAll || $_S->subscriptionType==customfield_forAllButAdmin )
            {
                $queries[] = array("SELECT id, email FROM @subscription WHERE cid=#cid# AND email!='' AND unsub=0", $this->cid);
                $deleteLinks[] = 'subscription/delete/$this->cid/email/$s->email';
                $queries[] = "SELECT id, email FROM @subscription WHERE cid=0 AND email!='' AND unsub=0";
                $deleteLinks[] = 'subscription/delete/00/email/$s->email';
                $extra = $_S->subscriptionType==customfield_forAllButAdmin ?  " AND u.isAdm!=1" : "";
                $queries[] = array("SELECT s.id, uid, u.email AS email FROM @subscription AS s, @user as u WHERE s.uid=u.id AND cid=#cid# AND uid!=0 $extra", $this->cid);
                $deleteLinks[] = 'subscription/delete/$this->cid/uid/$s->uid';
            }
            elseif( $_S->subscriptionType==customfield_forLoggedin )
            {
                $queries[] = array("SELECT s.id, uid, u.email AS email FROM @subscription AS s, @user as u WHERE s.uid=u.id AND cid=#cid# AND uid!=0", $this->cid);
                $deleteLinks[] = 'subscription/delete/$this->cid/uid/$s->uid';
            }
            elseif( $_S->subscriptionType==customfield_forManager )
            {
                $queries[] = array("SELECT s.id, uid, u.email AS email FROM @subscription AS s, @user as u WHERE s.uid=u.id AND cid=#this->cid# AND uid!=0 AND (u.isManager=1 || u.isAdm=1)", $this->cid);
                $deleteLinks[] = 'subscription/delete/$this->cid/uid/$s->uid';
            }
            else // forAdmin
            {
                $queries[] = array("SELECT s.id, uid, u.email AS email FROM @subscription AS s, @user as u WHERE s.uid=u.id AND cid=#this->cid# AND uid!=0 AND u.isAdm=1", $this->cid);
                $deleteLinks[] = 'subscription/delete/$this->cid/uid/$s->uid';
            }
            $count = 0;
            for( $i=0; $i<count($queries); $i++ )
            {
                G::load( $subscriptions, $queries[$i] );
                foreach( $subscriptions as $s )
                {
                    eval('$dl = "'.$deleteLinks[$i].'";');
                    $ctrl = new AppController($dl);
                    $params["unsubUrl"] = $ctrl->makeUrl(TRUE);
                    $failed = $n->send( $s->email, $params );
                    if( !$failed )
                    {
                        executeQuery("UPDATE @item SET subscribtionsNotified=CONCAT_WS(',', subscribtionsNotified, '$s->id') WHERE id='$this->id'");
                        $count++;
                    }
                }
                reset($subscriptions);
                unset($subscriptions);
            }
        }
    }
}

// elofordulhat, hogy a kategoria kivalasztasa utan a create formban gyorsabban nyomnak az Ok gombra,
// mint ahogy a custom fieldek "legordulnek". 
function checkAgainstEarlySubmission()
{
    if( !isset($_POST["cid"]) ) return TRUE; // ha az installbol erkezunk
    $typ =& $this->getTypeInfo(TRUE);
    for( $i=0; $i<count($this->fields); $i++ )
    {
        $field = & $this->fields[$i];
        if( !isset($this->{$field->columnIndex}) && 
            $field->type!=customfield_separator && $field->type!=customfield_picture && $field->type!=customfield_media && 
            !$field->isFixField() && !$field->userField &&
            $this->fieldExistsInForm($typ, $field->columnIndex)) 
        {
            return Roll::setFormInvalid();
        }
    }
    return TRUE;
}

function modify( $whereFields="" )
{
    global $gorumuser, $now;

    hasAdminRights($isAdm);
    $_S = new AppSettings();
    $_EC = EComm::createObject();
    if( !$isAdm && !$_S->allowModify ) return;
    $this->getCid();
    $this->activateVariableFields();
    $this->initClassVars();
    LocationHistory::savePost($this);
    G::load( $old, $this->id, "item" );
    if( !$isAdm && !$old->status ) return; // inactive itemet nem modosithat a tulaj
    if( !$this->checkCharacterLimit() || !$this->checkAndSetExpirationDays() ||
         !$_EC->checkConsumptionOfAction($purchaseItem, $consumption, $this, $old) ) return;
    if( !$isAdm )
    {
        // ha a tulaj modosit, ujra inactive lesz az item:
        if( !$this->getImmediateAppear($consumption, TRUE) ) $this->status=FALSE;
        // ha restartExpOnModify van, az olyan mintha az ad most jott volna letre:
        elseif( G::getAttr($this->cid, "appcategory", "restartExpOnModify") ) 
        {
            if( !$this->expirationAppearsInForm() && $this->expiration ) 
            {
                $this->expEmailSent=FALSE;
                $this->expirationTime = Date::add($this->expiration, Date_Day);
            }
        }
    }
    // ha az expiration megjelent a formban es modositottak is, akkor az expirationTime-ot megfeleloen modositani kell:
    if( $this->expirationAppearsInForm() && 
        ($this->expiration!=round($old->expirationTime->getDayDiff()) ||
        ($this->expiration>0 && $old->expirationTime->isPast()) ||
        ($this->expiration<0 && $old->expirationTime->isFuture()))) $this->expirationTime = Date::add($this->expiration, Date_Day);
    parent::modify();
    load($this);
    if( !Roll::isFormInvalid() )
    {
        if( !$this->getImmediateAppear($consumption, TRUE) && $this->status!=$old->status ) $this->changeStatus($this->status);
        if( $this->getRenewOnModify() ) executeQuery("UPDATE @item SET creationtime=NOW() WHERE id=#id#", $this->id);
        if( !$isAdm && $old->status && !$this->status )  // ha a tulaj modositott, es most valtottunk pendingre, admint ertesitjuk az uj pending itemrol
        {
            if( !$purchaseItem ) Roll::addInfoText("adScheduled");
            G::load($n, Notification_adCreated, "notification");
            if( $n->active )
            {
                $_S = new AppSettings();
                $this->getEmailParams($params, FALSE);
                $n->send( $_S->adminEmail, $params );
            }
        }
        $this->storeAttachment();
        if( $purchaseItem ) $purchaseItem->save($this);
        elseif( !$isAdm && $consumption ) executeQuery("UPDATE @user SET credits=credits-$consumption WHERE id=#id#", $gorumuser->id);        
        CacheManager::resetCache($this->cid);
    }
}

function checkCharacterLimit()
{
    $_S = new AppSettings();
    $object_vars = get_object_vars($this);
    foreach( $object_vars as $attr=>$val )
    {
        if (!is_array($val) && !is_object($val) && $_S->charLimit && strlen($val)>$_S->charLimit) 
        {
            return Roll::setFormInvalid("ad_limit_exc",$_S->charLimit, strlen($val));
        }
    }
    return TRUE;
}

function checkAndSetExpirationDays()
{
    if( !$this->expirationAppearsInForm() )
    {
        $this->expiration = $this->getDefaultExpiration();
    }
    elseif( $defaultExpiration = $this->getDefaultExpiration() )
    {
        // ha uresen hagytak az expirationt, a default lep ervenybe:
        if( empty($this->expiration) ) $this->expiration = $defaultExpiration;
        // ha nagyobbat adtak meg, mint a megadhato maximum:
        elseif( $this->expiration > $defaultExpiration )
        {
            return Roll::setFormInvalid("item_expiration_expl_2", $defaultExpiration);
        }
    }
    return TRUE;
}

function expirationAppearsInForm()
{
    global $gorumroll;
    
    hasAdminRights($isAdm);    
    return $this->getExpirationEnabled() && class_exists('response') && 
           ($or = $this->getExpirationOverride())!=customfield_forNone && 
           ($isAdm || ($or!=customfield_forAdmin && ($this->getDefaultExpiration()>=0 || strstr($gorumroll->method, "create")))); 
    // ha van maximum expiration es az owner nem admin, akkor csak a create formban adhat meg expirationt - kesobb ezt nem 
    // modosithatja a modify formban (mert az prolong-nak minosulne)
}

function getDefaultExpiration()
{
    return intval(G::getAttr($this->cid, "appcategory", "expiration"));
}

function showDetails($whereFields="", $withLoad=TRUE, $elementName="")
{
    global $gorumroll,$item_typ, $gorumuser;
    
    $this->id = $gorumroll->rollid;
    if( load($this) ) 
    {
        Roll::setInfoText("adNotFound");
        LocationHistory::saveInfoText();
        LocationHistory::rollBack(new AppController("/"));
    }
    LocationHistory::saveGorumCategory($this->cid);
    if( $gorumuser->id!=$this->ownerId && !$gorumuser->isAdm )
    {
        $this->clicked++;
        modify($this);
    }
    $this->activateVariableFields();
    load($this);
    $this->loadUserFields();
    hasAdminRights( $isAdm );
    $expField = $this->getField("expirationTime");
    $statusField = $this->getField("status");
    $displayExpirationInDetails = !$this->expirationTime->isEmpty() && $expField->displayInDetailsCondition($this->ownerId);
    if( !$this->status || $statusField->displayInDetailsCondition($this->ownerId) ) 
    {
        $item_typ["attributes"]["status"][]="details";
    }
    if( !$this->getImmediateAppear() )
    {
        // Az expiration time-nak csak akkor van ertelme, ha mar active:
        if( $displayExpirationInDetails && $this->status )
        {
            $item_typ["attributes"]["expirationTime"][]="details";
        }
        // Vagy akkor, ha meg nem aktiv, de expiration time-mal hoztak letre es a tulaj, vagy admin nezi:
        elseif( $expField->displayInDetailsCondition($this->ownerId) && $this->expiration && !$this->status )
        {
            $item_typ["attributes"]["expiration"][]="details";
        }
    }
    elseif( $displayExpirationInDetails )
    {
        $item_typ["attributes"]["expirationTime"][]="details";
    }
    if( class_exists("response" ) ) $this->showEmailLinks();
    $customAdDetailsTemplate = G::getAttr( $this->cid, "appcategory", "customAdDetailsTemplate");
    if( $customAdDetailsTemplate ) $item_typ["detailsTemplate"] = $customAdDetailsTemplate;   
    parent::showDetails($whereFields, FALSE, $elementName);
}

// betolti az ertekeket azokhoz a custom fieldekhez, amik a tulajdonosnak egy custom fieldjere mutatnak:
function loadUserFields()
{
    $owner = new User;
    $owner->id = $this->ownerId;
    $owner->activateVariableFields();
    load($owner);
    foreach( $this->getFields() as $field )
    {
        if( $field->userField ) 
        {
            $attr = G::getAttr($field->userField, "userfield", "columnIndex");
            $this->{$field->columnIndex} = substr($attr, 0, 4)=="col_" ? $owner->{$attr} : $owner->showListVal($attr);
        }
    }
}

function showEmailLinks()
{
    global $lll;

    list( $displayFriendmailLink, $displayResponseLink, $displayFlaggedLink ) = G::getAttr( $this->cid, "appcategory", "displayFriendmailLink", "displayResponseLink", "displayFlaggedLink" );
    if( AppSettings::isEnabled($displayResponseLink) )
    {
        if ($this->oodleType>0) {
            $link = "<a href='$this->oodleUrl' target='_blank'>".$lll["new_resp"]."</a>";
            View::assign("responseLink", $link);
        } else {
            $ctrl = new AppController("response/create_form/$this->id");
            View::assign("responseLink", $ctrl->generAnchor($lll["new_resp"], '', '_blank'));
        }
    }
    if( AppSettings::isEnabled($displayFriendmailLink) )
    {
        $ctrl = new AppController("friendmail/create_form/$this->id");
        View::assign("friendmailLink", $ctrl->generAnchor($lll["new_frie"], '', '_blank'));
    }
    if( AppSettings::isEnabled($displayFlaggedLink) )
    {
        $ctrl = new AppController("flagged/create_form/$this->id");
        View::assign("flaggedLink", $ctrl->generAnchor($lll["new_flag"], '', '_blank'));
    }
}

function getListSelect( $retrieveSelectOnly=TRUE, $elementName="" )
{
    global $item_typ, $gorumroll, $gorumuser, $lll;
    
    // hogy ne hivodjon meg ketszer foloslegesen a getCount miatt
    // Ha kulonbozo queryStringgel hivjuk, akkor viszont tobbszor is meghivodhat: 
    $qs = $gorumroll->ctrl->makeQueryString();
    if( isset($this->select[$qs]) && $retrieveSelectOnly ) return $this->select[$qs]; 
    CustomField::addCustomColumns("item");
    // Az adott user altal birtokolt itemek:
    if ($gorumroll->list=="item_my") 
    {
        $owner = new User;
        $owner->name = $gorumroll->rollid;
        $userId = load($owner, array("name")) ? 0 : $owner->id;
        
        $search = new CustomList;
        $search->activateVariableFields();
        // az 2-es ID-ju custom list a 'My ads':
        loadSQL($search, "SELECT * FROM @search WHERE id=2");
        $search->setupCustomListAppearance($elementName);
        // mas hirdeteseibol csak az aktivakat lathatjuk:
        hasAdminRights($isAdm);
        if( !$isAdm && $userId!=$gorumuser->id ) $search->query.=" AND status=1";
        $this->select[$qs] = str_replace('#gorumuser#', $userId, $search->query);
        $lll["item_my_ttitle"] = sprintf($lll["item_my_ttitle"], $owner->showListVal("name"));
        $this->pageTitle = $this->pageDescription = strip_tags($lll["item_my_ttitle"]);
    }
    //egy kereses eredmenye:
    elseif ($gorumroll->list=="item_search" || $gorumroll->list=="export" ) {
        // normal search eseten, az 1-es ID-ju customlistet kell lekernunk:
        $clId = $gorumroll->rollid ? $gorumroll->rollid : 1;
        $search = new CustomList;
        $search->activateVariableFields();
        if( !loadSQL($search, array("SELECT * FROM @search WHERE id=#id#", $clId)) )
        {
            $search->setupCustomListAppearance($elementName);
        }
        else 
        {
            Roll::setInfoText("listNotFound");
            LocationHistory::saveInfoText();
            LocationHistory::rollBack(new AppController("/"));
        }
        if( $clId==1 ) // normal search
        {
            loadSQL($search = new Search, array("SELECT * FROM @search WHERE uid=#uid# AND name=''", $gorumuser->id));
            $this->activateVariableFields();
            if( $specialSortAttrs = $this->getSpecialSortAttrs($search->cid ? 0 : 1, $search->cid) )
            {
                $search->query = str_replace( "n.*", "n.* $specialSortAttrs", $search->query);
            }
        }
        else
        {
            $this->pageTitle = $search->listTitle;
            $this->pageDescription = $search->listDescription;
            $search->applyCategoryFilterToSearchQuery();
        }
        $this->select[$qs] = array($search->query, $gorumuser->id);
    }
    elseif ($gorumroll->list=="item_favorities") {
        $this->activateVariableFields();
        $this->select[$qs] = array("SELECT n.*, c.wholeName AS cName, ".
                  "c.immediateAppear AS immediateAppear, c.permaLink AS catPermaLink ".
                  "FROM @item AS n, @category AS c ".
                  "WHERE c.id=n.cid AND FIND_IN_SET(n.id, #favorities#)!=0", $gorumuser->favorities);
    }
    // Egy adott kategoria itemjei:
    else 
    {
        list($recursive, $wholeName) = G::getAttr($gorumroll->rollid, "appcategory", "recursive", "wholeName");
        $userQueryPieces = ItemField::getUserQueryPieces($gorumroll->rollid);
        $cidCond = $recursive ? "wholeName LIKE '".quoteSQL($wholeName)."%'" : "cid='".quoteSQL($gorumroll->rollid)."'";
        $this->select[$qs] = "SELECT n.* ".$this->getSpecialSortAttrs(0, $gorumroll->rollid).", c.wholeName AS cName, c.permaLink AS catPermaLink, ".
                  "c.immediateAppear AS immediateAppear $userQueryPieces[as] FROM @item AS n, @category AS c $userQueryPieces[from] ".
                  "WHERE $userQueryPieces[where] $cidCond AND c.id=n.cid AND n.status='1'";
    }
    return $this->select[$qs];
}

function getLimit()
{
    $typ =& $this->getTypeInfo();
    // ha a customlistben limitet allitottak, az felulirja a blockSize-t:
    //var_dump($typ);
    if( isset($typ["listPresentationClassName"]) && $typ["listPresentationClassName"]=="ItemScrollablePresentation" ) 
    {
        return isset($typ["limit"]) ? "LIMIT $typ[limit]" : "";
    }
    else return parent::getLimit();
}

function loadHtmlList(&$list)
{
    global $item_typ, $gorumroll; 
    
    parent::loadHtmlList($list);
    if( $gorumroll->list=="item_search" && count($list) && !$gorumroll->rollid )
    {
        $cid = $list[0]->cid;
        while( ($item = current($list)) && $oneCatExists = ($item->cid==$cid) ) next($list);
        if( $oneCatExists ) 
        {
            include("item_typ.php");  // resetting $item_typ
            $this->setupCategorySpecificList($cid);
            // hogy a prototype-os mezok tenyleg objektumok legyenek:
            foreach( $list as $item )
            {
                foreach( $item_typ["attributes"] as $attr=>$attrInfo )
                {
                    if( isset($item->{$attr}) && isset($attrInfo["prototype"]) && !is_object($item->{$attr}) )
                    {
                        $item->{$attr} = new $attrInfo["prototype"]($item->{$attr});
                    }
                    // ha egy nem kategory specifikus search eredmenyet jelenitjuk meg es azt 
                    // kategoria specifikus oszlopokkal kivanjuk kiegesziteni, akkor 
                    // gaz lehet a user fieldekkel! A user filedek lekerdezesehez ugyanis
                    // meg a search query osszeallitasa soran be kell a querybe tenni a megfelelo 'AS' mezoket,
                    // hogy a juzerbol szarmazo oszlopokat bedzsojnozzuk az itembe. Egy advanced search eseten
                    // azonban ez nem tortenik meg, ezert ezeknek az oszlopoknak az ertekei definialatlanok lesznek
                    // (viszont az activateVariableFields ugy jelzi oket mint megmutatando oszlopokat!).
                    // Az ilyen oszlopokat nem tudjuk megmutatni, ezert itt ki is vesszuk a typeinfobol:
                    if( in_array("list", $attrInfo) && !isset($item->{$attr}) ) 
                    {
                        Object::removeFromTypeInfo( $attr, "list", "item_typ" );
                    }
                }
            }
        }
    }
}

function generForm()
{
    global $lll, $gorumroll, $item_typ;
    
    hasAdminRights($isAdm);
    if( !$isAdm || $this->getImmediateAppear() || !$gorumroll->rollid )
    {
        $item_typ["attributes"]["status"][]="form invisible";
    }
    if( !$this->expirationAppearsInForm() )
    {
        $item_typ["attributes"]["expiration"][]="form invisible";
    }
    elseif( $defaultExpiration = $this->getDefaultExpiration() )
    {
        $item_typ["attributes"]["expiration"]["default"] =
        $item_typ["attributes"]["expiration"]["max"]     = $defaultExpiration;
        $lll["item_expiration_expl"] = sprintf($lll["item_expiration_expl_2"], $defaultExpiration);
    }
    else // $defaultExpiration == 0
    {
        if( empty($this->expiration) ) $this->expiration="";
        $lll["item_expiration_expl"] = $lll["item_expiration_expl_1"];
    }
    parent::generForm();
}

function createForm()
{
    global $gorumroll, $lll;

    $_S = new AppSettings();
    $_EC = EComm::createObject();
    if( $gorumroll->rollid && !G::getAttr( $gorumroll->rollid, "appcategory", "allowAd") ) $gorumroll->rollid=0;
    LocationHistory::saveGorumCategory($this->cid = $gorumroll->rollid);    
    $this->hasObjectRights($hasRight, "create", FALSE);
    hasAdminRights($isAdm);
    if( !$_S->showSubmitAd() && !$isAdm ) handleError("Permission denied");
    if( !$hasRight->objectRight )
    {
        Roll::setInfoText("registerOrLoginToSubmit");
        $this->nextAction = new AppController("user/login_form");
        $gorumroll->afterAction($this);
    }
    if( $this->cid )
    {
        $this->activateVariableFields();
        $this->initClassVars();
        $this->cName = $this->getCatName();
        $_EC->confirmRules($gorumroll->rollid);
    }
    parent::createForm();
    $_S->handleCategorySelect("item-create_form", TRUE); //$excludeAdminOnlySubmitCats
}

function modifyForm()
{
    global $gorumroll, $lll;

    $_EC = EComm::createObject();
    $this->id = $gorumroll->rollid;
    LocationHistory::saveGorumCategory($this->getCid());
    $this->activateVariableFields();//csak emiatt kellett feluldefinialn
    $this->initClassVars();
    if( !Roll::isPreviousFormSubmitInvalid() )
    {
        $ret = $this->load();
        if( $ret )
        {
            $txt = $lll["not_found_in_db"];
            handleError($txt);
        }
        $old =& $this;
    }
    else G::load( $old, $this->id, "item" );
    $this->hasObjectRights($hasRight, "modify", TRUE);
    if( isset($this->expirationTime) && !$this->expirationTime->isEmpty() ) 
    {
        $this->expiration = round($this->expirationTime->getDayDiff());
        if( $this->expirationTime->isPast() ) $this->expiration = "-$this->expiration";
    }
    $this->addDeletePictureStuff();
    $this->addDeleteMediaStuff();
    $_EC->confirmRules($this->cid, $old);
    $this->cName = $this->getCatName();
    $this->catPermaLink = $this->getCatPermaLink();
    $this->generForm();
}

function moveForm()
{
    global $gorumroll, $lll;

    // csak admin move-olhat:
    hasAdminRights($isAdm);
    if(!$isAdm) return;
    $this->id = $gorumroll->rollid;
    $ret = $this->load();
    $lll["item_cid_expl"] = $lll["onlyCompatibleExpl"];
    $this->generForm();
}

function getCompatibleCategories()
{
    $categories = $this->getSelectFromTree(FALSE, FALSE,"",0);
    ItemField::filterCompatibleCategories($this->cid, $categories);
    return $categories;
}

function getSelectFromTree( $forTheSearchForm = FALSE, $noFilter=FALSE, $attrs="", $overrideCascading=-1)
{
    global $gorumroll;
    
    $_S = new AppSettings();

    switch ($overrideCascading) {
      case 0: $cascadingCategorySelectEnabled = false;
              break;
      case 1: $cascadingCategorySelectEnabled = true;
              break;
      default:
              $cascadingCategorySelectEnabled = $_S->cascadingCategorySelectEnabled();
    }
    
    hasAdminRights($isAdm);
    $itemNumCond = $cascadingCategorySelectEnabled && $gorumroll->list!="customlist" && $forTheSearchForm ? "AND itemNum>0" : "";
    if( !$attrs ) $attrs = "id, name, up, sortId, wholeName, allowAd, allowSubmitAdAdmin, itemNum, recursive, subCatNum";
    if( $_S->permaLinksEnabled() ) $attrs.=", permaLink";
    $exclude = ($gorumroll->list=="item" && 
                ($gorumroll->method=="create_form" || $gorumroll->method=="move_form") && 
                !$isAdm) ? "AND allowSubmitAdAdmin=0" : ""; 
    $query = "SELECT $attrs FROM @category WHERE up=0 $exclude $itemNumCond ORDER BY sortId ASC";
    G::load( $cats, $query );
    // cascading eseten csak a main kategoriak kellenek:
    if( $cascadingCategorySelectEnabled  && $gorumroll->list!="customlist"  && $gorumroll->rollid!=="alternative") return $cats;
    $cat = new AppCategory();
    $tree = & $cat->getCategoryTree( $cats, $attrs );
    if( $noFilter ) $cond = TRUE;
    else
    {
        $cond = $isAdm ? '$node["cat"]->allowAd==1' : '$node["cat"]->allowAd==1 && $node["cat"]->allowSubmitAdAdmin==0';
        if( $forTheSearchForm ) $cond.= ' && $node["cat"]->itemNum>0';
        $cond = "(($cond) || \$node['cat']->recursive)";
    }
    $categories = array();
    $cat->getArrayFromCategoryTree($tree, $categories, $cond, 0);
    return $categories;
}

function move()
{
    global $gorumroll;

    // csak admin move-olhat:
    hasAdminRights($isAdm);
    if(!$isAdm) return;
    $oldCid = G::getAttr( $this->id, "item", "cid" );
    // ha nincs move-olas:
    if( $oldCid==$this->cid ) return;
    G::load( $newCategory, array("SELECT * FROM @category WHERE id=#cid#", $this->cid) );
    // Ellenorzes:
    ItemField::filterCompatibleCategories($oldCid, $newCategory);
    if( !count($newCategory) ) return; // trukkozes
    $newCategory = $newCategory[0];
    
    CustomField::addCustomColumns("item");
    G::load( $oldFields, array("SELECT columnIndex FROM @customfield WHERE cid=#cid# ORDER BY sortId ASC", $oldCid));
    G::load( $newFields, array("SELECT columnIndex FROM @customfield WHERE cid=#cid# ORDER BY sortId ASC", $this->cid));
    load($this);
    $newObj = gclone($this);
    $newObj->cid = $newCategory->id;
    if( $newCategory->immediateAppear ) $newObj->status=TRUE;
    for( $i=0; $i<count($oldFields); $i++  )
    {
        if( isset($this->{$oldFields[$i]->columnIndex}) ) $newObj->{$newFields[$i]->columnIndex} = $this->{$oldFields[$i]->columnIndex};
    }
    modify($newObj);
    // itemnumok beallitasa
    if( $newObj->status ) $newCategory->increaseDirectItemNum();
    G::load( $oldCategory, $oldCid, "appcategory" );
    if( $this->status ) $oldCategory->decreaseDirectItemNum();
    Roll::setInfoText("adMoved");
    CacheManager::resetCache($this->cid);
    CacheManager::resetCache($oldCid);
}

function valid()
{
    parent::valid();
    if( !Roll::isFormInvalid() ) Object::valid();
}

function getNavBarPieces($absolute=FALSE, $withAdLink=FALSE)
{
    global $gorumroll;

    if (empty($this->cid)) return array();
    G::load($fatherCat, $this->cid, "appcategory");
    $navBarPieces = $fatherCat->getNavBarPieces($absolute);
    if( $title = $this->getTitle() )
    {
        $navBarPieces[$title] = $withAdLink ? $this->getLinkCtrl($title, $absolute) : "";
    }
    return $navBarPieces;
}

function getTitle($encoding=TRUE)
{
    static $commonTitleField=0;
    
    $typ =& $this->getTypeInfo();
    $columnIndex = FALSE;
    if( $fields = $this->getFields() )
    {
        foreach( $fields as $field ) 
        {
            if( $field->seo==customfield_title )
            {
                $columnIndex = $field->columnIndex;
                break;
            }
        }
        if( $columnIndex===FALSE || !isset($this->{$columnIndex})) return "";
        else
        {
            if( !$commonTitleField ) 
            {
                loadSQL( $commonTitleField=new ItemField, "SELECT * FROM @customfield WHERE isCommon=1 AND columnIndex='title'" );
            }
            // a displayLength-en nem az egyes kategoriak description mezoinek displayLenght-je hatarozza meg,
            // hanem az amit a common description fieldben van:
            $this->applyDisplayLengthLimit( $this->{$columnIndex}, $commonTitleField->displaylength );
            if( $encoding && !$field->allowHtml ) 
            {
                return htmlspecialchars($this->{$columnIndex});
            }
            else return $this->{$columnIndex};
        }
    }
    else return "";
}

function getDescription($encoding=TRUE)
{
    static $commonDescriptionField=0;
    
    $columnIndex = FALSE;
    if( $fields = $this->getFields() )
    {
        foreach( $fields as $field ) 
        {
            if( $field->seo==customfield_description )
            {
                $columnIndex = $field->columnIndex;
                break;
            }
        }
        if( $columnIndex===FALSE || !isset($this->{$columnIndex}) ) return "";
        else
        {
            if( !$commonDescriptionField ) 
            {
                loadSQL( $commonDescriptionField=new ItemField, "SELECT * FROM @customfield WHERE isCommon=1 AND columnIndex='description'" );
            }
            // a displayLength-en nem az egyes kategoriak description mezoinek displayLenght-je hatarozza meg,
            // hanem az amit a common description fieldben van:
            $this->applyDisplayLengthLimit( $this->{$columnIndex}, $commonDescriptionField->displaylength );
            if( $encoding && !$field->allowHtml ) 
            {
                return htmlspecialchars($this->{$columnIndex});
            }
            else return $this->{$columnIndex};
        }
    }
    else return "";
}

function getKeywords()
{
    $columnIndex = FALSE;
    if( $fields = $this->getFields() )
    {
        foreach( $fields as $field ) 
        {
            if( $field->seo==customfield_keywords )
            {
                $columnIndex = $field->columnIndex;
                break;
            }
        }
        if( $columnIndex===FALSE || !isset($this->{$columnIndex}) ) return "";
        return $this->{$columnIndex};
    }
    else return "";
}

function getPicture($thsize='medium')
{
    $columnIndex = FALSE;
    $picInfo = array('ext'=>'','thumbnail'=>'', 'picture'=>''); 
    
    if ($this->oodleType>0) {
      $picInfo['thumbnail'] = $this->oodleImageUrl;
      $picInfo['th_width'] = 50;
      $picInfo['th_height'] = 50;

      $picInfo['picture'] = $this->oodleImageUrl;
      $picInfo['width'] = 150;
      $picInfo['height'] = 140;

      return $picInfo;
      
    }
    
    if( $fields = $this->getFields() )
    {
        foreach( $fields as $field ) 
        {
            if( $field->mainPicture )
            {
                $columnIndex = $field->columnIndex;
                break;
            }
        }
        if( $columnIndex===FALSE || empty($this->{$columnIndex}) ) return $picInfo;
        $thName = AD_PIC_DIR . "/th_{$thsize}_$this->id"."_".substr($columnIndex, 4).".".$this->{$columnIndex};
        $picName = AD_PIC_DIR . "/$this->id"."_".substr($columnIndex, 4).".".$this->{$columnIndex};
        $picInfo['ext'] = $this->{$columnIndex};
        if( file_exists($thName) ) 
        {
            $picInfo['thumbnail'] = Controller::getBaseUrl() . $thName;
            $size = getimagesize( $thName );
            $picInfo['th_width'] = $size[0];
            $picInfo['th_height'] = $size[1];
        }
        if( file_exists($picName) ) 
        {
            $picInfo['picture'] = Controller::getBaseUrl() . $picName;
            $size = getimagesize( $picName );
            $picInfo['width'] = $size[0];
            $picInfo['height'] = $size[1];
        }
    }
    return $picInfo;
}

function getPageTitle()
{
    global $gorumroll;
    
    if( $this->pageTitle ) return $this->pageTitle;
    // CustomList eseteben:
    elseif( $gorumroll->list=="item_search" && $gorumroll->rollid )
    {
        $ret = mysql_fetch_array(executeQuery("SELECT listTitle FROM @search WHERE id=#id#", $gorumroll->rollid), MYSQL_ASSOC);
        return $ret["listTitle"];
    }
    return $this->getTitle(FALSE);
}

function getPageDescription()
{
    if( $this->pageDescription ) return $this->pageDescription;
    return $this->getDescription(FALSE);
}

function getPageKeywords()
{
    if( $this->pageKeywords ) return $this->pageKeywords;
    elseif( !empty($this->cid) ) return $this->getKeywords(FALSE);
}

function showHtmlList($elementName="", $cacheManager=0)
{
    global $gorumroll;
    
    // ez beallitja $this->select-et es vegrehajtja a setupCustomListAppearance-t ha szukseges:
    $this->getListSelect(FALSE, $elementName);
    // ha egy kategoria itemjei:
    if( $gorumroll->list=="item"  ) $this->setupCategorySpecificList();
    parent::showHtmlList($elementName, $cacheManager);
}

function setupCategorySpecificList( $cid=0 )
{
    global $gorumroll, $lll, $item_typ;

    $_S = new AppSettings();
    $this->cid = $cid ? $cid : $gorumroll->rollid;
    $this->activateVariableFields();
    G::load($c, $this->cid, "appcategory");
    // Category specifikus ad list title beallitasa:
    if( $c->customAdListTitle ) $lll["item_ttitle"]=$c->getAttr("customAdListTitle");
    $this->immediateAppear = $c->immediateAppear;
    if( $c->customAdListTemplate ) $item_typ["listTemplate"] = $c->customAdListTemplate;
    elseif( $_S->customAdListTemplate ) $item_typ["listTemplate"] = $_S->customAdListTemplate;
}

// hogy ne csak a cronjob hivhassa oket, hanem admin is:
function checkExpiration()
{
    hasAdminRights($isAdm);
    if( $isAdm ) $count = checkExpiration();
    Roll::setInfoText("$count expiration warning emails have been sent out.");
    $this->nextAction = new AppController("/");
}
function deleteExpiredAds()
{
    hasAdminRights($isAdm);
    if( $isAdm ) $count = deleteExpiredAds();
    Roll::setInfoText("$count expired ads have been deleted.");
    $this->nextAction = new AppController("/");
}

function downloadOodle() 
{
    
    
    $npath = substr(dirname(__FILE__), 0,-4);
    
    downloadOodle();
    
//    Roll::setInfoText("php5 ". $npath . "/nl.php");
    Roll::setInfoText("Downloading Oodle ads.");
    $this->nextAction = new AppController("/");
}

function showDetailsTool()
{
    return "";
}

function getCacheTimeFrameAndCategorySpecificity()
{
    global $gorumroll;
    
    $timeFrame = $categorySpecific = 0;
    if( $gorumroll->list=="item_search" && $gorumroll->rollid>2 /* My ads */ )
    {
        // lekerdezzuk a custom list 'cache' mezejet:
        if( $result = executeQuery(array("SELECT * FROM @search WHERE id=#id#", $gorumroll->rollid)) )
        {
            $row=mysql_fetch_array($result, MYSQL_ASSOC);
            $timeFrame = $row["cache"];
            $categorySpecific = $row["categorySpecific"];
            CustomList::getSortingSql($row["primarySort"], $row["primaryDir"], $row["primaryPersistent"], $row["secondarySort"], $row["secondaryDir"], $row["secondaryPersistent"]);
        }     
    }
    return array($timeFrame, $categorySpecific);
}

function getEmailParams( &$params, $withLoad=TRUE, $withOwner=TRUE, $extraParams=TRUE, $excludeAttr=0 )
{
    global $item_typ;
    if( $withLoad )
    {
        $this->getCid();
        $this->activateVariableFields();
        load($this); 
    }
    if( $extraParams )
    {
        $title = $this->getTitle(FALSE);
        $ctrl = $this->getLinkCtrl($title);
        $navBarPieces = $this->getNavBarPieces(TRUE, TRUE); // absolute
        $params = array(
            "listing"      => htmlspecialchars($title),
            "plainTitle"   => htmlspecialchars($title),
            "title"        => $ctrl->generAnchor($title, "", TRUE, "", TRUE),  // absolute
            "breadcrumb"   => Roll::composeNavBarPieces($navBarPieces),
            "wholeCatName" => htmlspecialchars($this->getWholeCatName()),
            "daysLeft"     => !isset($this->expirationTime) || !is_object($this->expirationTime) || $this->expirationTime->isEmpty() ? "" : round($this->expirationTime->getDayDiff()),
            "description"  => $this->getDescription(),
            "url"          => $ctrl->makeUrl(TRUE),
            "category"     => htmlspecialchars($this->getCatName()),
            "status"       => $this->showListVal("status"),
        );
    }
    else $params = array(
        "category"     => htmlspecialchars($this->getCatName()),
        "status"     => $this->showListVal("status"),
    );
    if( $withOwner )
    {
        $owner = User::createObject();
        $owner->id = $this->ownerId;
        $owner->getEmailParams($params["owner"]);
    }
    $this->getEmailParamsCore($params, $excludeAttr);
    if( $withOwner ) return $owner->email;
}

function getWholeCatName()
{
    if( isset($this->wholeCatName) ) return $this->wholeCatName;
    return G::getAttr( $this->cid, "appcategory", "wholeName" );
}

function getCatPermaLink()
{
    if( !empty($this->catPermaLink) ) return $this->catPermaLink;
    return G::getAttr( $this->cid, "appcategory", "permaLink" );
}

function getCatName()
{
    if( isset($this->cName) ) return $this->cName;
    return G::getAttr( $this->cid, "appcategory", "name" );
}

   
function getLinkCtrl($title="", $absolute=FALSE)
{
    global $seoSeparator;
    $_S = new AppSettings();
    if( $_S->permaLinksEnabled() )
    {
        if( !$title ) $title = $this->getTitle(FALSE);
        if ($this->oodleType==1) {
         $permaLink = "O{$this->oodleID}_" . $this->seoConvert($title, $seoSeparator);
        } else $permaLink = "{$this->id}_" . $this->seoConvert($title, $seoSeparator);
        if( !$_S->ommitCatPermaLink ) 
        {
            $catPermaLink = $this->getCatPermaLink();
            $permaLink = "$catPermaLink/$permaLink";
        }
        $ctrl = new AppController();
        $ctrl->setPermaLink($permaLink);
    }
    else $ctrl = new AppController($this->get_class() . "/$this->id");
    $ctrl->setAbsolute($absolute);
    return $ctrl;
}

function showAppCName()
{
    $c = new AppCategory;
    $c->id = $this->getCid();
    $c->name = $this->getCatName();
    $c->permaLink = $this->getCatPermaLink();
    return $c->showListVal("name");
}

function applyAfterView()
{
    global $gorumroll;
    
    View::assign("customMetaTags", "");
    View::assign("navBar", "");
    if( $gorumroll->method!="showdetails" ) return TRUE;
    if( $customAdMeta = G::getAttr($this->cid, "appcategory", "customAdMeta") )
    {
        $customAdMeta = $this->prepareCustomMetaTags($customAdMeta);
        View::assign("customMetaTags", $customAdMeta);
        View::assign("navBar", Roll::composeNavBarPieces($this->getNavBarPieces()));
        return FALSE;
    }
    return TRUE;
}

function prepareCustomMetaTags($customAdMeta)
{
    $_S = new AppSettings();
    $this->prepareVariableSubstitutionRules( $patterns, $replacements );
    G::load( $cat, $this->cid, "appcategory" );
    $patterns[] = "/{\s*category:\s*title\s*}/i";
    $replacements[]=htmlspecialchars(strip_tags(nl2br($cat->name)));    
    $patterns[] = "/{\s*category:\s*description\s*}/i";
    $replacements[]=htmlspecialchars(strip_tags(nl2br($cat->descriptionMeta)));    
    $patterns[] = "/{\s*category:\s*keywords\s*}/i";
    $replacements[]=htmlspecialchars(strip_tags(nl2br($cat->keywords)));    
    $patterns[] = "/{\s*site:\s*title\s*}/i";
    $replacements[]=htmlspecialchars(strip_tags(nl2br($_S->mainTitle)));
    $patterns[] = "/{\s*site:\s*title\s*prefix\s*}/i";
    $replacements[]=htmlspecialchars(strip_tags(nl2br($_S->titlePrefix)));
    $patterns[] = "/{\s*site:\s*description\s*}/i";
    $replacements[]=htmlspecialchars(strip_tags(nl2br($_S->mainDescription)));
    $patterns[] = "/{\s*site:\s*keywords\s*}/i";
    $replacements[]=htmlspecialchars(strip_tags(nl2br($_S->mainKeywords)));
    return preg_replace( $patterns, $replacements, $customAdMeta );
}

} // class


function fire_script($script,$buffer_output=1)
{
 if(!session_id()) session_start();
 $md5_script=md5($script);
 if (!isset($_SESSION[$md5_script]))//check script is not already running
 {
      $_SESSION[$md5_script]="currently-running";
      $start_time = microtime(true);
      if($buffer_output) ob_start();
      $fire_type = (function_exists('curl_exec') ) ? " PHP CURL " : " PHP fsockopen ";
      //                 "://" satisfies both cases http:// and https://
      if (strstr($script,"://") ) fire_remote_script($script);
      else
       {
         include(LOCATION.$script);
         $fire_type=" PHP include ";
       }
      if($buffer_output) $output=ob_get_contents();
      else $output="";
      if($buffer_output) ob_end_clean();
      $execution_time=number_format( (microtime(true) - $start_time), 5 )." seconds via".$fire_type;
      $output=substr($output, 0, MAX_ERROR_LOG_LENGTH);// truncate output to defined length
      if (ERROR_LOG) save_log($script,$output,$execution_time);
      unset($_SESSION[$md5_script]);
 }
}



function downloadOodle()
{
    include_once(NOAH_BASE."/oodle/post_oodle.php");

    $_S = new Settings;

    Oodle::post_ads($_S->oodleSerial);     
}


function checkExpiration()
{
    global $noahsHost, $noahsVersionCheckScript, $item_typ, $fatherCatList;
    
    $_S = new Settings;
    $timeBeforeExp = Date::add($_S->expNoticeBefore, Date_Day);
    $query = "SELECT id, cid FROM @item WHERE ".
             "expirationTime!=0 AND expEmailSent=0 AND status=1 AND expirationTime<'".$timeBeforeExp->getDbFormat()."' ORDER BY cid ASC";
    G::load( $items, $query );
    G::load($n, Notification_adExpired, "notification");
    if( $n->active ) 
    {
        for( $i=0; $i<count($items); $i++ )
        {
            if( $i && $items[$i]->cid!=$items[$i-1]->cid ) 
            {
                include("item_typ.php");
                $fatherCatList = 0;
            }
            $ownerEmail = $items[$i]->getEmailParams($params);
            $n->send( $ownerEmail, $params );
            executeQuery("UPDATE @item SET expEmailSent=1 WHERE id=".$items[$i]->id);
        }
    }
	CustomField::checkFieldExpiration();
    $_GS = new GlobalStat;
    if( !$_GS->reg ) 
    {
        $_GS->reg = md5(uniqid(rand(), true));
        modify($_GS);
    }
    $ck = new CheckConf();
    $data = $ck->getTransferData($_GS);
    $ck->getVersionInfo($noahsHost, "POST", $noahsVersionCheckScript, $data);
    return count($items);
}

function deleteExpiredAds()
{
    global $fatherCatList, $item_typ;
    
    $query = "SELECT id, cid FROM @item WHERE ".
             "expirationTime!=0 AND status=1 AND expirationTime<NOW() ORDER BY cid ASC";
    G::load( $items, $query );
    G::load($n, Notification_adDeleted, "notification");
    $_S = new AppSettings();
    for( $i=0; $i<count($items); $i++ )
    {
        if( $i && $items[$i]->cid!=$items[$i-1]->cid ) 
        {
            include("item_typ.php");
            $fatherCatList = 0;
        }
        if( $n->active ) 
        {
            $ownerEmail = $items[$i]->getEmailParams($params);
            $n->send( $ownerEmail, $params );
        }
        if( $_S->deleteAdsOnExpiry )
        {
            // azert TRUE-val,  mert nem akarjuk, hogy a delete is kuldjon egy mailt:
            $items[$i]->delete("","cronjob");
        }
        else
        {
            $item = new Item;
            $item->id = $items[$i]->id;
            $item->cid = $items[$i]->cid;
            $item->status = 0;
            $item->changeStatus(FALSE);
            modify($item);
        }
    }
    return count($items);
}

?>
