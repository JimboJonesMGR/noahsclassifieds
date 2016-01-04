/*****************************************************************************
 Egy event handlerbe erkezo Event objektum alapjan meghatarozza, hogy melyik 
 DOM objektumra hivtak meg az eventet:
 event:   az event objektum,
 returns: a DOM objektum
*****************************************************************************/
function getEventTarget(event)
{
    var obj;
    if (!event) var event = window.event;
    if (event.target) obj = event.target;
    else if (event.srcElement) obj = event.srcElement;
    if (obj.nodeType == 3) // defeat Safari bug
        obj = obj.parentNode;
    return obj;
}

/*****************************************************************************
 Hozzaad egy event-et egy objektumhoz anelkul, hogy a mar esetleg definialt
 regebbi eventeket felulirna.
 obj:    az objektum,
 evType: event tipus 'on' nelkul - pl.: load, click, blur, ...
 fn:     az event fuggveny neve
*****************************************************************************/
function addEvent(obj, evType, fn)
{
    
    if (obj.addEventListener)
    {
        obj.addEventListener(evType, fn, true);
        return true;
    } 
    else if (obj.attachEvent)
    {
        var r = obj.attachEvent("on"+evType, fn);
        return r;
    }
    else return false;
}

/*****************************************************************************
 Alternalo stilusu listakat produkal egy oldalon. Minden masodik olyan <tr>
 stilusat kicsereli row2-re, ahol row1 volt az eredeti stilus.
*****************************************************************************/
function stripe()
{
    var trs=document.getElementsByTagName("tr");
    var j=0;
    for( var i=0; i<trs.length; i++ )
    {
        if( trs[i].className.indexOf('row1')>-1 )
        {
            if( j%2 ) trs[i].className=trs[i].className.replace(/row1/, 'row2');
            j++;
        }
    }        
}

/*****************************************************************************
 Egy 'ul'-ben levo 'li'-ket vizszintesen elrendezve egyenloen elossza a
 rendelkezesre allo helyen. Menusor megjelenitesere hasznalhato, ha a 
 menupontok szama dinamikus (php-bol generalt)
 
 A kovetkezo CSS kell hozza:
ul.distributeEven, .distributeEven li {
	display: inline;
	padding: 0px;
}	
.distributeEven li {
    text-align: center;
    float: left;
}

 Ha az ul nem kozvetlenul a 'body'-ban van, hanem mondjuk egy 'div'-ben, akkor
 ahhoz a 'div'-hez meg a kovetkezo 'clearfix' osztalyt hozza kell adni (hogy a
 'div' tenyleg "korulvegye" az 'ul'-t):
.clearfix:after {
    content: "."; 
    display: block; 
    height: 0; 
    clear: both; 
    visibility: hidden;
}
* html .clearfix {height: 1%;}
 
 A kovetkezo HTML kell hozza:
<ul class="distributeEven">
	<li>Item1</li>
	<li>Item2</li>
	<li>Item3</li>
	...
</ul>  
*****************************************************************************/
function distributeEvenLis()
{
    var uls = document.getElementsByTagName('ul');
    for( var i=0; i<uls.length; i++ )
    {
        if( !(/\bdistributeEven\b/.exec(uls[i].className)) )continue;
        var childLis = uls[i].getElementsByTagName('li');
        if( childLis.length==0 ) continue;
        var directChildLis = new Array();
        for( var j=0; j<childLis.length; j++ )
        {
            if( childLis[j].parentNode==uls[i] ) directChildLis[directChildLis.length]=childLis[j];
        }
        if( directChildLis.length==0 ) continue;
        var fullWidth = uls[i].parentNode.clientWidth;
        var borderWidth = directChildLis[0].offsetWidth-directChildLis[0].clientWidth;
        var oneBorder = borderWidth/2;
        var singleWidth = Math.round(fullWidth/directChildLis.length)-oneBorder;
        var w=0;
        for( var j=0; j<directChildLis.length-1; j++ )
        {
            directChildLis[j].style["width"] = singleWidth + 'px';
            directChildLis[j].style["marginRight"] = -1*oneBorder + 'px';
            w+=(singleWidth+oneBorder);
        }
        // kerekitesi hibak kezelese:
        directChildLis[directChildLis.length-1].style["width"] = (fullWidth-w-borderWidth) + 'px';
    }
}

