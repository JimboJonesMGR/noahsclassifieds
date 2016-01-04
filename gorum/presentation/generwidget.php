<?php
defined('_NOAH') or die('Restricted access');

class GenerWidget
{

function generHiddenField($name="",$value="", $postfix="")
{
    if( $name )
    {
        $value=htmlspecialchars($value);
        //todo: ide is " kellene a value-hoz, mint a text-ben
        $id = $postfix ? "{$name}_$postfix" : $name;
        return "<input type='hidden' id='$id' name='$name' value='$value'>\n";
    }
}

function generTextField($type,$name,$value="",$size="", $maxlength="", $extra="")
// a password es a button mezot is ezzel csinaljuk
{
    $value=htmlspecialchars($value);
    $s="<input type='$type' id='$name' name='$name'";
    if ($value!="") $s.=" value=\"$value\"";
    if ($size!="") $s.=" size='$size'";
    if ($maxlength!="") $s.=" maxlength='$maxlength'";
    if( $type=="submit" ) $s.="class='button'";
    if ($extra!="") $s.=" $extra";
    $s.=">\n";
    return $s;
}


function loadckEditor($name)
{
    JavaScript::addInclude(NOAH_BASE . "/ckeditor/ckeditor.js");
    JavaScript::addOnload("CKEDITOR.replace('$name');");
}

function loadTinyMCE($markitupsimple)
{
  hasAdminRights($isAdm);
  $editortheme = "advanced";
  $advancedsettings = ", editor_selector : \"noahmce\",
			plugins : \"safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template\",

			theme_advanced_buttons1 : \"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect\",
			theme_advanced_buttons2 : \"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor\",
			theme_advanced_buttons3 : \"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,fullscreen\",
			theme_advanced_toolbar_location : \"top\",
			theme_advanced_toolbar_align : \"left\",
			theme_advanced_statusbar_location : \"bottom\",
			theme_advanced_resizing : true,
			
			template_external_list_url : \"lists/template_list.js\",
			external_link_list_url : \"lists/link_list.js\",
			external_image_list_url : \"lists/image_list.js\",
			media_external_list_url : \"lists/media_list.js\"
  ";
  
  if (!$isAdm)
  {
    if ($markitupsimple){
      $editortheme = "simple";
      $advancedsettings = "";
    }   
    $invalid_elements = "invalid_elements: \"applet,body,bgsound,base,basefont,embed,frame,frameset,head,html,id,iframe,ilayer,layer,link,meta,name,object,script,style,title,xml\","; 
  } //else  $invalid_elements = "valid_elements: \"*[*]\",";   
 	JavaScript::addInclude(NOAH_BASE . "/tinymce/jscripts/tiny_mce/tiny_mce_gzip.js"); //jquery.tinymce.js");

   $script="tinyMCE_GZ.init({
	       plugins : 'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	       themes : '".$editortheme."',
	       languages : 'en',
	       disk_cache : true,
	       debug : false
      });";
  
  JavaScript::addScript($script,2);

	$script="tinyMCE.init({
      mode: \"textareas\",
      theme : \"$editortheme\",".$invalid_elements."
      convert_urls : false
      $advancedsettings
     });";

    JavaScript::addScript($script,1);
    
    return " class='noahmce'";

}
function generTextAreaField($name,$value="",$rows="",$cols="",$readonly=FALSE, $markitup=FALSE, $markitupsimple=FALSE)
{
    global $jQueryLib;

    $value=z_specchars($value);
    $s="<textarea id='$name' name='$name'";
    if ($markitup)
    {
        //$rows = 10;
        $cols = "99%";
        $s.=GenerWidget::loadTinyMCE($markitupsimple);
    }

    
    if ($rows!="") 
    {
        if( is_numeric($rows) ) $s.=" rows='$rows'";
        else $s.=" style='height: $rows'";  // ha '%' vagy 'px' van benne
    }
    if ($cols!="") 
    {
        if( is_numeric($cols) ) $s.=" cols='$cols'";
        else $s.=" style='width: $cols'";  // ha '%' vagy 'px' van benne
    }
    if( $readonly ) $s.=" readonly";
    $s.=">\n";
    if ($value!="") $s.=$value;
    $s.="</textarea>";
    return $s;
}

