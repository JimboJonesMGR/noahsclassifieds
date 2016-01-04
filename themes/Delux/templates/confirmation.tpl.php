<?php defined('_NOAH') or die('Restricted access'); ?>
<div class='template confirmationTemplate'>
  <div class='forCurvyFooter'>
    <div class='confirmationHeader'>
      <?php echo $this->title ?>
    </div>  
    <div class='confirmationContent'>
      <?php echo $this->content ?>
    </div>  
    <div class='confirmationFooter'>
      <?php foreach( $this->submits as $submit ): ?>
        <?php echo $submit ?>
      <?php endforeach; ?>    
    </div>  
  </div>  
</div>  

