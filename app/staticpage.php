<?php
defined('_NOAH') or die('Restricted access');
$staticpage_typ = array();

class StaticPage extends Object 
{

function show()
{
    global $tA, $gorumroll;
    $template = "$gorumroll->rollid.tpl.php";
    if( !file_exists(GORUM_TEMPLATE_DIR . "/$template") && !file_exists(TEMPLATE_DIR . "/$template") && !file_exists(COMMON_TEMPLATES . "/$template") )
    {
        header("HTTP/1.0 404 Not Found");
        $template = "404.tpl.php";
    }
    $tA["staticpage-show"]=$template;
}

function preview()
{
    hasAdminRights($isAdm);
    if(!$isAdm) handleErrorPerm( __FILE__, __LINE__ );
    $_S = new AppSettings();
    foreach( $_POST as $attr=>$val )
    {
        $_S->$attr = $val;
    }
}

}
?>
