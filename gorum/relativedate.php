<?php
defined('_NOAH') or die('Restricted access');
define("Date_Absolute", 0);
define("Date_Ago", '-');
define("Date_FromNow", '+');

class RelativeDate extends Date
{

var $dir = Date_Absolute;

// A lehetseges parametere:
// - ures: a jelenlegi idovel inicializalodik,
// - integer: timestampnak tekinti,
// - string: minden datumformatum megfelel, amit az strtotime elfogad,
// - 2-7 db. kulonallo parameter: year, month, day, hour, minute, second, dir - az utolso 5 hianyozhat
// - 2-7 elem tombje: u.a., mint az elozo
// - '-': egy ures Ago
// - '+': egy user FromNow
function RelativeDate()
{
    $num_args = func_num_args();
    $args = func_get_args();
    // ha a parameterek relative date-re utalnak:
    if( $num_args==7 || (is_array($args[0]) && isset($args[0]["dir"])) )
    {
        if( is_array($args[0]) )
        {
            $args = $args[0];
            $num_args = count($args);
            // hogy indexelten is meglegyenek az ertekek, ha asszociativ tombot kapunk:
            if( isset($args["year"]) ) $args[]=$args["year"];
            if( isset($args["month"]) ) $args[]=$args["month"];
            if( isset($args["day"]) ) $args[]=$args["day"];
            if( isset($args["hour"]) ) $args[]=$args["hour"];
            if( isset($args["minute"]) ) $args[]=$args["minute"];
            if( isset($args["second"]) ) $args[]=$args["second"];
            if( isset($args["dir"]) ) $args[]=$args["dir"];
        }
        switch($num_args)
        {
            case 7:
                $this->dir = $args[6];
            case 6:
                if( !$this->dir ) $this->dir = $args[5];
                else $this->second = $args[5];
            case 5:
                $this->minute = $args[4];
            case 4:
                if( !$this->dir ) $this->dir = $args[3];
                else $this->hour = $args[3];
            case 3:
                $this->day = $args[2];
            case 2:
                $this->month = $args[1];
                $this->year = $args[0];
        }
        $this->update();
    }
    elseif($num_args==1 )
    {
        if( $args[0]==Date_Ago || $args[0]==Date_FromNow ) $this->dir=$args[0];
        elseif( !is_numeric($args[0]) && is_string($args[0]) && preg_match( "/^(8|9)\d{3}-\d{2}-\d{2} ?\d{0,2}:?\d{0,2}:?\d{0,2}/", $args[0] ) )
        {
            $this->fromString($args[0]);
            $this->update();
        }
        else parent::Date($args);  // absolute date eseten
    }
    else parent::Date($args);  // absolute date eseten
}

// dbFormat-ot aktualizalja a tobbi tagvaltozo alapjan:
function update()
{
    global $now;
    
    if( $this->dir )
    {
        $dir = $this->dir==Date_Ago ? -1 : +1;
        // Relative date eseteben a timestamp a mosthoz kepest eltolt idopont timestampjet fogja tartalmazni:
        $this->timestamp = mktime( $now->getHour()  + $dir * $this->hour,
                                   $now->getMinute()+ $dir * $this->minute,
                                   $now->getSecond()+ $dir * $this->second,
                                   $now->getMonth() + $dir * $this->month,
                                   $now->getDay()   + $dir * $this->day,
                                   $now->getYear()  + $dir * $this->year );
        $this->dbFormat = sprintf("%04d-%02d-%02d %02d:%02d:%02d", $this->year,$this->month,$this->day,$this->hour,$this->minute,$this->second);
        $this->dbFormat[0] = $this->dir==Date_Ago ? "8" : "9";
    }
    else parent::update();
}

function toDate()
{
    $this->update();  // hogy timestamp frissuljon
    return new Date($this->timestamp);
}

function fromString( $strDate )
{
    // ha relative date, pl: 9000-00-00 00:10
    if( preg_match( "/^(8|9)(\d{3})-(\d{2})-(\d{2}) ?(\d{0,2}):?(\d{0,2}):?(\d{0,2})/", $strDate, $matches ) )
    {
        $this->dir   = $matches[1]==8 ? Date_Ago : Date_FromNow;
        $this->year  = (int)$matches[2];
        $this->month = (int)$matches[3];
        $this->day   = (int)$matches[4];
        if( isset($matches[5]) )$this->hour   = (int)$matches[5];
        if( isset($matches[6]) )$this->minute = (int)$matches[6];
        if( isset($matches[7]) )$this->second = (int)$matches[7];
    }       
    else parent::fromString( $strDate );
}

// A mosthoz kepest eltolt idopontot adja vissza:
function getOffset()
{
    return new Date($this->timestamp);
}

function isRelative()
{
    return $this->dir;
}
function getDir()
{
    return $this->dir;
}
function setDir($v)
{
    $this->dir=$v;
    $this->update();
}

function setYear($v)
{
    $this->year=$v;
    $this->update();
}
function setMonth($v)
{
    $this->month=$v;
    $this->update();
}
function setDay($v)
{
    $this->day=$v;
    $this->update();
}
function setHour($v)
{
    $this->hour=$v;
    $this->update();
}
function setMinute($v)
{
    $this->minute=$v;
    $this->update();
}
function setSecond($v)
{
    $this->second=$v;
    $this->update();
}

// Display formatting related methods:
function format()
{
    global $lll;
    
    $readableVersion=array();
    if( $s=$this->year )
    {
        $readableVersion[]="$s $lll[years]";
    }
    if( $s=$this->month )
    {
        $readableVersion[]="$s $lll[months]";
    }
    if( $s=$this->day )
    {
        $readableVersion[]="$s $lll[days]";
    }
    if( $s=$this->hour )
    {
        $readableVersion[]="$s $lll[hours]";
    }
    if( $s=$this->minute )
    {
        $readableVersion[]="$s $lll[minutes]";
    }
    if( $s=$this->second )
    {
        $readableVersion[]="$s $lll[seconds]";
    }
    return implode(", ", $readableVersion).($this->dir==Date_Ago ? " $lll[ago]" : " $lll[fromNow]");
}

// Egy relative date alapjan eloallitja a DB query-be valo conditiont. Pl:
// NOW() - INTERVAL 1 YEAR - INTERVAL 2 MONTH
// FALSE-t ad vissza ha nem is relative date-rol van szo.
function getRelativeDateCondition()
{
    if( !$this->dir ) return FALSE;
    $condition="NOW()";
    if( $s=$this->year ) $condition.=" $this->dir INTERVAL $s YEAR";
    if( $s=$this->month ) $condition.=" $this->dir INTERVAL $s MONTH";
    if( $s=$this->day ) $condition.=" $this->dir INTERVAL $s DAY";
    if( $s=$this->hour ) $condition.=" $this->dir INTERVAL $s HOUR";
    if( $s=$this->minute ) $condition.=" $this->dir INTERVAL $s MINUTE";
    if( $s=$this->second ) $condition.=" $this->dir INTERVAL $s SECOND";
    return $condition;
}

}

?>