<?php defined('_NOAH') or die('Restricted access'); ?>
  <?php if( !empty($this->categoryMenu["organizeCategory"])): ?>
    <a href='<?php echo $this->categoryMenu["organizeCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["organizeCategory"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["addCategory"])): ?>
    <a href='<?php echo $this->categoryMenu["addCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["addCategory"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["modifyCategory"])): ?>
    <a href='<?php echo $this->categoryMenu["modifyCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["modifyCategory"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["deleteCategory"])): ?>
    <a href='<?php echo $this->categoryMenu["deleteCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["deleteCategory"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["cloneCategory"])): ?>
    <a href='<?php echo $this->categoryMenu["cloneCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["cloneCategory"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["categorySubscriptions"])): ?>
    <a href='<?php echo $this->categoryMenu["categorySubscriptions"]["link"] ?>'>
      <?php echo $this->categoryMenu["categorySubscriptions"]["label"] ?></a>
    
  <?php endif; ?>  
  <?php foreach( $this->customCategoryMenuPoints as $menuPoint ): ?>
    <a href='<?php echo $menuPoint["link"] ?>'>
      <?php echo $menuPoint["label"] ?></a>
    
  <?php endforeach; ?>    