function generSelectField($name,&$labels,&$values,$id="",$selected=0,$size=0,$width=0,
                          $showRelation="", $extra="")
{
    $s="\n<select name='$name'";
    if ($id) $s.=" id='$id'";
    if ($size>0) $s.=" size='$size'";
    if ($width>0) $s.=" width='$width' style='width:{$width}px;'";
    if ($extra!="") $s.=" $extra";
    $s.=">\n";
    $s.=GenerWidget::generSelectOptions($labels,$values,$selected, $showRelation);
    $s.="</select>\n";
    return $s;
}

function generSelectOptions(&$labels,&$values,$selected=0, $showRelation="", $rels=0)
{
    $s="";
    if( is_array($selected) && count($selected) ) $selected = $selected[0];
    if( !in_array($selected, $values) && isset($values[0])) $selected=$values[0];
    foreach($labels as $key=>$label ){
        $s.="<option value='".$values[$key]."'";
        if( $showRelation )
        {
            //if( isset($showRelation[$key]) ) $s.=" show='$showRelation[$key]_rel'";
            if( is_array($showRelation ) && isset($showRelation[$values[$key]]) ) $s.=" show='".$showRelation[$values[$key]]."_rel'";
            elseif( !is_array($showRelation ) && $values[$key]!=0 ) $s.=" show='".$showRelation."_rel'";
            else $s.=" show='none'";
        }
        if ($selected==$values[$key])
        {
            $s.=" selected";
        }
        if( $rels && isset($rels[$key]) )
        {
            $s.=" rel='$rels[$key]'";
        }
        $s.=">".$label."</option>\n";
    }
    return $s;
}

function generRadioField($name,&$labels,&$values,$selected=0,$cols=1,$showRelation="")
{
    $s="\n<table border='0' colspan='0' rowspan='0'>\n";
    $length = count($values);
    global $noRadioPreset;
    if (!isset($noRadioPreset) && $selected!=-1) {
        if( !in_array($selected, $values) ) $selected=$values[0];
    }
    for( $i=0; $i<$length/$cols; $i++ )
    {
        $s.="<tr>";
        for( $j=$i*$cols; $j<($i+1)*$cols; $j++ )
        {
            if( !isset($values[$j]) ) break(2);
            $v = $values[$j];
            $s.="<td class='celltext'>";
            $s.="<input type='radio' name='$name' value='$v' id='$name"."_$v'";
            if( $showRelation )
            {
                if( isset($showRelation[$v]) ) $s.=" show='$showRelation[$v]_rel'";
                else $s.=" show='none'";
            }
            if( $selected==$v ) 
            {
                $s.=" checked";
            }    
            $s.=">".$labels[$j];
            $s.="</td>\n";
        }
        $s.="</tr>\n";
    }
    $s.="</table>\n";
    return $s;
}

function generBoolField($name, $id="", $checked=FALSE, $value=1, $showRelation="", $extra="")
{
    $s="<input type='checkbox' value='$value'";
    if( $id ) $s.=" id='$id'";
    if( $name ) $s.=" name='$name'";
    if( $showRelation ) $s.=" show='$showRelation"."_rel'";
    if( $checked ) $s.=" checked";
    $s.=">";
    return $s;
}

