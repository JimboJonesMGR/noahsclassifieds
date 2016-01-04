$JQ.extend($JQ.noah, {
    addInlineWarningOnFocus: function(attr, text)
    {
        $JQ('.cell [name="' + attr + '"]').focus(function() {
            var cell = $JQ(this).closest('.cell');
            if( cell.find('.ruleWarning').length==0 )
            {
                $JQ(this).closest('.cell').append('<br><span class="ruleWarning">' + text + '</span>');
            }
        });
    },
    addInlineWarningOnChange: function(attr, value, text)
    {
        var action = function() {
            var displayRule = function(obj, value, text) {
                var cell = $JQ(obj).closest('.cell');
                var theValue = value.replace(/ /g,'');

                if( cell.find('#ruleWarning_'+theValue).length==0 )
                {
                    $JQ(obj).closest('.cell').append('<span class="ruleWarning" id="ruleWarning_' + theValue + '">' + text + '</span>');
                }

                var theCell = cell.find('#ruleWarning_'+theValue);
                var theStatus = cell.find('option[value="' + value + '"]').attr('selected') ?1:0;
                
                if (theStatus==0)
                    theCell.hide();
                else
                    theCell.show();
            }

            displayRule(this, value, text);
        }
        $JQ('.cell select[id="' + attr + '"]').change(action);
    },
    addInlineWarningOnMultiChange: function(attr, value, text)
    {
        var action = function() {
            var displayRule = function(obj, value, text) {
                var cell = $JQ(obj).closest('.cell');
                var theValue = value.replace(/ /g,'');
                if( cell.find('#ruleWarning_'+theValue).length==0 )
                {
                    $JQ(obj).closest('.cell').append('<span class="ruleWarning" id="ruleWarning_' + theValue + '">' + text + '</span>');
                }
                var theCell = cell.find('#ruleWarning_'+theValue);
                var theStatus = cell.find('input[name="' + attr + '"]').attr('checked') ?1:0;

                if (theStatus==0)
                    theCell.hide();
                else
                    theCell.show();
            
            }

            //var theValue = $JQ(this).getValue();
            displayRule(this, value, text);

        }
        $JQ('.cell input[name="' + attr + '"]').click(action);
    },
    popupOverlayOnLoad: function(overlaySelector)
    {
        $JQ(overlaySelector).overlay().load();
    },
    popupOverlayOnSubmit: function(overlaySelector)
    {
        $JQ('div[id$=item-modify_form], div[id$=item-create_form]').closest('form').submit( function() {
            $JQ(overlaySelector).overlay().load();
            return false;
        });                               
    }
});
