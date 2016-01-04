<?php
defined('_NOAH') or die('Restricted access');

function authenticate( $fromLogin=FALSE )
{
    global $gorumuser, $gorumroll, $gorumauthlevel, $gorumrecognised;
    global $autoLogout, $autoLogoutTime, $cookiePath, $testauth, $now;
    global $dontSetLastClickTime, $includeGuestsInCurrentlyOnline;


    if( !empty($_COOKIE["sessionUserId"]) && !empty($_COOKIE["usrPassword"]))
    {
        if( !G::load( $gorumuser, $_COOKIE["sessionUserId"], "user") )
        {
            if( $_COOKIE["usrPassword"] && $gorumuser->password == $_COOKIE["usrPassword"])
            {
                $expired = $fromLogin ? FALSE : timeoutExpired();
                if( !$expired )
                {
                    $gorumauthlevel = Loginlib_LowLevel;
                    $gorumrecognised = TRUE;
                    if(!isset($dontSetLastClickTime)) 
                    {
                        $gorumuser->lastClickTime = $now;
                        executeQuery(array("UPDATE @user SET lastClickTime=#lct# WHERE id=#id#", $now->getDbFormat(), $gorumuser->id));
                    }
                }
                return;
            }
        }
    }
    if( !empty($_COOKIE["globalUserId"]) )
    {
        if( !G::load( $gorumuser, $_COOKIE["globalUserId"], "user") )
        {
            if( $gorumuser->id==$gorumuser->name || (isset($_COOKIE["usrPassword"]) && $gorumuser->password == $_COOKIE["usrPassword"]) )
            {
                if( $gorumuser->id==$gorumuser->name )
                {
                    $gorumauthlevel = Loginlib_GuestLevel;
                    $gorumrecognised = FALSE;
                    if( isset($includeGuestsInCurrentlyOnline) && !isset($dontSetLastClickTime) )
                    {
                        executeQuery(array("UPDATE @user SET lastClickTime=#lct# WHERE id=#id#", $now->getDbFormat(), $gorumuser->id));
                    }
                }
                else
                {
                    $gorumauthlevel = Loginlib_BasicLevel;
                    $gorumrecognised = !empty($gorumuser->rememberPassword);
                    // Ez a feltetel csak akkor aktualizalja a
                    // lastClickTime-ot, ha a user recognised. Ez igy jo
                    // is, csak az a problema, hogy akkor a
                    // currentlyOnline sorban nem tudnak meg guest-kent
                    // se szerepelni azok a juzerek, akik azonositottak,
                    // de nem recognised-ok:
                    if( ($gorumrecognised || isset($includeGuestsInCurrentlyOnline)) && !isset($dontSetLastClickTime))
                    {
                        executeQuery(array("UPDATE @user SET lastClickTime=#lct# WHERE id=#id#", $now->getDbFormat(), $gorumuser->id));
                    }
                }
                return;
            }
        }
        else // not_found_in_db 
        {
            $gorumauthlevel = Loginlib_GuestLevel;
            //than create without name
            $gorumuser->init(array("id"=>$gorumuser->id, "name"=>$gorumuser->id));
            // azert csinaljuk igy, hogy a valid ne hivodjon:
            executeQuery("INSERT INTO @user SET id=#id#, name=#name#", $gorumuser->id, $gorumuser->id);
            if( isset($includeGuestsInCurrentlyOnline) )
            {
                $gorumuser->lastClickTime = $now;
                executeQuery("UPDATE @user SET lastClickTime=#lc# WHERE id=#id#", $now->getDbFormat(), $gorumuser->id);
            }

            // azert hogy az isAdm es hasonlok is ki legyenek toltve:
            load($gorumuser);
            if( isset($_COOKIE["usrPassword"]) ) 
            {
                setcookie("usrPassword","",Loginlib_ExpirationDate, $cookiePath);
            }
            $gorumrecognised = FALSE;
            return;
        }
    }
    $gorumauthlevel = Loginlib_NewUser;
    $gorumrecognised = FALSE;
    generateRandomId( $randomId );
    $gorumuser = new User;
    $gorumuser->isAdm = FALSE;
    $gorumuser->isMod = FALSE;
    $gorumuser->id = $randomId;
    $gorumuser->name = $randomId;
    //: Note: The sideeffect of this function is that it tries to set
    //:       the GlobalUserId cookie if the level of authentication
    //:       has proved to be NewUser.
    setcookie("globalUserId",$randomId,Loginlib_ExpirationDate, $cookiePath);
}

