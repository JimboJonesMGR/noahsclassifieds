<?php
$nVersion = "6.1.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$globalStat = new GlobalStat;
if( $globalStat->instver<$nVersion )
{
    // adding an isManager field to the user table and a corresponding custom user field:
    executeQueryForUpdate("ALTER TABLE @user ADD `isManager` int(11) NOT NULL DEFAULT '0'", __FILE__, __LINE__);
    executeQueryForUpdate("INSERT INTO @customfield (`cid`, `name`, `userField`, `isCommon`, `showInForm`, `expl`, `type`, `subType`, `values`, `useVariableSubstitution`, `default`, `checkboxCols`, `mandatory`, `allowHtml`, `useMarkitup`, `useMarkitupSimple`, `dateDefaultNow`, `fromyear`, `toyear`, `formatPrefix`, `formatPostfix`, `precision`, `precisionSeparator`, `thousandsSeparator`, `format`, `showInList`, `customListPlacement`, `innewline`, `rowspan`, `displaylength`, `sortable`, `mainPicture`, `showInDetails`, `customDetailsPlacement`, `displayLabel`, `detailsPosition`, `searchable`, `rangeSearch`, `seo`, `css`, `columnIndex`, `oldColumnIndex`, `sortId`, `fields`, `ecommAssignment`, `oodleField`) VALUES
	(0, 'Manager', 0, 0, 4, 'Managers have the right to moderate ads.', 3, 1, '', 0, '', '3', 0, 0, 0, 0, 0, 'now', 'now', '', '', 2, '.', ',', '', 4, 0, 0, 0, 0, 1, 0, 4, 0, 1, 0, 4, 0, 0, '', 'isManager', '', 2400, 0, 0, '');");
    // updating the 'Pending ads' custom field so that it is visible for managers in the login menu:
    executeQueryForUpdate("UPDATE @search SET displayedFor=7, displayInMenu=1 WHERE uid=0 AND status=0");
    updateGlobalstatAndFooter($nVersion);
}
?>
