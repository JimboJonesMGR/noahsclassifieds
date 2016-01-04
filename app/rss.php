<?php
defined('_NOAH') or die('Restricted access');
global $dbClasses;
$dbClasses[]="rss";

$rss_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "title"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"255",
                "min"=>1,
                "mandatory",
            ),
            "description"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>"40",
                "rows"=>"5"
            ),
            "language"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>10,
                "default"=>"en-us",
                "length"=>10,
            ),
            "category"=>array(
                "type"=>"INT",
                "form invisible",
                "no column"
            ),
            "user"=>array(
                "type"=>"INT",
                "form invisible",
                "no column"
            ),
            "latest"=>array(
                "type"=>"INT",
                "form invisible",
                "no column"
            ),
            "days"=>array(
                "type"=>"INT",
                "form invisible",
                "no column"
            ),
        ),
        "primary_key"=>"id"
    );
    
    
class RSS extends Object
{

function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $gorumrecognised, $lll;
    
    hasAdminRights($isAdm);
    if( $method=="modify" ) $hasRight->objectRight = $isAdm;
    elseif( $method=="create" || $method=="delete" ) $hasRight->objectRight = FALSE;
    else $hasRight->objectRight = TRUE;
    if( !$hasRight && $giveError )
    {
        handleError($lll["permission_denied"]);
    }
}

function modifyForm()
{
    $this->id=1;
    parent::modifyForm();
}

function getFeed()
{
    global $gorumroll, $item_typ, $lll;
    
    include(FEED_DIR . "/feedcreator.class.php");
    $ufc = new UniversalFeedCreator();
    $xmlFile = FEED_DIR . "/" . str_replace("/", "_", $gorumroll->queryString) . ".xml";
    //$ufc->useCached("RSS2.0", $xmlFile, 3600); // expires in one hour
    if( !empty($this->category) ) 
    {
        G::load( $cat, $this->category, "appcategory" );
        $ufc->title = $cat->name;
        $ufc->description = $cat->descriptionMeta ? $cat->descriptionMeta : $cat->description;
    }
    elseif( !empty($this->user) ) 
    {
        G::load( $user, $this->user, "user" );
        $ufc->title = $ufc->description = sprintf($lll["item_my_ttitle"], htmlspecialchars($user->name));
    }
    else 
    {
        G::load($rss, 1, "rss");
        $ufc->title = $rss->title;
        $ufc->description = $rss->description;
    }
    $ufc->link = Controller::getBaseUrl();
    $ufc->syndicationURL = $gorumroll->ctrl->makeUrl(TRUE);  // link to this page

    $query = "SELECT n.*, c.permaLink AS catPermaLink FROM @item AS n, @category AS c WHERE c.id=n.cid AND ";
    if( !empty($this->category) )
    {
        $query.=" cid='".quoteSQL($this->category)."' AND";
    }
    elseif( !empty($this->user) )
    {
        $query.=" ownerid='".quoteSQL($this->user)."' AND";
    }
    if( isset($this->days) )
    {
        $query.=" creationtime > NOW() - INTERVAL $this->days DAY AND";
    }
    $query.=" status=1";
    $query.=" ORDER BY creationtime DESC";
    if( !empty($this->latest) ) $query.=" LIMIT $this->latest";
    CustomField::addCustomColumns("item");
    G::load( $ads, $query );
    foreach( $ads as $ad )
    {
        $item = new FeedItem();
        $item->title = $ad->getTitle(FALSE);
        $ctrl = $ad->getLinkCtrl($item->title);
        $item->link=$ctrl->makeUrl(TRUE);
        $item->description = $ad->getDescription(FALSE);  // without htmlspecialchars()
        $item->date = (int)($ad->creationtime->getTimestamp());
        $image = new FeedImage(); 
        $picInfo = $ad->getPicture();
        if( $picInfo['picture'] )
        {
            $image->url = $picInfo;
            $image->title = $item->title; 
            $image->link = $item->link; 
            $image->description = $item->description;
            $item->image = $image;
        }
        $ufc->addItem($item);
    }
    $ufc->saveFeed("RSS2.0", $xmlFile); 
}

