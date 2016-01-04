<?php defined('_NOAH') or die('Restricted access'); ?>
<form method='POST' action='<?php echo $this->scriptName ?>' <?php echo $this->formAttrs ?>>
  <?php echo $this->hiddens ?>
  <div class='template formTemplate' id='<?php echo $this->listAndMethod ?>'>
    <div class='forCurvyFooter'>
      <table <?php if( !empty($this->tableClass) ) echo "class='$this->tableClass'" ?>>
        <caption>
          <span class='title'><?php echo $this->title ?></span>
        </caption>
        <tbody>                
          <?php if( !empty($this->confirmation) ): ?>
            <tr>
                <td class='separator' colspan='2'><?php echo $this->confirmation ?></td>
            </tr>
          <?php endif; ?>
          <tr>
            <td class='submitfooter' colspan='2'>
              <?php foreach( $this->submits as $submit ): ?>
                <?php echo $submit ?>
              <?php endforeach; ?>    
            </td>
          </tr>
        </tbody>
      </table>
    </div>  
  </div>  
</form>            
