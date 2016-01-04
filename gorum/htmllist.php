<?php
defined('_NOAH') or die('Restricted access');

function loadHtmlList(&$base,&$list)
{

    $base->hasObjectRights($hasRight, "load", TRUE);
    $query=getListQuery($base);
    $base->loadObjectsSQL($query,$list, TRUE);
    return ok;

}

function getListQuery(&$base)
{
    global $gorumroll;

    $select  = $base->getListSelect();
    $orderby = $base->getOrderBy();
    $limit   = $base->getLimit();
    $args = array();
    $query="";
    if( is_array($select) )
    {
        $query = array_shift($select);
        $args = $select;
    }
    else $query = $select;
    if( is_array($orderby) )
    {
        $query.= " ORDER BY ".array_shift($orderby);
        $args = array_merge($args, $orderby);
    }
    elseif( $orderby ) $query.= " ORDER BY $orderby";
    if( is_array($limit) )
    {
        $query.= " ".array_shift($limit);
        $args = array_merge($args, $limit);
    }
    elseif( $limit ) $query.= " $limit";
    if( count($args) ) $query = array_merge(array($query), $args);
    return $query;
}

function getOrderBy(&$base)
{
    $sorting = new Sorting($base);
    return $sorting->getSortSql();
}

function getLimit(&$base)
{
    $pager =& $base->getPager();
    return $pager->getLimit();
}

function csvExport(&$base, $full=FALSE)
{
    global $lll, $gorumroll;
    $separator=",";
    $s="";
    $base->hasObjectRights($hasRight, "load", TRUE);
    $select  = $base->getListSelect();
    $orderby = $base->getOrderBy();
    $query = "$select ORDER BY $orderby";
    $base->loadObjectsSQL($query,$list, TRUE);

    $typ=&$base->getTypeInfo();
    $attributeList = isset($typ["listOrder"]) ?
                     $typ["listOrder"] : array_keys($typ["attributes"]);
    $first = TRUE;
    foreach( $attributeList as $attr )
    {
        $val = & $typ["attributes"][$attr];
        if( (($full && in_array("export",$val)) || (in_array("list",$val)) && !in_array("no column",$val)) )
        {
            if( $first ) $first=FALSE;
            else $s.=$separator;
            if (isset($lll[$gorumroll->class."_".$attr])) {
                $s.=$lll[$gorumroll->class."_".$attr];
            }
            else $s.=$lll[$attr];
        }
    }
    $s.="\n";
    foreach( $list as $listItem )
    {
        $first = TRUE;
        foreach( $attributeList as $attr )
        {
            $val = & $typ["attributes"][$attr];
            if( (($full && in_array("export",$val)) || (in_array("list",$val)) && !in_array("no column",$val)) )
            {
                if( $first ) $first=FALSE;
                else $s.=$separator;
                if( in_array("text",$val) || in_array("textarea",$val) )
                {
                    $s.='"';
                    $x = str_replace(chr(13).chr(10), "#@# ", $listItem->{$attr});
                    $s.=str_replace('"', '""', $x);
                    $s.='"';
                }
                else $s.=$listItem->{$attr};
            }
        }
        $s.="\n";
    }
    header("Content-Type: application/download\n");
    header("Content-Disposition: attachment; filename=\"listdump.csv\"");
    /*
    $s.="<table width='100%' border='1' cellpadding='0' cellspacing='0'><tr>\n";
    foreach( $attributeList as $attr )
    {
        $val = & $typ["attributes"][$attr];
        if( (($full && in_array("export",$val)) || (in_array("list",$val)) && !in_array("no column",$val)) )
        {
            $s.="<td>";
            if (isset($lll[$gorumroll->class."_".$attr])) {
                $s.=$lll[$gorumroll->class."_".$attr];
            }
            else $s.=$lll[$attr];
            $s.="</td>";
        }
    }
    $s.="</tr>\n";
    foreach( $list as $listItem )
    {
        $s.="<tr>";
        foreach( $attributeList as $attr )
        {
            $val = & $typ["attributes"][$attr];
            if( (($full && in_array("export",$val)) || (in_array("list",$val)) && !in_array("no column",$val)) )
            {
                $s.="<td><pre>";
                $s.= str_replace(chr(13).chr(10), chr(10), $listItem->{$attr});
                $s.="</pre></td>";
                $s.="<td>";
                $s.= str_replace(chr(13).chr(10), chr(10), htmlspecialchars($listItem->{$attr}));
                $s.="</td>";
            }
        }
        $s.="</tr>\n";
    }
    $s.="</table>\n";

    header("Content-Type: application/download\n");
    header("Content-Disposition: attachment; filename=\"listdump.html\"");
*/
    //header("Content-lenght: close");
    //header("Connection: close");
    //header("Expires: 0");
    echo $s;
    die();
    return ok;
}

?>