/*****************************************************************************
 Egy 'div'-ben levo 'div'-eket vizszintesen elrendezve egyenloen elossza a
 rendelkezesre allo helyen. Menusor megjelenitesere hasznalhato, ha a 
 menupontok szama dinamikus (php-bol generalt)
 
 A kovetkezo CSS kell hozza:
.distributeEven{
    text-align: center;
    float: left;
}

 Ha a 'div' nem kozvetlenul a 'body'-ban van, hanem mondjuk egy 'div'-ben, akkor
 ahhoz a 'div'-hez meg a kovetkezo 'clearfix' osztalyt hozza kell adni (hogy a
 kulso 'div' tenyleg "korulvegye" a belso 'div'-et):
.clearfix:after {
    content: "."; 
    display: block; 
    height: 0; 
    clear: both; 
    visibility: hidden;
}
* html .clearfix {height: 1%;}

 A kovetkezo HTML kell hozza:
<div>
    <div class='distributeEven'>1</div>
    <div class='distributeEven'>2</div>
    <div class='distributeEven'>3</div>
    <div class='distributeEven'>4</div>
    <div class='distributeEven'>5</div>
</div> 
*****************************************************************************/
function distributeEvenDivs()
{
    var divs = document.getElementsByTagName('div');
    for( var i=0; i<divs.length; i++ )
    {
        var childDivs = divs[i].getElementsByTagName('div');
        if( childDivs.length==0 ) continue;
        if( !(/\bdistributeEven\b/.exec(childDivs.item(0).className)) )continue;
        var fullWidth = divs[i].clientWidth;
        var borderWidth = childDivs[0].offsetWidth-childDivs[0].clientWidth;
        var oneBorder = borderWidth/2;
        var singleWidth = Math.round((fullWidth)/childDivs.length)-oneBorder;
        var w=0;
        for( var j=0; j<childDivs.length; j++ )
        {
            childDivs[j].style["width"] = singleWidth + 'px';
            childDivs[j].style["marginRight"] = -1*oneBorder + 'px';
            w+=(singleWidth+oneBorder);
        }
        // kerekitesi hibak kezelese:
        childDivs[childDivs.length-1].style["width"] = (fullWidth-w-borderWidth) + 'px';
    }
}

/*****************************************************************************
 Adva van egy checkbox-csoport 0-tol indexelve - a 0-s indexu az
 'Any', vagy 'All'. Ha egy nullasnal nagyobb indexut becsekkelunk,
 akkor az Any-t ki kell csekkelni, de ha az Any-n kivul eppen az
 utolsot is becsekkeltuk, akkor az Any-t be kell csekkelni, az osszes
 tobbit viszont ki. Ha az Any-n kivul kicsekkeljuk az utolsot is,
 akkor az Any-t be kell csekkelni.
*****************************************************************************/
function checkBoxManager( event )
{
    var formElement = getEventTarget(event);

    nameSlices = formElement.name.split(/\[|\]/);
    formElementGroupName = nameSlices[0];
    isAnyField = formElement.getAttribute('src');
    index = nameSlices[1];
    if( isAnyField=='' ) isAnyField=(index==0);
    formObject = formElement.form;
    if( !isAnyField )
    {
        allChecked = true;
        hasChecked = false;
        for (var i = 1; i < 1000; i++) {
            formElementName = formElementGroupName + '[' + i + ']';
            if( typeof(formObject.elements[formElementName]) != 'undefined' )
            {
                if( formObject.elements[formElementName].checked==false )
                {
                    allChecked = false;
                }
                else hasChecked = true;
            }
            else break;  // terminate the loop when we go on to another form element.
        }
        if( !allChecked )
        {
            formElementName = formElementGroupName + '[0]';
            formObject.elements[formElementName].checked = false;
        }
    }
    if( isAnyField || allChecked || !hasChecked )
    {
        formElementName = formElementGroupName + '[0]';
        formObject.elements[formElementName].checked = true;

        for (var i = 1; i < 1000; i++) {
            formElementName = formElementGroupName + '[' + i + ']';
            if( typeof(formObject.elements[formElementName])!='undefined' )
            {
                formObject.elements[formElementName].checked = false;
            }
            else break;  // terminate the loop when we go on to another form element.
        }
    }
}

