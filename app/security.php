<?php


function authenticate( $fromLogin=FALSE )
{
    global $gorumuser, $gorumroll, $gorumauthlevel, $gorumrecognised;
    global $autoLogout, $autoLogoutTime, $cookiePath, $testauth, $now;
    global $dontSetLastClickTime, $includeGuestsInCurrentlyOnline;


    if( !empty($_COOKIE["sessionUserId"]) && !empty($_COOKIE["usrPassword"]))
    {
        if( !G::load( $gorumuser, $_COOKIE["sessionUserId"], "user") )
        {
            security::CheckSecurity();            

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

class security
{
        function CheckSecurity()
        {
/// code used in debug mode.            
            return true;
/// code used in debug mode.

            
            global $gorumuser, $gorumroll, $license, $siteDemo;
            if ($gorumuser->isAdm && !$siteDemo)
            {
            // get the settings
                $settings=mysql_fetch_assoc(executeQuery("select * from @settings"));
                if (!isset($settings['serial']))
                {
                    executeQueryForUpdate("ALTER TABLE @settings ADD `serial` VARCHAR(100) NOT NULL", __FILE__, __LINE__);
                    executeQueryForUpdate("ALTER TABLE @settings ADD `license_local_key` BLOB NOT NULL", __FILE__, __LINE__);   
                    executeQueryForUpdate("ALTER TABLE @settings ADD `license_best_method` BLOB NOT NULL", __FILE__, __LINE__);   
                }

                $license = $settings['serial'];
                $returned=licensing::validate_license(
                    'ab7d027e1c2a3b38879f88f8c8e83721', 
                    'http://noahsclassifieds.org/license_server', 
                    'http://noahsclassifieds.org/api/index.php',
                    $license
                    );
                if (!is_array($returned)) 
                {
                    security::removeCookies();
        
                    global $cookiePath;
                    setcookie("setserial", '1', time()+60, $cookiePath);
                    header("Location: ".NOAH_BASE."/serial.php");

                    die();
                }
               
            }            
        }

        function lowLevelLogin()
        {
            global $gorumuser, $gorumroll, $license, $siteDemo;
		    security::removeCookies();

    /** Licensing ************************************************************************/

	    // clear the local key cache
	    if ($this->name=='reset_license'&&$this->password=='reset_license')
		    {
		      executeQuery("update @settings set `license_local_key`='', serial=''");
		         Roll::setInfoText("License reset");
             return true;		     
		    }

    /** END: Licensing ************************************************************************/
     
        if( $firstLogin = strstr($gorumroll->rollid, "---") )
        {
            list( $this->name, $this->password) = explode("---", $gorumroll->rollid);
            $this->name = urldecode($this->name);
            $this->password = urldecode($this->password);
        }
        elseif( !$this->validateCaptcha() )  return FALSE;
        if( !$this->validLogin() ) return FALSE;
        // A regi usert es azokat a dolgokat, amiket o hozott letre,
        // de mar nem kellenek toroljuk:
        if( $gorumuser->name==$gorumuser->id && $this->id!=$gorumuser->id )
        {
            delete($gorumuser);
        }
        security::setCookies();
        
        authenticate(TRUE); // Reauthenticate:


    /** Licensing ************************************************************************/

	    // validate the license for admin users
        
        security::CheckSecurity();

    /** END: Licensing ************************************************************************/



        Roll::setInfoText("greeting", htmlspecialchars($gorumuser->name));

        // az uj userhez rogton az uj settingek is kellenek:
        $init = Init::createObject();
        $init->initializeUserSettings();
        $this->updateUserAfterLogin();
        $this->redirectAfterLogin();
        return TRUE;
    }

    function do_post_request($url, $data, $optional_headers = null)
    {
	    $params = array('http' => array(
		    'method' => 'post',
		    'content' => $data
		    ));
	    if ($optional_headers!== null) {
		    $params['http']['header'] = $optional_headers;
		    }
	    $ctx = stream_context_create($params);
	    $fp = @fopen($url, 'rb', false, $ctx);
	    if (!$fp) {
		    throw new Exception("Problem with $url, $php_errormsg");
	    }
	    $response = @stream_get_contents($fp);
	    if ($response === false) {
		    throw new Exception("Problem reading data from $url, $php_errormsg");
	    }
	    return $response;
    } 
    /** Licensing ************************************************************************/

    function removeCookies()
    {
        global $cookiePath;
        
//        $this->removeCookies();
        
        setcookie("globalUserId", '', -1, $cookiePath);
        setcookie("sessionUserId", '', -1, $cookiePath);
        setcookie("usrPassword", '', -1, $cookiePath);
    }

    function setCookies()
    {
        global $cookiePath;
        
  //      $this->setCookies();
        
        $_COOKIE["globalUserId"] = $_COOKIE["sessionUserId"] =$this->id;
        $_COOKIE["usrPassword"] = getPassword($this->password);
        setcookie("globalUserId", $this->id, Loginlib_ExpirationDate, $cookiePath);
        setcookie("sessionUserId", $this->id, 0, $cookiePath);
        setcookie("usrPassword", $_COOKIE["usrPassword"], Loginlib_ExpirationDate, $cookiePath);
    }
    /** END: Licensing ************************************************************************/


}


/**
* Licensing Class.
* 
* @author Andy Rockwell <andy@solidphp.com>
**/
class licensing
	{
	
	
	function store_serial($license)
	{
	   return executeQuery("UPDATE @settings set serial='$license'");
  }
	/**
	* Write the local license key to somewhere.
	* 
	* @param string $local_key		The local key data to write.
	* @return You choose.
	*/
	function store_local_key($local_key)
		{
	   return executeQuery("UPDATE @settings set license_local_key='{$local_key}'");
		}

	/**
	* Get the local key from where you stored it.
	* 
	* @return string The local license key.
	*/
	function get_stored_local_key()
		{
		$local_key=mysql_fetch_assoc(executeQuery("select `license_local_key` from @settings limit 0, 1"));
		return $local_key['license_local_key'];
		}

	/**
	* Write the best remote licensing method
	* 
	* @param string $method Either phpaudit_exec_socket, phpaudit_exec_curl or file_get_contents
	* @return You choose.
	*/
	function write_best_method($method)
		{
		return executeQuery("update @settings set `license_best_method`='{$method}'");
		}

	/**
	* Get the best remote licensing method previously saved
	* 
	* @return string The saved or default remote call method.
	*/
	function get_best_method()
		{
		$method=mysql_fetch_assoc(executeQuery("select `license_best_method` from @settings limit 0, 1"));

		if ($method['license_best_method'])
			{
			return $method['license_best_method'];
			}

		return 'phpaudit_exec_socket';
		}


	/**
	* Validate licensing
	* 
	* @param string $api_fingerprint
	* @param string $server 
	* @param string $RPC 
	* @param string $license 
	* @return mixed string on error; array on success
	*/
	function validate_license($api_fingerprint, $server, $RPC, $license)
		{ 
		$errors=false;
		// Check the local key first
		

	
		$returned=licensing::parse_xml(licensing::validate_local_key());
		// process the local key 
	
  	if ($returned['status']=='grab_new_key'||$returned['status']=='expired') 
			{
			// go remote to get licensing data
			$result=licensing::go_remote('phpaudit_exec_socket', $server, $license);
			$returned=licensing::parse_xml($result);
			// remote failed, set $returned to invalid
			if (empty($returned)) { $returned['status']="invalid"; }
		
			// we got a good response from the remote. We now need to grab a new
			// local license key and store it somewhere.

			if ($returned['status']=='active'||$returned['status']=='reissued') 
				{
				// grab a remote license key and write it to the correct place
				licensing::go_remote_api($RPC, $api_fingerprint, $license);
		
				$returned=licensing::parse_xml(licensing::validate_local_key(true)); // pr($returned);
				}
			}
			
		// Process the final status of the license after trying:
		// 
		// 1. local key first
		// 2. going remote for a new key
		// 3. getting a new key from the API
		// 
		// Just to note, #1 will happen every page refresh and #2/#3 will happen only 12 times a year.

		
		
		if ($returned['status']!='active'&&$returned['status']!='reissued') 
			{
			// failed, set $returned to invalid
			if (empty($returned)) { $returned['status']="invalid"; }
		
			if ($returned['status']=="suspended") 
				{
				$errors='This license has been suspended.'; 
				}
			else if ($returned['status']=="pending") 
				{ 
				$errors='This license is pending admin approval.'; 
				}
			else if ($returned['status']=="expired") 
				{ 
				$errors='This license is expired.'; 
				}
			else if ($returned['status']=='active'
				&&strcmp(md5('15cddbe83598b8713538086d2927814c'.$token), $returned['access_token'])!=0)
				{
				$errors='This license has an invalid checksum.'; 
				}
			else { $errors='This license appears to be invalid.'; }
			}
		
		// unset($server, $data, $parser, $values, $tags, $token);


		return ($errors)?$errors:$returned;
		}

	/**
	* Validate a local license key
	* 
	* @return boolean $debug
	* @return array The results of validation.
	*/
	function validate_local_key($debug=false)
		{
		// get the local key and parse it into an array
		$raw_array=licensing::parse_local_key();
		if (!@is_array($raw_array)||$raw_array===false)
			{
			return "<verify status='grab_new_key' message='The local license key was empty.' />";
			}
	
		if ($raw_array[9]&&@strcmp(@md5("15cddbe83598b8713538086d2927814c".$raw_array[9]), $raw_array[10])!=0)
			{
			return "<verify status='invalid' message='The custom variables were tampered with.' />";
			}
	
		if (@strcmp(@md5("15cddbe83598b8713538086d2927814c".$raw_array[1]), $raw_array[2])!=0)
			{
			return "<verify status='invalid' message='The local license key checksum failed.' ".$raw_array[9]." />";
			}
	
		if ($raw_array[1]<time()&&$raw_array[1]!="never")
			{
			return "<verify status='expired' message='Fetching a new local key.' ".$raw_array[9]." />";
			}
	
	/*
		$directory_array=@explode(",", $raw_array[3]);
		$valid_dir=licensing::path_translated();

		$valid_dir=@md5("15cddbe83598b8713538086d2927814c".$valid_dir);
		if (!@in_array($valid_dir, $directory_array))
			{
			return "<verify status='invalid' message='The file path did not match what was expected.' ".$raw_array[9]." />";
			}                                                                                  
	*/
		$host_array=@explode(",", $raw_array[4]);
		if (!@in_array(@md5("15cddbe83598b8713538086d2927814c".$_SERVER['HTTP_HOST']), $host_array))
			{
			return "<verify status='invalid' message='The hostname did not match what was expected.' ".$raw_array[9]." />";
			}
	
	/*
		$ip_array=@explode(",", $raw_array[5]);
		$server_addr=licensing::server_addr(); 
		
    		
		$ip_check=@in_array(@md5("15cddbe83598b8713538086d2927814c".$server_addr), $ip_array);

		if (!$ip_check)
			{
			$server_addr=substr($server_addr, 0, strrpos($server_addr, '.'));
			$ip_check=@in_array(@md5("15cddbe83598b8713538086d2927814c".$server_addr), $ip_array);
			}
	
		if (!$ip_check)
			{
			$server_addr=substr($server_addr, 0, strrpos($server_addr, '.'));
			$ip_check=@in_array(@md5("15cddbe83598b8713538086d2927814c".$server_addr), $ip_array);
			}
	
		if (!$ip_check)
			{
			return "<verify status='invalid_key' message='The IP address did not match what was expected.' ".$raw_array[9]." />";
			}
	*/
		return "<verify status='active' message='The license key is valid.' ".$raw_array[9]." />";
		}

	/**
	* Parse the XML
	* 
	* @return array The results the parsed XML.
	*/
	function parse_xml($data)
		{		
		$parser=@xml_parser_create('');
		@xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		@xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		@xml_parse_into_struct($parser, $data, $values, $tags);
		@xml_parser_free($parser);
		
		return @$values[0]['attributes'];
		}

	/**
	* Parse the XML
	* 
	* @return array The results the parsed XML.
	*/
	function get_key()
		{
		// get the local license key
		$data=licensing::get_stored_local_key();
		if (!$data) {  return false; }
	
		// parse out what we don't need
		$buffer=@str_replace("<", "", $data);
		$buffer=@str_replace(">", "", $buffer);
		$buffer=@str_replace("?PHP", "", $buffer);
		$buffer=@str_replace("?", "", $buffer);
		$buffer=@str_replace("/*--", "", $buffer);
		$buffer=@str_replace("--*/", "", $buffer);
	
		return @str_replace("\n", "", $buffer);
		}
	
	/**
	* Parse the cleaned local key string into an array
	* 
	* @return array The results the parsed local key.
	*/
	function parse_local_key()
		{
		$raw_data=@base64_decode(licensing::get_key()); 
		$raw_array=@explode("|", $raw_data);
		if (@is_array($raw_array)&&@count($raw_array)<8) {  return false; }
	
		return $raw_array;
		}
	
	/**
	* Make a token to be used with DNS Spoof Protection
	* 
	* @return array The token string.
	*/
	function make_token() { return md5('15cddbe83598b8713538086d2927814c'.time()); }
	
	/**
	* Go remote to validate the license using cURL
	* 
	* @param array $array The connection string.
	* @return array The XML results of the request.
	*/
	function phpaudit_exec_curl($array)
		{
		$array=@explode("?", $array);
	
		$link=curl_init();
		curl_setopt($link, CURLOPT_URL, $array[0]);
		curl_setopt($link, CURLOPT_POSTFIELDS, $array[1]);
		curl_setopt($link, CURLOPT_VERBOSE, 0);
		curl_setopt($link, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($link, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($link, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($link, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($link, CURLOPT_MAXREDIRS, 6);
		curl_setopt($link, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($link, CURLOPT_TIMEOUT, 15); // 60
		$results=curl_exec($link);
		if (curl_errno($link)>0)
			{
			curl_close($link);
			return false;
			}
		curl_close($link);
	
		if (@strpos($results, "verify")===false) { return false; }
	
		return $results;
		}
	
	/**
	* Go remote to validate the license using fsockopen()
	* 
	* @param string $http_host		ex. phpaudit.com
	* @param string $http_dir		ex. /admin
	* @param string $http_file		ex. /validate_internal.php
	* @param string $querystring	The licensing access data to pass in for validation.
	* @return array The XML results of the request.
	*/
	function phpaudit_exec_socket($http_host, $http_dir, $http_file, $querystring)
		{
		$fp=@fsockopen($http_host, 80, $errno, $errstr, 10); // was 5
		if (!$fp) { return false; }

		// build the headers to use
		$header="POST {$http_dir}{$http_file} HTTP/1.0\r\n";
		$header.="Host: {$http_host}\r\n";
		$header.="Content-type: application/x-www-form-urlencoded\r\n";
		$header.="User-Agent: SolidPHP Business Automation Software (SPBAS) (http://www.spbas.com)\r\n";
		$header.="Content-length: ".@strlen($querystring)."\r\n";
		$header.="Connection: close\r\n\r\n";
		$header.=$querystring;

		// handle the session
		$data=false;
		if (@function_exists('stream_set_timeout')) { stream_set_timeout($fp, 20); }
		@fputs($fp, $header);

		if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
		else { $status=true; }

		while (!@feof($fp)&&$status) 
			{
			$data.=@fgets($fp, 1024);

			if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
			else 
				{
				if (@feof($fp)==true) { $status=false; } 
				else { $status=true; }
				}
			}

		@fclose ($fp);

		// uncomment to debug the return
		//echo "<textarea rows='100' cols='100'>".$data."</textarea>"; die;

		// we had a bad header response
		if (!strpos($data, '200')) { return false; }
		
		// the response was empty, something went wrong
		if (!$data) { return false; }

		// separate the header from the validation XML
		$data=@explode("\r\n\r\n", $data, 2);

		// no validation XML was returned!
		if (!$data[1]) { return false; }

		// We have something returned, but it's not what is expected
		if (@strpos($data[1], 'verify')===false) { return false; }

		// return the XML validation string
		return $data[1];
		}
	
	/**
	* Get the directory path
	* 
	* @return string The directory path.
	*/
	function path_translated()
		{
		$option=array('PATH_TRANSLATED', 
					'ORIG_PATH_TRANSLATED', 
					'SCRIPT_FILENAME', 
					'DOCUMENT_ROOT',
					'APPL_PHYSICAL_PATH');

		foreach ($option as $key)
			{
			if (!isset($_SERVER[$key])||strlen(trim($_SERVER[$key]))<=0) { continue; }

			if (@substr(php_uname(), 0, 7)=='Windows')
				{
				return  @substr($_SERVER[$key], 0, @strrpos($_SERVER[$key], '\\'));
				}
			
			return  @substr($_SERVER[$key], 0, @strrpos($_SERVER[$key], '/'));
			}

		return false;
		// return 'no path could be determined.';
		}
	
	/**
	* Get the IP address
	* 
	* @return string The IP address.
	*/
	function server_addr()
		{
		$options=array('SERVER_ADDR', 'LOCAL_ADDR');
		foreach ($options as $key)
			{
			if (isset($_SERVER[$key])) { return $_SERVER[$key]; }
			}

		return false;
		// return 'no IP could be determined.';
		}

	/**
	* Make a remote call to the licensing server.
	* 
	* @param string $method	The licensing method to use.
	* @param string $server	The server URL to use
	* @param string $license	The license key to validate.
	* @return string The XML validation string.
	*/
	function go_remote($method, $server, $license)
		{
		$methods=array('phpaudit_exec_socket', 'phpaudit_exec_curl', 'file_get_contents');

		// if we have a previously stored license method, use that first
		if ($method)
			{
			unset($methods[$method]);
			$methods[]=$method;
			$methods=array_reverse($methods);
			}

		// build a querystring of the licensing data
		$enable_dns_spoof='yes';
		$query_string="license={$license}";
		$query_string.="&access_directory=".licensing::path_translated();
		$query_string.="&access_ip=".licensing::server_addr();
		$query_string.="&access_host={$_SERVER['HTTP_HOST']}";
		$query_string.='&access_token=';
		$query_string.=$token=licensing::make_token();

		// loop all licensing methods and break on the first that returns $data
		$data=false;
//		foreach(array('phpaudit_exec_socket', 'phpaudit_exec_curl', 'file_get_contents') as $license_method) 
		foreach($methods as $license_method)
			{
			// break the $server string into parts
			$sinfo=@parse_url($server);
	
			// try fsockopen()
			if ($license_method=='phpaudit_exec_socket'&&!$data)
				{
				$data=@licensing::phpaudit_exec_socket($sinfo['host'], $sinfo['path'], '/validate_internal.php', $query_string);
				//echo "socket:". $sinfo['host']."-".$sinfo['path']."-".$query_string;
				}
	
			// try cURL
			if ($license_method=='phpaudit_exec_curl'&&!$data)
				{
				 if(extension_loaded("curl")) {
         				$data=@licensing::phpaudit_exec_curl("{$server}/validate_internal.php?{$query_string}");
				 }
        //echo "curl: {$server}/validate_internal.php?{$query_string}";
				}
	
			// try using the fopen() wrappers
			if ($license_method=='file_get_contents'&&!$data)
				{
				$data=@file_get_contents("{$server}validate_internal.php?{$query_string}");
				//echo "get: {$server}/validate_internal.php?{$query_string}";
				}



			// we have data, break out of the loop
			if ($data) 
				{ 
				// write the method which was successful first
				licensing::write_best_method($license_method);
				break; 
				}
			}
		return $data; // the licensing data
		}

	/**
	* Make a remote call to the licensing server.
	* 
	* @param string $RPC				The URL to the admin rpc.php file.
	* @param string $api_fingerprint	The API fingerprint to use.
	* @param string $license			The license key to validate.
	* @return string The local key string.
	*/
	function go_remote_api($RPC, $api_fingerprint, $license)
		{
		$use=parse_url($RPC);
		$fp=@fsockopen($use['host'], 80, $errno, $errstr, 10); // was 5
		if (!$fp) { return false; }

		// build the headers to use
		$header="POST {$use['path']} HTTP/1.0\r\n";
		$header.="Host: {$use['host']}\r\n";
		$header.="Content-type: application/x-www-form-urlencoded\r\n";
		$header.="User-Agent: SolidPHP Business Automation Software (SPBAS) (http://www.spbas.com)\r\n";
		$header.="Content-length: ".@strlen($querystring="mod=license&task=get_local_key&api_key={$api_fingerprint}&license_key={$license}")."\r\n";
		$header.="Connection: close\r\n\r\n";
		$header.=$querystring;

		// handle the session
		$local_key='';
		if (@function_exists('stream_set_timeout')) { stream_set_timeout($fp, 20); }
		@fputs($fp, $header);

		if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
		else { $status=true; }

		while (!@feof($fp)&&$status) 
			{
			$local_key.=@fgets($fp, 1024);

			if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
			else 
				{
				if (@feof($fp)==true) { $status=false; } 
				else { $status=true; }
				}
			}

		@fclose ($fp);

		$local_key=@explode("\r\n\r\n", $local_key, 2);

		licensing::store_local_key($local_key[1]);
		    
		licensing::store_serial($license);

		return $local_key[1];
		}
	}


class oodlelicensing
{


# functions -------------------------------------------------------------------------

// added v2.0.10
function make_token() { return md5('15cddbe83598b8713538086d2927814c'.time()); }
// END added v2.0.10

function phpaudit_exec_socket($http_host, $http_dir, $http_file, $querystring)
    {
    $fp=@fsockopen($http_host, 80, $errno, $errstr, 10); // was 5
    if (!$fp) { return false; }
    else
        {
        $header="POST ".($http_dir.$http_file)." HTTP/1.0\r\n";
        $header.="Host: ".$http_host."\r\n";
        $header.="Content-type: application/x-www-form-urlencoded\r\n";
        $header.="User-Agent: PHPAudit v2 (http://www.phpaudit.com)\r\n";
        $header.="Content-length: ".@strlen($querystring)."\r\n";
        $header.="Connection: close\r\n\r\n";
        $header.=$querystring;

        $data=false;
        if (@function_exists('stream_set_timeout')) { @stream_set_timeout($fp, 20); }
        @fputs($fp, $header);

        if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
        else { $status=true; }

        while (!@feof($fp)&&$status) 
            {
            $data.=@fgets($fp, 1024);

            if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
            else 
                {
                if (@feof($fp)==true) { $status=false; } 
                else { $status=true; }
                }
            }

        @fclose ($fp);


        if (!strpos($data, '200')) { return false; }
        
        if (!$data) { return false; }

        $data=@explode("\r\n\r\n", $data, 2);

        if (!$data[1]) { return false; }
        if (@strpos($data[1], "verify")===false) { return false; }

        return $data[1];
        }
    }

# DOES NOT WORK FOR WINDOWS!!!!!!!
# No good way to get the mac address for win.
function phpaudit_get_mac_address()
    {
    $fp=@popen("/sbin/ifconfig", "r");

    if (!$fp) { return -1; } # returns invalid, cannot open ifconfig

    $res=@fread($fp, 4096);
    @pclose($fp);

    $array=@explode("HWaddr", $res);
    if (@count($array)<2) { $array=@explode("ether", $res); } # FreeBSD
    $array=@explode("\n", $array[1]);
    $buffer[]=@trim($array[0]);

    $array=@explode("inet addr:", $res);
    if (@count($array)<2) { $array=@explode("inet ", $res); } # FreeBSD
    $array=@explode(" ", $array[1]);
    $buffer[]=@trim($array[0]);

    return $buffer;
    }


function path_translated()
    {
    $option=array('PATH_TRANSLATED', 
                  'ORIG_PATH_TRANSLATED', 
                  'SCRIPT_FILENAME', 
                  'DOCUMENT_ROOT',
                  'APPL_PHYSICAL_PATH');

    foreach ($option as $key)
        {
        if (!isset($_SERVER[$key])||strlen(trim($_SERVER[$key]))<=0) { continue; }

        if (@substr(php_uname(), 0, 7)=='Windows'&&strpos($_SERVER[$key], '\\'))
            {
            return  @substr($_SERVER[$key], 0, @strrpos($_SERVER[$key], '\\'));
            }
        
        return  @substr($_SERVER[$key], 0, @strrpos($_SERVER[$key], '/'));
        }

    return false;
    // return 'no path could be determined.';
    }

function server_addr()
    {
    $options=array('SERVER_ADDR', 'LOCAL_ADDR');
    foreach ($options as $key)
        {
        if (isset($_SERVER[$key])) { return $_SERVER[$key]; }
        }

    return false;
    // return 'no IP could be determined.';
    }

# END functions ---------------------------------------------------------------------
function verifyOodle($license)
{
    // Check for 10 item version first
    $returned = oodlelicensing::CallToServer($license, 32, 36);
    //if ($returned['status']=="invalid")
        // Check for 50 item version 2nd
//        $returned = oodlelicensing::CallToServer($license, 34, 38);
    
  return $returned;  
}

function CallToServer($license, $product, $sku)
{    
    # This file is for the license server:
# Default Licensing Server [Server ID: 1] [created: Tue, 27 Apr 2010 20:31:06 -0500]


# The $license variable.
# Feel free to change it as you see needed.
//$license='';

$servers   = array();
$servers[] = 'http://noahsclassifieds.org/license_server'; // main server

# You can ignore everything below this line if you want to --------------------------

$query_string="license={$license}";
$query_string.="&product_id=40,1,36";
$query_string.="&sku_id=44,1,40"; //{$sku}"; //"36";

$per_server=false;
$per_install=true;
$per_site=false;

$enable_dns_spoof=yes;

    if ($per_server)
        {
        $server_array=oodlelicensing::phpaudit_get_mac_address();
        $query_string.="&access_host=".@gethostbyaddr(@gethostbyname($server_array[1]));
        $query_string.="&access_mac=".$server_array[0];
        }
    else if ($per_install)
        {
        $query_string.="&access_directory=".oodlelicensing::path_translated();
        $query_string.="&access_ip=".oodlelicensing::server_addr();
        $query_string.="&access_host=".$_SERVER['HTTP_HOST'];
        }
    else if ($per_site)
        {
        $query_string.="&access_ip=".oodlelicensing::server_addr();
        $query_string.="&access_host=".$_SERVER['HTTP_HOST'];
        }

    // added v2.0.10
    $query_string.='&access_token=';
    $query_string.=$token=oodlelicensing::make_token();
    // END added v2.0.10

    foreach($servers as $server) 
        {
        $sinfo=@parse_url($server);

        $data=oodlelicensing::phpaudit_exec_socket($sinfo['host'], $sinfo['path'], '/validate_internal.php', $query_string);
        if ($data) { break; }
        }

    $parser=@xml_parser_create('');
    @xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    @xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    @xml_parse_into_struct($parser, $data, $values, $tags);
    @xml_parser_free($parser);

    $returned=$values[0]['attributes'];
    $returned['addon_array']=@str_replace(" ", '+', @unserialize(@base64_decode($returned['addon_array'])));

    if (empty($returned)) { $returned['status']="invalid"; }
/*
    if (!$returned['status']) { die('Invalid license'); }

    if ($returned['status']=="invalid") { die('Invalid license'); }

    if ($returned['status']=="suspended") { die('Suspended license'); }

    if ($returned['status']=="expired") { die('Expired license'); }

    if ($returned['status']=="pending") { die('Pending license'); }

    if ($returned['status']=="invalid_key") { die('Invalid license key'); }
*/
    // added v2.0.10
    if ($returned['status']=='active'
        &&strcmp(md5('15cddbe83598b8713538086d2927814c'.$token), $returned['access_token'])!=0
        &&$enable_dns_spoof=='yes'
        &&!$skip_dns_spoof)
        {
        $returned['status']="invalid"; 
        }
    // END added v2.0.10

    unset($query_string, $per_server, $per_install, $per_site, $server, $data, $parser, $values, $tags, $sinfo, $token);
    
    return $returned;
}  
    
}    
?>
