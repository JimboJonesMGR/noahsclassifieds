<?php
include("initdirs.php");
// For compatibility before 2.3.0:
if( !file_exists($CONFIG_FILE_DIR . "/config.php") ) $CONFIG_FILE_DIR = ".";
ini_set("max_execution_time", 0);
$dbPrefix = "classifieds_";
include(NOAH_APP . "/constants.php");
//include(NOAH_APP . "/error.php");
include(NOAH_APP . "/include.php");
include(GORUM_DIR . "/installlib.php");
include(NOAH_APP . "/updatelib.php");
initDefaultLanguage();
updateMain($s);
echo $s;
?>
