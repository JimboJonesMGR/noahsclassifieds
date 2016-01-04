<?php
/* Files to delete */
$nVersion = "3.1.0";
defined('_NOAH') or die('Restricted access');
if( !class_exists("GlobalStat") ) die();
$_GS = new GlobalStat;
global $lll;
if( $_GS->instver<$nVersion )
{
    executeQueryForUpdate("ALTER TABLE @customfield ADD `isCommon` INT NOT NULL DEFAULT '0' AFTER `userField`;", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET `type`=1 WHERE columnIndex='ownerName'", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @customfield SET `searchable`=1 WHERE type=8 AND mainPicture=1", __FILE__, __LINE__);

    $query = "SELECT MAX(0+SUBSTRING(columnIndex, 5)) as columnIndex FROM @customfield WHERE columnIndex LIKE 'col_%'";
    $result = executeQueryForUpdate($query, __FILE__, __LINE__);
    if( mysql_num_rows($result) )
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        $nextColumnIndex = "col_".(1+$row["columnIndex"]);
    }
    else $nextColumnIndex = "col_0";
    executeQueryForUpdate("ALTER TABLE @item ADD $nextColumnIndex text NOT NULL DEFAULT ''", __FILE__, __LINE__);
    
    //ItemField::addDefaultCustomFields();
    $cf = new ItemField;
    $cf->columnIndex = "cName";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["appcategory"]) ? $lll["appcategory"] : "Category")."','0','1','0','','4','1','','','0','','3','0','0','0','0','now','now','','','2','.',',','','1','0','0','0','0','0','1','1','0','1','0','0','cName','','3600','0')", __FILE__, __LINE__);
    }
    $cf = new ItemField;
    $cf->columnIndex = "creationtime";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["creationtime"]) ? $lll["creationtime"] : "Created")."','0','1','0','','11','1','','','0','','3','0','0','0','0','now','now','','','2','.',',','','1','0','0','0','0','0','1','1','0','1','1','0','creationtime','','3700','0')", __FILE__, __LINE__);
    
    }
    $cf = new ItemField;
    $cf->columnIndex = "status";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["item_status"]) ? $lll["item_status"] : "Status")."','0','1','4','','4','1','0,1','','0','','3','0','0','0','0','now','now','','','2','.',',','','4','0','0','0','0','0','4','1','0','4','0','0','status','','3800','0')", __FILE__, __LINE__);
    
    }
    $cf = new ItemField;
    $cf->columnIndex = "clicked";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["item_clicked"]) ? $lll["item_clicked"] : "Views")."','0','1','0','','1','2','','','0','','3','0','0','0','0','now','now','','','2','.',',','','2','0','0','0','0','0','3','1','0','4','1','0','clicked','','3900','0')", __FILE__, __LINE__);
    
    }
    $cf = new ItemField;
    $cf->columnIndex = "responded";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["item_responded"]) ? $lll["item_responded"] : "Responses")."','0','1','0','','1','2','','','0','','3','0','0','0','0','now','now','','','2','.',',','','4','0','0','0','0','0','3','1','0','4','1','0','responded','','4000','0')", __FILE__, __LINE__);
    
    }
    $cf = new ItemField;
    $cf->columnIndex = "ownerName";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["item_ownerName"]) ? $lll["item_ownerName"] : "Owner")."','0','1','0','','6','1','','','0','','3','0','0','0','0','now','now','','','2','.',',','','1','0','0','0','0','0','1','1','0','4','0','0','ownerName','','4100','0')", __FILE__, __LINE__);
    
    }
    $cf = new ItemField;
    $cf->columnIndex = "expirationTime";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["exp"]) ? $lll["exp"] : "Expiration")."','0','1','0','','11','1','','','0','','3','0','0','0','0','now','now','','','2','.',',','','4','0','0','0','0','0','3','1','0','4','1','0','expirationTime','','4200','0')", __FILE__, __LINE__);

    }
    $cf = new ItemField;
    $cf->columnIndex = "title";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["title"]) ? $lll["title"] : "Title")."','0','1','1','','1','1','','','0','','3','1','0','0','0','now','now','','','2','.',',','','1','0','0','0','0','0','1','1','0','1','0','1','title','','4300','0')", __FILE__, __LINE__);
    }
    $cf = new ItemField;
    $cf->columnIndex = "description";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("columnIndex", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','".(isset($lll["description"]) ? $lll["description"] : "Description")."','0','1','1','','2','1','','','0','','3','0','0','0','0','now','now','','','2','.',',','','1','1','0','0','0','0','1','1','0','1','0','2','description','','4400','0')", __FILE__, __LINE__);

    }
    $cf = new ItemField;
    $cf->name = "Promotion level";
    $cf->isCommon = 1;
    $cf->cid = 0;
    if( load($cf, array("name", "isCommon", "cid")) )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('0','Promotion level','0','1','4','This is an example common field that has been set up so that only admin can see and set it. It is used in the search conditions of the demo \'Featured ads\' custom lists to fill those lists with the Gold, Silver and Bronze level featured ads.','6','1','None,Gold,Silver,Bronze','','0','','3','0','0','0','0','now','now','','','2','.',',','','0','0','0','0','0','0','4','1','0','4','0','0','$nextColumnIndex','','4500','0');", __FILE__, __LINE__);
    }
    executeQueryForUpdate("UPDATE @customfield SET `name`='Created' WHERE name='create_completed'", __FILE__, __LINE__);
    
    G::load( $cats, "SELECT id FROM @category" );    
    foreach( $cats as $c )
    {
        executeQueryForUpdate("INSERT INTO @customfield (cid,name,userField,isCommon,showInForm,expl,type,subType,`values`,default_text,default_bool,default_multiple,checkboxCols,mandatory,allowHtml,useMarkitup,dateDefaultNow,fromyear,toyear,formatPrefix,formatPostfix,`precision`,precisionSeparator,thousandsSeparator,format,showInList,innewline,rowspan,displaylength,sortable,mainPicture,showInDetails,displayLabel,detailsPosition,searchable,rangeSearch,seo,columnIndex,oldColumnIndex,sortId,`fields`) 
        VALUES ('$c->id','Promotion level','0','1','4','This is an example common field that has been set up so that only admin can see and set it. It is used in the search conditions of the demo \'Featured ads\' custom lists to fill those lists with the Gold, Silver and Bronze level featured ads.','6','1','None,Gold,Silver,Bronze','','0','','3','0','0','0','0','now','now','','','2','.',',','','0','0','0','0','0','0','4','1','0','4','0','0','$nextColumnIndex','','10000','0');", __FILE__, __LINE__);
    }
    
    executeQueryForUpdate("DELETE FROM @search", __FILE__, __LINE__);
    //CustomList::addCustomColumns();
    executeQueryForUpdate("ALTER TABLE @search
    ADD uid int(11) NOT NULL DEFAULT '0' AFTER id,
    ADD cid int(11) NOT NULL DEFAULT '0' AFTER uid,
    ADD listTitle varchar(255) NOT NULL DEFAULT '' AFTER query,
    ADD listDescription text NOT NULL DEFAULT '' AFTER listTitle,
    ADD creationtime datetime NOT NULL AFTER listDescription,
    ADD creationtime_from datetime NOT NULL AFTER creationtime,
    ADD creationtime_to datetime NOT NULL AFTER creationtime_from,
    ADD status int(11) NOT NULL DEFAULT '-1' AFTER creationtime_to,
    ADD clicked varchar(255) NOT NULL DEFAULT '' AFTER `status`,
    ADD responded varchar(255) NOT NULL DEFAULT '' AFTER clicked,
    ADD title varchar(255) NOT NULL DEFAULT '' AFTER responded,
    ADD description varchar(255) NOT NULL DEFAULT '' AFTER title,
    ADD ownerName text NOT NULL DEFAULT '' AFTER description,
    ADD expirationTime datetime NOT NULL AFTER ownerName,
    ADD expirationTime_from datetime NOT NULL AFTER expirationTime,
    ADD expirationTime_to datetime NOT NULL AFTER expirationTime_from,
    ADD primarySort int(11) NOT NULL AFTER expirationTime_to,
    ADD primaryDir varchar(4) NOT NULL DEFAULT 'ASC' AFTER primarySort,
    ADD primaryPersistent int(11) NOT NULL AFTER primaryDir,
    ADD secondarySort int(11) NOT NULL AFTER primaryPersistent,
    ADD secondaryDir varchar(4) NOT NULL DEFAULT 'ASC' AFTER secondarySort,
    ADD secondaryPersistent int(11) NOT NULL AFTER secondaryDir,
    ADD `limit` varchar(10) NOT NULL DEFAULT '' AFTER secondaryPersistent,
    ADD `columns` text NOT NULL DEFAULT '' AFTER `limit`,
    ADD displayedFor int(11) NOT NULL DEFAULT 1 AFTER `columns`,
    ADD pages text NOT NULL AFTER displayedFor,
    ADD displayInMenu int(11) NOT NULL AFTER pages,
    ADD categorySpecific int(11) NOT NULL AFTER displayInMenu,
    ADD recursive int(11) NOT NULL AFTER categorySpecific,
    ADD listStyle int(11) NOT NULL AFTER recursive,
    ADD `loop` int(11) NOT NULL DEFAULT '0' AFTER listStyle,
    ADD autoScroll int(11) NOT NULL DEFAULT '60' AFTER `loop`,
    ADD cache int(11) NOT NULL DEFAULT '60' AFTER autoScroll,
    ADD positionNormal varchar(10) NOT NULL DEFAULT '' AFTER cache,
    ADD positionScrollable varchar(10) NOT NULL DEFAULT '' AFTER positionNormal,
    MODIFY id int(11) NOT NULL auto_increment;", __FILE__, __LINE__);
    
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @item", __FILE__, __LINE__);
    $num = mysql_num_rows($result); 
    $itemColumnIndexes = array();
    for( $i=0, $count=0; $i<$num; $i++ ) 
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if( preg_match( "/^col_/", $row["Field"] ) ) $itemColumnIndexes[]=$row["Field"];
    }
    foreach( $itemColumnIndexes as $ci )
    {
        executeQueryForUpdate("ALTER TABLE @search ADD $ci text NOT NULL DEFAULT ''", __FILE__, __LINE__);
    }
    
    // demo featured ads:
    executeQueryForUpdate("UPDATE @item SET $nextColumnIndex='0'", __FILE__, __LINE__);
    G::load( $items, "SELECT id FROM @item WHERE status=1 ORDER BY creationtime DESC LIMIT 10" );
    foreach( $items as $item  ) executeQueryForUpdate("UPDATE @item SET $nextColumnIndex='Gold' WHERE id=$item->id LIMIT 10", __FILE__, __LINE__);
    
    loadSQL( $v1 = new CustomField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='title'");
    loadSQL( $v2 = new CustomField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='cName'");
    loadSQL( $v3 = new CustomField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='creationtime'");
    loadSQL( $v4 = new CustomField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='description'");
    loadSQL( $v5 = new CustomField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='clicked'");
    loadSQL( $v6 = new CustomField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='responded'");
    loadSQL( $v7 = new CustomField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND columnIndex='ownerName'");
    loadSQL( $v8 = new CustomField, "SELECT id FROM @customfield WHERE cid=0 AND isCommon=1 AND name='Promotion level'");
    //CustomList::addDefaultCustomLists();   
    executeQueryForUpdate("INSERT INTO @search (id,uid,cid,name,autoNotify,query,listTitle,listDescription,creationtime,creationtime_from,creationtime_to,status,clicked,responded,title,description,ownerName,expirationTime,expirationTime_from,expirationTime_to,primarySort,primaryDir,primaryPersistent,secondarySort,secondaryDir,secondaryPersistent,`limit`,`columns`,displayedFor,pages,displayInMenu,categorySpecific,recursive,listStyle,`loop`,autoScroll,cache,positionNormal,positionScrollable,$nextColumnIndex) 
    VALUES ('1','0','0','','0','SELECT n.*, c.wholeName AS cName, c.immediateAppear AS immediateAppear FROM @item AS n, @category AS c , @user AS u  WHERE n.ownerId=u.id AND  c.id=n.cid AND n.status=\'1\' AND 0','Search result list','This is a special custom list you can use to configure the columns of a non-category specific search result list.','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','-1','','','','','','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0','ASC','0','0','ASC','0','','$v1->id,$v2->id,$v4->id,$v7->id','1','','0','0','0','0','0','60','60','','',''),
           ('2','0','0','','0','SELECT n.*, c.wholeName AS cName, c.immediateAppear AS immediateAppear FROM @item AS n, @category AS c , @user AS u  WHERE n.ownerId=u.id AND  c.id=n.cid AND (FIND_IN_SET(n.status, \'-1\')!=0 OR n.ownerId=#gorumuser#)','My ads','The list of ads of a user. This means both the \'My ads\' list (the list of the currently logged in user), and the \'Advertisements of user XY\' lists.','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','-1','','','','','0','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','$v3->id','DESC','0','0','ASC','0','','$v1->id,$v2->id,$v5->id,$v6->id,$v4->id','2','','2','0','0','0','0','60','60','','',''),
           ('3','0','0','','0','SELECT n.*, c.wholeName AS cName, c.immediateAppear AS immediateAppear FROM @item AS n, @category AS c , @user AS u  WHERE n.ownerId=u.id AND  c.id=n.cid AND (n.status=\'1\')','Recent ads','List of 100 most recent ads','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','1','','','','','','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','$v3->id','DESC','0','0','ASC','0','100','$v1->id,$v2->id,$v3->id,$v4->id','1','','1','0','0','0','0','60','60','','',''),
           ('4','0','0','','0','SELECT n.*, c.wholeName AS cName, c.immediateAppear AS immediateAppear FROM @item AS n, @category AS c , @user AS u  WHERE n.ownerId=u.id AND  c.id=n.cid AND (n.status=\'1\')','Popular ads','List of 100 most viewed ads','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','1','','','','','','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','$v5->id','DESC','0','$v3->id','DESC','0','100','$v1->id,$v2->id,$v5->id,$v6->id,$v4->id','1','','1','0','0','0','0','60','60','','',''),
           ('5','0','0','','0','SELECT n.*, c.wholeName AS cName, c.immediateAppear AS immediateAppear FROM @item AS n, @category AS c , @user AS u  WHERE n.ownerId=u.id AND  c.id=n.cid AND (n.status=\'0\')','Pending ads','The list of ads that you haven\'t approved yet.','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0','','','','','','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','$v3->id','ASC','0','0','ASC','0','','$v1->id,$v2->id,$v3->id,$v7->id,$v4->id','4','','3','0','0','0','0','60','60','','',''),
           ('6','0','0','','0','SELECT n.*, c.wholeName AS cName, c.immediateAppear AS immediateAppear FROM @item AS n, @category AS c , @user AS u  WHERE n.ownerId=u.id AND  c.id=n.cid AND (n.status=\'1\' AND (FIND_IN_SET(\'Gold\', n.$nextColumnIndex)!=0))','Featured ads: Gold level','This is a featured ad list that demonstrate a way you can set up the \'featured ads\' feature yourself. It contains all the ads where the \'Promotion level\' common custom field has been set to \'Gold\'.','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','1','','','','','','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0','ASC','0','0','ASC','0','','$v1->id,$v4->id,$v8->id','4','/','0','0','0','1','0','60','60','','0','Gold');", __FILE__, __LINE__); 
    G::load( $fields, "SELECT cid, columnIndex, type FROM @customfield WHERE cid!=0 OR isCommon=1");
    foreach( $fields as $field  )
    {
        if( $field->columnIndex!='cName' && in_array($field->type, array(3, 4, 8, 10)) )
        {
            executeQueryForUpdate("UPDATE @search SET $field->columnIndex='-1' WHERE $field->columnIndex='' AND cid='$field->cid'", __FILE__, __LINE__);
        }
    }

    executeQueryForUpdate("ALTER TABLE @category ADD `restartExpOnModify` INT NOT NULL DEFAULT '0' AFTER `expirationOverride` ;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @settings DROP `showCreatedInLists`,DROP `showExpInLists`,DROP `showOwnerInLists` ;", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @category SET expirationEnabled=0 WHERE expiration=0 AND expirationOverride=0", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @category SET expiration=0, expirationOverride=0 WHERE expirationEnabled=0", __FILE__, __LINE__);
    G::load( $ads, "SELECT i.id FROM @item as i, @category as c WHERE i.cid=c.id AND c.expirationEnabled=0 
                    AND (i.expiration!=0 OR i.expEmailSent!=0 OR i.expirationTime!=0 OR i.renewalNum!=0)");
    foreach( $ads as $a ) executeQueryForUpdate("UPDATE @item SET expiration=0, expEmailSent=0, expirationTime=0, renewalNum=0 WHERE id=$a->id", __FILE__, __LINE__);      
    updateGlobalstatAndFooter($nVersion);
}
?>
