<?php
defined('_NOAH') or die('Restricted access');
$response_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "yourname"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250"
            ),
            "youremail"=>array(
                "type"=>"VARCHAR",
                "min"=>"1",
                "mandatory",
                "text",
                "max" =>"250"
            ),
            "carboncopy"=>array (
                "type"=>"INT",
                "bool",
                "default" =>"0"
            ),
            
            "mess"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>"40",
                "rows"=>"10"
            ),
            "captchaField"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("\$this->hasCaptchaInForm()"=>"text"),
                "max" =>"250",
                "length"=>10,
                "no column",
            ),
        ),
        "primary_key"=>"id"
    );
class Response extends Object
{
    
function hasCaptcha($postfix="")
{
    global $gorumroll;
    $_S = new AppSettings();
    if( $gorumroll->method=="create$postfix" && 
        in_array(Settings_response, explode(",", $_S->applyCaptcha))) return TRUE;
    return FALSE;
}
    
function createForm()
{
    global $gorumroll, $lll;
    
    if( strstr($gorumroll->list, "user") ) $lll["response_create_form"] = $lll["response_user_create_form"];
    parent::createForm();
}

function create()
{
    global $gorumroll, $webSiteUrl, $replyToAddress;

    $class = strstr($gorumroll->list, "user") ? "user" : "item";
    if( !isset($webSiteUrl) ) $webSiteUrl="";
    $this->valid();
    if( Roll::isFormInvalid() ) return;
    if( !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', $this->youremail) )
    {
        return Roll::setFormInvalid("invalidEmail");
    }
    executeQuery("UPDATE @$class SET responded=responded+1 WHERE id=#id#", $gorumroll->rollid);
    G::load($n, Notification_adReply, "notification");
    if( $n->active )
    {
        $obj = new $class;
        $obj->id = $gorumroll->rollid;
        $ownerEmail = $obj->getEmailParams($params);
        $params["message"] = $this->mess;
        $params["name"] = $this->yourname;
        $params["email"] = $this->youremail;
        $sp = new SendingParameters;
        $sp->to = $ownerEmail;
        $sp->replyTo = $this->youremail;
        $n->send( $sp, $params); // TODO:url
        if ($this->carboncopy==1)
        {
          $sp = new SendingParameters;
          $sp->to=$sp->from = $this->youremail;
          $sp->replyTo = $this->youremail;        
          $n->send( $sp, $params); // TODO:url
        }
    }
    //TODO: respnum increase
    Roll::setInfoText("mail_sent_$class");
}
}

//---------------------------------------------------------------------
//---------------------------------------------------------------------
//---------------------------------------------------------------------

$friendmail_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "yourname"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250"
            ),
            "youremail"=>array(
                "type"=>"VARCHAR",
                "min"=>"1",
                "mandatory",
                "text",
                "max" =>"250"
            ),
            /*
            "friendsname"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250"
            ),
            */
            "friendsemail"=>array(
                "type"=>"VARCHAR",
                "min"=>"1",
                "mandatory",
                "text",
                "max" =>"250"
            ),
            "mess"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>"40",
                "rows"=>"10"
            ),
            "captchaField"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("\$this->hasCaptchaInForm()"=>"text"),
                "max" =>"250",
                "length"=>10,
                "no column",
            ),
        ),
        "primary_key"=>"id"
    );
class Friendmail extends Object
{

function hasCaptcha($postfix="")
{
    global $gorumroll;
    $_S = new AppSettings();
    if( $gorumroll->method=="create$postfix" && 
        in_array(Settings_response, explode(",", $_S->applyCaptcha))) return TRUE;
    return FALSE;
}

function create()
{
    global $gorumroll;

    $class = strstr($gorumroll->list, "user") ? "user" : "item";
    $this->valid();
    if( Roll::isFormInvalid() ) return;
    if( !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', $this->youremail) ||
        !preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', $this->friendsemail) )
    {
        return Roll::setFormInvalid("invalidEmail");
    }
    G::load($n, Notification_adToAFriend, "notification");
    if( $n->active )
    {
        $obj = new $class;
        $obj->id = $gorumroll->rollid;
        $obj->getEmailParams($params);
        $params["message"] = $this->mess;
        $params["name"] = $this->yourname;
        $sp = new SendingParameters;
        $sp->to = $this->friendsemail;
        $sp->from = $this->youremail;
        $sp->replyTo = $this->youremail;
        $sp->replyToName = $this->yourname;
        $n->send( $sp, $params);
    }
    //TODO: respnum increase
    Roll::setInfoText("mail_fr_sent_$class");
}

}
?>