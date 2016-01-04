<?php defined('_NOAH') or die('Restricted access'); ?>
<?php if( $this->pager ): ?>
  <ul class='pager'>
    <?php foreach( $this->pager as $item ): ?>
      <li><?php echo $item ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<?php if( $this->wrapForm ): ?>
  <form method='POST' action='<?php echo $this->scriptName ?>' <?php echo $this->formAttrs ?>>
    <?php echo $this->hiddens ?>
<?php endif; ?>    
    <div class='template' id='<?php echo $this->listAndMethod ?>'>
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
          <thead>
            <tr>
              <?php
                // So that we can display the Picture in the first column (because the rowspanned fields like the Picture just arrive on the end of the column order, we must reverse it) 
                $indexesOfTheReverseOrder = array_merge($this->indexesOfCellsInRowSpan, $this->indexesOfCellsInNoSpan);
                foreach( $indexesOfTheReverseOrder as $i): 
              ?>
                <th class='colheader <?php echo $this->colHeaderClasses[$i] ?>' <?php echo $this->colHeaderAttrs[$i] ?>><?php echo $this->colHeaders[$i] ?></th>
              <?php endforeach; ?>    
            </tr>
          </thead>
          <tbody>                
            <?php
              // adding the colspanned cell indexes, too:
              $indexesOfTheReverseOrder = $this->emptyList ? array(0) : array_merge($indexesOfTheReverseOrder, $this->indexesOfCellsInColSpan);
              $numberOfColumns = count($indexesOfTheReverseOrder);
              for( $i=$alt=0; $i<count($this->cells); $i++, $alt=$i%2):
            ?>
              <tr class='row <?php if( isset($this->rowClasses[$i]) ) echo $this->rowClasses[$i] ?>'>
                <?php foreach( $indexesOfTheReverseOrder as $j ): ?>
                  <?php // Calculating the colspans and rowspans of the cells based on $this->cellSpans
                    if( $this->cellSpans[$j]=='colspan' ) 
                    {
                        if( !$this->emptyList ) echo "</tr><tr class='row newline'>";
                        $colspan = $this->numberOfCellsInNoSpan;
                        if( $this->emptyList ) $colspan = $colspan + $this->numberOfCellsInRowSpan;
                        $rowspan = 1;
                    }
                    elseif( $this->cellSpans[$j]=='rowspan' )
                    {
                        $colspan = 1;
                        $rowspan = $this->numberOfCellsInColSpan + 1;
                        if( $this->numberOfCellsInNoSpan > 0 ) $rowspan = $rowspan + 1;
                    }
                    elseif( $this->cellSpans[$j]=='no' ) $colspan = $rowspan = 1;
                  ?>  
                  <td 
                    class='cell<?php if( $this->zebraList ) echo $alt ?> <?php echo $this->cellClasses[$i][$j] ?>' 
                    colspan='<?php echo $colspan ?>' 
                    rowspan='<?php echo $rowspan ?>'
                    <?php echo $this->cellAttrs[$j] ?> 
                  >
                    <?php echo $this->cells[$i][$j] ?>
                  </td>
                <?php endforeach; ?>
              </tr>
              <?php if( !$this->emptyList ): ?>
                <tr class='toolRow'>
                  <td class='cell<?php if( $this->zebraList ) echo $alt ?> listmethod' colspan='<?php echo $this->numberOfCellsInNoSpan ?>' style='text-align: right;'>
                    <div style='float: left; width: 50%; text-align: left;'>
                      <?php if( isset($this->listMethods[$i]) ): ?>
                        <?php echo implode(" | \n", $this->listMethods[$i]) ?>
                      <?php endif; ?>
                    </div>  
                    <div style='float: right; width: 50%; text-align: right;'>
                      <?php /* So that the 'Created' ad 'Owner' fields are nicely displayed here (E.g.: Posted: 2009-04-07 by john),
                               you must edit the corresponding custom fields and check their 'Custom placement in lists' property! */         
                      ?>
                      <?php if( !empty($this->cellsByNames[$i]['Created']) ): ?>
                        Posted: <?php echo $this->cellsByNames[$i]['Created'] ?>
                      <?php endif; ?>  
                      <?php if( !empty($this->cellsByNames[$i]['Owner']) ): ?>
                        by <?php echo $this->cellsByNames[$i]['Owner'] ?>
                      <?php endif; ?>  
                    </div>
                  </td>  
                </tr>
              <?php endif; ?>  
            <?php endfor; ?>
          </tbody>
            <?php if( $this->wrapForm && count($this->submits) ): ?>
              <tr>
                <td class='submitfooter' colspan='<?php echo count($this->colHeaders); ?>'>
                  <?php foreach( $this->submits as $submit ): ?>
                    <?php echo $submit ?>
                  <?php endforeach; ?>    
                </td>
              </tr>
            <?php endif; ?>
        </table>
    </div>
<?php if( $this->wrapForm ): ?>
  <?php echo $this->additionalHiddens ?>
  </form>
<?php endif; ?> 