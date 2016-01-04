<?php defined('_NOAH') or die('Restricted access'); ?>
<?php // The category boxes only take the full width if there are at least $this->categoryColumnsNum boxes:
  $tableWidth = "100%";
  $categories =& $this->get("categories");
  $catNum=count($categories);
  $categoryColumnsNum =& $this->get("categoryColumnsNum");
  $oneCatWidth = 100/$categoryColumnsNum; 
  $alternatingColorsNum = 4;  // one different color for each column
?>
<?php if( $catNum ): /* if there are category boxes at all */ ?>
  <table cellspacing='0' class='catGrid' width='<?php echo $tableWidth ?>'>
    <?php for( $i=0; $i<$catNum; $i++ ): ?>
      <?php if( ($i % $categoryColumnsNum) == 0 ): /* new row necessary */ ?>
        <tr>
      <?php endif; ?>
          <td width='<?php echo $oneCatWidth ?>%' class='catColor<?php echo $i % $alternatingColorsNum ?>'>
            <div class='catTitle'>
              <a href='<?php echo $categories[$i]->link ?>'><?php echo $categories[$i]->title ?> [<?php echo $categories[$i]->itemNum ?>]</a> 
            </div>   
            <?php if($categories[$i]->picture): ?>
              <div class='catPicture'>
                <a href='<?php echo $categories[$i]->link ?>'><img src='<?php echo $categories[$i]->picture ?>'></a> 
              </div> 
            <?php endif; ?>
            <?php if($categories[$i]->description): ?>
              <div class='catDescription'>
                <div><?php echo $categories[$i]->description ?></div> 
              </div> 
            <?php endif; ?>
          </td>
      <?php if( (($i+1) % $categoryColumnsNum) == 0): /* row end necessary */ ?>
        </tr>
      <?php endif; ?>  
    <?php endfor; ?>
    <?php if( ($colspNum = $i % $categoryColumnsNum) > 0): /* filling the rest of the row with an empty td */ ?>
          <td colspan='<?php echo $colspNum ?>'></td>
        </tr>  
    <?php endif; ?>
  </table>
<?php endif; ?>

<?php  // displaying the advertisements if there are any:
    $this->displayContent("advertisementList"); 
?>