function timeoutExpired()
{
    global $gorumuser, $gorumroll, $gorumauthlevel, $gorumrecognised;
    global $autoLogout, $autoLogoutTime, $scriptName;
    
    if( $autoLogout &&
    // TODO:
        time()-$gorumuser->lastClickTime > $autoLogoutTime*60 &&
        ($gorumroll->list!="user" ||
        ($gorumroll->method!="create_form"&&
        $gorumroll->method!="create"&&
        $gorumroll->method!="login_form"&&
        $gorumroll->method!="login")))
    {
        logout();
        $s = "Timeout expired. Please, log in!";
        $s.= "<p><a href='$scriptName'>Click here to return to the application!</a>";
        echo $s;
        die();
    }
    return FALSE;
}

function createFirstAdmin()
{
    global $gorumauthlevel, $gorumuser, $gorumroll;
    global $gorumrecognised, $registrationType, $now;
    global $cookiePath, $user_typ, $noFirstAdmin, $infoText;

    if( empty($noFirstAdmin) )
    {
        $gorumauthlevel = Loginlib_LowLevel;
        $gorumrecognised = TRUE;
        $gorumuser = new User;
        if( isset($_COOKIE["globalUserId"]) ) $gorumuser->id = $_COOKIE["globalUserId"];
        else generateRandomId( $gorumuser->id );
        $gorumuser->name = "admin";
        $gorumuser->password = getPassword("admin");
        if( isset($user_typ["attributes"]["email"]) )
        {
            $gorumuser->email = "";
        }
        $gorumuser->isAdm = TRUE;
        if( $registrationType==User_emailCheck ) $gorumuser->active = TRUE;
        $gorumuser->lastClickTime = $now;
    
        create($gorumuser);
        // azert hogy az isAdm es hasonlok is ki legyenek benne toltve:
        load($gorumuser);
        setcookie("usrPassword",$gorumuser->password,
                  Loginlib_ExpirationDate, $cookiePath);
        setcookie("sessionUserId", $gorumuser->id, 0, $cookiePath );
    }
}

function generateRandomId( &$id )
{
    global $randIdMax,$randIdMin;
    if (!isset($randIdMin)) $randIdMin=0;
    if (!isset($randIdMax)) $randIdMax=getrandmax();
    $user = new User;
    mt_srand((double)microtime()*1000000);
    do
    {
        $id = (int)mt_rand($randIdMin,$randIdMax);
        $user->id = $id;
        $ret = load($user);
    }
    while( !$ret );
    return ok;
}

function initializeTimeoutServices()
{
    // Ez a fuggveny a gorumban nincs felhivva. Ha az applikacioban
    // netalantan felhivnank, akkor ott kell gondoskodni rola, hogy a
    // leszarmazott userben a lastClickTime attributum benne legyen.
    global $gorumuser, $now;

    $gorumuser->lastClickTime = time();
    $user = new User;
    $user->init( array("id"=>$gorumuser->id,
                       "lastClickTime"=>$gorumuser->lastClickTime) );
    modify($user);
    return ok;
}

function logout($noLocation=FALSE)
{
    global $cookiePath, $gorumuser;
    
    if( $_COOKIE["globalUserId"] )
    {
        setcookie("globalUserId","",Loginlib_ExpirationDate, $cookiePath);
    }
    if( $_COOKIE["sessionUserId"] )
    {
        setcookie("sessionUserId","",0, $cookiePath);
    }
    if( $_COOKIE["usrPassword"] )
    {
        setcookie("usrPassword","",Loginlib_ExpirationDate, $cookiePath);
    }
    $_COOKIE["globalUserId"] = 0;
    $_COOKIE["sessionUserId"] = 0;
    $_COOKIE["usrPassword"] = 0;
    Roll::setInfoText("goodbye", $gorumuser->name);
    LocationHistory::saveInfoText();

    $gorumuser->isAdm=FALSE;
    LocationHistory::rollBack(new AppController("/"));
}

?>
