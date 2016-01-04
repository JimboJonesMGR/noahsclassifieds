<?php
defined('_NOAH') or die('Restricted access');

include_once(NOAH_BASE . '/error/error.php');

class AppError extends Error
{

function AppError()
{
    global $errorFileSizeLimit, $maxNumberOfArchivedErrorFiles, $logExtension;
    
    $logFile = LOG_DIR . "/error.$logExtension";
    $this->Error($logFile);
    // create log file if not yet exists:
    if( !file_exists($logFile) ) 
    {
        if( !@copy("error/error.html", $logFile) ) return;
    }
    // if file size limit overflow:
    if( filesize($logFile) > $errorFileSizeLimit ) 
    {
        // reading all filenames in the log directory:
        $d = dir(LOG_DIR);
        $fileNames = array();
        while( ($entry=$d->read())!==FALSE )
        {
            if( !preg_match("/\.$logExtension$/", "$entry" ) || $entry=="error.$logExtension" ) continue;
            $fileNames[]=$entry;
        }
        $d->close();
        // if file number limit overflow:
        if( count($fileNames)>=$maxNumberOfArchivedErrorFiles )
        {
            // removing the oldest log file:
            sort($fileNames);
            unlink(LOG_DIR . "/$fileNames[0]");
        }
        $date = date("Y-m-d-H-i-s");  // e.g. 2008-03-14
        // stamping the current log file with the date:
        rename($logFile, LOG_DIR . "/error_$date.$logExtension");
        // creating a new log file:
        copy("error/error.html", $logFile);
    }
}

} // end class

global $suppressErrors;
if( !empty($suppressErrors) ) 
{
    $__ErrorHandler = new AppError();
    set_error_handler(array(&$__ErrorHandler, 'raiseError'));
}
elseif( defined("E_DEPRECATED") ) error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
else error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

?>
