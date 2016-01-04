<?php
/* Files to delete */
$nVersion = "3.0.2";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
if( $_GS->instver<$nVersion )
{
    $cf = new UserField;
    $cf->columnIndex = "viewAdsLink";
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (`cid`, `name`, `userField`, `showInForm`, `expl`, `type`, `subType`, `values`, `default_text`, `default_bool`, `default_multiple`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`) VALUES 
                      (0, 'Ads of this user', 0, 0, '', 9, 1, '', '', 0, '', '3', 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 'viewAdsLink', '', 1000, 0);", __FILE__, __LINE__);
    }
    updateGlobalstatAndFooter($nVersion);
}
?>
