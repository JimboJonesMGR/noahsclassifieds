<?php
defined('_NOAH') or die('Restricted access');

class CheckConf extends Object
{
var $installFiles = array("install.php", "installlib.php", "app/installlib.php", "uninstall.php", "autoinstall.php", "update.php", "update.lib.php", "u.php", "update-rss.php", "update-ecomm.php", "noah.ini.php");
var $appFiles = array("assignments.php","controller.php","init.php","search.php","cronjob.php","globalstat.php","item_detailspresentation.php","settings.php",
"category.php","customfield.php","item.php","staticpage.php","checkconf.php","include.php","subscription.php","user.php","config.php",                   
"include_view.php","response.php","tar.class.php","varfields.php","constants.php","error.php","rss.php","terms.txt","shoppingcart.php", "updatelib.php",
"advertisement.php", "globalsettings.php", "style.css", "template.php", "template1.php");
    
function show()
{
    global $gorumroll,$lll,$gorumuser, $dontRemoveInstallFiles, $CONFIG_FILE_DIR, $noahVersion;

    $_GS = new GlobalStat;
    hasAdminRights($isAdm);
    if (!$isAdm && !$gorumuser->isAdm && !$_GS->defPageConf) LocationHistory::rollBack(new AppController("/"));     
    
    JavaScript::addCss(CSS_DIR . "/checkconf.css?$noahVersion");
    if ($_GS->congrat) {
        View::assign("congrat", $lll["congrat"]);
        $_GS->congrat = FALSE;
        modify($_GS);
    }
    
    $report = array();
    $st=join("",file($CONFIG_FILE_DIR . "/config.php"));
    $p="^<\?";
    $cfe=FALSE;
    if (!ereg($p,$st)) 
    {
        $cfe=TRUE;
        $report[]=array($lll["confpreerr"], 'conferr');
    }
    $p="\?>$";
    $p1="\?>\n$";
    $p2="\?>\r\n$";
    if (!ereg($p,$st) && !ereg($p1,$st) && !ereg($p2,$st)) 
    {
        $cfe=TRUE;
        $report[]=array($lll["confposterr"], 'conferr');
    }
    if( $cfe ) $report[]=array($lll["conffileok"], 'confok');

    if( $gorumuser->password==getPassword("admin") ) 
    {
        $report[]=array($lll["chadmpass"], 'conferr');
    }
    $_S = new AppSettings;
    if( $_S->adminEmail=="" ) 
    {
        $report[]=array($lll["chsyspass"], 'conferr');
        $report[]=array($lll["chsyspass_expl"], 'confexpl');
    }
    else
    {
        $ctrl = new AppController("checkconf/mailtest");
        $report[]=array($ctrl->generAnchor($lll["triggerMailTest"]), 'confok');
    }

    if( !defined("IMG_GIF") || !function_exists("ImageTypes"))//nincs GD
    {
        $report[]=array($lll["nogd"], 'conferr');
        $report[]=array($lll["nogd_expl"], 'confexpl');
    }
    if ( !is_writeable(ini_get("session.save_path")) ) 
    {
        $error_message = "The configured Path for Session files (".ini_get("session.save_path").") is not writeable!";
    }
    
    $this->checkWritePermission( $noPermDirs );
    if( count($noPermDirs) )
    {
        $report[]=array(sprintf($lll["nopermission"], implode(", ", $noPermDirs)), 'conferr');
        $report[]=array($lll["nopermission_expl"], 'confexpl');
    }
    
    $this->checkReadPermission( $noPermDirs );
    if( count($noPermDirs) )
    {
        $report[]=array(sprintf($lll["nopermission_read"], implode(", ", $noPermDirs)), 'conferr');
        $report[]=array($lll["nopermission_read_expl"], 'confexpl');
    }
    
    // Nice URL section:
    View::assign("rewriteOn", $gorumroll->rewriteOn);
    if( !$gorumroll->rewriteOn )
    {
        if( function_exists("apache_get_modules") )
        {
            View::assign("rewriteModuleEnabled", in_array("mod_rewrite", apache_get_modules()));
        }
        else View::assign("rewriteModuleEnabled", "unsure" );
    }    
    
    
    // CAPTCHA test:
    $_S = new AppSettings();
    if ($_S->captchaType == "1")
    {
      ob_start();
      require(GORUM_DIR.'/recaptcha/rcaptcha.php');
      View::assign("captchaLink", ob_get_contents());
      ob_end_clean();
    } else  View::assign("captchaLink", "<img src='".Controller::getBaseURL()."gorum/captcha/captcha.php'>");

    if( (!empty($dontRemoveInstallFiles) || $this->installFilesRemoved()) &&
        $this->appFilesRemoved() && $this->backupFilesRemoved() && $_GS->defPageConf) 
    {
        $ctrl = new AppController("checkconf", "remove_first_check");
        View::assign("clickToDisappear", "$lll[confdisapp] ".$ctrl->generAnchor($lll["here1"]).".<br>$lll[confclicheck]" );
    }
    View::assign("report", $report);
}

function mailTest()
{
    global $gorumroll,$lll,$gorumuser, $noahVersion;
    
    $_GS = new GlobalStat;
    hasAdminRights($isAdm);
    if (!$isAdm && !$gorumuser->isAdm && !$_GS->defPageConf) LocationHistory::rollBack(new AppController("/"));     

    JavaScript::addCss(CSS_DIR . "/checkconf.css?$noahVersion");
    $_S = new AppSettings;
    // Mail teszt:
    Notification::gmail($errMsg, 
                        $_S->adminEmail, 
                        "Test mail",
                        "Test mail", 
                        $_S->adminFromName,TRUE,
                        $_S->adminEmail,$_S->adminEmail );
    if( $errMsg ) 
    {
        $report[]=array(sprintf($lll["mailerr"], $errMsg), 'conferr');
        //$report[]=array($lll["mailerr_expl"], 'confexpl');
    }
    else
    {
        $report[]=array(sprintf($lll["mailok"], $_S->adminEmail), 'confok');
    }            
    View::assign("checkTitle", $lll["checkMailtestTitle"]);
    View::assign("report", $report);
}

function installFilesRemoved()
{
    global $lll, $noahVersions;
    
    $found = FALSE;
    $unnecessaryAppFiles = array();
    foreach( $this->installFiles as $f )
    {
        if( file_exists($f) ) $unnecessaryAppFiles[] = $f;
    }
    foreach( $noahVersions as $v )
    {
        if( file_exists("updateinfo-$v.php") ) $unnecessaryAppFiles[] = "updateinfo-$v.php";
    }
    if( $found = count($unnecessaryAppFiles) )
    {
        $ctrl = new AppController("checkconf/inst_file_remove");
        View::assign("instFileRemove", sprintf($lll["instFileRemove"], 
                                               implode(", ", $unnecessaryAppFiles), 
                                               $ctrl->makeUrl()));
    }
    return !$found;
}

function appFilesRemoved()
{
    global $lll, $noahVersions;
    
    $found = FALSE;
    $unnecessaryAppFiles = array();
    foreach( $this->appFiles as $f )
    {
        if( file_exists($f) ) $unnecessaryAppFiles[] = $f;
    }
    if( $found = count($unnecessaryAppFiles) )
    {
        $ctrl = new AppController("checkconf/app_file_remove");
        View::assign("appFileRemove", sprintf($lll["appFileRemove"], 
                                               implode(", ", $unnecessaryAppFiles), 
                                               $ctrl->makeUrl()));
        View::assign("appFileRemoveExpl", $lll["appFileRemoveExpl"]);
    }
    return !$found;
}

function backupFilesRemoved()
{
    global $lll, $noahVersions;
    
    $found = FALSE;
    $unnecessaryBackupDirs = array();
    foreach( $noahVersions as $v )
    {
        if( file_exists("backup-$v") ) $unnecessaryBackupDirs[] = "backup-$v";
    }
    if( $found = count($unnecessaryBackupDirs) )
    {
        $ctrl = new AppController("checkconf/backup_file_remove");
        View::assign("backupFileRemove", sprintf($lll["backupFileRemove"], 
                                               implode(", ", $unnecessaryBackupDirs), 
                                               $ctrl->makeUrl()));
        View::assign("backupFileRemoveExpl", $lll["backupFileRemoveExpl"]);
    }
    return !$found;
}

function checkWritePermission( &$noPermDirs )
{
    $noPermDirs = array();
    foreach( array(AD_PIC_DIR, USER_PIC_DIR, CAT_PIC_DIR, UPLOAD_DIR, USER_UPLOAD_DIR, LOG_DIR, FEED_DIR) as $dir )
    {
        $fName = "$dir/dummy";
        if( !($f = @fopen($fName,"w")) ) $noPermDirs[]=$dir;
        @fclose( $f );
        @unlink( $fName );
    }
}

function checkReadPermission( &$noPermDirs )
{
    $noPermDirs = array();
    foreach( array(LANG_DIR, THEMES_DIR, GORUM_DIR."/captcha/fonts") as $dir )
    {
        if( !($d = opendir($dir)) ) $noPermDirs[]=$dir;
        else closedir($d);
    }
    $themesDid = opendir(THEMES_DIR);
    while( ($dir = readdir($themesDid)) !== false) 
    {
        if( (preg_match("/^\./", $dir) || $dir=="common_templates" || !is_dir(THEMES_DIR . "/$dir")) ) continue;
        $cssDir = THEMES_DIR."/$dir/css";
        if( !($d = opendir($cssDir)) ) $noPermDirs[]=$cssDir;
        else closedir($d);        
    }
    $dir = ECOMM_DIR."/gateways";
    if( file_exists($dir) )
    {
        if( !($d = opendir($dir)) ) $noPermDirs[]=$dir;
        else closedir($d);
    }
}

function removeInstFiles()
{
    global $dontRemoveInstallFiles, $noahVersions;
    
    if( !empty($dontRemoveInstallFiles) ) return;
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    foreach( $this->installFiles as $f )
    {
        if( file_exists($f) ) @unlink($f);
    }
    foreach( $noahVersions as $v )
    {
        if( file_exists("updateinfo-$v.php") ) @unlink("updateinfo-$v.php");
    }
    $this->rollBackNum = 1;    
}

function removeAppFiles()
{
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    foreach( $this->appFiles as $f )
    {
        if( file_exists($f) ) @unlink($f);
    }
    $this->rollBackNum = 1;    
}

function removeBackupFiles()
{
    global $noahVersions;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    foreach( $noahVersions as $v )
    {
        if( file_exists("backup-$v") ) $this->removeRecursively("backup-$v");
    }
    $this->rollBackNum = 1;    
}

function removeRecursively($dirOrFile)
{
    if( is_dir($dirOrFile) )
    {
        $dir = opendir($dirOrFile);
        while( ($file = readdir($dir)) !== false) 
        {
            if( !preg_match("/^\./", $file) ) $this->removeRecursively("$dirOrFile/$file");
        }
        @rmdir($dirOrFile);
    }
    else @unlink($dirOrFile);
}

function removeFirstCheck()
{
    $_GS = new GlobalStat;
    $_GS->defPageConf=FALSE;
    modify($_GS);
    $this->nextAction = new AppController("/");
}

function updates()
{
    global $gorumroll,$lll,$gorumuser, $noahsVersionCheckScript, $noahsHost, $noahVersion;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    JavaScript::addCss(CSS_DIR . "/checkconf.css?$noahVersion");
   
   
   	$target_url = "http://noahsclassifeds.com/update.html";
 		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL,$target_url);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$html = curl_exec($ch);
         
echo "{$html}";
    
}

