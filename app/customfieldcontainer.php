<?php
defined('_NOAH') or die('Restricted access');

class CustomFieldContainer extends Object
{

var $fields=0;

// The id that identifies the group of customfields that belongs to this object.
// (In case of Item, this is the "cid" field, in case of User, this is 0)
function getCid()
{
    return 0;
}

// Find a field by columnIndex:
function getField( $which )
{
    $fields = $this->getFields();
    foreach( $fields as $field ) if( $field->columnIndex==$which ) return $field;
    return FALSE;
}

// Find a field value by name:
function get( $which )
{
    $fields = $this->getFields();
    foreach( $fields as $field ) if( $field->name==$which ) return $this->{$field->columnIndex};
    return "";
}

// Set a field value by name:
function set( $which, $value )
{
    $fields = $this->getFields();
    foreach( $fields as $field ) if( $field->name==$which ) $this->{$field->columnIndex}=$value;
}

function showNewTool($rights)
{
    global $gorumroll, $lll;

    // csak a kategoriahoz tartozo adok listaja eseten tesszuk ki:
    $s="";
    hasAdminRights( $isAdm );
    if( $gorumroll->list==$this->get_table() && $isAdm )
    {
        $ctrl = new AppController($this->getCustomFieldClass() . "/sortfield_form/$gorumroll->rollid");
        $s=$ctrl->generAnchor($lll["customFields"]);
    }
    return $s;
}

function showListVal($attr, $format="", $absolute=FALSE, $fromGetEmailParams=FALSE)
{
    global $gorumroll, $lll, $applyCodeBlockSubstitution, $gorumuser, $gorumrecognised;

    $s=FALSE;
    if( ($s=parent::showListVal($attr, "", $absolute))!==FALSE )
    {
        return $s;
    }
    elseif ($attr=="description") {
        $s=$this->getDescription();
    }
    elseif( $attr=="creationtime" )
    {
        $s = $this->showDateField($attr, TRUE);
    }
    elseif( preg_match("/col_\d+/", $attr) || $attr=="id" ) // ha valtozo mezorol van szo
    {
        $typ =& $this->getTypeInfo(TRUE);
        $attrInfo =& $typ["attributes"][$attr];
        $field = $this->getField($attr);
        if( in_array("text", $attrInfo) || in_array("textarea", $attrInfo) )
        {
            if( $this->{$attr}==="" ) $s="";
            else
            {
                if (in_array("allow_html", $attrInfo)) 
                {
                    $s = $this->getAttr($attr);
                    if( !empty($applyCodeBlockSubstitution) ) $s = $this->applyCodeBlockSubstitution($s);
                }
                else  $s=nl2br(htmlspecialchars($this->getAttr($attr)));
                if( $field->subType==customfield_integer && $field->thousandsSeparator )
                {
                    $s = number_format( $s, 0, '', $field->getAttr("thousandsSeparator") );
                }
                if( $field->subType==customfield_float )
                {
                    $s = number_format( $s, $field->precision, $field->getAttr("precisionSeparator"), $field->getAttr("thousandsSeparator") );
                }
                if( $field->formatPrefix ) $s = $field->getAttr("formatPrefix").$s;
                if( $field->formatPostfix ) $s = $s.$field->getAttr("formatPostfix");
                if( $field->format )
                {
                    // ha definialva van egy spec formatum, akkor alkallmazzuk:
                    $s = sprintf( $field->getAttr("format"), $s );
                }
                $this->applyDisplayLengthLimit( $s, $attrInfo );
                if( in_array("titleTag", $attrInfo) && $gorumroll->method == "showhtmllist" )
                {
                    $ctrl = $this->getLinkCtrl($this->$attr);
                    $s = $ctrl->generAnchor($s, "", $absolute, "", FALSE);
                }
                elseif( !in_array("allow_html", $attrInfo))
                {
                    $s=preg_replace_callback('{((https?://[\w-]+)|(www))\.[\w\.-]+}i', create_function(
                                    '$matches',
                                    '$prefix = strcasecmp($matches[1], "www") ? "" : "http://";
                                     return "<a href=\'$prefix$matches[0]\' target=\'_blank\'>$matches[0]</a>";'),  $s);
                    $s=preg_replace('{\b[\w.%+-]+@[\w.-]+\.[A-Za-z]{2,4}\b}', '<a href=\'mailto:$0\'>$0</a>', $s); 
                }
                if( $field->useVariableSubstitution && !$fromGetEmailParams ) $this->variableSubstitution($s, $attr);
            }
        }
        elseif( in_array("bool", $attrInfo) )
        {
            $s = $this->{$attr} ? $lll["yes"] : $lll["no"];
        }
        elseif( in_array("url", $attrInfo) )
        {
            // htmlspecialchars nelkul:
            @$s = $this->{$attr};
        }
        elseif( in_array("selection", $attrInfo) || in_array("multipleselection", $attrInfo) || in_array("checkbox", $attrInfo) )
        {
            $s = $this->displayEnumValue($attr);
        }
        elseif( in_array("media", $attrInfo) )
        {
            if( $this->{$attr} )
            {
                $s="<a href='".$this->getUploadDir()."/$this->id"."_".$this->{$attr}."' target='_blank'>".
                   htmlspecialchars($this->{$attr})."</a>";
            }
            else $s="";
        }
        elseif( in_array("file", $attrInfo) )
        {            
            $picInfo = $this->showPicture($attr, "medium", FALSE, $absolute);
            $s = $picInfo["tag"];
        }
        elseif( in_array("date", $attrInfo) )
        {
            $s = $this->showDateField($attr, TRUE); 
        }
        else
        {
            $s=parent::showListVal($attr, "safetext");
        }
    }
    return $s;
}

function applyCodeBlockSubstitution($s)
{
    $s = preg_replace_callback('/(\<code class="[^"]+"\>)(.*)(\<\/code\>)/isU', 
                               create_function('$m', 'return $m[1].htmlspecialchars($m[2]).$m[3];'), 
                               $s, -1, $count);
    if( $count )
    {
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/chili/jquery.chili-2.2.js");
        JavaScript::addScript('ChiliBook.recipeFolder = "'. GORUM_JS_DIR . '/jquery/chili/";');
        JavaScript::addCss(GORUM_JS_DIR . "/jquery/chili/chili.css");
    }
    return $s;
}

function showDateField($attr, $ignoreHour=FALSE )
{
    if( empty($this->{$attr}) ) return "";
    elseif( is_string($this->{$attr}) ) $attr = new Date($this->{$attr});
    else $attr =& $this->{$attr};
    if( $ignoreHour ) $attr->setIgnoreHour(TRUE);
    return $attr->format();
}

function applyDisplayLengthLimit( &$s, &$attrInfoOrDisplayLength )
{
    global $gorumroll;
    
    $dl = is_array($attrInfoOrDisplayLength) && isset($attrInfoOrDisplayLength["displaylength"]) ? 
          $attrInfoOrDisplayLength["displaylength"] : (is_array($attrInfoOrDisplayLength) ? 0 : $attrInfoOrDisplayLength);
    if( $dl && $gorumroll->method=="showhtmllist")
    {
        if( strlen($s)>$dl )
        {
            $arr = split(" ", $s);
            $count=0;
            $s="";
            foreach( $arr as $i )
            {
                if( ($count+=strlen($i))<$dl ) $s.="$i ";
                else break;
            }
            $s.="...";
        }
    }
}

function variableSubstitution(&$s, $attr)
{
    $this->prepareVariableSubstitutionRules( $patterns, $replacements, FALSE, FALSE, $attr, FALSE );
    $s = preg_replace( $patterns, $replacements, $s );
}

function prepareVariableSubstitutionRules( &$patterns, &$replacements, $withOwner=TRUE, $extraParams=TRUE, $excludeAttr=0, $encode=TRUE )
{
    $this->getEmailParams( $params, FALSE, $withOwner, $extraParams, $excludeAttr );
    $patterns = $replacements = array();
    foreach( $params as $key=>$value ) 
    {
        if( is_array($value) )
        {
            foreach( $value as $ownerKey=>$ownerValue )
            {
                $patterns[]="/{(owner:)?\s*$ownerKey\s*}/i";
                $replacements[]= $encode ? htmlspecialchars(strip_tags(nl2br($ownerValue))) : $ownerValue;
            }
        }
        else
        {
            $patterns[]="/{(item:)?\s*$key\s*}/i";
            $replacements[]= $encode ? htmlspecialchars(strip_tags(nl2br($value))) : $value;
        }
    }
}

function showPicture( $attr, $thSize="medium", $noHref=FALSE, $absolute=FALSE )
{
    global $thumbnailSizes, $gorumroll;
    
    $picInfo = array();
    if( !isset($thumbnailSizes[$thSize]) ) $thSize = "medium";
    if( $this->{$attr} )
    {
        $picName = $this->getPicName($attr);
        if( file_exists($picName) )
        {
            $thName = $this->getThumbnailName($width, $height, $attr, $thSize);
            if( $thSize=="small" )
            {
                shrinkPicture($largeWidth, $largeHeight,$thumbnailSizes["large"]["width"],
                              $thumbnailSizes["large"]["height"], $picName );
                $dim = "rel='{$largeWidth}x{$largeHeight}'";
            }
            else $dim="";
            $base = $absolute ? Controller::getBaseUrl() : "";
            $img = "<img src='$base$thName' width='$width' height='$height' border='0' $dim>";
            if( !$noHref )
            {
                // ha eppen az ad details page-en vagyunk, akkor a kepre kattintva a teljes meretu kep jelenik meg - kulonben az ad details page-e:
                if( $gorumroll->method=="showdetails" && $gorumroll->rollid==$this->id )
                {
                    $s="<a class='picture thickbox' href='$base$picName' rel='thickbox_group'>$img</a>";
                }
                else 
                {
                    $ctrl = $this->getLinkCtrl();
                    $s="<a class='picture' href='".$ctrl->makeUrl($absolute)."'>$img</a>";
                }
                if( $gorumroll->method=="showhtmllist" ) $s = "<div class='picture'>$s</div>";
            }
            else $s = $img;
            $picInfo["width"] = $width;
            $picInfo["height"] = $height;
        }
        else $s= $gorumroll->method=="showhtmllist" ? $this->showEmptyPicture() : "";
    } elseif (($this->oodleType) && ($thSize=="medium")) $s=$this->showOodlePicture();
    else $s= $gorumroll->method=="showhtmllist" ? $this->showEmptyPicture() : "";
    $picInfo["tag"] = $s;
    return $picInfo;
}

function getPicName($attr, $thSize='')
{
    $index = split("_", $attr);
    $index = $index[1];
    $th = $thSize ? "th_{$thSize}_" : "";
    return $this->getPicDir() . "/$th{$this->id}_$index.".$this->{$attr};
}

function getThumbnailName(&$width, &$height, $attr, $thSize)
{
    global $thumbnailSizes;
    
    if( file_exists($thName = $this->getPicName($attr, $thSize)) || 
        file_exists($thName = $this->getPicName($attr, $this->id) ))  // alternative thumbnail naming for 1.3 backward compatibility
    {
        $size = getimagesize( $thName );
        $width = $size[0];
        $height = $size[1];
    }
    else  // no GD
    {
        $thName = $this->getPicName($attr);
        shrinkPicture($width, $height,$thumbnailSizes[$thSize]["width"],
                      $thumbnailSizes[$thSize]["height"], $thName );
    }
    return $thName;
}

function showOodlePicture($picOnly=FALSE)
{

    $oodlePower = NOAH_BASE.'/oodle/powered_by_oodle.gif';

    if ($this->oodleImageUrl=='') return $this->showEmptyPicture();

    if ($picOnly) {
         $img = "<div class='picture'><img src='$this->oodleImageUrl' width='187' height='140'/></div>"; //<br><img src='$oodlePower' />
        $s = $img;
    } else
    {
         $img = "<div class='picture'><img src='$this->oodleImageUrl' width='120' height='90'/></div>"; //<br><img src='$oodlePower' />
        $ctrl = $this->getLinkCtrl();
        $s="<a class='picture' href='".$ctrl->makeUrl($absolute)."'>$img</a>";
    }
    return $s;
}

function showEmptyPicture()
{
    global $lll;
    return "<div class='picture'>$lll[noPicture]</div>";
}

function setDefaultsOfFieldsThatDontAppearInForm()
{
    $typ =& $this->getTypeInfo(TRUE);
    foreach( $typ["attributes"] as $attr=>$val )
    {
        if( !isset($this->$attr) && isset($val["default"]) ) $this->$attr = $val["default"];
    }
}

function getSpecialSortAttrs($isCommon=0, $cid=0)
{    
    $sorting = new Sorting($this);
    $sortAttrs = $sorting->getAttrs();
    $s = "";
    foreach( $sortAttrs as $attr )
    {
        CustomField::getSortType($sortType, $sortSqlAttr, $isCommon, $cid, $attr);
        if( $sortType==customfield_integer )
        {
            $s.= ", 0+$sortSqlAttr AS $attr";
        }
        elseif( $sortType==customfield_float ) 
        {
            $s.= ", 0.0+$sortSqlAttr AS $attr";
        }
        elseif( $sortType==customfield_date ) 
        {
            $s.= ", IFNULL(CAST($sortSqlAttr AS DATE), '') AS $attr";
        }
    }
    return $s;
}

function activateVariableFields()
{
    global $lll, $defaultPrecisionSeparator, $gorumroll;

    $typ =& $this->getTypeInfo(TRUE);
    hasAdminRights($isAdm);
    if( empty($this->cid ) && !is_a($this, "user") && empty($this->fields) ) $fields = ItemField::getFixAndCommonFields();
    else $fields = $this->getFields();
    $typ["order"] = array_keys($typ["attributes"]);
    for( $i=0; $i<count($fields); $i++ )
    {
        $v = & $fields[$i];
        // juzer fieldek nem lehetnek formban:
        if( $gorumroll->method=="create" && !empty($v->userField) ) continue; 
        // ha mar benne van, kivesszuk, hogy a sorrend stimmeljen:
        if( ($key=array_search($v->columnIndex, $typ["order"]))!==FALSE ) unset($typ["order"][$key]);
        $typ["order"][]=$v->columnIndex;
        if( !isset($typ["attributes"][$v->columnIndex]) ) $typ["attributes"][$v->columnIndex] = array("type"=>"TEXT");
        $attrInfo = & $typ["attributes"][$v->columnIndex];
        $attrInfo["fieldIndex"] = "$i";
        $lll[$this->get_table()."_$v->columnIndex"]=$v->getAttr("name");
        //echo($this->get_table()."_$v->columnIndex<br>");
        //var_dump($lll[$this->get_table()."_$v->columnIndex"]);
        if( $v->mandatory )
        {
            $attrInfo[]="mandatory";
            $attrInfo["min"]="1";
        }
        if( $v->rowspan ) $attrInfo[]="rowspan";
        if( $v->innewline ) $attrInfo[]="in new line";
        if( $v->customListPlacement ) $attrInfo[]="customListPlacement";
        if( $v->customDetailsPlacement ) $attrInfo[]="customDetailsPlacement";
        if( $v->css ) $attrInfo["customCss"]=$v->css;
        if( $v->sortable )
        {
            $attrInfo[]="sorta";
            if( $v->subType==customfield_integer || $v->subType==customfield_float ) $attrInfo[]="sortasint";
        }
        if( !$v->displayLabel ) $attrInfo[]="widecontent_details";
        if( $v->detailsPosition!=customfield_normal )
        {
            if( $v->detailsPosition==customfield_topright ) $attrInfo["sidebar"]="top";
            elseif( $v->detailsPosition==customfield_bottomright ) $attrInfo["sidebar"]="bottom";
        }
        if( $v->expl && !isset($lll[$lllLabel = $this->get_table()."_$v->columnIndex"."_expl"]) ) $lll[$lllLabel]=$v->getAttr("expl");
        
        if( $gorumroll->method=="showdetails" ) $v->displayInDetails( $attrInfo, isset($this->ownerId) ? $this->ownerId : 0 );
        elseif( $gorumroll->method=="showhtmllist" ) $v->displayInList( $attrInfo );
        else $v->displayInForm($attrInfo);
        
        switch( $v->type )
        {
        case customfield_text:
            $attrInfo[]="text";
            $attrInfo["default"]=$v->default;
            $attrInfo["subtype"]=$v->subType;
            if( $v->format ) $attrInfo["format"]=$v->format;
            if( $v->allowHtml ) $attrInfo[]="allow_html";
            if( $v->seo==customfield_title ) $attrInfo[]="titleTag";
            if( $v->seo==1 ) $attrInfo[]="descriptionTag";
            if( $v->seo==customfield_keywords ) $attrInfo[]="keywordsTag";
            if( $v->displaylength ) $attrInfo["displaylength"]=$v->displaylength;
            if( $v->subType==customfield_integer ) $attrInfo["filterCharacters"]="numeric()";
            if( $v->subType==customfield_float ) $attrInfo["filterCharacters"]="numeric({allow:'$defaultPrecisionSeparator'})";
            break;
        case customfield_textarea:
            $attrInfo[]="textarea";
            $attrInfo["default"]=$v->default;
            $attrInfo["rows"]=10;
            if( $v->allowHtml ) $attrInfo[]="allow_html";
            if( $v->displaylength ) $attrInfo["displaylength"]=$v->displaylength;
            if( $v->seo==customfield_title ) $attrInfo[]="titleTag";
            if( $v->seo==customfield_description ) $attrInfo[]="descriptionTag";
            if( $v->seo==customfield_keywords ) $attrInfo[]="keywordsTag";
            if( $v->useMarkitup )
            {
                $attrInfo["markitup"]=array("set"=>"ad_html");
                if ($v->useMarkitupSimple)  $attrInfo[]="markitupsimple";
                $attrInfo[]="widecontent_form";
            }
            else $attrInfo["cols"]=50;
            break;
        case customfield_bool:
            $attrInfo[]="bool";
            $attrInfo["default"]=$v->default;
            break;
        case customfield_selection:
            $attrInfo[]="selection";
            $v->activateEnumAttrInfo( $attrInfo, $this->get_table(), $v->columnIndex );
            break;
        case customfield_multipleselection:
            $attrInfo[]="multipleselection";
            $count = $v->activateEnumAttrInfo( $attrInfo, $this->get_table(), $v->columnIndex );
            if( $count ) $attrInfo["size"]=min(10, $count);
            break;
        case customfield_checkbox:
            $attrInfo[]="checkbox";
            $attrInfo["cols"]=$v->checkboxCols;
            $v->activateEnumAttrInfo( $attrInfo, $this->get_table(), $v->columnIndex );
            break;
        case customfield_separator:
            $attrInfo[]="section";
            $attrInfo["name"]=$v->name;
            if( !isset($lll[$v->columnIndex]) ) $lll[$v->columnIndex]=$v->getAttr("name");
            break;
        case customfield_picture:
            $attrInfo[]="file";
            $attrInfo["name"]=$v->name;
            $lll[$v->columnIndex] = $v->getAttr("name");
            if( !empty($v->mainPicture) ) $attrInfo[]="pictureTag";
            break;
        case customfield_media:
            $attrInfo[]="file";
            $attrInfo[]="media";
            $attrInfo["name"]=$v->name;
            $lll[$v->columnIndex] = $v->getAttr("name");
            break;
        case customfield_url:
            $attrInfo[]="url";
            $attrInfo["length"]=20;
            break;
        case customfield_date:
            $attrInfo["type"]="DATETIME";
            $attrInfo["prototype"]="date";
            $attrInfo["format"]="([0-9]{4})-([0-9]{2})-([0-9]{2})$";
            $attrInfo["order"]=array("year", "month", "day");
            $attrInfo["display_format"]="Y-m-d";
            $attrInfo["length"]=16;
            $attrInfo[]="jscalendar";
            $attrInfo[]="datetext";
            $attrInfo["fromyear"]=$v->fromyear ? $v->fromyear : "now";
            $attrInfo["toyear"]=$v->toyear ? $v->toyear : "now";
            if( $v->dateDefaultNow ) $attrInfo[]="defaultnow";
        default:
            break;
        }
    }
    if( !isset($typ["listOrder"]) ) $typ["listOrder"] = $typ["order"];
}

function hasCaptchaInForm()
{
    if( $ret = $this->hasCaptcha("_form") )
    {
        $typ = & $this->getTypeInfo();
        // ha mar benne van, kivesszuk, hogy a sorrend stimmeljen:
        if( isset($typ["order"]) )
        {
            if( ($key=array_search("captchaField", $typ["order"]))!==FALSE ) unset($typ["order"][$key]);
            $typ["order"][]="captchaField";
        }
    }
    return $ret;
}

function iterateNonUserFieldAndDoSomething( $what )
{
    $typ =& $this->getTypeInfo(TRUE);
    foreach( $this->getFields() as $field )
    {
        if( !empty($field->userField) || !isset($typ["attributes"][$field->columnIndex]) ) continue;
        $attrInfo = & $typ["attributes"][$field->columnIndex];
        // a core fg-nek TRUE-t kell visszaadni az iteracio leallitasara,
        // es ez a fg is TRU-val jelzi, hogy az iteracio felbeszakadt
        if( $ret = $this->$what($attrInfo, $field) ) return TRUE;
    }
}

function delete( $whereFields="" )
{    
    $this->getCid();
    $this->activateVariableFields();
    load($this);
    $this->iterateNonUserFieldAndDoSomething("deleteCore");
    parent::delete($whereFields);
}

function deleteCore( $attrInfo, &$field )
{
    global $thumbnailSizes;
    
    $ind = substr( $field->columnIndex, 4 );
    if( in_array("media", $attrInfo) && $this->{$field->columnIndex}) // ha media tipusu
    {
        $ret=@unlink($this->getUploadDir() . "/{$this->id}_".$this->{$field->columnIndex});
    }
    elseif( in_array("file", $attrInfo) && $this->{$field->columnIndex}) // ha picture tipusu
    {
        $ret=@unlink($this->getPicDir() . "/{$this->id}_$ind.".$this->{$field->columnIndex});
        $ret=@unlink($this->getPicDir() . "/th_{$this->id}_$ind.".$this->{$field->columnIndex});
        foreach( $thumbnailSizes as $thName=>$dimensions )
        {
            $ret=@unlink($this->getPicDir() . "/th_{$thName}_{$this->id}_$ind.".$this->{$field->columnIndex});
        } 
    }
}

function valid()
{
    return $this->iterateNonUserFieldAndDoSomething("validCore");
}

function validCore($attrInfo, &$field)
{
    global $lll;

    if( in_array("file", $attrInfo) ) // ha picture, v. media tipusu
    {
        if( in_array("media", $attrInfo) ) $this->validMedia($field->columnIndex);
        else $this->validPicture($field->columnIndex);
        if( Roll::isFormInvalid() )
        {
            Roll::addInfoText("whichPictureAttribute", $lll[$field->columnIndex]);
            return TRUE;  // to stop iteration
        }
    }
}

function checkMandatoryFileUpload()
{
    return $this->iterateNonUserFieldAndDoSomething("checkMandatoryFileUploadCore");
}

function checkMandatoryFileUploadCore($attrInfo, &$field)
{
    if( in_array("mandatory", $attrInfo) &&
        ((in_array("file", $attrInfo) && empty($_FILES[$field->columnIndex]["name"])) ||
        (in_array("bool", $attrInfo) && !$this->{$field->columnIndex})) )
    {
        Roll::setFormInvalid("mandatoryField", $field->showListVal("name"));
        return TRUE;  // to stop iteration
    }
}

function storeAttachment()
{
    $this->iterateNonUserFieldAndDoSomething("storeAttachmentCore");
}

function storeAttachmentCore($attrInfo, &$field)
{
    if( in_array("file", $attrInfo) ) // ha picture, v. media tipusu
    {
        if( in_array("media", $attrInfo) ) $this->storeOneMedia($field->columnIndex, substr($field->columnIndex, 4));
        else $this->storeOnePicture($field->columnIndex, substr($field->columnIndex, 4));
    }
}

function validPicture($attr)
{
    if (!isset($_FILES[$attr]["name"]) || $_FILES[$attr]["name"]=="") return;
    if ($_FILES[$attr]["size"]==0) return Roll::setFormInvalid("picFileSizeNull");
    if ($_FILES[$attr]["tmp_name"]=="none") return Roll::setFormInvalid("picFileSizeToLarge1");
    $_S = new AppSettings();
    if ($_S->maxPicSize && $_FILES[$attr]["size"]>$_S->maxPicSize) 
    {
        return Roll::setFormInvalid("picFileSizeToLarge2", $_S->maxPicSize);
    }
    if (!is_uploaded_file($_FILES[$attr]["tmp_name"]))
    {
        handleError("Possible attack");
    }
    $fname=$_FILES[$attr]["tmp_name"];
    $size = getimagesize( $fname );
    if (!$size) return Roll::setFormInvalid("notValidImageFile");
    $type = $size[2]; // az image tipus, 1=>GIF, 2=>JPG, 3=>PNG
    $extensions = array("", "gif", "jpg", "png");
    if (!isset($extensions[$type]) ) return Roll::setFormInvalid("notValidImageFile");
    if( ($_S->maxPicWidth && $size[0]>$_S->maxPicWidth) || ($_S->maxPicHeight && $size[1]>$_S->maxPicHeight) )
    {
        return Roll::setFormInvalid("picFileDimensionToLarge", $_S->maxPicWidth, $_S->maxPicHeight);
    }
    if( ($_S->downsizeWidth>0 || $_S->downsizeHeight>0) && $this->imageUploadExceedsMemory($size) )
    {
        return Roll::setFormInvalid("picFileDimensionExceedsMemory");
    }
}

function validMedia($attr)
{
    if (!isset($_FILES[$attr]["name"]) || $_FILES[$attr]["name"]=="") return;
    if ($_FILES[$attr]["size"]==0) return Roll::setFormInvalid("picFileSizeNull");
    if ($_FILES[$attr]["tmp_name"]=="none") return Roll::setFormInvalid("picFileSizeToLarge1");
    $_S = new AppSettings();
    if ($_S->maxMediaSize && $_FILES[$attr]["size"]>$_S->maxMediaSize) 
    {
        return Roll::setFormInvalid("picFileSizeToLarge2", $_S->maxMediaSize);
    }
    if (!is_uploaded_file($_FILES[$attr]["tmp_name"])) handleError("Possible attack");
}

function storeOnePicture($attr, $i=0)
{
    global $thumbnailSizes;

    if (empty($_FILES[$attr]["name"]) ) return ok;
    $fname=$_FILES[$attr]["tmp_name"];
    if( !($f=fopen($fname,"r")) ) 
    {
        $attErrTxt = "Error opening attached file!";
        return nok;
    }
    $extensions = array("", "gif", "jpg", "png");
    $info = getimagesize( $fname );
    $type = $info[2]; // az image tipus, 1=>GIF, 2=>JPG, 3=>PNG
    $ext = $extensions[$type];
    $_S = new AppSettings();
    if( $this->imageResizeSupported($info) )
    {
        foreach( $thumbnailSizes as $thSize=>$dimensions )
        {
            if( $this->imageUploadExceedsMemory($info) )
            {
                if( $this->ext ) // deleting the old thumbnail if exists:
                {
                    $th_old_name = $this->getPicDir() . "/th_{$thSize}_{$this->id}_$i.".$this->{"col_$i"};   // pictures/ads/th_medium_2345_5.jpg
                    @unlink($th_old_name);
                }
            }
            else $this->downsizeImage($dimensions['width'], $dimensions['height'], $info, $fname, "th_{$thSize}_{$this->id}_$i.$ext");
        }
        if( ($_S->downsizeWidth>0 || $_S->downsizeHeight>0) && !$this->imageUploadExceedsMemory($info) )
        {
            $this->downsizeImage($_S->downsizeWidth, $_S->downsizeHeight, $info, $fname, "{$this->id}_$i.$ext");
            $downsized = TRUE;
        }
        else $downsized = FALSE;
    }
    if( !$downsized )
    {
        move_uploaded_file($fname, $foname = $this->getPicDir() . "/$this->id"."_$i.".$ext);
        // attempt to chmod the file, so that an FTP user can have read and write access to it, too:
        chmod($foname, 0666);
    }
    // A picture-ben csak azt taroljuk el, hogy mi a kiterjesztes:
    executeQuery( "UPDATE @" . $this->get_table() . " SET `attr`=#ext# WHERE id=#this->id#", $attr, $ext, $this->id );
    $_FILES[$attr]["name"]="";
}

function imageResizeSupported($info)
{
    if( defined("IMG_GIF") && function_exists("ImageTypes"))//van GD
    {
        $checkBits = array(0, IMG_GIF, IMG_JPG, IMG_PNG);
        return isset($checkBits[$info[2]]) && ((ImageTypes() & $checkBits[$info[2]]));
    }
    return FALSE;
}

function imageUploadExceedsMemory($info)
{
    $memoryLimit = byteStr2num(ini_get('memory_limit'));
    if( function_exists('memory_get_usage') && $memoryLimit && $memoryLimit!=-1 /* unlimited */ )
    {
        $channels = isset($info['channels']) ? $info['channels'] : 1;  // png has no channels
        $memoryNeeded = Round(($info[0] * $info[1] * $info['bits'] * $channels / 8 + Pow(2, 16)) * 1.65);
        $usage = memory_get_usage();
        //FP::log("Current usage: $usage, limit: $memoryLimit, new to allocate: $memoryNeeded, rest after allocate: ". ($memoryLimit-$usage-$memoryNeeded));
        // skipping if ImageCreate would exceed the memory limit:
        return $usage + $memoryNeeded > $memoryLimit; 
    }
    return FALSE;
}

function downsizeImage($width, $height, $info, $sourceFile, $destFile)
{
    $create_fg = array("", "ImageCreateFromGIF", "ImageCreateFromJPEG", "ImageCreateFromPNG");
    $save_fg = array("", "ImageGIF", "ImageJPEG", "ImagePNG");

    shrinkPicture($newWidth, $newHeight, $width, $height, $sourceFile );
    $src_im = $create_fg[$info[2]]($sourceFile);
    $dst_im = ImageCreateTrueColor ($newWidth, $newHeight);
    imagecopyresampled ($dst_im, $src_im, 0, 0, 0, 0, $newWidth, $newHeight, $info[0], $info[1]);
    $th_foname = $this->getPicDir() . "/$destFile";
    $save_fg[$info[2]]( $dst_im, $th_foname );
    // attempt to chmod the file, so that an FTP user can have read and write access to it, too:
    chmod($th_foname, 0666);
    imagedestroy($src_im);
}

function storeOneMedia($attr, $i=0)
{
    if (!isset($_FILES[$attr]["name"]) || $_FILES[$attr]["name"]=="") return;
    $tmp=$_FILES[$attr]["tmp_name"];
    $name = $_FILES[$attr]["name"];
    $uploadFile = $this->getUploadDir() . "/$this->id"."_$name";
    if( !move_uploaded_file($tmp, $uploadFile)) return;
    // ha modify-rol van szo, akkor toroljuk a regi media file-t:
    if( isset($this->{"$attr"}) && $this->{"$attr"} )
    {
        @unlink($this->getUploadDir() . "/$this->id"."_".$this->{"$attr"});
    }
    // attempt to chmod the file, so that an FTP user can have read and write access to it, too:
    chmod($uploadFile, 0666);
    executeQuery( "UPDATE @" . $this->get_table() . " SET `attr`=#name# WHERE id=#this->id#", $attr, $name, $this->id );
    $_FILES[$attr]["name"]="";
}

function addDeletePictureStuff()
{
    global $lll;
    
    foreach( $this->getFields() as $field )
    {
        if( $field->type!=customfield_picture || empty($this->{$field->columnIndex}) ) continue;
        $picture = $this->getThumbnailName($width, $height, $field->columnIndex, "small");
        $ctrl = new AppController($this->get_class()."/delete_picture/{$this->id}_$field->columnIndex");
        $deleteLink = $ctrl->generAnchor($lll["deletePicture"]); 
        $lll["{$field->columnIndex}_embedfield"] = "
        <table id='deletePicture_$field->columnIndex' style='width: 10px;'>
          <tr>
            <td>%s</td>
            <td rowspan='2' class='deleteAfterSuccess' style='padding-left: 10px'>
              <img src='$picture', width='$width' height='$height'>
            </td>
          </tr>
          <tr class='deleteAfterSuccess'>
            <td>$deleteLink</td>
          </tr>
        </table>";
        JavaScript::addOnload("
            $('#deletePicture_$field->columnIndex a').click(function (){
                $.get(this.href, function(){
                    $('#deletePicture_$field->columnIndex .deleteAfterSuccess').remove();
                });
                return false;
            });    
        ");
    }
}

function deletePicture()
{
    global $thumbnailSizes;

    $fileNameBase = $this->deletePictureOrMedia();
    @unlink($this->getPicDir() . "/$fileNameBase");
    @unlink($this->getPicDir() . "/th_$fileNameBase");
    foreach( $thumbnailSizes as $thName=>$dimensions )
    {
        @unlink($this->getPicDir() . "/th_{$thName}_$fileNameBase");
    } 
    die();
}

function addDeleteMediaStuff()
{
    global $lll;
    
    foreach( $this->getFields() as $field )
    {
        if( $field->type!=customfield_media || empty($this->{$field->columnIndex}) ) continue;
        $ctrl = new AppController($this->get_class()."/delete_media/{$this->id}_$field->columnIndex");
        $deleteLink = $ctrl->generAnchor($lll["deleteMedia"]); 
        $lll["{$field->columnIndex}_afterfield"] = "<p id='deleteAfterSuccess_$field->columnIndex'>$deleteLink</p>";
        JavaScript::addOnload("
            $('.cell[name=\"$field->columnIndex\"] a').click(function (){
                $.get(this.href, function(){
                    $('#deleteAfterSuccess_$field->columnIndex').remove();
                });
                return false;
            });    
        ");
    }
}

function deleteMedia()
{
    $fileNameBase = $this->deletePictureOrMedia(FALSE);
    unlink($this->getUploadDir() . "/$fileNameBase");
    die();
}

function deletePictureOrMedia($isPicture=TRUE)
{
    global $gorumrecognised, $gorumuser, $gorumroll;

    hasAdminRights($isAdm);
    $parts = explode("_", $gorumroll->rollid);
    $this->id = $parts[0];
    $className = $this->get_class();
    $attr = quoteSQL("$parts[1]_$parts[2]");
    CustomField::addCustomColumns($className);
    load($this);
    if( $isAdm || ($className=="item" && $gorumrecognised && $gorumuser->id==$this->ownerId) )
    {
        executeQuery("UPDATE @$className SET `attr`='' WHERE id=#id#", $attr, $this->id);
    }
    else die();
    return $isPicture ? "{$this->id}_$parts[2].".$this->$attr : "{$this->id}_".$this->$attr;
}

function getLinkCtrl($title="")
{
    $ctrl = new AppController($this->get_class() . "/$this->id");
    return $ctrl;
}

function getEmailParamsCore(&$params, $excludeAttr=0)
{
    foreach( $this->getFields() as $field )
    {
        if( $field->type!=customfield_separator && isset($this->{$field->columnIndex}) && $field->columnIndex!==$excludeAttr ) 
        {
            $params[$field->name] = $this->showListVal($field->columnIndex, "", TRUE, TRUE);
        }
    }
}

} // end class

function shrinkPicture(&$width, &$height, $boxWidth, $boxHeight, $pictureFile)
{
    $size = getimagesize( $pictureFile );
    $width = $size[0];
    $height = $size[1];
    if( ($boxWidth>0 && $width>$boxWidth) || ($boxHeight>0 && $height>$boxHeight) )
    {
        if( $boxWidth>0 )
        {
            $ratio = $width/$boxWidth;
            if( $boxHeight>0 && $height/$ratio>$boxHeight ) $ratio=$height/$boxHeight;
        }
        else
        {
            $ratio = $height/$boxHeight;
            if( $boxWidth>0 && $width/$ratio>$boxWidth ) $ratio=$width/$boxWidth;
        }
        $width = round($width/$ratio);
        $height = round($height/$ratio);
    }
}

?>
