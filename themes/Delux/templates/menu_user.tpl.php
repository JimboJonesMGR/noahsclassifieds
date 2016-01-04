<?php defined('_NOAH') or die('Restricted access'); ?>
  <?php if( !empty($this->userMenu["myProfile"])): ?>
    <a href='<?php echo $this->userMenu["myProfile"]["link"] ?>'>
      <?php echo $this->userMenu["myProfile"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php if( !empty($this->userMenu["mySubscriptions"])): ?>
    <a href='<?php echo $this->userMenu["mySubscriptions"]["link"] ?>'>
      <?php echo $this->userMenu["mySubscriptions"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php if( !empty($this->userMenu["help"])): ?>
    <a href='<?php echo $this->userMenu["help"]["link"] ?>'>
      <?php echo $this->userMenu["help"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php foreach( $this->customUserMenuPoints as $menuPoint ): ?>
    <a href='<?php echo $menuPoint["link"] ?>'>
      <?php echo $menuPoint["label"] ?></a>
    
  <?php endforeach; ?>    
  <?php if( !empty($this->userMenu["purchase"])): ?>
    <a href='<?php echo $this->userMenu["purchase"]["link"] ?>'>
      <?php echo $this->userMenu["purchase"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php if( !empty($this->userMenu["purchaseHistory"])): ?>
    <a href='<?php echo $this->userMenu["purchaseHistory"]["link"] ?>'>
      <?php echo $this->userMenu["purchaseHistory"]["label"] ?></a>
    
  <?php endif; ?>
<?php if( $this->ecommStatus): ?>
<a style=""> <?php echo $this->ecommStatus; ?></a>
                                                                    <?php endif; ?>