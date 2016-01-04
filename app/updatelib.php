<?php

function updateMain(&$s)
{
    global $lll, $gorumuser, $submit, $noahVersions;
    global $dbName,$dbUser,$dbUserPw, $dbHost, $gorumrecognised;

    $gorumrecognised = $gorumuser->isAdm = TRUE;  // az update-nek biztos ami biztos admin privilegiumokat kell adni
    $s="";
    showInstallHeader($s1);
    $s.=$s1;
    $s.="<h1>".$lll["u_maintitle"]."</h1>\n";
    connectDb($dbHost, $dbUser, $dbUserPw, $dbName);

    if( G::load( $fgs, 1, "globalstat" ) )
    {
        iPrint($lll["cantGetVersionInfo"], "err", $sp);
        $s.=$sp;
    }
    $toVersion = $noahVersions[sizeof($noahVersions)-1];
    if (isset($_GET["submit"])) {
        $submit=$_GET["submit"];
    }
    if( !isset($submit) )
    {
        if( $fgs->instver==$toVersion )
        {
            iPrint(sprintf($lll["already_installed"], $toVersion),"ok",$sp);
            $s.=$sp;
            return ok;
        }
        iPrint($lll["secure_copy"],"warn",$sp);
        $s.=$sp;
        $s.="<br><br>";
        iPrint(sprintf($lll["ready_to_update"], $dbName, $toVersion),
               "ok",$sp);
        $s.=$sp;
        $s.="<form method='get' action='update.php'>\n";
        $s.="<input type='submit' name='submit' value='".
            $lll["continue"]."'>";
        $s.="</form>\n";
    }
    else if( $submit==$lll["cancel"] )
    {
        iPrint($lll["operation_cancelled"],"ok",$sp);
        $s.=$sp;
    }
    else if( $submit==$lll["continue"] )
    {
        if( $fgs->instver=="1_2" || $fgs->instver=="1_1" )
        {
            iPrint($lll["onlyFrom1.3"], "err", $sp);
            $s.=$sp;
        }
        else
        {
            if( $fgs->instver<"2_3_0") 
            {
                if( !is__writable(NOAH_APP) )
                {
                    iPrint(sprintf($lll["picturesDirMustbeWritable"], NOAH_APP), "err", $sp);
                    $s.=$sp;
                    return;
                }
            }
            if( $fgs->instver=="1_3" || $fgs->instver=="1_3_1") 
            {
                if( !is__writable(AD_PIC_DIR) )
                {
                    iPrint(sprintf($lll["picturesDirMustbeWritable"], AD_PIC_DIR), "err", $sp);
                    $s.=$sp;
                    return;
                }
                update_1_3_to_2_1_2($s1, $dbName);
                $s.=$s1;
                $fgs->instver="2.1.2";
                $fgs->defPageConf=TRUE;
                modify($fgs);
            }
            if( $fgs->instver!=$toVersion )
            {
                update( $s1, $dbName, $fgs->instver, $toVersion );
                $s.=$s1;
            }
            $ctrl = new AppController("checkconf/show");
            $s.="<br><br><a href='".$ctrl->makeURL()."'>".$lll["backToIndex"]."</a>";
        }
    }
}

function is__writable($path) 
{
    //will work in despite of Windows ACLs bug
    //NOTE: use a trailing slash for folders!!!
    if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
        return is__writable($path.uniqid(mt_rand()).'.tmp');
    else if (is_dir($path))
        return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f = @fopen($path, 'a');
    if ($f===false)
        return false;
    fclose($f);
    if (!$rm)
        unlink($path);
    return true;
}