/*****************************************************************************
 Ugyanaz, mint az elozo fuggveny, csak multiple selection mezore
*****************************************************************************/
function multipleSelectionManager( event )
{
    var obj, select;
    obj = getEventTarget(event);
    
    // Firefoxnal a megklikkelt option-ra hivodik meg az event, IE-nel viszont
    // a selectionra:
    if( obj.nodeName=='OPTION' ) select = obj.parentNode;
    else select=obj;
    
    var deselectedExists=false;
    for (var i = 1; i < select.length; i++)
    {
        if (select.options[i].selected == true)
        {
            select.options[0].selected=false;
        }
        else deselectedExists=true;
    }
    if( !deselectedExists ) 
    {
        select.options[0].selected=true;
        for (var i = 1; i < select.length; i++)
        {
            select.options[i].selected=false;
        }
    }

}

/*****************************************************************************
 Adott egy multiple selection field, aminek az elso eleme az 'All'.
 Ha a lista barmely mas elemet kiszelektaljuk, akkor az All-t
 deszelektalni kell
*****************************************************************************/
function deselectAll( event )
{
   var obj = getEventTarget(event);

   for (var i = 1; i < obj.length; i++)
   {
      if (obj.options[i].selected == true)
      {
         obj.options[0].selected=false;
         break;
      }
   }
}

/*****************************************************************************
 Ha egy integer form field 'keypress' eventjere radefinialjuk ezt a fg-t,
 akko csak szamokat lehet beirni a mezobe.
*****************************************************************************/
function numbersOnly(event)
{
    var key,keychar;
    if (window.event)
        key = window.event.keyCode;
    else if (event)
        key = event.which;
    else
        return true;
    
    keychar = String.fromCharCode(key);
    // check for special characters like backspace
    // then check for the numbers 
    
    if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) 
    {
        ret=true;
    }    
    else if ((('0123456789').indexOf(keychar) > -1))
    {
        window.status = '';  
        ret = true;
    }
    else
    {
        window.status = 'Field excepts numbers only'; 
        if( event.preventDefault ) event.preventDefault();
        ret = false;
    }
    return ret;
}

function floatOnly(event)
{
    var key,keychar;
    if (window.event)
        key = window.event.keyCode;
    else if (event)
        key = event.which;
    else
        return true;
    
    keychar = String.fromCharCode(key);
    // check for special characters like backspace
    // then check for the numbers 
    
    if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) 
    {
        ret=true;
    }    
    else if ((('0123456789.').indexOf(keychar) > -1))
    {
        window.status = '';  
        ret = true;
    }
    else
    {
        window.status = 'Field excepts numbers only'; 
        if( event.preventDefault ) event.preventDefault();
        ret = false;
    }
    return ret;
}

/*****************************************************************************
 Megakadalyozza a default event bekovetkezeset. (Ugyanaz, mint egy 'return false'
 az egyszeru event-modell eseten)                                                
*****************************************************************************/
function stopEvent(e) {
    if(!e) var e = window.event;
    
    //e.cancelBubble is supported by IE - this will kill the bubbling process.
    e.cancelBubble = true;
    e.returnValue = false;

    //e.stopPropagation works only in Firefox.
    if (e.stopPropagation) {
        e.stopPropagation();
        e.preventDefault();
    }
    return false;
}

function URLEncode( plaintext)
{
	// The Javascript escape and unescape functions do not correspond
	// with what browsers actually do...
	var SAFECHARS = "0123456789" +					// Numeric
					"ABCDEFGHIJKLMNOPQRSTUVWXYZ" +	// Alphabetic
					"abcdefghijklmnopqrstuvwxyz" +
					"-_.!~*'()";					// RFC2396 Mark characters
	var HEX = "0123456789ABCDEF";

	var encoded = "";
	for (var i = 0; i < plaintext.length; i++ ) {
		var ch = plaintext.charAt(i);
	    if (ch == " ") {
		    encoded += "+";				// x-www-urlencoded, rather than %20
		} else if (SAFECHARS.indexOf(ch) != -1) {
		    encoded += ch;
		} else {
		    var charCode = ch.charCodeAt(0);
			if (charCode > 255) {
			    alert( "Unicode Character '" 
                        + ch 
                        + "' cannot be encoded using standard URL encoding.\n" +
				          "(URL encoding only supports 8-bit characters.)\n" +
						  "A space (+) will be substituted." );
				encoded += "+";
			} else {
				encoded += "%";
				encoded += HEX.charAt((charCode >> 4) & 0xF);
				encoded += HEX.charAt(charCode & 0xF);
			}
		}
	} // for

	return encoded;
};
