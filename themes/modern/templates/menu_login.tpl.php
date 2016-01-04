<?php defined('_NOAH') or die('Restricted access'); ?>
<table>
  <tr>
    <?php if( !empty($this->loginMenu["mainSite"])): ?>
      <td><div class='loginMenu'><a class='noindent' href='<?php echo $this->loginMenu["mainSite"]["link"] ?>'>
        <?php echo $this->loginMenu["mainSite"]["label"] ?></a>
      </div></td>
    <?php endif; ?>  
    <?php if( !empty($this->loginMenu["home"])): ?>
      <td><div class='loginMenu'><a class='noindent' href='<?php echo $this->loginMenu["home"]["link"] ?>'>
        <?php echo $this->loginMenu["home"]["label"] ?></a>
      </div></td>
    <?php endif; ?>  
    <?php if( !empty($this->loginMenu["register"])): ?>
      <td><div class='loginMenu'><a href='<?php echo $this->loginMenu["register"]["link"] ?>'>
        <?php echo $this->loginMenu["register"]["label"] ?></a>
      </div></td>
    <?php endif; ?>  
    <?php if( !empty($this->loginMenu["login"])): ?>
      <td><div class='loginMenu'><a href='<?php echo $this->loginMenu["login"]["link"] ?>'>
        <?php echo $this->loginMenu["login"]["label"] ?></a>
      </div></td>
    <?php endif; ?>  
    <?php if( !empty($this->loginMenu["logout"])): ?>
      <td><div class='loginMenu'><a href='<?php echo $this->loginMenu["logout"]["link"] ?>'>
        <?php echo $this->loginMenu["logout"]["label"] ?></a>
      </div></td>
    <?php endif; ?>  
    <?php if( !empty($this->loginMenu["addAd"])): ?>
      <td><div class='loginMenu'><a href='<?php echo $this->loginMenu["addAd"]["link"] ?>'>
        <?php echo $this->loginMenu["addAd"]["label"] ?></a>
      </div></td>
    <?php endif; ?>  
    <?php if( !empty($this->loginMenu["searchAds"])): ?>
      <td><div class='loginMenu'><a href='<?php echo $this->loginMenu["searchAds"]["link"] ?>'>
        <?php echo $this->loginMenu["searchAds"]["label"] ?></a>
      </div></td>
    <?php endif; ?>  
    <?php if( !empty($this->loginMenu["favorities"])): ?>
      <td><div class='loginMenu'><a href='<?php echo $this->loginMenu["favorities"]["link"] ?>'>
        <?php echo $this->loginMenu["favorities"]["label"] ?></a>
      </div></td>
    <?php endif; ?>  
    <?php foreach( $this->customLoginMenuPoints as $menuPoint ): ?>
      <td><div class='loginMenu'><a href='<?php echo $menuPoint["link"] ?>'>
        <?php echo $menuPoint["label"] ?></a>
      </div></td>
    <?php endforeach; ?>    
  </tr>
</table>

