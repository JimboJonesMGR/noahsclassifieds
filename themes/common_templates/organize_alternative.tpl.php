<?php defined('_NOAH') or die('Restricted access'); 
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));     
?>

<div id='checkconf'>
  <p class='confok'>
    The Parent ID-s determine the hierarchy between the categories. E.g. if the Parent ID of a category is 1, it means that it is 
    the sub category of the category with ID 1. You can change the hierarchy by changing the Parent ID-s. E.g. if you want to 
    move a sub category into an other category, change its Parent ID to that of the new category.
  </p>  
  <p class='conferr'>
    Moving a category into one of its sub categories doesn't work!
  </p>  
  <p class='confok'>
    The Sort indexes determine the order of the categories which are on the same level. You can change the order by changing the 
    Sort indexes. E.g. if you have three categories with indexes 100, 200 and 300 respectively and you want to move the third category
    in between the first two, give it an index of 150!
  </p>  
</div>
<?php  // displaying the advertisements if there are any:
    $this->displayContent("categoryList"); 
?>


