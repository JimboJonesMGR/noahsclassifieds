<?php defined('_NOAH') or die('Restricted access'); ?>
<?php include(NOAH_APP . "/config.php");  ?>
<?php
/**
 * Function to ping Google Sitemaps. Returns an integer, e.g. 200 or 404,
 * 0 on error.
 * @return     integer            Status code, e.g. 200|404|302 or 0 on error
 */
function pingGoogleSitemaps( $url_xml ) {
    $status = 0;
    $google = 'www.google.com';
    if( $fp=@fsockopen($google, 80) ) {
        $req =  'GET /webmasters/sitemaps/ping?sitemap=' .
                urlencode( $url_xml ) . " HTTP/1.1\r\n" .
                "Host: $google\r\n" .
                "User-Agent: Mozilla/5.0 (compatible; " .
                PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
                "Connection: Close\r\n\r\n";
        fwrite( $fp, $req );
        while( !feof($fp) ) {
            if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) ) {
                $status = intval( $m[1] );
                break;
            }
        }
        fclose( $fp );
    }
    return( $status );
}

function pingBingSitemaps( $url_xml ) {
    $google = 'www.bing.com';
    if( $fp=@fsockopen($google, 80) ) {
        $req =  'GET /webmaster/ping.aspx?siteMap=' .
                urlencode( $url_xml ) . " HTTP/1.1\r\n" .
                "Host: $google\r\n" .
                "User-Agent: Mozilla/5.0 (compatible; " .
                PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
                "Connection: Close\r\n\r\n";
        fwrite( $fp, $req );
        while( !feof($fp) ) {
            if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) ) {
                $status = intval( $m[1] );
                break;
            }
        }
        fclose( $fp );
    }
    return( $status );
}
function pingAskSitemaps( $url_xml ) {
    $google = 'submissions.ask.com';
    if( $fp=@fsockopen($google, 80) ) {
        $req =  'GET /ping?sitemap=' .
                urlencode( $url_xml ) . " HTTP/1.1\r\n" .
                "Host: $google\r\n" .
                "User-Agent: Mozilla/5.0 (compatible; " .
                PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
                "Connection: Close\r\n\r\n";
        fwrite( $fp, $req );
        while( !feof($fp) ) {
            if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) ) {
                $status = intval( $m[1] );
                break;
            }
        }
        fclose( $fp );
    }
    return( $status );
}
function pingYahooSitemaps( $url_xml , $application_id) {
    $google = 'search.yahooapis.com';
    if( $fp=@fsockopen($google, 80) ) {
        $req =  'GET /SiteExplorerService/V1/updateNotification?appid=' . $application_id . "&url=" .
                urlencode( $url_xml ) . " HTTP/1.1\r\n" .
                "Host: $google\r\n" .
                "User-Agent: Mozilla/5.0 (compatible; " .
                PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
                "Connection: Close\r\n\r\n";
        fwrite( $fp, $req );
        while( !feof($fp) ) {
            if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) ) {
                $status = intval( $m[1] );
                break;
            }
        }
        fclose( $fp );
    }
    return( $status );
}
?>
<?php
$table = $dbPrefix . "sitemap";
$exist_table = mysql_num_rows(mysql_query("SHOW TABLES like '$table'"));
if ($exist_table) {
    
}
else {
    $create_table="CREATE TABLE " . $table ." (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
notifyGoogle TINYINT NOT NULL ,
notifyBing TINYINT NOT NULL ,
notifyAsk TINYINT NOT NULL ,
notifyYahoo TINYINT NOT NULL ,
yahookey VARCHAR(50) NOT NULL ,
sm_cf_categories VARCHAR(50) NOT NULL ,
sm_cf_items VARCHAR(50) NOT NULL ,
date INT NOT NULL ,
serial VARCHAR(32) NOT NULL ,
extra VARCHAR(500) NOT NULL
)";
    mysql_query($create_table) or die(mysql_error());
    
    $createline = 'INSERT INTO `' . $table . '`
                (`id`, `notifyGoogle`, `notifyBing`, `notifyAsk`, `notifyYahoo`, `yahookey`, `sm_cf_categories`, `sm_cf_items`, `date`, `serial`, `extra`)
                VALUES (1, 1, 1, 1, 1, "", "Always", "Always", 0, "", "");';
    $result_create_line = mysql_query($createline);
}
?>
<style type="text/css">
    .pr {
        float:left;
        width: 40%;
        padding-right: 10px;
    }
