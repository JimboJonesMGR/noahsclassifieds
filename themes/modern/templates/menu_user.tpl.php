<?php defined('_NOAH') or die('Restricted access'); ?>
<ul>
  <?php if( !empty($this->userMenu["myProfile"])): ?>
    <li><a href='<?php echo $this->userMenu["myProfile"]["link"] ?>'>
      <?php echo $this->userMenu["myProfile"]["label"] ?></a>
    </li>
  <?php endif; ?>  
  <?php if( !empty($this->userMenu["mySubscriptions"])): ?>
    <li><a href='<?php echo $this->userMenu["mySubscriptions"]["link"] ?>'>
      <?php echo $this->userMenu["mySubscriptions"]["label"] ?></a>
    </li>
  <?php endif; ?>  
  <?php if( !empty($this->userMenu["help"])): ?>
    <li><a href='<?php echo $this->userMenu["help"]["link"] ?>'>
      <?php echo $this->userMenu["help"]["label"] ?></a>
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

