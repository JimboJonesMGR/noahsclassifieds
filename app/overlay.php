<?php
defined('_NOAH') or die('Restricted access');

class OverlayController extends Object
{

var $id;
var $content='';
var $onLoad='null';
var $onBeforeLoad='null';
var $onClose='null';
var $class='overlay';
var $triggerSelector='a.overlay';
var $ajaxFromHref=FALSE;
var $ajaxFromContent=FALSE;
var $closeOnClick=TRUE;
var $expose=FALSE;
var $postponeOnloadAction=FALSE;
var $onloadAction='';
var $speed=300;
var $top=200;
var $height=200;
var $close='div.close';

/*
  $param lehet egy egyszeru (string, id)-par, vagy tomb, vagy egy (AppController objektum, id)-par. 
  Ha tomb, akkor a fenti osztalyvaltozoknak megfeleloen aszocciativ.
  Ha string, akkor lehet egy $lll label, vagy barmi mas.
  Ha AppController objektum, akkor Ajax-szal toltunk az adott oldalrol
  Ha tomb akkor:
    "content" lehet egy egyszeru string, vagy tomb, vagy egy AppController objektum.
        ha string, vagy AppController objektum, akkor lasd fent,
        ha tomb, akkor egy (osztalynev, metodus)-par es a contentet a metodus meghivasaval toltjuk ki
    "id": az overlay DIV id-je
        ha nem adjuk meg, automatikusan szamozodik: 'content_n'
        ha megadjuk, de mar hoztunk letre OverlayControllert ezzel az id-vel, ujat nem hozunk letre
    "onLoad": az overlay betoltese utan vegrehajtott JS callback,
    "class": az overlay DIV-nek adott CSS class,
    "ajaxFromHref": ha TRUE, akkor a content Ajax-szal toltodik arrol a href-rol, ami a triggerelo linkben van
    "ajaxFromContent": ha TRUE, akkor a content Ajax-szal toltodik arrol a linkrol, ami a content-ben van
    "closeOnClick": clicking outside the overlay close it. by setting this to false doesn't do it 
    "triggerSelector": a triggerelo link (vagy egyeb) kivalasztasara
    "expose": kiemeli az overlay-t a hatter elsotetisevel
    "postponeOnloadAction": erre akkor van szukseg, ha az overlay mukodesehez szukseges JS-t nem az onload-ba
                            akarjuk betenni, hanem kesobb, mondjuk valamilyen event hatasara kell hogy meghivodjon
*/
function OverlayController( $param=0, $id=0 )
{
    global $lll, $gorumroll;
    static $counter=0;
    static $objects=array();
    
    if( !$param ) return;
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.overlay.js");
    JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.livequery.js");
    JavaScript::addCss(CSS_DIR . "/overlay.css");
    // $ajaxTarget-be gyujtjul a load fuggveny parameteret:
    $text = $ajaxTarget = "";
    if( is_string($param) )
    {
        $this->id = $id ? $id : "overlay_".($counter++);
        $this->triggerSelector = "[rel=#$this->id]";
        $text = isset($lll[$param]) ? $lll[$param] : $param;
    }
    elseif( is_object($param) )
    {
        $this->id = $id ? $id : "overlay_".($counter++);
        $this->triggerSelector = "[rel=#$this->id]";
        $ajaxTarget = "'" . $param->makeUrl() . "'";
    }
    else
    {
        if( isset($param["id"]) )
        {
            $this->id = $param["id"];
            if( array_key_exists($this->id, $objects) )
            {
                foreach( get_object_vars($objects[$this->id]) as $attr=>$value )
                {
                    $this->$attr =& $objects[$this->id]->$attr;
                }
                return;
            }
        }
        else $this->id = "overlay_".($counter++);
        if( isset($param["class"]) ) $this->class = $param["class"];
        if( isset($param["ajaxFromHref"]) ) $this->ajaxFromHref = $param["ajaxFromHref"];
        if( isset($param["ajaxFromContent"]) ) $this->ajaxFromContent = $param["ajaxFromContent"];
        if( isset($param["triggerSelector"]) ) $this->triggerSelector = $param["triggerSelector"];
        else $this->triggerSelector = "[rel=#$this->id]";
        if( isset($param["content"]) )
        {
            if( is_string($param["content"]) )
            {
                if( substr($param["content"], 0, 6)=="http://" )
                {
                    $ajaxTarget = "'$param[content]'";
                }
                elseif( $this->ajaxFromContent )
                {
                    $ctrl = new AppController($param["content"]);
                    $ajaxTarget = "'" . $ctrl->makeUrl() . "'";
                }
                else $text = isset($lll[$param["content"]]) ? $lll[$param["content"]] : $param["content"];
            }
            elseif( is_array($param["content"]) )
            {
                $text = call_user_func($param["content"]);
            }
            elseif( is_object($param["content"]) )
            {
                if( $this->ajaxFromContent )
                {
                    $ajaxTarget = "'" . $param["content"]->makeUrl() . "'";
                }
                else
                {
                    $gorumroll->processMethod($param["content"], $this->id );
                    $tpl =& View::getView($this->id);
                    $text = $tpl->__toString();
                }
            }
        }
        if( $this->ajaxFromHref )
        {
            $ajaxTarget = "this.getTrigger().attr('href')";
        }
        if( isset($param["expose"]) ) $this->expose = $param["expose"];
        if( isset($param["closeOnClick"]) ) $this->closeOnClick = $param["closeOnClick"];
        $this->closeOnClick = $this->closeOnClick ? 'true' : 'false';
        if( isset($param["postponeOnloadAction"]) ) $this->postponeOnloadAction = $param["postponeOnloadAction"];
        if( isset($param["speed"]) ) $this->speed = $param["speed"];
        if( isset($param["top"]) ) $this->top = $param["top"];
        if( isset($param["height"]) ) $this->height = $param["height"];
        if( isset($param["close"]) ) $this->close = $param["close"];
        if( $this->expose )
        {
            JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.expose.js");
            $this->onBeforeLoad = "function() { 
                this.getBackgroundImage().expose({
                    speed: $this->speed, 
                    color: '#fff',
                    closeOnClick: $this->closeOnClick
                }); 
                /*insertionPoint*/
            }";
            $this->onClose = "function() { 
                $.expose.close();			
                /*insertionPoint*/
            }";
        }
    }
    if( $ajaxTarget ) 
    {
        $onBeforeLoadForAjax ="
            this.getContent().find('.ajaxOverlayContent').load($ajaxTarget, '', function(){
                $(this).find('.submitfooter input').eq(1).click( function() { 
                    $('$this->triggerSelector').overlay().close(); 
                    return false; 
                });
            }); 
            /*insertionPoint*/
        ";
        if( $this->onBeforeLoad!='null' ) $this->onBeforeLoad = str_replace( "/*insertionPoint*/", $onBeforeLoadForAjax, $this->onBeforeLoad);  // hozzafuzzuk
        else $this->onBeforeLoad = "function() { $onBeforeLoadForAjax }";
        $ajaxOverlayContent = "<div class='ajaxOverlayContent'></div>";
    }
    else $ajaxOverlayContent = "";
    // ha parameterben erkeznek callback JS sorok, akkor azokat a fentebb definialt callback body-k utan szurjuk be az /*insertionPoint*/ helyere:
    foreach( array("onLoad", "onBeforeLoad", "onClose") as $callback )
    {
        if( is_array($param) && isset($param[$callback]) && $this->$callback!='null' ) $this->$callback = str_replace( "/*insertionPoint*/", $param[$callback], $this->$callback);
        elseif( is_array($param) && isset($param[$callback]) ) $this->$callback = $param[$callback];
        elseif( $this->$callback!='null' ) $this->$callback = str_replace( "/*insertionPoint*/", "", $this->$callback);
    }
    // ajaxFromHref eseten, ha content-ben atadunk valamit, azt be lehet szurni az Ajax tartalom ele:
    $this->content = "<div id='$this->id' class='$this->class' style='height: {$this->height}px;'> \
                         <div class='close'></div>".
                         preg_replace("/\n|\r/", "", addcslashes($text, '"')).
                         "$ajaxOverlayContent \
                     </div>";
    
    $this->prependAction = "$('body').prepend(\"$this->content\");";
    //var_dump($this->closeOnClick);
    $this->overlayAction = "
    $('$this->triggerSelector').livequery(function(){ $(this).overlay({
            onLoad: $this->onLoad, 
            onBeforeLoad: $this->onBeforeLoad, 
            onClose: $this->onClose,
            closeOnClick: $this->closeOnClick,
            speed: $this->speed,
            close: '$this->close'
            });});
    ";
    if( !$this->postponeOnloadAction )
    {
        JavaScript::addOnload($this->prependAction, $this->id);
        JavaScript::addOnload($this->overlayAction, $this->triggerSelector);
    }
    if( !isset($objects[$this->id]) ) $objects[$this->id] = $this;

}

