<?php
defined('_NOAH') or die('Restricted access');
class Stopwatch
{
    function Stopwatch()
    {
        $this->starts=0;
        $this->startms=0;
        $this->stops=0;
        $this->stopms=0;
    }
    function start()
    {
        list($this->startms,$this->starts) =  
            explode(" ",microtime());
        $this->spidx=0;
    }
    function stop()
    {
        list($this->stopms,$this->stops) =  
            explode(" ",microtime());
    }
    function elapsed()
    {
        global $elTime;
        $s="";
        if ($this->startms<$this->stopms) {
            $sec=$this->stops-$this->starts;
            $msec=$this->stopms-$this->startms;
        }
        else {
            $sec=$this->stops-$this->starts-1;
            $msec=$this->stopms+1-$this->startms;
        }
        $msec=substr($msec,1,strlen($msec)-1);
        for($i=1;isset($this->splits[$i]);$i++) {
            $s.="Split time between split ".(int)($i-1)." ".
                $this->splitLabel[$i-1].
                " and  split ".(int)$i." ".
                $this->splitLabel[$i].
                " : ".$this->spspsec[$i].$this->pspspmsec[$i]."<BR>\n";
        }
        for($i=0;isset($this->splits[$i]);$i++) {
            $s.="Split time from start $i ".$this->splitLabel[$i].
                " : ".$this->spstsec[$i].$this->pspstmsec[$i]."<BR>\n";
        }
        $avg=0;
        $num=0;
        for($i=1;isset($this->splits[$i]);$i++) {
            $num++;
            $avg+=$this->pspspmsec[$i];
        }
        if ($num>0) {
            $avg=(float)$avg/$num;
            $s.="Average : $avg<BR>\n";
        }
        $elTime=$sec.$msec;
        $s.="$sec$msec";
        return $s;
    }
}
?>
