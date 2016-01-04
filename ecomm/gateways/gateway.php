<?php

class Gateway
{
    
// returns "authorize_net", "paypal", etc.    
function getGatewayName()
{
    return strtolower(get_class($this));
}

// Reads all the sub directories under the 'ecomm/gateways' directory.
// They will specify the list of available gateways for the program.
// Returns an array - e.g.: array("authorize_net", "paypal")
function getGateways()
{
    static $gateways = 0;
    if( $gateways ) return $gateways;
    $gateways = array();
    if( ($gatewayDir = opendir(ECOMM_DIR . "/gateways"))===FALSE ) Roll::setInfoText("Failed to load the payment gateways! The program has no read permission under the 'ecomm/gateways' folder. Please, fix this!");
    else
    {
        while( ($dir = readdir($gatewayDir)) !== false) 
        {
            if( !preg_match("/^\./", $dir) && is_dir(ECOMM_DIR . "/gateways/$dir") ) $gateways[] = $dir;
        }
        closedir($gatewayDir);
    }
    return $gateways;
}

// Includes the gateway specific language files.
function includeLanguageFiles()
{
    global $language;

    foreach( Gateway::getGateways() as $gateway )
    {
        $fileName = ECOMM_DIR . "/gateways/$gateway/lang/lang_$language.php";
        if( file_exists($fileName) ) include($fileName);
        else include(ECOMM_DIR . "/gateways/$gateway/lang/lang_en.php"); // defaults to English
        $fileName = ECOMM_DIR . "/gateways/$gateway/lang/lang_admin_$language.php";
        if( file_exists($fileName) ) include($fileName);
        else include(ECOMM_DIR . "/gateways/$gateway/lang/lang_admin_en.php"); // defaults to English
    }
}

/**************************************************************************************************/
// Functions used to create a payment button:
/**************************************************************************************************/
function getPurchaseButton($purchaseItem)
{
    global $gorumuser;
    
    $_ES = new ECommSettings();
    hasAdminRights($isAdm);
    $img = $this->getPaymentButtonURL();
    $gateway = $this->getGatewayName();
    if( $_ES->getGatewayProperty("integrationMethod", $gateway)==ecomm_simpleIntegration && !$isAdm )
    {
        $gorumuser->copyPurchaseFormFields($purchaseItem, TRUE);
        $purchaseItem->price = sprintf( "%01.2f", floatval($purchaseItem->price));
        $gatewayFields = $this->getGatewayFieldsForSimpleIntegration($purchaseItem);
        $convertedFields = array();
        foreach( $gatewayFields as $field=>$val ) $convertedFields[] = "'$field': '".addcslashes($val, "'")."'";
        $onclick = 
        "setHiddenPurchaseFields(
            '".$_ES->getPaymentEnvironment($gateway)."',
            {
                ".str_replace('"', "'+String.fromCharCode(34)+'", implode(", ", $convertedFields))."
            }
        )";
        //'https://developer.authorize.net/param_dump.asp', 
        $onclick = preg_replace("/\n|\r\n/", "", $onclick);
        return GenerWidget::generTextField("image","$gateway$purchaseItem->id","","","", "src='$img' onclick=\"$onclick\"");
        //return "<img src='$img' onclick=\"$onclick\">";
    }
    else
    {
        $link = new AppController("purchase_$gateway/create_form/$purchaseItem->id");
        return str_replace("http://", "https://", $link->generImageAnchor($img, ""));
    }
}

function getPaymentButtonURL()
{
// must be overridden in the sub classes    
}

function getGatewayFieldsForSimpleIntegration($purchaseItem)
{
// must be overridden in the sub classes    
}

function getGatewayFieldsForAdvancedIntegration($purchaseItem)
{
    // Per default, we assume that the same fields are necessary for 
    // the Simple and Advanced integration. This is the case in Authorize.NET
    // for example (but not in PayPal!)
    return $this->getGatewayFieldsForSimpleIntegration($purchaseItem);
}

function getCustomerId()
{
    global $gorumuser;
    return $gorumuser->id;
}

function getSilentPostUrl()
{
    return Controller::getBaseUrl()."process.php";
}

function getReturnUrl()
{
    return Controller::getBaseUrl()."return.php";
}

function getCancelUrl()
{
    return Controller::getBaseUrl()."return.php";
}

