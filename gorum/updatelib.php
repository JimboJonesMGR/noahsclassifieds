<?php
defined('_NOAH') or die('Restricted access');

function update(&$s) 
{    
    update_1($s); // A notification tablaba szur be uj attributumokat:
}
    

function update_1(&$s)
{
    global $applName;
    $s="";

    $querys[] = "ALTER TABLE $applName"."_notification ADD fixRecipent int(11) NOT NULL default '0'";
    $querys[] = "ALTER TABLE $applName"."_notification ADD fixCC int(11) NOT NULL default '1'";
    $querys[] = "ALTER TABLE $applName"."_notification ADD recipent varchar(255) NOT NULL default ''";
    $querys[] = "ALTER TABLE $applName"."_notification ADD cc varchar(255) NOT NULL default ''";
    foreach( $querys as $query)
    {
        executeQuery($query,__FILE__,__LINE__);
    }
    $s.= "Update successful";
}

?>
