<?php
defined('_NOAH') or die('Restricted access');
//if( $registrationType==User_highLevel) include(GORUM_DIR . "/loginlib_high.php");
//else include(GORUM_DIR . "/loginlib.php");
include_once(GORUM_DIR . "/filter.php");
include(GORUM_DIR . "/gorumlib.php");
include(GORUM_DIR . "/object.php");
include(GORUM_DIR . "/roll.php");
include(GORUM_DIR . "/hasmany.php");
include(GORUM_DIR . "/dbproperty.php");
include(GORUM_DIR . "/location.php");
include(GORUM_DIR . "/controller.php");
include(GORUM_DIR . "/init.php");
include(GORUM_DIR . "/g.php");
include(GORUM_DIR . "/xdebug.php");
include(GORUM_DIR . "/date.php");
include(GORUM_DIR . "/presentation/lllglobalproperties.php");
include(GORUM_DIR . "/presentation/lllproperties.php");
include(GORUM_DIR . "/presentation/generwidget.php");
include(GORUM_DIR . "/presentation/formfieldtype.php");
include(GORUM_DIR . "/sorting.php");
include(GORUM_DIR . "/cache.php");
include(GORUM_DIR . "/fp.php");
include_once(GORUM_DIR . "/javascript.php");
if( $autoImapUserCreateMode ) include(GORUM_DIR . "/imap.php");
?>
