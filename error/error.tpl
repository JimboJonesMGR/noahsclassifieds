<?php
$showSourceUri = '../error/showSource.php';
$showSourcePrev = 10;
$showSourceNext = 10;
?>

<script type="text/javascript">
var currentParam<?php echo $now ?> = -1;
</script>

<pre>
<b>Error type:</b> <?php echo $errType[$errNo]; ?>

<?php

    $c['default'] = '#000000';
    $c['keyword'] = '#0000A0';
    $c['number']  = '#800080';
    $c['string']  = '#404040';
    $c['comment'] = '#808080';

    if (count($info)) { 
        foreach ($info as $k => $v) {
            echo '<b>';
            echo $k;
            echo ':</b> ';
            echo $v;
            echo "\r\n";
        }
    } else {
        echo '<b>Message:</b> ';
        echo $errMsg;
        echo "\r\n";
    }

    echo "\r\n";

    echo '<span style="font-family: monospaced; font-size: 11px;">Variables:</span> ';
    echo '<span style="font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="showVariables('.$now.')">[show details]</span> ';
    echo '<span style="font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="hideVariables('.$now.')">[hide details]</span>';

    echo "\r\n";
    
    echo '<ul>';
    echo '<li style="list-style-type: square;">';
    echo '<span onmouseover="this.style.color=\'#0000ff\'" onmouseout="this.style.color=\''.$c['keyword'].'\'" style="color: '.$c['keyword'].'; cursor: pointer;" onclick="showGET('.$now.')">';
    echo 'GET';
    echo '</span><br>';
    echo '<span id="GET'.$now.'" style="display: none; color: gray;">';
    echo print_r($_GET, TRUE);
    echo '</span></li>';

    echo '<li style="list-style-type: square;">';
    echo '<span onmouseover="this.style.color=\'#0000ff\'" onmouseout="this.style.color=\''.$c['keyword'].'\'" style="color: '.$c['keyword'].'; cursor: pointer;" onclick="showPOST('.$now.')">';
    echo 'POST';
    echo '</span><br>';
    echo '<span id="POST'.$now.'" style="display: none; color: gray;">';
    echo print_r($_POST, TRUE);
    echo '</span></li>';

    echo '<li style="list-style-type: square;">';
    echo '<span onmouseover="this.style.color=\'#0000ff\'" onmouseout="this.style.color=\''.$c['keyword'].'\'" style="color: '.$c['keyword'].'; cursor: pointer;" onclick="showCOOKIE('.$now.')">';
    echo 'COOKIE';
    echo '</span><br>';
    echo '<span id="COOKIE'.$now.'" style="display: none; color: gray;">';
    echo print_r($_COOKIE, TRUE);
    echo '</span></li>';

    global $gorumroll, $gorumuser, $gorumrecognised;
    echo '<li style="list-style-type: square;">';
    echo '<span onmouseover="this.style.color=\'#0000ff\'" onmouseout="this.style.color=\''.$c['keyword'].'\'" style="color: '.$c['keyword'].'; cursor: pointer;" onclick="showGorumroll('.$now.')">';
    echo 'gorumroll';
    echo '</span><br>';
    echo '<span id="gorumroll'.$now.'" style="display: none; color: gray;">';
    echo print_r($gorumroll, TRUE);
    echo '</span></li>';
    
    if( $gorumrecognised ) 
    {
        echo '<li style="list-style-type: square;">';
        echo '<span style="color: '.$c['keyword'].';">';
        echo 'gorumuser: '.$gorumuser->name;
        echo '</span></li>';
    }
    echo '</ul>';
    
    if (isset($_SERVER["HTTP_USER_AGENT"])) {
        echo "<b>User Agent:</b> ";
        echo $_SERVER["HTTP_USER_AGENT"];
        echo "<br>";
    }
    if (isset($_SERVER["HTTP_REFERER"])) {
        echo "<b>Referer:</b> ";
        echo $_SERVER["HTTP_REFERER"];
        echo "<br>";
    }
    echo "<b>Php version:</b> ";
    echo phpversion();
    echo ", <b>MySql version:</b> ";
    echo @mysql_get_server_info();
    echo "<br>";
    echo "<br>";

    if (count($trace)) {

        echo '<span style="font-family: monospaced; font-size: 11px;">Trace: ' . count($trace) . "</span> ";
        echo '<span style="font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="showDetails('.count($trace).', '.$now.')">[show details]</span> ';
        echo '<span style="font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="hideDetails('.count($trace).', '.$now.')">[hide details]</span>';
    
        echo "\r\n";
        
        echo '<ul>';
        $currentParam = -1;
        
        foreach ($trace as $k => $v) {
            
            $currentParam++;
            
            echo '<li style="list-style-type: square;">';
            
            if (isset($v['class'])) {
                echo '<span onmouseover="this.style.color=\'#0000ff\'" onmouseout="this.style.color=\''.$c['keyword'].'\'" style="color: '.$c['keyword'].'; cursor: pointer;" onclick="showFile('.$k.', '.$now.')">';
                echo $v['class'];
                echo ".";
            } else {
                echo '<span onmouseover="this.style.color=\'#0000ff\'" onmouseout="this.style.color=\''.$c['keyword'].'\'" style="color: '.$c['keyword'].'; cursor: pointer;" onclick="showFile('.$k.', '.$now.')">';
            }
            
            echo $v['function'];
            echo '</span>';
            echo " (";
            
            $sep = '';
            $v['args'] = (array) @$v['args'];
            foreach ($v['args'] as $arg) {

                $currentParam++;
                
                echo $sep;
                $sep    = ', ';
                $color = '#404040';

                switch (true) {
                    
                    case is_bool($arg):
                        $param  = 'TRUE';
                        $string = $param;
                        break;

                    case is_int($arg):
                    case is_float($arg):
                        $param  = $arg;
                        $string = $arg;
                        $color = $c['number'];
                        break;

                    case is_null($arg):
                        $param = 'NULL';
                        $string = $param;
                        break;

                    case is_string($arg):
                        $param = $arg;
                        $string = 'string[' . strlen($arg) . ']';
                        break;

                    case is_array($arg):
                        $param='';
                        foreach( $arg as $key=>$val )
                        {
                            if( is_array($val) && isset($val['imap_ttitle']) ) break;  // $lll
                            $param.="[$key]=>";                            
                            $param.= get_class($val)=='Savant2' || get_class($val)=='View' ? '' : print_r($val, TRUE);
                            $param.='<br>';
                        }
                        $string = 'array[' . count($arg) . ']';
                        break;

                    case is_object($arg):
                        $param = get_class($arg)=='Savant2' || get_class($arg)=='View' ? '' : print_r($arg, TRUE);
                        $string = 'object: ' . get_class($arg);
                        break;

                    case is_resource($arg):
                        $param = 'resource: ' . get_resource_type($arg);
                        $string = 'resource';
                        break;

                    default:
                        $param = 'unknown';
                        $string = $param;
                        break;

                }

                echo '<span style="cursor: pointer; color: '.$color.';" onclick="showOrHideParam('.$currentParam.', '.$now.')" onmouseout="this.style.color=\''.$color.'\'" onmouseover="this.style.color=\'#dd0000\'">';
                echo $string;
                echo '</span>';
                echo '<span id="param'.$now.$currentParam.'" style="display: none;">' . $param . '</span>';

            }
            
            echo ")";
            echo "\r\n";

            if (!isset($v['file'])) {
                $v['file'] = 'unknown';
            }
            if (!isset($v['line'])) {
                $v['line'] = 'unknown';
            }

            $v['line'] = @$v['line'];
            echo '<span id="file'.$now.$k.'" style="display: none; color: gray;">';
            if ($v['file'] && $v['line']) {
                echo 'FILE: <a onmouseout="this.style.color=\'#007700\'" onmouseover="this.style.color=\'#FF6600\'" style="color: #007700; text-decoration: none;" target="_blank" href="'.$showSourceUri.'?file='.urlencode($v['file']).'&line='.$v['line'].'&prev='.$showSourcePrev.'&next='.$showSourceNext.'">'.basename($v['file']).'</a>';
            } else {
                echo 'FILE: ' . fontStart('#007700') . basename($v['file']) . fontEnd();
            }
            echo "\r\n";
            echo 'LINE: ' . fontStart('#007700') . $v['line'] . fontEnd() . "\r\n";
            echo 'DIR:  ' . fontStart('#007700') . dirname($v['file']) . fontEnd();
            echo '</span>';
            
            echo '</li>';
        }
        
        echo '</ul>';
   
    } else {
        echo '<b>File:</b> ';
        echo basename($file);
        echo ' (' . $line . ') ';
        echo dirname($file);
    }
    global $sqlQueryDump;
    if( $sqlQueryDump )
    {
        echo "\r\n";
    
        echo '<span style="font-family: monospaced; font-size: 11px;">SQL queries:</span> ';
        echo '<span style="font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="showSQL('.$now.')">[show details]</span> ';
        echo '<span style="font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="hideSQL('.$now.')">[hide details]</span>';
        echo "\r\n";
        echo "\r\n";
        echo "<span id='SQL$now' style='display: none;'>$sqlQueryDump</span>";
    }
?>

<?php echo '<span id="paramHide'.$now.'" style="display: none; font-family: monospaced; font-size: 11px; cursor: pointer;" onclick="hideParam('.$now.')">[hide param]</span>';?>
<span id="paramSpace<?php echo $now ?>" style="display: none;">

</span><div id="param<?php echo $now ?>" perm="0" style="background-color: #FFFFE1; padding: 2px; display: none;"></div><hr />
</pre>