function getVersionInfo($host, $method, $path, $data)
{
    ob_start();
    if( ($fp = @fsockopen($host, 80, $errno, $errstr, 20))===FALSE || $errno )
    {
        while (@ob_end_clean());  // clears all output buffers
        return FALSE; // unable to connect
    }
    if ($method == 'GET') {
        $path .= '?' . $data;
    }
    fputs($fp, "$method $path HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp,"Content-type: application/x-www-form-urlencoded\r\n");
    fputs($fp, "Content-length: " . strlen($data) . "\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    if ($method == 'POST') fputs($fp, $data);

    $buf="";
    while (!feof($fp) && strlen($buf)<20000) $buf .= fgets($fp,128);
    fclose($fp);
    while (@ob_end_clean());  // clears all output buffers
    return $buf;
}

function register()
{
    global $gorumroll,$lll,$gorumuser, $noahVersion;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    JavaScript::addCss(CSS_DIR . "/checkconf.css?$noahVersion");
    View::assign("report", array());
    $_GS = new GlobalStat;
    if( $_GS->registered ) 
    {
        View::assign("checkTitle", $lll["noahAlreadyRegistered"]);
        View::assign("company", $_GS->company);
        View::assign("firstName", $_GS->firstName);
        View::assign("lastName", $_GS->lastName);
        View::assign("email", $_GS->email);
        return;
    }
    if( !$_GS->reg ) 
    {
        $_GS->reg = md5(uniqid(rand(), true));
        modify($_GS);
    }
    View::assign("checkTitle", $lll["registerNoahTitle"]);
}

function doRegister()
{
    global $gorumroll,$lll,$gorumuser, $noahsRegisterScript, $noahsHost, $noahVersion;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    JavaScript::addCss(CSS_DIR . "/checkconf.css?$noahVersion");
    $_GS = new GlobalStat;
    if( !$_GS->reg ) 
    {
        $_GS->reg = md5(uniqid(rand(), true));
    }
    $_GS->company = $_POST["company"];
    $_GS->firstName = $_POST["firstName"];
    $_GS->lastName = $_POST["lastName"];
    $_GS->email = $_POST["email"];
    $data = $this->getTransferData($_GS, TRUE);
    if( ($result = $this->getVersionInfo($noahsHost, "POST", $noahsRegisterScript, $data))===FALSE )
    {
        View::assign("checkTitle", $lll["unableToConnectNoah"]);       
    }
    else
    {
        if( strstr( $result, "Registration:OK" ) ) 
        {
            View::assign("checkTitle", $lll["noahRegistrationSuccessfull"]);
            $_GS->registered = TRUE;
        }
        else View::assign("checkTitle", $lll["noahRegistrationFalseResponse"]);
    }
    modify($_GS);
    View::assign("report", array());
}

function getTransferData( &$_GS, $withReg = FALSE )
{
    global $_GP, $_GA, $_GE; 
    
    $_S = new AppSettings();
    loadSQL($user=new User, "SELECT email FROM @user WHERE isAdm=1 LIMIT 1");
    $data = "id=".$_GS->reg;
    $data .= "&ip=".urlencode($_SERVER["REMOTE_ADDR"]);
    $data .= "&name=".urlencode(Controller::getBaseUrl());
    $data .= "&php=".urlencode(phpversion());
    $data .= "&mysql=".urlencode(mysql_get_server_info());
    $data .= "&version=".urlencode($_GS->instver);
    $data .= "&date=".urlencode($_GS->creationtime->getDbFormat());
    $data .= "&lastUpdate=".urlencode($_GS->lastUpdate->getDbFormat());
    $data .= "&systemEmail=".urlencode($_S->adminEmail);
    $data .= "&adminEmail=".urlencode($user->email);
    if( !empty($_GE) ) $data .= "&orderEmail=".urlencode($_GE);
    if( !empty($_GP) ) $data .= "&orderCode=".urlencode($_GP);
    if( !empty($_GA) ) $data .= "&affiliateId=".urlencode($_GA);
    $branch = $this->getBranch();
    $data .= "&branch=$branch";
    getDbCount($count, "SELECT COUNT(*) FROM @item");
    $data .= "&itemNum=$count";
    getDbCount($count, "SELECT COUNT(*) FROM @category");
    $data .= "&catNum=$count";
    $data .= "&webServer=".(!empty ($_SERVER['REQUEST_URI']) ? 'Apache' : 'IIS');
    $data .= "&theme=".urlencode($_S->defaultTheme);
    $data .= "&lang=".urlencode($_S->defaultLanguage);
    $data .= "&allowSelectTheme=".$_S->allowSelectTheme;
    $data .= "&enablePermalinks=".$_S->enablePermalinks;
    $data .= "&cascadingCategorySelect=".$_S->cascadingCategorySelect;
    $data .= "&ecommerceEnabled=".$_S->ecommerceEnabled;
    $data .= "&enableCombine=".$_S->enableCombine;
    $data .= "&mainTitle=".urlencode($_S->mainTitle);
    $data .= "&mainDescription=".urlencode($_S->mainDescription);
    $data .= "&mainKeywords=".urlencode($_S->mainKeywords);
    if( $_S->ecommerceEnabled==Settings_ecommEnabled )
    {
        $_ES = new ECommSettings();
        $data .= "&model=".$_ES->model;
        $data .= "&paypal_enabled=".$_ES->paypal_enabled;
        $data .= "&authorize_net_enabled=".$_ES->authorize_net_enabled;
        $data .= "&paypal_integrationMethod=".$_ES->paypal_integrationMethod;
        $data .= "&authorize_net_integrationMethod=".$_ES->authorize_net_integrationMethod;
        $gateways = array();
        foreach( GateWay::getGateways() as $gateway )
        {
            if( $gateway!='paypal' && $gateway!='authorize_net' ) $gateways[]=$gateway;
        }
        $data .= "&extraGateways=".urlencode(implode(", ", $gateways));
    }
    if( $withReg )
    {
        $data .= "&company=".urlencode($_POST["company"]);
        $data .= "&firstName=".urlencode($_POST["firstName"]);
        $data .= "&lastName=".urlencode($_POST["lastName"]);
        $data .= "&email=".urlencode($_POST["email"]);
    }
    return $data;
}

function getBranch()
{    
    if( class_exists("ecommfull") ) return "EComm";
    elseif( class_exists("rss") ) return "RSS";
    else return "Lite";
}

function doUpdate()
{

                                    
/*
    global $gorumroll,$gorumuser, $noahsUpdateScript, $noahsHost;
    
    ini_set("max_execution_time", 0);
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    $_GS = new GlobalStat;
    if( !$_GS->reg ) 
    {
        $_GS->reg = md5(uniqid(rand(), true));
    }
    $data = "id=".$_GS->reg;
    $data .= "&version=".urlencode($_GS->instver);
    if( isset($_POST["automatic"]) )
    {
        if( ($result = $this->getVersionInfo($noahsHost, "POST", $noahsUpdateScript, $data))===FALSE )
        {
            Roll::setInfoText("unableToConnectNoah");       
        }
        else
        {
            $result = explode("Data-Start:", $result);
            eval($result[1]);
            if( $latestVersion!=$_GS->instver )
            {
                $f = fopen("u.php", "w");
                if( !$f )
                {
                    Roll::setInfoText("updateFailed");
                }
                else
                {
                    fwrite($f, $updateFile);
                    fclose($f);
                    include_once(NOAH_BASE . "/u.php");
                }
            }
        }
        $this->nextAction = new AppController("checkconf/updates");
    }
    else
    {
        ob_start();
        if( ($fp = @fsockopen($noahsHost, 80, $errno, $errstr, 20))===FALSE || $errno )
        {
            Roll::setInfoText("unableToConnectNoah");       
            $this->nextAction = new AppController("checkconf/updates");
            while (@ob_end_clean());  // clears all output buffers
            return; // unable to connect
        }
        $branch = $this->getBranch();
        $source = "update-from-$_GS->instver-$branch.".(isset($_POST["manualZip"]) ? "zip" : "tgz");
        $path = "/versioninfo/get_file.php";
        $data .= "&file=".urlencode($source);
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $noahsHost\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: " . strlen($data) . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);
        if( feof($fp) || ($size = $this->getChunkSize($fp))<=3 ) 
        {
            Roll::setInfoText("downloadFileNotExists", $source);
            $this->nextAction = new AppController("checkconf/updates");
            while (@ob_end_clean());  // clears all output buffers
            return FALSE;  // not exists
        }
        while (@ob_end_clean());  // clears all output buffers
        //filenames in IE containing dots will screw up the
        //filename unless we add this
        if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
           $source = preg_replace('/\./', '%2e', $source, substr_count($source, '.') - 1);
           
        // required for IE, otherwise Content-disposition is ignored
        if(ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');
        
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Description: File Download");
        header("Content-type: application/download");
        header("Content-Disposition: attachment; filename=\"$source\"");
        header("Content-Transfer-Encoding: binary"); 
        header("Content-Length: $size");
        while( $size>0 && !feof($fp) )
        {
            $length = min(1024, $size);
            if( $buf = fgets($fp,$length) ) echo $buf;
            else break;
            flush();
            $size-=strlen($buf);
        }
        fclose($fp);
        die();
    }
*/
}

function getChunkSize($fp)
{
    // get header
    $header="";
    do $header.=fread($fp,1); while (!preg_match('/\\r\\n\\r\\n$/',$header));
    // check for chunked encoding
    if (preg_match('/Transfer\\-Encoding:\\s+chunked\\r\\n/',$header))
    {
        $byte = "";
        $chunk_size="";
        do {
            $chunk_size.=$byte;
            $byte=fread($fp,1);
        } while (ord($byte)!=13);      // till we match the CR
        fread($fp, 1);         // also drop off the LF
        fread($fp, 3);         // also drop off one more empty line
        $chunk_size=hexdec($chunk_size); // convert to real number
        return $chunk_size;
    }
    else
    {
        fread($fp, 3); // also drop off one more empty line
        // check for specified content length
        if (preg_match('/Content\\-Length:\\s+([0-9]*)\\r\\n/',$header,$matches)) return $matches[1];
         // not a nice way to do it (may also result in extra CRLF which trails the real content???)
        return 1000000000; //return just a big enough number
    }
}

function bytesFromSizeString($data) {
	preg_match("/(\d+)(M|K)?/", $data, $matches);
	if ( !isset($matches[2]) ) $matches[2] = "B";
	$multiplier = 1;
	switch (strtolower($matches[2])) {
		case "m": $multiplier *= 1024;
		case "k": $multiplier *= 1024;
	}
	return (int)$matches[1] * $multiplier;
}

function fetchMaxUploadSize() {
	if ( (boolean) ini_get("file_uploads") ) {
		$umf = bytesFromSizeString(ini_get("upload_max_filesize"));
		$pms = bytesFromSizeString(ini_get("post_max_size"));
		return $umf > $pms ? $umf : $pms;
	} else return 0;
}
}

?>
