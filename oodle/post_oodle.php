<?php
defined('_NOAH') or die('Restricted access');

include_once(NOAH_APP ."/item_typ.php");

@set_time_limit(0);

class Oodle
{
    function post_ads($serial="")
    {
        global $admin_id;
        global $returned;

        echo "<html><title>Noah's Classifieds - Oodle</title><body><center>";
        echo "<img src='".NOAH_BASE."/logo.gif' alt='NOAH'S CLASSIFIEDS'>";
        
        $_S = & new AppSettings();    
/*        
        if (($serial <> $_S->oodleSerial) or (empty($serial)))
        {
            echo("<p><b>Unauthorized use.</b></p>");
            echo "<p><input type=button value='<-- Go Back' onClick='history.go(-1)'></p></center></body></html>";
            die();
        }

        $returned=oodlelicensing::verifyOodle($_S->oodleSerial);
        if ($returned[status] != 'active')
        {
            echo "Invalid Oodle License. Please check your Noah settings.";
            echo "<p><input type=button value='<-- Go Back' onClick='history.go(-1)'></p></center></body></html>";
            die();
        }
*/
        $query = "SELECT id from @user WHERE isAdm = 1";
        $result = executeQuery($query); 
        if ($row = mysql_fetch_array($result))
        {
            $admin_id = $row['id'];
        }    

        // DELETE all previous oodle listings
        // yeah, yeah, having the ads load dynamically is a better option
        $query = "DELETE FROM @item WHERE oodleType = 1";
        executeQuery($query);

      
        // CLEAN out AUTOINCREMENT field
        $query = "ALTER TABLE @item AUTO_INCREMENT = 0";
        executeQuery($query);

        // Add Oodle Ads
//        echo "<pre>";
        echo "<table border= '1' bordercolor='FFCC00' style='background-color:FFFFCC' cellpadding='3' cellspacing='3'>";
        echo "<th>Noah Category</th><th>Oodle Category</th><th>Ads Inserted</th>";
        Oodle::addAds();
        echo "</table>";

        echo "<p><br /><input type=button value='<-- Go Back' onClick='history.go(-1)'></p></center></body></html>";
        
        $c = new AppCategory;
        $c->recalculateAllItemNums(TRUE);
    }

