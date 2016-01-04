<?php
/* Files to delete */
$nVersion = "4.1.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$globalStat = new GlobalStat;
if( $globalStat->instver<$nVersion )
{
    executeQueryForUpdate("UPDATE @search SET `query` = REPLACE(`query`, '(^|,[^,])', '(^|,)')", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD INDEX cid (`cid`)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @category ADD INDEX up (`up`)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD INDEX cid (`cid`)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD INDEX isCommon (`isCommon`)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD INDEX userField (`userField`)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @customfield ADD INDEX columnIndex (`columnIndex`)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @item ADD INDEX cid (`cid`)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @item ADD INDEX status (`status`)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @item ADD INDEX ownerId (`ownerId`)", __FILE__, __LINE__);

    executeQueryForUpdate("UPDATE @customfield SET allowHtml=1 WHERE columnIndex='name';", __FILE__, __LINE__);        
    alterDatabaseColumns("settings", "ADD", array("`displayResponseLink` INT( 11 ) NOT NULL DEFAULT '0'",
                                                  "`displayFriendmailLink` INT( 11 ) NOT NULL DEFAULT '0'"), __FILE__, __LINE__);     
    alterDatabaseColumns("user", "ADD", array("`responded` INT NOT NULL DEFAULT '0' AFTER `favorities`"), __FILE__, __LINE__);
    
    if( class_exists("ecommsettings") )
    {
        alterDatabaseColumns("ecommsettings", "ADD", array("`paypal_enabled` INT NOT NULL DEFAULT '0'",
                             "`paypal_user` VARCHAR( 255 ) NOT NULL",
                             "`paypal_environment` INT NOT NULL DEFAULT '0'",
                             "`paypal_integrationMethod` int(11) NOT NULL default '0'",
                             "`paypal_apiUser` varchar(255) NOT NULL default ''",
                             "`paypal_apiPassword` varchar(255) NOT NULL default ''",
                             "`paypal_apiSignature` varchar(255) NOT NULL default ''",
                             "`paypal_cvv2` int(11) NOT NULL default '0'"), __FILE__, __LINE__ );
        alterDatabaseColumns("ecommsettings", "CHANGE", array(
                                "`integrationMethod` `authorize_net_integrationMethod` INT( 11 ) NOT NULL DEFAULT '0'",
                                "`use_authorize_net` `authorize_net_enabled` INT( 11 ) NOT NULL DEFAULT '1'"), __FILE__, __LINE__ );
        executeQueryForUpdate("UPDATE @ecommsettings SET authorize_net_integrationMethod=authorize_net_integrationMethod+1", __FILE__, __LINE__ );
    }
    
    $v = new UserField;
    $v->cid = 0;
    $v->name = "Active";
    $v->type = customfield_bool;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forAdmin;
    $v->searchable = customfield_forAdmin;
    $v->sortable = TRUE;
    $v->columnIndex = "active";
    $v->sortId = 1150;
    $v->create();

    updateGlobalstatAndFooter($nVersion);
}

?>
