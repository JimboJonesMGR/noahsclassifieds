<?php defined('_NOAH') or die('Restricted access'); ?>
          <ul>
            <?php if( !empty($this->adminMenu["controlPanel"])): ?>
              <li><a href='<?php echo $this->adminMenu["controlPanel"]["link"] ?>'>
                <?php echo $this->adminMenu["controlPanel"]["label"] ?></a>
              </li>
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["myProfile"])): ?>
              <li><a href='<?php echo $this->adminMenu["myProfile"]["link"] ?>'>
                <?php echo $this->adminMenu["myProfile"]["label"] ?></a>
              </li>
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["checkConfiguration"])): ?>
              <li><a href='<?php echo $this->adminMenu["checkConfiguration"]["link"] ?>'>
                <?php echo $this->adminMenu["checkConfiguration"]["label"] ?></a>
              </li>
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["adminHelp"])): ?>
              <li><a href='<?php echo $this->adminMenu["adminHelp"]["link"] ?>'>
                <?php echo $this->adminMenu["adminHelp"]["label"] ?></a>
              </li>
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["merchants"])): ?>
              <li><a href='<?php echo $this->adminMenu["merchants"]["link"] ?>'>
                <?php echo $this->adminMenu["merchants"]["label"] ?></a>
              </li>
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["checkUpdates"])): ?>
              <li><a href='<?php echo $this->adminMenu["checkUpdates"]["link"] ?>'>
                <?php echo $this->adminMenu["checkUpdates"]["label"] ?></a>
              </li>
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["registerNoah"])): ?>
              <li><a href='<?php echo $this->adminMenu["registerNoah"]["link"] ?>'>
                <?php echo $this->adminMenu["registerNoah"]["label"] ?></a>
              </li>
            <?php endif; ?>  
            <?php if( !empty($this->adminMenu["purchaseHistory"])): ?>
              <li><a href='<?php echo $this->adminMenu["purchaseHistory"]["link"] ?>'>
                <?php echo $this->adminMenu["purchaseHistory"]["label"] ?></a>
              </li>
            <?php endif; ?>  
            <?php foreach( $this->customAdminMenuPoints as $menuPoint ): ?>
              <li><a href='<?php echo $menuPoint["link"] ?>'>
                <?php echo $menuPoint["label"] ?></a>
              </li>
            <?php endforeach; ?>    
          </ul>  

