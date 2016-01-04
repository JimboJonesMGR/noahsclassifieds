<?php
defined('_NOAH') or die('Restricted access');

class Presentation
{
    
var $template;
var $base;
var $typ;
var $innerBordersOnly;
var $cached="";

function Presentation(&$base, $what, $typ=0)
{
    global ${"gorum{$what}template"}, $gorumroll;
    $this->base =& $base;
    if( $typ ) $this->typ =& $typ;
    else $this->typ =& $base->getTypeInfo(TRUE);
    if( isset($this->typ["$gorumroll->list: {$what}Template"]) )
        $this->template = $this->typ["$gorumroll->list: {$what}Template"];
    if( isset($this->typ["$gorumroll->method: {$what}Template"]) )
        $this->template = $this->typ["$gorumroll->method: {$what}Template"];
    elseif ( isset($this->typ["{$what}Template"]) )    
        $this->template = $this->typ["{$what}Template"];
    else $this->template = ${"gorum{$what}template"};
    $this->innerBordersOnly = G::getSetting($this->typ, "innerBordersOnly" );
    if( $this->innerBordersOnly )
    {
        // a szelso td-k kulso bordereit toroljuk:
        JavaScript::addOnload("
            $('.template > table').find('tbody tr:not(.noapply), tfoot tr').find('td:first, th:first').css('border-left', 'none').end().
                                    find('td:last, th:last').css('border-right', 'none').end().
                                    find('td.groupsep_v + td').css('border-left', 'none').end().
                                    find('td.groupsep_v').prev().css('border-right', 'none').end().end().
                                    slice(-1).find('td').css('border-bottom', 'none');
        ", "innerBordersOnly");
    }
}

function gener(&$view)
{
    if( $this->cached )
    {
        $view->setCacheFileName($this->cached);
    }
    else
    {
        $view->setTemplateFileName($this->template);
        return $this->processContent($view->getTemplate());
    }
}

function getFormHeader(&$tpl)
{
    global $gorumroll, $scriptName, $noFileUpload, $onSubmit;

    if( isset($this->typ["formid"]) )
    {
        $formId = $hiddenFieldPrefix = $this->typ["formid"];
        $formAttrs="id='$formId'";
    }
    else
    {
        $formId="gorumForm";
        $hiddenFieldPrefix="";
        $formAttrs="id='gorumForm'";
    }
    if (!isset($noFileUpload)) $formAttrs.=" ENCTYPE='multipart/form-data'";
    $tpl->assign("formAttrs", $formAttrs);
    if ($onSubmit) JavaScript::addEvent("#$formId", "submit", $onSubmit);
    $tpl->assign("scriptName", $scriptName);
    // A kovetkezo method beallitasa:
    $ctrl = new AppController(array("method"=>str_replace("_form","",$gorumroll->method)));
    $tpl->assign("hiddens", $ctrl->generHiddenFields($hiddenFieldPrefix));
    return $hiddenFieldPrefix;
}

function getFormSubmit( &$submitButtonArr )
{
    global $lll, $noCancelButton, $gorumroll;
    
    $submitButtonArr=array();
    if( !in_array("nosubmit", $this->typ) )
    {
        if( isset($this->typ["$gorumroll->method: submit"]) )
        {
            $k=1;
            foreach( $this->typ["$gorumroll->method: submit"] as $button )
            {
                $submitButtonArr[]="<input type='submit' value='".$lll[$button].
                                 "' name='gsubmit' id='submit_".($k++)."' class='button'>\n";
            }
        }
        elseif( isset($this->typ["submit"]) )
        {
            $k=1;
            foreach( $this->typ["submit"] as $button )
            {
                $submitButtonArr[]="<input type='submit' value='".$lll[$button].
                                 "' name='gsubmit' id='submit_".($k++)."' class='button'>\n";
            }
        }
        elseif(isset($noCancelButton) && $noCancelButton)
        {
            $submitButtonArr[]="<input type='submit' value='".$lll["ok"].
                             "' name='gsubmit' class='button'>\n";
        }
        else
        {
            $submitButtonArr[]="<input type='submit' value='".$lll["ok"].
                             "' name='gsubmit' class='button'>\n";
            $submitButtonArr[]="<input type='submit' value='".$lll["cancel"].
                             "' name='gsubmit' class='button'>\n";
        }
    }
}

} // end class
?>
