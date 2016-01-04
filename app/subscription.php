<?php
defined('_NOAH') or die('Restricted access');
$subscription_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "cid"=>array(
                "type"=>"INT",
                "class"=>"category",
                "labelAttr"=>"wholeName",
                "nothing selected"=>"allCategories",
                "get_values_callback"=>'getSelectFromTree()',
                "conditions"=>array("\$isAdm"=>"classselection")
            ),
            "catName"=>array(
                "type"=>"VARCHAR",
                "no column",
                "form invisible",
                "conditions"=>array("\$gorumroll->list!='subscription_cat'"=>"list"),
                "link_to"=>array("class"=>"appcategory", "id"=>"cid", "other_attr"=>"name"),
                "sorta",
            ),
            "uid"=>array(
                "type"=>"INT",
                "form invisible"
            ),
            "userName"=>array(
                "type"=>"VARCHAR",
                "no column",
                "conditions"=>array("\$gorumroll->list!='subscription_my'"=>"list"),
                "link_to"=>array("class"=>"user", "id"=>"uid", "other_attr"=>"name", "not_exists"=>"Not registered"),
                "sorta",
            ),
            "email"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "cols"=>50,
                "rows"=>5,
                "mandatory",
                "safetext",
                "sorta",
                "conditions"=>array("\$gorumroll->list!='subscription_my'"=>"list",
                                    "\$isAdm"=>"textarea",
                                    "!\$isAdm"=>"text"),
            ),
            "creationtime"=>array(
                "type"=>"DATETIME",
                "form invisible",
                "prototype"=>"date",
                "sorta",
                "conditions"=>array("\$gorumroll->list!='subscription_my'"=>"list"),
            ),
            "unsub"=>array(
                "type"=>"INT",
            ),
            "catPermaLink"=>array(
                "type"=>"VARCHAR",
                "no column",                
            ),
        ),
        "primary_key"=>"id",
        "delete_confirm"=>"userName",
        "sort_criteria_attr"=>"creationtime",
        "sort_criteria_dir"=>"d",
    );