function generUrlField($name,$value="",$size="",$maxlength="")
{
    global $lll;
    if( $value && is_array($value) )
    {
        $value0 = $value[0];
        $value1 = $value[1];
    }
    elseif( $value )
    {
        $values=split("' target='_blank'>", $value);
        $value0 = htmlspecialchars(substr($values[0], 9));
        $value1 = htmlspecialchars(substr($values[1], 0, -4));
    }
    else $value0 = $value1 = "";
    $s="$lll[linkText]: <input type='text' name='$name"."[1]'";
    if ($value1!="") $s.=" value=\"$value1\"";
    if ($size!="") $s.=" size='$size'";
    if ($maxlength!="") $s.=" maxlength='$maxlength'";
    $s.=">";
    $s.="&nbsp;&nbsp;&nbsp;&nbsp;$lll[URL]: <input type='text' name='$name"."[0]'";
    if ($value0!="") $s.=" value=\"$value0\"";
    if ($size!="") $s.=" size='$size'";
    if ($maxlength!="") $s.=" maxlength='$maxlength'";
    $s.=">\n";
    return $s;
}

function generButtonField($name="",$value="",$class="", $relation="")
{
    $s="<input type='button'";
    if ($value!="") $s.=" value='$value'";
    if ($name!="") $s.=" name='$name'";
    if ($name!="") $s.=" id='$name'";
    $s.=">\n";
    return $s;
}

function generButton($content, $name="",$value="",$type="submit", $onclick="")
{
    $s="<button";
    if ($value!="") $s.=" value='$value'";
    if ($name!="") $s.=" name='$name'";
    if ($type!="") $s.=" type='$type'";
    $s.=">$content</button>\n";
    return $s;
}

function generFileField($name,$size="",$maxlength="", $max_file_size=0)
{
    $s="";
    if( $max_file_size )
    {
        $s.= "<input type='hidden' name='MAX_FILE_SIZE' value='$max_file_size'>\n";
    }
    $s.="<input type='file' name='$name'";
    if ($size!="") $s.=" size='$size'";
    if ($maxlength!="") $s.=" maxlength='$maxlength'";
    $s.=">\n";
    return $s;
}

function generMultipleSelection($name,&$listNames,&$listValues, $selected, $listSize, $width=0,
                                $showRelation="",$anyfield="", $asmSelect=0, $asmSelectLabel="")
{    
    
    global $lll, $jQueryLib;
    
    $selected=splitByCommas($selected);
    if( $asmSelect )
    {
        JavaScript::addInclude(GORUM_JS_DIR . $jQueryLib);
        if( preg_match("/sortable:\s*true/", $asmSelect) )
        {
            JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.dimensions.js");
            JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.ui.js");
        }
        JavaScript::addInclude(GORUM_JS_DIR . "/jquery/jquery.asmselect.js");
        JavaScript::addCss(GORUM_JS_DIR . "/jquery/jquery.asmselect.css");
        $asmSelect = preg_replace_callback( 
            "/(removeLabel|modifyLabel|addButtonLabel|modifyButtonLabel): '([^']+)'/m", 
            create_function('$matches', 'global $lll; return $matches[1].": \'".$lll[$matches[2]]."\'";'),
            $asmSelect
        );
        JavaScript::addOnload("$('#$name').asmSelect($asmSelect);");
        // hogy egy modify formban a kivalasztottak listajanak sorrendje ugyanaz legyen, 
        // mint amit mar egyszer elmentettunk:
        if( count($selected)>1 )
        {
            $tempSelected = $selected;
            for( $i=0, $helpArr=array(); $i<count($listValues); $i++ ) $helpArr[$listValues[$i]] = $listNames[$i];
            for( $i=0; $i<count($listValues); $i++ )
            {
                if( in_array($listValues[$i], $selected) ) 
                {
                    $listValues[$i] = array_shift($tempSelected);
                    $listNames[$i] = $helpArr[$listValues[$i]];
                }
            }
        }
    }
    $s="\n<select id='$name' name='$name"."[]' size='$listSize' ";
    if ($width>0) $s.="width='$width' style='width:{$width}px;' ";
    if( $asmSelectLabel ) $s.="title='".addcslashes($lll[$asmSelectLabel], "'")."' ";
    $s.="multiple>\n";
    $length = count($listValues);
    if( $length )
    {
        foreach( $listValues as $key=>$value )
        {
            $s.="<option value=\"".$value."\"";
            if( $showRelation )
            {
                if( isset($showRelation[$value]) ) $s.=" show='$showRelation[$value]_rel'";
                else $s.=" show='none'";
            }
            if( in_array($value, $selected) ) $s.=" selected";
            if( $anyfield==$value ) 
            {
                $s.=" src='any'";
            }    
            $s.=">".$listNames[$key]."</option>\n";
        }
    }
    else $s.="<option value='0'>".$lll["emptyList"]."</option>\n";    
    $s.="</select>\n";
    return $s;
}