/**************************************************************************************************/
// Functions used to process the gateway response to the silent post URL:
/**************************************************************************************************/

function processResponse(&$purchase, &$item)
{
    global $lll;
    
    $gateways = Gateway::getGateways();
    $gateway = 0;
    for( $i=0; $i<count($gateways) && !$gateway; $i++ )
    {
        if( call_user_func(array($gateways[$i], "testResponseAgainstGateway")) ) $gateway = new $gateways[$i];
    }
    $purchase->rawResponse = "<pre>".print_r($_POST, TRUE)."</pre>";
    if( !$gateway ) return $purchase->setError($lll["unknownGateway"]);
    $purchase->paymentMethod = $gateway->getGatewayName();
    $gateway->getDataFromResponse($purchase);
    if( !$gateway->validateSilentPostResponse($purchase) || 
        ($purchase->responseCode = $gateway->getResponseCode())!=ECOMM_COMPLETED || 
        !$gateway->getPurchaseItem($purchase, $item) ||
        !$gateway->checkForDuplicateTransaction($purchase) ||
        !$gateway->checkForPriceEquality($purchase, $item) ) return FALSE;
    $gateway->overwritePendingTransactionIfExists($purchase);
    return TRUE;
}

function overwritePendingTransactionIfExists($purchase)
{
    // If a previous purchase exists with the same transaction ID and status=Pending,
    // this Completed purchase must replace it, so we delete the previous Pending one:
    $purchaseCheck = new Purchase;
    $purchaseCheck->transactionId = $purchase->transactionId;
    $purchaseCheck->responseCode = ECOMM_PENDING;
    $ret = load($purchaseCheck, array("transactionId", "responseCode"));
    if( !$ret ) delete($purchaseCheck);
}

// If the price returned in the transaction response doesn't equal to the price of the item 
// the purchase refers to, we don't process the transaction
function checkForPriceEquality(&$purchase, $item)
{
    global $lll;
    
    if( floatval($item->price)!=floatval($purchase->price) )
    {
        return $purchase->setError($lll["wrongAmount"], $purchase->price);
    }
    return TRUE;
}

// If no purchase item exists with the item ID we get in the response,
// we don't process the transaction
function getPurchaseItem(&$purchase, &$item)
{
    global $lll;
    
    if( G::load( $item, $purchase->pid, "purchaseitem" ) ) 
    {
        return $purchase->setError($lll["unknownPurchaseItemId"]);
    }
    $purchase->description = $item->description;
    return TRUE;
}

// If an older transaction with the same transaction ID and Completed status exists already,
// we don't process the transaction
function checkForDuplicateTransaction(&$purchase)
{
    global $lll;
    // Checking for duplicate transaction (one with the same txn_id and Completed status):
    $purchaseCheck = new Purchase;
    $purchaseCheck->transactionId = $purchase->transactionId;
    $purchaseCheck->responseCode = ECOMM_COMPLETED;
    $ret = load($purchaseCheck, array("transactionId", "responseCode"));
    if( !$ret ) return $purchase->setError($lll["duplicateTransactionId"]);
    return TRUE;
}

function testResponseAgainstGateway()
{
    // must be overridden in the sub classes    
    return FALSE;
}

function getResponseCode()
{
    // must be overridden in the sub classes    
    return ECOMM_ERROR;
}

/**************************************************************************************************/
// Functions used to process the instant gateway response in case of an advanced integration:
/**************************************************************************************************/

function getInstantPaymentResponse( $purchaseItem )
{
    $_ES = new ECommSettings();
    $fields = $this->getGatewayFieldsForAdvancedIntegration($purchaseItem);
    FP::log($fields);
    $response = $this->sendPostRequest($fields, $_ES->getPaymentEnvironment($this->getGatewayName()), "POST");
    if( !$response ) return FALSE;  // error occured during sending the request
    return $this->validateInstantResponse($response);
}

