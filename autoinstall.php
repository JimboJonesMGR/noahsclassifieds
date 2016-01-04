<?php
/******************************************************************************************************************/
$autoInstallHelp = <<<EOD
This script attempts to perform an automatic Noah's Classifieds installation.
The administrator account of the installation will be: user: 'admin', password: 'admin'
There will also be a test user created: user: 'john', password: 'a'

It can be called either from command line or from the browser. 
In the former case, it can take parameters either from an ini file, or from the command line, or from both.
In the latter case, it can take parameters either from an ini file, or from the query string, or from both.
The parameters in the command line/query string always override those read from the ini file.
The default ini file is called 'noah.ini.php'.
For the description of each available parameters, see 'noah.ini.php'.
Per default, Noah's will be installed in the same directory where this script resides. This can be 
overridden by the 'noahDir' parameter.

Examples of calling the script from the command line:

# this installs with parameters taken solely from 'noah.ini.php':
php autoinstall.php

# this installs with parameters taken solely from an other ini file:
php autoinstall.php --iniFile=/some/path/other.ini.php

# this installs with parameters mostly read from 'noah.ini.php' and some of them are overridden by the command line:
php autoinstall.php --dbName=noah --dbUser=noahuser --dbUserPw=noahpass

Examples of calling the script from the browser:

# this installs with parameters taken solely from 'noah.ini.php':
http://path/to/noahs/installation/autoinstall.php

# this installs with parameters taken solely from an other ini file:
http://path/to/noahs/installation/autoinstall.php?iniFile=/some/path/other.ini.php

# this installs with parameters mostly read from 'noah.ini.php' and some of them are overridden by the command line:
http://path/to/noahs/installation/autoinstall.php?dbName=noah&dbUser=noahuser&dbUserPw=noahpass

# this installs the program somewhere else:
http://some/path/autoinstall.php?noahDir=/path/to/noahs/installation/

# you can suppress any output messages but the fatal errors with specifying the 'silent' 
# parameter either in the command line, or in the query string. E.g.:
http://path/to/noahs/installation/autoinstall.php?silent=1
php autoinstall.php -silent

# per default, the install fails if the program has been installed already. 
# you can override this with the 'withDrop' parameter. E.g.:
http://path/to/noahs/installation/autoinstall.php?withDrop=1
php autoinstall.php -withDrop
The above will re-install the program if it has already installed

# if you call the script from the browser, you can make it to automatically  
# redirect to the finished installation on completion with the 'redirect' parameter. E.g.:
http://path/to/noahs/installation/autoinstall.php?redirect=1

EOD;
/*********************************************************************************************************************/

define( '_NOAH', 1 );

$ai = new AutoInstall();
$ai->validate();
$ai->changeToWorkingDir();

include("initdirs.php");
include(NOAH_APP . "/constants.php");
include(GORUM_DIR . "/dbinstall.php");
include(NOAH_APP . "/installlib.php");
include(NOAH_APP . "/include.php");
include(GORUM_DIR . "/gorum_action.php");
include(GORUM_DIR . "/gorum_view.php");
initDefaultLanguage();

$ai->writeConfigFile();
include_once(NOAH_APP . "/config.php");

$di = new DbInstall($ai);
$ai->out("Creating database tables.");
$di->installCreateTables();
$ai->out("Creating admin user.");
createFirstAdmin();
$ai->out("Filling tables.");
appFillTables();
$ai->changeSettings();
$ai->out("Installation is ready.");
$ai->out("Checking installation.");
$ai->checkInstallation();

