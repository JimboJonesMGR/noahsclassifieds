<?php defined('_NOAH') or die('Restricted access'); ?>
<div class='template detailsTemplate' id='<?php echo $this->listAndMethod ?>'>
  <table <?php if( !empty($this->tableClass) ) echo "class='$this->tableClass'" ?>>
    <?php if($this->title): ?>
      <caption>
        <span class='title'><?php echo $this->title ?></span>
        <?php if( count($this->headerMethods) ): ?>
          <span class='headermethod'>
            <?php echo implode(" | \n", $this->headerMethods) ?>
          </span>
        <?php endif; ?>
      </caption>
    <?php endif; ?>  
    <tbody>
      <?php for( $i=0, $alt=0, $attrs=array_keys($this->rows); $i<count($this->rows); $i++, $alt=$i%2):
          $row=$this->rows[$attrs[$i]];
      ?>
        <?php foreach( $row as $key=>$value): ?>
          <?php if( $key=='label' ): ?>
            <tr>
              <td class='label<?php if( $this->zebraDetails ) echo $alt ?>'><?php echo $value ?></td>
          <?php elseif( $key=='value' ): ?>
              <td class='cell<?php if( $this->zebraDetails ) echo $alt ?>'><?php echo $value ?></td>
          </tr>
          <?php elseif( $key=='separator' ): ?>
            <tr>
              <td class='separator' colspan='2'><?php echo $value ?></td>
            </tr>  
          <?php elseif( $key=='widecontent' ): ?>
            <tr>
              <td class='cell<?php if( $this->zebraDetails ) echo $alt ?>' colspan='2'><?php echo $value ?></td>
            </tr>  
          <?php elseif( $key=='notable' ): ?>
            </tbody>
              </table>
              <?php echo $value ?>
              <table>
            <tbody>    
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endfor; ?>
      <?php if( $this->detailsMethods ): ?>
        <?php echo $this->detailsMethods ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>  
