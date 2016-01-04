<?php 
    global $lll;
    defined('_NOAH') or die('Restricted access'); 
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));         
?>
<div id='checkconf'>
  <?php if( $this->get("congrat")): ?>
    <h1><?php echo $this->get("congrat") ?></h1>
  <?php endif; ?>
  <h1><?php echo $lll["systemConfCheck"] ?></h1>
  <?php if( $this->get("congrat") || $this->get("clickToDisappear")): ?>
    <p class='confok'>
      Note: if after the installation, you get 'Error 400' pages when you click on any links, 
      please read the following page for the solution: 
      <a href='http://noahsclassifieds.org/documentation/configuration/rewriterules' target='_blank'>http://www.noahsclassifieds.org/documentation/configuration/rewriterules</a>
    </p>
  <?php endif; ?>    
  <?php foreach($this->get("report") as $report): ?>
    <p class='<?php echo $report[1] ?>'><?php echo $report[0] ?></p>
  <?php endforeach; ?>
  <?php if( !$this->get("rewriteOn") ): ?>
    <br>
    <h1><?php echo $lll["niceURLFeature"] ?></h1>
    <?php echo $lll["niceURLFeature_1"] ?>
    <pre>
    http://your.classifieds.site/item/10
    </pre>
    <?php echo $lll["niceURLFeature_2"] ?>
    <pre>
    http://your.classifieds.site/index.php?item/10
    </pre>
    <?php echo $lll["niceURLFeature_3"] ?><br><br>
    <?php if( $this->get("rewriteModuleEnabled")=="unsure" ): ?>
      <?php echo sprintf($lll["niceURLFeature_4"], "<span class='varName'>mod_rewrite</span>") ?>
    <?php endif; ?>
    <?php if( $this->get("rewriteModuleEnabled") ): ?>
      <?php echo sprintf($lll["niceURLFeature_5"], "<span class='varName'>mod_rewrite</span>", "<span class='varName'>.htaccess</span>") ?> 
      <pre>
    &lt;IfModule mod_rewrite.c&gt;
      RewriteEngine on
      RewriteRule .* - [env=REWRITE_ON:1]
      RewriteCond %{REQUEST_FILENAME} !-d
      RewriteCond %{REQUEST_FILENAME} !-f 
      RewriteRule ^(.*)$ index.php?url=$1 [L]
    &lt;/IfModule&gt;
      </pre>
      <?php echo $lll["niceURLFeature_6"] ?>
    <?php else: ?>
      <?php echo sprintf($lll["niceURLFeature_9"], "<span class='varName'>mod_rewrite</span>") ?>
    <?php endif; ?>
  <?php endif; ?>
    <br>
    <br>
    <h1><?php echo $lll["captchaTest"] ?></h1>
    <?php echo $lll["captchaTest_1"] ?>
    <br>
    <div style='text-align: center; width:100%;'><?php  echo $this->get("captchaLink"); ?></div>
  <?php if( $this->get("instFileRemove") ): ?>
    <p class='conferr'><?php echo $this->get("instFileRemove") ?></p>
  <?php endif; ?>
  <br>
  <?php if( $this->get("appFileRemove") ): ?>
    <p class='confok'><?php echo $this->get("appFileRemoveExpl") ?></p>
    <p class='conferr'><?php echo $this->get("appFileRemove") ?></p>
  <?php endif; ?>
  <?php if( $this->get("backupFileRemove") ): ?>
    <p class='confok'><?php echo $this->get("backupFileRemoveExpl") ?></p>
    <p class='conferr'><?php echo $this->get("backupFileRemove") ?></p>
  <?php endif; ?>
  <br>
  <br>
  <?php if( $this->get("clickToDisappear")): ?>
    <p class='confexpl'>
      <?php echo $this->get("clickToDisappear") ?>
    </p>
  <?php endif; ?>    
</div>