class AutoInstall
{
var $silent = FALSE;
var $redirect = FALSE;

function AutoInstall()
{
    global $installParameters, $autoInstallHelp, $argc, $argv;
    
    error_reporting(0);
    $iniFileName = "noah.ini.php";  // default ini file
    $installParameters = array();
    // if called from command line:
    if( !empty($argc) )
    {
        // reading parameters into $installParameters:
        if( $argc>1 ) AutoInstall::readCLI($installParameters);
        if( isset($installParameters["help"]) ) $this->outDie($autoInstallHelp);
        // if the parameters contain an 'iniFile', we override noah.ini.php with it:
        if( isset($installParameters["iniFile"]) ) $iniFileName = $installParameters["iniFile"];
        // if we have an ini file, include it:
        if( file_exists("$iniFileName") ) 
        {        
            // this fills out the $installParameters array from the ini file:
            if( !empty($installParameters->silent) ) $this->silent=TRUE;
            if( !empty($installParameters->redirect) ) $this->redirect=TRUE;
            $this->out("Reading ini file: $iniFileName");
            include($iniFileName);
            // if we have also command line parameters, their values can override the values read from the ini file, so we read them again:
            if( $argc>1 ) AutoInstall::readCLI($installParameters);
        }
        else $this->out("Ini file was not specified or doesn't exists. Initializing from the command line.");
    }
    // if called from the browser:
    else
    {
        // reading parameters from the query string into $installParameters:
        if( isset($_GET) && count($_GET) ) $installParameters = $_GET;
        if( isset($installParameters["help"]) ) $this->outDie(nl2br($autoInstallHelp));
        // if the parameters contain an 'iniFile', we override noah.ini.php with it:
        if( isset($installParameters["iniFile"]) ) $iniFileName = $installParameters["iniFile"];
        // if we have an ini file, include it:
        if( file_exists("$iniFileName") ) 
        {        
            // this fills out the $installParameters array from the ini file:
            if( !empty($_GET["silent"]) ) $this->silent=TRUE;
            if( !empty($_GET["redirect"]) ) $this->redirect=TRUE;
            $this->out("Reading ini file: $iniFileName");
            include($iniFileName);
            // if we have also query string parameters, their values can override the values read from the ini file, so we read them again:
            if( isset($_GET) || count($_GET) ) 
            {
                foreach( $_GET as $param=>$value ) $installParameters[$param] = $value;
            }
        }
        else $this->out("Ini file was not specified or doesn't exists. Initializing from the query string.");
    }
    foreach( $installParameters as $param=>$val ) $this->$param = $val;
}

function validate()
{
    // check for mandatory parameters:
    $this->out("Validating parameters");
    foreach( array("hostName", "dbName", "dbUser", "dbUserPw", "noahDir") as $param )
    {
        if( !isset($this->$param) ) $this->outDie("'$param' is mandatory. Installation failed - exiting.");
    }
}

function readCLI(&$params) 
{
    global $argv;
    
    foreach ($argv as $arg) 
    {
        if (ereg('--([^=]+)=(.*)',$arg,$reg)) 
        {
            $params[$reg[1]] = $reg[2];
        } 
        elseif(ereg('--?([a-zA-Z0-9]+)',$arg,$reg))
        {
            $params[$reg[1]] = 'true';
        }
        elseif($arg=="help")
        {
            $params["help"]='true';
        }
    }
}

function changeToWorkingDir()
{
    if( $this->noahDir!="." ) $this->out("Changig directory to '$this->noahDir'");
    if( @chdir($this->noahDir)===FALSE ) $this->outDie("'noahDir' seems to be invalid. Installation failed - exiting.");
}

function writeConfigFile()
{        
    if( ($f = @fopen(NOAH_APP . "/config.php", "w"))===FALSE ) $this->outDie("Unable to open 'app/config.php' for writing. Grant enough permissions and restart the installation!");  
    $s="";
    $s.="<"."?php\n";
    $s.="\$dbUser=\"$this->dbUser\";\n";
    $s.="\$dbUserPw=\"$this->dbUserPw\";\n";
    $s.="\$dbName=\"$this->dbName\";\n";
    $s.="\$hostName=\"$this->hostName\";\n";
    $s.="\$dbPrefix=\"$this->dbPrefix\";\n";
    if (isset($this->dbPort)) $s.="\$dbPort=\"$this->dbPort\";\n";
    if (isset($this->dbSocket)) $s.="\$dbSocket=\"$this->dbSocket\";\n";
    $s.="?".">\n";
    $this->out("Creating and writing config.php.");
    if( @fwrite($f,$s)===FALSE ) $this->outDie("Unable to write 'app/config.php'. Installation failed - exiting.");
    @fclose($f);
}

function changeSettings()
{
    $_S = new AppSettings(); 
    foreach( array("adminEmail", "adminFromName", "smtpServer", "smtpUser", "smtpPass", "fallBackNative") as $param )
    {
        $_S->$param = $this->$param;
    }
    modify($_S);
}

function checkInstallation()
{
    global $dontRemoveInstallFiles, $argc;
    
    if( !defined("IMG_GIF") || !function_exists("ImageTypes"))//nincs GD
    {
        $this->out("");
        $this->out("Warning: your server doesn't have an installed GD library.");
        $this->out("(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program can't generate thumbnails, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )");
    }
    
    $cc = new CheckConf;
    $cc->checkWritePermission( $noPermDirs );
    if( count($noPermDirs) )
    {
        $this->out("");
        $this->out(sprintf("The program has no write permission under the following directories: %s", implode(", ", $noPermDirs)));
        $this->out("(During it's operation, Noah's Classifieds has to save files in a few subdirectories, in order to upload pictures, log errors or create create cache files. You have to make sure the program has enough permission to do this.)");
    }
    $this->out("Removing install files");
    $cc->removeInstFiles();
    if( empty($argc) && $this->redirect )
    {
        $conf = new GlobalStat(); 
        $conf->defPageConf = 0;
        modify($conf);
        header("location: $this->noahDir/index.php\n");
    }
}

function out($s)
{
    global $argc;
    
    if( !$this->silent && !(empty($argc) && $this->redirect) )
    {
        if( !empty($argc) ) fwrite( STDOUT, "$s\n");
        else echo "$s<br>";
        flush();
    }
}

function outDie($s)
{
    global $argc;
    
    if( !empty($argc) ) fwrite( STDERR, "$s\n");
    else echo "$s<br>";
    die(1);
}

}
?>
