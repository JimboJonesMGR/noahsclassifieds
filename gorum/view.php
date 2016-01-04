<?php
defined('_NOAH') or die('Restricted access');

class View
{
    var $tpl;
    var $templateFileName;
    var $cache;
    var $elements;
    var $empty;
    var $paths;
    
    function View( $empty=FALSE )
    {
        require_once GORUM_DIR . "/Savant2.php";
        $this->elements = array();
        $this->paths = array();
        $this->tpl = new Savant2();
        $this->tpl->elements = 0;
        $this->tpl->elements = & $this->elements;
        $this->tpl->addPath('template', GORUM_TEMPLATE_DIR);
        $this->tpl->addPath('template', TEMPLATE_DIR);
        $this->tpl->addPath('template', COMMON_TEMPLATES);
        $this->empty = $empty;
        $this->templateFileName = $this->cache = "";
    }
    
    function init()
    {
        global $curvyCorners, $jQueryLib;
        if( !empty($curvyCorners) )
        {
            //JavaScript::addInclude(GORUM_DIR . "/js/niftycube.js");
            //JavaScript::addCss(GORUM_DIR . "/js/niftyCorners.css");
            //JavaScript::addOnload("
            //    Nifty('div.template','normal');
            //");
            JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
            JavaScript::addInclude(GORUM_JS_DIR . "/jquery/curvycorners.js");
            JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.livequery.js");
            JavaScript::addOnload("$.noah.addCurvyCornersToPresentationDivs();");
        }
    }

    function & getContentView()
    {
        global $gorumview;
        return $gorumview->elements["contentTemplate"];
    }

    // nev alapjan visszaadunk egy view-t, ha letezik, vagy egy ures view-t, ha nem:
    // a nev ilyen is lehet: view1/view2/...
    function & getView($elementName)
    {
        global $gorumview;
        $view =& $gorumview->getFatherView($elementName);
        if( !$elementName ) return $view;
        $null = new View(TRUE);
        return $null;
    }

    function addMainPath($path)
    {
        global $gorumview;
        $gorumview->addPath($path);
    }

    function addPath($path)
    {
        $this->paths[]=$path;
        $this->tpl->addPath('template', $path);
        // Amellett, hogy egy View-ban beallitjuk a custom path-ot, ugyanezt a
        // custom path-ot az osszes elementhez is hozzaadjuk:
        foreach( $this->elements as $element ) $element->addPath($path);
    }

    function setMainTemplateFile( $name )
    {
        global $gorumview;
        $gorumview->setTemplateFileName($name);
    }
    
    function setContentTemplateFile( $name )
    {
        $view =& View::getContentView();
        $view->setTemplateFileName($name);
    }

    function assign( $fieldName, $value )
    {
        global $gorumview;
        $template =& $gorumview->getTemplate();
        $template->{$fieldName}=$value;
    }
    
    function displayMain()
    {
        global $gorumview;
        header('Content-Type: text/html; charset=utf-8' );
        $gorumview->display();
    }
    
    function addFilter($filter)
    {
        global $gorumview;
        $template =& $gorumview->getTemplate();
        $template->loadFilter($filter);
    }
    
    function display()
    {
        global $contentSeparator;
        
        if( $this->empty ) echo "";
        elseif($this->templateFileName) 
        {
            $this->tpl->display($this->templateFileName);
        }
        else
        {
            $first=TRUE;
            foreach( $this->elements as $name=>$element )
            {
                if( $first ) $first=FALSE;
                else echo $contentSeparator;
                $element->display();
            }
        }
    }
    
    function displayContent()
    {
        global $contentSeparator;
        
        if( $this->empty ) echo "";
        elseif( $this->cache && $this->cache->checkCache() )
        {
            $this->cache->passThroughCache();
            if( count($this->elements) ) echo $contentSeparator;
        }
        elseif($this->templateFileName) 
        {
            $content = $this->tpl->fetch($this->templateFileName);
            if( $this->cache && $this->cache->isCacheActive()) 
            {
                $this->cache->saveCache($content);
            }
            echo $content;
            if( count($this->elements) && trim($content) )  echo $contentSeparator;
        }
        $separatorNecessary=FALSE;
        foreach( $this->elements as $name=>$element )
        {
            if( $separatorNecessary ) echo $contentSeparator;
            $element->displayContent();
            $separatorNecessary = !$element->getEmpty();
        }
    }
    