    function addAds()
    {

      global $latitude, $longitude, $cityName, $dbPrefix, $returned;

        $query = "select oodleLocation from @settings where enableOodle=1";
        $result = executeQuery($query); 

        if ($row = mysql_fetch_array($result))
        {
            $country = $row['oodleLocation'];
            $query = "select * from @category where enableOodle=1 order by sortID";
            $result = executeQuery($query); 
            while($row = mysql_fetch_array($result))
            {
                
                $url ='http://api.oodle.com/api/v2/listings?key=599F195CE912&format=php_serial'; //&region=sf&category='.$oodlecat.'&format=php_serial&num='.$count; 

                if ($row['oodleLocation']<>'')                                                    
                {
                    $url = $url.'&region='.$country."&location=".urlencode($row['oodleLocation']);   
                }
                else
                {
                    $url = $url.'&region='.$row['oodleRegion'];   
                }
  
                $url = $url.'&category='.$row['oodleCategory'];
                if ($row['oodleRadius']<>'') $url = $url.'&radius='.$row['oodleRadius'];
                if ($row['oodleSearch']<>'') $url = $url.'&q='.urlencode($row['oodleSearch']);
                
                $overNumber = FALSE;
  /*
                if ($row['oodleNum'] > $returned["limit"])
                {
                    $number = $returned["limit"];
                    $overNumber = TRUE;
                }
                else $number = $row['oodleNum'];
*/
                $number = $row['oodleNum'];
                if ($row['oodleNum']<>'') $url = $url.'&num='.$number;

                $addCount = Oodle::addOodleAds($row['id'],$url);
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['name']).'</td><td>'.$row['oodleCategory'].'</td><td>'.$addCount."</td>";
                echo "</tr>";
                if ($overNumber)
                {
                    echo "<tr>";
                    echo "<td colspan='3'><em><strong>Your subscription will only allow you to download a maximum of 10 ads for the ".$row['name']." cateogry.<br/>Please contact Noah to upgrade your subscription.</strong></em></td>";
                    echo "</tr>";
                }
            flush();
            unset($url);
            
            // wait for 5 seconds
//            usleep(5000000);
            }
        }  
    }

    function stristr_array( $haystack, $needle ) {
      if ($needle == '') return true;

      if ( !is_array( $needle ) ) {
        return false;
      }

      foreach ( $needle as $element ) {
        if ( stristr( $haystack, $element) ) {
          return true;
      
        }
      }
      return false;
    }

    function addOodleAds($noahcat, $url)
    {
      global $dontSetCreationTime, $admin_id, $oodleFieldValues;

try {
//print_r($url);
      
      $data = file_get_contents($url); 
      $response = unserialize($data); 

      unset($data);

//var_dump($data);
      
        $piccount=0;
      
      $dontSetCreationTime =TRUE;

      foreach ($response['listings'] as $key=>$ad) {
            $picprinted=false;
            $ad[attributes]['title'] = $ad[title];
            $ad[attributes]['body'] = $ad[body].'<br><br><b>via Oodle.com</b>';
               $ad[attributes]['ctime'] = date('Y-m-d G:i:s',$ad[ctime]);
               $ad[attributes]['image'] = $ad[images][0][src];
               $ad[attributes]['url'] = $ad[url];
            $ad[attributes]['id'] = $ad[id];
            
            $n = new Item;
            $n->cid = $noahcat;
            $n->creationtime = new Date($ad[attributes]['ctime']);
            $n->status=1;
            $n->oodleType=1;
            $n->oodleImageUrl=$ad[attributes]['image'];
            $n->oodleUrl=$ad[attributes]['url'];
            $n->oodleID=$ad[attributes]['id'];
            $n->ownerId=$admin_id;
            $query = "SELECT * FROM @customfield b where cid=$noahcat";
            $result = executeQuery($query); 
            while($row = mysql_fetch_array($result))
            {
                if ($row['oodleField']<>'')
                {
                    if (!is_null($oodleFieldValues[$ad[attributes][$row['oodleField']]])) {
                        $n->{$row['columnIndex']}=$oodleFieldValues[$ad[attributes][$row['oodleField']]];
                    } else $n->{$row['columnIndex']}=$ad[attributes][$row['oodleField']];
                }
            }
            $n->create(TRUE);
            unset($n);
            unset($result);

            $piccount++;
        } // END FOR

        unset($response);

        return $piccount;
 } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    flush();

 
 }
  

}

    function recalculateAllItemNums()
    {
        global $dbPrefix;

        $query = "SELECT * FROM @category WHERE up=0"; 
        $result = executeQuery($query); 
        while($row = mysql_fetch_array($result))
        {
            recalculateAllItemNumsCore($row['id']);
        }
    }

    function recalculateAllItemNumsCore($id)
    {
     
        getDbCount( $count, "SELECT COUNT(*) FROM @item WHERE cid=$id AND status=1");
        $directItemNum = $count;
        
        executeQuery("UPDATE @category SET directItemNum=$count WHERE id=$id");

        $query = "SELECT * FROM @category WHERE up=$id"; 

        $result = executeQuery($query); 
        while($row = mysql_fetch_array($result))
        {
          $subitemNum = recalculateAllItemNumsCore($row['id']);
          
          $itemNum+=$subitemNum;
        }
        // a teljes itemNumhoz a directItemNumot is hozza kell szamolni:
        $itemNum += $directItemNum; 
        // elmentjuk az itemNumot:
        executeQuery("UPDATE @category SET itemNum=$itemNum WHERE id=$id");

        return $itemNum;    
    }
}
?>
