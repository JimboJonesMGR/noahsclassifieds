function setHiddenPurchaseFields(environment,parameters)
{
    var purchaseForm = $JQ('#purchaseForm');
    purchaseForm.attr('action', environment );
    for( var field in parameters )
    {
        var value = parameters[field];
        if( value!="" ) 
        {
            purchaseForm.append("<input type='hidden' name='" + field + "' value='" + value + "'>");
        }
    }
    return false;
}
