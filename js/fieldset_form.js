jQuery(document).ready(function($) {
  noah_formId = 'fieldset_form';
  var allConditionalFields = new Array(
    'deleteAll', 'cloneToSubcats', 'cloneToCats', 'cloneFromCat'
  );
  var allConditionFields = new Array(
    'deleteAll', 'cloneToSubcats', 'cloneToCats', 'cloneFromCat'
  );
  //dump(cfForm);
  disableFields( allConditionalFields );
  hideAndDisplay(1);
  addConditionalEvents( allConditionFields );
});

function hideAndDisplay(firstCall)
{
  var form = $JQ('#'+noah_formId);
  var formVals = form.formHash();
  formVals.cloneToCats=$JQ('#asmList0 li').length;
  if( typeof formVals.cloneToSubcats == 'undefined' || formVals.cloneToSubcats=='' ) formVals.cloneToSubcats=0;
  if( typeof formVals.deleteAll == 'undefined' || formVals.deleteAll=='' ) formVals.deleteAll=0;
  //if( typeof formVals.cloneFromCat == 'undefined' || formVals.cloneFromCat=='false' ) formVals.cloneFromCat=0;
  //dump(formVals);
  displayField( 'deleteAll', (formVals.cloneToSubcats==0 && formVals.cloneToCats==0 && formVals.cloneFromCat==0));
  displayField( 'cloneToSubcats', (formVals.deleteAll==0 && formVals.cloneToCats==0 && formVals.cloneFromCat==0));
  displayField( 'cloneToCats', (formVals.deleteAll==0 && formVals.cloneToSubcats==0 && formVals.cloneFromCat==0));
  displayField( 'cloneFromCat', (formVals.deleteAll==0 && formVals.cloneToSubcats==0 && formVals.cloneToCats==0));
  // hogy a form le-fel nyilasa ne legyen zavaro, mindig a kepernyo legaljara pozicionalunk:
  if( firstCall!=1 ) $JQ(window).scrollTop($JQ(document).height() - $JQ(window).height());
}

function displayField( field, condition )
{
  //alert( field + ', ' + condition);
  var row = $JQ("#"+field).parents('tr.row');
  if( condition )  row.show();
  else row.hide();
}

function disableFields( fields )
{
  $JQ.each( fields, function() {
    $JQ("#" + this).parents('tr.row').hide();     
  });
}

function addConditionalEvents( fields )
{
  $JQ.each( fields, function() {
    $JQ("#"+noah_formId+" select[name='"+this+"']").change(hideAndDisplay);  
  });
  $JQ.each( fields, function() {
    $JQ("#"+noah_formId+" input[name='"+this+"']").click(hideAndDisplay);  
  });
}


