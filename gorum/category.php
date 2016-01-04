<?php
defined('_NOAH') or die('Restricted access');
$category_typ =  
    array(
        "attributes"=>array(   
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden",
                "safetext",
                "list",
            ),            
            "up"=>array(
                "type"=>"INT",
                "form hidden",
                "safetext",
                "list",
            ),
            "name"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250",
                "min" =>"1",
                "mandatory",
                "list",
                "details"
            ),
            "wholeName"=>array(
                "type"=>"TEXT",
                "form hidden",
                "safetext"
            ),
            "permaLink"=>array(
                "type"=>"TEXT",
            ),
            "subCatNum"=>array(
                "type"=>"INT",
                "form invisible",
                "safetext"
            ),
            "directSubCatNum"=>array(
                "type"=>"INT",
                "form invisible",
                "safetext"
            ),
            "itemNum"=>array(
                "type"=>"INT",
                "form invisible",
                "safetext"
            ),
            "directItemNum"=>array(
                "type"=>"INT",
                "form invisible",
                "safetext"
            ),
            "creationtime"=>array(
                "type"=>"DATETIME",
                "form invisible",
                "prototype"=>"date"
            )
        ),    
        "primary_key"=>"id",
        "delete_confirm"=>"name",
        "sort_criteria_sql"=>"sortId ASC, creationtime ASC"
    );


class Category extends Object
{
    
function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll,$gorumuser, $gorumrecognised;

    hasAdminRights($isAdm);
    $hasRight->generalRight = TRUE;
    if( $method=="load" ) {
        $hasRight->objectRight=TRUE;
    }        
    elseif( $isAdm ) {
        $hasRight->objectRight=TRUE;
    }
    else {
        $hasRight->objectRight=FALSE;
    }
    if( !$hasRight->objectRight && $giveError ) {
        handleError($lll["permission_denied"]);
    }        
} 

function createForm()
{
    global $gorumroll;
    $this->up = $gorumroll->rollid;
    parent::createForm();
}

function showListVal($attr)
{
    global $gorumuser,$gorumroll, $htmlListForum;

    $s=FALSE;
    if( ($s=parent::showListVal($attr))!==FALSE ) return $s;
    if( $attr=="name" )
    {
        $ctrl = $this->getLinkCtrl();
        return $ctrl->generAnchor($this->getAttr("name"));
    }
} 

function create()
{                                         
    global $seoSeparator;

    $this->wholeName=$this->name;
    $this->permaLink = $this->seoConvert(strtolower($this->name), $seoSeparator);
    if( $this->up )
    {
        $father = new AppCategory;
        $father->id = $this->up;
        load($father);
        $this->wholeName = $father->wholeName." - ".$this->wholeName;
        $this->permaLink = $father->permaLink."/".$this->permaLink;
    }
    parent::create();
    if( !Roll::isFormInvalid() && $this->up )
    {
        $father->increaseDirectSubCatNum();
    }
} 

function modify( $whereFields="" )
{
    $this->modifyRecursive();
}

function modifyRecursive()
{
    // Vigyazva kell barmit is beepiteni meg ebbe a modify-ba, mert
    // rekurziv is hivodhat.
    global $seoSeparator;

    $this->wholeName=$this->name;
    $this->permaLink = $this->seoConvert(strtolower($this->name), $seoSeparator);
    if( $this->up )
    {
        $father = new AppCategory;
        $father->id = $this->up;
        load($father);
        $this->wholeName = $father->wholeName." - ".$this->wholeName;
        $this->permaLink = $father->permaLink."/".$this->permaLink;
    }
    parent::modify();
    if( !Roll::isFormInvalid() )
    {
        $children = new AppCategory;
        $query =array("SELECT id, up, name FROM @category WHERE up=#this->id#", $this->id);
        loadObjectsSql( $children, $query, $children );
        foreach( $children as $child ) 
        {
            $child->modifyRecursive();  // rekurziv
        }    
        // Ez a recursive kavaras azert kell, hogy pontosan ez a fg hivodjon
        // rekurzivan es ne a leszarmaztatt osztaly modify-ja. 
    }       
}

