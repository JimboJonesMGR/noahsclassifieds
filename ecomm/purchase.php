<?php
defined('_NOAH') or die('Restricted access');
$purchase_typ=
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden"
            ),
            "transactionDetails"=>array(
                "type"=>"INT",
                "no column",
                "section",
                "form invisible",
                //"details",
            ),
            "paymentMethod"=>array(
                "type"=>"VARCHAR",
                "max"=>"20",
                "list",
                "details",
                "enum"
            ),
            "transactionId"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "list",
                "details",
                "safetext",
            ),
            "responseCode"=>array(
                "type"=>"INT",
                "list",
                "details",
                "enum"
            ),
            "responseText"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "details",
                "safetext"
            ),
            "creationtime"=>array(
                "type"=>"DATETIME",
                "prototype"=>"date",
                "details",
                "list",
                "sorta",
                "default_format",
            ),            
            "itemProperties"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "details",
            ),
            "pid"=>array(  // ID of the purchase item
                "type"=>"INT",
                "form hidden"
            ),            
            "uid"=>array(  
                "type"=>"INT",
                "conditions"=>array("\$isAdm"=>"details"),
            ),            
            "userName"=>array(
                "type"=>"INT",
                "no column",
                "link_to"=>array("class"=>"user", "id"=>"uid", "other_attr"=>"name"),
                "conditions"=>array("\$isAdm && !\$gorumroll->rollid"=>"list"),
            ),
            "description"=>array(
                "type"=>"TEXT",
                "readonly",
                "safetext",
                "list",
                "details",
                "in new line",
            ),
            "price"=>array(
                "type"=>"FLOAT",
                "readonly",
                "list",
                "sorta",
                "details",
            ),
            "notes"=>array(
                "type"=>"TEXT",
                "textarea",
                "cols"=>50,
                "rows"=>5,
                "details",
                "safetext_br",
            ),
            "customerDetails"=>array(
                "type"=>"INT",
                "section",
                "no column",
                "details",
            ),
            "firstName"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "lastName"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "address"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "city"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "state"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "zip"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "country"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "phone"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "fax"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "email"=>array(
                "type"=>"VARCHAR",
                "max"=>255,
                "text",
                "safetext",
            ),
            "countryCode"=>array(
                "type"=>"VARCHAR",
                "mandatory",                
                "selection",
                "mandatory",
                "default"=>"US",
                "values"=>array("AF","AX","AL","DZ","AS","AD","AO","AI","AQ","AG","AR","AM","AW","AU",
                                "AT","AZ","BS","BH","BD","BB","BY","BE","BZ","BJ","BM","BT","BO","BA",
                                "BW","BV","BR","IO","BN","BG","BF","BI","KH","CM","CA","CV","KY","CF",
                                "TD","CL","CN","CX","CC","CO","KM","CG","CD","CK","CR","CI","HR","CU",
                                "CY","CZ","DK","DJ","DM","DO","EC","EG","SV","GQ","ER","EE","ET","FK",
                                "FO","FJ","FI","FR","GF","PF","TF","GA","GM","GE","DE","GH","GI","GR",
                                "GL","GD","GP","GU","GT","GG","GN","GW","GY","HT","HM","VA","HN","HK",
                                "HU","IS","IN","ID","IR","IQ","IE","IM","IL","IT","JM","JP","JE","JO",
                                "KZ","KE","KI","KP","KR","KW","KG","LA","LV","LB","LS","LR","LY","LI",
                                "LT","LU","MO","MK","MG","MW","MY","MV","ML","MT","MH","MQ","MR","MU",
                                "YT","MX","FM","MD","MC","MN","MS","MA","MZ","MM","NA","NR","NP","NL",
                                "AN","NC","NZ","NI","NE","NG","NU","NF","MP","NO","OM","PK","PW","PS",
                                "PA","PG","PY","PE","PH","PN","PL","PT","PR","QA","RE","RO","RU","RW",
                                "SH","KN","LC","PM","VC","WS","SM","ST","SA","SN","CS","SC","SL","SG",
                                "SK","SI","SB","SO","ZA","GS","ES","LK","SD","SR","SJ","SZ","SE","CH",
                                "SY","TW","TJ","TZ","TH","TL","TG","TK","TO","TT","TN","TR","TM","TC",
                                "TV","UG","UA","AE","GB","US","UM","UY","UZ","VU","VE","VN","VG","VI",
                                "WF","EH","YE","ZM","ZW"),
                "no column",
            ),
            "cardDetails"=>array(
                "type"=>"INT",
                "section",
                "no column",
            ),
            "cardName"=>array(
                "type"=>"VARCHAR",
                "text",
                "mandatory",
                "min"=>1,
                "no column",
            ),
            "cardType"=>array(
                "type"=>"VARCHAR",
                "selection",
                "mandatory",
                "values"=>array(),  // will be defined per gateway
                "no column",
            ),
            "cardNumber"=>array(
                "type"=>"VARCHAR",
                "text",
                "mandatory",
                "min"=>1,
                "no column",
            ),
            "cardExp"=>array(
                "type"=>"VARCHAR",
                "text",
                "mandatory",
                "min"=>1,
                "no column",
            ),
            "cardCode"=>array(
                "type"=>"VARCHAR",
                "text",
                "mandatory",
                "no column",
            ),
            "rawResponse"=>array(
                "type"=>"TEXT",
                "htmltext",
                "conditions"=>array("\$isAdm"=>"details"),
                "widecontent_details"
            ),
        ),
        "primary_key"=>"id",
        "delete_confirm"=>"description",
        "sort_criteria_sql"=>"creationtime DESC",
    );

