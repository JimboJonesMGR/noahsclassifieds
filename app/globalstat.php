<?php
defined('_NOAH') or die('Restricted access');
$globalstat_typ = 
    array(
        "attributes"=>array(   
            "id"=>array(
                "type"=>"INT",
                "min" =>"0",
                "auto increment",
                "form hidden"
            ),
            "instver"=>array(
                "type"=>"VARCHAR",
                "max" =>"120",
                "min" =>"1",
            ),            
            "congrat"=>array(
                "type"=>"INT",
                "default"=>"1"
            ),
            "defPageConf"=>array(
                "type"=>"INT",
                "default"=>"1"
            ),
            "creationtime"=>array(
                "type"=>"DATE",
                "prototype"=>"date"
            ),
            "lastUpdate"=>array(
                "type"=>"DATE",
                "prototype"=>"date",
            ),
            "reg"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
            ),
            "registered"=>array(
                "type"=>"INT",
            ),
            "company"=>array(
                "type"=>"VARCHAR",
                "max" =>"255",
            ),            
            "firstName"=>array(
                "type"=>"VARCHAR",
                "max" =>"255",
            ),            
            "lastName"=>array(
                "type"=>"VARCHAR",
                "max" =>"255",
            ),            
            "email"=>array(
                "type"=>"VARCHAR",
                "max" =>"255",
            ),            
            "lastUpdateCheck"=>array(
                "type"=>"DATE",
                "prototype"=>"date",
            ),
        ),
        "primary_key"=>array("id")
    );
    
class GlobalStat extends Settings
{
}
?>
