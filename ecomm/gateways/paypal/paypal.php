<?php

class Paypal extends Gateway 
{
    
/**************************************************************************************************/
// Functions used when creating a payment button:
/**************************************************************************************************/

function getPaymentButtonURL()
{    
    return "https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif";    
}

// The fields that will be passed over to the gateway when one clicks on the payment button
function getGatewayFieldsForSimpleIntegration($purchaseItem)
{
    $_ES = new ECommSettings();
    return array(
        'rm'=>            2,
        'cmd'=>           '_xclick',
        'business'=>      $_ES->getGatewayProperty("user", $this->getGatewayName()),
        'currency_code'=> $_ES->currency, 
        'item_name'=>     $purchaseItem->description,
        'amount'=>        $purchaseItem->price, 
        'item_number'=>   $purchaseItem->id, 
        'custom'=>        $this->getCustomerId(),
        'notify_url'=>    $this->getSilentPostUrl(),
        'return'=>        $this->getReturnUrl(),
        'cancel_return'=> $this->getCancelUrl()
    );
}

/**************************************************************************************************/
// Functions used to process the gateway response to the silent post URL:
/**************************************************************************************************/

// This function returns TRUE if the response data identifies PayPal as the source of the response:
function testResponseAgainstGateway()
{
    return isset($_POST["txn_id"]);
}

function getResponseCode()
{
    if( !isset($_POST["payment_status"]) ) return ECOMM_ERROR;
    switch( $_POST["payment_status"] )
    {
        case 'Completed': return ECOMM_COMPLETED;
        case 'Pending':   return ECOMM_PENDING;
        case 'Error':     return ECOMM_ERROR;
        case 'Denied':    return ECOMM_DENIED;
        default:          return ECOMM_ERROR;
    }
}

function getDataFromResponse(&$purchase)
{
    $purchase->transactionId = $_POST["txn_id"];
    $purchase->responseText = $_POST["payment_status"];
    // in case of Pro, we can't pass over the user id and the item id in two different fields 
    // (I simply haven't find an appropriate separate field that could be used for the item id! 
    //  There is no 'item_number' field in the Pro API, namely.) - 
    // so we must put both into the CUSTOM field comma separated:
    if( strstr($_POST["custom"], ",") )
    {
        list($purchase->uid, $purchase->pid) = explode(",", $_POST["custom"]);
    }
    else
    {
        $purchase->pid = $_POST["item_number"];
        $purchase->uid = $_POST["custom"];
    }
    $purchase->firstName = @$_POST["first_name"];
    $purchase->lastName = @$_POST["last_name"];
    $purchase->address = @$_POST["address_street"];
    $purchase->city = @$_POST["address_city"];
    $purchase->state = @$_POST["address_state"];
    $purchase->zip = @$_POST["address_zip"];
    $purchase->country = @$_POST["address_country_code"];
    $purchase->email = @$_POST["payer_email"];
    $purchase->price = $_POST["mc_gross"];
}

function validateSilentPostResponse(&$purchase)
{
    global $lll;
    
    $_ES = new ECommSettings();  
    $url = $_ES->getResponseValidationHost($this->getGatewayName());
    // we must return exactly the same fields we got in the IPN, plus the 'cmd' - 
    // so let's extend the $_POST variable before sending back:
    $_POST['cmd']='_notify-validate';
    if( !($response = $this->sendPostRequest($_POST, $url)) ) return FALSE;
    elseif( !eregi("VERIFIED", $response) )
    {
        return $purchase->setError($lll["ipnValidationFailed"]." ".$response);
    }
    
    // checking if the receiver_email equals to the PayPal user:
    $user = $_ES->getGatewayProperty("user", $this->getGatewayName());
    if( $_POST["receiver_email"]!=$user )
    {
        return $purchase->setError(sprintf($lll["wrongReceiverEmail"], "$_POST[receiver_email] <--> $user"));
    }    
    return TRUE;
}

/**************************************************************************************************/
// Functions used to process the Website Payments Pro:
/**************************************************************************************************/

// The fields that will be passed over to the gateway when one submits the purchase form
function getGatewayFieldsForAdvancedIntegration($purchaseItem)
{
    $_ES = new ECommSettings();
    return array(
        'METHOD'         => 'doDirectPayment',
        'PAYMENTACTION'  => 'Sale',
        'VERSION'        => '57.0',
        'IPADDRESS'      => $_SERVER["REMOTE_ADDR"],
        'CURRENCYCODE'   => $_ES->currency, 
        'NOTIFYURL'      => $this->getSilentPostUrl(),
        
        // API credentials:
        'USER'           => $_ES->getGatewayProperty("apiUser", $this->getGatewayName()),
        'PWD'            => $_ES->getGatewayProperty("apiPassword", $this->getGatewayName()),
        'SIGNATURE'      => $_ES->getGatewayProperty("apiSignature", $this->getGatewayName()),

        // purchase item:
        'DESC'           => $purchaseItem->description,
        'AMT'            => $purchaseItem->price,
        
        // Credit card details:      /* @ is placed before the optional fields, so that they don't generate Php notices if they are missing */
        'CREDITCARDTYPE' => $purchaseItem->cardType,
        'ACCT'           => $purchaseItem->cardNumber,
        'EXPDATE'        => $purchaseItem->expMonth . $purchaseItem->expYear,  // e.g. 052011
        'CVV2'           => @$purchaseItem->cardCode,
        'STARTDATE'      => @$purchaseItem->startDate,
        'ISSUENUMBER'    => @$purchaseItem->issueNumber,
        
        // user fields:
        'CUSTOM'         => $this->getCustomerId() . "," . $purchaseItem->id,  // pass the user id and the id of the purchase item in the CUSTOM field
        'FIRSTNAME'      => @$purchaseItem->firstName,
        'LASTNAME'       => @$purchaseItem->lastName,
        'STREET'         => $purchaseItem->address,
        'CITY'           => $purchaseItem->city,
        'STATE'          => $this->getStateCodeFromStateName($purchaseItem->state),
        'ZIP'            => $purchaseItem->zip,
        'COUNTRYCODE'    => $purchaseItem->countryCode,
        'PHONENUM'       => @$purchaseItem->phone,
        'EMAIL'          => @$purchaseItem->email
    );
}

/**************************************************************************************************/
// Functions used to process the instant gateway response in case of an advanced integration:
/**************************************************************************************************/

// To make an associative array of kay=>value pairs from the URL-encoded response string:
function decodeInstantResponse($response)
{
    $intial=0;
    $nvpArray = array();
    while(strlen($response))
    {
        $keypos= strpos($response,'='); 
        $valuepos = strpos($response,'&') ? strpos($response,'&'): strlen($response); 
        $keyval=substr($response,$intial,$keypos);
        $valval=substr($response,$keypos+1,$valuepos-$keypos-1);
        $nvpArray[urldecode($keyval)] =urldecode( $valval);
        $response=substr($response,$valuepos+1,strlen($response));
     }
    return $nvpArray;
}

// See the following for more details about these three methods:
// Table 6. here: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_NVPAPIOverview#id086962080BI

// Returns TRUE if the transaction has a "completed" status:
function isResponseSuccessfull($response)
{
    return $response["ACK"]=="Success" || $response["ACK"]=="SuccessWithWarning";
}

function getErrorCode($response)
{
    // actually, there can be more errors listed in the response (L_ERRORCODE0, L_ERRORCODE1, etc.),
    // but we always only deal with the first one.
    return $response["L_ERRORCODE0"];
}

function getErrorText($response)
{
    return $response["L_SHORTMESSAGE0"]." ".$response["L_LONGMESSAGE0"];
}

}

?>
