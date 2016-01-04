<?php defined('_NOAH') or die('Restricted access'); ?>
<ul>
    <?php if( !empty($this->menu["mainSite"])): ?>
      <li><a class='noindent' href='<?php echo $this->menu["mainSite"]["link"] ?>'>
        <?php echo $this->menu["mainSite"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["home"])): ?>
      <li><a class='noindent' href='<?php echo $this->menu["home"]["link"] ?>'>
        <?php echo $this->menu["home"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["register"])): ?>
      <li><a href='<?php echo $this->menu["register"]["link"] ?>'>
        <?php echo $this->menu["register"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["login"])): ?>
      <li><a href='<?php echo $this->menu["login"]["link"] ?>'>
        <?php echo $this->menu["login"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["logout"])): ?>
      <li><a href='<?php echo $this->menu["logout"]["link"] ?>'>
        <?php echo $this->menu["logout"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["myProfile"])): ?>
      <li><a href='<?php echo $this->menu["myProfile"]["link"] ?>'>
        <?php echo $this->menu["myProfile"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["recentAds"])): ?>
      <li><a href='<?php echo $this->menu["recentAds"]["link"] ?>'>
        <?php echo $this->menu["recentAds"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["popularAds"])): ?>
      <li><a href='<?php echo $this->menu["popularAds"]["link"] ?>'>
        <?php echo $this->menu["popularAds"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["addAd"])): ?>
      <li><a href='<?php echo $this->menu["addAd"]["link"] ?>'>
        <?php echo $this->menu["addAd"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["searchAds"])): ?>
      <li><a href='<?php echo $this->menu["searchAds"]["link"] ?>'>
        <?php echo $this->menu["searchAds"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["mySubscriptions"])): ?>
      <li><a href='<?php echo $this->menu["mySubscriptions"]["link"] ?>'>
        <?php echo $this->menu["mySubscriptions"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["favorities"])): ?>
      <li><a href='<?php echo $this->menu["favorities"]["link"] ?>'>
        <?php echo $this->menu["favorities"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->menu["help"])): ?>
      <li><a href='<?php echo $this->menu["help"]["link"] ?>'>
        <?php echo $this->menu["help"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php foreach( $this->customUserMenuPoints as $menuPoint ): ?>
      <li><a href='<?php echo $menuPoint["link"] ?>'>
        <?php echo $menuPoint["label"] ?></a>
      </li>
    <?php endforeach; ?>    
    <?php if( !empty($this->userMenu["purchase"])): ?>
      <li><a href='<?php echo $this->userMenu["purchase"]["link"] ?>'>
        <?php echo $this->userMenu["purchase"]["label"] ?></a>
      </li>
    <?php endif; ?>  
    <?php if( !empty($this->userMenu["purchaseHistory"])): ?>
      <li><a href='<?php echo $this->userMenu["purchaseHistory"]["link"] ?>'>
        <?php echo $this->userMenu["purchaseHistory"]["label"] ?></a>
      </li>
    <?php endif; ?>  
</ul>  

