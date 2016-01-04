<?php
defined('_NOAH') or die('Restricted access');
include("oodle.php");


$category_typ["attributes"]["description"] =
            array(
                "type"=>"TEXT",
                "textarea",
                "rows"=>5,
                "cols"=>50,
                "details",
                "allow_html",
                "safetext"
            );
$category_typ["attributes"]["picture"] =
            array(
                "type"=>"VARCHAR",
                "file",
                "max" =>"250"
             );
$category_typ["attributes"]["recursive"] =
            array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
            );
$category_typ["attributes"]["seoProperties"] =
            array(
                "type"=>"INT",
                "section",
                "no column",
            );
$category_typ["attributes"]["descriptionMeta"] =
            array(
                "type"=>"TEXT",
                "textarea",
                "rows"=>5,
                "cols"=>50,
                "details",
                "safetext"
            );
$category_typ["attributes"]["keywords"] =
            array(
                "type"=>"TEXT",
                "textarea",
                "rows"=>5,
                "cols"=>50,
                "details",
                "safetext",
            );
$category_typ["attributes"]["customAdMeta"] =
            array(
                "type"=>"TEXT",
                "textarea",
                "rows"=>25,
                "cols"=>50,
                "allow_html",
            );
$category_typ["attributes"]["expirationAndModerationProperties"] =
            array(
                "type"=>"INT",
                "section",
                "no column",
            );
$category_typ["attributes"]["allowAd"] =
            array(
                "type"=>"INT",
                "bool",
                "safetext",
                "default"=>"1",
            );
$category_typ["attributes"]["allowSubmitAdAdmin"] =
            array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "safetext"
            );
$category_typ["attributes"]["immediateAppear"] =
            array(
                "type"=>"INT",
                "bool",
                "safetext",
                "default"=>"1",
            );
$category_typ["attributes"]["inactivateOnModify"] =
            array(
                "type"=>"INT",
                "bool",
                "safetext",
                "default"=>"1",
            );
$category_typ["attributes"]["renewOnModify"] =
            array(
                "type"=>"INT",
                "bool",
                "safetext",
                "default"=>"0",
            );
$category_typ["attributes"]["expirationEnabled"]=
            array(
                "type"=>"INT",
                "default"=>"0",
                "safetext",
                "conditions"=>array("class_exists('response')"=>array("bool", "show_relation"=>"expirationEnabled")),
            );
$category_typ["attributes"]["expiration"]=
            array(
                "type"=>"INT",
                "text",
                "safetext",
                "default"=>"0",
                "conditions"=>array("class_exists('response')"=>array("relation"=>"expirationEnabled")),
            );
$category_typ["attributes"]["expirationOverride"]=
            array(
                "type"=>"INT",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAdmin, customfield_forManager),
                "default"=>"0",  // none
                "cols"=>1,
                "safetext",
                "conditions"=>array("class_exists('response')"=>array("radio", "relation"=>"expirationEnabled")),
            );
$category_typ["attributes"]["restartExpOnModify"] =
            array(
                "type"=>"INT",
                "bool",
                "safetext",
                "default"=>"0",
                "relation"=>"expirationEnabled"
            );
$category_typ["attributes"]["notificationLinksProperties"] =
            array(
                "type"=>"INT",
                "section",
                "no column",
            );
$category_typ["attributes"]["displayResponseLink"] =
            array(
                "type"=>"INT",
                "radio",
                "safetext",
                "default"=>"1",  // customfield_forAll
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forAllButAdmin, customfield_forManager),
            );
$category_typ["attributes"]["displayFriendmailLink"] =
            array(
                "type"=>"INT",
                "radio",
                "safetext",
                "default"=>"1",  // customfield_forAll
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forAllButAdmin, customfield_forManager),
            );

$category_typ["attributes"]["displayFlaggedLink"] =
            array(
                "type"=>"INT",
                "radio",
                "safetext",
                "default"=>"1",  // customfield_forAll
                "cols"=>"1",
                "values"=>array(customfield_forNone, customfield_forLoggedin, customfield_forAll, customfield_forAdmin, customfield_forAllButAdmin, customfield_forManager),
            );            

$category_typ["attributes"]["otherProperties"] =
            array(
                "type"=>"INT",
                "section",
                "no column",
            );
$category_typ["attributes"]["customAdListTitle"] =
            array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
                "safetext"
             );
$category_typ["attributes"]["customAdListTemplate"] =
            array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
                "safetext"
             );
$category_typ["attributes"]["customAdDetailsTemplate"] =
            array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
                "safetext"
             );
$category_typ["attributes"]["sortId"]=
            array(
                "type"=>"INT",
                "safetext",
                //"text",
                "list"
            );
$category_typ["attributes"]["depth"]=
            array(
                "type"=>"INT",
                "safetext",
                "no column",
                //"list"
            );
$category_typ["attributes"]["oodleProperties"] =
            array(
                "type"=>"INT",
                "section",
                "no column",
            );
$category_typ["attributes"]["enableOodle"]=
            array(
                "type"=>"INT",
                "bool",
                "default"=>"0",
                "conditions"=>array("class_exists('response')"=>array("bool", "show_relation"=>"enableOodle"))
            );
            
$category_typ["attributes"]["oodleRegion"]=
            array(
                "type"=>"VARCHAR",
                "max"=>255,
                "selection",
                "values"=>array(),
                "conditions"=>array("class_exists('response')"=>array("relation"=>"enableOodle"))
            );
$category_typ["attributes"]["oodleCategory"]=
            array(
                "type"=>"VARCHAR",
                "max"=>255,
                "selection",
                "values"=>array(),
                "conditions"=>array("class_exists('response')"=>array("relation"=>"enableOodle"))
            );
$category_typ["attributes"]["oodleLocation"] =
            array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
                "safetext",
                "conditions"=>array("class_exists('response')"=>array("relation"=>"enableOodle"))
             );
$category_typ["attributes"]["oodleRadius"] =
            array(
                "type"=>"INT",
                "text",
                "default"=>"30",
                "conditions"=>array("class_exists('response')"=>array("relation"=>"enableOodle"))
             );
$category_typ["attributes"]["oodleSearch"] =
            array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
                "safetext",
                "conditions"=>array("class_exists('response')"=>array("relation"=>"enableOodle"))
             );
