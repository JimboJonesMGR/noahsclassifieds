<?php
defined('_NOAH') or die('Restricted access');
if( !isset($gorumformtemplate) ) $gorumformtemplate = "default_form.tpl.php";

class FormPresentation extends Presentation
{

    
var $zebraForm;

function FormPresentation(&$base)
{
    $this->Presentation($base, "form");  
    $this->zebraForm = G::getSetting($this->typ, "zebraForm" );
}

function processContent(&$tpl)
{
    global $lll, $upperTemplate, $gorumuser, $gorumroll;

    $hiddenFieldPrefix = $this->getFormHeader($tpl);
    $tpl->assign("zebraForm", $this->zebraForm);
    $tpl->assign("listAndMethod", "$gorumroll->list-$gorumroll->method");
    $class = $gorumroll->getClass();
    $method = $gorumroll->method;
    if( $smartForm = (in_array("smartform", $this->typ) || in_array("$method: smartform", $this->typ)) )
    {
        JavaScript::addInclude(GORUM_JS_DIR . "/usableforms.js");
        JavaScript::addOnload("prepareForm();");
    }
    
    $lllGlobProp = new LllGlobalProperties( $this->base );
    $tpl->assign("title", $lllGlobProp->getLabel($method));
    $attributeList = isset($this->typ["order"]) ?
                     $this->typ["order"] : array_keys($this->typ["attributes"]);
    //print_r($attributeList);                 
    $rows = array();  
    $indexes = array();
    $j=0;
    foreach( $attributeList as $attr )
    {
        if( !($val = & $this->typ["attributes"][$attr]) ) continue;
        $visibility=$this->base->getVisibility( $val, $attr );
        if( $visibility==Form_invisible ) continue;
        $displayType = FormFieldType::getFormDisplayType($val, $method, $attr);
        if( in_array($displayType, array("section","txtsection","freepart")) )
        {
            $this->{"gener{$displayType}Field"}($rows[$j], $attr, $val);
            $indexes[$attr]=$j;
            $j++;            
            continue;
        }
        // Ahelyett, hogy a processMethodban initeznenk, itt allitjuk
        // az attributumot defaultra, ha nincs beszettelve:
        if( !isset($this->base->{$attr}) )
        {
            $this->base->{$attr} = $this->base->getDefault($this->typ, $attr);
        }
        if( $visibility==Form_hidden || ($visibility==Form_readonly && !in_array("nohidden",$val)))
        {
            $tpl->hiddens.=GenerWidget::generHiddenField($attr,$this->base->{$attr}, $hiddenFieldPrefix);
        }
        if( !$displayType || $visibility==Form_hidden ) continue;
        $lllProp = new LllProperties( $this->base, $attr );
        $s = $this->generField($displayType, $attr, $val, $lllProp );
        if( !isset($val["fieldgroup"]) ) 
        {
            $rows[$j]["type"]=$displayType;

            $this->generCommonFieldProperties( $rows[$j], $attr, $val, $lllProp );
            $rows[$j]["field"] = $s;
            $indexes[$attr]=$j;
            $j++;
        }
        else
        {
            // ha egy mezo-csoport tagja, akkor csak hozzafuzzuk az elozo mezohoz
            // es nem noveljuk a szamlalot:
            if( isset($lll[$class."_".$attr] ) ) $s = $lll[$class."_".$attr].$s;
            $rows[$j-1]["field"] .= $s;
        }
    }
    $submits = array();
    $this->getFormSubmit( $submits );
    $this->addJavaScripts();
    $tpl->assign("additionalHiddens", $this->base->getAdditionalHiddens($tpl));
    $tpl->assign("additionalContent", "");
    $tpl->assign("rows", $rows);
    $tpl->assign("indexes", $indexes);
    $tpl->assign("submits", $submits);
    //var_dump($tpl);die();
    return ok;
}

function generSectionField( &$tplRow, &$attr, &$val )
{
    global $lll;
    
    if( isset($lll[$attr]) )
    {
        $tplRow["type"] = "section";
        if( isset($val["relation"]) ) 
        {
            $rels = explode(",", $val["relation"]);
            $r="";            
            if( is_array($rels) )
            {
                for( $k=0; $k<count($rels); $k++ ) 
                {
                    if( $r ) $r.=",";
                    $r.=$rels[$k]."_rel";
                }
            }
            else $r=$rels."_rel";
            $tplRow["relation"] = " relation='$r'";
        }
        $tplRow["field"] = $lll[$attr];   
    }
    $tplRow["attr"] = $attr;
}

function generTxtSectionField( &$tplRow, &$attr, &$val )
{
    global $lll;
    
    if( isset($lll[$attr]) )
    {
        $tplRow["type"] = "txtsection";
        if( isset($val["relation"]) ) {
            $tplRow["relation"] = " relation='$val[relation]_rel'";
        }
        $tplRow["field"] = $lll[$attr];   
    }
    $tplRow["attr"] = $attr;
}

function generCommonFieldProperties( &$tplRow, &$attr, &$val, &$lllProp )
{
    global $gorumroll;
    
    if( isset($val["relation"]) ) 
    {
        $rels = explode(",", $val["relation"]);
        $r="";            
        if( is_array($rels) )
        {
            for( $k=0; $k<count($rels); $k++ ) 
            {
                if( $r ) $r.="_";
                $r.=$rels[$k]."_rel";
            }
        }
        else $r=$rels."_rel";
        $tplRow["relation"] = " relation='$r'";
    }
    $tplRow["label"] = $lllProp->getLabel();
    $tplRow["expl"] =  $lllProp->getExpl();
    $tplRow["afterField"] = $lllProp->getAfterField();
    $tplRow["embedField"] = $lllProp->getEmbedField();
    if (in_array("$gorumroll->method: mandatory",$val) || in_array("mandatory",$val)) $tplRow["label"].=" *";
    $tplRow["attr"] = $attr;
    if( in_array("widecontent_form",$val) ) $tplRow["widecontent"]=TRUE;
}

function generFreePartField( &$tplRow, &$attr, &$val )
{
    $tplRow["type"] = "freepart";
    $tplRow["field"] = $val["freepart"];
    $tplRow["attr"] = $attr;
}

function generField( $fdt, &$attr, &$val, &$lllProp )
{
    if( !$fdt ) return "";
    return $this->{"gener{$fdt}Field"}( $attr, $val, $lllProp);
}

function getTextFieldLengths( $val, &$inputLength, &$fieldLength )
{
    global $maxInputLength, $maxFieldLength;
    
    if (isset($val["max"])) $fieldLength=$val["max"];
    else $fieldLength=$maxFieldLength;
    if (isset($val["length"])) $inputLength=$val["length"];
    else $inputLength=$maxInputLength;
}

function generReadonlyField( $attr )
{
    return $this->base->showListVal($attr);
}

function generFieldGroupField(  )
{
    //Fieldgroup-nal a kovetkezo mezok tartalma fogja kepezni a fieldet
    return "";
}

function generFileField( $attr, $val )
{
    $this->getTextFieldLengths( $val, $inputLength, $fieldLength );
    $max_file_size= isset($val["max_file_size"]) ? intval($val["max_file_size"]) : 0; 
    return GenerWidget::generFileField($attr,$inputLength, $fieldLength, $max_file_size);
}

function generTextField( $attr, $val )
{
    global $jQueryLib;
    
    $this->getTextFieldLengths( $val, $inputLength, $fieldLength );
    if(isset($val["onkeypress"])) JavaScript::addEvent('#'.$attr, "keypress", $val["onkeypress"]);
    if(isset($val["onkeyup"])) JavaScript::addEvent('#'.$attr, "keyup", $val["onkeyup"]);
    if(isset($val["onchange"])) JavaScript::addEvent('#'.$attr, "change", $val["onchange"]);
    if(isset($val["onblur"])) JavaScript::addEvent('#'.$attr, "blur", $val["onblur"]);
    if( isset($val["default"]) && $val["default"]==="" && $this->base->{$attr}==="0" ) $this->base->{$attr}="";
    if( isset($val["masked"]) )
    {
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.maskedinput.js");
        JavaScript::addOnload("
            $('#$attr').mask('$val[masked]');
        ");                      
    }
    if( isset($val["filterCharacters"]) )
    {
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.alphanumeric.js");
        JavaScript::addOnload("
            $('#$attr').$val[filterCharacters];
        ");                      
    }
    return GenerWidget::generTextField("text",$attr,$this->base->{$attr},$inputLength,$fieldLength);
}

function generDateTextField( $attr, $val )
{
    $this->getTextFieldLengths( $val, $inputLength, $fieldLength );
    return GenerDateWidget::generDateTextField($attr, $this->base->{$attr}, $val, $inputLength, $fieldLength);
}

function generPasswordField( $attr, $val )
{
    $this->getTextFieldLengths( $val, $inputLength, $fieldLength );
    return GenerWidget::generTextField("password",$attr,$this->base->{$attr},$inputLength,$fieldLength);
}

function generButtonField( $attr, $val, &$lllProp )
{
    $this->getTextFieldLengths( $val, $inputLength, $fieldLength );
    $buttonText = $lllProp->getButtontext();
    return GenerWidget::generTextField("button","submit",$buttonText,$inputLength,$fieldLength);
}

function generSubmitField( $attr, $val, &$lllProp )
{
    $this->getTextFieldLengths( $val, $inputLength, $fieldLength );
    $buttonText = $lllProp->getButtontext();
    $submitName = isset($val["name"]) ? $val["name"] : "gsubmit";
    return GenerWidget::generTextField("submit",$submitName,$buttonText,$inputLength,$fieldLength);
}

function generTextAreaField( $attr, $val )
{
    $readonly = in_array("readonly",$val);
    $markitup = isset($val["markitup"]) ? $val["markitup"] : 0;
    $markitupsimple = in_array("markitupsimple",$val);
    $cols = isset($val["cols"]) ? $val["cols"] : "";
    return GenerWidget::generTextAreaField($attr,$this->base->{$attr},$val["rows"], $cols,$readonly, $markitup, $markitupsimple);
}

function generMultipleSelectionField( $attr, $val, &$lllProp )
{
    $size = isset($val["size"]) ? $val["size"] : 1;
    $width = isset($val["width"]) ? $val["width"] : 0;
    if( in_array("variablesize",$val) )
    {
        $count = count($val["values"]);
        if( isset($val["nothing selected"]) ) $count++;
        $size = $count>$size ? $size : $count;
    }
    $labels =& $lllProp->getSelectLabels($val["values"]);
    if(isset($val["onclick"])) JavaScript::addEvent('#'.$attr, "click", $val["onclick"]);
    if(isset($val["onchange"])) JavaScript::addEvent('#'.$attr, "change", $val["onchange"]);
    $showRelation=isset($val["show_relation"]) ? $val["show_relation"] : "";
    $anyfield=isset($val["anyfield"]) ? $val["anyfield"] : "";
    $asmSelect=isset($val["asmselect"]) ? $val["asmselect"] : "";
    $asmSelectLabel=isset($val["asmselect_label"]) ? $val["asmselect_label"] : "";    
    $s = GenerWidget::generMultipleSelection($attr,$labels,$val["values"], $this->base->{$attr},
                                             $size,$width,$showRelation, $anyfield, $asmSelect, $asmSelectLabel);
    if( in_array("selectfilter",$val))
    {
        $s=GenerWidget::generSelectFilterField($attr, $labels, $width).$s;
    }
    return $s;
}

function generCheckBoxField( $attr, $val, &$lllProp )
{
    $cols = isset($val["cols"]) ? $val["cols"] : 1;
    $labels =& $lllProp->getSelectLabels($val["values"]);
    foreach($val["values"] as $key=>$value)
    {
        if(isset($val["onclick"])) JavaScript::addEvent('#'.$attr."_$key", "click", $val["onclick"]);
    }
    $horizvert=(in_array("horizvert",$val));
    $showRelation=isset($val["show_relation"]) ? $val["show_relation"] : "";
    $anyfield=isset($val["anyfield"]) ? $val["anyfield"] : "";
    $multimask=in_array("multimask",$val) ? 1 : 0;
    return GenerWidget::generCheckbox($attr,$labels,$val["values"],
                                      $this->base->{$attr},$cols,$horizvert,$showRelation,
                                      $multimask, $lllProp->getAfterField(), $anyfield);
}

function generSelectionField( $attr, $val, &$lllProp )
{
    global $lll;
    
    $s="";
    $size = isset($val["size"]) ? $val["size"] : 1;
    $width = isset($val["width"]) ? $val["width"] : 0;
    if(isset($val["onchange"])) JavaScript::addEvent('#'.$attr, "change", $val["onchange"]);            
    $dependentAttr = isset($val["dependent_attr"]) ? $val["dependent_attr"] : "";
    if( $dependentAttr && isset($this->base->{$dependentAttr}) ) 
    {
        $s.="
            <script LANGUAGE='JavaScript'>
            <!--
            var onChangeDefaultSelected = ".$this->base->{$dependentAttr}.";".
            "\n-->
            </script>
            ";
    }        
    $labels = array();
    $showRelation=isset($val["show_relation"]) ? $val["show_relation"] : "";
    if (isset($val["configvalues"])) {
        $valName=$val["configvalues"];
        global $$valName;
        foreach($$valName as $key => $value) {
            $labels[$value]=$lll[$valName."_".$value];
            $values[$value]=$value;
        }
        $s = GenerWidget::generSelectField($attr,$labels,$values,$attr,$this->base->{$attr},
                                             $size,$width,$showRelation);
    }
    else {
        if( !is_array($val["values"]) && strstr( $val["values"], "\$this->base" ))  eval("\$w=$val[values];");
        else $w = $val["values"];
        $labels =& $lllProp->getSelectLabels($w);
        $s = GenerWidget::generSelectField($attr,$labels,$w,$attr,$this->base->{$attr},
                                             $size,$width,$showRelation);
    }
    if( in_array("selectfilter",$val))
    {
        $s=GenerWidget::generSelectFilterField($attr, $labels, $width).$s;
    }
    return $s;
}

function generClassSelectionField( $attr, $val, &$lllProp )
{
    global $lll;
    
    $size = isset($val["size"]) ? $val["size"] : 1;
    $width = isset($val["width"]) ? $val["width"] : 0;
    if( isset($val["get_values_callback"]) ) 
    {
        eval('$objects=$this->base->'.$val["get_values_callback"].';');
    }
    else
    {
        if( isset($val["query"]) )
        {
            // ha egy fuggvenyt adunk meg query-kent:
            if( !preg_match("{^SELECT.*}", $val["query"]) )  eval("\$query=$val[query];");
            else $query=$val["query"];
        }
        else $query = "SELECT id, $val[labelAttr] FROM @".$val['class'];
        if( isset($val["where"]) ) 
        {
            // ha egy osztalyfuggvenyt adunk meg where feltetelkent: pl. "where"=>"\$this->base->getWhere()"
            if( strstr( $val["where"], "\$this->base" ))  eval("\$w=$val[where];");
            else $w = $val["where"];
            $query.=" WHERE $w";
        }
        if( isset($val["ordered"]) ) $query.=" ORDER BY $val[ordered]";
        if(isset($val["onchange"])) JavaScript::addEvent('#'.$attr, "change", $val["onchange"]);
        $objects = new $val["class"];
        loadObjectsSQL($objects, $query, $objects);
    }
    $labels = array();
    $values = array();
    if( isset($val["nothing selected"]) )
    {
        $values[] = 0;
        $labels[]=$lll[$val["nothing selected"]];
    }
    if( isset($val["labelFormat"]) ) 
    {
        $labelAttrs = split(", *", $val["labelAttr"]);
        $e = "sprintf('$val[labelFormat]'";
        foreach( $labelAttrs as $l ) $e.=", \$obj->$l";
        $e.=")";
    }
    foreach( $objects as $obj )
    {
        $values[]=$obj->id;
        if( $obj->id && isset($val["labelFormat"]) ) 
        {
            eval("\$temp=$e;");
            $labels[]=$temp;
        }
        elseif( $obj->id ) $labels[]=$obj->getAttr($val["labelAttr"]);
        else $labels[]=$lll["nothingSelected"];
    }
    $showRelation=isset($val["show_relation"]) ? $val["show_relation"] : "";
    $s = GenerWidget::generSelectField($attr,$labels,$values,$attr,$this->base->{$attr},
                                         $size,$width,$showRelation);
    if( in_array("selectfilter",$val))
    {
        $s=GenerWidget::generSelectFilterField($attr, $labels, $width).$s;
    }
    return $s;
}

function generMultipleClassSelectionField( $attr, $val, &$lllProp )
{
    global $lll;
    
    $size = isset($val["size"]) ? $val["size"] : 1;
    $width = isset($val["width"]) ? $val["width"] : 0;
    $hasMany=FALSE;
    if( isset($val["get_values_callback"]) ) 
    {
        eval('$objects=$this->base->'.$val["get_values_callback"].';');
    }
    else
    {
        $hasMany = HasMany::construct($this->base, $attr, $val);
        if( isset($val["query"]) )
        {
            // ha egy fuggvenyt adunk meg query-kent:
            if( !preg_match("{^SELECT.*}", $val["query"]) )  eval("\$query=$val[query];");
            else $query=$val["query"];
            //echo $query;
        }
        elseif( $hasMany ) $query = $hasMany->getSelectFieldQuery();
        else $query = "SELECT id, $val[labelAttr] FROM @$val[class]";
        if( isset($val["where"]) ) 
        {
            // ha egy osztalyfuggvenyt adunk meg where feltetelkent: pl. "where"=>"\$this->base->getWhere()"
            if( strstr( $val["where"], "\$this->base" ))  eval("\$w=$val[where];");
            else $w = $val["where"];
            $query.=" WHERE $w";
        }
        if( isset($val["ordered"]) ) $query.=" ORDER BY $val[ordered]";
        //echo $query;
        $objects = new $val["class"];
        loadObjectsSQL($objects, $query, $objects);
    }
    if( in_array("variablesize",$val) )
    {
        $count = count($objects);
        if( isset($val["nothing selected"]) ) $count++;
        $size = $count>$size ? $size : $count;
    }
    $labels = array();
    $values = array();
    if( isset($val["nothing selected"]) )
    {
        $values[] = 0;
        $labels[]=$lll[$val["nothing selected"]];
    }
    if( isset($val["labelFormat"]) ) 
    {
        $labelAttrs = split(", *", $val["labelAttr"]);
        $e = "sprintf('$val[labelFormat]'";
        foreach( $labelAttrs as $l ) $e.=", \$obj->$l";
        $e.=")";
    }
    $default=array();
    foreach( $objects as $obj )
    {
        $values[]=$obj->id;
        if( $obj->id && isset($val["labelFormat"]) ) 
        {
            eval("\$temp=$e;");
            $labels[]=$temp;
        }
        elseif( $obj->id ) $labels[]=$obj->{$val["labelAttr"]};
        else $labels[]=$lll["nothingSelected"];
        if( !empty($obj->selected) ) $default[]=$obj->id;
    }
    if( !$hasMany || 
        get_class($hasMany)=="HasManyWithoutLinkClass" ||
        in_array("overridedefault",$val)) $default = in_array("nodefaultselected",$val) ? 0 : $this->base->{$attr};
    // if( is_array($this->base->{$attr})) 
    // {
        // $default = in_array("nodefaultselected",$val) ? 0 : $this->base->{$attr};
    // }
    // elseif( $this->base->{$attr} ) $default=$this->base->{$attr};
    if(isset($val["onclick"])) JavaScript::addEvent('#'.$attr, "click", $val["onclick"]);
    if(isset($val["onchange"])) JavaScript::addEvent('#'.$attr, "change", $val["onchange"]);
    $showRelation=isset($val["show_relation"]) ? $val["show_relation"] : "";
    $anyfield=isset($val["anyfield"]) ? $val["anyfield"] : "";
    $asmSelect=isset($val["asmselect"]) ? $val["asmselect"] : "";
    $asmSelectLabel=isset($val["asmselect_label"]) ? $val["asmselect_label"] : "";
    $s = GenerWidget::generMultipleSelection($attr,$labels,$values,$default,
                                               $size,$width,$showRelation, $anyfield, $asmSelect, $asmSelectLabel);
    if( in_array("selectfilter",$val))
    {
        $s=GenerWidget::generSelectFilterField($attr, $labels, $width).$s;
    }
    return $s;
}

function generDateField( $attr, $val )
{
    return GenerDateWidget::generSimpleDateField($attr,$this->base->{$attr},FALSE,$val);
}

function generTimeField( $attr, $val )
{
    return GenerDateWidget::generSimpleDateField($attr,$this->base->{$attr},TRUE,$val);
}

function generBoolField( $attr, $val )
{
    if( !isset($this->base->{$attr}) ) $this->base->{$attr}=FALSE;
    $showRelation=isset($val["show_relation"]) ? $val["show_relation"] : "";
    return GenerWidget::generBoolField($attr,$attr, $this->base->{$attr}, 1, $showRelation);
}

function generRadioField( $attr, $val, &$lllProp )
{
    global $gorumroll;
    
    $labels =& $lllProp->getSelectLabels($val["values"]);
    $showRelation=isset($val["show_relation"]) ? $val["show_relation"] : "";
    // Huu de csunya:
    if( in_array("nodefault",$val) &&
        $gorumroll->method=="create_form" &&
        !isset($_POST[$attr]) &&
        !$this->base->{$attr} ) $default = -1;
    else $default=$this->base->{$attr};
    return GenerWidget::generRadioField($attr,$labels,$val["values"],$default,
                                        $val["cols"],$showRelation);
}

function generUrlField( $attr, $val )
{
    $this->getTextFieldLengths( $val, $inputLength, $fieldLength );
    return GenerWidget::generUrlField($attr,$this->base->{$attr},$inputLength,$fieldLength);
}

function generVoiceField( $attr, $val )
{
    return GenerVoiceWidget::generVoiceField($attr);
}

function addJavaScripts()
{
    if( isset($this->typ["jscripts"]) )
    {
        if( is_array($this->typ["jscripts"]) )
        {
            foreach( $this->typ["jscripts"] as $script ) JavaScript::addScript($script());
        }
        else
        {
            $script = $this->typ["jscripts"];
            JavaScript::addScript($script());
        }
    }
}

function generRedirectForm(&$base)
{
    global $gorumroll, $scriptName;
    
    $ctrl = new AppController(array("method"=>str_replace("_form","",$gorumroll->method)));
    $hiddens = $ctrl->generHiddenFields();
    $typ =& $base->getTypeInfo();
    $attributeList = array_keys($typ["attributes"]);
    for( $i=0; $i<count($attributeList); $i++ )
    {
        $attr = $attributeList[$i];
        if( !($val = & $typ["attributes"][$attr]) ) continue;
        $visibility = $base->getVisibility( $val, $attr );
        if( $visibility==Form_hidden ) $hiddens.=GenerWidget::generHiddenField($attr,$base->{$attr});
    }
    return "
    <form action='$scriptName' method='post' name='frm'>
        $hiddens
    </form>
    <script language='JavaScript'>
        document.frm.submit();
    </script>";
}

} // end class
?>