function delete( $whereFields="" )
{
    G::load( $children, array("SELECT * FROM @category WHERE up=#this->id#", $this->id) );
    global $recursive;
    foreach( $children as $child ) 
    {
        $recursive=TRUE;         
        $child->delete();  // rekurziv
        $recursive=FALSE;
    }    
    // Elobb kitoroljuk az itemeit (ha az item egyaltalan be van 
    // inkudalva). Azert kell elotte, mert az 
    // item->delete() hivhat load-ot a categoriara
    if( class_exists("item") )
    {
        if( class_exists("itemnode") )
        {
            $query = "SELECT iid, id FROM @itemnode WHERE cid='$this->id";
            $itemNodes = new ItemNode;
            foreach( $itemNodes as $itemNode )
            {
                delete($itemNode);
                // megszamoljuk, hogy hany hivatkozas maradt meg az adott itemre
                // az itemnode tablaban:
                getDbCount($count, array("SELECT COUNT(*) FROM @itemnode WHERE iid=#itemNode->iid#", $itemNode->iid));
                // ha nincs ra tobb hivatkozas, akkor toroljuk:
                // TODO: ez igy nem kezeli az itemNum-ok csokkenteset!
                if( !$count ) executeQuery("DELETE FROM @item WHERE id=#itemNode->iid#", $itemNode->iid);
            }
        }
        else
        {
            $items = new Item;
            $query = array("SELECT * FROM @item WHERE cid=#this->id#", $this->id);
            loadObjectsSql( $items, $query, $items );
            $itemCount = count($items);
            foreach( $items as $item ) $item->delete("", "categoryDelete");
        }    
    }
    parent::delete($whereFields);

    // Rekurziv esetben elobb a levelre hivodik meg a kovetkezo 
    // kodreszlet, majd az o folott allo objektumra es igy tovabb 
    // egeszen addig az objektumig, amelyre tulajdonkeppen meghivtuk a 
    // delete-et. A subCatNum ennek soran egyesevel csokkenget a lanc
    // tagjaiban:
    if( $this->up )
    {
        G::load($father, $this->up, "appcategory");
        $father->decreaseDirectSubCatNum();
        $father->decreaseItemNum($itemCount);
    }
    executeQuery("DELETE FROM @subscription WHERE cid=#cid#", $this->id);
    executeQuery("DELETE FROM @unsubscription WHERE cid=#cid#", $this->id);
} 

function getListSelect()
{
    global $gorumroll;

    $select = array("SELECT * FROM @category WHERE up=#rollid#", $gorumroll->rollid);
    
    return $select;
} 

function cacheFatherObjects()
{
    global $fatherCatList;
    global $gorumroll;
    if( (!isset($this->id) || !$this->id) && $gorumroll->rollid ) 
    {
        $this->id=$gorumroll->rollid;
        $ret = load( $this );
        if( $ret ) {
            $txt="can not load category object";
            handleError($txt);
        } 
    }    
    if( !isset($fatherCatList) || !$fatherCatList)
    {
        $fatherCatList = array();
        //if ($withOwn) $fatherCatList[] = $this;
        $childCat = gclone($this);
        while( !empty($childCat->up) )
        {
            G::load( $childCat, $childCat->up, "appcategory" );
            $fatherCatList[] = $childCat;
        }
        $fatherCatList=array_reverse($fatherCatList);
    }
}

function increaseDirectItemNum($mennyivel=1)
{
    $this->directItemNum+=$mennyivel;
    $this->increaseItemNum($mennyivel);
}   

function increaseItemNum($mennyivel=1)
{
    $this->itemNum+=$mennyivel;
    modify( $this ); 
    if( $this->up )
    {
        G::load($father, $this->up, "appcategory");
        $father->increaseItemNum($mennyivel);  // rekurziv
    }
}   

function decreaseDirectItemNum($mennyivel=1)
{
    $this->directItemNum-=$mennyivel;
    $this->decreaseItemNum($mennyivel);
}   

function decreaseItemNum( $mennyivel=1 )
{
    $this->itemNum -= $mennyivel;
    modify( $this ); 
    if( $this->up )
    {
        G::load($father, $this->up, "appcategory");
        $father->decreaseItemNum($mennyivel);  // rekurziv
    }
}   

function increaseDirectSubCatNum()
{
    $this->directSubCatNum++;
    $this->increaseSubCatNum();
}   

function increaseSubCatNum()
{
    $this->subCatNum++;
    modify( $this ); 
    if( $this->up )
    {
        $father = new AppCategory;
        $father->id = $this->up;
        load($father);
        $father->increaseSubCatNum();  // rekurziv
    }
}   

function decreaseDirectSubCatNum()
{
    $this->directSubCatNum--;
    $this->decreaseSubCatNum();
}   

function decreaseSubCatNum()
{
    $this->subCatNum--;
    modify( $this ); 
    if( $this->up )
    {
        $father = new AppCategory;
        $father->id = $this->up;
        load($father);
        $father->decreaseSubCatNum();  // rekurziv
    }
}   

