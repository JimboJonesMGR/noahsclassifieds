<?php
defined('_NOAH') or die('Restricted access');

function traceStart( $fileName='' )
{
    ini_set("xdebug.collect_params", 3);
    ini_set("xdebug.collect_return", 1);
    if( !function_exists('xdebug_is_enabled') || !xdebug_is_enabled() ) return;
    if( !$fileName ) $fileName = xdebug_call_function();
    xdebug_start_trace( getcwd()."/log/$fileName", XDEBUG_TRACE_APPEND );
}

function traceStop(  )
{
    if( !function_exists('xdebug_is_enabled') || !xdebug_is_enabled() ) return;
    xdebug_stop_trace();
}
?>