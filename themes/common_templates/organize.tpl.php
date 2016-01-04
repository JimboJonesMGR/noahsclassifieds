<?php defined('_NOAH') or die('Restricted access');     
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));     
?>


<div id='checkconf'>
  <p class='confok'>
    <a href='index.php?cat/organize_form/alternative'>Click here</a> to use an alternative organizer interface if you find the current one uncomfortalbe or failing!
  </p>  
</div>

<div id="organize_widget" class='template'></div>


