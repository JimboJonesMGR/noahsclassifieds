var gorumForm;

rule_registration = 1;
rule_submit = 2;
rule_prolong = 3;
rule_view = 4;
rule_reply = 5;
rule_setField = 6;
rule_setFieldToValue = 7;

rule_generic = 0;
rule_customized = 1;

jQuery(document).ready(function($) {
  var allConditionalFields = new Array(
    'viewNum', 'replyNum', 'cid', 'includeSubcats', 'ruleField', 'ruleValue',
    'confirmationText', 'successText', 'failText' 
  );
  var allConditionFields = new Array(
    'action', 'cid', 'confirmationTextType', 'successTextType', 'failTextType', 'ruleField'
  );
  //dump(cfForm);
  disableFields( allConditionalFields );
  hideAndDisplay(0);
  addConditionalEvents( allConditionFields );

  function hideAndDisplay(event)
  {
    gorumForm = $('div[id$=rule-create_form], div[id$=rule-modify_form]').closest('form');
    var formVals = gorumForm.formHash();
    var triggeredField = event ? event.data.field : '';
    displayField( 'viewNum', (formVals.action==rule_view));
    displayField( 'replyNum', (formVals.action==rule_reply));
    displayField( 'cid', (formVals.action!=rule_registration));
    displayField( 'includeSubcats', (formVals.action!=rule_registration && formVals.action!=rule_setField && formVals.action!=rule_setFieldToValue && formVals.cid!=0));
    displayField( 'ruleField', (formVals.action==rule_setField || formVals.action==rule_setFieldToValue), formVals.cid, formVals.action, triggeredField);
    displayField( 'ruleValue', (formVals.action==rule_setFieldToValue && formVals.ruleField!=0), formVals.ruleField, '', triggeredField);
    displayField( 'confirmationText', (formVals.confirmationTextType==rule_customized));
    displayField( 'failText', (formVals.failTextType==rule_customized));
    displayField( 'successText', (formVals.successTextType==rule_customized));
  }
  
  function displayField( field, condition, cidOrField, action, triggeredField )
  {
    var row = gorumForm.find("[name='"+field+"']").parents('tr.row');
    if( condition ) 
    {
        if( (triggeredField=='cid' || triggeredField=='action') && field=='ruleField' )
        {          
            var method = action==rule_setFieldToValue ? 'get_select_fields_for_rules' : 'get_fields_for_rules';
            $("#ruleField").load('index.php?customfield/' + method + '/' + cidOrField, function() {
                $(this).parents('tr.row').show();
            });
        }
        else if( triggeredField=='ruleField' && field=='ruleValue' )
        {
            $("#ruleValue").load('index.php?customfield/get_values_for_rules/' + cidOrField, function() {
                $(this).parents('tr.row').show();
            });
        }
        else row.show();
    }
    else row.hide();
  }
  
  function disableFields( fields )
  {
    $.each( fields, function() {
      $("#" + this).parents('tr.row').hide();     
    });
  }
  
  function addConditionalEvents( fields )
  {
    $.each( fields, function() {
      gorumForm.find("select[name='"+this+"']").bind('change', {field: this}, hideAndDisplay);  
    });
    $.each( fields, function() {
      gorumForm.find("input[name='"+this+"']").bind('click', {field: this}, hideAndDisplay);  
      gorumForm.find("input[name='"+this+"\\[0\\]']").bind('click', {field: this}, hideAndDisplay);  
    });
  }

});

