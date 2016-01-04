<?php
defined('_NOAH') or die('Restricted access');
global $elll;
$elll["default"] = <<< EOF
A serious error has occured. <br>
<a href='%s'>Click here to go back to the site</a>
EOF;
$elll["notrec"] = <<< EOF
The system was not able to authenticate you as a logged in user,
and refused to access this function.
Please log in with your username and password, and navigate
to the function you wanted to access.
EOF;
$elll["rec"] = <<< EOF
You have no permission to access this function.
EOF;

global $errorList;
$errorList = array();

/**
* @project mygosuLib
* @package ErrorHandler
* @version 2.0.1
* @license BSD
* @copyright (c) 2003,2004 Cezary Tomczak
* @link http://gosu.pl/software/mygosulib.html
*/

define('ERROR_HANDLER_ROOT', dirname(__FILE__));

/**
* @access public
* @package ErrorHandler
*/
class Error {

    /**
    * Constructor
    * @access public
    */
    function Error($logFile) {
        ini_set('docref_root', null);
        ini_set('docref_ext', null);
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        ini_set("ignore_repeated_errors",1);
        //ini_set("ignore_repeated_source",1);
        ini_set("display_errors",1);
        ini_set("log_errors",0);
        ini_set("log_errors_max_len",0);
        ini_set("track_errors",1);//??? ezt hasznalni? TODO 2
        ini_set("error_log",$logFile);
        // Parse,Compile, Core, etc... Errors
        ini_set('html_errors',false);
        //ini_set('error_prepend_string','<html><head><META http-equiv="refresh" content="0;URL=index.php?list=displayerror&method=show&rollid=');
        //ini_set('error_append_string','"></head></html>');
    }

    /**
    * @param int $errNo
    * @param string $errMsg
    * @param string $file
    * @param int $line
    * @return void
    * @access public
    */
    function raiseError($errNo, $errMsg, $file, $line) {
        // Az ismetlodo hibakat nem logoljuk:
        if( $this->duplicateFound($errNo, $errMsg, $file, $line) ) return;
        static $errorCounter = 0;
        
        if (! ($errNo & error_reporting())) {
            return;
        }
        /*
        while (ob_get_level()) {
            @ob_end_clean();
        }
        */
        $errType = array (
            1    => "Php Error",
            2    => "Php Warning",
            4    => "Parsing Error",
            8    => "Php Notice",
            16   => "Core Error",
            32   => "Core Warning",
            64   => "Compile Error",
            128  => "Compile Warning",
            256  => "Php User Error",
            512  => "Php User Warning",
            1024 => "Php User Notice"
        );
        
        $info = array();

        if (($errNo & E_USER_ERROR) && is_array($arr = @unserialize($errMsg))) {
            foreach ($arr as $k => $v) {
                $info[$k] = $v;
            }
        }
        
        $trace = array();

        if (function_exists('debug_backtrace')) {
            $trace = debug_backtrace();
            //array_shift($trace);
        }

        ob_start();
        $now = time()+ $errorCounter;
        include ERROR_HANDLER_ROOT . '/error.tpl';
        $errorCounter++;
        $s = ob_get_contents();
        @ob_end_clean();
        error_log($s,0);//logba
        
        global $elll;
        if ($errNo==E_USER_ERROR) {
            $ctrl = new AppController("/");
            header("Location: ".$ctrl->makeUrl(TRUE));
        }
    }
    
    function displayErrorPage($txt)
    {
        echo $txt;
        die();
    }
    
    function duplicateFound($errNo, $errMsg, $file, $line) 
    {
        global $errorList;
    
        $lastErr = array("errno"=>$errNo, "errmsg"=>$errMsg, "file"=>$file, "line"=>$line);
        foreach( $errorList as $err ) if( $err==$lastErr ) return TRUE;
        $errorList[]=$lastErr;
        return FALSE;
    }
} // end class

function fontStart($color) {
    return '<font color="' . $color . '">';
}
function fontEnd() {
    return '</font>';
}


?>