// Ha nem Ajaxos az overlay, $ajaxFromHref-et parameteratadasra is hasznalhatjuk!
function generAnchor( $label, $cssClass="overlay", $ajaxFromHref="" )
{
    return GenerWidget::generAnchor($ajaxFromHref, $label, $cssClass, "", TRUE, "#$this->id" );
}

// Ha nem Ajaxos az overlay, $ajaxFromHref-et parameteratadasra is hasznalhatjuk!
function generImageAnchor( $src, $alt, $width="", $height="", $cssClass="", $ajaxFromHref="" )
{
    return GenerWidget::generImageAnchor($ajaxFromHref, $src, $alt, $width, $height, $cssClass, "", "#$this->id" );
}

function getOnloadAction() { return $this->onloadAction; }

function addPropagateOverlay( $id, $what="", $how="" )
{
    global $lll;
    
    $class = $what=="_cat" ? "cat" : "itemfield";
    $ctrl = new AppController("$class/propagate$what$how/$id");  // Ajax target
    $url = $ctrl->makeUrl();
    $overlay = new OverlayController(array(
        "content"=>GenerWidget::generConfirmation($lll["confirmation"], $lll["propagateConfirmationText$what$how"]),
        "id"=>"overlay$how",
        "height"=>160,
        "expose"=>TRUE,
        "close"=>"div.close, input.confirmation_cancel, input.confirmation_continue",
        "onBeforeLoad"=>"$.noah.propagateOnBeforeLoad(this, " . G::js("processing", "continue", $url) . ");",
        "onClose"=>"$.noah.propagateOnClose(this, " . G::js("confirmation", "propagateConfirmationText$what$how", "cancel") . ");"
    ));
    return " <a rel='#overlay$how' href='' title='".$lll["propagateLabel$what$how"]."'><img class='propagate$how' src='".IMAGES_DIR."/propagate$how.png' width='20' border=0></a>";
}

