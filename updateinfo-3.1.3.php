<?php
/* Files to delete */
$nVersion = "3.1.3";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
if( $_GS->instver<$nVersion )
{
    executeQueryForUpdate("UPDATE @customfield SET type=4, searchable=1 WHERE columnIndex='cName'", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET type=6 WHERE columnIndex='ownerName'", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET `name`='Created' WHERE name='create_completed'", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET `values` = '' WHERE columnIndex = 'status' ", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @search ADD `iid` INT NOT NULL AFTER `listDescription`", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @category ADD `inactivateOnModify` INT NOT NULL DEFAULT '1',
                           ADD `showDescription` INT NOT NULL DEFAULT '1';", __FILE__, __LINE__);
    G::load( $cats, "SELECT c.id, f.cid FROM @category AS c LEFT JOIN @customfield AS f ON f.cid=c.id AND f.columnIndex='id' WHERE ISNULL(f.cid)");
    foreach( $cats as $c )
    {
        executeQueryForUpdate("INSERT INTO @customfield (`cid`, `name`, `userField`, `showInForm`, `expl`, `type`, `subType`, `values`, `default_text`, `default_bool`, `default_multiple`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`) VALUES 
        ($c->id, 'ID', 0, 0, '', 1, 2, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 'id', '', 50, 0)", __FILE__, __LINE__);
    }
    updateGlobalstatAndFooter($nVersion);
}
?>
