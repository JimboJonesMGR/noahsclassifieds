<?php
defined('_NOAH') or die('Restricted access');
// A cronjobok applikacionkent fixek. Az installibben kell oket
// letrehozni. A user nem hozhat letre ujat es nem torolhet ki egyet
// sem, maximum inactivra allithatja oket, vagy a vegrehajtasi
// gyakorisagukat valtoztathatja.

$dbClasses[]="cronjob";

$cronjob_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "form hidden",
            ),
            "title"=>array(
                "type"=>"VARCHAR",
                "max" =>"120",
                "list",
                "details",
                "form readonly"
            ),
            "lastExecutionTime"=>array(
                "type"=>"DATETIME",
                "prototype"=>"date",
                "list",
                "details",
                "form readonly"
            ),
            "frequency"=>array(  // hours
                "type"=>"INT",
                "text",
                "min"=>1,
                "mandatory",
                "list",
                "details",
            ),
            "active"=>array(
                "type"=>"INT",
                "bool",
                "yesno",
                "default"=>1,
                "list",
                "details",
            ),
            "function"=>array(
                "type"=>"VARCHAR",
                "form invisible",
                "max" =>"120",
            )
        ),
        "primary_key"=>"id",
        "sort_criteria_attr"=>"id",
        "sort_criteria_dir"=>"d"
    );

class CronJob extends Object
{
    function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
    {
        global $lll;
        hasAdminRights($isAdm);
        $hasRight->objectRight = $isAdm && $method!="create" && $method!="delete";
        $hasRight->generalRight = TRUE;
        if( !$hasRight->objectRight && $giveError )
        {
            handleError($lll["permission_denied"]);
        }
        return ok;
    }

    function showDetailsTool()
    {
        return "";
    }

    function showListVal($attr)
    {
        global $lll;

        if( ($s=parent::showListVal($attr))!==FALSE )
        {
            return $s;
        }
        elseif( $attr=="frequency" )
        {
            $s=$this->{$attr}." ".$lll["hour(s)"];
        }
        else
        {
            $s=parent::showListVal($attr, "safetext");
        }
    }
}

function executeCronJobs()
{
    global $now;
    G::load( $cronjobs, "SELECT * FROM @cronjob WHERE active='1' AND NOW()-INTERVAL frequency HOUR > lastExecutionTime" );
    foreach( $cronjobs as $cronjob )
    {
        eval($cronjob->function);
        $cronjob->lastExecutionTime=$now;
        modify( $cronjob );
    }
}

?>