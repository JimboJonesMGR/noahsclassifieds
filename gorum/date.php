<?php
defined('_NOAH') or die('Restricted access');

include_once("adodb-time.inc.php");

define("Date_Year", 6);
define("Date_Month", 5);
define("Date_Week", 4);
define("Date_Day", 3);
define("Date_Hour", 2);
define("Date_Minute", 1);
define("Date_Second", 0);

// human readable formats:    
$Date_format="Y-m-d H:i:s";
$Date_formatIgnoreSecond="Y-m-d H:i";    
$Date_formatIgnoreHour="Y-m-d";

$now = new Date("now");    

class Date
{

var $timestamp=0;
var $dbFormat ='';

var $year     =0;
var $month    =0;
var $day      =0;
var $hour     =0;
var $minute   =0;
var $second   =0;

var $error    ='';

var $ignoreSecond = FALSE;
var $ignoreHour   = FALSE;

// A lehetseges parametere:
// - ures: ures datummal inicializalodik,
// - integer: timestampnak tekinti,
// - string: minden datumformatum megfelel, amit az strtotime elfogad,
// - 2-6 db. kulonallo parameter: year, month, day, hour, minute, second - az utolso 4 hianyozhat
// - 2-6 elem tombje: u.a., mint az elozo
function Date()
{
    if(($num_args = func_num_args()) > 0)
    {
        $args = func_get_args();
        
        if( is_array($args[0]) )
        {
            $args = $args[0];
            $num_args = count($args);
            // ez akkor lehet ha egy leszarmazott osztaly konstruktorat hivjak meg egy tombbel:
            if( is_array($args[0]) )
            {
                $args = $args[0];
                $num_args = count($args);
            }
            // hogy indexelten is meglegyenek az ertekek, ha asszociativ tombot kapunk:
            $i=0;
            foreach( $args as $key=>$value ) $args[$i++]=$value;
        }
    }
    switch($num_args)
    {
        case 6:
            $this->second = $args[5];
        case 5:
            $this->minute = $args[4];
        case 4:
            $this->hour = $args[3];
        case 3:
            $this->day = $args[2];
        case 2:
            $this->month = $args[1];
            $this->year = $args[0];
            // ha szandekosan nem adtak at napot, 1-re allitjuk, de ha atadtak
            // es az 0, akkor 0 marad:
            if( $num_args==2 ) $this->day = 1;
            $this->timestamp = adodb_mktime($this->hour, $this->minute, $this->second, $this->month, $this->day , $this->year);
            break;
        case 1:
            if( is_numeric($args[0]) )
            {
                $this->timestamp = $args[0];
            }
            elseif( is_string($args[0]) )
            {
                $this->fromString($args[0]);
            }
            break;
        case 0:
            break;
    }
    $this->update();
}

function __toString()
{
    return $this->dbFormat;
}

function getDbFormat($dbType='')
{
    // le kell vagni az idot:
    if( $dbType=="DATE" ) return substr($this->__toString(), 0, 10);
    return $this->__toString();
}

// timestamp alapjan beallitja a tobbi osztalyvaltozot:
function update()
{
    if( $this->timestamp!=0 )
    {
        $this->year = (int)adodb_date("Y", $this->timestamp);
        $this->month = (int)adodb_date("n", $this->timestamp);
        $this->day = (int)adodb_date("j", $this->timestamp);
        $this->hour = (int)adodb_date("H", $this->timestamp);
        $this->minute = (int)adodb_date("i", $this->timestamp);
        $this->second = (int)adodb_date("s", $this->timestamp);
        $this->dbFormat = adodb_date("Y-m-d H:i:s", $this->timestamp);
    }
}

function fromString( $strDate )
{
    if( !$strDate || preg_match("/^0000-00-00/", $strDate) ) $this->timeStamp = 0;
    elseif( ($this->timestamp = strtotime($strDate))===FALSE )
    {
        if( preg_match("/(\d{4})-(\d{2})-(\d{2})/", $strDate, $matches ) )
        {
            list($year, $month, $day) = $matches;
            if( preg_match("/(\d{2}):(\d{2})/", $strDate, $matches ) )
            {
                list($hour, $minute) = $matches;
            }
            else list($hour, $minute) = array(0,0);
            $this->timestamp = adodb_mktime($hour, $minute, 0, $month, $day , $year);
        }
        else
        {
            $this->error = "Invalid date: $strDate";
        }
    }
}

function isEmpty(){ return ($this->timestamp==0); }

function getTimestamp() {return $this->timestamp; }
function getYear() {return $this->year; }
function getMonth() {return $this->month; }
function getDay() {return $this->day; }
function getHour() {return $this->hour; }
function getMinute() {return $this->minute; }
function getSecond() {return $this->second; }
function getError() {return $this->error; }
function getWeek() {return (int)adodb_date('W', $this->timestamp); }
function getDayOfWeek() {return (int)adodb_date('N', $this->timestamp); }
function getDayOfWeekUSA() {return (int)adodb_date('w', $this->timestamp); }
function getDayOfYear() {return (int)adodb_date('z', $this->timestamp); }  // 0...365

function setYear($v)
{
    $this->timestamp = adodb_mktime($this->hour, $this->minute, $this->second, $this->month, $this->day , $v);
    $this->update();
}
function setMonth($v)
{
    $this->timestamp = adodb_mktime($this->hour, $this->minute, $this->second, $v, $this->day, $this->year);
    $this->update();
}
function setDay($v)
{
    $this->timestamp = adodb_mktime($this->hour, $this->minute, $this->second, $this->month, $v, $this->year);
    $this->update();
}
function setHour($v)
{
    $this->timestamp = adodb_mktime($v, $this->minute, $this->second, $this->month, $this->day, $this->year);
    $this->update();
}
function setMinute($v)
{
    $this->timestamp = adodb_mktime($this->hour, $v, $this->second, $this->month, $this->day, $this->year);
    $this->update();
}
function setSecond($v)
{
    $this->timestamp = adodb_mktime($this->hour, $this->minute, $v, $this->month, $this->day, $this->year);
    $this->update();
}

// Osszehasonlito fuggvenyek:
// A $precision parameter megadja azt az utolso datum mezot, amire meg az osszehasonlitas ervenyes, pl:
// $d1->isEqual( $d2, Date_Day ) megadja, hogy $d1 es $d2 ugyanarra a napra esik-e
// $d1->isBefore( $d2, Date_Year) megadja, hogy $d1 egy korabbi evben volt-e mint $d2

function compare( $operator, $date, $precision=Date_Second )
{
    if( $operator=='==' ) return $this->isEqual($date, $precision);
    if( $operator=='!=' ) return !$this->isEqual($date, $precision);
    if( $operator=='>' )  return $this->isGreaterThan($date, $precision);
    if( $operator=='<' )  return $this->isLessThan($date, $precision);
    if( $operator=='<=' ) return !$this->isGreaterThan($date, $precision);
    if( $operator=='>=' ) return !$this->isLessThan($date, $precision);
}                
function isEqual( $date, $precision=Date_Second )
{
    return $this->comparisionCore($date, $precision, "attrsAreEqual", "==");
}
function isGreaterThan( $date, $precision=Date_Second )
{
    return $this->comparisionCore($date, $precision, "attrsAreGreaterThan", ">");
}
function isLessThan( $date, $precision=Date_Second )
{
    return $this->comparisionCore($date, $precision, "attrsAreLessThan", "<");
}
function isNotEqual( $date, $precision=Date_Second )
{
    return !$this->isEqual( $date, $precision );
}
function isGreaterThanOrEqual( $date, $precision=Date_Second )
{
    return !$this->isLessThan( $date, $precision );
}
function isLessThanOrEqual( $date, $precision=Date_Second )
{
    return !$this->isGreaterThan( $date, $precision );
}
function isAfter( $date, $precision=Date_Second )
{
    return $this->isGreaterThan( $date, $precision );
}
function isBefore( $date, $precision=Date_Second )
{
    return $this->isLessThan( $date, $precision );
}
function isBetween( $date1, $date2, $borders="<>", $precision=Date_Second )
{
    if( $borders=="<>" ) return $this->isGreaterThan( $date1, $precision ) && $this->isLessThan( $date2, $precision );
    elseif( $borders=="<>=" ) return $this->isGreaterThan( $date1, $precision ) && $this->isLessThanOrEqual( $date2, $precision );
    elseif( $borders=="<=>" ) return $this->isGreaterThanOrEqual( $date1, $precision ) && $this->isLessThan( $date2, $precision );
    elseif( $borders=="<=>=" ) return $this->isGreaterThanOrEqual( $date1, $precision ) && $this->isLessThanOrEqual( $date2, $precision );
}
// Az idopont a jovoben van-e:
function isFuture()
{
    global $now;
    return $this->isGreaterThan($now);
}
// Az idopont a multban van-e:
function isPast()
{
    return !$this->isFuture();
}

// Privat osszehasonlito fuggvenyek - csak a fentiek hasznaljak oket
function comparisionCore( $date, $precision, $comparisionFg, $comparisionOp )
{
    switch( $precision )
    {
        case Date_Second: eval('return $this->timestamp'.$comparisionOp.'$date->timestamp;');
        case Date_Minute: return $this->$comparisionFg($date, array("year", "month", "day", "hour", "minute"));        
        case Date_Hour:   return $this->$comparisionFg($date, array("year", "month", "day", "hour"));        
        case Date_Day:    return $this->$comparisionFg($date, array("year", "month", "day"));        
        case Date_Month:  return $this->$comparisionFg($date, array("year", "month"));        
        case Date_Year:   return $this->$comparisionFg($date, array("year"));        
    }
}
function attrsAreEqual( $date, $attrs )
{
    foreach( $attrs as $attr ) if( $this->{$attr}!=$date->{$attr} ) return FALSE;
    return TRUE;                                  
}
function attrsAreGreaterThan( $date, $attrs )
{
    foreach( $attrs as $attr )
    {
        if( $this->{$attr}>$date->{$attr} ) return TRUE;
        if( $this->{$attr}<$date->{$attr} ) return FALSE;
    }        
    return FALSE; // egyenlok
}
function attrsAreLessThan( $date, $attrs )
{
    foreach( $attrs as $attr )
    {
        if( $this->{$attr}<$date->{$attr} ) return TRUE;
        if( $this->{$attr}>$date->{$attr} ) return FALSE;
    }        
    return FALSE; // egyenlok
}

// Datum aritmetika:

// Pl: $d->add( 1, Date_Year ) : $d-hez kepest 1 ev mulva
//     Date::add( 1, Date_Day ): 1 nap mulva
function add( $num, $what )
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : $now;
    switch( $what )
    {
        case Date_Second: return new Date($d->timestamp+$num);
        case Date_Minute: return new Date($d->timestamp+$num*60);
        case Date_Hour: return new Date($d->timestamp+$num*3600);
        // ez igy figyelembe veszi a teli-nyari oraatallitast is:    
        case Date_Day: return new Date($d->year, $d->month, $d->day+$num, $d->hour, $d->minute, $d->second);
        case Date_Week: return new Date($d->year, $d->month, $d->day+7*$num, $d->hour, $d->minute, $d->second);
        case Date_Month: return new Date($d->year, $d->month+$num, $d->day, $d->hour, $d->minute, $d->second);
        case Date_Year: return new Date($d->year+$num, $d->month, $d->day, $d->hour, $d->minute, $d->second);
    }
}
function subtract( $num, $what )
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : $now;
    return $d->add(-1*$num, $what);
}

