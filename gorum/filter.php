<?php
defined('_NOAH') or die('Restricted access');

function filterInput($value)
{
    if( is_array($value) ) return array_map('filterInput', $value);
    do{ $output = $value; } while ($output != ($value = strip_selected_tags($value)));
    return $output;
}

function strip_selected_tags($text)
{
    $tags = array('applet', 'body', 'bgsound', 'base', 'basefont', 'embed', 'frame', 
                  'frameset', 'head', 'html', 'id', 'iframe', 'ilayer', 'layer', 'link', 'meta', 'name', 
                  'object', 'script', 'style', 'title', 'xml');
    $attributes = 'javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|'.
               'onmousemove|onmouseout|onkeypress|onkeydown|onkeyup';
    foreach ($tags as $tag){
        while(preg_match('/<'.$tag.'(|\W[^>]*)>(.*)<\/'. $tag .'>/isU', $text, $found)){
            $text = str_replace($found[0],$found[2],$text);
        }
    }
    $text = preg_replace('/(<('.join('|',$tags).')(|\W.*)\/?>)/isU', '', $text);
    return preg_replace('/(<[^>]*)'.$attributes.'([^>]*>)/isU', '$1$2', $text);
}

?>
