<?php
global $categoryColumnsNum, $zebraList, $tableRowHighlight, $curvyCorners, $zebraList, $zebraDetails, $tableRowHighlight, 
       $contentSeparator, $populateTwoLevelsOfSubCategories;
// The number of columns the categories are displayed in:
$categoryColumnsNum=3;
// Alternating colors in list rows:
$zebraList=TRUE;
// Rows in lists are highlighted when the cursor is moved over:
$tableRowHighlight="list";
// To make the corners of lists, forms and details panels rounded:
$curvyCorners=FALSE;
// Alternating colors in lists:
$zebraList=TRUE;
// Alternating colors in details panels:
$zebraDetails=TRUE;
// Hover effect on the rows of lists:
$tableRowHighlight="list";
// If a page contains more than one elements - e.g. two forms, they are separated with the below structure to keep some spacing between them:
$contentSeparator = "<p style='height:20px;'>";
// If you want to create a category list template where the direct sub categories are displayed under the main category, set the following variable to TRUE:
$populateTwoLevelsOfSubCategories=TRUE;
// If you set the following variable TRUE, the 'currentCategory' template variable will always contain 
// references to the adjacent sibling categories of the current category and to the father category of the current one!
// If we take the distributed test categories as an example:
// - assuming that the currentCategory is 'Economy cars', the father category is 'Cars' and the adjacent siblings are ('Economy cars', 'Pickups')
// - assuming that the currentCategory is 'Cars', the adjacent siblings are ('Cars', 'Hardware', 'Cottages', 'Dating')
global $populateAdjacentSiblingCategories;
$populateAdjacentSiblingCategories=FALSE;

// It is possible to pass the whole category hierarchy to the main template file in a template variable called 'fullCategoryTree'.
// It is useful when you want to display an expandable-collapsible category navigator somewhere on the page.
// For more details, check out the following page: http://noahsclassifieds.org/documentation/customization/full_category_tree
global $populateFullCategoryTree, $categoryTreeFormat, $categoryTreeMainTag, $categoryTreeMainClass, $categoryTreeActiveNodeClass, $categoryTreeWithLinks;       
$populateFullCategoryTree = FALSE;
$categoryTreeFormat = "html";  // other possible values: "multi_array", "html"

// In case of "ul_list", you can also set the further variables:
// other possible values are "ol", "div" if you want to use an <ol> or <div> list instead of <ul>
$categoryTreeMainTag = "ul";  

// you can give a CSS class to the main <ul> (or <ol> or <div>)
$categoryTreeMainClass = "";

// you can give a CSS class to the node of the currentCategory, in order to distinguish the 
// the active "category context" from all the other categories:
$categoryTreeActiveNodeClass = "";

// instead of the simple category names, you can use links to the categories by setting the following to TRUE:
$categoryTreeWithLinks = FALSE;

class ThemeConfig
{
    
function init()
{
    global $gorumroll;
    
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/curvycorners.js");
    JavaScript::addInclude(THEME_DIR . "/javascripts/modern.js");
    if( ($gorumroll->list=="item" || $gorumroll->list=="user") && $gorumroll->method=="showdetails" ) 
    {
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.preload.js");
        JavaScript::addOnload("
          $('.smallpic img').preload({
              find:'small',
              replace:'large'
          });
          $('.smallpic a').hover(function(){
              var dim = $(this).find('img').attr('rel').split('x');
              var src = $(this).find('img').attr('src');
              $('.mainpic img').attr({
                  src: src.replace('small','large'),
                  width: dim[0],
                  height: dim[1]
              });
              $('.mainpic a').attr('href', this.href);
          },function(){});
        ");    
    }
}

}
?>