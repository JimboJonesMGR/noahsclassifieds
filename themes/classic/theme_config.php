<?php
global $categoryColumnsNum, $zebraList, $tableRowHighlight, $zebraList, $zebraDetails, $tableRowHighlight, $contentSeparator;

// The number of columns the categories are displayed in:
$categoryColumnsNum=4;
// Alternating colors in list rows:
$zebraList=TRUE;
// Rows in lists are highlighted when the cursor is moved over:
$tableRowHighlight="list";
// Alternating colors in lists:
$zebraList=TRUE;
// Alternating colors in details panels:
$zebraDetails=TRUE;
// Hover effect on the rows of lists:
$tableRowHighlight="list";
// If a page contains more than one elements - e.g. two forms, they are separated with the below structure to keep some spacing between them:
$contentSeparator = "<p style='height:20px;'>";

class ThemeConfig
{
    
function init()
{
    JavaScript::addInclude(THEME_DIR . "/javascripts/classic.js");
}

// Animation used to display the info text:    
function showInfoText()
{
    global $jQueryLib;
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.color.js");
    JavaScript::addScript("
    jQuery(document).ready(function($) {
        $('#infoText').animate({ 
            backgroundColor: 'pink' 
        }, 1000 ).animate({ 
            backgroundColor: '#cbcc66' 
        }, 1000 );
    });
    ");
}

}
?>
