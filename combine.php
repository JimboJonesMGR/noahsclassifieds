<?php
include("initdirs.php");
include(NOAH_APP . "/constants.php");
include(NOAH_APP . "/js_css_map.php");
global $keysToJsFiles, $keysToCssFiles;
extendKeysToFilesWithThemeContent();

$cache 	  = TRUE;
$cachedir = FEED_DIR;
$base = NOAH_BASE;

$type = $_GET['type'];
if( $type=="css" ) $fileMap =& $keysToCssFiles;
elseif( $type=="javascript" ) $fileMap =& $keysToJsFiles;
else return;

$elements = explode(',', $_GET['files']);
$fullFileNames = array();
foreach( $elements as $f )
{
    if( isset($fileMap[$f]) && file_exists($fileMap[$f]) ) $fullFileNames[]=$fileMap[$f];
}
$elements =& $fullFileNames;
// Determine last modification date of the files
$lastmodified = 0;
while (list(,$element) = each($elements)) {
    $path = realpath($base . '/' . $element);

    if (($type == 'javascript' && substr($path, -3) != '.js') || 
        ($type == 'css' && substr($path, -4) != '.css')) {
        header ("HTTP/1.0 403 Forbidden");
        exit;	
    }
    
    $lastmodified = max($lastmodified, filemtime($path));
}
// Send Etag hash
$hash = $lastmodified . '-' . md5($_GET['files']);
header ("Etag: \"" . $hash . "\"");
// Expiration header: far future
$offset = 60 * 60 * 24 * 365;
$ExpStr = "Expires: " .gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
header($ExpStr);

if (0 && isset($_SERVER['HTTP_IF_NONE_MATCH']) && 
    stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"' . $hash . '"') 
{
    // Return visit and no modifications, so do not send anything
    header ("HTTP/1.0 304 Not Modified");
    header ('Content-Length: 0');
} 
else 
{
    // ha php-bol probalok tomoriteni az egesz nem mukodik es nem tudom, miert!
    // a .htaccess-be kel beirni: php_flag zlib.output_compression on
    // es akkor megy
    
    /*
    // Determine supported compression method
    $gzip = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
    $deflate = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');

    // Determine used compression method
    $encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');
    // Check for buggy versions of Internet Explorer
    if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') && 
        preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
        $version = floatval($matches[1]);
        
        if ($version < 6)
            $encoding = 'none';
            
        if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1')) 
            $encoding = 'none';
    }
    */
    $encoding = 'none';
    
    // First time visit or files were modified
    if ($cache) 
    {
        // Try the cache first to see if the combined files were already generated
        $cachefile = 'cache-' . $hash . '.' . $type . ($encoding != 'none' ? '.' . $encoding : '');
        
        if (file_exists($cachedir . '/' . $cachefile)) {
            if ($fp = fopen($cachedir . '/' . $cachefile, 'rb')) {
                if ($encoding != 'none') {
                    header ("Content-Encoding: " . $encoding);
                }
            
                header ("Content-Type: text/" . $type);
                //header ("Content-Length: " . filesize($cachedir . '/' . $cachefile));
    
                fpassthru($fp);
                fclose($fp);
                exit;
            }
        }
    }

    // Get contents of the files
    $contents = '';
    reset($elements);
    while (list(,$element) = each($elements)) {
        $path = realpath($base . '/' . $element);
        if( $type=="css" ) $contents .= "\n\n" . css_compress($element, file_get_contents($path));
        else  
        {
            $contents .= "\n\n" . file_get_contents($path);
            // in order to avoid conflict with other JS libraries, $JQ will be used instead of $:
            if( preg_match("/\bjquery\.js/", $path) )
            {
                $contents.="\n\nvar \$JQ = jQuery.noConflict();\n\n";
            }
        }
    }

    // Send Content-Type
    header ("Content-Type: text/" . $type);
    // Expiration header: far future
    //$offset = 60 * 60 * 24 * 365;
    //$ExpStr = "Expires: " .gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
    //header('Expires: Fri, 31 Dec 2010 14:19:41 GMT');
    
    if (isset($encoding) && $encoding != 'none') 
    {
        // Send compressed contents: nem mukodik!!!
        $contents = gzencode($contents, 9, $gzip ? FORCE_GZIP : FORCE_DEFLATE);
        header ('Content-Length: ' . strlen($contents));
        header ("Content-Encoding: " . $encoding);
        echo $contents;
    } 
    else 
    {
        // Send regular contents
        //header ('Content-Length: ' . strlen($contents));
        echo $contents;
    }

    // Store cache
    if ($cache) {
        if ($fp = fopen($cachedir . '/' . $cachefile, 'wb')) {
            fwrite($fp, $contents);
            fclose($fp);
        }
    }
}	

/**
 * Very simple CSS optimizer
 *
 */
function css_compress($file, $css){
    //strip comments through a callback
    $css = preg_replace_callback('#(/\*)(.*?)(\*/)#s','css_comment_cb',$css);

    //strip (incorrect but common) one line comments
    $css = preg_replace('/(?<!:)\/\/.*$/m','',$css);

    // strip whitespaces
    $css = preg_replace('![\r\n\t ]+!',' ',$css);
    $css = preg_replace('/ ?([:;,{}\/]) ?/','\\1',$css);

    // shorten colors
    $css = preg_replace("/#([0-9a-fA-F]{1})\\1([0-9a-fA-F]{1})\\2([0-9a-fA-F]{1})\\3/", "#\\1\\2\\3",$css);
    
    if( strstr($file, "/$_GET[theme]/" ) )
    {
        // replace relative background image paths with absolute ones:
        $css = preg_replace("{url\((['\"]?)../images/}", 'url($1'.NOAH_BASE."/themes/$_GET[theme]/images/", $css);
    }
    elseif( strstr($file, "markitup" ) )
    {
        $dir = str_replace( "style.css", "", $file);
        // replace relative background image paths with absolute ones:
        $css = preg_replace("{url\((['\"]?)}", '$0'.$dir, $css);
    }
    elseif( strstr($file, "jscalendar" ) )
    {
        $dir = str_replace( "theme.css", "", $file);
        // replace relative background image paths with absolute ones:
        $css = preg_replace("{url\((['\"]?)}", '$0'.$dir, $css);
    }

    return $css;
}

/**
 * Callback for css_compress()
 *
 * Keeps short comments (< 5 chars) to maintain typical browser hacks
 *
 */
function css_comment_cb($matches){
    if(strlen($matches[2]) > 4) return '';
    return $matches[0];
}

function extendKeysToFilesWithThemeContent()
{
    global $keysToCssFiles, $keysToJsFiles;
    
    $themesDir = opendir(THEMES_DIR);
    while( ($dir = readdir($themesDir)) !== false) 
    {
        if( (preg_match("/^\./", $dir) || $dir=="common_templates" || !is_dir(THEMES_DIR . "/$dir")) ) continue;
        $keysToJsFiles[$dir] = THEMES_DIR . "/$dir/javascripts/$dir.js";
        $themeDir = opendir(THEMES_DIR . "/$dir/css");
        while( ($file = readdir($themeDir)) !== false) 
        {
            if( strstr($file, '.css') ) $keysToCssFiles[$dir."@".substr($file, 0, -4)] = THEMES_DIR . "/$dir/css/$file";
        }
        closedir($themeDir);
    }
    closedir($themesDir);
}
