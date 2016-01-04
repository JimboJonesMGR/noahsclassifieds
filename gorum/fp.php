<?php

class FP
{
    function log( $message, $label="" )
    {
        global $_FP;
        if( $_FP ) $_FP->log( $message, $label );
    }
}
?>
