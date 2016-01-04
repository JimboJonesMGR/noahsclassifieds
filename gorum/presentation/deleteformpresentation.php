<?php
defined('_NOAH') or die('Restricted access');
if( !isset($gorumdeleteformtemplate) ) $gorumdeleteformtemplate = "default_deleteform.tpl.php";

class DeleteFormPresentation extends Presentation
{

function DeleteFormPresentation(&$base)
{
    $this->Presentation($base, "deleteform");  
}

function processContent(&$tpl)
{
    global $lll, $upperTemplate;
    global $gorumroll, $jsInclude, $jsOnLoad, $scriptName;
    global $maxInputLength, $maxFieldLength, $noFileUpload, $onSubmit;
    
    $formAttrs="";
    if (!isset($noFileUpload)) $formAttrs=" enctype='multipart/form-data'";
    if ($onSubmit) $formAttrs.=" onsubmit='$onSubmit'";
    $tpl->assign("formAttrs", $formAttrs);
    $tpl->assign("scriptName", $scriptName);
    $tpl->assign("listAndMethod", "$gorumroll->list-$gorumroll->method");
    $class = $gorumroll->getClass();
    $method = $gorumroll->method;
    // A kovetkezo method beallitasa:
    $ctrl = new AppController(array("method"=>str_replace("_form","",$method)));

    $hiddens = $ctrl->generHiddenFields();
    foreach( $this->typ["attributes"] as $attr=>$val )
    {
        if( in_array("$gorumroll->method: form hidden",$val) )
        {
            $hiddens.=GenerWidget::generHiddenField($attr,$this->base->{$attr});
        }
        elseif( in_array("form hidden",$val) )
        {
            $hiddens.=GenerWidget::generHiddenField($attr,$this->base->{$attr});
        }
    }
    $tpl->assign("hiddens", $hiddens);
    $lllGlobProp = new LllGlobalProperties( $this->base );
    $title = sprintf($lll["beforeDelete"], $lllGlobProp->getLabel());    
    if( $sd = $lllGlobProp->getLabel("seriousDeleteQuestion", FALSE) )
    {
        if ($title) $title.="<br>";
        $title.=$sd;
    }
    $tpl->assign("title", $title);    
       
    if( isset($this->typ["delete_confirm"]) && isset($this->base->{$this->typ["delete_confirm"]}) &&
        $this->base->{$this->typ["delete_confirm"]} )
    {
        $tpl->assign("confirm", $this->base->showListVal($this->typ["delete_confirm"]));
    }
    $submits=array();
    $submits[]="<input type=submit value='$lll[ok]' name=gsubmit class='button'>\n";
    $submits[]="<input type=submit value='$lll[cancel]' name=gsubmit class='button'>\n";
    $tpl->assign("submits", $submits);
    $tpl->assign("rows", array());
    //var_dump($tpl);die();
    return ok;
}

} // end class
?>