// Diff related methods:

// Egy Date objektumot ad vissza, melynek a day, hour, minute es second mezeje
// annak megfeleloen lesz beallitva, hogy a kerdeses ket datum kozott (ha nem adunk
// parametert, az aktualis idot veszi) hany nap, ora, perc es masodperc elteres van.
// Ezek aztan a megfelelo get metodusokkal lekerdezhetok.
function getFullDiff( $otherDate=0 )
{
    global $now;
    if( !$otherDate ) $otherDate=$now;
    $diff = abs($this->timestamp - $otherDate->timestamp);  //second
    $ret = new Date();
    $ret->day = floor($diff/86400);
    $diff = $diff % 86400;
    $ret->hour = floor($diff/3600);
    $diff = $diff % 3600;
    $ret->minute = floor($diff/60);
    $ret->second = $diff % 60;
    return $ret;
}
// Ket datum kozti kulonbseg masodpercekben szamitva
function getSecondDiff( $otherDate=0 )
{
    global $now;
    if( !$otherDate ) $otherDate=$now;
    return abs($this->timestamp-$otherDate->timestamp);
}
// Ket datum kozti kulonbseg percekben szamitva
function getMinuteDiff( $otherDate=0 )
{
    return $this->getSecondDiff($otherDate)/60;
}
// Ket datum kozti kulonbseg orakban szamitva
function getHourDiff( $otherDate=0 )
{
    return $this->getSecondDiff($otherDate)/3600;
}
// Ket datum kozti kulonbseg napokban szamitva
function getDayDiff( $otherDate=0 )
{
    return $this->getSecondDiff($otherDate)/86400;
}
// Ket datum kozotti elterest adja meg 'hours:minutes' formatumban.
// Pl.: 34:10, 5:00
function getHoursMinutesDiff( $otherDate=0 )
{
    $diff = $this->getFullDiff($otherDate);
    return ($diff->getDay()*24 + $diff->getHour()).":".sprintf("%02d", $diff->getMinute());
}