class Subscription extends Object
{
    
function createForm()
{
    global $lll, $gorumrecognised;
    
    hasAdminRights($isAdm);
    if( $isAdm ) 
    {
        $lll["subscription_create_form"]=$lll["subscription_create_form_admin"];
        $lll["subscription_email_expl"]=$lll["subscription_email_expl_admin"];
    } elseif (!$gorumrecognised)
    {
        LocationHistory::rollBack(new AppController("/"));        
    }
    parent::createForm();
}

function create()
{
    global $gorumuser, $gorumroll, $gorumrecognised;
    
    if( !isset($this->cid) ) $this->cid = $gorumroll->rollid;
    hasAdminRights($isAdm);
    if( !$gorumrecognised && !$this->email )
    {
        return Roll::setFormInvalid("emailMandatory");
    }
    if( !$gorumrecognised && $this->email )
    {
        if( !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', $this->email) )
        {
            return Roll::setFormInvalid("invalidEmail");
        }
        $this->unsub = FALSE;
        $this->subscribeAction();        
        if( !$isAdm ) return Roll::setInfoText("subscribed");
    }
    elseif( !$isAdm )
    {
        $this->uid = $gorumuser->id;
        create($this);
        $this->rollBackNum = 1;
        return Roll::setInfoText("subscribed");
    }
    else
    {
        ini_set("max_execution_time", 0);
        $this->unsub = FALSE;
        $emails = array_unique(array_map(create_function('$v', 'return trim(strtolower($v));'), explode("\n", $this->email)));        
        foreach( $emails as $this->email )
        {
            $this->subscribeAction();
        }
    }
}

function delete()
{
    global $gorumuser, $gorumroll, $gorumrecognised;

    hasAdminRights($isAdm);
    if( !empty($this->id) )
    {
        if( $isAdm ) delete($this);  // admin delete
    }
    else
    {
        $this->cid = $gorumroll->rollid;
        if( !empty($this->email) )
        {
            $this->unsub = TRUE;
            $this->subscribeAction();
        }
        elseif( $this->uid )
        {
            delete($this, array("cid", "uid"));
        }
        elseif( $gorumrecognised )
        {
            $this->uid = $gorumuser->id;
            delete($this, array("cid", "uid"));
        }
        $this->rollBackNum = 1;
        Roll::setInfoText("unsubscribed");
    }
}

function subscribeAction()
{
    hasAdminRights($isAdm);
    $this->email = trim(strtolower($this->email));
    if( !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', $this->email) ) return;
    if( $this->unsub )
    {
        if( $this->cid )
        {
            if( $this->exists($this->cid, TRUE) ) return;  // ha mar egyszer leiratkozott errol a ketagoriarol
            if( $this->exists(0         , TRUE) ) return;  // ha mar egyszer leiratkozott az oszses kategoriarol
            if( $this->exists($this->cid, FALSE))          // ha mar egyszer feliratkozott erre a kategoriara
            {
                $this->deleteSub($this->cid, FALSE);       // a feliratkozast toroljuk
            }
            if( $this->exists(0            , FALSE)  )     // ha mar egyszer feliratkozott az osszes kategoriara
            {
                $this->deleteSub(0, FALSE);                // a feliratkozast toroljuk
            }
            $this->insertSub();
        }
        else //all categories
        {
            if( $this->exists(0, TRUE) ) return;  // ha mar egyszer leiratkozott az oszses kategoriarol
            $this->deleteSub('*', '*');            // minden fel es leiratkozast torlunk
            $this->insertSub();
        }
    }
    else  // subscribe
    {
        if( $isAdm )
        {
            if( $this->cid )
            {
                if( $this->exists($this->cid, '*') ) return; // ha mar fel vagy leiratkozott erre a kategoriara
                if( $this->exists(0         , '*') ) return; // ha mar fel vagy leiratkozott az oszses kategoriara
                $this->insertSub();
            }
            else //all categories
            {
                if( $this->exists(0,   FALSE) ) return; // ha mar feliratkozott az oszses kategoriara
                if( $this->exists('*', TRUE) ) return;  // ha mar egyszer leiratkozott valamelyik kategoriarol
                $this->deleteSub('*', FALSE);           // minden feliratkozast torlunk
                $this->insertSub();
            }
        }
        else // user
        {
            if( $this->cid )
            {
                if( $this->exists($this->cid, FALSE) ) return;  // ha mar feliratkozott erre a kategoriara
                if( $this->exists(0         , FALSE) ) return;  // ha mar feliratkozott az oszses kategoriara
                if( $this->exists($this->cid, TRUE)  )          // ha mar egyszer leiratkozott errol a kategoriarol
                {
                    $this->deleteSub($this->cid, TRUE);         // a leiratkozast toroljuk
                }
                if( $this->exists(0            , TRUE)  )       // ha mar egyszer leiratkozott az osszes kategoriarol
                {
                    $this->deleteSub(0, TRUE);                  // a leiratkozast toroljuk
                }
                $this->insertSub();
            }
            else //all categories
            {
                if( $this->exists(0, FALSE) ) return;  // ha mar feliratkozott az oszses kategoriara
                $this->deleteSub('*', '*');            // minden fel es leiratkozast torlunk
                $this->insertSub();
            }
        }
    }
}

function exists($cid, $unsub)
{
    $whereCond="";
    if( $cid!=='*' ) $whereCond.="AND cid='$cid'";  
    if( $unsub!=='*' ) $whereCond.="AND unsub=".intval($unsub);  
    $query = "SELECT id FROM @subscription WHERE email=#email# $whereCond LIMIT 1";
    //FP::log($query);
    return !loadSQL($s = new Subscription, array($query, $this->email));
}

function deleteSub($cid, $unsub)
{
    $whereCond="";
    if( $cid!='*' ) $whereCond.="AND cid='$cid'";  
    if( $unsub!=='*' ) $whereCond.="AND unsub=".intval($unsub);  
    $query = "DELETE FROM @subscription WHERE email=#email# $whereCond";
    //FP::log($query);
    executeQuery(array($query, $this->email));
}

function insertSub()
{
    $this->id = 0;
    create($this);    
}

function getListSelect()
{
    global $gorumroll, $subscription_typ, $gorumuser;

    hasAdminRights($isAdm);
    if ($gorumroll->list=="subscription" || $gorumroll->list=="subscription_unsub")
    {
        if( !$isAdm ) handleError("Permission denied");
        $select = "SELECT s.*, c.wholeName AS catName, c.permaLink AS catPermaLink, u.name AS userName, IF(u.id, u.email, s.email) AS email ".
                  "FROM @subscription AS s LEFT JOIN @user AS u ".
                  "ON s.uid=u.id LEFT JOIN @category AS c ON c.id=s.cid WHERE unsub=";
        $select .= $gorumroll->list=="subscription_unsub" ? "1" : "0";
        $subscription_typ["attributes"]["userName"][]="list";
        $subscription_typ["attributes"]["email"][]="list";
        $subscription_typ["attributes"]["catName"][]="list";
    }
    elseif ($gorumroll->list=="subscription_cat")
    {
        if( !$isAdm ) handleError("Permission denied");
        $select = array("SELECT s.*, u.name AS userName ".
                  "FROM @subscription AS s LEFT JOIN @user AS u ".
                  "ON s.uid=u.id WHERE cid=#rollid#", $gorumroll->rollid);
        $subscription_typ["attributes"]["userName"][]="list";
        $subscription_typ["attributes"]["email"][]="list";
    }
    elseif ($gorumroll->list=="subscription_my")
    {
        $select = array("SELECT s.*, c.wholeName AS catName, c.permaLink AS catPermaLink ".
                  "FROM @subscription AS s, @category AS c ".
                  "WHERE c.id=s.cid AND uid=#gorumuser->id#", $gorumuser->id);
        $subscription_typ["attributes"]["catName"][]="list";
    }
    return $select;
}

function showModTool()
{
    return "";
}

function showNewTool($rights)
{
    global $gorumroll;
    
    if( $gorumroll->list=="subscription" ) return parent::showNewTool($rights);
    return "";
}

function showDetailsTool()
{
    return "";
}

function showListVal($attr)
{
    global $lll;
    
    if( $attr=="catName" )
    {        
        if( !$this->cid ) return $lll["allCategories"];
        $c = new AppCategory;
        $c->id = $this->cid;
        $c->name = $this->catName;
        $c->permaLink = $this->catPermaLink;
        return $c->showListVal("name");        
    }
    elseif( ($s=parent::showListVal($attr))!==FALSE ) return $s;
    else
    {
        $s=parent::showListVal($attr, "safetext");
    }
    return $s;
}

function getSelectFromTree()
{
    return Item::getSelectFromTree();
}

function showHtmlList()
{
    global $gorumroll;
    
    parent::showHtmlList();
    if( $gorumroll->list=="subscription" )
    {
        $ctrl = new AppController("subscription_unsub/list");
        $gorumroll->processMethod($ctrl, "unsubList" );
    }
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
  
    hasAdminRights($isAdm);
    if( !$isAdm ) return array();
    $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    $navBarPieces[$lll["subscription_ttitle"]] = $gorumroll->method=="showhtmllist" ? "" : new AppController("subscription/list");
    return $navBarPieces;
}
}
?>