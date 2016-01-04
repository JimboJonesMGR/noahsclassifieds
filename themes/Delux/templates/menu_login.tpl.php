<?php defined('_NOAH') or die('Restricted access'); ?>

<div id="menu">
    <div id="first_menu" class="left">
        <?php if (!empty($this->loginMenu["mainSite"])): ?>
            <span class="left_first_menu"></span><a class='noindent' href='<?php echo $this->loginMenu["mainSite"]["link"] ?>'>
            <?php echo $this->loginMenu["mainSite"]["label"] ?></a>
        <span class="right_first_menu"></span>
        <?php endif; ?>  
        <?php if (!empty($this->loginMenu["home"])): ?>
                <span class="left_first_menu"></span><a class='noindent' href='<?php echo $this->loginMenu["home"]["link"] ?>'>
            <?php echo $this->loginMenu["home"]["label"] ?></a>
            <span class="right_first_menu"></span>            
        <?php endif; ?>  
        <!--<?php if (!empty($this->loginMenu["register"])): ?>
                    <span class="left_first_menu"></span><a href='<?php echo $this->loginMenu["register"]["link"] ?>'>
            <?php echo $this->loginMenu["register"]["label"] ?></a>
                <span class="right_first_menu"></span>                        
        <?php endif; ?> -->
        <?php if (!empty($this->loginMenu["login"])): ?>
                        <span class="left_first_menu"></span><a href='<?php echo $this->loginMenu["login"]["link"] ?>'>
            <?php echo $this->loginMenu["login"]["label"] ?></a>
                    <span class="right_first_menu"></span>                                    
        <?php endif; ?>  
        <!--<?php if (!empty($this->loginMenu["logout"])): ?>
                            <span class="left_first_menu"></span><a href='<?php echo $this->loginMenu["logout"]["link"] ?>'>
            <?php echo $this->loginMenu["logout"]["label"] ?></a>
                        <span class="right_first_menu"></span>                                                
        <?php endif; ?>-->
        <?php if (!empty($this->loginMenu["addAd"])): ?>
                                <span class="left_first_menu"></span><a href='<?php echo $this->loginMenu["addAd"]["link"] ?>'>
            <?php echo $this->loginMenu["addAd"]["label"] ?></a>
                            <span class="right_first_menu"></span>                                                            
        <?php endif; ?>  
        <?php if (!empty($this->loginMenu["searchAds"])): ?>
                                    <span class="left_first_menu"></span><a href='<?php echo $this->loginMenu["searchAds"]["link"] ?>'>
            <?php echo $this->loginMenu["searchAds"]["label"] ?></a>
                                <span class="right_first_menu"></span>                                                                            
        <?php endif; ?> 
        <?php if (!empty($this->loginMenu["favorities"])): ?>
                                        <span class="left_first_menu"></span><a href='<?php echo $this->loginMenu["favorities"]["link"] ?>'>
            <?php echo $this->loginMenu["favorities"]["label"] ?></a>
                                    <span class="right_first_menu"></span>                                                                                    
        <?php endif; ?>  
        <?php foreach ($this->customLoginMenuPoints as $menuPoint): ?>
                                            <span class="left_first_menu"></span><a href='<?php echo $menuPoint["link"] ?>'>
            <?php echo $menuPoint["label"] ?></a>
                                        <span class="right_first_menu"></span>                                                                                                
        <?php endforeach; ?>    

    </div>                                                                        
    <ul id="secound_menu" class="right">                                                                        

    </ul>
    <div class="clear">

    </div>

</div>
