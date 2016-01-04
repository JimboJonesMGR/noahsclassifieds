<?php
$nVersion = "4.1.1";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$globalStat = new GlobalStat;
if( $globalStat->instver<$nVersion )
{
    executeQueryForUpdate("INSERT INTO @notification (`id`, `cc`, `title`, `subject`, `body`, `active`, `langDependent`) VALUES (111, '', 'Ad Flagged', 'Ad Flagged', 'notifications/email_flagged.html', 1, 1);", __FILE__, __LINE__);        

    alterDatabaseColumns("settings", "ADD", array("`captchaType` INT( 11 ) NOT NULL DEFAULT '0'",
                                                  "`recaptchaPrivateKey` varchar(255) NOT NULL",
                                                  "`recaptchaPublicKey` varchar(255) NOT NULL",
                                                  "`displayFlaggedLink` INT( 11 ) NOT NULL DEFAULT '0'"), __FILE__, __LINE__);     

    alterDatabaseColumns("category", "ADD", array("`displayFlaggedLink` INT( 11 ) NOT NULL DEFAULT '0'"), __FILE__, __LINE__);     

    alterDatabaseColumns("customfield", "ADD", array("`useMarkitupSimple` INT( 11 ) NOT NULL DEFAULT '0'"), __FILE__, __LINE__);     

    updateGlobalstatAndFooter($nVersion);
}




?>