</style>
<form method="post" name="sitemap" action="">
    <div class='template formTemplate' id='user-login_form'>
            <table >
                <caption>
                    <span class='title'>Sitemap Settings</span>
                </caption>
                <tbody>
                    <tr class='row' >
                        <td class='label' colspan="2">Your sitemap was last built on :
                            <big style="color:green;"><?php
                                
                                echo date("F j, Y, g:i:s a",mysql_result(mysql_query("SELECT date FROM " . $table . " WHERE ID=1"),0));?></big>
                        </td>
                    </tr>
                    <tr class='row' >
                        <td class='separator' colspan="2">Notify Settings</td>
                    </tr>
                    <tr class='row' >
                        <td class='label' colspan="2">
                            <label for="notifyGoogle">
                                <input type='checkbox' id='notifyGoogle' name='notifyGoogle' value='1'
                                <?php
                                $notifyGoogle1 = mysql_result(mysql_query("SELECT notifyGoogle FROM " . $table . " WHERE ID=1"),0);
                                if ($notifyGoogle1==1) {
                                    echo 'checked="yes"';
                                       }?>>
                                Notify Google about updates of your site
                            </label>
                            <br/>
                            <small>No registration required, but you can join the
                                <a href="https://www.google.com/webmasters/tools">Google Webmaster Tools</a>
                                to check crawling statistics.
                            </small>
                        </td>
                    </tr>
                    <tr class='row' >
                        <td class='label' colspan="2">

                            <input type='checkbox' id='notifyBing' name='notifyBing' value='1'
                            <?php
                            $notifyBing1 = mysql_result(mysql_query("SELECT notifyBing FROM " . $table . " WHERE ID=1"),0);
                            if ($notifyBing1==1) {
                                echo 'checked="yes"';
                                   }?>>
                            Notify Bing (formerly MSN Live Search) about updates of your site
                            <br/>
                            <small>No registration required, but you can join the
                                <a href="http://www.bing.com/webmaster">Bing Webmaster Tools</a>
                                to check crawling statistics.
                            </small>
                        </td>
                    </tr>
                    <tr class='row' >
                        <td class='label' colspan="2">
                            <input type='checkbox' id='notifyAsk' name='notifyAsk' value='1'
                            <?php
                            $notifyAsk1 = mysql_result(mysql_query("SELECT notifyAsk FROM " . $table . " WHERE ID=1"),0);
                            if ($notifyAsk1==1) {
                                echo 'checked="yes"';
                                   }?>>
                            Notify Ask.com about updates of your site
                            <br/>
                            <small>No registration required.
                            </small>
                        </td>
                    </tr>
                    <tr class='row' >
                        <td class='label' colspan="2">
                            <input type='checkbox' id='notifyYahoo' name='notifyYahoo' value='1'
                            <?php
                            $notifyYahoo1 = mysql_result(mysql_query("SELECT notifyYahoo FROM " . $table . " WHERE ID=1"),0);
                            if ($notifyYahoo1==1) {
                                echo 'checked="yes"';
                                   }?>>
                            Notify YAHOO about updates of your site
                            <br/>
                            Your Application ID:
                            <input type="text" name="yahookey" id="yahookey" value="<?php echo $yahookey1 = mysql_result(mysql_query("SELECT yahookey FROM " . $table . " WHERE ID=1"),0); ?>" /><br/>
                            <small>Don't you have such a key?
                                <a href="https://login.yahoo.com/config/login?.src=devnet&.done=http%3A%2F%2Fdeveloper.yahoo.com%2F">Request one here</a>!
                                (<a href="http://developer.yahoo.net/about/">Web Services by Yahoo!</a>)
                            </small>
                        </td>
                    </tr>
                    <tr class='row' >
                        <td class='separator' colspan="2">Priorities</td>
                    </tr>
                    <tr class='row' >
                        <td class='label' colspan="2">
                            <ul>
                                <li class="pr">
                                    <label for="sm_pr_categories">
                                        <?php
                                        $sm_pr_categories1 = mysql_result(mysql_query("SELECT sm_pr_categories FROM " . $table . " WHERE ID=1"),0);
                                        ?>
                                        <select id="sm_pr_categories" name="sm_pr_categories" disabled>
                                            <option value="1">Auto</option>
                                        </select>
                                        Categories - <small>Uses the item count to calculate the priority</small>
                                    </label>
                                </li>
                                <li class="pr">
                                    <label for="sm_pr_items">
                                        <select id="sm_pr_items" name="sm_pr_items" disabled>
                                            <option value="1">Auto</option>

                                        </select>
                                        Items - <small>Uses the number of visits of the item to calculate the priority</small>
                                    </label>
                                </li>
                            </ul>

                        </td>
                    </tr>
                    <tr class='row' >
                        <td class='separator' colspan="2">Change Frequency</td>
                    </tr>
                    <tr class='row' >
                        <td class='label' colspan="2">

                            <ul>
                                <li class="pr">
                                    <label for="sm_cf_categories">
                                        <?php
                                        $sm_cf_categories1 = mysql_result(mysql_query("SELECT sm_cf_categories FROM " . $table . " WHERE ID=1"),0);
                                        ?>
                                        <select id="sm_cf_categories" name="sm_cf_categories">
                                            <option value="Always" <?php if($sm_cf_categories1=='Always') {
                                                echo '  selected="selected"';
                                                    } ?>>Always</option>
                                            <option value="Hourly" <?php if($sm_cf_categories1=='Hourly') {
                                                echo '  selected="selected"';
                                                    } ?>>Hourly</option>
                                            <option value="Daily" <?php if($sm_cf_categories1=='Daily') {
                                                echo '  selected="selected"';
                                                    } ?>>Daily</option>
                                            <option value="Weekly" <?php if($sm_cf_categories1=='Weekly') {
                                                echo '  selected="selected"';
                                                    } ?>>Weekly</option>
                                            <option value="Monthly" <?php if($sm_cf_categories1=='Monthly') {
                                                echo '  selected="selected"';
                                                    } ?>>Monthly</option>
                                            <option value="Yearly" <?php if($sm_cf_categories1=='Yearly') {
                                                echo '  selected="selected"';
                                                    } ?>>Yearly</option>
                                            <option value="Never" <?php if($sm_cf_categories1=='Never') {
                                                echo '  selected="selected"';
                                                    } ?>>Never</option>
                                        </select>
                                        Categories
                                    </label>
                                </li>
                                <li class="pr">
                                    <label for="sm_cf_items">
                                        <?php
                                        $sm_cf_items1 = mysql_result(mysql_query("SELECT sm_cf_items FROM " . $table . " WHERE ID=1"),0);
                                        ?>
                                        <select id="sm_cf_items" name="sm_cf_items">
                                            <option value="Always" <?php if($sm_cf_items1=='Always') {
                                                echo '  selected="selected"';
                                                    } ?>>Always</option>
                                            <option value="Hourly" <?php if($sm_cf_items1=='Hourly') {
                                                echo '  selected="selected"';
                                                    } ?>>Hourly</option>
                                            <option value="Daily" <?php if($sm_cf_items1=='Daily') {
                                                echo '  selected="selected"';
                                                    } ?>>Daily</option>
                                            <option value="Weekly" <?php if($sm_cf_items1=='Weekly') {
                                                echo '  selected="selected"';
                                                    } ?>>Weekly</option>
                                            <option value="Monthly" <?php if($sm_cf_items1=='Monthly') {
                                                echo '  selected="selected"';
                                                    } ?>>Monthly</option>
                                            <option value="Yearly" <?php if($sm_cf_items1=='Yearly') {
                                                echo '  selected="selected"';
                                                    } ?>>Yearly</option>
                                            <option value="Never" <?php if($sm_cf_items1=='Never') {
                                                echo '  selected="selected"';
                                                    } ?>>Never</option>
                                        </select>
                                        Items
                                    </label>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr class='row' >
                        <td class='label' colspan="2">
                            <?php
                            $ok = $_REQUEST["ok"];
                            if($ok) { ?>
                                <?php
                                echo "Start sitemap generating ...";
                                $update_date_run = mysql_query("UPDATE " . $table . " SET date ='" .time()."' WHERE ID = 1") or die('error: ' . mysql_error());
                                $update_notify_run = mysql_query("UPDATE " . $table .
                                        " SET notifyGoogle ='" . $_REQUEST["notifyGoogle"] .
                                        "'," . "notifyBing='" . $_REQUEST["notifyBing"] .
                                        "'," . "notifyAsk='" . $_REQUEST["notifyAsk"] .
                                        "'," . "notifyYahoo='" . $_REQUEST["notifyYahoo"] .
                                        "'," . "sm_cf_categories='" . $_REQUEST["sm_cf_categories"] .
                                        "'," . "sm_cf_items='" . $_REQUEST["sm_cf_items"] .
                                        "'," . "yahookey='" . $_REQUEST["yahookey"]
                                        ."' WHERE ID = 1") or die('error: ' . mysql_error());
                                $category_changefreq_category = $_REQUEST["sm_cf_categories"];
                                $category_changefreq_items = $_REQUEST["sm_cf_items"];
                                $obj = new Controller();
                                $counter=1;
                                $query01 = "SELECT clicked FROM @item ORDER BY clicked DESC LIMIT 1";
                                $result01 = executeQuery($query01) or die(mysql_error());
                                if ($row01 = mysql_fetch_array($result01)) {
                                        $most_click=$row01['clicked'];
                                }
                                $counter=1;
                                $query02 = "SELECT itemNum FROM @category ORDER BY itemNum DESC LIMIT 1";
                                $result02 = executeQuery($query02) or die(mysql_error());
                                if ($row02 = mysql_fetch_array($result02)) {
                                        $most_popular=$row02['itemNum'];
                                }
                                $xml="<?xml version='1.0' encoding='UTF-8' ?>";
                                $xml .="<?xml-stylesheet type='text/xsl' href='{$obj->getBaseUrl()}sitemap.xsl'?>";
                                $xml .='<urlset'."\n" . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'
                                        ."\n".'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"'
                                        ."\n".'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                                $query = "SELECT * FROM @category";
                                $result = executeQuery($query) or die(mysql_error());
                                while($row = mysql_fetch_array($result)) {
                                   $xml .='
                            <url>
                            <loc>' .$obj->getBaseUrl() . $row['permaLink'] . '</loc>
                            <lastmod>' . date_format(date_create($row['creationtime']),"Y-m-d\TH:i:sP") . '</lastmod>
                            <changefreq>' . strtolower($category_changefreq_category) . '</changefreq>
                            <priority>'; 
                                    if ($row['itemNum']==$most_popular) {
                                        $xml .= '1.0';
                                    }
                                    else {
                                        $item_pri=$most_popular/$row['itemNum'];
                                        $item_pri=1/$item_pri;
                                        $xml .= round($item_pri, 2);
                                        
                                    }               
                                    $xml .= '</priority>
                            </url>';
                            
                            $query = "SELECT columnindex FROM  @customfield WHERE seo=1";
                            $result = executeQuery($query); 
                            if ($item = mysql_fetch_array($result)) $title = $item[0];
                            $query = "Select id,$title,creationtime,clicked,oodleUrl FROM @item WHERE cid={$row['id']}";
                            $result = executeQuery($query); 
                            while ($item = mysql_fetch_array($result))
                            {
                                            if ($item['oodleID'])
                                            {
                                                $item_url = "O{$row1['oodleID']}_";
                                                $item_url = str_replace('/', '_', $item_url);
                                                $item_url = str_replace('&', '', $item_url);
                                                $item_url = str_replace('^', '', $item_url);
                                                $item_url = str_replace('%', '', $item_url);

                                            } else {
                                                
                                                $item_url = str_replace(' ', '_', $item[$title]);
                                                $item_url = str_replace('/', '_', $item_url);
                                                $item_url = str_replace('&', '', $item_url);
                                                $item_url = str_replace('^', '', $item_url);
                                                $item_url = str_replace('%', '', $item_url);
                                            
                                            }

                                            $item_url = $obj->getBaseUrl() . $row['permaLink'] . '/' . $item['id'] . '_'. $item_url;
                                            
                                            $xml .='
                                        <url>
                                        <loc>' . $item_url .'</loc>
                                        <lastmod>' . date_format(date_create($item['creationtime']),"Y-m-d\TH:i:sP") . '</lastmod>
                                        <changefreq>' . strtolower($category_changefreq_items) . '</changefreq>
                                        <priority>';
                                            if ($item['clicked']==$most_click) {
                                                $xml .= '1.0';
                                            }
                                            else {
                                                $item_pri=$most_click/$item['clicked'];
                                                $item_pri=1/$item_pri;
                                                $xml .= round($item_pri, 2);
                                                
                                            }
                                            $xml .='</priority>
                                        </url>';
                                   } // end while
                                }
                                $xml .= '</urlset>';
                                if (file_exists('sitemap.xml')) {
                                    unlink('sitemap.xml');
                                    file_put_contents('sitemap.xml', $xml);
                                }
                                else {
                                    file_put_contents('sitemap.xml', $xml);
                                }
/*                                
                                if ($notifyGoogle1==1) {
                                    if(pingGoogleSitemaps($obj->getBaseUrl() . "sitemap.xml") == 200) {
                                        echo "<br/> Google was <b style='color:green'>successfully notified</b> about changes.";
                                    }
                                    else {
                                        echo "<br/> There was a problem while notifying Google.";
                                    }
                                }
                                if ($notifyBing1==1) {
                                    if (pingBingSitemaps($obj->getBaseUrl() . "sitemap.xml") == 200) {
                                        echo "<br/> Bing was <b style='color:green'>successfully notified</b> about changes.";
                                    }
                                    else {
                                        echo "<br/> There was a problem while notifying Bing.";
                                    }
                                }
                                if ($notifyAsk1==1) {
                                    if (pingAskSitemaps($obj->getBaseUrl() . "sitemap.xml") == 200) {
                                        echo "<br/> ASK.NET was <b style='color:green'>successfully notified</b> about changes.";
                                    }
                                    else {
                                        echo "<br/> There was a problem while notifying ASK.NET.";
                                    }
                                }                                
                                if ($notifyYahoo1==1) {
                                    if (pingYahooSitemaps($obj->getBaseUrl() . "sitemap.xml", $_REQUEST["yahookey"]) == 200) {
                                        echo "<br/> Yahoo was <b style='color:green'>successfully notified</b> about changes.";
                                    }
                                    else {
                                        echo "<br/> There was a problem while notifying Yahoo.";
                                    }
                                }
*/                                                                
                                echo "<br/> <big style='color:red;'>Done !</big>";
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
                <tr>
                    <td class='submitfooter' colspan='2'>
                        <input type='submit' value='Save Settings & Generate Sitemap' name='ok' class='button'>
                    </td>
                </tr>
            </table>
        </div>
</form>