function update( &$s, $dbName, $fromVersion, $toVersion="Latest" )
{
    global $noahVersions;
    global $lll;

    $s="";
    $length = sizeof($noahVersions);
    if( $toVersion=="Latest" ) $toVersion = $noahVersions[$length-1];
    if( !in_array( $fromVersion, $noahVersions) ||
        !in_array( $toVersion, $noahVersions) )
    {
        iPrint(sprintf($lll["invalid_version"],"$fromVersion, $toVersion"),"err",$sp);
        $s.=$sp;
        return ok;
    }
    if( $fromVersion==$toVersion )
    {
        iPrint(sprintf($lll["already_installed"], $toVersion),"ok",$sp);
        $s.=$sp;
        return ok;
    }
    $fromIndex = getIndex($fromVersion);
    $toIndex   = getIndex($toVersion);
    if( $toIndex < $fromIndex )
    {
        iPrint(sprintf($lll["invalid_version"],"$fromVersion, $toVersion"),"err",$sp);
        $s.=$sp;
        return ok;
    }
    global $updateOutput;
    $updateOutput = "";
    for( $vInd=$fromIndex+1; $vInd<=$toIndex; $vInd++ )
    {
        $fname = NOAH_BASE . "/updateinfo-$noahVersions[$vInd].php";
        if( file_exists($fname) )
        {
            $contents = join('', file($fname));
            if( preg_match('{/\* Files to delete:\s*(\S.*)\s*\*/}s', $contents, $matches ) )
            {
                $filesToDelete = preg_split('/[\n\r]+/', $matches[1]);
                foreach( $filesToDelete as $file ) @unlink(NOAH_BASE . "/$file");
            }
            include($fname);
            $s.=$updateOutput;
        }
        else updateGlobalstatAndFooter($noahVersions[$vInd]);
    }
    // storing the last update time:
    executeQueryForUpdate("UPDATE @globalstat SET lastUpdate=NOW()", __FILE__, __LINE__);

    iPrint($lll["updateSuccessful"],"ok",$sp);
    $s.=$sp;

}

function getIndex( $version )
{
    global $noahVersions;
    foreach( $noahVersions as $index=>$ver )
    {
        if( $ver==$version ) return $index;
    }
}

function update_1_3_to_2_1_2(&$s, $dbName)
{
    global $lll, $variableFieldsNum;
    
    updateTableNames();
    createNewTables();
    updateSettingsTable();
    updateCategoryTable();
    updateCustomFields();
    updateItemTable();
    updateGlobalstatTable();
    updateOtherTables();
}