// $dff azt mondja meg, hogy mennyi volt a kulonbseg a tarolt es a tenyleges
// directItemNum kozott abban a kategoriaban, ahol a fg-t eloszor meghivtak.
// A fuggvenyt eloszor 0-val hivja meg az az item, amiben valami itemnum
// valtoztato modositas tortent.
function calculateItemNums( $diff=0 )
{
    if( $diff )
    {
        if( !isset($this->itemNum) ) load($this);
        // $diff-nek megfeleloen modositjuk az itemNumot es taroljuk:
        $this->itemNum+=$diff;       
        executeQuery("UPDATE @category SET itemNum=#this->itemNum# WHERE id=#this->id#",
                     $this->itemNum, $this->id);
        // ha van apja, akkor rekurzivan meghivjuk ra a fg-t u.a. a $diff-fel:
        if( $this->up )
        {
            $father = new AppCategory;
            $father->id = $this->up;
            $father->calculateItemNums( $diff );
        }    
    }
    else
    {    
        // megszamlaljuk az osszes aktiv kozvetlen itemet:
        getDbCount( $count, array("SELECT COUNT(*) FROM #item WHERE cid=#this->id# AND status=1", $this->id));
        // ha esetleg meg nincs betoltve a kategoria, akkor betoltjuk:
        if( !isset($this->directItemNum) ) load($this);
        $diff = $count-$this->directItemNum;
        // ha kulonbseg van a tarolt es a tenyleges kozott:
        if( $diff )
        {
            // eltaroljuk az uj directItemNum-ot:
            executeQuery("UPDATE @category SET directItemNum=#count# WHERE id=#this->id#", $count, $this->id);
            // Ujrahivjuk a fg-t nem nulla $diff-fel, hogy az itemNum is 
            // megfeleloen modosuljon:
            $this->calculateItemNums( $diff );
        }   
    }
}

function recalculateAllItemNumsCore()
{
    // megszamlaljuk az osszes aktiv kozvetlen itemet:
    getDbCount( $count, array("SELECT COUNT(*) FROM @item WHERE cid=#this->id# AND status=1", $this->id));
    $this->directItemNum = $count;
    // eltaroljuk az uj directItemNum-ot:
    executeQuery("UPDATE @category SET directItemNum=#count# WHERE id=#this->id#", $count, $this->id);
    // betoltjuk a kozvetlen gyerekeket:
    $subcats = new AppCategory;
    $query = array("SELECT * FROM @category WHERE up=#this->id#", $this->id); 
    loadObjectsSql( $subcats, $query, $subcats );
    $this->itemNum=0;
    if( count($subcats) )
    {
        foreach( $subcats as $cat )
        {
            // ha vannak gyerekei, rekurzivan kiszamoljuk a gyerekek itemNumjat:
            $cat->recalculateAllItemNumsCore();
            // a sajat itemNum a gyerekek itemNumjanak osszege:
            $this->itemNum+=$cat->itemNum;
        }
    }
    // a teljes itemNumhoz a directItemNumot is hozza kell szamolni:
    $this->itemNum += $this->directItemNum; 
    // elmentjuk az itemNumot:
    executeQuery("UPDATE @category SET itemNum=#this->itemNum# WHERE id=#this->id#", $this->itemNum, $this->id);
}

function getPageTitle()
{
    global $gorumroll;
    
    $_S = new AppSettings();
    if( $gorumroll->method=="showhtmllist" && $gorumroll->list=="appcategory" && $gorumroll->rollid==0 ) return $_S->getPageTitle();
    return !empty($this->name) ? $this->getAttr("name") : parent::getPageTitle();
}

function getPageDescription()
{
    if( !empty($this->descriptionMeta) ) return $this->descriptionMeta;
    return !empty($this->description) ? $this->getAttr("description") : parent::getPageDescription();
}

function getPageKeywords()
{
    return !empty($this->keywords) ? $this->keywords : parent::getPageKeywords();
}

function recalculateAllItemNums($overridePermission=FALSE)
{
    if( !$overridePermission )
    {
        hasAdminRights( $isAdm );
        if( !$isAdm ) handleErrorPerm( __FILE__, __LINE__ );
    }
    $cats = new AppCategory;
    $query = "SELECT * FROM @category WHERE up=0"; 
    loadObjectsSql( $cats, $query, $cats );
    foreach( $cats as $cat )
    {
        $cat->recalculateAllItemNumsCore();
    }
    Roll::setInfoText("itemNumbersRecalculated");
    $this->nextAction = new AppController("/");
}

}  // end class
?>
