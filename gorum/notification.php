<?php
defined('_NOAH') or die('Restricted access');
// A notificationok applikacionkent fixek. Az installibben kell oket 
// letrehozni. A user nem hozhat letre ujat es nem torolhet ki egyet 
// sem, maximum modosithatja oket

global $notification_typ;
$notification_typ =  
    array(
        "attributes"=>array(   
            "id"=>array(
                "type"=>"INT",
                "form hidden",
            ),    
            "cc"=>array(
                "type"=>"VARCHAR",
                "max" =>"255",
                "text",
                "details",
            ),            
            "title"=>array(
                "type"=>"VARCHAR",
                "max" =>"120",
                "list",
                "details",
                "form readonly",
                "detailslink",
            ),
            "subject"=>array(
                "type"=>"VARCHAR",
                "max" =>"120",
                "min" =>"1",
                "text",
                "mandatory",
                "details",
                "safetext",
            ),
            "body"=>array(  
                "type"=>"TEXT",
                "textarea",
                "cols"=>50,
                "rows"=>5,
                "mandatory",
                "details",
                "safetext_br"
            ),    
            "active"=>array(
                "type"=>"INT",
                "bool",
                "default"=>"1",
                "list",
                "details",
                "yesno"
            ),    
            "langDependent"=>array(
                "type"=>"INT",
                "default"=>"1",
            )
        ),    
        "primary_key"=>"id",
        "sort_criteria_attr"=>"id",
        "sort_criteria_dir"=>"d"
    );

// Egy ilyen objektumban adjuk at a send fuggvenynek azokat a 
// parametereket, amik a kuldeshez szuksegesek:
class SendingParameters
{
    var $to; // ez az egy mandatory
    var $cc;
    var $replyTo;
    var $replyToName;
    
    function SendingParameters()
    {
        $this->to = $this->cc = $this->replyTo = $this->replyToName = "";
    }    
}

class Notification extends Object
{
    function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
    {
        global $lll, $gorumroll;
        hasAdminRights($isAdm);

        if (!$isAdm && ($gorumroll->method == "showdetails" || $gorumroll->method == "showhtmllist")) LocationHistory::rollBack(new AppController("/"));

        $hasRight->objectRight = ($isAdm && $method=="modify") || $method=="load";
        $hasRight->generalRight = TRUE;
        if( !$hasRight->objectRight && $giveError )
        {
            handleError($lll["permission_denied"]);
        }
        return ok;
    } 
     
    function showDetailsTool()
    {
        return "";
    }   
     
    // param vagy egy SendingParameters objektum, vagy a visszafele
    // kompatibilitas miatt egy string ami a cimzett emailcimet 
    // tartalmazza. Ha egy objektum, akkor magaban foglalja a kuldeshez
    // szukseges osszes parametert - vagyis a cimzetten kivul meg a 
    // 'reply to'-t, a 'cc'-t, stb.
    //
    // param utan meg valtozo szamu tovabbi argumentumot kaphat a 
    // fuggveny - ott jonnek a valtozok, amiket az email szovegbe be 
    // kell helyettesiteni.
    function send( $sp, $params )
    {
        global $htmlNotifications, $logNotifications, $ommitNotifications, $language;
        
        $_S = new AppSettings();
        $dumpParams = print_r($params, TRUE);
        foreach( $params as $key=>$value ) 
        {
            $$key=$value;
            ${"item:$key"}=$value;
            if( is_array($value) )
            {
                foreach( $value as $ownerKey=>$ownerValue )
                {
                    if( !isset($$ownerKey) ) $$ownerKey=$ownerValue;
                    ${"owner:$ownerKey"}=$ownerValue;
                }
            }
        }
        // a visszafele kompatibilitas miatt, arra az esetre, ha param
        // csak egy string:
        if( !is_object($sp) )
        {   
            $p = new SendingParameters;
            $p->to = $sp;
            $sp = $p;
        }
        
        $sp->cc = $this->cc;
        
        // Ha a bodyban csak egy html file nev van, akkor betoltjuk es
        // azt vesszuk template-nek:
        if( preg_match("/\.(html|php)$/i",$this->body, $matches) ) 
        {
            $extension = $matches[1];
            $_S = new AppSettings; 
            if( !$this->langDependent || $language==$_S->defaultLanguage || 
                !(file_exists($fileName = str_replace(".$extension", "_$language.$extension", $this->body))) )
            {
                $fileName = $this->body;
            }
        }
        else $extension="";
        if( $extension=="php" ) 
        {
            ob_start(); 
            include NOAH_BASE . "/$fileName";
            $mailText = ob_get_clean();
        }
        else
        {
            if( $extension=="html" ) $this->body=join('', file(NOAH_BASE . "/$fileName"));
            // Kulonben nem lehetne eval-ozni:
            $withoutQuote = addcslashes ($this->body, '"');  
            
            // behelyettesitjuk a valtozokat:
            eval ("\$mailText = \"$withoutQuote\";");
        }
        if( preg_match( "{<title>(.*)</title>}i", $mailText, $matches ) ) $this->subject = $matches[1];
        else
        {
            $withoutQuote = addcslashes ($this->subject, '"');  
            eval ("\$this->subject = \"$withoutQuote\";");
        }
        if( $sp->replyTo ) $replyTo = $sp->replyTo;
        else $replyTo = $_S->replytoEmail;
        if( $sp->replyToName ) $replyToName = $sp->replyToName;
        else $replyToName = $_S->replytoName;
        $from = $_S->adminEmail;
        $fromName = $_S->adminFromName;
        $retpath = $sp->replyTo ? $sp->replyTo : "";
        if( $logNotifications )
        {
            $f = fopen("mailtest.html", "a");
            fputs($f, "<font color='darkgreen'><i>Sending mail: <ul><li>to: $sp->to, <li>subject: $this->subject, <li>replyTo: ".htmlspecialchars($replyTo).", <li>from: ".htmlspecialchars($from).", <li>body:</ul></i></font><p><font color='blue'>$mailText</font></p><p><font color='green'><pre>$dumpParams</pre></font></p>");
            //fputs($f, "<font color='darkgreen'><i>Sending mail: <ul><li>to: $sp->to, <li>subject: $this->subject, <li>replyTo: ".htmlspecialchars($replyTo).", <li>from: ".htmlspecialchars($from)."</ul>");
        }
        if( $ommitNotifications ) $err=0;
        else $err = $this->gmail($error, $sp->to, $this->subject, $mailText, $fromName, 
                                 $htmlNotifications, $replyTo, $from, $this->cc, $replyToName);
        if( $_S->swiftLog )
        {
            $log =& Swift_LogContainer::getLog();
            $s = $log->dump(true);
            $logFile = LOG_DIR . "/swift_log.txt";
            if( $s && ($sf=fopen($logFile, "a"))!==FALSE ) 
            {
                fwrite($sf, $s);
                fclose($sf);
            }
        }            
        if( $logNotifications )
        {
            if( $err ) fputs($f, "<font color='red'><i>Error occured during sending the mail</i>: $error</font><br><br>");
            else fputs($f, "<font color='red'><i>Mail sent.</i></font><br><br>");
            fclose($f);
        }
        return $err;
    }
    
