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
  <?php if( $this->get("releaseNotes") ): ?>
    <br>
    <div id='releaseNotes'>
      <?php echo $this->get("releaseNotes") ?>
    </div>
  <?php endif; ?>
  <?php if( $this->get("updateAutomatic") ): ?> 
    <br>
    <br>
    <h1>By clicking on the below 'Update' button, you can perform an automatic update to the latest version of Noah's. If you prefer doing a manual update, <a href='http://noahsclassifieds.org/faq/item/45' target='_blank'>click here</a> to read about how to do it!</h1>
    <table class='chart'>
      <tr>
        <td>
          <p class='confok'>Steps of the update:</p>        
          <p class='confexpl'>
            <ol>
              <li>You click on the below 'Update' button,</li>
              <li>If you have the 3.2.0-RSS version or below, the program asks for the email address you purchased Noah's with. From the 4.0 version the installations are "licensed" and this step is necessary for that.</li>
              <li>The program downloads the list of files it is about to modify and checks if it has enough permission to write them. 
              If it has no write permission, it lists all the files you must grant write permission to and stops. 
              <a href='http://noahsclassifieds.org/faq/item/38' target='_blank'>Click here</a> to read about the proper file permissions in the Noah's installation directory!</li>
              <li>The program lists all the files it is about to modify or delete during the update</li>
              <li>You accept this by clinking on an other button</li>
              <li>The program makes a backup copy of the old files (if you happened to altered some of them (e.g. template files),
              this gives you a chance that you later "merge" your changes into the new files!)</li>
              <li>The program unpacks the new files and displays one more page with a 'Continue' button.</li>                
              <li>Clicking on that button, the necessary database changes will be performed, too and this completes the uptate process.</li>                
            </ol>
          </p>    
        </td>
      </tr>  
      <tr>
        <td>
          <form method='post' action='index.php'>
            <input type='hidden' name='list' value='checkconf'>
            <input type='hidden' name='method' value='do_update'>
            <p class='confok'>Click here to update to <?php echo $this->get("latestVersion") ?>:</p>
            <input class='updateButton' type='submit' name='automatic' value='<?php echo $this->get("updateAutomatic") ?>'>
          </form>
        </td>
      </tr>
    </table>  
  <?php endif; ?>
  <?php if( $this->get("branch")!="EComm" ): ?> 
    <br><br><br>
    <h1>You are currently using the <?php echo $this->get("branch") ?> version of the program.</h1>
    <p class='confok'>Click here to view the benefits of upgrading your program to the RSS or EComm version:</p>
    <a href='http://noahsclassifieds.org/documentation/chart'>Version comparison matrix</a>
  <?php endif; ?>
</div>
