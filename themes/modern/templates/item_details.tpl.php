<?php defined('_NOAH') or die('Restricted access'); ?>
<?php $friendOrResponseLinksExist = $this->get("responseLink") || $this->get("friendmailLink") || $this->get("flaggedLink"); ?>
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
        <?php for( $i=$k=$alt=$sideBarReady=0, $attrs=array_keys($this->rows); $i<count($this->rows); $i++, $alt=$k%2):
            $row=$this->rows[$attrs[$i]];
            $customCss=@$this->customCss[$attrs[$i]];
            if( in_array($attrs[$i], $this->sideBarContent["fields"]) ) continue;
        ?>
          <?php foreach( $row as $key=>$value): ?>
            <?php if( $key=='label' ): ?>
              <tr>
                <td class='label<?php if( $this->zebraDetails ) echo $alt ?>'><?php echo $value ?></td>
            <?php elseif( $key=='value' ): ?>
                <td class='cell<?php if( $this->zebraDetails ) echo $alt ?> <?php echo $customCss ?>'><?php echo $value ?></td>
            <?php elseif( $key=='separator' ): ?>
              <tr>
                <td class='separator <?php echo $customCss ?>' colspan='2'><?php echo $value ?></td>
            <?php elseif( $key=='widecontent' ): ?>
              <tr>
                <td class='cell<?php if( $this->zebraDetails ) echo $alt ?> <?php echo $customCss ?>' colspan='2'><?php echo $value ?></td>
            <?php endif; ?>
            <?php if( $key!='label' && !$sideBarReady && (count($this->sideBarContent["fields"]) || $this->mainPicture) ): ?>
              <td class='adDetailsSideBar' rowspan='<?php echo count($this->rows) + (int)$friendOrResponseLinksExist ?>'>
                <?php include $this->loadTemplate("item_details_sidebar.tpl.php"); ?>
              </td>
              <?php $sideBarReady=TRUE; ?>  
            <?php endif; ?>
            <?php if( $key!='label' ): ?>
              </tr>
            <?php endif; ?>  
          <?php endforeach; ?>
        <?php $k++; endfor; ?>
        <?php if( $friendOrResponseLinksExist ): ?>
          <tr>
            <td colspan='2' class='friendAndResponse'>
              <table>
                <tr>
                  <?php if( $this->get("flaggedLink") ): ?>
                    <td style='padding-right: 10px;'><div class='friend'><?php echo $this->get("flaggedLink") ?></div></td>
                  <?php endif; ?>  
                  <?php if( $this->get("responseLink") ): ?>
                    <td style='padding-left: 10px; padding-right: 10px;'><div class='friend'><?php echo $this->get("responseLink") ?></div></td>
                  <?php endif; ?>
                  <?php if( $this->get("friendmailLink") ): ?>
                    <td style='padding-left: 10px;'><div class='friend'><?php echo $this->get("friendmailLink") ?></div></td>
                  <?php endif; ?>  
                </tr>  
              </table>
            </td>  
          </tr>  
        <?php endif; ?>
        <?php if( $this->detailsMethods ): ?>
          <?php echo $this->detailsMethods ?>
        <?php endif; ?>
      </tbody>
    </table>
</div>  
