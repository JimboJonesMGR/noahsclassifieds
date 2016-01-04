<?php
defined('_NOAH') or die('Restricted access');

function addEcommerceTables()
{
    executeQueryForUpdate("CREATE TABLE @ecommrule (
      `id` int(11) NOT NULL auto_increment,
      `model` int(11) NOT NULL default '0',
      `action` int(11) NOT NULL default '0',
      `consumption` float NOT NULL default '0',
      `viewNum` int(11) NOT NULL default '1',
      `replyNum` int(11) NOT NULL default '1',
      `cid` int(11) NOT NULL default '0',
      `includeSubcats` int(11) NOT NULL default '0',
      `ruleField` int(11) NOT NULL default '0',
      `ruleValue` int(11) NOT NULL default '0',
      `confirmationTextType` int(11) NOT NULL default '0',
      `confirmationText` text NOT NULL,
      `successTextType` int(11) NOT NULL default '0',
      `successText` text NOT NULL,
      `failTextType` int(11) NOT NULL default '0',
      `failText` text NOT NULL,
      PRIMARY KEY  (`id`))", __FILE__, __LINE__);
    
    
    executeQueryForUpdate("CREATE TABLE @ecommsettings (
      `id` int(11) NOT NULL auto_increment,
      `model` int(11) NOT NULL default '2',
      `expNoticeBefore_subscription` int(11) NOT NULL default '5',
      `expNoticeBefore_credits` int(11) NOT NULL default '10',
      `purchaseFormFields` text NOT NULL,
      `currency` varchar(255) NOT NULL default 'USD',
      `currencySymbol` varchar(255) NOT NULL default '$',
      `formatPrefix` varchar(255) NOT NULL default '$',
      `formatPostfix` varchar(255) NOT NULL default '',
      `precision` int(1) NOT NULL default '2',
      `precisionSeparator` varchar(1) NOT NULL default '.',
      `thousandsSeparator` varchar(1) NOT NULL default ',',
      `format` varchar(255) NOT NULL default '',
      `authorize_net_enabled` int(11) NOT NULL default '0',
      `authorize_net_integrationMethod` int(11) NOT NULL default '0',
      `authorize_net_environment` int(11) NOT NULL default '0',
      `authorize_net_user` varchar(255) NOT NULL default '',
      `authorize_net_key` varchar(255) NOT NULL default '',
      `authorize_net_test` int(11) NOT NULL default '1',
      `authorize_net_cvv2` int(11) NOT NULL default '0',
      `authorize_net_md5Hash` varchar(255) NOT NULL default '',
      `paypal_enabled` int(11) NOT NULL default '0',
      `paypal_integrationMethod` int(11) NOT NULL default '0',
      `paypal_environment` int(11) NOT NULL default '0',
      `paypal_user` varchar(255) NOT NULL default '',
      `paypal_apiUser` varchar(255) NOT NULL default '',
      `paypal_apiPassword` varchar(255) NOT NULL default '',
      `paypal_apiSignature` varchar(255) NOT NULL default '',
      `paypal_cvv2` int(11) NOT NULL default '0',
      PRIMARY KEY  (`id`));", __FILE__, __LINE__);
        
    executeQueryForUpdate("CREATE TABLE @purchase (
      `id` int(11) NOT NULL auto_increment,
      `paymentMethod` varchar(20) NOT NULL default '',
      `transactionId` varchar(255) NOT NULL default '',
      `responseCode` int(11) NOT NULL default '0',
      `responseText` varchar(255) NOT NULL default '',
      `creationtime` datetime NOT NULL,
      `pid` int(11) NOT NULL default '0',
      `uid` int(11) NOT NULL default '0',
      `description` text NOT NULL,
      `price` float NOT NULL,
      `notes` text NOT NULL,
      `firstName` varchar(255) NOT NULL default '',
      `lastName` varchar(255) NOT NULL default '',
      `address` varchar(255) NOT NULL default '',
      `city` varchar(255) NOT NULL default '',
      `state` varchar(255) NOT NULL default '',
      `zip` varchar(255) NOT NULL default '',
      `country` varchar(255) NOT NULL default '',
      `phone` varchar(255) NOT NULL default '',
      `fax` varchar(255) NOT NULL default '',
      `email` varchar(255) NOT NULL default '',
      `rawResponse` text NOT NULL,
      PRIMARY KEY  (`id`))", __FILE__, __LINE__); 
    
    executeQueryForUpdate("CREATE TABLE @purchaseitem (
      `id` int(11) NOT NULL auto_increment,
      `iid` int(11) NOT NULL default '0',
      `uid` int(11) NOT NULL default '0',
      `description` text NOT NULL,
      `type` int(11) NOT NULL default '1',
      `amount` int(11) NOT NULL default '1',
      `unit` int(11) NOT NULL default '0',
      `price` float NOT NULL,
      `sortId` int(11) NOT NULL default '0',
      `creationtime` datetime NOT NULL,
      PRIMARY KEY  (`id`))", __FILE__, __LINE__); 
    
    $ecomm = new ECommFull();
    $ecomm->initialize();    
}

?>