class Purchase extends Object
{
    
function hasObjectRights(&$hasRight, $method, $giveError=FALSE)
{
    global $lll, $gorumroll, $gorumuser;

    hasAdminRights($isAdm);
    $hasRight->generalRight = TRUE;
    if( $method=="create" || $isAdm ||
        ($method=="load" && isset($this->uid) && $this->uid==$gorumuser->id) )
    {
        $hasRight->objectRight=TRUE;
    }
    if( !$hasRight->objectRight && $giveError ) {
        handleError($lll["permission_denied"]);
    }
}
    
function createForm()
{
    global $gorumroll, $gorumuser, $purchase_typ, $ecommAssignmentToFieldMapping, $lll, $gorumrecognised;
    
    if( !$gorumrecognised )  LocationHistory::rollBack(new AppController("/"));     
    
    $_ES = new ECommSettings();
    $this->pid = $gorumroll->rollid;
    $this->paymentMethod = str_replace("purchase_", "", $gorumroll->list);  // e.g. $gorumroll->list='purchase_authorize_net'
    
    if (!G::load( $items, "SELECT * FROM @purchaseitem WHERE id={$this->pid} and uid={$gorumuser->id}" ))
    {
        return Roll::setFormInvalid("Invalid purchase item.");
    }
    $item =& $items[0];

    $this->description = $item->description;
    $this->price = $item->price;
    $gorumuser->copyPurchaseFormFields($this);
    $fieldsToDisplay = explode(",", $_ES->purchaseFormFields);
    $purchase_typ["order"]=array();
    foreach( $fieldsToDisplay as $field ) $purchase_typ["order"][]=$ecommAssignmentToFieldMapping[$field];
    $ccFields = "creditCardDetailsFields_$this->paymentMethod";
    global $$ccFields;
    if( !isset($$ccFields) ) $ccFields = array("cardDetails", "cardNumber", "cardExp");  // default
    foreach( $$ccFields as $field )
    {
        $purchase_typ["order"][]=$field;
    }
    if( $_ES->getGatewayProperty("cvv2", $this->paymentMethod) ) $purchase_typ["order"][]="cardCode";
    if( in_array("cardType", $$ccFields) )
    {
        $ccTypes = "cardTypes_$this->paymentMethod";
        global $$ccTypes;
        foreach( $$ccTypes as $type )
        {
            $purchase_typ["attributes"]["cardType"]["values"][]=$type;
            $lll["cardType_$type"]=$type;
        }
    }
    if( $_ES->getGatewayProperty("environment", $this->paymentMethod)==ecomm_test || $_ES->getGatewayProperty("test", $this->paymentMethod) )
    {
        JavaScript::addInclude(JS_DIR."/generate_test_cc_number.js");
    }
    if( in_array("countryCode", $$ccFields) )        
    {
        global $language;
        if( file_exists(ECOMM_DIR . "/" . LANG_DIR . "/lang_countrycodes_$language.php") )
        {
            include(ECOMM_DIR . "/" . LANG_DIR . "/lang_countrycodes_$language.php");
        }
        else include(ECOMM_DIR . "/" . LANG_DIR . "/lang_countrycodes_en.php");
    }
    parent::createForm();
}

function create()
{
    global $gorumroll, $gorumuser;
    
    
    $_ES = new ECommSettings();
    ini_set("max_execution_time", 0);
    $this->id = $gorumroll->rollid;  // purchase item id!
    $this->uid = $gorumuser->id;
    $this->paymentMethod = str_replace("purchase_", "", $gorumroll->list);  // e.g. $gorumroll->list='purchase_authorize_net'
    
    if( !$this->validatePurchaseAndGetItem($item) ) return FALSE;

    $this->price = sprintf( "%01.2f", floatval($item->price));
    $this->description = $item->description;
    
    $this->cardNumber = preg_replace("/\D/", "", $this->cardNumber );  // stripping any non-decimal
    $cardExpParts = explode("/", $this->cardExp);
    $this->expMonth = substr('0'.$cardExpParts[0],-2);
    $this->expYear  = '20'.substr($cardExpParts[1],-2);

    $gateway = new $this->paymentMethod;
    if( $gateway->getInstantPaymentResponse( $this ) ) Roll::setInfoText("successfullPayment");
}

function validatePurchaseAndGetItem( &$item )
{
    global $lll, $gorumroll;
    
    $_ES = new ECommSettings();
    if( !$_ES->getGatewayProperty("enabled", $this->paymentMethod ) ) return Roll::setFormInvalid("Invalid payment method.");
    if( G::load( $item, $this->id, "purchaseitem" ) ) return Roll::setFormInvalid("Invalid purchase item.");
    if( $_ES->getGatewayProperty("integrationMethod", $this->paymentMethod)==ecomm_advancedIntegration )
    {
        $ccFields = "creditCardDetailsFields_$this->paymentMethod";
        global $$ccFields;
        if( !isset($$ccFields) ) $ccFields = array("cardDetails", "cardNumber", "cardExp");  // default
        $mandatoryFields = array("cardName", "cardNumber", "cardExp");
        foreach( $mandatoryFields as $attr )
        {
            if( in_array($attr, $$ccFields) && empty($this->$attr) ) return Roll::setFormInvalid("mandatoryField", $lll["purchase_$attr"]);
        }
        if( $_ES->getGatewayProperty("cvv2", $this->paymentMethod) && empty($this->cardCode) )
        {
            return Roll::setFormInvalid("mandatoryField", $lll["purchase_cardCode"]);
        }
        if( in_array("cardNumber", $$ccFields) && preg_match("/[^ -\d]/", $this->cardNumber ) ) return Roll::setFormInvalid("invalidCardNumber");
        if( in_array("cardExp", $$ccFields) && !preg_match("{\d{2}/\d{2}}", $this->cardExp, $cardExpParts) )
        {
            return Roll::setFormInvalid("invalidExpirationFormatting");
        }
    }
    return TRUE;
}

function silentPost()
{
    $success = Gateway::processResponse($this, $item);
    create($this);
    if( $success ) $this->applyPurchaseItem($item);
    die();
}

function relayResponse()
{
    global $lll;
    
    $this->responseCode = $_POST["x_response_code"];
    $this->pid = $_POST["pid"];
    $it = $lll["purchase_responseMessage_$this->responseCode"];
    switch( $this->responseCode )
    {
        case 1:
            G::load( $item, $this->pid, "purchaseitem" ); 
            if( $item->type==ecomm_credit ) $it.=sprintf($lll["purchase_creditAdded"], $item->amount);
            elseif( $item->type==ecomm_subscription ) $it.=sprintf($lll["purchase_subscriptionAdded"], $item->amount, $lll["purchaseitem_unit_".$item->unit]);
            else $it.=$lll["purchase_adActivated"];
            Roll::setInfoText($it);
            break;    
        default:
            Roll::setInfoText("purchase_responseMessage_$this->responseCode");
    }
}

function applyPurchaseItem($purchaseItem)
{
    global $subAmountToDays, $now;
    
    if( $purchaseItem->type==ecomm_subscription )
    {
        G::load( $user, $this->uid, "ecommuser" );
        if( $user->expirationTime->isEmpty() ) $user->expirationTime = $now;
        $user->expirationTime = $user->expirationTime->add($purchaseItem->amount * $subAmountToDays[$purchaseItem->unit], Date_Day);
        modify($user);
    }
    elseif( $purchaseItem->type==ecomm_credit ) 
    {
        G::load( $user, $this->uid, "ecommuser" );
        $user->credits += $purchaseItem->amount;
        modify($user);
    }
    else  // ecomm_pending
    {
        if( !G::load( $item, $purchaseItem->iid, "item" ) )
        {
            $item->changeStatus(TRUE);  // aktivaljuk
        }
        delete($purchaseItem);
    }
}

function showHtmlList($elementName="")
{
    global $gorumuser, $gorumrecognised;
    
    hasAdminRights($isAdm);
    if( isset($_POST["x_response_code"]) ) $this->relayResponse();
    if( !$isAdm && $gorumrecognised ) $this->uid = $gorumuser->id;
    parent::showHtmlList();
}

function showListVal($attr)
{
    $_ES = new ECommSettings();
    $s=FALSE;
    if( ($s=parent::showListVal($attr))!==FALSE )
    {
        return $s;
    }
    elseif ($attr=="price") 
    {
        $s = $_ES->formatPrice($this->$attr);
    }
    return $s;
}

function showNewTool()
{
    return "";
}

function getListSelect()
{
    global $gorumroll, $gorumuser, $gorumrecognised;

    hasAdminRights($isAdm);
    
    if( !$gorumrecognised ) LocationHistory::rollBack(new AppController("/"));

    if( $isAdm && $gorumroll->rollid ) $query="SELECT * FROM @purchase WHERE uid=#rollid#";
    elseif( $isAdm && !$gorumroll->rollid ) $query="SELECT p.*, u.name AS userName FROM @purchase AS p, @user AS u WHERE u.id=p.uid";
    elseif( !$isAdm ) $query="SELECT * FROM @purchase WHERE uid='$gorumuser->id'";
    return array($query, $gorumroll->rollid);
} 

function showDetails($whereFields="", $withLoad=TRUE, $elementName="")
{
    global $purchase_typ, $ecommAssignmentToFieldMapping, $gorumroll;
    
    $this->id = $gorumroll->rollid;
    $ret=$this->load();
    if ($ret==not_found_in_db) return Roll::setInfoText("not_found_deleted");
    $this->hasObjectRights($hasRight, "load", TRUE);
    $_ES = new ECommSettings();
    $fieldsToDisplay = explode(",", $_ES->purchaseFormFields);
    foreach( $fieldsToDisplay as $field ) $purchase_typ["attributes"][$ecommAssignmentToFieldMapping[$field]][]="details";
    parent::showDetails($whereFields, FALSE, $elementName);
}

function getNavBarPieces()
{
    global $lll, $gorumroll;
    
    $navBarPieces = array($lll["home"] => new AppController("/"));
    $navBarPieces[$lll["purchase_ttitle"]] = $gorumroll->method=="showhtmllist" ? "" : new AppController("purchase/list");
    return $navBarPieces;
}

function setError($errorText)
{
    $this->responseCode=ECOMM_ERROR;
    $this->responseText=$errorText;
    return FALSE;
}

}

?>