    // Ha egy uj view nev erkezik ilyen formaban: view1/view2/view3 es view3 meg nem letezik, de view1 es view2 igen,
    // akkor visszaadja a view1/view2 altal meghatarozott view-t $name-ben pedig view3-t.
    // Ha view1 erkezik es meg nem letezik ilyen $gorumview alatt, 
    // visszaadja $gorumview-t, $name-ben pedig view1-et.
    // Ha egy path minden tagja letezik mar, $name-et uresen adjuk vissza
    function & getFatherView(&$name)
    {
        if( !$name ) return $this->getContentView();
        $parts = explode("/", $name);
        $fatherView = $this;
        foreach( $parts as $viewName ) 
        {
            if( isset($fatherView->elements[$viewName]) ) $fatherView = & $fatherView->elements[$viewName];
            else
            {
                $name = $viewName;
                return $fatherView;
            }                
        }
        $name="";
        return $fatherView;
    }
    
    // $name-et ilyen forman lehet megadni: pl. view1/view2/view3
    // ha view3 meg nem letezik, az uj view view3 lesz view2 alatt. 
    // Ha mar letezik, akkor egy uj (nevtelen) view-t adunk view3 ala.
    // Ha $name=='', akkor egy uj nevtelen view-t adunk a 'contentTemplate' view ala:
    function & addElement( $name="", $cache=0 )
    {
        // Ha uj elementet hozunk letre, ugyanazok lesznek a custom path-jai,
        // mint a szulo View-nak:
        $view =& $this->getFatherView($name);
        if( $name )
        {
            $view->elements[$name] = new View();
            foreach( $view->paths as $path ) $view->elements[$name]->addPath($path);
            $view->elements[$name]->setCache($cache);
            return $view->elements[$name];
        }
        else
        {
            $element = new View();
            foreach( $view->paths as $path ) $element->addPath($path);
            array_push($view->elements, $element);
            foreach( $view->elements as $key=>$val ) $lastKey = $key;
            $view->elements[$lastKey]->setCache($cache);
            return $view->elements[$lastKey];
        }
    }
    
    function  & getElementTemplate( $name )
    {
        $view =& View::getContentView();
        return $view->elements[$name]->tpl;
    }
    
    function getEmpty()
    {
        return $this->empty;
    }
    
    function setEmpty($value)
    {
        $this->empty = $value;
    }

    function setTemplateFileName($value)
    {
        global $language;
        
        $this->templateFileName = $value;
        $langTemplateFile = str_replace(".tpl.php", "_$language.tpl.php", $value);
        foreach( array(GORUM_TEMPLATE_DIR, TEMPLATE_DIR, COMMON_TEMPLATES) as $dir )
        {
            if( file_exists("$dir/$value") ) 
            {
                if( file_exists("$dir/$langTemplateFile") ) $this->templateFileName = $langTemplateFile;
                else $this->templateFileName = $value;
                break;
            }
        }
    }
    
    function setCache($value)
    {
        $this->cache = $value;
    }
    
    function & getCache()
    {
        return $this->cache;
    }
    
    function & getTemplate()
    {
        return $this->tpl;
    }
    
    function __toString() {
        if( $this->empty ) return "";
        return $this->tpl->fetch($this->templateFileName);
    }
    
    function generBordersTop($width, $height, $tl, $t, $tr, $l, $fullWidth='100%', $tableClass='', $innerClass='')
    {
        return "<table class='$tableClass' width='$fullWidth' cellpadding='0' cellspacing='0' >".
        "<tr>".
         "<td style='width:{$width}px; height:{$height}px;background: url($tl) no-repeat'></td>".
         "<td style='height:{$height}px;background: url($t) repeat-x;'></td>".
         "<td style='width:{$width}px; height:{$height}px;background: url($tr) no-repeat'></td>".
        "</tr>".
        "<tr>".
         "<td style='width:{$width}px; background: url($l) repeat-y;'></td>".
         "<td class='$innerClass'>\n";
    }
    
    function generBordersBottom($width, $height, $r, $bl, $b, $br)
    {
        return "</td>".
         "<td style='width:{$width}px; background: url($r) repeat-y;'></td>".
        "</tr>".
        "<tr>".
         "<td style='width:{$width}px; height:{$height}px;background: url($bl) no-repeat'></td>".
         "<td style='height:{$height}px;background: url($b) repeat-x;'></td>".
         "<td style='width:{$width}px; height:{$height}px;background: url($br) no-repeat'></td>".
        "</tr>".
        "</table>\n";
    }
    
    function dump()
    {
        global $gorumview;
        
        echo("root<br>");
        foreach( $gorumview->elements as $name=>$element )
        {
            $element->dumpCore($name, 1);
        }
    }
    
    function dumpCore($name, $level)
    {
        for( $i=0; $i<$level; $i++ ) echo "&nbsp;";
        echo("$name<br>");
        foreach( $this->elements as $name=>$element )
        {
            $element->dumpCore($name, $level+1);
        }
    }
}
?>