    function gmail(&$error, $to, $subject,$body, $fromName="",$html=0,$repto="",$from="", $cc="", $reptoName="")
    {
        global $errorReportingLevel;
        
        require_once GORUM_DIR . "/SwiftMailer/Swift.php";
        
        $_S = new AppSettings();
        error_reporting(0);
        $log =& Swift_LogContainer::getLog();
        $log->setLogLevel($_S->swiftLog);         
        Swift_Errors::expect($e, "Swift_Exception");
        if( $_S->smtpServer )
        {
            require_once GORUM_DIR . "/SwiftMailer/Swift/Connection/SMTP.php";
            if( $_S->fallBackNative )
            {
                require_once GORUM_DIR . "/SwiftMailer/Swift/Connection/NativeMail.php";
                require_once GORUM_DIR . "/SwiftMailer/Swift/Connection/Multi.php";
                $connections = array();
                $conn = new Swift_Connection_SMTP($_S->smtpServer);
                $conn->setUsername($_S->smtpUser);
                $conn->setPassword($_S->smtpPass);
                $conn->setPort($_S->smtpPort);
                $conn->setPort($_S->smtpPort);
                $conn->setEncryption($_S->smtpSecure);
                if( $e!==null ) 
                {
                    $error = $e->getMessage();
                    return;
                }
                $connections[] =& $conn;
                // Fall back to native mail:
                $connections[] = new Swift_Connection_NativeMail();
                if( $e!==null ) 
                {
                    $error = $e->getMessage();
                    return;
                }
                $swift = new Swift(new Swift_Connection_Multi($connections));
            }
            else
            {
                $connection = new Swift_Connection_SMTP($_S->smtpServer);
                $connection->setUsername($_S->smtpUser);
                $connection->setPassword($_S->smtpPass);
                $connection->setPort($_S->smtpPort);
                $connection->setEncryption($_S->smtpSecure);
                if( $e!==null ) 
                {
                    $error = $e->getMessage();
                    return;
                }
                $swift = new Swift($connection);
            }
        }
        else 
        {
            require_once GORUM_DIR . "/SwiftMailer/Swift/Connection/NativeMail.php";
            $swift = new Swift(new Swift_Connection_NativeMail());
        }
        error_reporting($errorReportingLevel);
        if( $e!==null ) 
        {
            $error = $e->getMessage();
            return;
        }
        else 
        {
            $error="";
            Swift_Errors::clear("Swift_Exception");
        }
         
        $subject  =  str_replace(array("&lt;", "&gt;"), array("<", ">"), $subject);
        
        $charset = "utf-8";
        $message = new Swift_Message($subject);
        $message->setCharset($charset);
        $part1 = new Swift_Message_Part($body, "text/html");
        $part1->setCharset($charset);
        $message->attach($part1);
        $part2 = new Swift_Message_Part(strip_tags($body));
        $part2->setCharset($charset);
        $message->attach($part2);
        if( $repto ) $message->setReplyTo(new Swift_Address($repto, $reptoName));
        
        error_reporting(0);
        Swift_Errors::expect($e, "Swift_Exception");
        $recipients = new Swift_RecipientList();
        $recipients->addTo($to);
        if( $this->cc ) $recipients->addCc($this->cc);
        $swift->send($message, $recipients, new Swift_Address($from, $fromName));
        if( $e!==null ) $error = $e->getMessage();
        else 
        {
            $error="";
            Swift_Errors::clear("Swift_Exception");
        }

        $swift->disconnect();
        error_reporting($errorReportingLevel);
    }

    function getNavBarPieces()
    {
        global $lll, $gorumroll;
        
        $navBarPieces = ControlPanel::getNavBarPieces(TRUE);
        $navBarPieces[$lll["Notifications"]] = $gorumroll->method=="showhtmllist" ? "" : new AppController("notification/list");
        return $navBarPieces;
    }
}
?>
