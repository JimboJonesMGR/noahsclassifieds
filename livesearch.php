<?php //defined('_NOAH') or die('Restricted access');   ?>
<?php
include("app/config.php");
//include("app/controller.php");
mysql_connect($hostName, $dbUser, $dbUserPw);
mysql_selectdb($dbName);
//$obj = new Controller();
//get the q parameter from URL
$q = addslashes($_GET["q"]);
?>
<ul>

    <?php
    $query = "SELECT * FROM " . $dbPrefix . "category";
    $result = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_array($result)) {

        $query1 = 'SELECT * FROM ' . $dbPrefix . 'customfield where cid=' . $row['id'] . ' and seo=1';
        $result1 = mysql_query($query1) or die(mysql_error());
        while ($row1 = mysql_fetch_array($result1)) {
            $columnIndex = $row1['columnIndex'];
            $query2 = 'SELECT creationtime,id,clicked,' . $columnIndex . ' FROM ' . $dbPrefix . 'item where cid=' . $row['id'] . " and " . $columnIndex . " LIKE '%$q%'";
            $result2 = mysql_query($query2) or die(mysql_error());
            while ($row2 = mysql_fetch_array($result2)) {
                $item_url = str_replace(' ', '_', $row2[$columnIndex]);
                $item_url = str_replace('/', '_', $item_url);
                $item_url = str_replace('&', '', $item_url);
                $item_url = str_replace('^', '', $item_url);
                $item_url = str_replace('%', '', $item_url);
                echo "<li><a href='" . $row['permaLink'] . '/' . $row2['id'] . '_' . $item_url . "'>" . $row2[$columnIndex] . "</a></li>";
            }
        }
    }
    ?>
</ul>
<?php
mysql_close();