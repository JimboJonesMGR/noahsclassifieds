<?php

class Authorize_net extends Gateway 
{

/**************************************************************************************************/
// Functions used when creating a payment button:
/**************************************************************************************************/

function getPaymentButtonURL()
{    
    return ECOMM_DIR."/images/authorize_net.gif";    
}

// The fields that will be passed over to the gateway when one clicks on the payment button
function getGatewayFieldsForSimpleIntegration($purchaseItem )
{   
    $_ES = new ECommSettings();
    $tstamp = time();
    srand($tstamp);
    $sequence = rand(1, 1000);    
    return array(
        'x_login'            => $_ES->getGatewayProperty("user", $this->getGatewayName()),
        'x_test_request'	  => $_ES->getGatewayProperty("test", $this->getGatewayName()),
        'x_currency'         => $_ES->currency,
        'x_version'          => '3.1',  // current API version
        'x_duplicate_window' => 0,  // disabling the check for duplicate transactions
        'x_customer_ip'      => $_SERVER["REMOTE_ADDR"],  // This field is required when using the Fraud Detection Suite (FDS) IP Address Blocking tool.
        'x_type'             => 'AUTH_CAPTURE',
        'x_show_form'        => 'PAYMENT_FORM',
        'x_method'           => 'CC',
        'x_delim_data'       => TRUE,
        'x_delim_char'       => ',',
        
        // purchase item:
        'pid'                => $purchaseItem->id, 
        'x_description'      => $purchaseItem->description,
        'x_amount'           => $purchaseItem->price,
        
        // user fields:         /* @ is placed before the optional fields, so that they don't generate Php notices if they are missing */
        'x_cust_id'          => $this->getCustomerId(), 
        'x_first_name'       => @$purchaseItem->firstName,
        'x_last_name'        => @$purchaseItem->lastName,
        'x_address'          => @$purchaseItem->address,
        'x_city'             => @$purchaseItem->city,
        'x_state'            => @$purchaseItem->state,
        'x_zip'              => @$purchaseItem->zip,
        'x_country'          => @$purchaseItem->country,
        'x_phone'            => @$purchaseItem->phone,
        'x_fax'              => @$purchaseItem->fax,
        'x_email'            => @$purchaseItem->email,
        
        // dataflow verification fields:
        'x_fp_timestamp'     => $tstamp,
        'x_fp_sequence'      => $sequence,
        'x_fp_hash'          => $this->getFingerPrint($sequence, $tstamp, $purchaseItem->price)
    );
}

function getFingerPrint($sequence, $tstamp, $price)
{
    $_ES = new ECommSettings();
    $key = $_ES->getGatewayProperty("key", $this->getGatewayName());
    $data = $_ES->getGatewayProperty("user", $this->getGatewayName()) . "^" . 
            $sequence . "^" . $tstamp . "^" . 
            $price . "^";
    if (function_exists('mhash') && defined('MHASH_MD5')) return bin2hex(mhash(MHASH_MD5, $data, $key));
    else
    {
        $b = 64; // byte length for md5
        if (strlen($key) > $b) $key = pack("H*",md5($key));
        $key  = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad ;
        $k_opad = $key ^ $opad;
        return md5($k_opad  . pack("H*",md5($k_ipad . $data)));
    }
}

/**************************************************************************************************/
// Functions used to process the gateway response to the silent post URL:
/**************************************************************************************************/

// This function returns TRUE if the response data identifies Authorize.NET as the source of the response:
function testResponseAgainstGateway()
{
    return isset($_POST["x_response_code"]);
}

function getResponseCode()
{
    if( !isset($_POST["x_response_code"]) ) return ECOMM_ERROR;
    return $_POST["x_response_code"];
}

function getDataFromResponse(&$purchase)
{
    $purchase->transactionId = $_POST["x_trans_id"];
    $purchase->responseText  = $_POST["x_response_reason_text"];
    $purchase->pid           = $_POST["pid"];
    $purchase->uid           = $_POST["x_cust_id"];
    $purchase->notes         = @$_POST["notes"];
    $purchase->firstName     = @$_POST["x_first_name"];
    $purchase->lastName      = @$_POST["x_last_name"];
    $purchase->address       = @$_POST["x_address"];
    $purchase->city          = @$_POST["x_city"];
    $purchase->state         = @$_POST["x_state"];
    $purchase->zip           = @$_POST["x_zip"];
    $purchase->country       = @$_POST["x_country"];
    $purchase->phone         = @$_POST["x_phone"];
    $purchase->fax           = @$_POST["x_fax"];
    $purchase->email         = @$_POST["x_email"];
    $purchase->price         = $_POST["x_amount"];
}

function validateSilentPostResponse(&$purchase)
{
    global $lll;
    
    $_ES = new ECommSettings();
    $hash = $_ES->getGatewayProperty("md5Hash", $this->getGatewayName());
    $loginId = $_ES->getGatewayProperty("user", $this->getGatewayName());
    $price = sprintf( "%01.2f", floatval($purchase->price));
    if( $hash && ($_POST['x_MD5_Hash'] != ($myHash=strtoupper(md5($hash . $loginId . $_POST['x_trans_id'] . $price))))) 
    {        
        return $purchase->setError($lll["securityCodeMismatch"]);
    }
    return TRUE;
}    

/**************************************************************************************************/
// Functions used to process the AIM:
/**************************************************************************************************/

// The fields that will be passed over to the gateway when one submits the purchase form
function getGatewayFieldsForAdvancedIntegration($purchaseItem )
{   
    $_ES = new ECommSettings();
    
    return array(
        'x_login'            => $_ES->getGatewayProperty("user", $this->getGatewayName()),
        'x_tran_key'         => $_ES->getGatewayProperty("key", $this->getGatewayName()),
        'x_test_request'	  => $_ES->getGatewayProperty("test", $this->getGatewayName()),
        'x_currency'         => $_ES->currency,
        'x_version'          => '3.1',  // current API version
        'x_duplicate_window' => 0,  // disabling the check for duplicate transactions
        'x_customer_ip'      => $_SERVER["REMOTE_ADDR"],  // This field is required when using the Fraud Detection Suite (FDS) IP Address Blocking tool.
        'x_type'             => 'AUTH_CAPTURE',
        'x_method'           => 'CC',
        'x_delim_data'       => TRUE,
        'x_delim_char'       => ',',
        'x_encap_char'       => '"',
        
        // purchase item:
        'pid'                => $purchaseItem->id, 
        'x_description'      => $purchaseItem->description,
        'x_amount'           => $purchaseItem->price,
        
        // user fields:         /* @ is placed before the optional fields, so that they don't generate Php notices if they are missing */
        'x_cust_id'          => $this->getCustomerId(), 
        'x_first_name'       => @$purchaseItem->firstName,
        'x_last_name'        => @$purchaseItem->lastName,
        'x_address'          => @$purchaseItem->address,
        'x_city'             => @$purchaseItem->city,
        'x_state'            => @$purchaseItem->state,
        'x_zip'              => @$purchaseItem->zip,
        'x_country'          => @$purchaseItem->country,
        'x_phone'            => @$purchaseItem->phone,
        'x_fax'              => @$purchaseItem->fax,
        'x_email'            => @$purchaseItem->email,
        
        // Credit card details:
        'x_card_num'         => $purchaseItem->cardNumber,
        'x_exp_date'         => $purchaseItem->expMonth . $purchaseItem->expYear,  // e.g. 052011
        'x_card_code'        => $purchaseItem->cardCode,
    );
}

/**************************************************************************************************/
// Functions used to process the instant gateway response in case of an advanced integration:
/**************************************************************************************************/

// http://developer.authorize.net/guides/AIM/Transaction_Response/Transaction_Response.htm
function decodeInstantResponse($response)
{
    if( $response[0]=='"' && $response[strlen($response)-1]=='"' )
    {
        // $response is a string like this: "something","anything","something else",...
        return explode('","',substr($response,1,-1));	//explode the answer excluding the first and last char
                                                      //there will be an array with at least 69 fields
    }
    else  // e.g. <HTML><BODY><H3>The following errors have occurred.</H3>(13) The merchant login ID or password is invalid or the account is inactive.<BR></BODY></HTML>
    {
        $decoded = array();
        $decoded[0]=ECOMM_ERROR;
        $decoded[3]=strip_tags($response);
        if( preg_match('/\((\d+)\)/', $decoded[3], $matches) ) $decoded[2]=$matches[1];
        else $decoded[2]=0;
        return $decoded;
    }
}

// See the following for more details about these three methods:
// http://developer.authorize.net/guides/AIM/Transaction_Response/Fields_in_the_Payment_Gateway_Response.htm

// Returns TRUE if the transaction has a "completed" status:
function isResponseSuccessfull($response)
{
    return $response[0]==1;
}

function getErrorCode($response)
{
    return $response[2];
}

function getErrorText($response)
{
    return $response[3];
}

}

?>
