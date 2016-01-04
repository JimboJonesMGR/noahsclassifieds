<?php defined('_NOAH') or die('Restricted access'); ?>
<?php if( count($this->sideBarContent["top"]) ): ?>
  <div class='sideBarTop'>
    <?php foreach( $this->sideBarContent["top"] as $value ): ?>
      <div><?php echo $value ?></div>
    <?php endforeach; ?>  
  </div>
<?php endif; ?>  
<?php if( $this->mainPicture ):
  $pictureColumnsNum = 3;
  $picNum = count($this->pictures);
?>
  <table class='pictures'>
    <tr>
      <td class='mainpic' colspan='<?php echo $pictureColumnsNum ?>'><?php echo $this->mainPicture['tag'] ?></td>
    </tr> 
    <?php if( $picNum>1 ): /* if we have only one picture, displaying it as the main is enough */ ?>
      <?php for( $j=0; $j<$picNum; $j++ ): ?>
        <?php if( ($j % $pictureColumnsNum) == 0 ): /* new row necessary */ ?>
          <tr>
        <?php endif; ?>
          <td width='<?php echo round(100/$pictureColumnsNum) ?>%' class='smallpic'><?php echo $this->pictures[$j]['tag'] ?></td>
        <?php if( (($j+1) % $pictureColumnsNum) == 0): /* row end necessary */ ?>
          </tr>
        <?php endif; ?>  
      <?php endfor; ?>
      <?php if( $picNum % $pictureColumnsNum ): ?>
        <?php for( $j=0; $j<$pictureColumnsNum - ($picNum % $pictureColumnsNum); $j++ ): /* insert empty td-s to fill the space */ ?>
          <td></td>
        <?php endfor; ?>
      <?php endif; ?>
    <?php endif; ?>  
  </table>
<?php endif; ?>  
<?php if( count($this->sideBarContent["bottom"]) ): ?>
  <div class='sideBarBottom'>
    <?php foreach( $this->sideBarContent["bottom"] as $value ): ?>
      <div><?php echo $value ?></div>
    <?php endforeach; ?>
  </div>  
<?php endif; ?>  
