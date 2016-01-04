$JQ.extend($JQ.noah, {
    propagateOnBeforeLoad: function(api, processingLabel, continueLabel, url)
    {
        var attrName = api.getTrigger().closest('td').next('td').attr('name');
        api.getContent().find('.confirmation_ok').bind( 'click', {attr: attrName}, function(e) { 
            var overlay = $JQ(e.target).closest('.confirmationTemplate');
            // replacing the header text to 'Processing...':
            overlay.find('.confirmationHeader').html(processingLabel);
            // replacing the content with a loading animation image
            $JQ(loadingAnimation).appendTo(overlay.find('.confirmationContent').empty()).center(); 
            overlay.find('.confirmation_ok').hide();
            overlay.find('.confirmation_cancel').val(continueLabel);
            if( e.data.attr=='values' ) 
            {
                var propagateParameters = {
                    attr: e.data.attr, 
                    value: $JQ.toJSON($JQ('.cell [name="'+e.data.attr+'[]"]').fieldArray()),
                    "default": $JQ.toJSON($JQ('.cell [name="default[]"]').fieldArray()),
                    optionValueModificationStack: $JQ.toJSON(optionValueModificationStack)
                };
            }
            else
            {
                var propagateParameters = {
                    attr: e.data.attr, 
                    value: $JQ('.cell [name='+e.data.attr+']').getValue()
                };
            }
            overlay.find('.confirmationContent').load( url, propagateParameters, function(){});
            return false;
        });
    },
    propagateOnClose: function(api, confirmationLabel, propagateConfirmationText, cancelLabel)
    {
        api.getContent().find('.confirmationHeader').html(confirmationLabel).end().
                          find('.confirmationContent').html(propagateConfirmationText).end().
                          find('.confirmation_cancel').val(cancelLabel).end().
                          find('.confirmation_ok').unbind().show();
    },
    submitOptionValueModificationStack: function()
    {
        $JQ('.submitfooter input').click( function() { 
            if( typeof optionValueModificationStack == 'undefined' ) return true;                 
            var stack = $JQ.toJSON(optionValueModificationStack);
            if( $JQ('#optionValueModificationStack').length ) $JQ('#optionValueModificationStack').val(stack);
            else $JQ('<input type="hidden" name="optionValueModificationStack" />').val(stack).appendTo($JQ('div[id$=field-modify_form]').closest('form'));
        });
    }
});