function getDump()
{
    $s = "<h1>Classifieds dump</h1>\n";
    $kn = isset($_GET["keepnewlines"]);
    if( !isset($this->category) )
    {
        $query = "SELECT id, name FROM @category WHERE up=0";
        $cats = new ClassifiedsCategory;
        loadObjectsSql( $cats, $query, $cats );
        foreach( $cats as $c )
        {
            $s.="<h2>".htmlspecialchars($c->name)."</h2>\n";    
            $query = "SELECT id, title, creationtime, ownerId, col_0";
            $query.=" FROM @item WHERE";
            $query.=" cid=$c->id";
            $query.=" ORDER BY creationtime DESC";        
            $ads = new Item;
            loadObjectsSql( $ads, $query, $ads );
            foreach( $ads as $ad )
            {
                $s.="<h4>".htmlspecialchars($ad->title)."</h4>\n";
                $s.=$kn ? nl2br($ad->col_0) : $ad->col_0;
            }
            $query = "SELECT id, name FROM @category WHERE up=$c->id";
            $subcats = new AppCategory;
            loadObjectsSql( $subcats, $query, $subcats );
            foreach( $subcats as $sc )
            {
                $s.="<h3>".htmlspecialchars($sc->name)."</h3>\n";    
                $query = "SELECT id, title, creationtime, ownerId, col_0";
                $query.=" FROM @item WHERE";
                $query.=" cid=$sc->id";
                $query.=" ORDER BY creationtime DESC";        
                $ads = new Item;
                loadObjectsSql( $ads, $query, $ads );
                foreach( $ads as $ad )
                {
                    $s.="<h4>".htmlspecialchars($ad->title)."</h4>\n";
                    $s.=$kn ? nl2br($ad->col_0) : $ad->col_0;
                }
            }
        }
    }
    else
    {
        G::load( $c, $this->category, "appcategory" );
        $s.="<h2>".htmlspecialchars($c->name)."</h2>\n";    
        $query = "SELECT id, title, creationtime, ownerId, col_0";
        $query.=" FROM @item WHERE";
        $query.=" cid=$c->id";
        $query.=" ORDER BY creationtime DESC";        
        $ads = new Item;
        loadObjectsSql( $ads, $query, $ads );
        foreach( $ads as $ad )
        {
            $s.="<h4>".htmlspecialchars($ad->title)."</h4>\n";
            $s.=$kn ? nl2br($ad->col_0) : $ad->col_0;
        }
        $query = "SELECT id, name FROM @category WHERE up=$c->id";
        $subcats = new AppCategory;
        loadObjectsSql( $subcats, $query, $subcats );
        foreach( $subcats as $sc )
        {
            $s.="<h3>".htmlspecialchars($sc->name)."</h3>\n";    
            $query = "SELECT id, title, creationtime, ownerId, col_0";
            $query.=" FROM @item WHERE";
            $query.=" cid=$sc->id";
            $query.=" ORDER BY creationtime DESC";        
            $ads = new Item;
            loadObjectsSql( $ads, $query, $ads );
            foreach( $ads as $ad )
            {
                $s.="<h4>".htmlspecialchars($ad->title)."</h4>\n";
                $s.=$kn ? nl2br($ad->col_0) : $ad->col_0;
            }
        }
    }
    echo $s;
    die();      
}

function initialize()
{
    $rss = new RSS;
    $rss->id = 1;
    $rss->title = "Noah's Classifieds RSS feed";
    $rss->description="Latest ads from Noah's Classifieds";
    $rss->language = "en-us";
    $rss->link = Controller::getBaseUrl();
    create($rss);
}

function makeRssFeed()
{
    global $gorumroll, $lll;
    
    $latestNum = 20;
    $feed=array();
    $params = "rss/latest/$latestNum";
    $ctrl = new AppController($params);
    $feed[] = array("link"=>$ctrl->makeUrl(), "label"=>sprintf($lll["rssLatest"], $latestNum), "linkClass"=>"color1");
    if( ($gorumroll->list=="appcategory" || $gorumroll->list=="item") && $gorumroll->method=="showhtmllist" && $gorumroll->rollid )
    {
        $params.= "/category/$gorumroll->rollid";
        $ctrl = new AppController($params);
        $feed[] = array("link"=>$ctrl->makeUrl(), "label"=>sprintf($lll["rssLatestInCategory"], $latestNum), "linkClass"=>"color2");
    }
    elseif( ($gorumroll->list=="user" && $gorumroll->method=="showdetails") )
    {
        $params.= "/user/$gorumroll->rollid";
        $ctrl = new AppController($params);
        $feed[] = array("link"=>$ctrl->makeUrl(), "label"=>sprintf($lll["rssLatestOfUser"], $latestNum), "linkClass"=>"color2");
    }
    View::assign("rssFeed", $feed);
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
    
    $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
    $navBarPieces[$lll["rss"]] = "";
    return $navBarPieces;
}
}

?>