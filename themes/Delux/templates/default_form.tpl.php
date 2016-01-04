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
          <?php for( $i=0, $alt=0; $i<count($this->rows); $i++, $alt=$i%2):
                $row=$this->rows[$i];
          ?>
            <?php if( $row['type']=='section' ): ?>
              <tr class='row' <?php echo @$row['relation'] ?>>
                <td class='separator' name='<?php echo $row['attr'] ?>' colspan='2'><?php echo $row['field'] ?></td>
              </tr>  
            <?php elseif( $row['type']=='txtsection' ): ?>
              <tr class='row' <?php echo @$row['relation'] ?>>
                <td class='cell<?php if( $this->zebraForm ) echo $alt ?>' name='<?php echo $row['attr'] ?>' colspan='2'><?php echo $row['field'] ?></td>
              </tr>  
            <?php elseif( $row['type']=='freepart' ): ?>
              <?php echo $row['field'] ?>
            <?php else: ?>
              <tr class='row' <?php echo @$row['relation'] ?>>
                <?php if( !empty($row['widecontent'] )): ?>
                  <td class='cell<?php if( $this->zebraForm ) echo $alt ?>' colspan='2'>
                    <span class='label'><?php echo $row['label'] ?></span>
                <?php else: ?>  
                  <td class='label<?php if( $this->zebraForm ) echo $alt ?>'>
                    <?php echo $row['label'] ?>
                <?php endif; ?>  
                <?php if( !empty($row['expl']) ): ?>
                  <br><span class='expl'><?php echo $row['expl'] ?></span>
                <?php endif; ?>
                <?php if( !empty($row['widecontent']) ): ?>
                  <br>
                <?php else: ?>  
                  </td>
                  <td class='cell<?php if( $this->zebraForm ) echo $alt ?>' name='<?php echo $row['attr'] ?>'>
                <?php endif; ?>  
                <?php if( !empty($row['embedField']) ): ?>
                  <?php echo sprintf($row['embedField'], $row['field']) ?>
                <?php else: ?>
                  <?php echo $row['field'] ?>
                <?php endif; ?>  
                <?php if( !empty($row['afterField']) ): ?>
                  <?php echo $row['afterField'] ?>
                <?php endif; ?>
                </td>
              </tr>
            <?php endif; ?>
          <?php endfor; ?>
        </tbody>
          <?php if( count($this->submits) ): ?>
            <tr>
              <td class='submitfooter' colspan='2'>
                <?php foreach( $this->submits as $submit ): ?>
                  <?php echo $submit ?>
                <?php endforeach; ?>    
              </td>
            </tr>
          <?php endif; ?>
      </table>
    </div>
  </div>
  <?php echo $this->additionalHiddens ?>
</form>
