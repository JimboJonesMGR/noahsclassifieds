<?php defined('_NOAH') or die('Restricted access'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?php echo $this->language ?>" dir="<?php echo $this->langDir ?>">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <base href='<?php echo $this->baseUrl ?>'>
    
    <?php /* Search Engine Optimization section: */ ?>
    <?php if( $this->get("customMetaTags") ): ?>
      <?php echo $this->get("customMetaTags") ?>
    <?php else: ?>  
      <title><?php echo $this->titlePrefix ?><?php if( $this->title ) echo ' - '.$this->title; ?></title>
      <meta name='description' content='<?php echo $this->description ?>'>
      <meta name='keywords' content='<?php echo $this->keywords ?>'>
    <?php endif; ?>
    
    <?php /* JavaScript section (without this, pages won't work properly!): */ ?>
    <?php echo $this->jsIncludes /* includes external JavaScript and CSS files */ ?>
    <?php echo $this->javaScript /* inserts internal JavaScrip code */ ?>
    <?php echo $this->extraHead /* inserts the 'Additional HEAD content' from the Settings form */ ?>
  </head>  
  <body>
    <?php echo $this->extraBody /* inserts the 'Additional BODY content' from the Settings form */ ?>
    <div id='outerMain' class='<?php echo $this->outerMainClass ?>'>
    <div id='sidebarLeft'>
      <?php $this->displayContent("customListLeft") /* inserts custom lists where 'On the left side of the page' has been selected in the 'Position' field */ ?>
    </div>  
    <div id='main' class='<?php echo $this->mainClass ?>'>
      <?php $this->displayContent("customListTop", putWhiteSpaceAbove) /* inserts custom lists where 'On the top of the page' has been selected in the 'Position' field */ ?>
      <div id='top'>
        <div id='header'><img src='<?php echo $this->imagesDir ?>/headpic.gif?logoImage'></div>
        <div id='loginMenu'>
          <?php include $this->loadTemplate("menu_login.tpl.php"); /* This includes an other template file that contains the user menu points */ ?>
        </div>
        <?php if( isset($this->rssFeed) ): ?>
          <ul class="feedList">
            <?php foreach( $this->rssFeed as $item ): ?>
              <li>
                <a href='<?php echo $item["link"] ?>' class='<?php echo $item["linkClass"] ?>'>
                  <?php echo $item["label"] ?>
                </a>
              </li>
            <?php endforeach; ?>  
          </ul>
        <?php endif; ?>  
      </div>  
      <div  id='userStatusBar'>
        <div id='userStatus'>
          <?php echo $this->userStatus ?>
        </div>
        <?php if( $this->languageSelector): ?>
          <div id='languageSelector'>
            <?php echo $this->languageSelector ?>
          </div>
        <?php endif; ?>  
        <?php if( $this->themeSelector): ?>
          <div id='themeSelector'>
            <?php echo $this->themeSelector ?>
          </div>
        <?php endif; ?>  
      </div>
      <div id='sep'></div>
      <?php if( count($this->adminMenu) ): ?>
        <div id='userMenu' class='menu'>
          <?php include $this->loadTemplate("menu_admin.tpl.php"); /* This includes an other template file that contains the user/admin menu points */ ?>
        </div>
      <?php elseif( count($this->userMenu) ): ?>
        <div id='userMenu' class='menu'>
          <?php include $this->loadTemplate("menu_user.tpl.php"); /* This includes an other template file that contains the user menu points */ ?>
          <?php if( $this->ecommStatus): ?>
            <div id='ecommStatus'>
              <?php echo $this->ecommStatus; ?>
            </div>
          <?php endif; ?>  
        </div>
      <?php endif; ?>
      <?php if( count($this->categoryMenu) ): ?>
        <div id='categoryMenu' class='menu'>
          <?php include $this->loadTemplate("menu_category.tpl.php"); /* This includes an other template file that contains the category menu points */ ?>
        </div>
      <?php endif; ?>
      <?php echo $this->extraTopContent /* inserts the 'Additional top content' from the Settings form */ ?>
      <?php if($this->infoText): ?>
        <div id='infoTextBar'><div id='infoText'><?php echo $this->infoText ?></div></div>
      <?php endif; ?>
      <?php $this->displayContent("customListAboveContent", putWhiteSpaceAbove) /* inserts custom lists where 'Above content' has been selected in the 'Position' field */ ?>
      <div id='content'>
        <?php if($this->get("navBar")): ?>
          <div id='navBar'><?php echo $this->get("navBar") ?></div>
        <?php endif; ?>
        <div id='contentArea'>
          <?php 
          $this->displayContent() 
          ?>
        </div>
      </div>    
      <?php $this->displayContent("customListBelowContent", putWhiteSpaceAbove) /* inserts custom lists where 'Below content' has been selected in the 'Position' field */ ?>
      <?php echo $this->extraBottomContent /* inserts the 'Additional bottom content' from the Settings form */ ?>
      <div id='footer'>
        <div><div><?php echo $this->versionFooter ?></div></div>
      </div>
      <?php echo $this->extraFooter /* inserts the 'Additional footer content' from the Settings form */ ?>
      <?php $this->displayContent("customListBottom", putWhiteSpaceAbove) /* inserts custom lists where 'On the bottom of the page' has been selected in the 'Position' field */ ?>
    </div> 
    <div id='sidebarRight'>
      <?php $this->displayContent("customListRight") /* inserts custom lists where 'On the right side of the page' has been selected in the 'Position' field */ ?>
    </div>  
    </div>  
  </body>
</html>  