// Related date methods:
// Statikudan es tagfuggvenykent is lehet oket hivni. Pl:
// $date->firstSecondOfDay()  <=>  Date::firstSecondOfDay($date)
// $now->firstSecondOfDay()  <=>  Date::firstSecondOfDay()
function firstSecondOfDay($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    return new Date($d->year, $d->month, $d->day);
}
function lastSecondOfDay($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    return new Date($d->year, $d->month, $d->day, 23, 59, 59);
}
function firstDayOfWeek($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    return new Date($d->year, $d->month, $d->day - adodb_date('N', $d->timestamp) + 1);
}
function lastDayOfWeek($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    return new Date($d->year, $d->month, $d->day + 7 - adodb_date('N', $d->timestamp));
}
function firstDayOfMonth($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    return new Date($d->year, $d->month, 1);
}
function lastDayOfMonth($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    return new Date($d->year, $d->month+1, 0);
}
function firstDayOfYear($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    return new Date($d->year, 1, 1);
}
function lastDayOfYear($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    return new Date($d->year, 12, 31);
}
function lastSecondOfWeek($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    $lastDay = $d->lastDayOfWeek();
    return $lastDay->lastSecondOfDay();
}
function lastSecondOfMonth($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    $lastDay = $d->lastDayOfMonth();
    return $lastDay->lastSecondOfDay();
}
function lastSecondOfYear($date=0)
{
    global $now;
    $d = isset($this) && is_a($this, "Date") ? $this : ($date ? $date : $now);
    $lastDay = $d->lastDayOfYear();
    return $lastDay->lastSecondOfDay();
}