function sendPostRequest($DataStream, $URL, $how = 'POST', $force='')
{
    $parsed = parse_url($URL);
    if(strtolower($parsed['scheme']) == 'http'){
        $HTTP_S = 'http://';
        $port = '80';
    } else {
        $HTTP_S = 'ssl://';
        $port = '443';
    }
    if(isset($parsed['port']) && $parsed['port']>0){
        $port = $parsed['port'];
    }
    $host	= $parsed['host'];
    $uri	= $parsed['path'].(isset($parsed['query'])?'?'.$parsed['query']:'').(isset($parsed['fragment'])?'#'.$parsed['fragment']:'');

    $ReqBody = '';

    foreach($DataStream as $key=>$val){
        if ($ReqBody!='') $ReqBody .= '&';
        if( $key!='method' && $key!='list' ) $ReqBody .= $key.'='.urlencode($val);
    } 
    $ContentLength = strlen($ReqBody);
    $return = "";
    if ((function_exists('version_compare')
        && version_compare(phpversion(), '4.3.0', '>=')
        && extension_loaded('openssl')
        && $force=='')
        || $force=='fsockopen') {
        
        $in = fsockopen($HTTP_S.$host, $port, $errno, $errstr, 60);

        if (!$in) {
            return Roll::setFormInvalid("cantConnectGatewayHost");
        } else {
            $ReqHeader = strtoupper($how).' '.$uri." HTTP/1.1\n".
                         'Host: '.$host."\n".
                         "Content-Type: application/x-www-form-urlencoded\n".
                         'Content-Length: '.$ContentLength."\n".
                         "Connection: close\n\n".
                         $ReqBody."\n";
            fputs($in, $ReqHeader);
        }
        $line = '';
        $firstLine = fgets($in, 4096);
        while (fgets($in, 4096) != "\r\n");
        // in case an "HTTP/1.1 100 Continue" header, we read until an other empty line arrives:
        if( strstr($firstLine, "100 Continue") ) while (fgets($in, 4096) != "\r\n");

        while ($line = @fgets($in, 4096)){
            $return .= $line;
        }
        fclose($in);
        return $return;
    }elseif ((extension_loaded('curl') && $force=='') || $force=='curl_ext') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ReqBody); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $certFile = $this->getCertificateFile();
        if(!extension_loaded('openssl') || !$certFile){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  // this makes it so you don't need to have a certificate
        }
        else{
            curl_setopt($ch, CURLOPT_CAINFO, $certFile); // if you have the crt file, u can specify it here, You don�t need the line above if u set this.
        }
        $return = curl_exec($ch); 
        if(curl_errno($ch)>0) return Roll::setFormInvalid("paymentFailed", curl_error($ch));
        curl_close($ch);
        return $return;
    } elseif($force == '' || $force == 'curl') {
        if($HTTP_S == 'ssl://') $HTTP_S = 'https://';
        
        if(strtolower($how)=='post'){
            $exec_str = $this->getCurlPath().' -m 120 -d "'.$ReqBody.'" "'.$HTTP_S.$host.':'.$port.$uri.'" -L';
        } else {
            $exec_str = $this->getCurlPath().' -m 120 "'.$HTTP_S.$host.':'.$port.$uri.'?'.$ReqBody.'" -L';
        }
        if($this->getCertificateFile()!=''){
            $exec_str .= ' --cert "'.$this->getCertificateFile().'"';
        }
        exec($exec_str, $ret_arr, $ret_num);

        if ($ret_num!=0 || !is_array($ret_arr) ) return Roll::setFormInvalid("paymentFailed", "CURL error");
        return join('',$ret_arr);
    }
} 

// Used in the Advanced Integration to get the result of an instant payment response:
// We only need to retrieve if the transaction was successfull or not. All the other data 
// will be passed to the silent post URL by the gateway anyway (IPN), so the instant response 
// need not be processed any deeper than this.
function validateInstantResponse($response)
{
    global $lll;
    
    $response = $this->decodeInstantResponse($response);
    FP::log($response);
    if( $this->isResponseSuccessfull($response) ) return TRUE;
    if( isset($lll[$label = $this->getGatewayName()."_errorText_".$this->getErrorCode($response)]) ) return Roll::setFormInvalid($label);
    return Roll::setFormInvalid($this->getErrorText($response));
}

function getCertificateFile()
{
    return "";
}

function getCurlPath()
{
    return '/usr/local/bin/curl';
}

function getStateCodeFromStateName($stateName)
{
    global $stateCodes;
    
    if( strlen($stateName)==2 ) return $stateName;  // if it happened to be a state code already
    include_once("statecodes.php");
    if( isset($stateCodes[$label=strtolower($stateName)]) ) return $stateCodes[$label];
    return $stateName;
}

}

?>
