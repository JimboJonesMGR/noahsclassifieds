<?php
defined('_NOAH') or die('Restricted access');
include(NOAH_APP . "/security.php");
include(GORUM_DIR . "/gorum.php");
include(GORUM_DIR . "/dbtreeproperty.php");
include(GORUM_DIR . "/category.php");
include(GORUM_DIR . "/settings.php");
include(GORUM_DIR . "/notification.php");
if( file_exists(NOAH_APP . "/rss.php") ) include(NOAH_APP . "/rss.php");
if( file_exists(NOAH_APP . "/response.php") && filesize(NOAH_APP . "/response.php")!=4297 ) include(NOAH_APP . "/response.php");
include(NOAH_APP . "/subscription.php");
include(NOAH_APP . "/controller.php");
include(NOAH_APP . "/assignments.php");
include(NOAH_APP . "/settings.php");
include(NOAH_APP . "/globalstat.php");
include(NOAH_APP . "/customfieldcontainer.php");
include(NOAH_APP . "/user.php");
include(NOAH_APP . "/category.php");
include(NOAH_APP . "/item.php");
//include(NOAH_APP . "/fieldcolumn.php");
include(NOAH_APP . "/customfield.php");
include(NOAH_APP . "/userfield.php");
include(NOAH_APP . "/itemfield.php");
include(NOAH_APP . "/init.php");
include(NOAH_APP . "/search.php");
include(NOAH_APP . "/itemsearch.php");
include(NOAH_APP . "/usersearch.php");
include(NOAH_APP . "/checkconf.php");
include(NOAH_APP . "/cronjob.php");
include(NOAH_APP . "/fieldset.php");
include(NOAH_APP . "/controlpanel.php");
include(NOAH_APP . "/customlist.php");
include(NOAH_APP . "/overlay.php");
include(NOAH_APP . "/ecomm.php");
include(NOAH_APP . "/flagged.php");

if( EComm::isEnabledGlobally() ) include(ECOMM_DIR . "/constants.php");
global $_FP;
if( $firePHP ) 
{
    include(GORUM_DIR . "/firephp/FirePHP.class.php");
    $_FP = FirePHP::getInstance(TRUE);
}
else $_FP=0;
?>
