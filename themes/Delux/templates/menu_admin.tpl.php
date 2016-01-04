<?php defined('_NOAH') or die('Restricted access'); ?>
            <?php if( !empty($this->adminMenu["controlPanel"])): ?>
              <a href='<?php echo $this->adminMenu["controlPanel"]["link"] ?>'>
                <?php echo $this->adminMenu["controlPanel"]["label"] ?></a>
              
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["myProfile"])): ?>
              <a href='<?php echo $this->adminMenu["myProfile"]["link"] ?>'>
                <?php echo $this->adminMenu["myProfile"]["label"] ?></a>
              
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["checkConfiguration"])): ?>
              <a href='<?php echo $this->adminMenu["checkConfiguration"]["link"] ?>'>
                <?php echo $this->adminMenu["checkConfiguration"]["label"] ?></a>
              
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["adminHelp"])): ?>
              <a href='<?php echo $this->adminMenu["adminHelp"]["link"] ?>'>
                <?php echo $this->adminMenu["adminHelp"]["label"] ?></a>
              
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["merchants"])): ?>
              <a href='<?php echo $this->adminMenu["merchants"]["link"] ?>'>
                <?php echo $this->adminMenu["merchants"]["label"] ?></a>
              
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["checkUpdates"])): ?>
              <a href='<?php echo $this->adminMenu["checkUpdates"]["link"] ?>'>
                <?php echo $this->adminMenu["checkUpdates"]["label"] ?></a>
              
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["registerNoah"])): ?>
              <a href='<?php echo $this->adminMenu["registerNoah"]["link"] ?>'>
                <?php echo $this->adminMenu["registerNoah"]["label"] ?></a>
              
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["purchaseHistory"])): ?>
              <a href='<?php echo $this->adminMenu["purchaseHistory"]["link"] ?>'>
                <?php echo $this->adminMenu["purchaseHistory"]["label"] ?></a>
              
            <?php endif; ?>  
            <?php foreach( $this->customAdminMenuPoints as $menuPoint ): ?>
              <a href='<?php echo $menuPoint["link"] ?>'>
                <?php echo $menuPoint["label"] ?></a>
              
            <?php endforeach; ?>    

