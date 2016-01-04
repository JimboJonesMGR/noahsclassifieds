<?php defined('_NOAH') or die('Restricted access'); ?>
<div class='checkconf'>
  <h1>Let's have an overview on the different kind of item (advertisement) lists in Noah's Classifieds:</h1>
  <ul>
    <li>The most frequently used item lists are the category listings - you can see them whenever you click on the name of a category,</li>
    <li>Search result list: if a search result list contains ads from only one category, it will be displayed just like the category listings - with all the category specific columns,</li>
    <li>All the ads of one user, including the 'My ads' list,</li>
    <li>Special lists: 'Recent ads', 'Popular ads', 'Approved ads', 'Pending ads'</li>
  </ul>
  <p style='font-weight: bold;'>
  If we want to generalize the lists under the latter two points, we can name one common factor: all of them are actually special search result lists!
  E.g. The 'My ads' list is the result of a search for ads where the owner is the currently logged in one. 
  The 'Popular ads' is a result of a search where all the ads are listed ordered by the number they are displayed descending.</p>
  
  This approach opened the way to making the program even more flexible. In the 3.1.0 release, we have added the following changes:
  <ul>
    <li>We introduce the term of "custom list" - this is an item list that admin can create and arbitrarily configure by supplying a search condition and some other properties,</li>
    <li>We replace the special lists of the above latter two points with their pre-configured custom list counterpart! 
    'My ads', 'Recent ads', 'Popular ads' and 'Pending ads' are nothing but ordinary custom lists from now on,</li>
    <li>There are several things you can do with a custom list:
      <ul>
        <li>You can tell which ads it contains (by giving a search condition),</li>
        <li>You can tell what columns it displays and how it looks like,</li>
        <li>You can put a menu point that links to it in any of the four menu bars,</li>
        <li>You can make it so that the list is automatically displayed on any Noah's page! 
        In this case you can specify, which pages you want to see the list on and exactly where the list should appear and how (RSS version only!)</li>
        <li>And of course, you can create any number of new custom lists! It's up to your creativity what you use them for.</li>
      </ul>
    </li>
  </ul>
</div>
<?php $this->displayContent("listOfCustomLists"); ?>

