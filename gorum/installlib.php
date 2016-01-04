<?php
defined('_NOAH') or die('Restricted access');
$configFileName="config.php";
include_once(GORUM_DIR . '/filter.php');
    
$_GET = filterInput($_GET);
$_COOKIE = filterInput($_COOKIE);
$_SERVER = filterInput($_SERVER);
$_FILES = filterInput($_FILES);
$_POST = filterInput($_POST);

if (isset($_POST["hostName"])) {
    $hostName=$_POST["hostName"];
}
if (isset($_POST["dbUser"])) {
    $dbUser=$_POST["dbUser"];
}
if (isset($_POST["dbUserPw"])) {
    $dbUserPw=$_POST["dbUserPw"];
}
if (isset($_POST["dbPort"])) {
    $dbPort=$_POST["dbPort"];
}
if (isset($_POST["dbSocket"])) {
    $dbSocket=$_POST["dbSocket"];
}
if (isset($_POST["dbName"])) {
    $dbName=$_POST["dbName"];
}
if (isset($_POST["dbPrefix"])) {
    $dbPrefix=$_POST["dbPrefix"];
}

if (!isset($hostName)) $hostName="localhost";
if (!isset($dbUser)) $dbUser="root";
if (!isset($dbUserPw)) $dbUserPw="";
if (!isset($dbPrefix)) $dbPrefix="";
if (!isset($dbPort)) $dbPort="";
if (!isset($dbSocket)) $dbSocket="";
if (!isset($dbName)) $dbName="classifieds";

function installMain(&$s)
{
    global $lll;
    global $hostName,$dbUser,$dbUserPw,$dbName,$dbPort,$dbSocket;
    global $scriptName;
    global $cookiePath;
    global $phpVersionMin, $mySqlVersionMin;

    $s="";
    showInstallHeader($s1);
    $s.=$s1;
    // Ezt azert kommentezem ki, mert gyakran ujrainstallalok ugy hogy elozoleg
    // john-kent be voltam jelentkezve. Ilyen esetben mindig john
    // id-jevel hozta letre eloszor az admint, majd amikor john
    // letrehozasara kerult a sor, akkor hibat adott az install mondvan,
    // hogy ilyen id-ju juzer mar letezik:
    //if (!isset($_COOKIE["globalUserId"]))
    //{
        mt_srand((double)microtime()*1000000);
        global $randIdMax,$randIdMin;
        if (!isset($randIdMin)) $randIdMin=0;
        if (!isset($randIdMax)) $randIdMax=getrandmax();
        $randomId = (int)mt_rand($randIdMin,$randIdMax);
        setcookie("globalUserId", $randomId,Loginlib_ExpirationDate,
                  $cookiePath);
        $_COOKIE["globalUserId"] = $randomId;
    //}
    if (isset($_POST["edit"])) {
        $s.=showEditForm(TRUE);
        return;
    }

    //if( isset($_POST["submit"]) &&
    //    $_POST["submit"]==$lll["install"] )
    //{


    //check file creation
    $ret=checkFileCreate();
    if ($ret==ok) {
        iPrint($lll["create_file_ok"],"ok",$sp);
        $s.=$sp;
        $createconf=TRUE;
    }
    else {
        if (!isset($_POST["confirm"])) {
            iPrint($lll["create_file_nok_ext"],"warn",$sp);
        }
        else iPrint($lll["create_file_nok"],"warn",$sp);
        $s.=$sp;
        $createconf=FALSE;
    }

    //check mysql connection
    $db->hostName=$hostName;
    $db->user=$dbUser;
    $db->password=$dbUserPw;
    $db->port=$dbPort;
    $db->socket=$dbSocket;

    $connectRet=checkMysql($db,$s1);
    $s.=$s1;
    if ($connectRet==ok) {
        iPrint($lll["mysql_found"],"ok",$sp);
        $s.=$sp;
        $connectok=TRUE;
        $pwok=TRUE;
    }
    elseif ($connectRet==mysql_access_denied) {
        iPrint($lll["mysql_found"],"ok",$sp);
        $s.=$sp;
        if ($dbUserPw=="") {
            iPrint(sprintf($lll["need_pw"],$dbUser),
                   "warn",$sp);
            $s.=$sp;
            $s.=showEditForm(TRUE);
            return ok;
        }
        else {
            iPrint(sprintf($lll["incorr_pw"],$dbUser),
                   "warn",$sp);
            $s.=$sp;
            $s.=showEditForm(TRUE);
            return ok;
        }
    }
    else {
        iPrint($lll["mysql_not_found"]." (".mysql_error().")","warn",$sp);
        $s.=$sp;
        $s.=showEditForm(TRUE);
        return ok;
    }
    if( !DbInstall::checkComponentVersions( $mySqlVersion, $phpVersion ) )
    {
        iPrint(sprintf($lll["versionTooLow"], $mySqlVersionMin, $mySqlVersion, $phpVersionMin, $phpVersion),"err",$sp);
        $s.=$sp;
        return ok;
    }
    if (!isset($_POST["confirm"])) {
        $s.=showAskConfirm();
        return ok;
    }

    if (isset($_COOKIE["globalUserId"])) {
        iPrint($lll["cookieok"],"ok",$sp);
        $s.=$sp;
    }
    else {
        iPrint($lll["cookienok"],"err",$sp);
        $s.=$sp;
        return;
    }

    //check if db exists
    $ret=mysql_select_db($dbName);
    if ($ret) {
        iPrint(sprintf($lll["db_installed"], $dbName),"ok",$sp);
        $s.=$sp;
    }
    else {
        $ret=createDb();
        if ($ret!=ok) {
            $s1=sprintf($lll["cantcreatedb"],$dbUser);
            iPrint($s1,"warn",$sp);
            $s.=$sp;
            return ok;
        }
        else {
            iPrint(sprintf($lll["db_created"],$dbName),
                   "ok",$sp);
            $s.=$sp;
            //select db
            $ret=mysql_select_db($dbName);
        }
    }
    $ret=DbInstall::installCreateTables();
    if ($ret!=ok) {
        iPrint($lll["inst_create_table_err"],"err",$sp);
        $s.=$sp;
        return $ret;
    }
    else {
        iPrint($lll["tables_installed"],"ok",$sp);
        $s.=$sp;
    }

    createFirstAdmin();
    appFillTables();
    iPrint($lll["tables_filled"],"ok",$sp);
    $s.=$sp;

    if ($createconf) {//config file can be generated
        $ret=writeConfigFile($s1);
        if ($ret!=ok) {
            $s.=$s1;
            return;
        }
    }
    else {//config can't be created
        iPrint($lll["compare_conf"],"warn",$sp);
        $s.=$sp;
        showConfFileHtml($s1);
        $s.=$s1;
        iPrint($lll["afterwrconf"],"warn",$s1);
        $s.=$s1;
    }
    iPrint($lll["move_inst_file"],"warn",$s1);
    $s.=$s1;
    iPrint(sprintf($lll["congrat"], "Noah's Classifieds"),"hurra",$s1);
    $s.=$s1;
    iPrint($lll["inst_ch_pw"],"warn",$s1);
    $s.=$s1;


    //send him to the application:
    $s.="<a href='$scriptName'>".sprintf($lll["inst_click"],
                                         "Noah's Classifieds")."</a>";
    return ok;
}

