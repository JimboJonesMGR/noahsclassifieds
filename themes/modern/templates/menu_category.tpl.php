<?php defined('_NOAH') or die('Restricted access'); ?>
<ul>
  <?php if( !empty($this->categoryMenu["organizeCategory"])): ?>
    <li><a href='<?php echo $this->categoryMenu["organizeCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["organizeCategory"]["label"] ?></a>
    </li>
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["addCategory"])): ?>
    <li><a href='<?php echo $this->categoryMenu["addCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["addCategory"]["label"] ?></a>
    </li>
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["modifyCategory"])): ?>
    <li><a href='<?php echo $this->categoryMenu["modifyCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["modifyCategory"]["label"] ?></a>
    </li>
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["deleteCategory"])): ?>
    <li><a href='<?php echo $this->categoryMenu["deleteCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["deleteCategory"]["label"] ?></a>
    </li>
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["cloneCategory"])): ?>
    <li><a href='<?php echo $this->categoryMenu["cloneCategory"]["link"] ?>'>
      <?php echo $this->categoryMenu["cloneCategory"]["label"] ?></a>
    </li>
  <?php endif; ?>  
  <?php if( !empty($this->categoryMenu["categorySubscriptions"])): ?>
    <li><a href='<?php echo $this->categoryMenu["categorySubscriptions"]["link"] ?>'>
      <?php echo $this->categoryMenu["categorySubscriptions"]["label"] ?></a>
    </li>
  <?php endif; ?>  
  <?php foreach( $this->customCategoryMenuPoints as $menuPoint ): ?>
    <li><a href='<?php echo $menuPoint["link"] ?>'>
      <?php echo $menuPoint["label"] ?></a>
    </li>
  <?php endforeach; ?>    
</ul>