function generCheckbox($name,&$listNames,&$listValues, $selected, $cols, 
                       $vert=FALSE,$showRelation="",$multimask=0, $afterField="",$anyfield="")
{
    global $hackTdClass;
    
    $selected=splitByCommas($selected);
    $s="\n<table border='0' colspan='0' rowspan='0'>\n";
    $length = count($listValues);
    
    if (isset($hackTdClass) && $hackTdClass) {
        $hTdClass=" class='$hackTdClass'";
    }
    else $hTdClass=" class='celltext'";
    if ($vert) {//vertical
        $rows=ceil($length/$cols);
        $ind1=0;
        $ind2=0;
        $aind=0;
        $aindH=0;
        for( $i=0; $i<$rows; $i++ ) {
            $s.="<tr>";
            for($j=0;$j<$cols;$j++) {
                if( !isset($listValues[$ind2]) ) break;
                $v = $listValues[$ind2];
                $s.="<td$hTdClass>";
                $s.="<input type='checkbox' id='$name"."_$ind2' name='$name"."[$ind2]' value='$v'";
                if( $showRelation )
                {
                    if( isset($showRelation[$v]) ) $s.=" show='$showRelation[$v]_rel'";
                    else $s.=" show='none'";
                }
                if( in_array($v, $selected) ) $s.=" checked";
                if( $anyfield==$v ) 
                {
                    $s.=" src='any'";
                }    
                $s.=">".$listNames[$ind2];
                
                $s.="</td>\n";
                $ind2+=$rows;
            }
            $s.="</tr>\n";
            $ind1++;
            $ind2=$ind1;
        }
    }
    else {//horizontal
        for( $i=0; $i<$length/$cols; $i++ )
        {
            $s.="<tr>";
            for( $j=$i*$cols; $j<($i+1)*$cols; $j++ )
            {
                if( !isset($listValues[$j]) ) break(2);
                $v = $listValues[$j];
                $s.="<td$hTdClass>";
                $s.="<input type='checkbox' id='$name"."_$j' name='$name"."[$j]' value='$v'";
                if( $showRelation )
                {
                    if( isset($showRelation[$v]) ) $s.=" show='$showRelation[$v]_rel'";
                    else $s.=" show='none'";
                }
                if( in_array($v, $selected) ) $s.=" checked";
                if( $anyfield==$v ) 
                {
                    $s.=" src='any'";
                }    
                $s.=">".$listNames[$j];
                $s.="</td>\n";            
            }
            $s.="</tr>\n";
        }
    }
    if ($afterField) {
        $s.="<tr>";
        $s.="<td colspan='$cols'>$afterField</td>";
        $s.="</tr>";
    }
    $s.="</table>\n";
    return $s;
}

