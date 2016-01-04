<?php defined('_NOAH') or die('Restricted access'); global $lll; 
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));     
?>

<div id='checkconf'>
  <h1><?php echo $this->get("checkTitle"); ?></h1>
  <?php foreach($this->get("report") as $report): ?>
    <p class='<?php echo $report[1] ?>'><?php echo $report[0] ?></p>
  <?php endforeach; ?>
  <form method='POST' action='index.php' ENCTYPE='multipart/form-data'>
    <input type='hidden' id='list' name='list' value='checkconf'> 
    <input type='hidden' id='method' name='method' value='do_register'>
    <table cellpaddin='10' cellspacing='10' border='0' width='50%'>
      <tr>
        <td><?php echo $lll["reg_companyName"] ?>:</td><td><input type='text' name='company' value='<?php echo $this->get("company") ?>'></td>
      </tr>  
      <tr>
        <td><?php echo $lll["reg_firstName"] ?>:</td><td><input type='text' name='firstName' value='<?php echo $this->get("firstName") ?>'></td>
      </tr>  
      <tr>
        <td><?php echo $lll["reg_lastName"] ?>:</td><td><input type='text' name='lastName' value='<?php echo $this->get("lastName") ?>'></td>
      </tr>  
      <tr>
        <td><?php echo $lll["reg_email"] ?>:</td><td><input type='text' name='email' value='<?php echo $this->get("email") ?>'></td>
      </tr>  
      <tr>
        <td></td><td><input type='submit' name='submit' value='<?php echo $lll["reg_submit"] ?>'></td>
      </tr>  
    </table>  
  </form>  
</div>
