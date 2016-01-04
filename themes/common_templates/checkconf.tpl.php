<?php 
    defined('_NOAH') or die('Restricted access'); 
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));         
?>
<div id='checkconf'>
  <h1><?php echo $this->get("checkTitle") ?></h1>
  <?php foreach($this->get("report") as $report): ?>
    <p class='<?php echo $report[1] ?>'><?php echo $report[0] ?></p>
  <?php endforeach; ?>
</div>
