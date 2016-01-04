<?php 
  $maxTitleLength = 23; 
?>

<!-- root element for scrollable --> 
<div class="scrollable <?php echo $this->orientation ?>" id="scrollable<?php echo $this->id ?>"> 
     
  <!-- those small round navigational buttons are auto- generated. styled with CSS --> 
  <div class="navi"></div> 
   
  <!-- "prev page" link is generated here. styling with CSS --> 
  <a class="prev"></a>     
   
  <!-- container for the scrollable items --> 
  <div class="items <?php echo $this->orientation ?>"> 
    <?php for( $i=$altMain=0; $i<count($this->cells); $i++, $altMain=$i%2): ?>
      <div class='item'>
        <a href='<?php echo $this->cells[$i]["link"] ?>'>
          <div class='title'>
            <?php echo $this->applyDisplayLengthLimit($this->cells[$i]["title"], $maxTitleLength) ?>
          </div>
        </a>  
        
        <div class='inner'>
            <?php for( $j=$k=$alt=0; $j<count($this->cells[$i]["rows"]); $j++, $alt=$k%2): $row=$this->cells[$i]["rows"][$j]; ?>
              <?php if($row["class"]=="picture"): ?>
                <div class='<?php echo $row["class"] ?>'>
                  <a href='<?php echo $this->cells[$i]["link"] ?>'><?php echo $row["value"] ?></a> 
                </div>
              <?php else: ?>
                <a href='<?php echo $this->cells[$i]["link"] ?>'><?php echo $row["value"] ?></a> 
                <?php if($row["value"] && !empty($this->cells[$i]["rows"][$j+1])): ?>
                  <hr>
                <?php endif; ?>  
              <?php endif; ?>
            <?php endfor; ?>
        </div>  
         
      </div>
    <?php endfor; ?>
  </div> 
   
  <!-- "prev page" link --> 
  <a class="next"></a> 
     
</div> 
