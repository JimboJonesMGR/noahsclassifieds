<?php
defined('_NOAH') or die('Restricted access');

global $keysToJsFiles, $keysToCssFiles;

$keysToJsFiles_ = array(
    "core"=>GORUM_JS_DIR . "/core.js",
    "cookie"=>GORUM_JS_DIR . "/cookie.js",
    "dump"=>GORUM_JS_DIR . "/dump.js",
    "usableforms"=>GORUM_JS_DIR . "/usableforms.js",
    "jquery"=>GORUM_JS_DIR . "/jquery/jquery-1.6.1.min.js",
    "interface_jquery"=>GORUM_JS_DIR . "/jquery/interface/jquery.js",
    "form"=>GORUM_JS_DIR . "/jquery/form.js",
    //"field"=>GORUM_JS_DIR . "/jquery/field.js",
    "inestedsortable"=>GORUM_JS_DIR . "/jquery/inestedsortable.js",
    "alphanumeric"=>GORUM_JS_DIR . "/jquery/jquery.alphanumeric.js",
    "color"=>GORUM_JS_DIR . "/jquery/jquery.color.js",
    "maskedinput"=>GORUM_JS_DIR . "/jquery/jquery.maskedinput.js",
    
    "asmselect"=>GORUM_JS_DIR . "/jquery/jquery.asmselect.js",
    "bgiframe"=>GORUM_JS_DIR . "/jquery/jquery.bgiframe.js",
    "center"=>GORUM_JS_DIR . "/jquery/jquery.center.js",
    "curvycorners"=>GORUM_JS_DIR . "/jquery/curvycorners.js",
    //"dimensions"=>GORUM_JS_DIR . "/jquery/jquery.dimensions.js",
    "jquery_dump"=>GORUM_JS_DIR . "/jquery/jquery.dump.js",
    "em"=>GORUM_JS_DIR . "/jquery/jquery.em.js",
    "expose"=>GORUM_JS_DIR . "/jquery/jquery.expose.js",
    "jscrollpane"=>GORUM_JS_DIR . "/jquery/jquery.jscrollpane.js",
    "livequery"=>GORUM_JS_DIR . "/jquery/jquery.livequery.js",
    "nestedsortablewidget"=>GORUM_JS_DIR . "/jquery/jquery.nestedsortablewidget.js",
    "overlay"=>GORUM_JS_DIR . "/jquery/jquery.overlay.js",
    "preload"=>GORUM_JS_DIR . "/jquery/jquery.preload.js",
    "scrollable"=>GORUM_JS_DIR . "/jquery/jquery.scrollable.js",
    "ui"=>GORUM_JS_DIR . "/jquery/jquery.ui.js",
    "json"=>GORUM_JS_DIR . "/jquery/json.js",
    "tablehover"=>GORUM_JS_DIR . "/jquery/tablehover.js",
    "thickbox"=>GORUM_JS_DIR . "/jquery/thickbox.js",
    "chili"=>GORUM_JS_DIR . "/jquery/jquery.chili-2.2.js",
    
    "calendar"=>GORUM_JS_DIR . "/jscalendar/calendar.js",
    "calendar-en"=>GORUM_JS_DIR . "/jscalendar/lang/calendar-en.js",
    "calendar-setup"=>GORUM_JS_DIR . "/jscalendar/calendar-setup.js",
    "markitup"=>GORUM_JS_DIR . "/jquery/markitup/jquery.markitup.js",
    "default-set"=>GORUM_JS_DIR . "/jquery/markitup/sets/default/set.js",
    "html-set"=>GORUM_JS_DIR . "/jquery/markitup/sets/html/set.js",
    "ad_html-set"=>GORUM_JS_DIR . "/jquery/markitup/sets/ad_html/set.js",
    "head-set"=>GORUM_JS_DIR . "/jquery/markitup/sets/head/set.js",
    
    "idrag"=>GORUM_JS_DIR . "/jquery/interface/idrag.js",
    "idrop"=>GORUM_JS_DIR . "/jquery/interface/idrop.js",
    "interface"=>GORUM_JS_DIR . "/jquery/interface/interface.js",
    "isortables"=>GORUM_JS_DIR . "/jquery/interface/isortables.js",
    "iutil"=>GORUM_JS_DIR . "/jquery/interface/iutil.js",
    
    "apply_rule"=>JS_DIR. "/apply_rule.js",
    "categoryselect"=>JS_DIR. "/categoryselect.js",
    "credit_rule_form"=>JS_DIR. "/credit_rule_form.js",
    "custom_field_form"=>JS_DIR. "/custom_field_form.js",
    "fieldset_form"=>JS_DIR. "/fieldset_form.js",
    "noah"=>JS_DIR. "/noah.js",
    "propagate"=>JS_DIR. "/propagate.js",
    "purchase"=>JS_DIR. "/purchase.js",
    "noah_scrollable"=>JS_DIR. "/scrollable.js",
    "sort_custom_fields"=>JS_DIR. "/sort_custom_fields.js",
);

$keysToCssFiles_ = array(
    "calendar"=>GORUM_JS_DIR . "/jscalendar/skins/aqua/theme.css",
    "asmselect"=>GORUM_JS_DIR . "/jquery/jquery.asmselect.css",
    "jscrollpane"=>GORUM_JS_DIR . "/jquery/jscrollpane.css",
    "default-set"=>GORUM_JS_DIR . "/jquery/markitup/sets/default/style.css",
    "html-set"=>GORUM_JS_DIR . "/jquery/markitup/sets/html/style.css",
    "ad_html-set"=>GORUM_JS_DIR . "/jquery/markitup/sets/ad_html/style.css",
    "head-set"=>GORUM_JS_DIR . "/jquery/markitup/sets/head/style.css",
    "markitup-style"=>GORUM_JS_DIR . "/jquery/markitup/skins/markitup/style.css",
    "chili"=>GORUM_JS_DIR . "/jquery/chili/chili.css",
);

if( isset($keysToCssFiles) ) $keysToCssFiles = array_merge($keysToCssFiles_, $keysToCssFiles);
else $keysToCssFiles = $keysToCssFiles_;
if( isset($keysToJsFiles) ) $keysToJsFiles = array_merge($keysToJsFiles_, $keysToJsFiles);
else $keysToJsFiles = $keysToJsFiles_;

?>
