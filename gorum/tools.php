<?php
defined('_NOAH') or die('Restricted access');
function showTools(&$base,$rights)
{
    global $gorumroll,$showIcon;
    $s=$s1=$s2=$s3="";
    if( $gorumroll->method!="showdetails" )$s1=$base->showDetailsTool();
    $s2=$base->showModTool($rights);
    $s3=$base->showDelTool($rights);
    if ($showIcon) $sep=" ";
    else $sep=" | \n";
    if( $s1!="" || $s2!="" || $s3!="")
    {
        $s.=$s1;
        if ($s && $s2) $s.=$sep;
        $s.=$s2;
        if ($s && $s3) $s.=$sep;
        $s.=$s3;
    }
    if (!$s) $s="&nbsp;";
    return $s;
}

function showModTool($base, $rights)
{
    global $lll,$gorumroll,$showIcon;

    $s="";
    if (!isset($rights["modify"])) 
    {
        $base->hasObjectRights($hasRight,"modify");
        $hasRight = $hasRight->objectRight;
    }
    else $hasRight = $rights["modify"];
    if ($hasRight) 
    {
        $ctrl = new AppController(array("method"=>"modify_form", "rollid"=>$base->id));
        if( $showIcon ) $s.=$ctrl->generImageAnchor(IMAGES_DIR . "/modify.gif",$lll["icon_modify"],17,22);
        else  $s.=$ctrl->generAnchor($lll["icon_modify"]);
    }
    return $s;
}

function showDelTool($base, $rights)
{
    global $lll,$gorumroll,$showIcon;

    $s="";
    if (!isset($rights["delete"])) 
    {
        $base->hasObjectRights($hasRight,"delete");
        $hasRight = $hasRight->objectRight;
    }
    else $hasRight = $rights["delete"];
    if ($hasRight) 
    {
        $ctrl = new AppController(array("method"=>"delete_form", "rollid"=>$base->id));
        if( $showIcon ) $s.=$ctrl->generImageAnchor(IMAGES_DIR . "/delete.gif", $lll["icon_delete"],17,22);
        else $s.=$ctrl->generAnchor($lll["icon_delete"]);
    }
    return $s;
}

function showDetailsTool($base)
{
    global $lll,$gorumroll,$showIcon;
    
    $ctrl = new AppController("$gorumroll->list/showdetails/$base->id");
    if( $showIcon ) return $ctrl->generImageAnchor(IMAGES_DIR . "/details.gif", $lll["icon_details"],17,22);
    return $ctrl->generAnchor($lll["icon_details"]);
}

function showNewTool($base,$rights)
{
    global $lll,$gorumroll;

    $s="";
    if (!isset($rights["create"])) 
    {
        $base->hasObjectRights($hasRight,"create");
        $hasRight = $hasRight->objectRight;
    }
    else $hasRight = $rights["create"];
    if ($hasRight) 
    {
        $ctrl = new AppController($gorumroll->list, "create_form", $base->showNewToolPlusUrl());
        $cl = $ctrl->getClass();
        $lllGlobProp = new LllGlobalProperties( new $cl );
        $s.=$ctrl->generAnchor($lllGlobProp->getLabel("newitem"));
    }
    return $s;
}

function showCsvExportTool($base)
{
    global $lll,$gorumroll;

    $s="";
    hasAdminRights($isAdm);
    if ($isAdm) {
        $ctrl = new AppController();
        $ctrl->method = "showcsv";
        $label=$lll["showcsv"];
        $s.=$ctrl->generAnchor($label);
        $ctrl->method = "showfullcsv";
        $label=$lll["showfullcsv"];
        $s.=" | ".$ctrl->generAnchor($label);
    }
    return $s;
}

?>
