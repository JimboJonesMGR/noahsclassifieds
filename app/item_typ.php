<?php
defined('_NOAH') or die('Restricted access');
global $item_typ;
$item_typ =
    array(
        "attributes"=>array(
            "id"=>array(
                "type"=>"INT",
                "auto increment",
                "form hidden",
                "export"
            ),
            "cid"=>array(
                //"form hidden",
                "type"=>"INT",
                "class"=>"category",
                "labelAttr"=>"wholeName",
                "values"=>array(),
                "modify_form: form invisible",
                "conditions"=>array("!\$gorumroll->rollid"=>array("nothing selected"=>"selectCategory"),
                                    "\$gorumroll->method=='move_form'"=>array("get_values_callback"=>'getCompatibleCategories()'),
                                    "\$gorumroll->method=='create_form' && (!\$gorumroll->rollid || !\$_S->cascadingCategorySelectEnabled())"=>array("get_values_callback"=>'getSelectFromTree()'),
                                    "\$gorumroll->method=='create_form' && \$gorumroll->rollid && \$_S->cascadingCategorySelectEnabled()"=>"form hidden",
                                    "\$gorumroll->method!='create_form' || !\$gorumroll->rollid || !\$_S->cascadingCategorySelectEnabled()"=>"classselection")
            ),
            "firstCid"=>array(
                "type"=>"INT",
                "form invisible",
            ),
            "cName"=>array(
                "type"=>"VARCHAR",
                "max" =>"120",
                "link_to"=>array("class"=>"appcategory", "id"=>"cid", "other_attr"=>"name"),
                "conditions"=>array("\$gorumroll->method=='create_form' && \$gorumroll->rollid && \$_S->cascadingCategorySelectEnabled()"=>"create_form: readonly",
                                    "\$gorumroll->method=='create_form' && \$gorumroll->rollid && !\$_S->cascadingCategorySelectEnabled()"=>"form invisible"),
                "nohidden",
                "modify_form: readonly",
                "no column",
            ),
            "wholeCatName"=>array(
                "type"=>"VARCHAR",
                "max" =>"120",
                "no column",                
            ),
            "catPermaLink"=>array(
                "type"=>"VARCHAR",
                "no column",                
            ),
            "title"=>array(  // a nem kategory specifikus item listak Title oszlopahoz
                "type"=>"INT",
                "form invisible",
                "no column"
            ),
            "description"=>array(  // a nem kategory specifikus item listak Description-jehez
                "type"=>"INT",
                "form invisible",
                "no column",
                "in new line"
            ),
            "creationtime"=>array(
                "type"=>"DATETIME",
                "prototype"=>"date",
                "form invisible",
            ),
            "status"=>array(
                "type"=>"INT",
                "values"=>array(0, 1),  // Inactive, Active, Rejected
                "default"=>1,
                "enum",
                "conditions"=>array("\$isAdm && \$gorumroll->method!='move_form'"=>"selection")
            ),
            "clicked"=>array(
                "type"=>"INT",
                "form invisible",
                "sorta"
            ),
            "responded"=>array(
                "type"=>"INT",
                "form invisible",
                "sorta"
            ),
            "ownerId"=>array(
                "type"=>"INT",
                "form invisible",
            ),
            "ownerName"=>array(
                "type"=>"INT",
                "form invisible",
                "no column",
                "link_to"=>array("class"=>"user", "id"=>"ownerId", "other_attr"=>"name"),
            ),
            "expEmailSent"=>array(
                "type"=>"INT",
                "form invisible",
                "default"=>"0"
            ),
            "expirationTime"=>array(
                "type"=>"DATETIME",
                "prototype"=>"date",
                "form invisible",
                "sorta"
            ),
            "renewalNum"=>array(
                "type"=>"INT",
                "form invisible",
            ),
            "email"=>array(
                "no column",
                "form invisible",
            ),
            "expiration"=>array(
                "type"=>"INT",
                "conditions"=>array("\$gorumroll->method!='move_form'"=>"text")
            ),
            "expirationEnabled"=>array(
                "type"=>"INT",
                "no column",
                "form invisible"
            ),
            "expirationOverride"=>array(
                "type"=>"INT",
                "no column",
                "form invisible"
            ),
            "immediateAppear"=>array(
                "type"=>"INT",
                "no column",
                "form invisible"
            ),
            "captchaField"=>array(
                "type"=>"VARCHAR",
                "conditions"=>array("\$this->hasCaptchaInForm()"=>"text"),
                "max" =>"250",
                "length"=>10,
                "no column",
            ),
            "oodleType"=>array(
                "type"=>"INT",
                "form invisible"
            ),
            "oodleImageUrl"=>array(
                "type"=>"VARCHAR",
                "max" =>"255",
                "form invisible"
            ),
            "oodleUrl"=>array(
                "type"=>"VARCHAR",
                "max" =>"255",
                "form invisible"
            ),
            "oodleID"=>array(
                "type"=>"VARCHAR",
                "max" =>"255",
                "form invisible"
            ),
            "subscribtionsNotified"=>array(
                "type"=>"TEXT",
            ),
        ),
        "primary_key"=>"id",
        //"delete_confirm"=>"",
        "sort_criteria_sql"=>"creationtime DESC",
        "detailsTemplate"=>"item_details.tpl.php",
        "detailsPresentationClassName"=>"ItemDetailsPresentation",
        "listPresentationClassName"=>"ItemListPresentation",
        "keys"=>array("cid", "status", "ownerId"),
        "conditions"=>array("\$gorumroll->method=='create_form' && !\$gorumroll->rollid && \$_S->cascadingCategorySelectEnabled()"=>array("submit"=>array("continue", "cancel")))
    );

    
?>