function checkMysql($db,&$s)
{
    $db->host=$db->hostName;
    if ($db->port!="") $db->host.=":".$db->port;
    if ($db->socket!="") $db->host.=":".$db->socket;
    ob_start();
    $link = mysql_connect($db->host,$db->user,$db->password );
    $errMsg = ob_get_contents();
    @ob_end_clean();
    $s="";
    if (strstr($errMsg,"Unknown MySQL Server Host")) {
        return mysql_host_error;
    }
    if (strstr($errMsg,"Access denied")) {
        return mysql_access_denied;
    }
    if (strstr($errMsg,"Can't connect")) {
        return mysql_connect_error;
    }
    if( !$link ) {
        return mysql_connect_error;
    }
    return ok;
}

function createDb()
{
    global $dbName;

    $query="CREATE DATABASE $dbName DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    $result=mysql_query($query);
    if ($result==0) {
        return nok;
    }
    else {
        return ok;
    }
}

function showInstallHeader(&$s)
{
    global $lll;
    $s="";
    $s.="<HEAD>\n";
    $s.="<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" >\n";
    $s.="<STYLE TYPE='text/css'>\n";
    $s.="body {text-align:center;}\n";
    $s.="h1 {color:#669999;}\n";
    $s.="table.edit {color:darkblue;background-color:lightblue;}\n";
    $s.="td.edit {color:darkblue;}\n";
    $s.=".err {color:red; }\n";
    $s.=".ok {color:green; }\n";
    $s.=".warn {color:#ff6600; }\n";
    $s.=".hurra {color:darkblue; }\n";
    $s.=".msg {color:#669999; }\n";
    $s.="-->\n";
    $s.="</STYLE>\n";
    $s.="
    <script type='text/javascript'>
    <!--
        function checkAccept()
        {
            var val = document.getElementById('accept').checked;
            if( val==0 )
            {
                alert('".$lll["youMustAcceptTerms"]."');
                return false;
            }
            return true;
        }
    -->
    </script>\n";
    $s.="</HEAD>\n";
    $s.="<BODY BGCOLOR='ffffff'>\n";
    $s.='<script src="https://cdn.rawgit.com/jaredreich/notie.js/master/notie.js"></script>
        <script type="text/javascript">
        notie.confirm("Noahs Classifieds is not under development anymore. Please use <a href=\'http://open-classifieds.com\'>Open Classifieds</a> instead.", "Yes, I want the best", "No, I like bugs", 
            function() {
                window.location = "http://open-classifieds.com";
            });
        </script>';
}