$category_typ["attributes"]["oodleNum"] =
            array(
                "type"=>"INT",
                "text",
                "max" =>"50",
                "default"=>"10",
                "conditions"=>array("class_exists('response')"=>array("relation"=>"enableOodle"))
             );

            
$category_typ[]="smartform";
$category_typ["listOrder"]=array("name", "id", "up", "sortId", "depth");
$category_typ["showhtmllist: submit"]=array("updateHierarchy");
$category_typ[]="wrap_form";
$category_typ["keys"]="up";

class AppCategory extends Category
{

function get_table()
{
    return "category";
}

function initOodle()
{
    global $lll, $category_typ, $oodleRegions, $oodleCategories;
    
    $_S = new AppSettings();
    $attrInfo = & $category_typ["attributes"];
    foreach( $oodleRegions[$_S->oodleLocation] as $name => $value ) 
    {
        $attrInfo["oodleRegion"]["values"][]=$name;
        $lll["category_oodleRegion_".$name] = $value;
    }

    foreach( $oodleCategories as $cat ) 
    {
        foreach($cat as $name => $value)
        {
            $attrInfo["oodleCategory"]["values"][]=$name;
            $lll["category_oodleCategory_".$name] = $name;
        }
    }

}

function create($fromInstall = FALSE, $fromClone = FALSE)
{
    global $lll;

    if( !isset($this->sortId) )
    {
        $query = "SELECT MAX(sortId) as sortId FROM @category WHERE up=#up#";
        loadSQL( $catStat = new AppCategory, array($query, $this->up) );
        $this->sortId = isset($catStat->sortId) ? $catStat->sortId+100 : 100;
    }
    $this->handleExpirationFieldsContraversy();
    Category::create();
    if( !$fromClone && !Roll::isFormInvalid() )
    {
        $this->addDefaultCustomFields($fromInstall);
        $this->storeAttachment();
        Roll::setInfoText("created", $lll[$this->get_class()]);
    }
}

function addDefaultCustomFields($fromInstall = FALSE)
{
    global $lll;
    
    if( $this->up )
    {        
        // az alkategoria orokli az apja custom fieldjeit:
        G::load( $customFields, array("SELECT * FROM @customfield WHERE cid=#up#", $this->up));
        foreach( $customFields as $cf )
        {
            $cf->cid = $this->id;
            unset($cf->id);
            create($cf);
        }
    }
    else
    {
        ItemField::addDefaultCustomFields($fromInstall, $this->id);
    }
}

function modifyForm()
{
    global $lll, $gorumroll, $category_typ;

    $this->id = $gorumroll->rollid;
    load($this);

    $this->initOodle();


    if( $this->picture )
    {
        $picture = CAT_PIC_DIR . "/$this->id.$this->picture";
        shrinkPicture($width, $height, 70, 70, $picture);
        $ctrl = new AppController("cat/delete_picture/$this->id");
        $deleteLink = $ctrl->generAnchor($lll["deletePicture"]); 
        $lll["category_picture_embedfield"] = "
        <table id='deletePicture'>
          <tr>
            <td>%s</td>
            <td rowspan='2' class='deleteAfterSuccess'>
              <img src='$picture', width='$width' height='$height'>
            </td>
          </tr>
          <tr class='deleteAfterSuccess'>
            <td>$deleteLink</td>
          </tr>
        </table>";
        JavaScript::addOnload("
            $('#deletePicture a').click(function (){
                $.get(this.href, function(){
                    $('#deletePicture .deleteAfterSuccess').remove();
                });
                return false;
            });    
        ");
    }
    // Propagation:
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.center.js");  // to center the loading animation image
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/field.js");  // to retrieve the form field values
    JavaScript::addInclude(JS_DIR . "/propagate.js");
    
    // Propagate into all other categories:
    $propagatePostfix = OverlayController::addPropagateOverlay($this->id, "_cat");
    
    // Propagate into the subcategories only:
    getDbCount( $count, array("SELECT COUNT(*) FROM @category WHERE up=#id#", $this->id) );
    if( $count )  // ha leteznek egyaltalan sub category-k
    {
        $propagatePostfix .= " ".OverlayController::addPropagateOverlay( $this->id, "_cat", "_subcat" );
    }
    foreach( array_keys($category_typ["attributes"]) as $attr )
    {
        if( !in_array($attr, array("name","notificationLinksProperties","expirationAndModerationProperties","seoProperties", "otherProperties")) && 
            $this->getVisibility( $category_typ["attributes"][$attr], $attr )==Form_visible ) 
        {
            if( isset($lll["category_$attr"]) ) $lll["category_$attr"].=$propagatePostfix;
            elseif(isset($lll["appcategory_$attr"])) $lll["appcategory_$attr"].=$propagatePostfix;
            elseif(isset($lll[$attr])) $lll[$attr].=$propagatePostfix;
        }
    }
    parent::modifyForm();
}

function propagate( $intoSubcatsOnly=FALSE )
{
    global $gorumroll, $lll;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) die();
    if( !class_exists('rss') ) echo $lll["freeNotSupported"];
    $this->id = $gorumroll->rollid;
    $length = $this->propagateField($attr=$_POST["attr"], $_POST["value"], $intoSubcatsOnly);
    $label = isset($lll["category_$attr"]) ? $lll["category_$attr"] : (isset($lll["appcategory_$attr"]) ? $lll["appcategory_$attr"] : $lll[$attr]);
    if( $length ) echo sprintf($lll["catSuccessfullyPropagated"], $label, $length);
    else echo $lll["catNoPropagationOccured"];
    die();
}

function propagateField( $attr, $value, $intoSubcatsOnly=FALSE )
{
    global $lll;
    
    load($this);
    if( $intoSubcatsOnly )
    {
        $query = "SELECT * FROM @category AS c WHERE wholeName LIKE '".quoteSQL($this->wholeName)."%' AND id!=#id#";
    }
    else $query = "SELECT * FROM @category WHERE name='".quoteSQL($this->name)."' AND id!=#id#";
    G::load( $cats, array($query, $this->id ) );
    foreach( $cats as $cat )
    {
        if( $attr=="picture" ) // a picture masolasa specialis, mert nem a form-bol vesszuk az erteket
        {
            $value = $this->picture;
            @copy(CAT_PIC_DIR . "/$this->id".".".$this->picture, CAT_PIC_DIR . "/$cat->id".".".$this->picture);
        }
        executeQuery("UPDATE @category SET `attr`=#value# WHERE id=#id#", $attr, $value, $cat->id);
    }
    return count($cats);
}

function deletePicture()
{
    global $gorumroll;
    
    hasAdminRights($isAdm);
    if( !$isAdm ) die();
    @unlink(CAT_PIC_DIR . "/$gorumroll->rollid".".".$this->picture);
    executeQuery("UPDATE @category SET picture='' WHERE id=#id#", $gorumroll->rollid);
    die();
}

function modify( $whereFields="" )
{
    // betoltjuk aregi category-t:
    G::load( $oldObject, $this->id, "appcategory" );
    $this->handleExpirationFieldsContraversy();
    parent::modify($whereFields);
    // recursive esetben csak a wholeName valtoztatasarol van szo,
    // nincs attachment feltoltes, exp, vagy immediateAppear valtoztatas:    
    if( !Roll::isFormInvalid() )
    {
        $this->storeAttachment();
        $this->handleExpirationChanges($oldObject->expiration);
        $this->handleImmediateAppearChanges($oldObject->immediateAppear);
        CacheManager::resetCache($this->id);
    }
}

// biztositjuk, hogy ne legyen ellentmondas a kulonbozo expirationnel kapcsolatos mezok kozt:
function handleExpirationFieldsContraversy()
{
    if( isset($this->expirationEnabled) )
    {
        // ha az egyik nulla, a masiknak is nullanak kell lenni
        if( !$this->expirationEnabled ) 
        {
            $this->expiration = 0;
            $this->expirationOverride = customfield_forNone;
        }
        elseif( empty($this->expiration) && $this->expirationOverride==customfield_forNone ) $this->expirationEnabled=0;
    }
}

function handleExpirationChanges( $oldExp )
{
    if( !isset($this->expiration) ) return; // akkor lehet, ha allowAd=FALSE
    if( !$oldExp && $this->expiration )  // most allitjuk be az expirationt
    {
        $exp = Date::add($this->expiration, Date_Day);
        executeQuery("UPDATE @item SET expirationTime=#exp#, expEmailSent=0 WHERE cid=#this->id# AND status=1", $exp->getDbFormat(), $this->id);
    }
    elseif( $oldExp && !$this->expiration )  // most szuntetjuk meg az expirationt
    {
        executeQuery("UPDATE @item SET expirationTime=0, expEmailSent=0, renewalNum=0 WHERE cid=#this->id#", $this->id);
    }
    elseif( $this->expiration != $oldExp )  // lejarati ido valtoztatas
    {
        $diff = $this->expiration - $oldExp;
        executeQuery("UPDATE @item SET expirationTime=expirationTime + INTERVAL $diff DAY WHERE cid=#this->id# AND expirationTime!=0", $this->id);
        if( $diff>0 ) // hosszabbitas eseten
        {
            $_S = new AppSettings();
            // ha mar kuldtunk emailt, de a hosszabbitas reven ujra lagalabb expNoticeBefore tavlataba kerul a lejarat, akkor ujra kell majd kuldeni emailt:
            executeQuery("UPDATE @item SET expEmailSent=0 WHERE cid=#this->id# AND expEmailSent=1 AND DATEDIFF(expirationTime, NOW())>=#daysBefore#", $this->id, $_S->expNoticeBefore);
        }
    }
}

function handleImmediateAppearChanges( $oldImmediateAppear )
{
    if( !$oldImmediateAppear && $this->immediateAppear )
    {
        // ha eppen imediateAppear-ra allitottak, akkor minden inactive
        // ad-ot aktivra allitunk a kategoriaban:
        getDbCount( $count, array("SELECT COUNT(*) FROM @item WHERE cid=#this->id# AND status=0", $this->id));
        if( $this->expiration ) 
        {
            $expirationTime = Date::add($exp, Date_Day);
            $exp = ", expirationTime = '".$expirationTime->getDbFormat()."', expEmailSent=0";
        }
        else $exp="";
        executeQuery("UPDATE @item SET status=1 $exp WHERE cid=#this->id# AND status=0", $this->id);
        load($this);  // hogy a directItemNum betoltodjon
        $this->increaseDirectItemNum($count);
    }
}

function delete( $whereFields="" )
{
    global $recursive, $siteDemo;

    if( $siteDemo ) return Roll::setInfoText("This operation is not permitted in the demo.");
    Category::delete($whereFields);
    if( $this->picture )
    {
        $ret=@unlink(CAT_PIC_DIR . "/$this->id".".".$this->picture);
        if(!$ret) Roll::setInfoText("cantdelfile",$this->picture);
    }

    // Kitoroljuk az azonos id-ju customfield objektumokat is:
    executeQuery("DELETE FROM @customfield WHERE cid=#this->id#", $this->id);
    if( !$recursive )
    {
        $this->nextAction = new AppController("list/$this->up");  // a torles utan az apja listajara ugrunk
    }
}

function getNavBarPieces($absolute=FALSE)
{
    global $gorumroll, $lll;
    if( empty($this->id) ) return array();
    $ctrl = new AppController("/");
    $ctrl->setAbsolute($absolute);
    $navBarPieces = array($lll["home"] => $ctrl);
    $this->cacheFatherObjects();
    global $fatherCatList;
    foreach( $fatherCatList as $fatherCat )
    {
        if( $fatherCat->id!=$this->id )
        {
            $ctrl = $fatherCat->getLinkCtrl();
            $ctrl->setAbsolute($absolute);
            $navBarPieces[$fatherCat->getAttr("name")] = $ctrl;
        }
    }
    if( $gorumroll->method=="showhtmllist" && $gorumroll->list=="appcategory" )
    {
        $navBarPieces[htmlspecialchars($this->getAttr("name"))] = "";
    }
    else
    {
        $navBarPieces[$this->getAttr("name")] = $this->getLinkCtrl($absolute);
    }
    return $navBarPieces;
}

function showHtmlList()
{
    global $gorumroll, $populateTwoLevelsOfSubCategories;

    if( $gorumroll->rollid==="alternative" ) 
    {
        hasAdminRights($isAdm);
        if (!$isAdm) LocationHistory::rollBack(new AppController("/"));     
        
        ini_set("max_execution_time", 0);
        if( isset($_POST["sortId"]) ) return $this->organizeAlternative();
        return parent::showHtmlList();        
    }
    JavaScript::addCss(CSS_DIR . "/category.css");
    $s="";
    LocationHistory::saveGorumCategory($this->id = $gorumroll->rollid);
    // Ha ilyen-olyan torlesi kavarasok kovetkezteben ez az objektum
    // mar nem letezik, akkor a home-ra megyunk:
    if( load($this) ) $gorumroll->rollid = 0;
    $this->loadHtmlList($list);
    hasAdminRights($isAdm);
    $rangeSelText = "";
    $catArr = array();
    $i=0;
    foreach( $list as $listItem ) 
    {
        $ctrl = $listItem->getLinkCtrl();
        $catArr[$i]->link=$ctrl->makeUrl();
        $catArr[$i]->title=htmlspecialchars($listItem->getAttr("name"));
        $catArr[$i]->description=$listItem->getAttr("description");
        $catArr[$i]->itemNum=$listItem->itemNum;
        if( $listItem->picture ) 
        {
            $catArr[$i]->picture=CAT_PIC_DIR . "/$listItem->id.$listItem->picture";
        }
        else $catArr[$i]->picture="";
        if( $populateTwoLevelsOfSubCategories ) AppCategory::populateTwoLevelsOfSubCategories($listItem->id, $catArr[$i]->subCats);
        $i++;
    }
    if( $gorumroll->rollid && ($this->allowAd || $this->recursive) ) // Home-ban nem kell
    {
        $ctrl = new AppController("item/list/$gorumroll->rollid");
        $gorumroll->processMethod($ctrl, "advertisementList" );
    }
    View::assign( "categories", $catArr );
}

function loadHtmlList(&$list)
{
    global $gorumroll;
    
    if( $gorumroll->rollid!=="alternative" ) return parent::loadHtmlList($list);
    $item = new Item;
    $list = $item->getSelectFromTree(FALSE, TRUE);
}

function valid()
{
    if (!isset($_FILES["picture"]["name"]) ||
        $_FILES["picture"]["name"]=="")
    {
        return Category::valid();
    }
    if (isset($_FILES["picture"]["name"]) && strstr($_FILES["picture"]["name"]," "))
    {
        return Roll::setFormInvalid("spacenoatt");
    }
    if ($_FILES["picture"]["size"]==0) 
    {
        return Roll::setFormInvalid("picFileSizeNull");
    }
    if ($_FILES["picture"]["tmp_name"]=="none") 
    {
        return Roll::setFormInvalid("picFileSizeToLarge1");
    }
    if (!is_uploaded_file( //ONLY from php 4.02 !!!
            $_FILES["picture"]["tmp_name"]))
    {
        handleError("Possible attack");
    }
    $fname=$_FILES["picture"]["tmp_name"];
    $size = getimagesize( $fname );
    if (!$size) return Roll::setFormInvalid("notValidImageFile");
    return Category::valid();
}

function storeAttachment()
{
    if (!isset($_FILES["picture"]["name"]) || $_FILES["picture"]["name"]=="") return;
    $fname=$_FILES["picture"]["tmp_name"];
    $f=@fopen($fname,"r");
    if (!$f)  return Roll::setInfoText("cantOpenFile");
    $extensions = array("", "gif", "jpg", "png");
    //$checkBits = array(0, IMG_GIF, IMG_JPG, IMG_PNG);
    $size = getimagesize( $fname );
    $type = $size[2]; // az image tipus, 1=>GIF, 2=>JPG, 3=>PNG
    $file = fread($f,$_FILES["picture"]["size"]);
    $ext = $extensions[$type];
    $foname = CAT_PIC_DIR . "/$this->id".".".$ext;
    $fo = fopen($foname,"w");
    //TODO: error handle
    fwrite( $fo,$file);
    fclose( $fo );
    // attempt to chmod the file, so that an FTP user can have read and write access to it, too:
    chmod($foname, 0666);
    /*
    $foname_gray = CAT_PIC_DIR$this->id"."_gray.".$ext;
    if( defined("IMG_GIF") && function_exists("ImageTypes") )  // GD support
    {
        // mas fg-eket kell hivni az image tipusnak megfeleloen:
        $create_fg = array("", "ImageCreateFromGIF", "ImageCreateFromJPEG",
                               "ImageCreateFromPNG");
        $save_fg = array("", "ImageGIF", "ImageJPEG", "ImagePNG");
        $src_im = $create_fg[$type]($fname);
        if( $src_im && imagefilter($src_im, IMG_FILTER_GRAYSCALE) )
        {
            $save_fg[$type]( $src_im, $foname_gray );
        }
        imagedestroy($src_im);
    }
    else copy($foname, $foname_gray);
    */
    // A picture-ben csak azt taroljuk el, hogy mi a kiterjesztes:
    executeQuery( "UPDATE @category SET picture=#$ext# WHERE id=#this->id#", $ext, $this->id );
    $_FILES["picture"]["name"]="";
    return ok;
}

// Ez azert kell, mert a catregory listben egy kategory list es egy
// ad list is van, de a lapozo toolnak csak az ad listre kell
// vonatkoznia
function getLimit()
{
    return "";
}

function organizeForm()
{
    global $gorumroll, $lll, $jQueryLib, $curvyCorners, $lll, $siteDemo, $paginateCategoryOrganizerFromNumberOfCats, $infoText;

    hasAdminRights( $isAdm );
    if( !$isAdm ) handleErrorPerm( __FILE__, __LINE__ );
    if( !class_exists('rss') ) return;
    
    $_S = new AppSettings();
    if( $gorumroll->rollid==="alternative" || $_S->alternativeOrganizer ) 
    {
        $this->organizeFormAlternative();
        return;
    }
    
    JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/interface/iutil.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/interface/idrag.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/interface/idrop.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/interface/isortables.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/inestedsortable.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.nestedsortablewidget.js");
    JavaScript::addCss(CSS_DIR . "/nestedsortablewidget.css");
    JavaScript::addCss(CSS_DIR . "/checkconf.css");
    if( !empty($curvyCorners) )
    {
        if( $infoText && !$siteDemo ) Roll::setInfoText("useDragAndDrop");
        elseif( $siteDemo ) Roll::setInfoText("Use drag-and-drop to reorganize the categories!");
    }
    else Roll::setInfoText("");
    if( $this->getCategoryCount()>$paginateCategoryOrganizerFromNumberOfCats )
    {
        $paginate = ", paginate: true, itemsPerPage: $paginateCategoryOrganizerFromNumberOfCats";
    }
    else $paginate = "";
    JavaScript::addOnload("
        $('#organize_widget').NestedSortableWidget({
            loadUrl: '$_SERVER[PHP_SELF]',
            loadUrlParams: {list: 'appcategory', method: 'get_json_tree'},
            loadRequestType: 'POST',
            saveUrl: 'index.php',
            saveUrlParams: {list: 'appcategory', method: 'organize'},
            colsWidth: [200,80,80,100],
            padding: [4, 5, 4, 10],
            whiteMargin: 1,
            fadeOutHover: false,
            onLoad: function(){
                $('.nsw-save-progress-wrap').eq(1).hide();
            },
            text: {
                saveButton: '$lll[organizeSaveButton]',
                saveMessage: '$lll[organizeSaveMessage]',
                saveError: '$lll[organizeSaveError]',
                nextPageDrop: '$lll[organizeNextPageDrop]',
                previousPageDrop: '$lll[organizePreviousPageDrop]',
                nextItems: '$lll[organizeNextItems]',
                previousItems: '$lll[organizePreviousItems]',
                loadError: '$lll[organizeLoadError]'
            }
            $paginate
        });
    ");
}  

function & getCategoryTree( $cats, $cols='*', $withIndex=TRUE )
{
    $tree = array();
    for( $i=0; $i<count($cats); $i++ )
    {
        unset($cats[$i]->creationtime);
        // TODO: subCatNum egyszeruen nem megbizhato
        /*
        if( $cats[$i]->subCatNum )
        {
            G::load( $subCats, "SELECT $cols FROM @category WHERE up={$cats[$i]->id} ORDER BY sortId ASC" );
            $node = array("cat"=>$cats[$i], "subCats"=>$this->getCategoryTree( $subCats, $cols, $withIndex ));
        }
        else $node = array("cat"=>$cats[$i], "subCats"=>array());
        */
        G::load( $subCats, "SELECT $cols FROM @category WHERE up={$cats[$i]->id} ORDER BY sortId ASC" );
        $node = array("cat"=>$cats[$i], "subCats"=>$this->getCategoryTree( $subCats, $cols, $withIndex ));
        if( $withIndex ) $node["index"]=$i;
        $tree[]=$node;    
    }
    return $tree;
}

function getJsonTree()
{
    global $lll;
    
    hasAdminRights( $isAdm );
    if( !$isAdm ) handleErrorPerm( __FILE__, __LINE__ );

    ini_set("max_execution_time", 0);
    $count = $this->getCategoryCount();
    G::load( $cats, "SELECT * FROM @category WHERE up=0 ORDER BY sortId ASC" );
    $tree = & $this->getCategoryTree( $cats );
    $requestFirstIndex = isset($_POST["requestFirstIndex"]) ? $_POST["requestFirstIndex"] : 0;
    $s='
        {
          "requestFirstIndex" : '.$requestFirstIndex.',
          "firstIndex" : 0,
          "count": '.$count.',
          "totalCount" :'.$count.',
          "columns":["'.$lll["name"].'", "'.$lll["methods"].'", "'.$lll["appcategory_allowAd"].'", "'.$lll["exp"].'", "'.$lll["unmoderated"].'"],
          "items": 
          [';
            for( $i=0; $i<count($tree); $i++ ) $s.=$this->treeNodeToJson($tree[$i]);
    $s.=" ]
        }";
    echo $s;
    die();
}

function getCategoryCount()
{
    getDbCount( $count, "SELECT COUNT(*) FROM @category" );
    return $count;
}

function treeNodeToJson($node)
{
    $s="";
    if( $node["index"] ) $s.=",\n";
    $s.="{\n";
    $s.='"id": '.$node["cat"]->id.',';
    $s.='"info": ["' . addcslashes(htmlspecialchars($node["cat"]->getAttr("name")), '"') . '", "' . 
                       $node["cat"]->showTools() . '", "' . 
                       $node["cat"]->showListVal("allowAd") . '", "' . 
                       $node["cat"]->showListVal("expiration") . '", "' . 
                       $node["cat"]->showListVal("immediateAppear") . '"]';
    if( count($node["subCats"]) )
    {
        $s.=',
            "children": 
            [
            ';
                for( $i=0; $i<count($node["subCats"]); $i++ ) $s.=$this->treeNodeToJson($node["subCats"][$i]);
        $s.=']
        ';
    }
    $s.="}\n";
    return $s;    
}

function getHtmlTree( &$tree, $mainTag='ul', $mainClass='', $activeClass='', $withLinks=FALSE )
{
    $class = $mainClass ? " class='$mainClass'" : "";
    $s="<$mainTag$class>\n";
    for( $i=0; $i<count($tree); $i++ ) $s.=$this->treeNodeToHtml($tree[$i], $mainTag, $mainClass, $activeClass, $withLinks, 2 );
    $s.="</$mainTag>\n";
    return $s;
}

function treeNodeToHtml($node, $mainTag, $mainClass, $activeClass, $withLinks, $depth )
{
    global $gorumcategory;
    
    $leafTag = $mainTag=='ul' || $mainTag=='ol' ? 'li' : 'div';
    
    $class = $activeClass && $gorumcategory==$node["cat"]->id ? " class='$activeClass'" : "";
    $padding = str_repeat("  ", $depth);
    $s="$padding<$leafTag$class>\n";
    if( $withLinks )
    {
        $ctrl = $node["cat"]->getLinkCtrl();
        $s.=$padding."  ".$ctrl->generAnchor($node["cat"]->getAttr("name"));
    }
    else 
    {
        $s.=$padding."  ".htmlspecialchars($node["cat"]->getAttr("name"));
    }
    $s.="\n";
    if( count($node["subCats"]) )
    {
        $s.="$padding  <$mainTag>\n";
        for( $i=0; $i<count($node["subCats"]); $i++ ) $s.=$this->treeNodeToHtml($node["subCats"][$i], $mainTag, $mainClass, $activeClass, $withLinks, $depth+2 );
        $s.="$padding  </$mainTag>\n";
    }
    $s.="$padding</$leafTag>\n";
    return $s;    
}

function getArrayFromCategoryTree(&$tree, &$arr, $cond='1', $depth=0)
{
    foreach( $tree as $node )
    {
        $node['cat']->depth = $depth;
        eval('$c = '.$cond.';');
        if( $c ) $arr[] = $node['cat'];
        $this->getArrayFromCategoryTree($node['subCats'], $arr, $cond, $depth+1);
    }
}

function organize()
{
    global $siteDemo;
    
    hasAdminRights( $isAdm );
    if( !$isAdm ) handleErrorPerm( __FILE__, __LINE__ );
    if( !class_exists('rss') || $siteDemo ) return;
    
    ini_set("max_execution_time", 0);
    $hierarchyChanged = FALSE;
    $sortId = 100;
    $firstIndex = 0;
    // ebben osszegyujtjuk az osszes olyan kategoria id-jet, ami egy valtoztatott blokkban van:
    $cidsInBlocksSoFar = array();
    if( AppCategory::is_assoc($_REQUEST['nested-sortable-widget']) ) $modifiedBlocks = array($_REQUEST['nested-sortable-widget']);
    else $modifiedBlocks = & $_REQUEST['nested-sortable-widget'];
    //FP::log($modifiedBlocks);
    // ha nincs pagination:
    if( count($modifiedBlocks)==1 && $modifiedBlocks[0]["count"]==$this->getCategoryCount() )
    {
        //$fp->log("No pagination");
        $this->updateOrderIter( $modifiedBlocks[0], $sortId, $firstIndex, $hierarchyChanged, $cidsInBlocksSoFar );
    }
    else
    {
        //$fp->log("Pagination");
        // lekerjuk a valtoztatas elotti kategoria fat, mert ossze kell fesulni a valtoztatott blokkokkal:
        G::load( $cats, "SELECT * FROM @category WHERE up=0 ORDER BY sortId ASC" );
        $tree = & $this->getCategoryTree( $cats );
        //$fp->log($tree, "Tree");
        $firstNode = & $tree[0];
        // $tIndex egy tomb ami a tree egy agan levo node-okra mutato referenciakat tartalmaz:
        $tIndex = array($firstNode);
        foreach( $modifiedBlocks as $block )  // vegigmegyunk a blokkokon
        {
            //$fp->group("Block begins - first index: $firstIndex");
            //$fp->log($sortId, "Starting sortId");
            //$fp->log($block["firstIndex"], "First index of the block");
            // a regi fa nodjainak sortId-jit frissitgetjuk addig, amig el nem jutunk az aktualis blokkig:
            while( $firstIndex < $block["firstIndex"] )
            {
                $this->updateOriginalTreeNode( $tree, $tIndex, $sortId );
                $firstIndex++;
            }
            //$fp->log($firstIndex, "First index after updating old nodes");
            //$fp->log($sortId, "SortId after updating old nodes");
            // a blokk elemeinek update-je:
            $this->updateOrderIter( $block, $sortId, $firstIndex, $hierarchyChanged, $cidsInBlocksSoFar );
            //$fp->log($firstIndex, "First index after updating block");
            //$fp->log($sortId, "SortId after updating block");
            // amig az a blokkokban mar szereplo nodokat tartalmaz, "skippeljuk" a regi fat:
            while( $tIndex && in_array($tIndex[count($tIndex)-1]["cat"]->id, $cidsInBlocksSoFar) ) $this->advanceTreeIndex($tree, $tIndex);
            //$fp->groupend();
        }
        //$fp->group("Updating the rest of the old nodes");
        // az osszes valtoztatott blokk utani regi faban levo elemet is update-ezni kell:
        while( $tIndex ) $this->updateOriginalTreeNode( $tree, $tIndex, $sortId );
        //$fp->groupend();
    }
    if( $hierarchyChanged ) $this->recalculateAllItemNums(TRUE);
    die();
}

function updateOriginalTreeNode( &$tree, &$tIndex, &$sortId )
{    
    // a $tIndex altal mutattott aktualis node-hoz tartozo kategoria sortId-jet frissitjuk.
    // az aktualis node mindig a $tIndex utolso eleme:
    //$fp->log("Setting sortId original node: id: ".$tIndex[count($tIndex)-1]["cat"]->id.", sortId: $sortId" );
    executeQuery("UPDATE @category SET sortId=#sortId# WHERE id=#id#", $sortId, $tIndex[count($tIndex)-1]["cat"]->id);
    $sortId+=100;  
    $this->advanceTreeIndex($tree, $tIndex);
}

// $tIndex egy tomb ami a tree egy agan levo node-okra mutato referenciakat tartalmaz
function advanceTreeIndex( &$tree, &$tIndex )
{
    // "leptetjuk" a $tIndexet a fa melysegi bejarasa szerinti kovetkezo node-ra.
    // a lev�l-node-tol kezdve keressuk a tovabbhaladasi lehetoseget:
    $i=count($tIndex)-1;
    // ha vannak al-kategoriak, akkor tudunk egyel melyebbre menni a faban:
    if( count($tIndex[$i]["subCats"]) ) 
    {
        $tIndex[]=$tIndex[$i]["subCats"][0];
    }
    // ha a node-dal azonos szinten, letezik meg tovabbi alkategoria, akkor a node-ot kicsereljuk ra:
    elseif( $i && isset($tIndex[$i-1]["subCats"][$tIndex[$i]["index"]+1]) )
    {
        $tIndex[$i]=$tIndex[$i-1]["subCats"][$tIndex[$i]["index"]+1];
    }
    // ha nem letezik, visszalepunk annyival, amennyivel csak szukseges:
    elseif( $i ) 
    {
        while( $i ) // amig tudunk visszalepni
        {
            unset($tIndex[$i--]);
            // ha a visszalepes utani szinten, van tovabbi alkategoria:
            if( $i && isset($tIndex[$i-1]["subCats"][$tIndex[$i]["index"]+1]) )
            {
                $tIndex[$i]=$tIndex[$i-1]["subCats"][$tIndex[$i]["index"]+1];
            }
            elseif( !$i )
            {
                //$fp->log($tIndex[$i]["index"]+1, "Checking root index");
                // ha a gyokerben vagyunk es letezik tovabbi fo-kategoria, akkor tovabblepunk ra:
                if( isset($tree[$tIndex[$i]["index"]+1]) ) $tIndex[$i] = & $tree[$tIndex[$i]["index"]+1];
                else $tIndex=FALSE; // ha nincs tobb node a faban
            }
        }
    }
    else
    {
        //$fp->log($tIndex[$i]["index"]+1, "Checking root index");
        // ha a gyokerben vagyunk es letezik tovabbi fo-kategoria, akkor tovabblepunk ra:
        if( isset($tree[$tIndex[$i]["index"]+1]) ) $tIndex[$i] = & $tree[$tIndex[$i]["index"]+1];
        else $tIndex=FALSE; // ha nincs tobb node a faban
    }
    //if( $tIndex ) $fp->log(array_map(create_function('$v', 'return array($v["cat"]->id, $v["index"]);'), $tIndex), "tIndex");
    //else $fp->log($tIndex, "tIndex" );
}

function updateOrderIter( &$node, &$sortId, &$firstIndex, &$hierarchyChanged, &$cidsInBlocksSoFar )
{
    $wholeNamePrefix=$permaLinkPrefix="";
    $firstIndex += count($node["items"]);
    foreach( $node["items"] as $n )
    {
        $this->updateOrder( $n, 0, $sortId, $wholeNamePrefix, $permaLinkPrefix, $hierarchyChanged, $cidsInBlocksSoFar ); 
    }
}

function is_assoc($array) 
{
    foreach (array_keys($array) as $k => $v) 
    {
        if ($k !== $v) return true;
    }
    return false;
}

function updateOrder( $node, $up, &$sortId, $wholeNamePrefix, $permaLinkPrefix, &$hierarchyChanged, &$cidsInBlocksSoFar )
{
    global $seoSeparator;

    $cidsInBlocksSoFar[] = $node["id"];
    if( !isset($node['oldUp']) ) list( $oldUp, $name ) = G::getAttr( $node["id"], "appcategory", "up", "name" );
    else list( $oldUp, $name ) = array($node['oldUp'], $node['name']);
    $wholeName = $wholeNamePrefix ? $wholeNamePrefix." - ".$name : $name;
    $permaName = $this->seoConvert($name, $seoSeparator);
    $permaLink = $permaLinkPrefix ? $permaLinkPrefix."/".$permaName : $permaName;
    //FP::log("Setting sortId block node: id: ".$node["id"].", sortId: $sortId, up: $up" );
    executeQuery("UPDATE @category SET up=#up#, wholeName=#wholeName#, permaLink=#permaLink#, sortId=#sortId# WHERE id=#id#", 
                 $up, $wholeName, $permaLink, $sortId, $node["id"]);
    //file_put_contents("test.html", "$node[id]: $sortId\n", FILE_APPEND );
    $hierarchyChanged = $hierarchyChanged || $oldUp!=$up;
    $sortId+=100;
    if( isset($node["children"]) ) 
    {
        foreach( $node["children"] as $subNode ) $this->updateOrder( $subNode, $node["id"], $sortId, $wholeName, $permaLink, $hierarchyChanged, $cidsInBlocksSoFar );
    }
}

function showTools()
{
    global $lll;
    
    $ctrl1 = new AppController("appcategory/modify_form/$this->id");
    $ctrl2 = new AppController("appcategory/delete_form/$this->id");
    $ctrl4 = new AppController("field/sortfield_form/$this->id");
    $ctrl3 = new AppController("clonecat/create_form/$this->id");
    return "<span class='methods'>".$ctrl1->generAnchor($lll["icon_modify"]) . " | " . 
                                    $ctrl2->generAnchor($lll["icon_delete"]) . " | " . 
                                    $ctrl3->generAnchor($lll["clone"]) . " | " . 
                                    $ctrl4->generAnchor($lll["fields"])."</span>";
}

function organizeFormAlternative()
{
    global $gorumroll, $contentSeparator, $lll, $tA;
    
    $_S = new AppSettings();
    $contentSeparator="";
    $tA["appcategory-organize_form"] = $tA["appcategory-organize_form-alternative"];
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.alphanumeric.js");
    JavaScript::addOnload("$('#appcategory-showhtmllist input:text').numeric();");                      
    JavaScript::addCss(CSS_DIR . "/checkconf.css");
    $lll["appcategory_ttitle"] = $lll["alwaysUseAlternativeOrganizer"];
    $lll["appcategory_ttitle"].= GenerWidget::generBoolField("alternativeOrganizer", "", $_S->alternativeOrganizer);
    $ctrl = new AppController("cat/list/alternative");
    $gorumroll->processMethod($ctrl, "categoryList" );
}

function organizeAlternative()
{
    ini_set("max_execution_time", 0);
    $ao = empty($_POST["alternativeOrganizer"]) ? 0 : 1;
    executeQuery("UPDATE @settings SET alternativeOrganizer=$ao");
    $cats = array();
    foreach( $_POST["up"] as $id=>$up )
    {
        $cat = array('id'=>$id, 'up'=>$up, 'name'=>$_POST["name"][$id], 'oldUp'=>$_POST["oldUp"][$id], 'sortId'=>$_POST["sortId"][$id]);
        if( isset($cats[$up]) ) $cats[$up][]=$cat;
        else $cats[$up] = array($cat);
    }
    foreach( $cats as $up=>$level ) usort($cats[$up], create_function('$a, $b', 'return $a["sortId"]<$b["sortId"] ? -1 : 1;'));
    //FP::log($cats, "Cats");
    $modifiedTree = array("count"=>count($_POST["up"]), "firstIndex"=>"0", "items"=>array());
    foreach( $cats[0] as $cat )
    {
        $this->addToModifiedTree( $modifiedTree['items'], $cats, $cat );
    }
    //FP::log($modifiedTree, "modifiedTree");
    
    $hierarchyChanged = FALSE;
    $sortId = 100;
    $firstIndex = 0;
    $cidsInBlocksSoFar = array();
    $this->updateOrderIter( $modifiedTree, $sortId, $firstIndex, $hierarchyChanged, $cidsInBlocksSoFar );
    if( $hierarchyChanged ) $this->recalculateAllItemNums(TRUE);
    LocationHistory::rollBack(new AppController("cat/organize_form/alternative"));
}

function addToModifiedTree( &$modifiedTree, &$cats, $cat )
{
    if( isset($cats[$cat['id']]) ) 
    {
        $cat['children'] = array();
        foreach( $cats[$cat['id']] as $c ) $this->addToModifiedTree( $cat['children'], $cats, $c );
    }
    $modifiedTree[] = $cat;
}

function hasModeration()
{
    static $hasModeration = FALSE;
    
    if( $hasModeration!==FALSE ) return $hasModeration;
    getDbCount( $hasModeration, "SELECT COUNT(*) FROM @category WHERE immediateAppear=0" );
    return $hasModeration;
}

function hasExpiration()
{
    static $hasExpiration = FALSE;
    
    if( $hasExpiration!==FALSE ) return $hasExpiration;
    getDbCount( $hasExpiration, "SELECT COUNT(*) FROM @category WHERE expirationEnabled=1" );
    return $hasExpiration;
}

function getOneLevelOfCategories($cid, $excludeAdminOnlySubmitCats=FALSE)
{
    hasAdminRights($isAdm);
    $exclude = ($excludeAdminOnlySubmitCats && !$isAdm) ? "AND allowSubmitAdAdmin=0" : ""; 
    $query = "SELECT id, name, allowAd, recursive, permaLink FROM @category WHERE up=#cid# $exclude ORDER BY sortId ASC";
    G::load($fields, array($query, $cid));
    return $fields;
}

function getOneLevelOfCategoriesAjax($excludeAdminOnlySubmitCats=FALSE)
{
    global $gorumroll, $lll;
    list($allowAd, $recursive) = G::getAttr( $gorumroll->rollid, "appcategory", "allowAd", "recursive");
    $fields = $this->getOneLevelOfCategories($gorumroll->rollid, $excludeAdminOnlySubmitCats);
    if( count($fields) )
    {
        $values = array_map(create_function('$v', 'return $v->id;'), $fields);
        $labels = array_map(create_function('$v', 'return htmlspecialchars($v->getAttr("name"));'), $fields);  
        $rels =   array_map(create_function('$v', 'return $v->allowAd;'), $fields);
        array_unshift($values, 0);
        array_unshift($labels, $lll["selectCategory"]);  
        array_unshift($rels, intval($allowAd || $recursive));
        $fields = GenerWidget::generSelectOptions($labels,$values, 0, '', $rels);
    }
    else $fields = "";
    echo '{ "allowAd": '.intval($allowAd || $recursive).', "fields": "'.str_replace("\n", "", addcslashes($fields, '"')).'" }';
    die();
}

function assignCurrentCategoryFields()
{
    global $gorumcategory, $populateFullCategoryTree, $populateTwoLevelsOfSubCategories, $populateAdjacentSiblingCategories;
    
    if( $gorumcategory )
    {
        G::load( $cat, $gorumcategory, "appcategory" );
        $catArr = array();
        foreach( get_object_vars($cat) as $attr=>$value ) 
        {
            if( !in_array($attr, array("ecomm", "globalStat", "s", "creationtime", "name")) )
            {
                $catArr[$attr] = $cat->showListVal($attr);
            }
            elseif( $attr=="name" )
            {
                $catArr["link"] = $cat->showListVal("name");
                $catArr["name"] = htmlspecialchars($cat->getAttr("name"));
            }
        }
        if( $populateTwoLevelsOfSubCategories ) AppCategory::populateTwoLevelsOfSubCategories( $cat->id, $catArr["subCats"] );
        if( $populateAdjacentSiblingCategories ) 
        {
            if( $cat->up ) 
            {
                G::load( $father, $cat->up, "appcategory" );
                $catArr["fatherCat"]["link"] = $father->showListVal("name");
                $catArr["fatherCat"]["name"] = htmlspecialchars($father->getAttr("name"));
            }
            AppCategory::populateTwoLevelsOfSubCategories( $cat->up, $catArr["adjacentSiblingCats"] );
        }
        View::assign("currentCategory", $catArr);
    }
    else View::assign("currentCategory", 0);
    if( $populateFullCategoryTree ) AppCategory::populateFullCategoryTree();
}

function populateTwoLevelsOfSubCategories($catId, &$arr)
{
    $arr = array();
    $subCats = AppCategory::getOneLevelOfCategories($catId);
    for( $i=0; $i<count($subCats); $i++  )
    {
        $arr[$i]["link"] = $subCats[$i]->showListVal("name");
        $arr[$i]["name"] = htmlspecialchars($subCats[$i]->getAttr("name"));
    }
}

function populateFullCategoryTree()
{
    global $categoryTreeFormat, $categoryTreeMainClass, $categoryTreeMainTag, $categoryTreeActiveNodeClass, 
           $categoryTreeParentNodeClass, $categoryTreeLeafNodeClass, $categoryTreeWithLinks;
    
    $attrs = "id, name, up, sortId, wholeName, itemNum, permaLink, subCatNum";
    if( $categoryTreeFormat=="single_array" )
    {
        $item = new Item;
        $categories = $item->getSelectFromTree(FALSE, TRUE, $attrs);
    }
    else
    {
        $query = "SELECT $attrs FROM @category WHERE up=0 ORDER BY sortId ASC";
        G::load( $mainCats, $query );
        $cat = new AppCategory();
        $categories = & $cat->getCategoryTree( $mainCats, $attrs, FALSE );
        if( $categoryTreeFormat=="html" )
        {
            $categories = $cat->getHtmlTree($categories, $categoryTreeMainTag, $categoryTreeMainClass, $categoryTreeActiveNodeClass, $categoryTreeWithLinks);
        }
    }
    View::assign("fullCategoryTree", $categories);
}

function getLinkCtrl($absolute=FALSE)
{
    $_S = new AppSettings;
    if( $_S->permaLinksEnabled() )
    {        
        $ctrl = new AppController();
        $ctrl->setPermaLink($this->permaLink);
    }
    else $ctrl = new AppController("cat/list/$this->id");
    $ctrl->setAbsolute($absolute);
    return $ctrl;
}

function showListVal($attr)
{
    global $gorumroll;

    if( $gorumroll->rollid!=="alternative" ) return parent::showListVal($attr);
    if( $attr=="name" )
    {
        $s = parent::showListVal($attr);
        if( isset($this->depth) ) return "<div style='padding-left: ".(20*$this->depth)."px;'>$s</div>";
        return $s;
    }
    elseif( $attr=="sortId" )
    {
        return GenerWidget::generTextField("text","sortId[$this->id]",$this->sortId, 6);
    }
    elseif( $attr=="up" )
    {
        $s = GenerWidget::generTextField("text","up[$this->id]",$this->up, 6);
        $s.= GenerWidget::generHiddenField("name[$this->id]",htmlspecialchars($this->name));
        $s.= GenerWidget::generHiddenField("oldUp[$this->id]",$this->up);
        return $s;
    }
    else return parent::showListVal($attr);
} 

function showDetailsTool()
{
    global $lll;
    
    $ctrl = new AppController("clonecat/create_form/$this->id");
    return $ctrl->generAnchor($lll["clone"]); 
}

}
?>
