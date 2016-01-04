<?php defined('_NOAH') or die('Restricted access'); ?>
<div style="clear:both"></div>
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
      <div class='forCurvyFooter'>
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
              <?php foreach( $this->colHeaders as $i=>$value): ?>
                <th class='colheader <?php echo $this->colHeaderClasses[$i] ?>' <?php echo $this->colHeaderAttrs[$i] ?>><?php echo $this->colHeaders[$i] ?></th>
              <?php endforeach; ?>    
            </tr>
            <?php if( count($this->filterHeaders) ): ?>
              <tr class='filterheader'>
                <?php foreach( $this->filterHeaders as $i=>$value): ?>
                  <th class='filterheader'><?php echo $this->filterHeaders[$i] ?></th>
                <?php endforeach; ?>    
              </tr>
            <?php endif; ?>
          </thead>
          <tbody>                
            <?php for( $i=$alt=0; $i<count($this->cells); $i++, $alt=$i%2): ?>
              <tr class='row <?php if( isset($this->rowClasses[$i]) ) echo $this->rowClasses[$i] ?>'>
                <?php if( isset($this->listMethods[$i]) ): ?>
                  <td class='cell<?php if( $this->zebraList ) echo $alt ?> listmethod'>
                    <?php echo implode(" | \n", $this->listMethods[$i]) ?>
                  </td>
                <?php endif; ?>
                <?php for( $j=0; $j<count($this->cells[$i]); $j++): ?>
                  <?php // Calculating the colspans and rowspans of the cells based on $this->cellSpans
                    if( $this->cellSpans[$j]=='colspan' ) 
                    {
                        if( !$this->emptyList ) echo "</tr><tr class='row newline'>";
                        $colspan = $this->numberOfCellsInNoSpan + $this->numberOfToolsCells;
                        if( $this->emptyList ) $colspan = $colspan + $this->numberOfCellsInRowSpan;
                        $rowspan = 1;
                    }
                    elseif( $this->cellSpans[$j]=='rowspan' )
                    {
                        $colspan = 1;
                        $rowspan = $this->numberOfCellsInColSpan;
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
                <?php endfor; ?>
              </tr>
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
    </div>
<?php if( $this->wrapForm ): ?>
  <?php echo $this->additionalHiddens ?>
  </form>
<?php endif; ?> 