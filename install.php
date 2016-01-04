<?php
include("initdirs.php");

include(NOAH_APP . "/constants.php");
include(GORUM_DIR . "/dbinstall.php");
include(GORUM_DIR . "/installlib.php");
include(NOAH_APP . "/installlib.php");
include(NOAH_APP . "/include.php");
include(GORUM_DIR . "/gorum_action.php");
include(GORUM_DIR . "/gorum_view.php");

initDefaultLanguage();
installMain($s);
echo $s;
?>