// Display formatting related methods:
/* static */ function setFormat($format)
{
    global $Date_format;
    $Date_format = $format;
}
/* static */ function setFormatIgnoreSecond($format)
{
    global $Date_formatIgnoreSecond;
    $Date_formatIgnoreSecond = $format;
}
/* static */ function setFormatIgnoreHour($format)
{
    global $Date_formatIgnoreHour;
    $Date_formatIgnoreHour = $format;
}
function format($format='', $textForEmptyDate='')
{
    global $Date_formatIgnoreHour, $Date_formatIgnoreSecond, $Date_format;
    if( $this->isEmpty() ) return $textForEmptyDate;
    if( !$format )
    {
        if( $this->ignoreHour ) $format = $Date_formatIgnoreHour;
        elseif( $this->ignoreSecond ) $format = $Date_formatIgnoreSecond;
        else $format = $Date_format;
    }
    return adodb_date( $format, $this->timestamp );   
}
function setIgnoreSecond( $i )
{
    $this->ignoreSecond = $i;
}
function setIgnoreHour( $i )
{
    $this->ignoreHour = $i;
}

/* static */ function test()
{
    $d = new Date("hjsgdf");
    echo "Invalid date:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date();
    echo "Default date:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date("now");
    echo "Current date:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date('1960-02-10 01:02:03');
    echo "From string - '1960-02-10 01:02:03':<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date('Wed, 01/16/2008 07:20');
    echo "From string - 'Wed, 01/16/2008 07:20':<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(1907, 1);
    echo "From 2 separate parameters:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(1907, 1, 15);
    echo "From 3 separate parameters:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(1907, 1, 15, 1);
    echo "From 4 separate parameters:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(1907, 1, 15, 1, 2);
    echo "From 5 separate parameters:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(1907, 1, 15, 1, 2, 3);
    echo "From 6 separate parameters:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(array("year"=>1, "month"=>2, "day"=>3, "hour"=>4, "minute"=>5, "second"=>6));
    echo "From array of 6:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(array("year"=>1, "month"=>2, "day"=>3, "hour"=>4, "minute"=>5));
    echo "From array of 5:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(array("year"=>1, "month"=>2, "day"=>3, "hour"=>4));
    echo "From array of 4:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    $d = new Date(array("year"=>1, "month"=>2, "day"=>3));
    echo "From array of 3:<br>";
    echo "<pre>".print_r($d, TRUE)."</pre>";
    
    echo "<h3>Comparision test:</h3><br>";
    $d1 = new Date('1907-6-15 12:30:30');
    $d11 = new Date('1907-6-15 12:30:30');
    $d2 = new Date('1907-6-16 12:30:30');
    $d3 = new Date('1907-6-17 12:30:30');
    echo "$d1==$d11: ".($d1->compare('==', $d11) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1!=$d11: ".(!$d1->compare('!=', $d11) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1<$d11: ".(!$d1->compare('<', $d11) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1>$d11: ".(!$d1->compare('>', $d11) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1<=$d11: ".($d1->compare('<=', $d11) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1>=$d11: ".($d1->compare('>=', $d11) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    
    echo "$d1==$d2: ".(!$d1->compare('==', $d2) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1!=$d2: ".($d1->compare('!=', $d2) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1<$d2: ".($d1->compare('<', $d2) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1>$d2: ".(!$d1->compare('>', $d2) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1<=$d2: ".($d1->compare('<=', $d2) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1>=$d2: ".(!$d1->compare('>=', $d2) ? 'ok' : '<font color=red>NOK</font>')."<br>";

    echo "$d1<$d2<$d3: ".($d2->isBetween($d1, $d3) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1<=$d11<$d3: ".($d11->isBetween($d1, $d3, '<=>') ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1<$d2: ".($d1->isBefore($d2) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d3>$d2: ".($d3->isAfter($d2) ? 'ok' : '<font color=red>NOK</font>')."<br>";

    echo "$d1==$d2(day): ".(!$d1->compare('==', $d2, Date_Day) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1!=$d2(day): ".($d1->compare('!=', $d2, Date_Day) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1<$d2(day): ".($d1->compare('<', $d2, Date_Day) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1>$d2(day): ".(!$d1->compare('>', $d2, Date_Day) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1<=$d2(day): ".($d1->compare('<=', $d2, Date_Day) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1>=$d2(day): ".(!$d1->compare('>=', $d2, Date_Day) ? 'ok' : '<font color=red>NOK</font>')."<br>";

    echo "$d1==$d2(month): ".($d1->compare('==', $d2, Date_Month) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1==$d2(year): ".($d1->compare('==', $d2, Date_Year) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    echo "$d1==$d2(hour): ".(!$d1->compare('==', $d2, Date_Hour) ? 'ok' : '<font color=red>NOK</font>')."<br>";
    
    echo "<h3>Diff test:</h3><br>";
    $d1 = new Date('1907-6-15 12:30:30');
    $d2 = new Date('1907-6-17 12:30:30');
    $d3 = new Date('1907-6-15 13:32:33');
    echo "Diff of $d1 and $d2:<br>";
    echo "<pre>".print_r($d1->getFullDiff($d2), TRUE)."</pre>";
    echo "Diff of $d1 and $d3:<br>";
    echo "<pre>".print_r($d1->getFullDiff($d3), TRUE)."</pre>";
    echo "Diff of $d2 and $d3:<br>";
    echo "<pre>".print_r($d2->getFullDiff($d3), TRUE)."</pre>";
    echo "Diff of $d1 and $d1:<br>";
    echo "<pre>".print_r($d1->getFullDiff($d1), TRUE)."</pre>";
    
    echo "Diff of $d1 and $d2:<br>";
    echo "<pre>".$d1->getHoursMinutesDiff($d2)."</pre>";
    echo "Diff of $d1 and $d3:<br>";
    echo "<pre>".$d1->getHoursMinutesDiff($d3)."</pre>";
    echo "Diff of $d2 and $d3:<br>";
    echo "<pre>".$d2->getHoursMinutesDiff($d3)."</pre>";
    echo "Diff of $d1 and $d1:<br>";
    echo "<pre>".$d1->getHoursMinutesDiff($d1)."</pre>";
    
    echo "firstSecondOfDay $d1:<br>";
    echo "<pre>".$d1->firstSecondOfDay()."</pre>";
    
    echo "firstSecondOfDay $d1:<br>";
    echo "<pre>".Date::firstSecondOfDay($d1)."</pre>";
    
    echo "firstSecondOfDay today:<br>";
    echo "<pre>".Date::firstSecondOfDay()."</pre>";
    
    echo "lastSecondOfDay $d1:<br>";
    echo "<pre>".$d1->lastSecondOfDay()."</pre>";
    
    echo "firstDayOfWeek $d1:<br>";
    echo "<pre>".$d1->firstDayOfWeek()."</pre>";
    
    echo "lastDayOfWeek $d1:<br>";
    echo "<pre>".$d1->lastDayOfWeek()."</pre>";
    
    echo "firstDayOfMonth $d1:<br>";
    echo "<pre>".$d1->firstDayOfMonth()."</pre>";
    
    echo "lastDayOfMonth $d1:<br>";
    echo "<pre>".$d1->lastDayOfMonth()."</pre>";
    
    echo "firstDayOfYear $d1:<br>";
    echo "<pre>".$d1->firstDayOfYear()."</pre>";
    
    echo "lastDayOfYear $d1:<br>";
    echo "<pre>".$d1->lastDayOfYear()."</pre>";

    echo "lastSecondOfWeek $d1:<br>";
    echo "<pre>".$d1->lastSecondOfWeek()."</pre>";
    
    echo "lastSecondOfMonth $d1:<br>";
    echo "<pre>".$d1->lastSecondOfMonth()."</pre>";
    
    echo "lastSecondOfYear $d1:<br>";
    echo "<pre>".$d1->lastSecondOfYear()."</pre>";

    echo "<h3>Datum aritmetika:</h3><br>";
    echo "$d1 ->add( 1, Date_Second ):<br>";
    echo "<pre>".$d1->add( 1, Date_Second )."</pre>";
    echo "$d1 ->add( 1, Date_Minute ):<br>";
    echo "<pre>".$d1->add( 1, Date_Minute )."</pre>";
    echo "$d1 ->add( 1, Date_Hour ):<br>";
    echo "<pre>".$d1->add( 1, Date_Hour )."</pre>";
    echo "$d1 ->add( 1, Date_Day ):<br>";
    echo "<pre>".$d1->add( 1, Date_Day )."</pre>";
    echo "$d1 ->add( 1, Date_Week ):<br>";
    echo "<pre>".$d1->add( 1, Date_Week )."</pre>";
    echo "$d1 ->add( 1, Date_Month ):<br>";
    echo "<pre>".$d1->add( 1, Date_Month )."</pre>";
    echo "$d1 ->add( 1, Date_Year ):<br>";
    echo "<pre>".$d1->add( 1, Date_Year )."</pre>";
    echo "1 nap mulva:<br>";
    echo "<pre>".Date::add( 1, Date_Day )."</pre>";
    echo "1 honap mulva:<br>";
    echo "<pre>".Date::add( 1, Date_Month )."</pre>";
    echo "1 ev mulva:<br>";
    echo "<pre>".Date::add( 1, Date_Year )."</pre>";
    echo "1 nappal ezelott:<br>";
    echo "<pre>".Date::subtract( 1, Date_Day )."</pre>";
    echo "1 honappal ezelott:<br>";
    echo "<pre>".Date::subtract( 1, Date_Month )."</pre>";
    echo "1 evvel ezelott:<br>";
    echo "<pre>".Date::subtract( 1, Date_Year )."</pre>";
    
}

}

//Date::test();

?>