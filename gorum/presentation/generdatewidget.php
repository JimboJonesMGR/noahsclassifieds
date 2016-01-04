<?php
defined('_NOAH') or die('Restricted access');

class GenerDateWidget
{
function generSimpleDateField($name,$value,$withTime=FALSE,$attrInfo)
{
    $s=GenerDateWidget::generDateWidgett($name, $value,"horizontal",$withTime,$attrInfo);
    return $s;
}

function generComplexDateField($name,$value,$labels,$values,$selected=0)
{
    global $lll;
    $s="<table cellpadding='5' cellspacing='5'><tr><td valign='top'>";
    $s.="<select name='".$name."[relative]'>\n";
    foreach($labels as $key=>$label ){
        $values[$key]=htmlspecialchars($values[$key]);
        $s.="<option value=\"".$values[$key]."\"";
        if ((gettype($selected)=="array" && $selected[$key]) ||
            $key==$selected)
        {
            $s.=" selected";
        }
        $s.=">$label</option>\n";
    }
    $s.="</select>,\n <br>$lll[orSelectConcreteTime]:</td><td>";
    $s.=GenerDateWidget::generDateWidgett($name, $value, "vertical");
    $s.="</td></tr></table>\n";
    return $s;
}

function generDateWidgett($name, $value, $alignment="horizontal",
                         $withTime=FALSE, &$attrInfo)
{
    global $lll, $now;
    $s="";
    if (!isset($attrInfo["fromyear"])) $attrInfo["fromyear"]=2001;
    elseif($attrInfo["fromyear"]=="now") $attrInfo["fromyear"]=$now->getYear();
    if (!isset($attrInfo["toyear"])) $attrInfo["toyear"]=2010;
    elseif($attrInfo["toyear"]=="now") $attrInfo["toyear"]=$now->getYear();
    
    if( $alignment=="vertical" )
    {
        $s.="<table><tr><td class='celltext'>$lll[year]: </td><td>";
        $s.="<select name='".$name."[year]'>\n";
        for($i=$attrInfo["fromyear"];$i<=$attrInfo["toyear"];$i++){
            $s.="<option value='$i'";
            if($value->getYear()==$i)
            {
                $s.=" selected";
            }
            $s.=">$i</option>\n";
        }
        $s.="</select>\n";
        $s.="</td></tr>\n<tr><td class='celltext'>$lll[month]: </td><td>";
        $s.="<select name='".$name."[month]'>\n";
        for( $i=1; $i<13; $i++ ){
            $s.="<option value='$i'";
            if($value->getMonth()==$i)
            {
                $s.=" selected";
            }
            $s.=">".$lll["month_$i"]."</option>\n";
        }
        $s.="</select>\n";
        $s.="</td></tr>\n<tr><td class='celltext'>$lll[day]: </td><td>";
        $s.="<select name='".$name."[day]'>\n";
        for( $i=1; $i<32; $i++ ){
            $s.="<option value='$i'";
            if($value->getDay()==$i)
            {
                $s.=" selected";
            }
            $s.=">$i</option>\n";
        }
        $s.="</select>\n";
        if( $withTime )
        {
            $s.="</td></tr>\n<tr><td class='celltext'>$lll[hour]: </td><td>";
            $s.="<select name='".$name."[hour]'>\n";
            for( $i=0; $i<24; $i++ ){
                $s.="<option value='$i'";
                if($value->getHour()==$i)
                {
                    $s.=" selected";
                }
                $s.=">$i</option>\n";
            }
            $s.="</select>\n";
            $s.="</td></tr>\n<tr><td class='celltext'>$lll[minute]: </td><td>";
            $s.="<select name='".$name."[hour]'>\n";
            for( $i=0; $i<60; $i++ ){
                $s.="<option value='$i'";
                if($value->getMinute()==$i)
                {
                    $s.=" selected";
                }
                $s.=">$i</option>\n";
            }
            $s.="</select>\n";
        }
        $s.="</td></tr></table>\n";
    }
    else
    {
        $showRelation = isset($attrInfo["show_relation"]) ? $attrInfo["show_relation"] : 0;
        $year="<span class='celltext'>$lll[year]: ";
        $year.="<select name='".$name."[year]'>\n";
        $rel = "";
        if (in_array("undef",$attrInfo)) {
            if( $showRelation )
            {
                if( isset($showRelation["0"]) ) $rel=" show='$showRelation[0]_rel'";
                else $rel=" show='none'";
            }
            $year.="<option value='0'$rel>".$lll[$name."_undef"]."</option>\n";
        }
        for($i=$attrInfo["fromyear"];$i<=$attrInfo["toyear"];$i++){
            $year.="<option value='$i'";
            if($value->getYear()==$i)
            {
                $year.=" selected";
            }
            if( $showRelation )
            {
                if( isset($showRelation[$i]) ) $year.=" show='$showRelation[$i]_rel'";
                else $year.=" show='none'";
            }
            $year.=">$i</option>\n";
        }
        $year.="</select>\n";
        $month="$lll[month]: ";
        $month.="<select name='".$name."[month]'>\n";
        if (in_array("undef",$attrInfo)) {
            if( $showRelation )
            {
                if( isset($showRelation["0"]) ) $rel=" show='$showRelation[0]_rel'";
                else $rel=" show='none'";
            }
            $month.="<option value='0'$rel>".$lll[$name."_undef"]."</option>\n";
        }
        for( $i=1; $i<13; $i++ ){
            $month.="<option value='$i'";
            if($value->getMonth()==$i)
            {
                $month.=" selected";
            }
            if( $showRelation )
            {
                if( isset($showRelation[$i]) ) $month.=" show='$showRelation[$i]_rel'";
                else $month.=" show='none'";
            }
            $month.=">".$lll["month_$i"]."</option>\n";
        }
        $month.="</select>\n";
        $day="$lll[day]: ";
        $day.="<select name='".$name."[day]'>\n";
        if (in_array("undef",$attrInfo)) {
            if( $showRelation )
            {
                if( isset($showRelation["0"]) ) $rel=" show='$showRelation[0]_rel'";
                else $rel=" show='none'";
            }
            $day.="<option value='0'$rel>".$lll[$name."_undef"]."</option>\n";
        }
        for( $i=1; $i<32; $i++ ){
            $day.="<option value='$i'";
            if($value->getDay()==$i)
            {
                $day.=" selected";
            }
            if( $showRelation )
            {
                if( isset($showRelation[$i]) ) $day.=" show='$showRelation[$i]_rel'";
                else $day.=" show='none'";
            }
            $day.=">$i</option>\n";
        }
        $day.="</select>\n";
        $s.= in_array("reverse",$attrInfo) ? $day.$month.$year : $year.$month.$day;
        if( $withTime )
        {
            $s.="$lll[hour]: ";
            $s.="<select name='".$name."[hour]'>\n";
            if (in_array("undef",$attrInfo)) {
                if( $showRelation )
                {
                    if( isset($showRelation["0"]) ) $rel=" show='$showRelation[0]_rel'";
                    else $rel=" show='none'";
                }
                $s.="<option value='-1'$rel>".$lll[$name."_undef"]."</option>\n";
            }
            for( $i=0; $i<24; $i++ ){
                $s.="<option value='$i'";
                if($value->hour()==$i)
                {
                    $s.=" selected";
                }
                $s.=">$i</option>\n";
            }
            $s.="</select>\n";
            $s.="$lll[minute]: ";
            $s.="<select name='".$name."[minute]'>\n";
            if (in_array("undef",$attrInfo)) {
                if( $showRelation )
                {
                    if( isset($showRelation["0"]) ) $rel=" show='$showRelation[0]_rel'";
                    else $rel=" show='none'";
                }
                $s.="<option value='-1'$rel>".$lll[$name."_undef"]."</option>\n";
            }
            for( $i=0; $i<60; $i++ ){
                $s.="<option value='$i'";
                if($value->getMinute()==$i)
                {
                    $s.=" selected";
                }
                $s.=">$i</option>\n";
            }
            $s.="</select>\n";
        }
        $s.="</span>\n";
    }
    return $s;
}

function generDateTextField($name,$value,&$attrInfo, $size="", $maxlength="")
{
    global $now;
    if( $value->isEmpty() && in_array("defaultnow", $attrInfo) ) 
    {
        $display = $now->getDbFormat();
    }
    else $display = $value->getDbFormat();
    $jsCalendar = in_array("jscalendar", $attrInfo);
    $s=GenerWidget::generTextField('text',$name,$display,$size, $maxlength);
    if( $jsCalendar )
    {
        JavaScript::addInclude(GORUM_JS_DIR . "/jscalendar/calendar.js");
        JavaScript::addInclude(GORUM_JS_DIR . "/jscalendar/lang/calendar-en.js");
        JavaScript::addInclude(GORUM_JS_DIR . "/jscalendar/calendar-setup.js");
        JavaScript::addCss(GORUM_JS_DIR . "/jscalendar/skins/aqua/theme.css");
        //$s.="<button type='reset' id='trigger'>...</button>";
        $s.="<img src='".GORUM_JS_DIR."/jscalendar/img.gif' id='{$name}_trigger'
             style='cursor: pointer; border: 1px solid red;'
             title='Date selector'
             onmouseover=\"this.style.background='red';\"
             onmouseout=\"this.style.background=''\" >";
        $calendarDisplay = $display ? "'$display'" : "null";
        if (!isset($attrInfo["fromyear"])) $fromyear=$now->getYear();
        elseif($attrInfo["fromyear"]=="now") $fromyear=$now->getYear();
        elseif( preg_match("{now-(\d+)}", $attrInfo["fromyear"], $matches )) $fromyear=$now->getYear()-intval($matches[1]);  // e.g.: now-2
        else $fromyear=$attrInfo["fromyear"];
        if (!isset($attrInfo["toyear"])) $toyear=$now->getYear();
        elseif($attrInfo["toyear"]=="now") $toyear=$now->getYear();
        elseif( preg_match("{now\+(\d+)}", $attrInfo["toyear"], $matches )) $toyear=$now->getYear()+intval($matches[1]);  // e.g.: now+2
        else $toyear=$attrInfo["toyear"];
        $format = preg_replace("/\b\w\b/", "%$0", $attrInfo["display_format"]);  // minden betu ele beteszunk egy % jelet
        $format = str_replace("%i", "%M", $format); 
        $showsTime = in_array("showstime", $attrInfo) ? "true" : "false"; 
        JavaScript::addOnload("
          Calendar.setup(
            {
              inputField  : '$name',         // ID of the input field
              ifFormat    : '$format',    // the date format
              button      : '{$name}_trigger',       // ID of the button
              date        : $calendarDisplay,                 // initial date
              range       : [$fromyear, $toyear],   // range of years
              showsTime       : $showsTime
            }
          );
        ");
    }
    return $s;
}

}
?>
