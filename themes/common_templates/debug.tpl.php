<?php 
    defined('_NOAH') or die('Restricted access'); 
    hasAdminRights($isAdm);
    if (!$isAdm) LocationHistory::rollBack(new AppController("/"));         
?>
<?php 
    // You can select from two debug styles. Use whichever you prefer:
    $debugStyle = "expandable";
    //$debugStyle = "simple";
    
    $vars = $this->getVars();
    $elements = $vars["elements"];
    //if( isset($vars["elements"]["contentTemplate"]->elements) ) $elements = $vars["elements"]["contentTemplate"]->elements;
    //else $elements = array();    
    unset($vars["elements"]);
    htmlspecialchars_arr($vars);
    
    echo "<h3>Variables that can be used in 'layout.tpl.php'</h3>";
    echo "<h4>Note: the same variables can be used in all the templates 'layout.tpl.php' includes with 'loadTemplate' (e.g. in the menu templete files)</h4>";
    echo "<h4>Note: the variables of 'layout.tpl.php' can be used in the content template files via the 'get' function</h4>";
    debug_var($vars, $debugStyle);

    echo "<h3>Content templates:</h3>";
    foreach( $elements as $element )
    {
        if( $element->templateFileName )
        {
            $vars = $element->tpl->getVars();
            $innerElements = $vars["elements"];
            unset($vars["elements"]);
            htmlspecialchars_arr($vars);
            
            echo "<h3>Variables that can be used in '$element->templateFileName'</h3>";
            debug_var($vars, $debugStyle);
        }
        else $innerElements = $element->tpl->elements;
        if( count($innerElements) )
        {
            foreach( $innerElements as $innerElement )
            {
                $vars = $innerElement->tpl->getVars();
                unset($vars["elements"]);
                htmlspecialchars_arr($vars);
                
                echo "<h3>Variables that can be used in '$innerElement->templateFileName'</h3>";
                debug_var($vars, $debugStyle);
            }
        }
    }
?>

<?php

function debug_var( $vars, $style="simple" )
{
    if( $style=="simple" ) debug_var_simple($vars);
    else debug_var_expandable("", print_r($vars, TRUE));
}

function htmlspecialchars_arr(&$arr)
{
    if( is_object($arr) ) return;
    if( !is_array($arr) ) $arr = htmlspecialchars($arr);
    else foreach( $arr as $key=>$value ) htmlspecialchars_arr($arr[$key]);
}
function debug_var_simple(&$var, $info = FALSE)
{
    $scope = false;
    $prefix = 'unique';
    $suffix = 'value';
 
    if($scope) $vals = $scope;
    else $vals = $GLOBALS;

    $old = $var;
    $var = $new = $prefix.rand().$suffix; $vname = FALSE;
    foreach($vals as $key => $val) if($val === $new) $vname = $key;
    $var = $old;

    echo "<pre style='margin: 0px 0px 10px 0px; display: block; background: white; color: black; font-family: Verdana; border: 1px solid #cccccc; padding: 5px; font-size: 10px; line-height: 13px;'>";
    if($info != FALSE) echo "<b style='color: red;'>$info:</b><br>";
    do_dump($var, '$'.$vname);
    echo "</pre>";
}

function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)
{
    $do_dump_indent = "<span style='color:#eeeeee;'>|</span> &nbsp;&nbsp; ";
    $reference = $reference.$var_name;
    $keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';

    if (is_array($var) && isset($var[$keyvar]))
    {
        $real_var = &$var[$keyvar];
        $real_name = &$var[$keyname];
        $type = ucfirst(gettype($real_var));
        echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
    }
    else
    {
        $var = array($keyvar => $var, $keyname => $reference);
        $avar = &$var[$keyvar];
   
        $type = ucfirst(gettype($avar));
        if($type == "String") $type_color = "<span style='color:green'>";
        elseif($type == "Integer") $type_color = "<span style='color:red'>";
        elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
        elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
        elseif($type == "NULL") $type_color = "<span style='color:black'>";
   
        if(is_array($avar))
        {
            $count = count($avar);
            echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#a2a2a2'>$type ($count)</span><br>$indent(<br>";
            $keys = array_keys($avar);
            foreach($keys as $name)
            {
                $value = &$avar[$name];
                do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
            }
            echo "$indent)<br>";
        }
        elseif(is_object($avar))
        {
            echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br>$indent(<br>";
            foreach($avar as $name=>$value) do_dump($value, "$name", $indent.$do_dump_indent, $reference);
            echo "$indent)<br>";
        }
        elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
        elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span><br>";
        elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
        elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
        elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
        else echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $avar<br>";

        $var = $var[$keyvar];
    }
}

function debug_var_expandable($name,$data)
{
    $captured = preg_split("/\r?\n/",$data);
    print "<script>function toggleDiv(num){
      var span = document.getElementById('d'+num);
      var a = document.getElementById('a'+num);
      var cur = span.style.display;
      if(cur == 'none'){
        a.innerHTML = '-';
        span.style.display = 'inline';
      }else{
        a.innerHTML = '+';
        span.style.display = 'none';
      }
    }</script>";
    print "<b>$name</b>\n";
    print "<pre>\n";
    foreach($captured as $line)
    {
        print debug_colorize_string($line)."\n";
    }
    print "</pre>\n";
}

function next_div($matches)
{
  static $num = 0;
  ++$num;
  return "$matches[1]<a id=a$num href=\"javascript: toggleDiv($num)\">+</a><span id=d$num style=\"display:none\">(";
}

function debug_colorize_string($string)
{
    $string = preg_replace("/\[(\w*)\]/i", '[<font color="red">$1</font>]', $string);
    $string = preg_replace_callback("/(\s+)\($/", 'next_div', $string);
    $string = preg_replace("/(\s+)\)$/", '$1)</span>', $string);
    /* turn array indexes to red */
    /* turn the word Array blue */
    $string = str_replace('Array','<font color="blue">Array</font>',$string);
    /* turn arrows graygreen */
    $string = str_replace('=>','<font color="#556F55">=></font>',$string);
    return $string;
} 
?>