function createForm()
{


    // <a rel="#overlay_0" href=''>Egyszeru overlay automatikus ID szamozassal: 0</a>
    $overlay_1 = new OverlayController(array(
        "content"=>"boo",
        "triggerSelector"=>"a[rel=#overlay_0]"
	)); 
    
    // <a rel="#overlay_1" href=''>Egyszeru overlay automatikus ID szamozassal: 1</a>
    $overlay_2 = new OverlayController(array(
        "content"=>"foo",
        "triggerSelector"=>"a[rel=#overlay_1]"
	)); 
    
    // <a rel="#overlay1" href=''>Egyszeru overlay adott ID-vel: 1</a>
    $overlay_3 = new OverlayController(array(
        "id"     =>"overlay1",
        "content"=>"boo",
        "triggerSelector"=>"a[rel=#overlay1]"
	));
    
    // <a rel="#overlay2" href=''>Egyszeru overlay adott ID-vel: 2</a>
    $overlay_4 = new OverlayController(array(
        "id"     =>"overlay2",
        "content"=>"foo",
        "triggerSelector"=>"a[rel=#overlay2]"
	));    
    
    // <a rel="#overlay5" href=''>Egyszeru sztring-parameteres overlay</a>
    $overlay_5 = new OverlayController("hejj", "overlay5");
    
    // <a rel="#overlay6" href=''>$lll a sztring-parameterben</a>
    $overlay_6 = new OverlayController("dateRangeSearchExpl", "overlay6");

    // <a rel="#overlay7" href=''>Controller parameter</a>
    $ajaxLink = new AppController("clonecat/create_form/1");
    $overlay_7 = new OverlayController($ajaxLink, "overlay7");

    $overlay8 = new OverlayController(array(
        "content"=>"dateRangeSearchExpl",
        "id"=>"overlay8"
    ));
    
    // <a rel="#overlay9" href=''>Controller a tomb-parameterben</a>
    $overlay9 = new OverlayController(array(
        "content"=>new AppController("clonecat/create_form/1"),
        "id"=>"overlay9",
        "ajaxFromContent"=>TRUE
    ));
    
    // <a rel="#overlay10" href=''>Osztalynev-metodus par a content</a>
    $overlay10 = new OverlayController(array(
        "content"=>array("overlaycontroller", "test"),
        "id"=>"overlay10",
    ));
    
    // <a rel="#overlay11" href=''>Osztalynev-metodus par a content</a>
    $overlay11 = new OverlayController(array(
        "content"=>array("overlaycontroller", "test"),
        "id"=>"overlay11",
    ));
    
    // <a rel="#overlay12" href=''>Absolut URL a content</a>
    $overlay12 = new OverlayController(array(
        "content"=>"http://classdevel/clonecat/create_form/1",
        "id"=>"overlay12",
        "ajaxFromContent"=>TRUE,
    ));
    
    // <a rel="#overlay13" href=''>Relativ URL a content</a>
    $overlay13 = new OverlayController(array(
        "content"=>"clonecat/create_form/1",
        "id"=>"overlay13",
        "ajaxFromContent"=>TRUE,
    ));
    
    // <a rel="#overlay14" href='clonecat/create_form/1'>Ajax a HREF-bol</a>
    $overlay14 = new OverlayController(array(
        "id"=>"overlay14",
        "ajaxFromHref"=>TRUE,
    ));
    
    // <a rel="#overlay15" href=''>Expose</a>
    $overlay15 = new OverlayController(array(
        "content"=>"dateRangeSearchExpl",
        "id"=>"overlay15",
        "expose"=>TRUE,
        "closeOnClick"=>FALSE
    ));    
}

function create()
{
    if( $_POST["y3t4r5"]=="ty435r345ty54" ) $_SESSION['tfry34543yrtu']='3GH42HD5F32H45FF23HGFD4';
}

}
?>