function iPrint($txt,$style,&$s)
{
    $s="";
    $s.="<b>";
    $s.="<span class='$style'>";
    $s.=$txt;
    $s.="</span>";
    $s.="</b>\n<br>";
}

function uninstallMain(&$s)
{
    global $dbName,$dbUser,$dbUserPw, $dbHost;


    $s="";
    if (!isset($dbName)) {
        iPrint($s1,"err",$sp);
        $s.=$sp;
        $txt="dbName not set";
        handleErr($txt,__FILE__,__LINE__);
    }
    showInstallHeader($s1);
    $s.=$s1;
    $s.="<h1>Uninstall</h1>";
    connectDb($dbHost, $dbUser, $dbUserPw, $dbName);
    $query="DROP DATABASE $dbName";
    $result=executeQuery($query);
    iPrint("Db dropped","ok",$sp);
    $s.=$sp;
    iPrint("Uninstall successful","hurra",$sp);
    $s.=$sp;
    return ok;
}
function checkFileCreate()
{
    global $configFileName;

    $fN=NOAH_APP . "/$configFileName";
    $content=@file($fN);
    $f=@fopen($fN,"w");
    if ($f) {
        if (is_array($content)) {
            foreach($content as $row) fwrite($f,$row);
        }
        return ok;
    }
    else {
        return nok;
    }
}
function generHiddens()
{
    global $hostName,$dbUser,$dbUserPw,$dbName,$dbPort,$dbSocket, $dbPrefix;
    $s="";
    $s.="<input type='hidden' name='dbUser'".
        " value='$dbUser'>\n";
    $s.="<input type='hidden' name='dbUserPw'".
        " value='$dbUserPw'>\n";
    $s.="<input type='hidden' name='dbName'".
        " value='$dbName'>\n";
    $s.="<input type='hidden' name='hostName'".
        " value='$hostName'>\n";
    $s.="<input type='hidden' name='dbSocket'".
        " value='$dbSocket'>\n";
    $s.="<input type='hidden' name='dbPort'".
        " value='$dbPort'>\n";
    $s.="<input type='hidden' name='dbPrefix'".
        " value='$dbPrefix'>\n";
    return $s;
}
function showAskConfirm()
{
    global $lll;
    global $hostName,$dbUser,$dbUserPw,$dbName,$dbPort,$dbSocket, $dbPrefix;
    global $scriptName;

    $s="";
    iPrint($lll["inst_params"],"ok",$s1);
    $s.=$s1;
    $s.="<table border='1'>";
    $s.="<table border='0'><tr><td>";
    $s.="<pre><strong>";
    $s.=$lll["mysqluser"].":$dbUser<BR>";
    $s.=$lll["dbHostName"].":$hostName<BR>";
    $s.=$lll["dbDbName"].":$dbName<BR>";
    $s.=$lll["dbPrefix"].":$dbPrefix<BR>";
    if ($dbSocket!="") {
        $s.=$lll["dbSocket"].":$dbSocket<BR>";
    }
    if ($dbPort!="") {
        $s.=$lll["dbPort"].":$dbPort<BR>";
    }
    $s.="</strong></pre>";
    $s.="</td></tr></table>\n";
    $s.="<form method='POST' action='install.php' onsubmit='return checkAccept();'>\n";
    $s.=generHiddens();
    iPrint($lll["acceptTerms"],"ok",$s1);
    $s.="$s1<br>";
    $s.="<input type='submit' name='edit' value='".
        $lll["edit_params"]."'>";
    $s.="<br><br>\n";
    $s.="<input type='submit' name='confirm' value='".
        $lll["install"]."'>";
    $s.="</form><br>\n";
    $s.="<textarea rows=30 cols=100>\n".join('', file(NOAH_APP.'/terms.txt'))."</textarea>\n";
    return $s;
}
function showEditForm($all=FALSE)
{
    global $hostName,$dbUser,$dbUserPw,$dbName,$dbPort,$dbSocket, $dbPrefix;
    global $lll;

    $s="";
    $length=30;
    $s.="<center>\n";
    $s.="<table border='0' class='edit' cellpadding='4' cellspacing='1' width='400'>\n";
    $s.="<form method='POST' action='install.php'>\n";
    $s.="<tr class='edit'>\n";
    $s.="<th class='edit' colspan='2'>".$lll["formtitle"]."</th>";
    $s.="</tr>\n";
    $s.="<tr class='edit'>\n";
    $s.="<td class='edit'>".$lll["mysqluser"]."</td>\n";
    $s.="<td class='edit'>";
    $s.="<input type='text' length='$length' name='dbUser'".
         " value='$dbUser'>";
    $s.="</td>\n";
    $s.="</tr>\n";
    $s.="<tr class='edit'>\n";
    $s.="<td class='edit'>".$lll["password"]."</td>\n";
    $s.="<td class='edit'>";
    $s.="<input type='password' length='$length' name='dbUserPw'".
         " value='$dbUserPw'>";
    $s.="</td>\n";
    $s.="</tr>\n";
    if ($all) {
        $s.="<tr class='edit'>\n";
        $s.="<td class='edit'>".$lll["dbName"]."</td>\n";
        $s.="<td class='edit'>";
        $s.="<input type='text' length='$length' name='dbName'".
             " value='$dbName'>";
        $s.="</td>\n";
        $s.="</tr>\n";
        $s.="<tr class='edit'>\n";
        $s.="<td class='edit'>".$lll["hostName"]."</td>\n";
        $s.="<td class='edit'>";
        $s.="<input type='text' length='$length' name='hostName'".
             " value='$hostName'>";
        $s.="</td>\n";
        $s.="</tr>\n";
        $s.="<tr class='edit'>\n";
        $s.="<td class='edit'>".$lll["dbPort"]."</td>\n";
        $s.="<td class='edit'>";
        $s.="<input type='text' length='$length' name='dbPort'".
             " value='$dbPort'>";
        $s.="</td>\n";
        $s.="<tr class='edit'>\n";
        $s.="<td class='edit'>".$lll["dbSocket"]."</td>\n";
        $s.="<td class='edit'>";
        $s.="<input type='text' length='$length' name='dbSocket'".
             " value='$dbSocket'>";
        $s.="</td>\n";
        $s.="</tr>\n";
        $s.="<tr class='edit'><td colspan='2' style='font-size:smaller; white-space: wrap;text-align: justify;'>$lll[dbPrefixExplanation]</td></tr>\n";
        $s.="<tr class='edit'>\n";
        $s.="<td class='edit'>".$lll["dbPrefix"]."</td>\n";
        $s.="<td class='edit'>";
        $s.="<input type='text' length='$length' name='dbPrefix'".
             " value='$dbPrefix'>";
        $s.="</td>\n";
        $s.="</tr>\n";
    }
    else {
        $s.="<input type='hidden' name='dbName'".
             " value='$dbName'>";
        $s.="<input type='hidden' name='hostName'".
             " value='$hostName'>";
        $s.="<input type='hidden' name='dbPort'".
             " value='$dbPort'>";
        $s.="<input type='hidden' name='dbSocket'".
             " value='$dbSocket'>";
        $s.="<input type='hidden' name='dbPrefix'".
             " value='$dbPrefix'>";
    }
    $s.="<tr class='edit'>\n";
    $s.="<th class='edit' colspan='2'>";
    $s.="<input type='submit' value='OK'>";
    $s.="</th>";
    $s.="</tr>\n";
    $s.="</form>\n";
    $s.="</table>\n";
    $s.="</center>\n";
    return $s;
}
function showConfFile(&$s)
{
    global $hostName,$dbUser,$dbUserPw,$dbName,$dbPort,$dbSocket, $dbPrefix;

    $s="";
    $s.="<"."?php\n";
    $s.="\$dbUser=\"$dbUser\";\n";
    $s.="\$dbUserPw=\"$dbUserPw\";\n";
    $s.="\$dbName=\"$dbName\";\n";
    $s.="\$hostName=\"$hostName\";\n";
    $s.="\$dbPrefix=\"$dbPrefix\";\n";
    if (isset($dbPort)) {
        $s.="\$dbPort=\"$dbPort\";\n";
    }
    if (isset($dbSocket)) {
        $s.="\$dbSocket=\"$dbSocket\";\n";
    }
    $s.="?".">\n";
    echo $s;
}
function writeConfigFile(&$s)
{
    global $configFileName,$lll;

    $s="";
    $f=@fopen(NOAH_APP . "/$configFileName","w+");
    if ($f==0) {
        $s.=$lll["conf_file_write_err"];
        return nok;
    }
    showConfFile($sc);
    fwrite($f,$sc);
    fclose($f);
    return ok;
}
function showConfFileHtml(&$s)
{
    $s="";
    showConfFile($s1);
    $s.="<pre style='text-align:left;background-color:#eeeeee'>".
        "<strong>".htmlspecialchars($s1)."</strong></pre>";
}
?>
