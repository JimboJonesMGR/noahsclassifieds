<?php
defined('_NOAH') or die('Restricted access');
if( !isset($gorumlisttemplate) ) $gorumlisttemplate = "default_list.tpl.php";

class ListPresentation extends Presentation
{

var $tableSort;
var $tableFilter;
var $tableRowHighlight;
var $zebraList;

function ListPresentation(&$base, $typ=0)
{
    global $gorumroll, $jQueryLib;
    
    $this->Presentation($base, "list", $typ);
    $this->tableSort = G::getSetting($this->typ, "clientSideTableSort" );
    $this->tableFilter = G::getSetting($this->typ, "clientSideTableFilter", "enable" );
    $this->tableRowHighlight = G::getSetting($this->typ, "tableRowHighlight" );
    $this->zebraList = G::getSetting($this->typ, "zebraList" );
    if( $this->tableSort || $this->tableFilter || $this->tableRowHighlight )
    {
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
    }
    if( $this->tableSort || $this->tableFilter )
    {
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/tablesort.js");
        if( $this->tableFilter )
        {
            require_once(GORUM_DIR . "/presentation/filter.php");
            $this->tableFilter = new Filter($this->typ);
        }
    }
    if( $this->tableRowHighlight )
    {
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/tablehover.js");
    }
}

function gener(&$view)
{
    $view->setEmpty($isEmpty = parent::gener($view));
    return $isEmpty;
}

function processContent(&$tpl)
{
    global $lll, $headerHeight, $gorumroll;

    $this->base->loadHtmlList($list);
    $tpl->assign("wrapForm", in_array("wrap_form", $this->typ));
    if( $tpl->wrapForm ) 
    {
        $this->getFormHeader($tpl);
        $this->getFormSubmit( $submits );
        $tpl->assign("submits", $submits);
        $tpl->assign("additionalHiddens", $this->base->getAdditionalHiddens($list));
    }
    $this->base->hasGeneralRights($rights);
    if( !in_array("no_pager", $this->typ) ) 
    {
        $pager =& $this->base->getPager();
        $tpl->assign("pager", $pager->showPagerTool());
    }
    else $tpl->assign("pager", "");
    $tpl->assign("footer", "");
    $tpl->assign("listAndMethod", "$gorumroll->list-$gorumroll->method");
    $tpl->assign("zebraList", $this->zebraList);
    if( $this->tableRowHighlight )
    {
        JavaScript::addOnload("$('#$tpl->listAndMethod table').tableHover({rowClass: 'hover-row', clickClass: 'hover-click'});");
    }
    $isEmptyList = !count($list);
    if( $isEmptyList && in_array("empty_list", $this->typ) )
    {
        return 1;  // ezzel azt jelezzuk, a hivo fg-nek, hogy ures sztringgel kell visszaternie rogton
    }
    if( $this->tableSort ) $tpl->assign("tableClass", "table-autosort");
    
    $tpl->assign("title", $lll[$gorumroll->list."_ttitle"]);
    
    $attributeList = isset($this->typ["listOrder"]) ? $this->typ["listOrder"] : array_keys($this->typ["attributes"]);
    $noSpanList = $colSpanList = $rowSpanList = $customListPlacementAttrList = array();
    $numberOfCellsInColSpan = $numberOfCellsInRowSpan = $numberOfCellsInNoSpan = 0;
    foreach( $attributeList as $attr ) 
    {
        $val = & $this->typ["attributes"][$attr];
        if( !in_array("list",$val) ) continue;
        if( $isNewLine = in_array("in new line", $val) ) $colSpanList[]=$attr;
        elseif( $isRowSpan = in_array("rowspan", $val) ) $rowSpanList[]=$attr;
        elseif(in_array("customListPlacement", $val))    
        {
            $customListPlacementAttrList[]=$attr;
            continue;
        }
        else                                             $noSpanList[]=$attr;
        if( $isNewLine)      $numberOfCellsInColSpan++;
        elseif( $isRowSpan ) $numberOfCellsInRowSpan++;
        else                 $numberOfCellsInNoSpan++;
    }
    $tpl->assign("numberOfCellsInColSpan", $numberOfCellsInColSpan);
    $tpl->assign("numberOfCellsInRowSpan", $numberOfCellsInRowSpan);
    $tpl->assign("numberOfCellsInNoSpan", $numberOfCellsInNoSpan);
    // Ezzel atrendezzuk az $attributeList-et ugy, hogy elol legyenek a normal oszlopok, 
    // utana a rowspanos oszlopok es vegul az uj sorba szant oszlopok:
    $attributeList = array_merge($noSpanList, $rowSpanList, $colSpanList);
    $tpl->assign("indexesOfCellsInNoSpan",  $numberOfCellsInNoSpan  ? range(0, $numberOfCellsInNoSpan-1) : array());
    $tpl->assign("indexesOfCellsInRowSpan", $numberOfCellsInRowSpan ? range($numberOfCellsInNoSpan, $numberOfCellsInNoSpan+$numberOfCellsInRowSpan-1) : array());
    $tpl->assign("indexesOfCellsInColSpan", $numberOfCellsInColSpan ? range($numberOfCellsInNoSpan+$numberOfCellsInRowSpan, $numberOfCellsInNoSpan+$numberOfCellsInRowSpan+$numberOfCellsInColSpan-1) : array());
    
    $tpl->assign("cellFieldNames", $attributeList);
    $tpl->assign("numberOfToolsCells",  in_array("notools", $this->typ) ? 0 : 1);
    $tpl->assign("colHeadersExists", !in_array("nocolheaders", $this->typ));
    
    $this->setHeaderMethods($rights, $headerMethods);

    $colHeaders = $colHeaderAttrs = $colHeaderClasses = $filterHeaders = $cellAttrs = $cellSpans = array();
    if( $tpl->colHeadersExists && $tpl->numberOfToolsCells ) 
    {
        // ha nincs header, de vannak header methodok, azokat ide ficcantjuk be:
        if( !$tpl->title && count($headerMethods) ) $colHeaders[-1]=implode(" | ", $headerMethods);
        else $colHeaders[-1]="&nbsp;";
        $colHeaderAttrs[-1]= isset($headerHeight) ? "height='$headerHeight'" : "";
        $colHeaderClasses[-1]="";
        if( $this->tableFilter ) $filterHeaders[-1]="Filter:";
    }
    foreach( $attributeList as $attr )
    {
        $val = & $this->typ["attributes"][$attr];
        if( !in_array("in new line", $val) ) $this->setColHeader( $val, $attr, $colHeaders, $colHeaderAttrs, $colHeaderClasses, $filterHeaders );
        $this->setCellAttrs($val, $cellAttrs, $cellSpans);
    }
    $listMethods = $cells = $customListPlacementList = $rowClasses = $cellClasses = array(); 
    $listMethodExists = FALSE;
    for( $i=0; $i<count($list); $i++ ) 
    {
        $listItem = $list[$i];
        // egy az objektum osztalyaban feluldefinialt fg-el lehetoseget adunk
        // arra, hogy az objektum erteketol fuggoen belemanipulaljunk a 
        // typeInfo-ba:
        $listItem->preprocessRow();
        if( $tpl->numberOfToolsCells )
        {
            $listMethods[$i]=array();
            $s1 = $gorumroll->method!="showdetails" ? $listItem->showDetailsTool() : "";
            if( $s1 ) $listMethods[$i][]=$s1;
            if( $s2=$listItem->showModTool($rights) ) $listMethods[$i][]=$s2;
            if( $s3=$listItem->showDelTool($rights) ) $listMethods[$i][]=$s3;
            if( $s1 || $s2 || $s3 ) $listMethodExists = TRUE;
        }
        $cells[$i] = array();
        $customListPlacementList[$i] = array();
        foreach( $attributeList as $attr )
        {
            $listItem->preprocessCell($this->typ["attributes"][$attr], $attr);
            $cells[$i][] = $listItem->showListVal($attr);
            $cellClasses[$i][] = isset($this->typ["attributes"][$attr]["customCss"]) ? $this->typ["attributes"][$attr]["customCss"] : "";
        }
        foreach( $customListPlacementAttrList as $attr )
        {
            $listItem->preprocessCell($this->typ["attributes"][$attr], $attr);
            $customListPlacementList[$i][$attr] = $listItem->showListVal($attr);
        }
    }
    // ha nincs listMethodos sor, nem kell a legelso ures oszlopot megmutatni:
    if( $tpl->numberOfToolsCells && !$listMethodExists )
    {
        $tpl->assign("numberOfToolsCells", 0);
        $listMethods=array();
        array_shift($colHeaders);
        array_shift($colHeaderAttrs);
        array_shift($colHeaderClasses);
    }
    $tpl->assign("emptyList", $isEmptyList);
    if( $isEmptyList )
    {        
        $cells[]=array($lll["emptylist"]);
        $cellClasses[]=array("");
        $cellAttrs=array("align='center'");
        $cellSpans=array("colspan");
    }
    $tpl->assign("headerMethods", $headerMethods);
    $tpl->assign("colHeaders", $colHeaders);
    $tpl->assign("colHeaderAttrs", $colHeaderAttrs);
    $tpl->assign("colHeaderClasses", $colHeaderClasses);
    $tpl->assign("filterHeaders", $filterHeaders);
    $tpl->assign("listMethods", $listMethods);
    $tpl->assign("cells", $cells);
    $tpl->assign("cellAttrs", $cellAttrs);
    $tpl->assign("cellClasses", $cellClasses);
    $tpl->assign("cellSpans", $cellSpans);
    $tpl->assign("rowClasses", $rowClasses);
    $tpl->assign("customListPlacementList", $customListPlacementList);
    $tpl->assign("customListPlacementAttrList", $customListPlacementAttrList);
}

function setHeaderMethods( $rights, &$headerMethods )
{
    global $enableCsvExport;
    
    $headerMethods=array();
    if( $s=$this->base->showNewTool($rights) ) $headerMethods[]=$s;
    if( $enableCsvExport ) 
    {
        if( $s=$this->base->showCsvExportTool() ) $headerMethods[]=$s;
    }    
}

function setColHeader($val, $attr, &$colHeaders, &$colHeaderAttrs, &$colHeaderClasses, &$filterHeaders)
{
    $lllProp = new LllProperties( $this->base, $attr );
    $temp = $lllProp->getColHeader();
    if( !$temp ) $temp = $lllProp->getLabel();
    $colHeaderClass = "";
    if( $this->tableSort )
    {
        $colHeaderClass = isset($val["sort"]) ? "table-sortable:".$val["sort"] : "";             
    }
    else
    {
        $temp.=Sorting::showSortTool($this->base, $attr);
    }
    if( isset($val["customCss"]) ) $colHeaderClass.= " ".$val["customCss"];
    $colHeaderClasses[] = $colHeaderClass;
    $colHeaders[]=$temp;
    $colHeaderAttrs[]= isset($headerHeight) ? "nowrap height='$headerHeight'" : "nowrap";
    if( $this->tableFilter )
    {
        if( isset($val["filter"]) )
        {
            $filterHeaders[]=$this->tableFilter->generField($val["filter"], $list, $attr);
        }
        else $filterHeaders[]="";
    }
}

function setCellAttrs($val, &$cellAttrs, &$cellSpans)
{
    $props = "";
    if( in_array("centered",$val) )   $props.=" align='center'";
    if( in_array("nowrap",$val) )     $props.=" nowrap";
    if( isset($val["fixwidth"]) )     $props.=" width='$val[fixwidth]'";
    if( isset($val["style"]) )        $props.=" style='$val[style]'";
    if( in_array("alignright",$val) ) $props.=" align='right'";
    if( in_array("widecell",$val) )   $props.=" width='100%'";
    if( in_array("in new line", $val) ) $span="colspan";
    elseif( in_array("rowspan", $val) ) $span="rowspan";
    else                                $span="no";
    $cellSpans[] = $span;
    $cellAttrs[] = $props;
}

} // end class
?>
