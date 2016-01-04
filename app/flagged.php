<?php
defined('_NOAH') or die('Restricted access');
$flagged_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "flagged_mess"=>array(
                "type"=>"VARCHAR",
                "text",
                "max" =>"250"
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
class Flagged extends Object
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

    $_S = new AppSettings();
    $this->valid();
    if( Roll::isFormInvalid() ) return;

    G::load($n, Notification_adFlagged, "notification");
  
    if( $n->active )
    {
    	$item = new Item;
        $item->id = $gorumroll->rollid;
        $item->getEmailParams($params);
        $params["message"] = $this->flagged_mess;
        $sp = new SendingParameters;

        $sp->to = $_S->adminEmail;
        $sp->from = $_S->adminEmail;
        $n->send( $sp, $params);
    }
    //TODO: flagnum increase
    Roll::setInfoText("ad_was_flagged");
}


}
?>