function updateTableNames()
{
    global $dbPrefix;
    
    executeQueryForUpdate("ALTER TABLE {$dbPrefix}advertisement RENAME {$dbPrefix}item;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE {$dbPrefix}classifiedscategory RENAME {$dbPrefix}category;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE {$dbPrefix}classifiedssearch RENAME {$dbPrefix}search;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE {$dbPrefix}classifiedsuser RENAME {$dbPrefix}user;", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE {$dbPrefix}globalsettings RENAME {$dbPrefix}settings;", __FILE__, __LINE__);
    executeQueryForUpdate("DROP TABLE {$dbPrefix}badwords;");
}

function updateSettingsTable()
{
    global $noahVersion, $versionFooterText;
    
    executeQueryForUpdate("
    ALTER TABLE @settings 
    CHANGE `settings_blockSize` `blockSize` INT(3) NOT NULL DEFAULT '100000',
    CHANGE `settings_showExplanation` `showExplanation` TINYINT(4) NOT NULL DEFAULT '1',
    CHANGE `settings_adminEmail` `adminEmail` VARCHAR(255) NOT NULL DEFAULT '',
    CHANGE `settings_expiration` `expiration` INT(11) NOT NULL DEFAULT '30',
    CHANGE `settings_expNoticeBefore` `expNoticeBefore` INT(11) NOT NULL DEFAULT '5',
    CHANGE `settings_charLimit` `charLimit` INT(11) NOT NULL DEFAULT '10000',
    CHANGE `settings_immediateAppear` `immediateAppear` INT(11) NOT NULL DEFAULT '1',
    CHANGE `settings_maxPicSize` `maxPicSize` INT(11) NOT NULL DEFAULT '0',
    CHANGE `settings_maxPicWidth` `maxPicWidth` INT(11) NOT NULL DEFAULT '0',
    CHANGE `settings_maxPicHeight` `maxPicHeight` INT(11) NOT NULL DEFAULT '0',
    CHANGE `settings_renewal` `renewal` INT(11) NOT NULL DEFAULT '5',
    CHANGE `settings_allowModify` `allowModify` INT(11) NOT NULL DEFAULT '1',
    DROP `settings_necessaryAuthLevel`,
    DROP `settings_rangeBlockSize`,
    DROP `settings_textAreaRows`,
    DROP `settings_textAreaCols`,
    DROP `settings_headTemplate`,
    DROP `settings_upperTemplate`,
    DROP `settings_lowerTemplate`,
    DROP `settings_minPasswordLength`,
    DROP `settings_htmlTitle`,
    DROP `settings_htmlKeywords`,
    DROP `settings_htmlDescription`,
    DROP `settings_thumbnailWidth` ,
    DROP `settings_thumbnailHeight` ,
    DROP `settings_showChangePassword`,
    DROP `settings_showLogout`,
    DROP `settings_showLogin`,
    DROP `settings_showRegister`,
    DROP `settings_showMyProfile`,
    DROP `settings_showMyAds`,
    DROP `settings_showSubmitAd`,
    DROP `settings_showRecentAds`,
    DROP `settings_showMostPopularAds`,
    DROP `settings_showSearch`,
    DROP `settings_showHome`,
    ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ,
    ADD subscriptionType int(11) NOT NULL default '2',
    ADD `adminFromName` VARCHAR(255) NOT NULL DEFAULT '' AFTER adminEmail,
    ADD `menuPoints` VARCHAR( 255 ) NOT NULL AFTER `maxPicHeight` ,
    ADD `titlePrefix` VARCHAR( 255 ) NOT NULL AFTER `adminFromName`,
    ADD `smtpServer` VARCHAR( 255 ) NOT NULL AFTER `adminFromName` ,
    ADD `smtpUser` VARCHAR( 255 ) NOT NULL AFTER `smtpServer` ,
    ADD `smtpPass` VARCHAR( 255 ) NOT NULL AFTER `smtpUser`,
    ADD `fallBackNative` INT NOT NULL DEFAULT '0' AFTER `smtpPass`,
    ADD `versionFooter` TEXT NOT NULL AFTER `showExplanation`,
    ADD `helpLink` VARCHAR(255) NOT NULL AFTER menuPoints,
    ADD `defaultTheme` VARCHAR( 255 ) NOT NULL AFTER `helpLink` ,
    ADD `allowSelectTheme` INT NOT NULL DEFAULT '1' AFTER `defaultTheme` ,
    ADD `allowedThemes` TEXT NOT NULL AFTER `allowSelectTheme`,
    ADD `mainTitle` VARCHAR( 255 ) NOT NULL AFTER `titlePrefix` ,
    ADD `mainDescription` TEXT NOT NULL AFTER `mainTitle` ,
    ADD `mainKeywords` TEXT NOT NULL AFTER `mainDescription`,
    ADD `showCreatedInLists` INT NOT NULL DEFAULT '0',
    ADD `showCreatedInDetails` INT NOT NULL DEFAULT '1',
    ADD `showExpInLists` INT NOT NULL DEFAULT '0',
    ADD `showExpInDetails` INT NOT NULL DEFAULT '1',
    ADD `dateFormat` VARCHAR( 100 ) NOT NULL DEFAULT 'Y-m-d',
    ADD `enableFavorities` INT NOT NULL DEFAULT '1',
    ADD `enableRememberPassword` INT NOT NULL DEFAULT '1',
    ADD `enablePasswordReminder` INT NOT NULL DEFAULT '1',
    ADD `maxMediaSize` INT(11) NOT NULL DEFAULT '50000' after mainKeywords,
    ADD `updateCheckInterval` INT NOT NULL DEFAULT 7;", __FILE__, __LINE__);
    
    getDbCount( $count, "SELECT * FROM @settings");
    $cmd = $count ? "UPDATE" : "INSERT INTO";
    executeQueryForUpdate("
        $cmd @settings SET 
            id=1, 
            menuPoints='1,2,3,4,5,6,7,8,9,10,11,12', 
            defaultTheme='modern', 
            allowedThemes='classic,modern',
            versionFooter='$versionFooterText'", __FILE__, __LINE__);
    $_S = new AppSettings();
    if( strstr($_S->adminEmail, "noreply@phpoutsourcing.com") || strstr($_S->adminEmail, "noreply@noreply.com") )
    {
        executeQueryForUpdate("UPDATE @settings SET adminEmail=''", __FILE__, __LINE__);
    }
}

function updateCustomFields()
{
    global $gorumroll, $dbClasses;
    include(NOAH_APP . "/varfields.php");
    $dbClasses[]="varfields";
    $gorumroll = new Roll();
    
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @varfields", __FILE__, __LINE__);
    $variableFieldsNum = (mysql_num_rows($result)-3)/15;
    G::load( $varfields, "SELECT * FROM @varfields");
    $attrs = array("name","expl","type","active","everActivated","values","default",
        "mandatory","list","innewline","displaylength","searchable",
        "hidden","format","allowHtml",
        "sortable","fromyear","toyear");
    $oldVariableFieldsNum = $variableFieldsNum;
    $maxVariableFieldsNum=0;
    CustomField::addCustomColumns("item");
    foreach( $varfields as $v )
    {
        $sortId=1000;
        $columnIndex=0;
        $c = new CustomField;
        $c->cid = $v->id;
        $c->name = "Title";
        $c->type = varfields_text;
        $c->active = TRUE;
        $c->mandatory = TRUE;
        $c->showInList = TRUE;
        $c->searchable = TRUE;
        $c->sortable = TRUE;
        $c->seo = customfield_title;
        $c->columnIndex = $columnIndex++;
        $c->oldColumnIndex = "title";
        $c->sortId = $sortId;
        $sortId+=100;
        create($c);
        
        $c = new CustomField;
        $c->cid = $v->id;
        $c->name = "Picture";
        $c->type = varfields_picture;
        $c->active = TRUE;
        $c->everActivated = TRUE;
        $c->mandatory = FALSE;
        $c->showInList = TRUE;
        $c->mainPicture = TRUE;
        $c->searchable = TRUE;
        $c->sortable = FALSE;
        $c->rowspan = TRUE;
        $c->columnIndex = $columnIndex++;
        $c->oldColumnIndex = "picture";
        $c->sortId = $sortId;
        $sortId+=100;
        create($c);
        
        $variableFieldsNumInThisCat = 2;
        for( $i=0; isset($v->{"active_$i"}); $i++ )
        {
            if( $v->{"active_$i"} )
            {
                $c = new CustomField;
                $c->cid = $v->id;
                $c->sortId = $sortId;
                $sortId+=100;
                $c->columnIndex = $columnIndex++;
                $c->oldColumnIndex = "col_$i";
                foreach( $attrs as $attr )
                {
                    $fullAttrName = "{$attr}_".($i ? strval($i) : "0");
                    if( $attr=="list" ) $c->showInList = $v->$fullAttrName;
                    elseif( $attr=="default" )
                    {
                        if( $v->{"type_$i"}==customfield_text || $v->{"type_$i"}==customfield_selection )
                        {
                            $c->default_text = $v->{"default_$i"};
                        }
                        if( $v->{"type_$i"}==customfield_textarea || $v->{"type_$i"}==customfield_multipleselection || $v->{"type_$i"}==customfield_checkbox )
                        {
                            $c->default_multiple = $v->{"default_$i"};
                        }
                        elseif( $v->{"type_$i"}==customfield_bool )
                        {
                            $c->default_bool = $v->{"default_$i"};
                        }
                    }
                    elseif( $attr=="sortable" && isset($v->$fullAttrName) ) $c->$attr = ($v->$fullAttrName>1);
                    elseif( isset($v->{$fullAttrName}) ) $c->$attr = $v->$fullAttrName;
                }
                create($c);
                $variableFieldsNumInThisCat++;
            }
        }
        if( $variableFieldsNumInThisCat > $variableFieldsNum )
        {
            for( $i=$variableFieldsNum; $i<$variableFieldsNumInThisCat; $i++ )
            {
                executeQueryForUpdate("ALTER TABLE @item ADD col_$i TEXT NOT NULL", __FILE__, __LINE__);
            }
            $variableFieldsNum = $variableFieldsNumInThisCat;
        }
        $maxVariableFieldsNum = max($maxVariableFieldsNum, $variableFieldsNumInThisCat);
        global $item_typ;
        $item_typ["attributes"]["title"]=array();
        $item_typ["attributes"]["picture"]=array();
        for( $i=0; $i<=$maxVariableFieldsNum; $i++ )
        {
            if( !isset($item_typ["attributes"]["col_$i"]) ) $item_typ["attributes"]["col_$i"]=array("type"=>"TEXT");
        }
        G::load( $ads, "SELECT * FROM @item WHERE cid=$v->id");
        G::load( $customFields, "SELECT * FROM @customfield WHERE cid=$v->id");
        foreach( $ads as $a )
        {
            $newAd = new Item;
            $newAd->id = $a->id;
            foreach( $customFields as $c )
            {
                $newAd->{"col_$c->columnIndex"} = $a->{$c->oldColumnIndex};            
            }
            reset($customFields);
            modify($newAd);
        }
    }
    // a folosleges oszlopok torlese:
    for( $i=$maxVariableFieldsNum; $i<$oldVariableFieldsNum; $i++ )
    {
        executeQueryForUpdate("ALTER TABLE @item DROP col_$i", __FILE__, __LINE__);
    }
}

function updateItemTable()
{
    global $thumbnailSizes;
    
    executeQueryForUpdate("
        ALTER TABLE @item 
        DROP title, DROP picture, DROP keepPrivate,
        CHANGE `active` `status` INT NOT NULL DEFAULT 1, 
        CHANGE `expirationTime` `expirationTime` DATETIME NOT NULL, 
        CHANGE `creationtime` `creationtime` DATETIME NOT NULL;", __FILE__, __LINE__);   
    executeQueryForUpdate("UPDATE @item SET `expirationTime`=0, expEmailSent=0", __FILE__, __LINE__);   
    G::load( $cats, "SELECT * FROM @category WHERE expiration!=0");
    foreach( $cats as $cat )
    {
        executeQueryForUpdate("UPDATE @item SET `expirationTime`= NOW() + INTERVAL $cat->expiration DAY WHERE cid=$cat->id;", __FILE__, __LINE__);
    }
    CustomField::addCustomColumns("item");
    G::load( $items, "SELECT * FROM @item WHERE col_1!=''");
    $create_fg = array("", "ImageCreateFromGIF", "ImageCreateFromJPEG",
                           "ImageCreateFromPNG");
    $save_fg = array("", "ImageGIF", "ImageJPEG", "ImagePNG");
    $extensions = array("", "gif", "jpg", "png");
    $checkBits = array(0, IMG_GIF, IMG_JPG, IMG_PNG);
    $memoryLimit = byteStr2num(ini_get('memory_limit'));
    foreach( $items as $item )
    {
        $ext = strstr($item->col_1, "jpg") ? "jpg" : (strstr($item->col_1, "gif") ? "gif" : (strstr($item->col_1, "png") ? "png" : ""));
        if( !$ext ) continue;
        executeQueryForUpdate("UPDATE @item SET col_1='$ext' WHERE id=$item->id", __FILE__, __LINE__);
        $fname = AD_PIC_DIR . "/$item->id.$ext";
        if( file_exists($fname) )
        {
            @unlink(AD_PIC_DIR . "/th_$item->id.$ext");  // a regi thumbnailt toroljuk
            copy( $fname, AD_PIC_DIR . "/{$item->id}_1.$ext" );  // uj nev a full image-nek
            // mas fg-eket kell hivni az image tipusnak megfeleloen:
            $size = getimagesize( $fname );
            $width = $size[0];
            $height = $size[1];
            $type = $size[2]; // az image tipus, 1=>GIF, 2=>JPG, 3=>PNG
            $ext = $extensions[$type];
            $supported=FALSE;
            if( defined("IMG_GIF") && function_exists("ImageTypes"))//van GD
            {
                $supported = isset($checkBits[$type]) && ((ImageTypes() & $checkBits[$type]));
            }
            // ha az adott image tipus supportalva van:
            if( $supported )
            {
                foreach( $thumbnailSizes as $thSize=>$dimensions )
                {
                    if( function_exists('memory_get_usage') && $memoryLimit && $memoryLimit!=-1 /* unlimited */ )
                    {
                        $channels = isset($size['channels']) ? $size['channels'] : 1;  // png has no channels
                        $memoryNeeded = Round(($size[0] * $size[1] * $size['bits'] * $channels / 8 + Pow(2, 16)) * 1.65);
                        $usage = memory_get_usage();
                        //FP::log("Current usage: $usage, limit: $memoryLimit, new to allocate: $memoryNeeded, rest after allocate: ". ($memoryLimit-$usage-$memoryNeeded));
                        // skipping if ImageCreate would exceed the memory limit:
                        if( $usage + $memoryNeeded > $memoryLimit ) continue;
                    }                
                    shrinkPicture($newWidth, $newHeight, $dimensions["width"], $dimensions["height"], $fname );
                    $src_im = $create_fg[$type]($fname);
                    $dst_im = ImageCreateTrueColor ($newWidth, $newHeight);
                    imagecopyresampled ($dst_im, $src_im, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    $th_foname = AD_PIC_DIR . "/th_{$thSize}_{$item->id}_1.$ext";   // pictures/ads/th_medium_2345_5.jpg
                    $save_fg[$type]( $dst_im, $th_foname );
                    imagedestroy($src_im);
                }
            }
            @unlink($fname);  // a full image-et a regi neven toroljuk
        }
    }
    global $gorumuser, $gorumrecognised;
    $gorumrecognised=TRUE;
    $gorumuser->isAdm=1;
    $c = new AppCategory;
    $c->recalculateAllItemNums(TRUE);
}

function updateGlobalstatTable()
{
    executeQueryForUpdate("
        ALTER TABLE @globalstat 
        ADD `creationtime` DATE NOT NULL ,
        ADD `lastUpdate` DATE NOT NULL ,
        ADD `reg` VARCHAR( 255 ) NOT NULL ,
        ADD `registered` INT NOT NULL DEFAULT '0',
        ADD `company` VARCHAR( 255 ) NOT NULL ,
        ADD `firstName` VARCHAR( 255 ) NOT NULL ,
        ADD `lastName` VARCHAR( 255 ) NOT NULL ,
        ADD `email` VARCHAR( 255 ) NOT NULL,
        ADD `lastUpdateCheck` DATE NOT NULL ;");
    executeQueryForUpdate("UPDATE @globalstat SET defPageConf=0, creationtime=NOW(), lastUpdate=NOW()", __FILE__, __LINE__);
}

function updateCategoryTable()
{
    executeQueryForUpdate("
        ALTER TABLE @category 
        ADD `keywords` TEXT NOT NULL AFTER `description`,
        ADD `creationtime` DATETIME NOT NULL;");
    $result = executeQueryForUpdate("SHOW COLUMNS FROM @category", __FILE__, __LINE__);
    $num = mysql_num_rows($result);    
    $found=FALSE;
    for( $i=0, $count=0; $i<$num && !$found; $i++ ) 
    {
        $row=mysql_fetch_array($result, MYSQL_ASSOC);
        if( $row["Field"]=='expiration' ) $found=TRUE;
    }
    if( !$found ) 
    {
        executeQueryForUpdate("ALTER TABLE @category 
            ADD `expiration` INT NOT NULL DEFAULT '0', 
            ADD immediateAppear INT NOT NULL DEFAULT '1', 
            ADD customAdListTitle VARCHAR( 255 ) NOT NULL;", __FILE__, __LINE__);
        $_S = new AppSettings;
        if( !$_S->immediateAppear ) executeQueryForUpdate("UPDATE @category SET immediateAppear=0", __FILE__, __LINE__);
        if( $_S->expiration ) executeQueryForUpdate("UPDATE @category SET expiration=$_S->expiration", __FILE__, __LINE__);
    }
}

function createNewTables()
{
    global $dbClasses;

    executeQueryForUpdate("
        CREATE TABLE @subscription (
        id int(11) NOT NULL auto_increment,
        cid int(11) NOT NULL default '0',
        uid int(11) NOT NULL default '0',
        email varchar(255) NOT NULL default '',
        PRIMARY KEY  (id))", __FILE__, __LINE__);
    executeQueryForUpdate("
        CREATE TABLE @customfield (
          `id` int(11) NOT NULL auto_increment,
          `cid` int(11) NOT NULL default '0',
          `name` varchar(120) NOT NULL default '',
          `expl` text NOT NULL,
          `type` int(11) NOT NULL default '1',
          `subType` int(11) NOT NULL default '1',
          `rangeSearch` int(11) NOT NULL default '0',
          `values` text NOT NULL,
          `default_text` varchar(255) NOT NULL default '',
          `default_bool` int(11) NOT NULL default '0',
          `default_multiple` text NOT NULL,
          `mandatory` int(11) NOT NULL default '0',
          `showInList` int(11) NOT NULL default '0',
          `innewline` int(11) NOT NULL default '0',
          `rowspan` int(11) NOT NULL default '0',
          `displaylength` int(5) NOT NULL default '0',
          `allowHtml` int(11) NOT NULL default '0',
          `searchable` int(11) NOT NULL default '0',
          `hidden` int(11) NOT NULL default '0',
          `format` varchar(255) NOT NULL default '',
          `dateDefaultNow` int(11) NOT NULL default '0',
          `fromyear` varchar(20) NOT NULL default 'now',
          `toyear` varchar(20) NOT NULL default 'now',
          `sortable` int(11) NOT NULL default '0',
          `seo` int(11) NOT NULL default '0',
          `mainPicture` int(11) NOT NULL default '0',
          `columnIndex` int(11) NOT NULL default '0',
          `oldColumnIndex` varchar(255) NOT NULL default '',
          `sortId` int(11) NOT NULL default '0',
          `fields` int(11) NOT NULL default '0',
          PRIMARY KEY  (`id`)
        );", __FILE__, __LINE__);
    $dbClasses[]="rss";
    executeQueryForUpdate("
        CREATE TABLE @rss (
          `id` int(11) NOT NULL auto_increment,
          `title` varchar(255) NOT NULL default '',
          `description` text NOT NULL,
          `language` varchar(10) NOT NULL default 'en-us',
          PRIMARY KEY  (`id`)
        );", __FILE__, __LINE__);
}

function updateOtherTables()
{
    executeQueryForUpdate("INSERT INTO @notification VALUES (109, 0, 1, '', '', 'Auto notify email', 'Auto notify: a new ad has been submitted', 'title, url, unsubUrl', 'A new advertisement with title \'\$title\' has just been submitted.You can have a look at it under the following link:\n\$url\n\nIf you want to unsubscribe, click on the following link:\n\$unsubUrl', 1);", __FILE__, __LINE__);
    executeQueryForUpdate("REPLACE INTO @notification (`id`, `fixRecipent`, `fixCC`, `recipent`, `cc`, `title`, `subject`, `variables`, `body`, `active`) VALUES 
        (1, 0, 1, '', '', 'Sent to the user after the registration, contains the initial password', 'Initial password', 'uname, pwd, url', 'notifications/email_initial_password.html', 1)", __FILE__, __LINE__);
    executeQueryForUpdate("ALTER TABLE @user ADD active INT(11) NOT NULL default 0, ADD favorities TEXT NOT NULL;", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @user SET active=1 WHERE id!=name;", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @cronjob SET active=1;", __FILE__, __LINE__);
    executeQueryForUpdate("INSERT INTO @rss (`id`, `title`, `description`, `language`) VALUES 
    (1, 'Noah''s Classifieds RSS feed', 'Latest ads from Noah''s Classifieds', 'en-us');", __FILE__, __LINE__);
}

function updateGlobalstatAndFooter( $version )
{
    $versionFooterText = addcslashes("Powered by <a href='http://noahsclassifieds.org'>Noah's Classifieds</a> $version - 
                      <a href='http://open-classifieds.com' title='Best classifieds software script'>Update now to Open Classifieds</a>","'\\");
    executeQueryForUpdate("UPDATE @settings SET versionFooter='$versionFooterText' WHERE (locate('livetransactions', versionFooter) AND locate('noahsv8', versionFooter)) OR locate('noahsclassifieds.org', versionFooter)", __FILE__, __LINE__);
    executeQueryForUpdate("UPDATE @globalstat SET instver='$version'", __FILE__, __LINE__);
}

?>
