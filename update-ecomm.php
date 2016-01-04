<?php
$dbPrefix = "classifieds_";  // for backward compatibility with 1.3
include("initdirs.php");

include(NOAH_APP . "/constants.php");
include(NOAH_APP . "/error.php");
include(NOAH_APP . "/include.php");
include(ECOMM_DIR . "/update.php");
gorumMain();

executeQueryForUpdate("
CREATE TABLE @rss (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `language` varchar(10) NOT NULL default 'en-us',
  PRIMARY KEY  (`id`)
);", __FILE__, __LINE__);

executeQueryForUpdate("INSERT INTO @rss (`id`, `title`, `description`, `language`) VALUES 
(1, 'Noah''s Classifieds RSS feed', 'Latest ads from Noah''s Classifieds', 'en-us');", __FILE__, __LINE__);

addEcommerceTables();

echo "<h3>The program has been successfully updated to the EComm version.</h3>\n"    
?>