function generSelectFilterField($name, &$labels, $width)
{
    if( !$width )
    {
        $width = 0;
        foreach( $labels as $label ) $width = max($width, strlen($label));
    }
    $s="Filter:<br>";
    $s.= GenerWidget::generTextField("text","{$name}_selectfilter","",$width);
    $s.="<br>";
    JavaScript::addOnload("
    function filterSelectField(e)
    {
        e=e||window.event;
        var k=e.charCode||e.keyCode||e.which;						                        
        if(e.ctrlKey || e.altKey) return true;  // ignore
        else if ((k>=41 && k<=122) ||k==32 || k>186 || k==8)  //typeable characters
        {
            var name = this.name.slice(0, -13);  // levagjuk '_selectfilter'-t
            var filter=this.value.toLowerCase();
            // betesszuk egy tombbe az osszes option-t
            if( eval('typeof('+name+'OptionsRepository)!=\"object\"') )
            {
                eval(name+'OptionsRepository = new Array;');
                \$JQ('#' + name).find('option').each(function(){
                    eval(name+'OptionsRepository').push([\$JQ(this).val(), \$JQ(this).html()]);
                });
            }
            \$JQ('#' + name).find('option').remove();  // kiuritjuk a szelekt mezot teljesen
            var x=0;
            \$JQ.each(eval(name+'OptionsRepository'), function(i, val)
            {
                // es csak azokat tesszuk vissza, amiben a filter megtalalhato:
                if( val[1].toLowerCase().indexOf(filter)>-1 )
                {
                    \$JQ('#' + name).get(0).options[x++]=new Option(val[1], val[0]);
                }
            });
        }
    }
    \$JQ('input[id$=_selectfilter]').keyup(filterSelectField);
    ", "filterSelectField");
    return $s;
}

function generAnchor( $link, $label, $cssClass="", $target="", $encode=TRUE, $rel="" )
{
    $s="<a href='$link'";
    if( $cssClass ) $s.=" class='$cssClass'";
    if( $target ) $s.=" target='$target'";
    if( $encode ) $label = htmlspecialchars($label);
    if( $rel ) $s.=" rel='$rel'";
    $s.=">$label</a>";
    return $s;
}

function generImageAnchor( $link, $src, $alt, $width="", $height="", $cssClass="", $target="", $rel="" )
{
    $alt = htmlspecialchars($alt);
    $img = "<img src='$src' alt='$alt' border='0' title='$alt'";
    if ($width!="") $img.=" width='$width'";
    if ($height!="") $img.=" height='$height'";
    $img.=">";
    return GenerWidget::generAnchor($link, $img, $cssClass, $target, FALSE, $rel);
}

function initCaptchaField()
{
    global $lll;
    
    $_S = new AppSettings();

    switch ($_S->captchaType) {
       case 1:
        $captcha =  GenerWidget::generatereCaptcha();
        break;
      default:
        $captcha =  GenerWidget::generateNoahCaptcha();
        break;
    } 
    
    $lll["captchaField_embedfield"]=$captcha;

}

function generatereCaptcha()
{

    ob_start();
    require(GORUM_DIR.'/recaptcha/rcaptcha.php');
    $rcaptcha = "
        <script type='text/javascript'> 
         var RecaptchaOptions = { theme : 'clean', lang  : 'en' };
        </script>".ob_get_contents();
   ob_end_clean();
   
   return $rcaptcha;
}

function generateNoahCaptcha()
{
  $ncaptcha = "
        <table><tr><td width='1' style='padding-right: 20px;'>
            <img src='".Controller::getBaseURL()."gorum/captcha/captcha.php' alt='CAPTCHA'></td><td>%s</td></tr>
        </table>";
        
  return $ncaptcha;
}

function generConfirmation( $title, $content='', $submits=0 )
{
    global $lll;
    
    $tpl = new Savant2();
    $tpl->addPath('template', TEMPLATE_DIR);
    $tpl->addPath('template', COMMON_TEMPLATES);
    $tpl->assign("title", $title);
    $tpl->assign("content", $content);
    if( !$submits ) $submits = array("ok", "cancel"); 
    $submitArr = array();
    foreach( $submits as $button )
    {
        $submitArr[]="<input type='submit' value='$lll[$button]' name='gsubmit' class='button confirmation_$button'>\n";
    }
    $tpl->assign("submits", $submitArr);
    return $tpl->fetch("confirmation.tpl.php");
}

} // end class
?>
