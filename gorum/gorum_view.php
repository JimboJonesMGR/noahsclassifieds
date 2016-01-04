<?php
defined('_NOAH') or die('Restricted access');
include(GORUM_DIR . "/Savant2.php");
include(GORUM_DIR . "/view.php");
include(GORUM_DIR . "/htmllist.php");
include(GORUM_DIR . "/tools.php");
include(GORUM_DIR . "/presentation/generdatewidget.php");
include(GORUM_DIR . "/presentation/presentation.php");
include(GORUM_DIR . "/presentation/listpresentation.php");
include(GORUM_DIR . "/presentation/formpresentation.php");
include(GORUM_DIR . "/presentation/deleteformpresentation.php");
include(GORUM_DIR . "/presentation/detailspresentation.php");
include(GORUM_DIR . "/pager.php");
if( file_exists(NOAH_APP . "/include_view.php") ) include(NOAH_APP . "/include_view.php");
?>
