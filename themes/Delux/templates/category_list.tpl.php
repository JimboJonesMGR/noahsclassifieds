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
<?php $cnt=1; ?>
<?php for( $i=0; $i<$catNum; $i++ ): ?>
<div class="list_cats_index left">
                    <div class="smalltitle">
                        <a href="<?php echo $categories[$i]->link ?>" class="tooltip" style="color:#E65709">
                                <?php echo $categories[$i]->title ?>
                            <span class="custom warning">
                            <img src="<?php echo $categories[$i]->picture ?>" alt="<?php echo $categories[$i]->title ?>" width="64" />
                            <em><?php echo $categories[$i]->title ?></em>
                            <?php echo $categories[$i]->description ?>
                        </span>
                        </a> (<?php echo $categories[$i]->itemNum ?>)</div>
    <?php $subcatNum = count($categories[$i]->subCats); ?>
    <?php if($subcatNum>0) : ?>
    <ul>
        <?php for( $x=0; $x<$subcatNum; $x++) : ?>
	<li>&raquo; <?php echo $categories[$i]->subCats[$x]['link'] ?></li>
<?php endfor; ?>
    </ul>
<?php endif; ?>
</div>
<?php $cnt++; ?>
    <?php if ($cnt==4){
        $cnt=1;
        echo "<div style='clear:both'></div><br/>";
    } ?>
<?php endfor; ?>
<?php endif; ?>

<?php  // displaying the advertisements if there are any:
    $this->displayContent("advertisementList");
?>
