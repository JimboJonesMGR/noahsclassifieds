<?php

class Export extends Object
{
    
function create()
{
    global $lll, $noahVersion, $gorumroll;
    global $seoSeparator;

    $exportExtensions = array(customlist_xml=>"xml", customlist_csv=>"csv");
    
    hasAdminRights($isAdm);
    if( !$isAdm ) LocationHistory::rollBack(new AppController("/"));
    include(GORUM_DIR . "/gorum_view.php");
    $list = new CustomList;
    $list->activateVariableFields();
    if( loadSQL($list, array("SELECT * FROM @search WHERE id=#id#", $gorumroll->rollid)) || !$list->exportFormat ) return;
    $ext = $exportExtensions[$list->exportFormat];
    $date = date("Y-m-d-H-i-s");
    $fileName = LOG_DIR . "/export_$date.$ext";
    G::load( $unsortedColumns, "SELECT * FROM @itemfield WHERE FIND_IN_SET(id, '$list->exportFields')!=0" );
    // Hogy a $columns arary sorrendje ugyanaz legyen, mint $list->exportFields-ben:
    $columns = array();
    $length = count($unsortedColumns);
    foreach( explode(",", $list->exportFields) as $id )
    {
        for( $i=0; $i<$length; $i++ )
        {
            if( $unsortedColumns[$i]->id==$id ) 
            {
                $columns[]=$unsortedColumns[$i];
                break;
            }
        }
    }
    $ad = new Item;
    $ad->loadHtmlList($ads);
    array_walk( $columns, create_function('$v', '
        if( $v->userField ) 
        { 
            list( $v->userColumnIndex, $v->type, $v->name, $v->allowHtml) = G::getAttr($v->userField, "userfield", "columnIndex", "type", "name", "allowHtml");            
        }
        else $v->userColumnIndex = "";
        $v->name = preg_replace(array("/$[\d.-]/", "/[^\w:]/"), $seoSeparator, $v->name);'));
    $owner = new User;
    $owner->activateVariableFields();
    $fgName = "create_$ext";
    $this->$fgName($fileName, $list, $ads, $columns);
    $this->nextAction = new AppController("customlist/list");
    Roll::setInfoText("exportSavedAs", $fileName);
}

function create_xml($fileName, &$list, &$ads, &$columns)
{
    global $gorumroll;
    
    include(FEED_DIR . "/feedcreator.class.php");
    $ufc = new UniversalFeedCreator();
    $ufc->descriptionHtmlSyndicated = TRUE;
    $ufc->title = $list->listTitle;
    $ufc->description = $list->listDescription;
    $ctrl = new AppController("customlist/$list->id");
    $ufc->link = $ctrl->makeUrl(TRUE);
    $ufc->syndicationURL = $gorumroll->ctrl->makeUrl(TRUE);  // link to this page    
    $owner = new User;
    foreach( $ads as $ad )
    {
        $item = new FeedItem();
        $item->descriptionHtmlSyndicated = TRUE;
        $item->title = $ad->getTitle(FALSE);
        $ctrl = $ad->getLinkCtrl($item->title);
        $item->link=$ctrl->makeUrl(TRUE);
        $item->description = $ad->getDescription(FALSE);  // without htmlspecialchars()
        $item->date = (int)($ad->creationtime->getTimestamp());
        $item->additionalElements = array();
        foreach( $columns as $column )
        {
            if( isset($ad->{$column->columnIndex}) ) 
            {
                if( $column->userField ) 
                {
                    $owner->{$column->userColumnIndex} = $ad->{$column->columnIndex};
                    $content = $owner->showListVal($column->userColumnIndex, "", TRUE);
                }
                else $content = $ad->showListVal($column->columnIndex, "", TRUE);
                $item->additionalElements[$column->showListVal("name")] = 
                    array("html"=>$column->allowHtml ||
                                  $column->type==customfield_url || 
                                  $column->type==customfield_picture || 
                                  $column->type==customfield_media || 
                                  $column->columnIndex=="cName" || 
                                  $column->userColumnIndex=="email", 
                          "content"=>$content);
            }
        }
        $ufc->addItem($item);
    }
    $ufc->saveFeed($list->xmlType, $fileName, FALSE); 
}

function create_csv($fileName, &$list, &$ads, &$columns)
{
    global $gorumroll;
    
    if( !($f = fopen($fileName, "w")) ) return Roll::setInfoText($lll["couldntOpenExportFile"]);
    $owner = new User;
    foreach( $ads as $ad )
    {
        $item = new FeedItem();
        $item->descriptionHtmlSyndicated = TRUE;
        $item->title = $ad->getTitle(FALSE);
        $ctrl = $this->getLinkCtrl($item->title);
        $item->link=$ctrl->makeUrl(TRUE);
        $item->description = $ad->getDescription(FALSE);  // without htmlspecialchars()
        $item->date = (int)($ad->creationtime->getTimestamp());
        $item->additionalElements = array();
        foreach( $columns as $column )
        {
            if( isset($ad->{$column->columnIndex}) ) 
            {
                if( $column->userField ) 
                {
                    $owner->{$column->userColumnIndex} = $ad->{$column->columnIndex};
                    $content = $owner->showListVal($column->userColumnIndex, "", TRUE);
                }
                else $content = $ad->showListVal($column->columnIndex, "", TRUE);
                $item->additionalElements[$column->showListVal("name")] = 
                    array("html"=>$column->allowHtml ||
                                  $column->type==customfield_url || 
                                  $column->type==customfield_picture || 
                                  $column->type==customfield_media || 
                                  $column->columnIndex=="cName" || 
                                  $column->userColumnIndex=="email", 
                          "content"=>$content);
            }
        }
        $ufc->addItem($item);
    }
    $ufc->saveFeed($list->xmlType, $fileName, FALSE); 
}
}

?>
