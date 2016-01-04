<?php
$dbPrefix = "classifieds_";  // for backward compatibility with 1.3

include("initdirs.php");
// For compatibility before 2.3.0:
if( !file_exists($CONFIG_FILE_DIR . "/config.php") ) $CONFIG_FILE_DIR = ".";
include(NOAH_APP . "/constants.php");
include(NOAH_APP . "/error.php");
include(NOAH_APP . "/include.php");

gorumMain();

View::displayMain();
?>
